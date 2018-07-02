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




global $mod_strings;
global $current_user;


if (!$GLOBALS['current_user']->isAdminForModule('Users')) sugar_die("Unauthorized access to administration.");

$focus = BeanFactory::getBean('Teams');

if(!isset($_REQUEST['record']) || !isset($_REQUEST['user_id'])) {
	sugar_die($mod_strings['ERR_ADD_RECORD']);
}
else {
	$record = $_REQUEST['record'];
	$user_id = $_REQUEST['user_id'];
	if(is_array($record)){
		foreach($record as $id){
			$focus->retrieve($id);
			$focus->add_user_to_team($user_id);
		}
	}
	else{
		$focus->retrieve($record);
		$focus->add_user_to_team($user_id);
	}
}
header("Location: index.php?module={$_REQUEST['return_module']}&action={$_REQUEST['return_action']}&record={$_REQUEST['return_id']}");
?>
