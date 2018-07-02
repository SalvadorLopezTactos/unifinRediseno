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



global $current_user;


if (!is_admin($current_user)&& !is_admin_for_module($current_user,'ForecastSchedule')&& !is_admin_for_module($current_user,'Forecasts')) sugar_die("Unauthorized access to administration.");

$focus = BeanFactory::getBean('ForecastSchedule');

if ($_POST['isDuplicate'] != 1) {
//	echo "not duplicate, retrieving record {$_POST['record']}";
	$focus->retrieve($_POST['record']);
}// else { echo "duplicate, not retrieving"; }


//default cascade hierarchy.
$focus->cascade_hierarchy=0;
foreach ($focus->column_fields as $field) {
	if (isset($_POST[$field])) {
		
		if ($field == "cascade_hierarchy" && $_POST[$field] == "on") {
			$value=1;
		} else {
			$value = $_POST[$field];
		}
		$focus->$field = $value;
	}
}
$focus->save();
$return_id = $focus->timeperiod_id;


$return_module = (!empty($_POST['return_module'])) ? $_POST['return_module'] : "TimePeriods";
$return_action = (!empty($_POST['return_action'])) ? $_POST['return_action'] : "DetailView";

$GLOBALS['log']->debug("Saved record with id of {$return_id}");

header("Location: index.php?action={$return_action}&module={$return_module}&record={$return_id}");
?>