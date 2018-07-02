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

class CalendarViewGetGR extends SugarView {

	function CalendarViewGetGR(){
 		parent::SugarView();
	}
	
	function process(){
		$this->display();
	}
	
	function display(){
		error_reporting(0);
		require_once('include/json_config.php');
		global $json;
        	$json = getJSONobj();
        	$json_config = new json_config();
        	$GRjavascript = $json_config->getFocusData($_REQUEST['type'], $_REQUEST['record']);
        	ob_clean();
        	echo $GRjavascript;
	}	

}

?>
