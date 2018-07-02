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

require_once "modules/OutboundEmailConfiguration/OutboundEmailConfigurationPeer.php";

if(!is_admin($current_user)){
    sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
}

/**
 * clearPasswordSettings
 * @deprecated as of 7.5
 */
function clearPasswordSettings() {
    $GLOBALS['log']->deprecated("This method is no longer valid for use and will be removed in a future version of SugarCRM");
}

require_once('modules/Administration/Forms.php');
echo getClassicModuleTitle(
        "Administration",
        array(
            "<a href='index.php?module=Administration&action=index'>".translate('LBL_MODULE_NAME','Administration')."</a>",
           $mod_strings['LBL_MANAGE_PASSWORD_TITLE'],
           ),
        false
        );
require_once('modules/Configurator/Configurator.php');
$configurator = new Configurator();
$sugarConfig = SugarConfig::getInstance();
$focus = BeanFactory::getBean('Administration');
$configurator->parseLoggerSettings();
$config_strings = return_module_language($GLOBALS['current_language'], 'Configurator');
$valid_public_key = true;
if (!empty($_POST['saveConfig'])) {
    do {
        if ($_POST['captcha_on'] == '1') {
    		$handle = @fopen("http://api.recaptcha.net/challenge?k=".$_POST['captcha_public_key']."&cachestop=35235354", "r");
    		$buffer ='';
    		if ($handle) {
    		    while (!feof($handle)) {
    		        $buffer .= fgets($handle, 4096);
    		    }
    		    fclose($handle);
    		}
    		if (substr($buffer, 1, 4) != 'var ') {
    		    // skip save and go to display form
    		    $valid_public_key = false;
    		    break;
    		}
    	}

		if (isset($_REQUEST['system_ldap_enabled']) && $_REQUEST['system_ldap_enabled'] == 'on') {
			$_POST['system_ldap_enabled'] = 1;
		}
		else
			$_POST['system_ldap_enabled'] = 0;


        if(isset($_REQUEST['authenticationClass']))
        {
	        $configurator->useAuthenticationClass = true;
        } else {
	        $configurator->useAuthenticationClass = false;
            $_POST['authenticationClass'] = '';
        }

        if (isset($_REQUEST['ldap_group_attr_req_dn']) && $_REQUEST['ldap_group_attr_req_dn'] == 'on') {
            $_POST['ldap_group_attr_req_dn'] = 1;
        } else {
            $_POST['ldap_group_attr_req_dn'] = 0;
        }

		if (isset($_REQUEST['ldap_group_checkbox']) && $_REQUEST['ldap_group_checkbox'] == 'on')
			$_POST['ldap_group'] = 1;
		else
			$_POST['ldap_group'] = 0;

		if (isset($_REQUEST['ldap_authentication_checkbox']) && $_REQUEST['ldap_authentication_checkbox'] == 'on')
			$_POST['ldap_authentication'] = 1;
		else
		    $_POST['ldap_authentication'] = 0;

        if (!empty($_POST['ldap_admin_password']) && $_POST['ldap_admin_password'] == Administration::$passwordPlaceholder) {
            unset($_POST['ldap_admin_password']);
        }

		if( isset($_REQUEST['passwordsetting_lockoutexpirationtime']) && is_numeric($_REQUEST['passwordsetting_lockoutexpirationtime'])  )
		    $_POST['passwordsetting_lockoutexpiration'] = 2;

        // Check SAML settings
        if (!empty($_POST['authenticationClass']) && $_POST['authenticationClass'] == 'SAMLAuthenticate') {
            if (empty($_POST['SAML_loginurl'])) {
                $configurator->addError($config_strings['ERR_EMPTY_SAML_LOGIN']);
                break;
            } else {
                $_POST['SAML_loginurl'] = trim($_POST['SAML_loginurl']);
                if (!filter_var($_POST['SAML_loginurl'], FILTER_VALIDATE_URL)) {
                    $configurator->addError($config_strings['ERR_SAML_LOGIN_URL']);
                    break;
                }
            }
            if (!empty($_POST['SAML_SLO'])) {
                $_POST['SAML_SLO'] = trim($_POST['SAML_SLO']);
                if (!filter_var($_POST['SAML_SLO'], FILTER_VALIDATE_URL)) {
                    $configurator->addError($config_strings['ERR_SAML_SLO_URL']);
                    break;
                }
            }
            if (empty($_POST['SAML_X509Cert'])) {
                $configurator->addError($config_strings['ERR_EMPTY_SAML_CERT']);
                break;
            }
            if (isset($_REQUEST['SAML_SAME_WINDOW'])) {
                $_POST['SAML_SAME_WINDOW'] = true;
            } else {
                $_POST['SAML_SAME_WINDOW'] = false;
            }            
        }

		$configurator->saveConfig();
		$focus->saveConfig();

		// Clean API cache since we may have changed the authentication settings
		MetaDataManager::refreshSectionCache(array(MetaDataManager::MM_CONFIG));

        die("
            <script>
            var app = window.parent.SUGAR.App;
            app.api.call('read', app.api.buildURL('ping'));
            app.router.navigate('#bwc/index.php?module=Administration&action=index', {trigger:true, replace:true});
            </script>"
        );
	} while (false);

	// We did not succeed saving, but we still want to load data from post to display it
	$configurator->populateFromPost();
}

