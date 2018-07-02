<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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




class Configurator {
	var $config = '';
	var $override = '';
    public $allow_undefined = array (
        'stack_trace_errors', 'export_delimiter', 'use_real_names', 'developerMode', 'default_module_favicon',
        'authenticationClass', 'SAML_loginurl', 'SAML_X509Cert', 'SAML_SLO', 'dashlet_auto_refresh_min',
        'show_download_tab', 'enable_action_menu', 'offlineEnabled');
	var $errors = array ('main' => '');
	var $logger = NULL;
	var $previous_sugar_override_config_array = array();
	var $useAuthenticationClass = false;

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function Configurator()
    {
        self::__construct();
    }

	public function __construct() {
		$this->loadConfig();
	}

	function loadConfig() {
		$this->logger = LoggerManager::getLogger();
		global $sugar_config;
		$this->config = $sugar_config;
	}

	function populateFromPost() {
		$sugarConfig = SugarConfig::getInstance();
		foreach ($_POST as $key => $value) {

			if ($key == "logger_file_ext") {
			    $trim_value = preg_replace('/.*\.([^\.]+)$/', '\1', $value);
			    if(in_array($trim_value, $this->config['upload_badext'])) {
			        $GLOBALS['log']->security("Invalid log file extension: trying to use invalid file extension '$value'.");
			        continue;
			    }
			}
			if (isset ($this->config[$key]) || in_array($key, $this->allow_undefined)) {
				if (strcmp("$value", 'true') == 0) {
					$value = true;
				}
				if (strcmp("$value", 'false') == 0) {
					$value = false;
				}
                $this->config[$key] = $value;
			} else {
                $v = $sugarConfig->get(str_replace('_', '.', $key));
            if ($v  !== null){
			   setDeepArrayValue($this->config, $key, $value);
			}}

		}

	}

	function handleOverride()
	{
		global $sugar_config, $sugar_version;
		$sc = SugarConfig::getInstance();
		list($oldConfig, $overrideArray) = $this->readOverride();
		$this->previous_sugar_override_config_array = $overrideArray;
		$diffArray = deepArrayDiff($this->config, $sugar_config);
		$overrideArray = sugarArrayMergeRecursive($overrideArray, $diffArray);

		if(isset($overrideArray['authenticationClass']) && empty($overrideArray['authenticationClass'])) {
		    unset($overrideArray['authenticationClass']);
		}

		$overideString = "<?php\n/***CONFIGURATOR***/\n";

		sugar_cache_put('sugar_config', $this->config);
		$GLOBALS['sugar_config'] = $this->config;

		//print_r($overrideArray);
        //Bug#53013: Clean the tpl cache if action menu style has been changed.
        if( isset($overrideArray['enable_action_menu']) &&
                ( !isset($this->previous_sugar_override_config_array['enable_action_menu']) ||
                    $overrideArray['enable_action_menu'] != $this->previous_sugar_override_config_array['enable_action_menu'] )
        ) {
            require_once('modules/Administration/QuickRepairAndRebuild.php');
            $repair = new RepairAndClear;
            $repair->module_list = array();
            $repair->clearTpls();
        }

		foreach($overrideArray as $key => $val) {
			if (in_array($key, $this->allow_undefined) || isset ($sugar_config[$key])) {
				if (is_string($val) && strcmp($val, 'true') == 0) {
					$val = true;
					$this->config[$key] = $val;
				}
				if (is_string($val) && strcmp($val, 'false') == 0) {
					$val = false;
					$this->config[$key] = false;
				}
			}
			$overideString .= override_value_to_string_recursive2('sugar_config', $key, $val, true, $oldConfig);
		}
		$overideString .= '/***CONFIGURATOR***/';

		$this->saveOverride($overideString);
		if(isset($this->config['logger']['level']) && $this->logger) $this->logger->setLevel($this->config['logger']['level']);
	}

