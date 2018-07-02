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

require_once('modules/ForecastSchedule/Forms.php');
require_once('modules/Forecasts/Common.php');

$admin = Administration::getSettings("notify");

global $app_strings;
global $app_list_strings;
global $mod_strings;

if (!isset($_REQUEST['record'])) $_REQUEST['record'] = "";
if (!is_admin($current_user)&& !is_admin_for_module($current_user,'ForecastSchedule')
    && !is_admin_for_module($current_user,'Forecasts') && $_REQUEST['record'] != $current_user->id) {
        sugar_die("Unauthorized access to administration.");
}

$focus = BeanFactory::getBean('ForecastSchedule', $_REQUEST['record']);

//if duplicate record request then clear the Primary key(id) value.
if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == '1') {
	$focus->id = "";
}

echo getClassicModuleTitle($mod_strings['LBL_FS_MODULE_NAME'], array($mod_strings['LBL_FS_MODULE_NAME'],$_REQUEST['timeperiod_name']), true);


$GLOBALS['log']->info("Forecast Schedule Edit view");
$xtpl=new XTemplate ('modules/ForecastSchedule/EditView.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);

if (isset($_REQUEST['error_string'])) $xtpl->assign("ERROR_STRING", "<span class='error'>Error: ".$_REQUEST['error_string']."</span>");
if (isset($_REQUEST['return_module'])) $xtpl->assign("RETURN_MODULE", "TimePeriods");
if (isset($_REQUEST['return_action'])) $xtpl->assign("RETURN_ACTION", "DetailView");
if (isset($_REQUEST['return_id'])) $xtpl->assign("RETURN_ID", $_REQUEST['return_id']);
$xtpl->assign("JAVASCRIPT", get_validate_record_js().get_set_focus_js());
$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);

$comm = new Common();
$comm->get_timeperiod_start_end_date($_REQUEST['return_id']);

$xtpl->assign("TIMEPERIOD_ID", $_REQUEST['return_id']);
$xtpl->assign("TIMEPERIOD_NAME", $comm->timeperiod_name);
$xtpl->assign("START_DATE", $comm->start_date);
$xtpl->assign("END_DATE", $comm->end_date);
$xtpl->assign("FORECAST_START_DATE", $focus->forecast_start_date);
$xtpl->assign("STATUS_OPTIONS", get_select_options_with_id($app_list_strings['forecast_schedule_status_dom'], $focus->status));

if(isset($_REQUEST['record'])) {
	$xtpl->assign("ID", $_REQUEST['record']);
}

global $timedate;
$xtpl->assign("CALENDAR_DATEFORMAT", $timedate->get_cal_date_format());
$xtpl->assign("USER_DATEFORMAT", '('. $timedate->get_user_date_format().')');

$xtpl->assign("USER_OPTIONS", get_select_options_with_id(get_user_array(TRUE, "Active", $focus->user_id), $focus->user_id));
if ($focus->cascade_hierarchy  == '1') {
	$xtpl->assign("CASCADE_HIERARCHY","Checked");
}
$xtpl->assign("THEME", SugarThemeRegistry::current()->__toString());

if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == '1') {
	$xtpl->assign("IS_DUPLICATE", "1");
}
$xtpl->parse("main");
$xtpl->out("main");

?>
