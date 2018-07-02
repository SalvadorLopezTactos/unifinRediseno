<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
require_once('include/MVC/Controller/ControllerFactory.php');
require_once('include/MVC/View/ViewFactory.php');

/**
 * SugarCRM application
 *
 * @api
 */
class SugarApplication
{
    var $controller = null;
    var $headerDisplayed = false;
    var $default_module = 'Home';
    var $default_action = 'sidecar';

    function SugarApplication()
    {
    }

    /**
     * Perform execution of the application. This method is called from index2.php
     */
    function execute()
    {
        global $sugar_config;
        if (!empty($sugar_config['default_module'])) {
            $this->default_module = $sugar_config['default_module'];
        }
        $module = $this->default_module;
        if (!empty($_REQUEST['module'])) {
            $module = $_REQUEST['module'];
        }
        insert_charset_header();
        $this->setupPrint();

        $this->controller = ControllerFactory::getController($module);

        // make sidecar view load faster
        // TODO the rest of the code will be removed as soon as we migrate all modules to sidecar
        if ($this->controller->action === 'sidecar' ||
            (
                $this->controller->action === 'index' && $this->controller->module === 'Home' &&
                (empty($_REQUEST['entryPoint']) || (isset($_REQUEST['action']) && $_REQUEST['action'] === 'DynamicAction'))
            ) ||
            empty($_REQUEST)
        ) {
            // check for not authorised users
            $this->checkMobileRedirect();
            $this->controller->action = 'sidecar';
            $this->controller->execute();
            return;
        } elseif ($this->controller->action === 'Login' && $this->controller->module === 'Users') {
            // TODO remove this when we are "iFrame free"

            // by default login location is base site URL
            $location = rtrim($sugar_config['site_url'], '/') . '/';
            $loginRedirect = $this->getLoginRedirect();

            $loginVars = $this->getLoginVars();

            if (isset($loginVars['module'])) {
                if (isModuleBWC($loginVars['module'])) {
                    // in case if login module is BWC, location is the BWC URL (as if the user was already
                    // logged in), since authentication is managed by Sidecar, not the module itself
                    $location .= '#bwc/' . $loginRedirect;
                } else {
                    // otherwise compose basic Sidecar route
                    $location .= '#' . rawurlencode($loginVars['module']);
                    if (isset($loginVars['record'])) {
                        $location .= '/' . rawurlencode($loginVars['record']);
                    }
                }
            }

            echo '<script>
            if (parent.location == window.location) {
                window.location = ' . json_encode($location) . ';
            } else {
                window.top.SUGAR.App.bwc.login(' . json_encode($loginRedirect) . ');
            }
            </script>';
            return;
        }
        // If the entry point is defined to not need auth, then don't authenticate.
        if (empty($_REQUEST['entryPoint'])
            || $this->controller->checkEntryPointRequiresAuth($_REQUEST['entryPoint'])
        ) {
            $this->startSession();
             // check for authorised users
            $this->checkMobileRedirect();
            $this->loadUser();
            $this->ACLFilter();
            $this->preProcess();
            $this->controller->preProcess();
            $this->checkHTTPReferer();
        }

        SugarThemeRegistry::buildRegistry();
        $this->loadLanguages();
          $this->checkDatabaseVersion();
        $this->loadDisplaySettings();
        $this->loadLicense();
        $this->loadGlobals();
        $this->setupResourceManagement($module);
        $this->controller->execute();
        sugar_cleanup();
    }

    public function checkMobileRedirect () {
        // do nothing if mobile version is not enabled in config
        if (!$this->isMobileRedirectEnabled()) {
            return false;
        }

        // If we're authenticating, do not redirect
        if (!empty($_REQUEST['module']) && !empty($_REQUEST['action'])
            && 'Users' == $_REQUEST['module'] && 'authenticate' == strtolower($_REQUEST['action'])) {
            return false;
        }

        if (isset($_REQUEST['mobile']) || isset($_COOKIE['sugar_mobile'])) {
            if ((isset($_REQUEST['mobile']) && $_REQUEST['mobile'] == '0') || (isset($_COOKIE['sugar_mobile']) && $_COOKIE['sugar_mobile'] == '0')) {
                if (!isset($_COOKIE['sugar_mobile']) || $_COOKIE['sugar_mobile'] != '0') {
                    setcookie('sugar_mobile', '0'); // expires on browser closed
                }
                if (isset($_SESSION['isMobile'])) unset($_SESSION['isMobile']);
            }
            else {
                // redirect to mobile version
                $this->redirectToMobileApp();
            }
        }
        elseif ($this->checkForNomadSupport()) {
            $this->redirectToMobileApp();
        }
    }