    //bug #27947 , if previous $sugar_config['stack_trace_errors'] is true and now we disable it , we should clear all the cache.
    function clearCache()
    {
        global $sugar_config, $sugar_version;
        list($oldConfig, $currentConfigArray) = $this->readOverride();
        foreach($currentConfigArray as $key => $val) {
            if (in_array($key, $this->allow_undefined) || isset ($sugar_config[$key])) {
                if (empty($val) ) {
                    if(!empty($this->previous_sugar_override_config_array['stack_trace_errors']) && $key == 'stack_trace_errors'){
                        require_once('include/TemplateHandler/TemplateHandler.php');
                        TemplateHandler::clearAll();
                        return;
                    }
                }
            }
        }
        // Clear metadata config section only
        MetaDataManager::refreshSectionCache(array(MetaDataManager::MM_CONFIG));
        MetaDataManager::refreshSectionCache(array(MetaDataManager::MM_SERVERINFO));
    }

	function saveConfig() {
		$this->saveImages();
		$this->populateFromPost();
		$this->handleOverride();
		$this->clearCache();
	}

	/**
	 * Read config & config override, and return old config and their difference
	 * @return array[old config, difference in configs]
	 */
	protected function readOverride() {
		$sugar_config = array();
		if(is_readable('config.php')) {
		    include 'config.php';
		}
		$old_config = $sugar_config;
		if (file_exists('config_override.php')) {
		    if ( !is_readable('config_override.php') ) {
		        $GLOBALS['log']->fatal("Unable to read the config_override.php file. Check the file permissions");
		    }
	        else {
	            include('config_override.php');
	        }
		}
		return array($old_config, deepArrayDiff($sugar_config, $old_config));
	}
	function saveOverride($override) {
        require_once('install/install_utils.php');
	    if ( !file_exists('config_override.php') ) {
	    	touch('config_override.php');
	    }
	    if ( !(make_writable('config_override.php')) ||  !(is_writable('config_override.php')) ) {
	        $GLOBALS['log']->fatal("Unable to write to the config_override.php file. Check the file permissions");
	        return;
	    }
		$fp = sugar_fopen('config_override.php', 'w');
		fwrite($fp, $override);
		fclose($fp);
	}

	function overrideClearDuplicates($array_name, $key) {
		if (!empty ($this->override)) {
			$pattern = '/.*CONFIGURATOR[^\$]*\$'.$array_name.'\[\''.$key.'\'\][\ ]*=[\ ]*[^;]*;\n/';
			$this->override = preg_replace($pattern, '', $this->override);
		} else {
			$this->override = "<?php\n\n?>";
		}

	}

	function replaceOverride($array_name, $key, $value) {
		$GLOBALS[$array_name][$key] = $value;
		$this->overrideClearDuplicates($array_name, $key);
		$new_entry = '/***CONFIGURATOR***/'.override_value_to_string($array_name, $key, $value);
		$this->override = str_replace('?>', "$new_entry\n?>", $this->override);
	}

	function restoreConfig() {
		$this->readOverride();
		$this->overrideClearDuplicates('sugar_config', '[a-zA-Z0-9\_]+');
		$this->saveOverride();
		ob_clean();
		header('Location: index.php?action=EditView&module=Configurator');
	}

	function saveImages() {
		if (!empty ($_POST['company_logo'])) {
			$this->saveCompanyLogo("upload://".$_POST['company_logo']);
		}
		if (!empty ($_POST['quotes_logo'])) {
			$this->saveCompanyQuoteLogo("upload://".$_POST['quotes_logo']);
			rmdir_recursive(sugar_cached('smarty/templates_c'));
		}
	}

