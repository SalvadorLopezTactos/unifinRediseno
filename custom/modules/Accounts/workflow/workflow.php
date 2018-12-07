<?php

use Sugarcrm\Sugarcrm\Util\Arrays\ArrayFunctions\ArrayFunctions;
include_once("include/workflow/alert_utils.php");
include_once("include/workflow/action_utils.php");
include_once("include/workflow/time_utils.php");
include_once("include/workflow/trigger_utils.php");
//BEGIN WFLOW PLUGINS
include_once("include/workflow/custom_utils.php");
//END WFLOW PLUGINS
	class Accounts_workflow {
	function process_wflow_triggers(& $focus){
		include("custom/modules/Accounts/workflow/triggers_array.php");
		include("custom/modules/Accounts/workflow/alerts_array.php");
		include("custom/modules/Accounts/workflow/actions_array.php");
		include("custom/modules/Accounts/workflow/plugins_array.php");
		
 if( ( !($focus->fetched_row['estatus_c'] ==  stripslashes('No Interesado') )) && 
 (isset($focus->estatus_c) && $focus->estatus_c ==  stripslashes('No Interesado'))){ 
 

	 //Frame Secondary 

	 $secondary_array = array(); 
	 //Secondary Triggers 

	global $triggeredWorkflows;
	if (!isset($triggeredWorkflows['a85e941a_f9a7_11e8_8ffb_00155da06f04'])){
		$triggeredWorkflows['a85e941a_f9a7_11e8_8ffb_00155da06f04'] = true;
		 unset($alertshell_array); 
		$action_meta_array['Accounts0_action0']['trigger_id'] = 'a85e941a_f9a7_11e8_8ffb_00155da06f04';
	$action_meta_array['Accounts0_action0']['action_id'] = '161c7f1f-0aee-47f9-5414-558ae285e632';
	 $action_meta_array['Accounts0_action0']['workflow_id'] = '5174bed4-6d7a-6dd6-8c84-5580cd5bbc54';
	 process_workflow_actions($focus, $action_meta_array['Accounts0_action0']); 
 	$action_meta_array['Accounts0_action1']['trigger_id'] = 'a85e941a_f9a7_11e8_8ffb_00155da06f04';
	$action_meta_array['Accounts0_action1']['action_id'] = 'f2619411-cc47-0ec7-3fc4-558ae3183309';
	 $action_meta_array['Accounts0_action1']['workflow_id'] = '5174bed4-6d7a-6dd6-8c84-5580cd5bbc54';
	 process_workflow_actions($focus, $action_meta_array['Accounts0_action1']); 
 	}
 

	 //End Frame Secondary 

	 unset($secondary_array); 
 

 //End if trigger is true 
 } 


	//end function process_wflow_triggers
	}

	//end class
	}

?>