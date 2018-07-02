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

$action_view_map['authorize']= 'authorize';

/*
	global $mod_strings;
	global $current_language;
	global $currentModule;
	$temp_module = $currentModule;
	$mod_strings = return_module_language($current_language,'Calendar');
	$currentModule = 'Calendar';
	$args = array();
        include_once("modules/Calendar/Calendar.php") ;
        include_once("modules/Calendar/templates/templates_calendar.php") ;
        $args['calendar'] = new Calendar('month');
	$args['view'] = 'month';
	$args['size'] = 'small';
        template_calendar($args);
	$mod_strings = return_module_language($current_language,$temp_module);
	$currentModule = $_REQUEST['module'];
*/
