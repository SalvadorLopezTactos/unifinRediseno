<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

require_once 'modules/Users/authentication/SugarAuthenticate/SugarAuthenticate.php';
require_once 'modules/Users/authentication/SugarAuthenticate/SugarAuthenticateExternal.php';
require_once 'modules/Users/authentication/SAMLAuthenticate/saml.php';

/**
 * This file is used to control the authentication process.
 * It will call on the user authenticate and controll redirection
 * based on the users validation
 */
class SAMLAuthenticate extends SugarAuthenticate implements SugarAuthenticateExternal
{
    var $userAuthenticateClass = 'SAMLAuthenticateUser';
    var $authenticationDir = 'SAMLAuthenticate';

    /**
     * pre_login
     *
     * Override the pre_login function from SugarAuthenticate so that user is
     * redirected to SAML entry point if other is not specified
     */
    function pre_login()
    {
        parent::pre_login();

        if (empty($_REQUEST['no_saml'])) {
            SugarApplication::redirect('?entryPoint=SAML');
        }
    }

    /**
     * Called when a user requests to logout
     *
     * Override default behavior. Redirect user to special "Logged Out" page in
     * order to prevent automatic logging in.
     */
    public function logout()
    {
        session_destroy();
        ob_clean();
        header('Location: index.php?module=Users&action=LoggedOut');
        sugar_cleanup(true);
    }

    /**
     * Get URL to follow to get logged in
     *
     * @param array $returnQueryVars Query variables that should be added to the return URL
     *
     * @return string
     */
    public function getLoginUrl($returnQueryVars = array())
    {
        $settings = self::loadSettings($returnQueryVars);
        $this->patchSettings($settings, $returnQueryVars);
        $authrequest = $this->getAuthRequest($settings);
        return $authrequest->getRedirectUrl();
    }

    /**
     * Get URL to follow to get logged out
     * @return string
     */
    public function getLogoutUrl()
    {
        if(empty($GLOBALS['sugar_config']['SAML_SLO'])) {
            return;
        }
        $auth = new OneLogin_Saml2_Auth(SAMLAuthenticate::loadSettings());
        $req = new OneLogin_Saml2_LogoutRequest($auth->getSettings());
        $url = $GLOBALS['sugar_config']['SAML_SLO'];
        if (strpos($url, '?') === false) {
            $paramPrefix = '?';
        } else {
            $paramPrefix = '&';
        }
        return $url . $paramPrefix . 'SAMLRequest=' . urlencode($req->getRequest());
    }

    /**
     * Returns SAML authentication request
     *
     * @param OneLogin_Saml_Settings $settings
     * @return OneLogin_Saml_AuthRequest
     */
    protected function getAuthRequest(OneLogin_Saml_Settings $settings)
    {
        return new OneLogin_Saml_AuthRequest($settings);
    }

    /**
     * Load SAML settings
     * @param array $returnQueryVars Query variables that should be added to the return URL
     * @return OneLogin_Saml_Settings
     */
    public static function loadSettings($returnQueryVars = array())
    {
        $settings = null;
        require_once 'modules/Users/authentication/SAMLAuthenticate/saml.php';
        require SugarAutoLoader::existingCustomOne('modules/Users/authentication/SAMLAuthenticate/settings.php');
        // BC conversion
        if ($settings instanceof SamlSettings) {
            $oldsettings = $settings;
            // reload default defs with correct class
            require 'modules/Users/authentication/SAMLAuthenticate/settings.php';
            foreach (get_object_vars($oldsettings) as $k => $v) {
                $settings->$k = $v;
            }
        }

        $settings_map = array('idp_sso_target_url' => 'idpSingleSignOnUrl',
            'x509certificate' => 'idpPublicCertificate',
            'assertion_consumer_service_url' => 'spReturnUrl',
            'name_identifier_format' => 'requestedNameIdFormat'
        );

        foreach ($settings_map as $old => $new) {
            if (!empty($settings->$old)) {
                $settings->$new = $settings->$old;
            }
        }

        if ($settings->spIssuer == 'php-saml' && !empty($settings->issuer) &&
             $settings->issuer != 'php-saml') {
            $settings->spIssuer = $settings->issuer;
        }

        if (!isset($settings->useXML)) {
            foreach (array('update', 'create', 'check') as $saml_item) {
                if (!empty($oldsettings->saml_settings[$saml_item])) {
                    $settings->useXML = true;
                    $settings->saml2_settings[$saml_item] = $oldsettings->saml_settings[$saml_item];
                }
            }
        }

        return $settings;
    }

    /**
     * Patches SAML settings stored in configuration by adding query variables in return URL
     *
     * @param OneLogin_Saml_Settings $settings
     * @param array $returnQueryVars
     */
    protected function patchSettings($settings, array $returnQueryVars)
    {
        // OneLogin_Saml_AuthRequest doesn't escape strings before placing them into XML,
        // so the URL is kind of expected to be already escaped. Historically, we store it escaped
        // in a file which may be customized. Here we un-escape the URL, patch it and escape back
        $returnUrl = htmlspecialchars_decode($settings->spReturnUrl);
        $returnUrl = $this->addQueryVars($returnUrl, $returnQueryVars);
        $settings->spReturnUrl = htmlspecialchars($returnUrl);
    }

    /**
     * Adds query variables to the URL
     *
     * @param string $url
     * @param array $queryVars
     *
     * @return string
     */
    protected function addQueryVars($url, array $queryVars)
    {
        if ($queryVars) {
            $hasQuery = strpos($url, '?') !== false;
            $prefix = $hasQuery ? '&' : '?';
            $url .= $prefix . http_build_query($queryVars);
        }

        return $url;
    }
}

/**
* Stub class for BC
*/
class SamlSettings {}
