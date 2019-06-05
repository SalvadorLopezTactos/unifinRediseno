<?php

use Sugarcrm\Sugarcrm\Util\Arrays\ArrayFunctions\ArrayFunctions;
include_once("include/workflow/alert_utils.php");
include_once("include/workflow/action_utils.php");
include_once("include/workflow/time_utils.php");
include_once("include/workflow/trigger_utils.php");
//BEGIN WFLOW PLUGINS
include_once("include/workflow/custom_utils.php");
//END WFLOW PLUGINS
	class TCT2_Notificaciones_workflow {
	function process_wflow_triggers(& $focus){
		include("custom/modules/TCT2_Notificaciones/workflow/triggers_array.php");
		include("custom/modules/TCT2_Notificaciones/workflow/alerts_array.php");
		include("custom/modules/TCT2_Notificaciones/workflow/actions_array.php");
		include("custom/modules/TCT2_Notificaciones/workflow/plugins_array.php");
		if(isset($focus->fetched_row['id']) && $focus->fetched_row['id']!=""){ 
 
 if( ( !(
 	 ( 
 		$focus->fetched_row['ejecutado_c'] === true ||
 		$focus->fetched_row['ejecutado_c'] === 'true' ||
 		$focus->fetched_row['ejecutado_c'] === 'on' ||
 		$focus->fetched_row['ejecutado_c'] === 1 ||
 		$focus->fetched_row['ejecutado_c'] === '1'
 	 )  
 )) && 
 (
 	 ( 
 		isset($focus->ejecutado_c) && $focus->ejecutado_c === true ||
 		isset($focus->ejecutado_c) && $focus->ejecutado_c === 'true' ||
 		isset($focus->ejecutado_c) && $focus->ejecutado_c === 'on' ||
 		isset($focus->ejecutado_c) && $focus->ejecutado_c === 1 ||
 		isset($focus->ejecutado_c) && $focus->ejecutado_c === '1'
 	 )  
)){ 
 

	 //Frame Secondary 

	 $secondary_array = array(); 
	 //Secondary Triggers 
	 //Secondary Trigger number #1
	 if( (isset($focus->persona_c) && $focus->persona_c ==  stripslashes('Cliente'))	 ){ 
	 


	global $triggeredWorkflows;
	if (!isset($triggeredWorkflows['52e5ff04_8729_11e9_8b56_00155da0710c'])){
		$triggeredWorkflows['52e5ff04_8729_11e9_8b56_00155da0710c'] = true;
		 $alertshell_array = array(); 

	 $alertshell_array['alert_msg'] = "88a3c80c-4278-11e8-9e62-00155d967307"; 

	 $alertshell_array['source_type'] = "Custom Template"; 

	 $alertshell_array['alert_type'] = "Email"; 

	 process_workflow_alerts($focus, $alert_meta_array['TCT2_Notificaciones0_alert0'], $alertshell_array, false); 
 	 $alertshell_array = array(); 

	 $alertshell_array['alert_msg'] = "6155ce22-766b-11e8-989a-00155d967407"; 

	 $alertshell_array['source_type'] = "Custom Template"; 

	 $alertshell_array['alert_type'] = "Email"; 

	 process_workflow_alerts($focus, $alert_meta_array['TCT2_Notificaciones0_alert1'], $alertshell_array, false); 
 	 unset($alertshell_array); 
		}
 

	 //End Frame Secondary 

	 // End Secondary Trigger number #1
 	 } 

	 unset($secondary_array); 
 

 //End if trigger is true 
 } 

		 //End if new, update, or all record
 		} 

if(isset($focus->fetched_row['id']) && $focus->fetched_row['id']!=""){ 
 
 if( ( !(
 	 ( 
 		$focus->fetched_row['ejecutado_c'] === true ||
 		$focus->fetched_row['ejecutado_c'] === 'true' ||
 		$focus->fetched_row['ejecutado_c'] === 'on' ||
 		$focus->fetched_row['ejecutado_c'] === 1 ||
 		$focus->fetched_row['ejecutado_c'] === '1'
 	 )  
 )) && 
 (
 	 ( 
 		isset($focus->ejecutado_c) && $focus->ejecutado_c === true ||
 		isset($focus->ejecutado_c) && $focus->ejecutado_c === 'true' ||
 		isset($focus->ejecutado_c) && $focus->ejecutado_c === 'on' ||
 		isset($focus->ejecutado_c) && $focus->ejecutado_c === 1 ||
 		isset($focus->ejecutado_c) && $focus->ejecutado_c === '1'
 	 )  
)){ 
 

	 //Frame Secondary 

	 $secondary_array = array(); 
	 //Secondary Triggers 
	 //Secondary Trigger number #1
	 if( (isset($focus->persona_c) && $focus->persona_c ==  stripslashes('Prospecto'))	 ){ 
	 


	global $triggeredWorkflows;
	if (!isset($triggeredWorkflows['52e6c2a4_8729_11e9_8237_00155da0710c'])){
		$triggeredWorkflows['52e6c2a4_8729_11e9_8237_00155da0710c'] = true;
		 $alertshell_array = array(); 

	 $alertshell_array['alert_msg'] = "88a3c80c-4278-11e8-9e62-00155d967307"; 

	 $alertshell_array['source_type'] = "Custom Template"; 

	 $alertshell_array['alert_type'] = "Email"; 

	 process_workflow_alerts($focus, $alert_meta_array['TCT2_Notificaciones1_alert0'], $alertshell_array, false); 
 	 $alertshell_array = array(); 

	 $alertshell_array['alert_msg'] = "9a074084-766b-11e8-afca-00155d967407"; 

	 $alertshell_array['source_type'] = "Custom Template"; 

	 $alertshell_array['alert_type'] = "Email"; 

	 process_workflow_alerts($focus, $alert_meta_array['TCT2_Notificaciones1_alert1'], $alertshell_array, false); 
 	 unset($alertshell_array); 
		}
 

	 //End Frame Secondary 

	 // End Secondary Trigger number #1
 	 } 

	 unset($secondary_array); 
 

 //End if trigger is true 
 } 

		 //End if new, update, or all record
 		} 


	//end function process_wflow_triggers
	}

	//end class
	}

?>