    public function redirectToMobileApp(){
        $mobileUrl = $this->getMobileUrl();
        echo <<<EOF
<script type="text/javascript">
    window.location = '$mobileUrl' + location.hash;
</script>
EOF;

    }

    public function getMobileUrl(){
        return 'mobile/';
    }

    /**
     * Defines whether mobile application is installed and available
     *
     * @return bool
     */
    public function isMobileRedirectEnabled()
    {
        global $sugar_config;
        return !empty($sugar_config['enable_mobile_redirect']);
    }

    /**
     * Checks whether device is in list of compatible devices of Nomad (mobile js app)
     *
     * @return bool
     */
    public function checkForNomadSupport(){

        if (empty($_SERVER['HTTP_USER_AGENT'])) return false;

        $ua = strtolower($_SERVER['HTTP_USER_AGENT']);


        $isIosDevice = preg_match("/(iphone|ipod)/i", $ua);
        if ($isIosDevice) {
            // detect iOS version
            preg_match("/OS (\d+)_\d+(_\d+)?\s+/i", $ua, $osVersionMatches);
            return $osVersionMatches ? $osVersionMatches[1] >= 5 : false;  // check iOS version >= 5
        }

        // check for Chrome in Android
        $isAndroid = preg_match('/Android/i', $ua);
        if ($isAndroid) {
            // detect chrome mobile     https://developers.google.com/chrome/mobile/docs/user-agent
            // we don't check for screen resolution because chrome for tablets has another UA signature
            // so it's ehough to detect Chrome Mobile for phones
            $isChromeForMobilePhones = preg_match('/Chrome\/([.0-9])* Mobile/i', $ua); // only for mobile devices, not tablets
            return $isChromeForMobilePhones;
        }

        return false;
    }

    /**
     * Load the authenticated user. If there is not an authenticated user then redirect to login screen.
     */
    function loadUser()
    {
        global $authController, $sugar_config;
        // Double check the server's unique key is in the session.  Make sure this is not an attempt to hijack a session
        $user_unique_key = (isset($_SESSION['unique_key'])) ? $_SESSION['unique_key'] : '';
        $server_unique_key = (isset($sugar_config['unique_key'])) ? $sugar_config['unique_key'] : '';
        if(!empty($this->controller->allowed_actions)) {
            $allowed_actions =  $this->controller->allowed_actions;
        } else {
            $allowed_actions = array('Authenticate', 'Login', 'LoggedOut');
        }

        if (($user_unique_key != $server_unique_key) && (!in_array($this->controller->action, $allowed_actions))
            && (!isset($_SESSION['login_error']))
        ) {
            session_destroy();

            if (!empty($this->controller->action)) {
                if (strtolower($this->controller->action) == 'delete') {
                    $this->controller->action = 'DetailView';
                } elseif (strtolower($this->controller->action) == 'save') {
                    $this->controller->action = 'EditView';
                } elseif (strtolower($this->controller->action) == 'quickcreate') {
                    $this->controller->action = 'index';
                    $this->controller->module = 'home';
                } elseif (isset($_REQUEST['massupdate']) || isset($_GET['massupdate']) || isset($_POST['massupdate'])) {
                    $this->controller->action = 'index';
                } elseif (!in_array($this->controller->action, $this->whiteListActions) && $this->isModifyAction()) {
                    $this->controller->action = 'index';
                }
            }

            header('Location: ' . $this->getUnauthenticatedHomeUrl(true));
            exit ();
        }

		$authController = AuthenticationController::getInstance();
		$GLOBALS['current_user'] = BeanFactory::getBean('Users');
		if(isset($_SESSION['authenticated_user_id'])){
			// set in modules/Users/Authenticate.php
			if(!$authController->sessionAuthenticate()){
				 // if the object we get back is null for some reason, this will break - like user prefs are corrupted
				$GLOBALS['log']->fatal('User retrieval for ID: ('.$_SESSION['authenticated_user_id'].') does not exist in database or retrieval failed catastrophically.  Calling session_destroy() and sending user to Login page.');
				session_destroy();
				SugarApplication::redirect($this->getUnauthenticatedHomeUrl());
				die();
            } else {
                $trackerManager = TrackerManager::getInstance();
                $monitor = $trackerManager->getMonitor('tracker_sessions');
                $active = $monitor->getValue('active');
                if ($active == 0
                    && (!isset($GLOBALS['current_user']->portal_only) || $GLOBALS['current_user']->portal_only != 1)
                ) {
                    // We are starting a new session
                    $result = $GLOBALS['db']->query(
                        "SELECT id FROM " . $monitor->name . " WHERE user_id = '" . $GLOBALS['db']->quote(
                            $GLOBALS['current_user']->id
                        ) . "' AND active = 1 AND session_id <> '" . $GLOBALS['db']->quote(
                            $monitor->getValue('session_id')
                        ) . "' ORDER BY date_end DESC"
                    );
                    $activeCount = 0;
                    while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                        $activeCount++;
                        if ($activeCount > 1) {
                            $GLOBALS['db']->query(
                                "UPDATE " . $monitor->name . " SET active = 0 WHERE id = '" . $GLOBALS['db']->quote(
                                    $row['id']
                                ) . "'"
                            );
                        }
                    }
                }
            }
        }
        $GLOBALS['log']->debug('Current user is: ' . $GLOBALS['current_user']->user_name);
        $GLOBALS['logic_hook']->call_custom_logic('', 'after_load_user');
        // Reset ACLs in case after_load_user hook changed ACL setups
        SugarACL::resetACLs();

