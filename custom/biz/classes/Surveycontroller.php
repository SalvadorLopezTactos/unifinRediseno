<?php

/**
 * The file used to handle layout actions
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
require_once 'include/utils.php';
require_once 'custom/biz/classes/Surveyutils.php';
require_once 'modules/ModuleBuilder/parsers/parser.label.php';
require_once 'modules/ModuleBuilder/Module/StudioModuleFactory.php';
require_once 'modules/ModuleBuilder/parsers/views/GridLayoutMetaDataParser.php';

class Surveycontroller {

    /**
     * Description :: This function is used to check license validation.
     * 
     * @return bool '$result' - 1 - license validated
     *                          0 - license not validated
     */
    function validateLicense() {
        // get validate license status
        $key = $_REQUEST['k'];
        $CheckResult = Surveyutils::checkPluginLicense($key);
        return $CheckResult;
    }

    /**
     * Description :: This function is used to enable or disable plugin.
     * 
     * @return bool '$result' - true - plugin enabled
     */
    function enableDisableSurvey() {
        //used to enable/disable plugin
        require_once('modules/Administration/Administration.php');
        $enabled = $_REQUEST['enabled'];
        $administrationObj = new Administration();
        $administrationObj->retrieveSettings('SurveyPlugin');
        switch ($enabled) {
            case '1': //enabled
                $administrationObj->saveSetting("SurveyPlugin", "ModuleEnabled", 1);
                $administrationObj->saveSetting("SurveyPlugin", "LastValidationMsg", "");
                break;
            case '0': //disabled
                $administrationObj->saveSetting("SurveyPlugin", "ModuleEnabled", 0);
                $administrationObj->saveSetting("SurveyPlugin", "LastValidationMsg", "This module is disabled, please contact Administrator.");
                break;
            default: //default is disabled
                $administrationObj->saveSetting("SurveyPlugin", "ModuleEnabled", 0);
                $administrationObj->saveSetting("SurveyPlugin", "LastValidationMsg", "This module is disabled, please contact Administrator.");
        }
        return true;
    }

    function save_surveysmtp_setting() {
        require_once('modules/Administration/Administration.php');
        $administrationObj = new Administration();
        $administrationObj->saveSetting("SurveySmtp", "survey_notify_fromname", $_REQUEST['survey_notify_fromname']);
        $administrationObj->saveSetting("SurveySmtp", "survey_notify_fromaddress", $_REQUEST['survey_notify_fromaddress']);
        $administrationObj->saveSetting("SurveySmtp", "survey_smtp_email_provider", $_REQUEST['survey_smtp_email_provider']);
        $administrationObj->saveSetting("SurveySmtp", "survey_mail_smtp_host", $_REQUEST['survey_mail_smtp_host']);
        $administrationObj->saveSetting("SurveySmtp", "survey_mail_smtpport", $_REQUEST['survey_mail_smtpport']);
        $administrationObj->saveSetting("SurveySmtp", "survey_mail_smtpssl", $_REQUEST['survey_mail_smtpssl']);
        $administrationObj->saveSetting("SurveySmtp", "survey_mail_smtp_username", $_REQUEST['survey_mail_smtp_username']);
        $administrationObj->saveSetting("SurveySmtp", "survey_mail_smtp_password", $_REQUEST['survey_mail_smtp_password']);
        $administrationObj->saveSetting("SurveySmtp", "survey_mail_smtp_retype_password", $_REQUEST['survey_mail_smtp_retype_password']);

        header("Location: index.php?module=Administration&action=index");
        exit();
    }

}