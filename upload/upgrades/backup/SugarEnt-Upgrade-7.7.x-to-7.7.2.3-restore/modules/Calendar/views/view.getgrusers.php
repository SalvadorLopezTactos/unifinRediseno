<?php
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
require_once('include/MVC/View/SugarView.php');

class CalendarViewGetGRUsers extends SugarView {

	function CalendarViewGetGRUsers(){
 		parent::SugarView();
	}
	
	function process(){
		$this->display();
	}
	
	function display(){
		$users_arr = array();
		require_once("modules/Users/User.php");	
	
		$user_ids = explode(",", trim($_REQUEST['users'],','));	
		$user_ids = array_unique($user_ids);	

		require_once('include/json_config.php');
		global $json;
		$json = getJSONobj();
		$json_config = new json_config();        
	       
		foreach($user_ids as $u_id){
			if(empty($u_id))
				continue;
			$bean = BeanFactory::getBean('Users', $u_id);
			array_push($users_arr, $json_config->populateBean($bean));        	
		}
		
		$GRjavascript = "\n" . $json_config->global_registry_var_name."['focus'].users_arr = " . $json->encode($users_arr) . ";\n";       	
		ob_clean();
		echo $GRjavascript;
	}	

}

?>
