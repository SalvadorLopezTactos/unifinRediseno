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


	//Used for custom plugins
	if(
	!empty($_REQUEST['plugin_action']) && $_REQUEST['plugin_action']!=""
	&&
	!empty($_REQUEST['plugin_module']) && $_REQUEST['plugin_module']!=""){

		if(SugarAutoLoader::existing('custom/workflow/plugins/'.$_REQUEST['plugin_module'].'/'.$_REQUEST['plugin_action'].'.php')){
				include_once('custom/workflow/plugins/'.$_REQUEST['plugin_module'].'/'.$_REQUEST['plugin_action'].'.php');
		} else {
			echo "custom plugin file not found";
		}
	} else {

		echo "A custom plugin step 2 was not specified";
	}


?>
