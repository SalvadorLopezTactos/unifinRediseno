<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

use Sugarcrm\Sugarcrm\IdentityProvider\OAuth2StateRegistry;
use Sugarcrm\Sugarcrm\inc\Entitlements\Exception\SubscriptionException;

class UsersViewOAuth2Authenticate extends SidecarView
{

    /**
     * current platform
     * @var string
     */
    protected $platform;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct();
        $this->options['show_header'] = false;
        $this->options['show_javascript'] = false;
    }

    /**
     * @inheritdoc
     */
    public function preDisplay($params = array()) : void
    {
        $code = $this->request->getValidInputGet('code');
        $scope = $this->request->getValidInputGet('scope');
        $state = $this->request->getValidInputGet('state');
        if (!$code || !$scope || !$state) {
            $this->redirect();
        }
        list($this->platform, $state) = explode('_', $state);

        $stateRegistry = $this->getStateRegistry();
        $isStateRegistered = $stateRegistry->isStateRegistered($state);
        $stateRegistry->unregisterState($state);
        if (!$isStateRegistered) {
            $this->redirect();
        }

        $oAuthServer = \SugarOAuth2Server::getOAuth2Server($this->platform);

        try {
            $GLOBALS['logic_hook']->call_custom_logic('Users', 'before_login');
            $this->authorization = $oAuthServer->grantAccessToken([
                'grant_type' => 'authorization_code',
                'code' => $code,
                'scope' => $scope,
            ]);

            $tokenInfo = $oAuthServer->verifyAccessToken($this->authorization['access_token']);
            if (!$tokenInfo) {
                $this->redirect();
            }
            /** @var User $user */
            $user = BeanFactory::getBean('Users', $tokenInfo['user_id']);
            if (!$user) {
                $this->redirect();
            }

            $user->call_custom_logic('after_login');

            $loginStatus = apiCheckLoginStatus();
            if (true !== $loginStatus && !$user->isAdmin()) {
                if ($loginStatus['level'] == 'maintenance') {
                    SugarApplication::redirect('./#maintenance');
                } elseif ($loginStatus['message'] === 'ERROR_LICENSE_SEATS_MAXED') {
                    SugarApplication::redirect('./#licenseSeats');
                }
            }
            // Adding the setcookie() here instead of calling $api->setHeader() because
            // manually adding a cookie header will break 3rd party apps that use cookies
            setcookie(
                RestService::DOWNLOAD_COOKIE . '_' . $this->platform,
                $this->authorization['download_token'],
                [
                    'expires' => time() + $this->authorization['refresh_expires_in'],
                    'path' => ini_get('session.cookie_path'),
                    'domain' => ini_get('session.cookie_domain'),
                    'secure' => ini_get('session.cookie_secure'),
                    'httponly' => ini_get('session.cookie_httponly'),
                    'samesite' => ini_get('session.cookie_samesite'),
                ],
            );
        } catch (SubscriptionException $e) {
            SugarApplication::redirect('./#licenseSeats');
        } catch (\Exception $e) {
            $this->redirect();
        }

        parent::preDisplay($params);
    }

    /**
     * This method sets the config file to use and renders the template
     *
     * @param array $params additional view paramters passed through from the controller
     */
    public function display($params = [])
    {
        if ($this->platform === 'mobile') {
            $moduleInstallerClass = SugarAutoLoader::customClass('ModuleInstaller');
            $sidecarConfig = $moduleInstallerClass::getBaseConfig();
            $this->ss->assign('appPrefix', $sidecarConfig['env'] . ':' . $sidecarConfig['appId'] . ':');
            $this->ss->assign("siteUrl", SugarConfig::getInstance()->get('site_url'));
            $this->ss->display('modules/Users/tpls/AuthenticateMobile.tpl');
        } else {
            parent::display($params);
        }
    }

    /**
     * @return OAuth2StateRegistry
     */
    protected function getStateRegistry() : OAuth2StateRegistry
    {
        return new OAuth2StateRegistry();
    }

    /**
     * Redirects to the main page.
     */
    protected function redirect(): void
    {
        $GLOBALS['logic_hook']->call_custom_logic('Users', 'login_failed');
        SugarApplication::redirect('./#stsAuthError');
    }
}
