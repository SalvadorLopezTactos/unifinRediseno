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





require_once('modules/Forecasts/Common.php');


global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;

//exit if the logged in user does not have admin rights.
if (!is_admin($current_user) && !is_admin_for_module($current_user,'ForecastSchedule')&& !is_admin_for_module($current_user,'Forecasts')) sugar_die("Unauthorized access to administration.");


$focus = BeanFactory::getBean('ForecastSchedule');

$GLOBALS['log']->info("in detail view");

if (!empty($_REQUEST['record'])) {

	$GLOBALS['log']->info("record to be fetched".$_REQUEST['record']);
	
    $result = $focus->retrieve($_REQUEST['record']);  
    if($result == null)
    {
    	sugar_die($app_strings['ERROR_NO_RECORD']);
    }
}
else {
	header("Location: index.php?module=TimePeriods&action=DetailView&return_id=".$_REQUEST['return_id']);
}

echo getClassicModuleTitle($mod_strings['LBL_FS_MODULE_NAME'], array($mod_strings['LBL_FS_MODULE_NAME'],$focus->get_summary_text()), true);



$GLOBALS['log']->info("Forecast Schedule Detail View");

$xtpl=new XTemplate ('modules/ForecastSchedule/DetailView.html');
$focus->format_all_fields();
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);
$xtpl->assign("GRIDLINE", $gridline);
$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
$xtpl->assign("ID", $focus->id);
if (isset($_REQUEST['return_module'])) {
	$xtpl->assign("RETURN_MODULE", $_REQUEST['return_module']);
} else {
	$xtpl->assign("RETURN_MODULE", "TimePeriods");
}
if (isset($_REQUEST['return_action'])) {
	$xtpl->assign("RETURN_ACTION", $_REQUEST['return_action']);
} else {
	$xtpl->assign("RETURN_ACTION", "DetailView");
}
$xtpl->assign("RETURN_ID", $focus->timeperiod_id);  //return_id is the timeperiod_id

$comm = new Common();
$comm->set_current_user($focus->user_id);
$comm->get_timeperiod_start_end_date($focus->timeperiod_id);

$xtpl->assign("TIMEPERIOD_NAME", $comm->timeperiod_name);
$xtpl->assign("START_DATE", $comm->start_date);
$xtpl->assign("END_DATE", $comm->end_date);

$xtpl->assign("FORECAST_START_DATE", $focus->forecast_start_date);
$xtpl->assign("STATUS", $focus->status);
$xtpl->assign("USER_NAME",$comm->get_user_name($focus->user_id));

if ($focus->cascade_hierarchy  == '1') {
	$xtpl->assign("CASCADE_HIERARCHY","Checked");
}

global $current_user;
if(is_admin($current_user) && $_REQUEST['module'] != 'DynamicLayout' && !empty($_SESSION['editinplace'])){	
	$xtpl->assign("ADMIN_EDIT","<a href='index.php?action=index&module=DynamicLayout&from_action=".$_REQUEST['action'] ."&from_module=".$_REQUEST['module'] ."&record=".$_REQUEST['record']. "&mod_lang=Teams'>".SugarThemeRegistry::current()->getImage("EditLayout","border='0' align='bottom'", null,null,'.gif',$mod_strings['LBL_EDIT_LAYOUT'])."</a>");
}
$xtpl->parse("main");
$xtpl->out("main");
?>