		//set cookies
		if(isset($_SESSION['authenticated_user_id'])){
			$GLOBALS['log']->debug("setting cookie ck_login_id_20 to ".$_SESSION['authenticated_user_id']);
			self::setCookie('ck_login_id_20', $_SESSION['authenticated_user_id'], time() + 86400 * 90, '/', null, null, true);
		}
		if(isset($_SESSION['authenticated_user_theme'])){
			$GLOBALS['log']->debug("setting cookie ck_login_theme_20 to ".$_SESSION['authenticated_user_theme']);
			self::setCookie('ck_login_theme_20', $_SESSION['authenticated_user_theme'], time() + 86400 * 90);
		}
		if(isset($_SESSION['authenticated_user_theme_color'])){
			$GLOBALS['log']->debug("setting cookie ck_login_theme_color_20 to ".$_SESSION['authenticated_user_theme_color']);
			self::setCookie('ck_login_theme_color_20', $_SESSION['authenticated_user_theme_color'], time() + 86400 * 90);
		}
		if(isset($_SESSION['authenticated_user_theme_font'])){
			$GLOBALS['log']->debug("setting cookie ck_login_theme_font_20 to ".$_SESSION['authenticated_user_theme_font']);
			self::setCookie('ck_login_theme_font_20', $_SESSION['authenticated_user_theme_font'], time() + 86400 * 90);
		}
		if(isset($_SESSION['authenticated_user_language'])){
			$GLOBALS['log']->debug("setting cookie ck_login_language_20 to ".$_SESSION['authenticated_user_language']);
			self::setCookie('ck_login_language_20', $_SESSION['authenticated_user_language'], time() + 86400 * 90);
		}
		//check if user can access

    }

    public function ACLFilter()
    {
        $GLOBALS['moduleList'] = SugarACL::filterModuleList($GLOBALS['moduleList'], 'access', true);
    }

    /**
     * setupResourceManagement
     * This function initialize the ResourceManager and calls the setup method
     * on the ResourceManager instance.
     *
     */
    function setupResourceManagement($module)
    {
        require_once('include/resource/ResourceManager.php');
        $resourceManager = ResourceManager::getInstance();
        $resourceManager->setup($module);
    }

    function setupPrint()
    {
        $GLOBALS['request_string'] = '';

        // merge _GET and _POST, but keep the results local
        // this handles the issues where values come in one way or the other
        // without affecting the main super globals
        $merged = array_merge($_GET, $_POST);
        foreach ($merged as $key => $val) {
            if (is_array($val)) {
                foreach ($val as $k => $v) {
                    //If an array, then skip the urlencoding. This should be handled with stringify instead.
                    if (is_array($v)) {
                        continue;
                    }

                    $GLOBALS['request_string'] .= urlencode($key) . '[' . $k . ']=' . urlencode($v) . '&';
                }
            } else {
                $GLOBALS['request_string'] .= urlencode($key) . '=' . urlencode($val) . '&';
            }
        }
        $GLOBALS['request_string'] .= 'print=true';
    }

	function preProcess(){
	    $config = Administration::getSettings();
		if(!empty($_SESSION['authenticated_user_id'])){
			if(isset($_SESSION['hasExpiredPassword']) && $_SESSION['hasExpiredPassword'] == '1'){
				if( $this->controller->action!= 'Save' && $this->controller->action != 'Logout') {
	                $this->controller->module = 'Users';
	                $this->controller->action = 'ChangePassword';
	                $record = $GLOBALS['current_user']->id;
	             }else{
					$this->handleOfflineClient();
				 }
            } elseif ($this->controller->action != 'AdminWizard'
                    && $this->controller->action != 'EmailUIAjax'
                    && $this->controller->action != 'Wizard'
                    && $this->controller->action != 'SaveAdminWizard'
                    && $this->controller->action != 'SaveUserWizard'
            ){
                $this->handleOfflineClient();
            }
		}
		$this->handleAccessControl();
	}

    function handleOfflineClient()
    {
        if (isset($GLOBALS['sugar_config']['disc_client']) && $GLOBALS['sugar_config']['disc_client']) {
            if (isset($_REQUEST['action']) && $_REQUEST['action'] != 'SaveTimezone') {
                if (!file_exists('modules/Sync/file_config.php')) {
                    if ($_REQUEST['action'] != 'InitialSync' && $_REQUEST['action'] != 'Logout'
                        && ($_REQUEST['action'] != 'Popup' && $_REQUEST['module'] != 'Sync')
                    ) {
                        //echo $_REQUEST['action'];
                        //die();
                        $this->controller->module = 'Sync';
                        $this->controller->action = 'InitialSync';
                    }
                } else {
                    require_once ('modules/Sync/file_config.php');
                    if (isset($file_sync_info['is_first_sync']) && $file_sync_info['is_first_sync']) {
                        if ($_REQUEST['action'] != 'InitialSync' && $_REQUEST['action'] != 'Logout'
                            && ($_REQUEST['action'] != 'Popup' && $_REQUEST['module'] != 'Sync')
                        ) {
                            $this->controller->module = 'Sync';
                            $this->controller->action = 'InitialSync';
                        }
                    }
                }
            }
            global $moduleList, $sugar_config, $sync_modules;
            require_once('modules/Sync/SyncController.php');
            $GLOBALS['current_user']->is_admin = '0'; //No admins for disc client
        }
    }

    /**
     * Handles everything related to authorization.
     */
    function handleAccessControl()
    {
        if ($GLOBALS['current_user']->isDeveloperForAnyModule()) {
            return;
        }
        if (!empty($_REQUEST['action']) && $_REQUEST['action'] == "RetrieveEmail") {
            return;
        }
        if (!is_admin($GLOBALS['current_user']) && !empty($GLOBALS['adminOnlyList'][$this->controller->module])
            && !empty($GLOBALS['adminOnlyList'][$this->controller->module]['all'])
            && (empty($GLOBALS['adminOnlyList'][$this->controller->module][$this->controller->action])
                || $GLOBALS['adminOnlyList'][$this->controller->module][$this->controller->action] != 'allow')
        ) {
            $this->controller->hasAccess = false;
            return;
        }

        // Bug 20916 - Special case for check ACL access rights for Subpanel QuickCreates
        if (isset($_POST['action']) && $_POST['action'] == 'SubpanelCreates') {
            $actual_module = $_POST['target_module'];
            if (!empty($GLOBALS['modListHeader']) && !in_array($actual_module, $GLOBALS['modListHeader'])) {
                $this->controller->hasAccess = false;
            }
            return;
        }

        if (!empty($GLOBALS['current_user']) && empty($GLOBALS['modListHeader'])) {
            $GLOBALS['modListHeader'] = query_module_access_list($GLOBALS['current_user']);
        }

        if (in_array($this->controller->module, $GLOBALS['modInvisList'])
            && ((in_array('Activities', $GLOBALS['moduleList']) && in_array('Calendar', $GLOBALS['moduleList']))
                && in_array($this->controller->module, $GLOBALS['modInvisListActivities']))
        ) {
            $this->controller->hasAccess = false;
            return;
        }
    }

    /**
     * Load only bare minimum of language that can be done before user init and MVC stuff
     */
    static function preLoadLanguages()
    {
        if (!empty($_SESSION['authenticated_user_language'])) {
            $GLOBALS['current_language'] = $_SESSION['authenticated_user_language'];
        } else {
            $GLOBALS['current_language'] = $GLOBALS['sugar_config']['default_language'];
        }
        $GLOBALS['log']->debug('current_language is: ' . $GLOBALS['current_language']);
        //set module and application string arrays based upon selected language
        $GLOBALS['app_strings'] = return_application_language($GLOBALS['current_language']);
    }

    /**
     * Load application wide languages as well as module based languages so they are accessible
     * from the module.
     */
    function loadLanguages()
    {
        global $locale;
        $GLOBALS['current_language'] = $locale->getAuthenticatedUserLanguage();
        $GLOBALS['log']->debug('current_language is: ' . $GLOBALS['current_language']);
        //set module and application string arrays based upon selected language
        $GLOBALS['app_strings'] = return_application_language($GLOBALS['current_language']);
        if (empty($GLOBALS['current_user']->id)) {
            $GLOBALS['app_strings']['NTC_WELCOME'] = '';
        }
        if (!empty($GLOBALS['system_config']->settings['system_name'])) {
            $GLOBALS['app_strings']['LBL_BROWSER_TITLE'] = $GLOBALS['system_config']->settings['system_name'];
        }
        $GLOBALS['app_list_strings'] = return_app_list_strings_language($GLOBALS['current_language']);
        $GLOBALS['mod_strings'] = return_module_language($GLOBALS['current_language'], $this->controller->module);
    }


    /**
     * checkDatabaseVersion
     * Check the db version sugar_version.php and compare to what the version is stored in the config table.
     * Ensure that both are the same.
     */
    function checkDatabaseVersion($dieOnFailure = true)
    {
        $row_count = sugar_cache_retrieve('checkDatabaseVersion_row_count');
        if (empty($row_count)) {
            $version_query
                = "SELECT count(*) as the_count FROM config WHERE category='info' AND name='sugar_version' AND " .
                $GLOBALS['db']->convert('value', 'text2char') . " = " . $GLOBALS['db']->quoted(
                $GLOBALS['sugar_db_version']
            );

            $result = $GLOBALS['db']->query($version_query);
            $row = $GLOBALS['db']->fetchByAssoc($result);
            $row_count = $row['the_count'];
            sugar_cache_put('checkDatabaseVersion_row_count', $row_count);
        }

        if ($row_count == 0 && empty($GLOBALS['sugar_config']['disc_client'])) {
            if ($dieOnFailure) {
                $replacementStrings = array(
                    0 => $GLOBALS['sugar_version'],
                    1 => $GLOBALS['sugar_db_version'],
                );
                sugar_die(string_format($GLOBALS['app_strings']['ERR_DB_VERSION'], $replacementStrings));
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Load the themes/images.
     */
    function loadDisplaySettings()
    {
        global $theme;

        // THIS IS A FIX FOR 7.1.5
        // We no longer have multiple themes support.

        // We removed the ability for the user to choose his preferred theme.
        // In the future, we'll add this feature back, in the new Sidecar Themes
        // format.
        // Backward compatibilty modules look and feel must be in accordance to
        // Sidecar modules, thus there is only one possible theme: `RacerX`
        $theme = 'RacerX';

        SugarThemeRegistry::set($theme);
        require_once('include/utils/layout_utils.php');
        $GLOBALS['image_path'] = SugarThemeRegistry::current()->getImagePath() . '/';
        if (defined('TEMPLATE_URL')) {
            $GLOBALS['image_path'] = TEMPLATE_URL . '/' . $GLOBALS['image_path'];
        }

        if (isset($GLOBALS['current_user'])) {
            $GLOBALS['gridline'] = (int)($GLOBALS['current_user']->getPreference('gridline') == 'on');
            $GLOBALS['current_user']->setPreference('user_theme', $theme, 0, 'global');
        }
    }

    function loadLicense()
    {
        loadLicense();
        global $user_unique_key, $server_unique_key;
        $user_unique_key = (isset($_SESSION['unique_key'])) ? $_SESSION['unique_key'] : '';
        $server_unique_key = (isset($sugar_config['unique_key'])) ? $sugar_config['unique_key'] : '';
    }

    function loadGlobals()
    {
        global $currentModule;
        $currentModule = $this->controller->module;
        if ($this->controller->module == $this->default_module) {
            $_REQUEST['module'] = $this->controller->module;
            if (empty($_REQUEST['action'])) {
                $_REQUEST['action'] = $this->default_action;
            }
        }
    }

    /**
     * Actions that modify data in this controller's instance and thus require referrers
     *
     * @var array
     */
    protected $modifyActions = array();
    /**
     * Actions that always modify data and thus require referrers
     * save* and delete* hardcoded as modified
     *
     * @var array
     */
    private $globalModifyActions
        = array(
            'massupdate', 'configuredashlet', 'import', 'importvcardsave', 'inlinefieldsave',
            'wlsave', 'quicksave'
        );

	/**
	 * Modules that modify data and thus require referrers for all actions
	 */
	private $modifyModules = array(
		'Administration' => true,
		'UpgradeWizard' => true,
		'Configurator' => true,
		'Studio' => true,
		'ModuleBuilder' => true,
		'Emails' => true,
	    'Trackers' => array('trackersettings'),
	    'SugarFavorites' => array('tag'),
	    'Import' => array('last', 'undo'),
	    'Users' => array('changepassword', "generatepassword"),
	);

    protected function isModifyAction()
    {
        $action = strtolower($this->controller->action);
        if (substr($action, 0, 4) == "save" || substr($action, 0, 6) == "delete") {
            return true;
        }
        if (isset($this->modifyModules[$this->controller->module])) {
            if ($this->modifyModules[$this->controller->module] === true) {
                return true;
            }
            if (in_array($this->controller->action, $this->modifyModules[$this->controller->module])) {
                return true;

            }
        }
        if (in_array($this->controller->action, $this->globalModifyActions)) {
            return true;
        }
        if (in_array($this->controller->action, $this->modifyActions)) {
            return true;
        }
        return false;
    }

    /**
     * The list of the actions excepted from referer checks by default
     *
     * @var array
     */
    protected $whiteListActions
        = array(
            'index', 'ListView', 'DetailView', 'EditView', 'oauth', 'authorize', 'Authenticate', 'Login',
            'SupportPortal',
            'LogView',
            "SugarpdfSettings", "saveftsmodules", 'SaveSequence'
        );

    /**
     * Respond to XSF attempt
     * @param string $http_host HTTP host sent
     * @param bool $dieIfInvalid
     * @param bool $inBWC Are we in BWC frame?
     * @return boolean Returns false
     */
    protected function xsrfResponse($http_host, $dieIfInvalid, $inBWC)
    {
        $whiteListActions = $this->whiteListActions;
        $whiteListActions[] = $this->controller->action;
        $whiteListString = "'" . implode("', '", $whiteListActions) . "'";
        if ($dieIfInvalid) {
            if($inBWC) {
                if(!empty($this->controller->module)) {
                    header("Location: index.php?module={$this->controller->module}&action=index");
                } else {
                    header("Location: index.php?module=Home&action=index");
                }
            } else {
                header("Cache-Control: no-cache, must-revalidate");
                $ss = new Sugar_Smarty;
                $ss->assign('host', $http_host);
                $ss->assign('action', $this->controller->action);
                $ss->assign('whiteListString', $whiteListString);
                $ss->display('include/MVC/View/tpls/xsrf.tpl');
            }
            sugar_cleanup(true);
        }
        return false;
    }

    /**
     *
     * Checks a request to ensure the request is coming from a valid source or it is for one of the white listed actions
     */
    protected function checkHTTPReferer($dieIfInvalid = true)
    {
        global $sugar_config;
        if (!empty($sugar_config['http_referer']['actions'])) {
            $this->whiteListActions = array_merge($sugar_config['http_referer']['actions'], $this->whiteListActions);
        }

        $strong = empty($sugar_config['http_referer']['weak']);

        // Bug 39691 - Make sure localhost and 127.0.0.1 are always valid HTTP referers
        $whiteListReferers = array('127.0.0.1', 'localhost');
        if (!empty($_SERVER['SERVER_ADDR'])) {
            $whiteListReferers[] = $_SERVER['SERVER_ADDR'];
        }
        if (!empty($sugar_config['http_referer']['list'])) {
            $whiteListReferers = array_merge($whiteListReferers, $sugar_config['http_referer']['list']);
        }

        $inBWC = !empty($_GET['bwcFrame']);
        // for BWC iframe, matching referer is not enough
        if ($strong && (empty($_SERVER['HTTP_REFERER']) || $inBWC)
            && !in_array($this->controller->action, $this->whiteListActions)
            && $this->isModifyAction()
        ) {
            $http_host = empty($_SERVER['HTTP_HOST'])?array(''):explode(':',$_SERVER['HTTP_HOST']);
            return $this->xsrfResponse($http_host[0], $dieIfInvalid, $inBWC);
        } else {
            if (!empty($_SERVER['HTTP_REFERER']) && !empty($_SERVER['SERVER_NAME'])) {
                $http_ref = parse_url($_SERVER['HTTP_REFERER']);
                if ($http_ref['host'] !== $_SERVER['SERVER_NAME']
                    && !in_array($this->controller->action, $this->whiteListActions)
                    && (empty($whiteListReferers) || !in_array($http_ref['host'], $whiteListReferers))
                ) {
                    return $this->xsrfResponse($http_ref['host'], $dieIfInvalid, $inBWC);
                }
            }
        }
        return true;
    }

    function startSession()
    {
        $sessionIdCookie = isset($_COOKIE['PHPSESSID']) ? $_COOKIE['PHPSESSID'] : null;
        if (isset($_REQUEST['MSID'])) {
            session_id($_REQUEST['MSID']);
            session_start();
            if (isset($_SESSION['user_id']) && isset($_SESSION['seamless_login'])) {
                unset ($_SESSION['seamless_login']);
            } else {
                if (isset($_COOKIE['PHPSESSID'])) {
                    self::setCookie('PHPSESSID', '', time() - 42000, '/');
                }
                sugar_cleanup(false);
                session_destroy();
                exit('Not a valid entry method');
            }
        } else {
            if (can_start_session()) {
                session_start();
            }
        }

        if (isset($_REQUEST['login_module']) && isset($_REQUEST['login_action'])
            && !($_REQUEST['login_module'] == 'Home' && $_REQUEST['login_action'] == 'index')
        ) {
            if (!is_null($sessionIdCookie) && empty($_SESSION)) {
                self::setCookie('loginErrorMessage', 'LBL_SESSION_EXPIRED', time() + 30, '/');
            }
        }

        self::trackLogin();

        LogicHook::initialize()->call_custom_logic('', 'after_session_start');
    }


    /**
     * trackLogin
     *
     * This is a protected function used to separate tracking the login information.  This allows us to better cleanly
     * separate a PRO feature as well as unit test this block.  This function writes log entries to the tracker_sessions
     * table to record a login session.
     *
     */
    public static function trackLogin()
    {
        $trackerManager = TrackerManager::getInstance();
        if ($monitor = $trackerManager->getMonitor('tracker_sessions')) {
            $db = DBManagerFactory::getInstance();
            $session_id = $monitor->getValue('session_id');
            $query = "SELECT date_start, round_trips, active FROM $monitor->name WHERE session_id = '" . $db->quote(
                $session_id
            ) . "'";
            $result = $db->query($query);

            if (isset($_SERVER['REMOTE_ADDR'])) {
                $monitor->setValue('client_ip', $_SERVER['REMOTE_ADDR']);
            }

            if (($row = $db->fetchByAssoc($result))) {
                if ($row['active'] != 1 && !empty($_SESSION['authenticated_user_id'])) {
                    $GLOBALS['log']->error(
                        'User ID: (' . $_SESSION['authenticated_user_id']
                            . ') has too many active sessions. Calling session_destroy() and sending user to Login page.'
                    );
                    session_destroy();
                    $msg_name = 'TO' . 'O_MANY_' . 'CONCUR' . 'RENT';
                      SugarApplication::redirect('index.php?action=Login&module=Users&loginErrorMessage=LBL_'.$msg_name);
                    die();
                }
                $monitor->setValue('date_start', $db->fromConvert($row['date_start'], 'datetime'));
                $monitor->setValue('round_trips', $row['round_trips'] + 1);
                $monitor->setValue('active', 1);
            } else {
                // We are creating a new session
                // Don't set the session as active until we have made sure it checks out.
                $monitor->setValue('active', 0);
                $monitor->setValue('date_start', TimeDate::getInstance()->nowDb());
                $monitor->setValue('round_trips', 1);
            }
        }
    }



    function endSession()
    {

        $trackerManager = TrackerManager::getInstance();
        if ($monitor = $trackerManager->getMonitor('tracker_sessions')) {
            $monitor->setValue('date_end', TimeDate::getInstance()->nowDb());
            $seconds = strtotime($monitor->date_end) - strtotime($monitor->date_start);
            $monitor->setValue('seconds', $seconds);
            $monitor->setValue('active', 0);
        }
        session_destroy();
    }

    /**
     * Redirect to another URL.
     *
     * If the module is not in BWC it will try to map to sidecar url.
     * If it loads only temporarily, please check if the module is pointing to
     * a layout/view in BWC.
     *
     * This function writes session data, ends the session and exists the app.
     *
     * @param string $url The URL to redirect to.
     */
    public function redirect($url)
    {
        /*
         * Parse the module from the URL first using regular expression.
         * This is faster than parse_url + parse_str in first place and most of
         * our redirects won't go to sidecar (at least for now).
         */
        if (preg_match('/module=([^&]+)/', $url, $matches) && !isModuleBWC($matches[1])) {
            parse_str(parse_url($url, PHP_URL_QUERY), $params);
            $script = navigateToSidecar(
                buildSidecarRoute($params['module'], $params['record'], translateToSidecarAction($params['action']))
            );
            echo "<script>$script</script>";
            exit();
        }

        session_write_close();
        header('HTTP/1.1 301 Moved Permanently');
        header("Location: $url");

        exit();
    }

    public static function appendErrorMessage($error_message)
    {
        if (empty($_SESSION['user_error_message']) || !is_array($_SESSION['user_error_message'])) {
            $_SESSION['user_error_message'] = array();
        }
        $_SESSION['user_error_message'][] = $error_message;
    }

    public static function getErrorMessages()
    {
        if (isset($_SESSION['user_error_message']) && is_array($_SESSION['user_error_message'])) {
            $msgs = $_SESSION['user_error_message'];
            unset($_SESSION['user_error_message']);
            return $msgs;
        } else {
            return array();
        }
    }

    /**
     * Wrapper for the PHP setcookie() function, to handle cases where headers have
     * already been sent
     */
    public static function setCookie(
        $name,
        $value,
        $expire = 0,
        $path = '/',
        $domain = null,
        $secure = false,
        $httponly = false
    )
    {
        if (is_null($domain)) {
            if (isset($_SERVER["HTTP_HOST"])) {
                $domain = $_SERVER["HTTP_HOST"];
            } else {
                $domain = 'localhost';
            }
        }

        if (!headers_sent()) {
            setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
        }

        $_COOKIE[$name] = $value;
    }

    /**
     * Get combined values of GET and POST
     * @return array
     */
    protected function getRequestVars()
    {
        return array_merge($_GET, $_POST);
    }

    /**
     * Create string to attach to login URL with vars to preserve post-login
     *
     * @return string URL part with login vars
     */
    public function createLoginVars()
    {
        $ret = array();
        $req = $this->getRequestVars();
        foreach (array_keys($req) as $var) {
            if(!empty($this->controller->$var)){
                $ret["login_" . $var] = $this->controller->$var;
                continue;
            }
            $ret["login_" . $var] = $req[$var];
        }
        if (isset($req['mobile'])) {
            $ret['mobile'] = $req['mobile'];
        }
        if (isset($req['no_saml'])) {
            $ret['no_saml'] = $req['no_saml'];
        }
        if (empty($ret)) {
            return '';
        }
        return "&" . http_build_query($ret);
    }

    /**
     * Get the list of vars passed with login form
     *
     * @param bool $add_empty Add empty vars to the result?
     *
     * @return array List of vars passed with login
     */
    public function getLoginVars($add_empty = true)
    {
        $prefix = 'login_';
        $ret = array();
        $req = $this->getRequestVars();

        foreach (array_keys($req) as $var) {
            if(strpos($var, $prefix) === 0){
                if (!empty($req[$var]) || $add_empty) {
                    $ret[substr($var, strlen($prefix))] = isset($_REQUEST[$var]) ? $req[$var] : '';
                }
            }
        }
        return $ret;
    }

    /**
     * Get URL to redirect after the login
     *
     * @return string the URL to redirect to
     */
    public function getLoginRedirect()
    {
        $prefix = 'login_';
        $vars = array();
        $req = $this->getRequestVars();

        foreach (array_keys($req) as $var) {
            if(strpos($var, $prefix) === 0){
                if (!empty($req[$var])) {
                    $vars[substr($var, strlen($prefix))] = $req[$var];
                }
            }
        }
        if (isset($req['mobile'])) {
            $vars['mobile'] = $req['mobile'];
        }

        if (isset($req['mobile'])) {
            $vars['mobile'] = $req['mobile'];
        }
        if (empty($vars)) {
            return $this->getAuthenticatedHomeUrl();
        }
        else {
            return "index.php?" . http_build_query($vars);
        }
    }


    /**
     * Determines whether or not the applications should display using the
     * sidecar framework.
     *
     * May need to be removed after 7.0 migration.
     *
     * @return bool
     */
    protected function shouldUseSidecar()
    {
        if ( array_key_exists('sidecar', $_GET) && $_GET['sidecar'] === '0' ) {
            return false;
        } else {
            return true;
        }
    }

    protected function getAuthenticatedHomeUrl() {
        $url = "index.php?module=Home&action=index";

        if ( $this->shouldUseSidecar() ) {
            $url = "index.php?action=sidecar#Home";
        }

        return $url;
    }

    protected function getUnauthenticatedHomeUrl($addLoginVars=false) {
        $url = "index.php?action=Login&module=Users";

        if ( $addLoginVars ) {
            $url .= $this->createLoginVars();
        }

        return $url;
    }
}