$focus->retrieveSettings();

if (!empty($focus->settings['ldap_admin_password'])) {
    $focus->settings['ldap_admin_password'] = Administration::$passwordPlaceholder;
}

require_once('include/SugarLogger/SugarLogger.php');
$sugar_smarty = new Sugar_Smarty();

// if no IMAP libraries available, disable Save/Test Settings
if(!function_exists('imap_open')) $sugar_smarty->assign('IE_DISABLED', 'DISABLED');

$sugar_smarty->assign('CONF', $config_strings);
$sugar_smarty->assign('MOD', $mod_strings);
$sugar_smarty->assign('APP', $app_strings);
$sugar_smarty->assign('APP_LIST', $app_list_strings);
$sugar_smarty->assign('config', $configurator->config);
$sugar_smarty->assign('error', $configurator->errors);
$sugar_smarty->assign('LANGUAGES', get_languages());
$sugar_smarty->assign("settings", $focus->settings);

$sugar_smarty->assign('saml_enabled_checked', false);

//echo "sugar_config[authenticationClass]: " . $sugar_config['authenticationClass'];
//if (array_key_exists('authenticationClass', $sugar_config) && $sugar_config['authenticationClass'] == 'SAMLAuthenticate') {
//   $sugar_smarty->assign('saml_enabled_checked', true);
//} else {
//	$sugar_smarty->assign('saml_enabled_checked', false);
//}


if(!function_exists('mcrypt_cbc')){
	$sugar_smarty->assign("LDAP_ENC_KEY_READONLY", 'readonly');
	$sugar_smarty->assign("LDAP_ENC_KEY_DESC", $config_strings['LDAP_ENC_KEY_NO_FUNC_DESC']);
}else{
	$sugar_smarty->assign("LDAP_ENC_KEY_DESC", $config_strings['LBL_LDAP_ENC_KEY_DESC']);
}
$sugar_smarty->assign("settings", $focus->settings);

if ($valid_public_key){
	if(!empty($focus->settings['captcha_on'])){
		$sugar_smarty->assign("CAPTCHA_CONFIG_DISPLAY", 'inline');
	}else{
		$sugar_smarty->assign("CAPTCHA_CONFIG_DISPLAY", 'none');
	}
}else{
	$sugar_smarty->assign("CAPTCHA_CONFIG_DISPLAY", 'inline');
}

$sugar_smarty->assign("VALID_PUBLIC_KEY", $valid_public_key);



$res=$GLOBALS['sugar_config']['passwordsetting'];

$outboundMailConfig = OutboundEmailConfigurationPeer::getSystemDefaultMailConfiguration();
$smtpServerIsSet    = (OutboundEmailConfigurationPeer::isMailConfigurationValid($outboundMailConfig)) ? "0" : "1";
$sugar_smarty->assign("SMTP_SERVER_NOT_SET", $smtpServerIsSet);

$focus = BeanFactory::getBean('InboundEmail');
$focus->checkImap();
$storedOptions = \Sugarcrm\Sugarcrm\Security\InputValidation\Serialized::unserialize(base64_decode($focus->stored_options));
$email_templates_arr = get_bean_select_array(true, 'EmailTemplate','name', '','name',true);
$create_case_email_template = (isset($storedOptions['create_case_email_template'])) ? $storedOptions['create_case_email_template'] : "";
$TMPL_DRPDWN_LOST =get_select_options_with_id($email_templates_arr, $res['lostpasswordtmpl']);
$TMPL_DRPDWN_GENERATE =get_select_options_with_id($email_templates_arr, $res['generatepasswordtmpl']);

$sugar_smarty->assign("TMPL_DRPDWN_LOST", $TMPL_DRPDWN_LOST);
$sugar_smarty->assign("TMPL_DRPDWN_GENERATE", $TMPL_DRPDWN_GENERATE);

$LOGGED_OUT_DISPLAY= (isset($res['lockoutexpiration']) && $res['lockoutexpiration'] == '0') ? 'none' : '';
$sugar_smarty->assign("LOGGED_OUT_DISPLAY_STATUS", $LOGGED_OUT_DISPLAY);

$sugar_smarty->display('modules/Administration/PasswordManager.tpl');
