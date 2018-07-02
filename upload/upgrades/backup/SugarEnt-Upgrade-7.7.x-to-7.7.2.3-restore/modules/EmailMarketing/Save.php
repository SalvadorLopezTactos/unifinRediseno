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






global $timedate;
global $current_user;
if(!empty($_POST['meridiem'])){
	$_POST['time_start'] = $timedate->merge_time_meridiem($_POST['time_start'],$timedate->get_time_format(), $_POST['meridiem']);
}

if(empty($_REQUEST['time_start'])) {
  $time_to_fix = date($timedate->get_date_time_format(), strtotime($_POST['date_start']));
    
  $_REQUEST['date_start'] = $time_to_fix;
  $_POST['date_start'] = $time_to_fix;
} else {
  $_REQUEST['date_start'] = $_REQUEST['date_start'] . ' ' . $_REQUEST['time_start'];
  $_POST['date_start'] = $_POST['date_start'] . ' ' . $_POST['time_start'];
}

$marketing = BeanFactory::getBean('EmailMarketing');
if (isset($_POST['record']) && !empty($_POST['record'])) {
	$marketing->retrieve($_POST['record']);
}
if(!$marketing->ACLAccess('Save')){
		ACLController::displayNoAccess(true);
		sugar_cleanup(true);
}

if (!empty($_POST['assigned_user_id']) && ($marketing->assigned_user_id != $_POST['assigned_user_id']) && ($_POST['assigned_user_id'] != $current_user->id)) {
	$check_notify = TRUE;
}
else {
	$check_notify = FALSE;
}
foreach($marketing->column_fields as $field)
{
	if ($field == 'all_prospect_lists') {
		if(isset($_POST[$field]) && $_POST[$field]='on' )
		{
			$marketing->$field = 1;
		} else {
			$marketing->$field = 0;			
		}
	}else {
		if(isset($_POST[$field]))
		{
			$value = $_POST[$field];
			$marketing->$field = $value;
		}
	}
}

foreach($marketing->additional_column_fields as $field)
{
	if(isset($_POST[$field]))
	{
		$value = $_POST[$field];
		$marketing->$field = $value;

	}
}

$marketing->campaign_id = $_REQUEST['campaign_id'];
$marketing->save($check_notify);

//add prospect lists to campaign.
$marketing->load_relationship('prospectlists');
$prospectlists=$marketing->prospectlists->get();
if ($marketing->all_prospect_lists==1) {
	//remove all related prospect lists.
	if (!empty($prospectlists)) {
		$marketing->prospectlists->delete($marketing->id);
	}
} else {
	if (is_array($_REQUEST['message_for'])) {
		foreach ($_REQUEST['message_for'] as $prospect_list_id) {
			
			$key=array_search($prospect_list_id,$prospectlists);
			if ($key === null or $key === false) {
				$marketing->prospectlists->add($prospect_list_id);			
			} else {
				unset($prospectlists[$key]);
			}
		}
		if (count($prospectlists) != 0) {
			foreach ($prospectlists as $key=>$list_id) {
				$marketing->prospectlists->delete($marketing->id,$list_id);				
			}	
		}
	}
}
if($_REQUEST['action'] != 'WizardMarketingSave'){
    $header_URL = "Location: index.php?action=DetailView&module=Campaigns&record={$_REQUEST['campaign_id']}";
    $GLOBALS['log']->debug("about to post header URL of: $header_URL");
    header($header_URL);
}
?>