	function checkTempImage($path)
	{
	    if(!verify_uploaded_image($path)) {
        	$GLOBALS['log']->fatal("A user ({$GLOBALS['current_user']->id}) attempted to use an invalid file for the logo - {$path}");
        	sugar_die('Invalid File Type');
		}
		return $path;
	}
    /**
     * Saves the company logo to the custom directory for the default theme, so all themes can use it
     *
     * @param string $path path to the image to set as the company logo image
     */
	function saveCompanyLogo($path)
    {
    	$path = $this->checkTempImage($path);
    	$logo = create_custom_directory(SugarThemeRegistry::current()->getDefaultImagePath(). '/company_logo.png');
        copy($path, $logo);
        SugarAutoLoader::addToMap($logo);
        sugar_cache_clear('company_logo_attributes');
        SugarThemeRegistry::clearAllCaches();
        SugarThemeRegistry::current()->clearImageCache('company_logo.png');
        MetaDataManager::refreshSectionCache(array(MetaDataManager::MM_LOGOURL));
	}
	/**
	 * @params : none
	 * @return : An array of logger configuration properties including log size, file extensions etc. See SugarLogger for more details.
	 * Parses the old logger settings from the log4php.properties files.
	 *
	 */

	function parseLoggerSettings(){
		if(!function_exists('setDeepArrayValue')){
			require('include/utils/array_utils.php');
		}
		if (file_exists('log4php.properties')) {
			$fileContent = file_get_contents('log4php.properties');
			$old_props = explode('\n', $fileContent);
			$new_props = array();
			$key_names=array();
			foreach($old_props as $value) {
				if(!empty($value) && !preg_match("/^\/\//", $value)) {
					$temp = explode("=",$value);
					$property = isset( $temp[1])? $temp[1] : array();
					if(preg_match("/log4php.appender.A2.MaxFileSize=/",$value)){
						setDeepArrayValue($this->config, 'logger_file_maxSize', rtrim( $property));
					}
					elseif(preg_match("/log4php.appender.A2.File=/", $value)){
						$ext = preg_split("/\./",$property);
						if(preg_match( "/^\./", $property)){ //begins with .
							setDeepArrayValue($this->config, 'logger_file_ext', isset($ext[2]) ? '.' . rtrim( $ext[2]):'.log');
							setDeepArrayValue($this->config, 'logger_file_name', rtrim( ".".$ext[1]));
						}else{
							setDeepArrayValue($this->config, 'logger_file_ext', isset($ext[1]) ? '.' . rtrim( $ext[1]):'.log');
							setDeepArrayValue($this->config, 'logger_file_name', rtrim( $ext[0] ));
						}
					}elseif(preg_match("/log4php.appender.A2.layout.DateFormat=/",$value)){
						setDeepArrayValue($this->config, 'logger_file_dateFormat', trim(rtrim( $property), '""'));

					}elseif(preg_match("/log4php.rootLogger=/",$value)){
						$property = explode(",",$property);
						setDeepArrayValue($this->config, 'logger_level', rtrim( $property[0]));
					}
				}
			}
			setDeepArrayValue($this->config, 'logger_file_maxLogs', 10);
			setDeepArrayValue($this->config, 'logger_file_suffix', "%m_%Y");
			$this->handleOverride();
			unlink('log4php.properties');
			$GLOBALS['sugar_config'] = $this->config; //load the rest of the sugar_config settings.
			require_once('include/SugarLogger/SugarLogger.php');
			//$logger = new SugarLogger(); //this will create the log file.

		}

		if (!isset($this->config['logger']) || empty($this->config['logger'])) {
			$this->config['logger'] = array (
			'file' => array(
				'ext' => '.log',
				'name' => 'sugarcrm',
				'dateFormat' => '%c',
				'maxSize' => '10MB',
				'maxLogs' => 10,
				'suffix' => ''), // bug51583, change default suffix to blank for backwards comptability
			'level' => 'fatal');
		}
		$this->handleOverride();


	}


	function saveCompanyQuoteLogo($path) {
		$path = $this->checkTempImage($path);
		copy($path, 'modules/Quotes/layouts/company.jpg');
	}


}
?>
