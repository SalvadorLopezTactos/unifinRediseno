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

 * Description:  
 ********************************************************************************/


require_once('include/controller/Controller.php');




$focus = BeanFactory::getBean('WorkFlow');

if(isset($_POST['record']) && $_POST['record']!=""){
	$focus->retrieve($_POST['record']);
	$is_new = false;
} else {
	$is_new = true;
}

//check if we need to remove the old stuff
if(!$is_new && ((!empty($_POST['base_module']) && ($_POST['base_module'] != $focus->base_module)) || (!empty($_POST['type']) && ($_POST['type'] != $focus->type)))){
    $focus->delete_workflow_on_cascade = false;
    $focus->mark_deleted($_POST['record']);
    $focus->deleted = 0;
}

foreach($focus->column_fields as $field)
{
	if(isset($_POST[$field]))
	{
		$focus->$field = $_POST[$field];
		
	}
}

foreach($focus->additional_column_fields as $field)
{
	if(isset($_POST[$field]))
	{
		$value = $_POST[$field];
		$focus->$field = $value;
		
	}
}


if ($focus->status=="Active"){
	$focus->status = 1;	
} else {
	$focus->status = 0;
}	

//If this is new, set the initial process order
if($is_new==true){
		$controller = new Controller();
		$controller->init($focus, "New");
		$controller->change_component_order("", "", $_REQUEST['base_module']);
}

$focus->save();


if(!empty($_POST['is_duplicate']) && $_POST['is_duplicate'] == "true"){
	$old_workflow = BeanFactory::getBean('WorkFlow', $_POST['old_record_id']);
	$alerts_list =& $old_workflow->get_linked_beans('alerts','WorkFlowAlertShell');
	$actions_list =& $old_workflow->get_linked_beans('actions','WorkFlowActionShell');
	$triggers_list = & $old_workflow->get_linked_beans('triggers','WorkFlowTriggerShell');
	$filters_list = & $old_workflow->get_linked_beans('trigger_filters','WorkFlowTriggerShell');
	
	foreach($alerts_list as $alert)
	{
		$alert->copy($focus->id);
	}
	
	foreach($actions_list as $action)
	{
		$newActionId = $action->copy($focus->id);
	
		// BUG 44500 Duplicating workflow does not duplicate invitees for created activites
		$query = "SELECT id FROM workflow WHERE parent_id = '{$action->id}' ";
		$result1 = $focus->db->query($query);
		while (($row=$focus->db->fetchByAssoc($result1)) != null) {
			$copyWorkflow = BeanFactory::getBean('WorkFlow', $row['id']);
			$copyWorkflow->id = '';
			$copyWorkflow->parent_id = $newActionId;
			$copyWorkflowId = $copyWorkflow->save();

			$query = "SELECT id FROM workflow_alertshells WHERE parent_id = '{$row[id]}' ";
			$result2 = $focus->db->query($query);
			while (($alertshell=$focus->db->fetchByAssoc($result2)) != null) {
				$copyAlertshell = BeanFactory::getBean('WorkFlowAlertShells', $alertshell['id']);
				$copyAlertshell->id = '';
				$copyAlertshell->parent_id = $copyWorkflowId;
				$copyAlertshellId = $copyAlertshell->save();
				
				$query = "SELECT id FROM workflow_alerts WHERE parent_id = '{$alertshell[id]}' ";
				$result3 = $focus->db->query($query);
				while (($alert=$focus->db->fetchByAssoc($result3)) != null) {
					$copyAlert = BeanFactory::getBean('WorkFlowAlerts', $alert['id']);
					$copyAlert->id = '';
					$copyAlert->parent_id = $copyAlertshellId;
					$copyAlertId = $copyAlert->save();
				}
			}
		}
	}
	
	foreach($triggers_list as $trigger)
	{
		$trigger->copy($focus->id);
	}
	
	foreach($filters_list as $filter)
	{
		$filter->copy($focus->id);
	}
}

	//Add or Build Logic File if necessary
	$focus->check_logic_hook_file();

//write the workflow into the workflow files
$focus->write_workflow();

$return_id = $focus->id;

if(isset($_POST['return_module']) && $_POST['return_module'] != "") $return_module = $_POST['return_module'];
else $return_module = "WorkFlow";
if(isset($_POST['return_action']) && $_POST['return_action'] != "") $return_action = $_POST['return_action'];
else $return_action = "DetailView";
if(isset($_POST['return_id']) && $_POST['return_id'] != "") $return_id = $_POST['return_id'];

$GLOBALS['log']->debug("Saved record with id of ".$return_id);
//exit;

//Redirect to DetailView, not listview for the workflow object.

header("Location: index.php?action=DetailView&module=$return_module&record=$return_id");
?>
