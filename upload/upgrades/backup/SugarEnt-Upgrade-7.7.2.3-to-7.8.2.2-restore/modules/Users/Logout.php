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
/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/



// record the last theme the user used
$current_user->setPreference('lastTheme',$theme);
$GLOBALS['current_user']->call_custom_logic('before_logout');

// submitted by Tim Scott from SugarCRM forums
foreach($_SESSION as $key => $val) {
	$_SESSION[$key] = ''; // cannot just overwrite session data, causes segfaults in some versions of PHP	
}
if(isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time()-42000, '/');
}

SugarApplication::endSession();

LogicHook::initialize();
$GLOBALS['logic_hook']->call_custom_logic('Users', 'after_logout');

/** @var AuthenticationController $authController */
$authController->authController->logout();
