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

global $locale;

if(!empty($_REQUEST['module']) && !empty($_REQUEST['action']) && !empty($_REQUEST['record'])) {
	$currentModule = clean_string($_REQUEST['module']);
	$action = clean_string($_REQUEST['action']);
	$record = clean_string($_REQUEST['record']);
} else {
	die ("module, action, and record id all are required");
}

$GLOBALS['focus'] = BeanFactory::getBean($currentModule, $record);
if(empty($focus)) {
    ACLController::displayNoAccess();
    sugar_die();
}
include("modules/$currentModule/$action.php");

?>
