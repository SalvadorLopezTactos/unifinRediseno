<?php
/**
 * The file used to add survey configuration to admin panel 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

$admin_option_defs = array();

$admin_option_defs['Administration']['license_configuration_link'] = array(
    '',
    'LBL_SURVEY_LICENSE_CONFIGURATION',
    'LBL_SURVEY_LICENSE_CONFIGURATION_DESC',
    'index.php?module=Administration&action=surveyconfiguration'
);

$admin_option_defs['Administration']['healty_check'] = array(
    '',
    'LBL_HEALTH_CHECK',
    'LBL_HEALTH_CHECK_DESC',
    'index.php?module=Administration&action=health_check'
);

$admin_option_defs['Administration']['survey_automizer'] = array(
    '',
    'LBL_SURVEY_AUTOMIZER',
    'LBL_SURVEY_AUTOMIZER_DESC',
    'javascript:parent.SUGAR.App.router.navigate("bc_survey_automizer", {trigger: true});'
);
$admin_option_defs['Administration']['survey_smtp'] = array(
    '',
    'LBL_SURVEY_SMTP_SETTING',
    'LBL_SURVEY_SMTP_SETTING_DESC',
    'index.php?module=Administration&action=surveysmtp'
);

$admin_group_header[] = array(
    'LBL_SURVEY_CONF_TITLE',
    '',
    false,
    $admin_option_defs,
    'LBL_SURVEY_LICENSE_CONFIGURATION_TITLE'
);