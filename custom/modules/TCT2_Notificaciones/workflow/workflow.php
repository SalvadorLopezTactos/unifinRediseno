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
	 $secondary_array = check_rel_filter($focus, $secondary_array, 'tct2_notificaciones_accounts', $trigger_meta_array['trigger_0_secondary_0'], 'any'); 
	 if(($secondary_array['results']==true)	 ){ 
	 


	global $triggeredWorkflows;
	if (!isset($triggeredWorkflows['c31eefc2_730e_11e8_8e00_00155d963615'])){
		$triggeredWorkflows['c31eefc2_730e_11e8_8e00_00155d963615'] = true;
		 $alertshell_array = array(); 

	 $alertshell_array['alert_msg'] = "c7858982-41bc-11e8-9540-00155d963615"; 

	 $alertshell_array['source_type'] = "Custom Template"; 

	 $alertshell_array['alert_type'] = "Email"; 

	 process_workflow_alerts($focus, $alert_meta_array['TCT2_Notificaciones0_alert0'], $alertshell_array, false); 
 	 $alertshell_array = array(); 

	 $alertshell_array['alert_msg'] = "182ceabe-4984-11e8-bb16-00155d963615"; 

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
 
 if( (
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
	if (!isset($triggeredWorkflows['c31f7406_730e_11e8_9c0f_00155d963615'])){
		$triggeredWorkflows['c31f7406_730e_11e8_9c0f_00155d963615'] = true;
		 $alertshell_array = array(); 

	 $alertshell_array['alert_msg'] = "c7858982-41bc-11e8-9540-00155d963615"; 

	 $alertshell_array['source_type'] = "Custom Template"; 

	 $alertshell_array['alert_type'] = "Email"; 

	 process_workflow_alerts($focus, $alert_meta_array['TCT2_Notificaciones1_alert0'], $alertshell_array, false); 
 	 $alertshell_array = array(); 

	 $alertshell_array['alert_msg'] = "2c519f60-499f-11e8-903b-00155d963615"; 

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