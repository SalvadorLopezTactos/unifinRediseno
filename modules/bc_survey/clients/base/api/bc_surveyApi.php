<?php

/**
 * The file used to set custom api related to survey actions
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


require_once 'clients/base/api/ModuleApi.php';
require_once 'data/BeanFactory.php';
require_once('custom/biz/classes/Surveyutils.php');
require_once 'custom/include/utilsfunction.php';
include_once 'custom/include/pagination.class.php';


class bc_surveyApi extends ModuleApi {

    public function registerApiRest() {
        return array(
            'get_report' => array(
                'reqType' => 'POST',
                'path' => array('bc_survey', 'get_report'),
                'pathVars' => array('', ''),
                'method' => 'get_report',
                'shortHelp' => 'Get reports for survey status',
                'longHelp' => '',
            ),
            'get_export_report' => array(
                'reqType' => 'POST',
                'path' => array('bc_survey', 'get_export_report'),
                'pathVars' => array('', ''),
                'method' => 'get_export_report',
                'shortHelp' => 'Get reports for survey status',
                'longHelp' => '',
            ),
            'makeQuestionWiseExportContent' => array(
                'reqType' => 'POST',
                'path' => array('bc_survey', 'makeQuestionWiseExportContent'),
                'pathVars' => array('', ''),
                'method' => 'makeQuestionWiseExportContent',
                'shortHelp' => 'Get reports for survey status',
                'longHelp' => '',
            ),
            'save_survey' => array(
                'reqType' => 'POST',
                'path' => array('bc_survey', 'save_survey'),
                'pathVars' => array('', ''),
                'method' => 'save_survey',
                'shortHelp' => 'Save Survey Record to database',
                'longHelp' => '',
            ),
            'get_survey' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'get_survey'),
                'pathVars' => array('', ''),
                'method' => 'get_survey',
                'shortHelp' => 'Get Survey Record data from database',
                'longHelp' => '',
            ),
            'save_edited_survey' => array(
                'reqType' => 'POST',
                'path' => array('bc_survey', 'save_edited_survey'),
                'pathVars' => array('', ''),
                'method' => 'save_edited_survey',
                'shortHelp' => 'Save Survey Record edited data to database',
                'longHelp' => '',
            ),
            'getIndividualPersonReport' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'getIndividualPersonReport'),
                'pathVars' => array('', ''),
                'method' => 'getIndividualPersonReport',
                'shortHelp' => 'Get Individual person report data on popup',
                'longHelp' => '',
            ),
            'getSearchResult' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'getSearchResult'),
                'pathVars' => array('', ''),
                'method' => 'getSearchResult',
                'shortHelp' => 'Get Searched result data as per criteria',
                'longHelp' => '',
            ),
            'approveRequest' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'approveRequest'),
                'pathVars' => array('', ''),
                'method' => 'approveRequest',
                'shortHelp' => 'Approve resend request',
                'longHelp' => '',
            ),
            'GetSurveys' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'GetSurveys'),
                'pathVars' => array('module', '', '', ''),
                'method' => 'GetSurveys',
                'shortHelp' => 'Get Survey List Of Module',
                'longHelp' => '',
            ),
            'checkEmailTemplateForSurvey' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'checkEmailTemplateForSurvey'),
                'pathVars' => array('module', '', '', ''),
                'method' => 'checkEmailTemplateForSurvey',
                'shortHelp' => 'Check Email Template Exist For Survey',
                'longHelp' => '',
            ),
            'SendSurveyEmail' => array(
                'reqType' => 'POST',
                'path' => array('bc_survey', '?', 'SendSurveyEmail'),
                'pathVars' => array('', ''),
                'method' => 'SendSurveyEmail',
                'shortHelp' => 'Send Survey Email',
                'longHelp' => '',
            ),
            'SendImmediateEmail' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'SendImmediateEmail'),
                'pathVars' => array('module', '', '', '', '', '', ''),
                'method' => 'SendImmediateEmail',
                'shortHelp' => 'Send Survey Email immediate after send button clicked in record view',
                'longHelp' => '',
            ),
            'openSummaryDetailView' => array(
                'reqType' => 'POST',
                'path' => array('bc_survey', '?', 'openSummaryDetailView'),
                'pathVars' => array('', 'survey_id', ''),
                'method' => 'openSummaryDetailView',
                'shortHelp' => 'Open Summary Detail View Of Sent Survey Customers',
                'longHelp' => '',
            ),
            'GetSurveyTemplates' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'GetSurveyTemplates'),
                'pathVars' => array('module', '', '', ''),
                'method' => 'GetSurveyTemplates',
                'shortHelp' => 'Get Survey Template List Of Module for creating new survey from it while sending survey from list view',
                'longHelp' => '',
            ),
            'SendSurveyReminder' => array(
                'reqType' => 'POST',
                'path' => array('bc_survey', '?', 'SendSurveyReminder'),
                'pathVars' => array('', 'surveyID', ''),
                'method' => 'SendSurveyReminder',
                'shortHelp' => 'Send Survey Reminder Email',
                'longHelp' => '',
            ),
            'checkingLicenseStatus' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'checkingLicenseStatus'),
                'pathVars' => array('', ''),
                'method' => 'checkingLicenseStatus',
                'shortHelp' => 'check license is validated or not',
                'longHelp' => '',
            ),
            'exportToExcel' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'exportToExcel'),
                'pathVars' => array('', ''),
                'rawReply' => true,
                'allowDownloadCookie' => true,
                'method' => 'exportToExcel',
                'shortHelp' => 'export result data to excel',
                'longHelp' => '',
            ),
            'isSurveySend' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'isSurveySend'),
                'pathVars' => array('', ''),
                'method' => 'isSurveySend',
                'shortHelp' => 'check that survey is send or not',
                'longHelp' => '',
            ),
            'getSurveyURL' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'getSurveyURL'),
                'pathVars' => array('', ''),
                'method' => 'getSurveyURL',
                'shortHelp' => 'Get Survey URL for attending survey on behalf of customer',
                'longHelp' => '',
            ),
            'getResubmissionStatus' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'getResubmissionStatus'),
                'pathVars' => array('', ''),
                'method' => 'getResubmissionStatus',
                'shortHelp' => 'Get Resubmission Status that survey status for resubmission is on or not',
                'longHelp' => '',
            ),
            'getTargetRelatedtoForSubmission' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'getTargetRelatedtoForSubmission'),
                'pathVars' => array('', ''),
                'method' => 'getTargetRelatedtoForSubmission',
                'shortHelp' => 'Get target parent name of submission',
                'longHelp' => '',
            ),
            'delete_transaction' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'delete_transaction'),
                'pathVars' => array('', ''),
                'method' => 'delete_transaction',
                'shortHelp' => 'Delete Survey Transaction from Individual Report',
                'longHelp' => '',
            ),
            'get_survey_language' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'get_survey_language'),
                'pathVars' => array('', ''),
                'method' => 'get_survey_language',
                'shortHelp' => 'Get Survey Default and Supported Language',
                'longHelp' => '',
            ),
            'save_new_language' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'save_new_language'),
                'pathVars' => array('', ''),
                'method' => 'save_new_language',
                'shortHelp' => 'Save new survey language to supported survey language Language',
                'longHelp' => '',
            ),
            'remove_language' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'remove_language'),
                'pathVars' => array('', ''),
                'method' => 'remove_language',
                'shortHelp' => 'Remove  Language',
                'longHelp' => '',
            ),
            'save_default_language' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'save_default_language'),
                'pathVars' => array('', ''),
                'method' => 'save_default_language',
                'shortHelp' => 'Save default  Language',
                'longHelp' => '',
            ),
            'get_survey_detail_to_translate_lang' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'get_survey_detail_to_translate_lang'),
                'pathVars' => array('', ''),
                'method' => 'get_survey_detail_to_translate_lang',
                'shortHelp' => 'Get Survey Detail to translate in selected Language',
                'longHelp' => '',
            ),
            'save_language_translation' => array(
                'reqType' => 'POST',
                'path' => array('bc_survey', 'save_language_translation'),
                'pathVars' => array('', ''),
                'method' => 'save_language_translation',
                'shortHelp' => 'Save Language translation',
                'longHelp' => '',
            ),
            'generate_unique_survey_submit_id' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'generate_unique_survey_submit_id'),
                'pathVars' => array('', ''),
                'method' => 'generate_unique_survey_submit_id',
                'shortHelp' => 'Get Survey Submit Unique id to make survey open URL',
                'longHelp' => '',
            ),
            'get_sync_module_fields' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'get_sync_module_fields'),
                'pathVars' => array('', ''),
                'method' => 'get_sync_module_fields',
                'shortHelp' => 'Get Sync Module Fields for Data Piping',
                'longHelp' => '',
            ),
            'compare_survey_field_with_module_field' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'compare_survey_field_with_module_field'),
                'pathVars' => array('', ''),
                'method' => 'compare_survey_field_with_module_field',
                'shortHelp' => 'Compare Sync Module Fields type with Survey Question type',
                'longHelp' => '',
            ),
            'retrieve_all_module_field_required_status' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'retrieve_all_module_field_required_status'),
                'pathVars' => array('', ''),
                'method' => 'retrieve_all_module_field_required_status',
                'shortHelp' => 'Retrieve sync field is required or not',
                'longHelp' => '',
            ),
            'validateLicense' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'validateLicense'),
                'pathVars' => array('', ''),
                'method' => 'validateLicense',
                'shortHelp' => 'Validate License for Survey Rocket Plugin',
                'longHelp' => '',
            ),
            'enableDisableSurvey' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'enableDisableSurvey'),
                'pathVars' => array('', ''),
                'method' => 'enableDisableSurvey',
                'shortHelp' => 'Enable or Disable Survey Rocket Plugin',
                'longHelp' => '',
            ),
            'save_surveysmtp_setting' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'save_surveysmtp_setting'),
                'pathVars' => array('', ''),
                'method' => 'save_surveysmtp_setting',
                'shortHelp' => 'Survey Custom SMTP setting',
                'longHelp' => '',
            ),
            // Survey Status :: LoadedTech Customization
            'change_survey_status' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'change_survey_status'),
                'pathVars' => array('', ''),
                'method' => 'change_survey_status',
                'shortHelp' => 'Change survey status',
                'longHelp' => '',
            ),
            'openMutliChartOptionsModel' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'openMutliChartOptionsModel'),
                'pathVars' => array('module', ''),
                'method' => 'openMutliChartOptionsModel',
                'shortHelp' => 'Open Popup To Choose Chart Option',
                'longHelp' => '',
            ),
            'getAllSurveyQuestions' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'getAllSurveyQuestions'),
                'pathVars' => array('', ''),
                'method' => 'getAllSurveyQuestions',
                'shortHelp' => 'Retrieve all questions for Question Logic',
                'longHelp' => '',
            ),
            'generateQueLogicSection' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'generateQueLogicSection'),
                'pathVars' => array('', ''),
                'method' => 'generateQueLogicSection',
                'shortHelp' => 'Generate section for Question Logic',
                'longHelp' => '',
            ),
            'generateIndividualHistory' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey', 'generateIndividualHistory'),
                'pathVars' => array('', ''),
                'method' => 'generateIndividualHistory',
                'shortHelp' => 'Generate section for Individual History',
                'longHelp' => '',
            ),
        );
    }

    function openMutliChartOptionsModel($api, $args) {
        $chartArrayOnQType = array(
            'netpromoterscore' => array(
                'npsgaugechart' => array('title' => 'Meter Gauge', 'src' => 'custom/include/images/npsgaugechart.png'),
                'piechart' => array('title' => 'Pie Chart', 'src' => 'custom/include/images/piechart.png'),
                'npsbarchart' => array('title' => 'Bar Chart', 'src' => 'custom/include/images/npsbarchart.png'),
                'columnchart' => array('title' => 'Column Chart', 'src' => 'custom/include/images/columnchart.png'),
                'linechart' => array('title' => 'Line Chart', 'src' => 'custom/include/images/linechart.png'),
            ),
            'matrix' => array(
                'barchart' => array('title' => 'Bar Chart', 'src' => 'custom/include/images/barchart.png'),
                'columnchart' => array('title' => 'Column Chart', 'src' => 'custom/include/images/columnchart.png'),
                'stackedcolumnchart' => array('title' => 'Stacked Column Chart', 'src' => 'custom/include/images/stackedcolumnchart.png'),
                'stackedbarchart' => array('title' => 'Stacked Bar Chart', 'src' => 'custom/include/images/stackedbarchart.png'),
                'groupcolumnchart' => array('title' => 'Group Column Chart', 'src' => 'custom/include/images/groupcolumnchart.png'),
            ),
            'other' => array(
                'piechart' => array('title' => 'Pie Chart', 'src' => 'custom/include/images/piechart.png'),
                'barchart' => array('title' => 'Bar Chart', 'src' => 'custom/include/images/barchart.png'),
                'columnchart' => array('title' => 'Column Chart', 'src' => 'custom/include/images/columnchart.png'),
                'linechart' => array('title' => 'Line Chart', 'src' => 'custom/include/images/linechart.png'),
            ),
            'check-box' => array(
                'barchart' => array('title' => 'Bar Chart', 'src' => 'custom/include/images/barchart.png'),
                'columnchart' => array('title' => 'Column Chart', 'src' => 'custom/include/images/columnchart.png'),
                'linechart' => array('title' => 'Line Chart', 'src' => 'custom/include/images/linechart.png'),
            ),
            'multiselectlist' => array(
                'barchart' => array('title' => 'Bar Chart', 'src' => 'custom/include/images/barchart.png'),
                'columnchart' => array('title' => 'Column Chart', 'src' => 'custom/include/images/columnchart.png'),
                'linechart' => array('title' => 'Line Chart', 'src' => 'custom/include/images/linechart.png'),
            ),
        );
        $questionID = $args['questionID'];
        $que_type = $args['queType'];
        $reportType = $args['reportType'];
        if ($que_type != 'matrix' && $que_type != 'netpromoterscore' && $que_type != 'check-box' && $que_type != 'multiselectlist') {
            $que_type = 'other';
        }
        $htmlContent = "<div class='bottom' id='switchChartModel' style='border: solid 2px grey;'>
                            <div style='float: right;top: -13px;position: relative;left: 21px;'><img style='cursor: pointer;' id='closeSwitchChartModel' width='30px' src='custom/include/images/close.png' /></div>
                            <div style=''><h4>Chart Type</h4></div>
                            <div><br/></div>
                            <div id='different_charts' style='margin-top:-12px;margin-left:8px;'>";
        foreach ($chartArrayOnQType[$que_type] as $chartType => $qContent) {
            $title = $qContent['title'];
            $src = $qContent['src'];
            $htmlContent .= "<div title='{$title}' style='cursor: pointer;display:inline;font-size: 14px;margin-right: 10px;' class='swichChart' id='icon_{$questionID}_{$reportType}_{$chartType}'>";
            $htmlContent .= "<img src='{$src}' style='margin-left: 5px;height: 16px;width: 16px;'>";
            $htmlContent .= " </div>";
        }
        $htmlContent .= "</div><div style='margin-top: 10px;border-bottom: 2px solid #dddddd;'></div>";
        $htmlContent .= "<div style='display: inline-flex;'><h4>Show Stats</h4><input class='toggleStatsTable' style='margin-left: 90px;margin-top: 14px;position: absolute;' type='checkbox' id='stats_{$questionID}_{$reportType}' /></div>";
        $htmlContent .= "</div>";
        return $htmlContent;
    }

    function makeQuestionWiseExportContent($api, $args) {
        global $db;
        $exportReport = $args['exportReport'];
        $survey_id = $args['survey_id'];
        $gffilterData = json_decode($args['JsonGfData'], true);
        $oSurvey = new bc_survey();
        $oSurvey->retrieve($survey_id);
        $surveyName = $oSurvey->name;
        $exportAS = $args['exportAS'];
        $survey_type = $args['status_type'];
        $questionPDFData = json_decode($args['questionPDFData'], true);
        $fromIndividualQuestion = (isset($args['fromIndividualQuestion'])) ? $args['fromIndividualQuestion'] : false;
        $qID = (isset($args['qID'])) ? $args['qID'] : '';
        $selectedRangeVal = json_decode(html_entity_decode($args['selectedRangeVal']), true);
        $GF_saved_question_logic = array();
// Global Filter :: Start
        $gf_filter_by = isset($gffilterData['gf_filter_by']) ? $gffilterData['gf_filter_by'] : '';
        if (in_array($gf_filter_by, array('by_date', 'by_question_logic'))) {

            if (!empty($gffilterData['gf_start_date'])) {
                $gf_start_date = TimeDate::getInstance()->to_db_date($gffilterData['gf_start_date'], false);
            }
            if (!empty($gffilterData['gf_end_date'])) {
                $gf_end_date = TimeDate::getInstance()->to_db_date($gffilterData['gf_end_date'], false);
            }

            if (empty($gf_end_date) && !empty($gf_start_date)) {
                $gf_end_date = date('Y-m-d'); // Take current date as End Date to retrieve result of filter by date
            }
            if (empty($gf_start_date) && !empty($gf_end_date)) {
                $gf_start_date = date("Y-m-d", strtotime($oSurvey->date_entered)); // Take survey created date as Start Date to retrieve result of filter by date 
            }
            $global_filter = array('gf_filter_by' => 'by_date', 'gf_start_date' => $gf_start_date, 'gf_end_date' => $gf_end_date);
        }
        if ($gf_filter_by == 'by_question_logic') {

            $global_filter = array('gf_filter_by' => 'by_question_logic', 'gf_start_date' => $gf_start_date, 'gf_end_date' => $gf_end_date);
            $GF_saved_question_logic = json_decode($gffilterData['GF_saved_question_logic']);
        }
// Global Filter :: End
        $global_filter['GF_match_case'] = $gffilterData['GF_match_case'];
        $returnData = getUserAccessibleRecordsData($survey_id, $survey_type, $gf_filter_by, $global_filter, $GF_saved_question_logic);
        if ($exportReport == 'normal') {
            $retunrChartData = exportQuestionNormalReportDataAsPDF($questionPDFData, $survey_id, $survey_type, $returnData, $surveyName, $qID, $fromIndividualQuestion,$exportAS);
        } else {
            $retunrChartData = exportQuestionTrendReportDataAsPDF($questionPDFData, $survey_id, $survey_type, $returnData, $selectedRangeVal, $surveyName, $qID, $fromIndividualQuestion,$exportAS);
        }
        return $retunrChartData;
    }

    function get_export_report($api, $args) {
        global $db;
        $exportReport = $args['exportReport'];
        $survey_id = $args['survey_id'];
        $gffilterData = json_decode($args['JsonGfData'], true);
        $oSurvey = new bc_survey();
        $oSurvey->retrieve($survey_id);
        $survey_type = $args['status_type'];
        $selectedRangeVal = json_decode(html_entity_decode($args['selectedRangeVal']), true);
        $GF_saved_question_logic = array();
// Global Filter :: Start
        $gf_filter_by = isset($gffilterData['gf_filter_by']) ? $gffilterData['gf_filter_by'] : '';
        if (in_array($gf_filter_by, array('by_date', 'by_question_logic'))) {

            if (!empty($gffilterData['gf_start_date'])) {
                $gf_start_date = TimeDate::getInstance()->to_db_date($gffilterData['gf_start_date'], false);
            }
            if (!empty($gffilterData['gf_end_date'])) {
                $gf_end_date = TimeDate::getInstance()->to_db_date($gffilterData['gf_end_date'], false);
            }

            if (empty($gf_end_date) && !empty($gf_start_date)) {
                $gf_end_date = date('Y-m-d'); // Take current date as End Date to retrieve result of filter by date
            }
            if (empty($gf_start_date) && !empty($gf_end_date)) {
                $gf_start_date = date("Y-m-d", strtotime($oSurvey->date_entered)); // Take survey created date as Start Date to retrieve result of filter by date 
            }
            $global_filter = array('gf_filter_by' => 'by_date', 'gf_start_date' => $gf_start_date, 'gf_end_date' => $gf_end_date);
        }
        if ($gf_filter_by == 'by_question_logic') {

            $global_filter = array('gf_filter_by' => 'by_question_logic', 'gf_start_date' => $gf_start_date, 'gf_end_date' => $gf_end_date);
            $GF_saved_question_logic = json_decode($gffilterData['GF_saved_question_logic']);
        }
// Global Filter :: End
        $global_filter['GF_match_case'] = $gffilterData['GF_match_case'];
        $returnData = getUserAccessibleRecordsData($survey_id, $survey_type, $gf_filter_by, $global_filter, $GF_saved_question_logic);
        $accesible_submissions = $returnData['accesible_submissions'];
        $total_submitted = $returnData['total_send_survey'];
        if ($exportReport == 'normal') {
            $retunrChartData = getQuestionWiseExportReportData($survey_id, $survey_type, $total_submitted, $accesible_submissions, '', false);
        } else {
            $retunrChartData = getQuestionWiseTrendExportReportData($survey_id, $survey_type, $accesible_submissions, $selectedRangeVal, '', false);
        }
        return $retunrChartData;
    }

    public function get_report($api, $args) {
        require_once 'custom/include/utilsfunction.php';
        $survey_id = $args['survey_id'];
        global $db, $current_user, $app_list_strings, $sugar_config;
        $datef = $current_user->getPreference('datef');
        $timef = $current_user->getPreference('timef');
        $type = $args['status'];
        $submissionTypeArray = array();
        if (isset($args['status_type']) && $args['status_type'] == 'email') {
            $status_type = 'email';
            $submissionTypeArray = array('Email');
        } else if (isset($args['status_type']) && $args['status_type'] == 'openended') {
            $status_type = 'openended';
            $submissionTypeArray = array('Open Ended');
        } else {
            $status_type = 'combined';
            $submissionTypeArray = array('Email', 'Open Ended');
        }

        $submissionTypeImplodeVal = implode("','", $submissionTypeArray);

        $multi_data_array = array(); // store value of  bar chart
        $chart_ids = array();
        $scale_chart_ids = array();
        $matrix_chart_ids = array();
        $matrix_chart_colors = array();
        $chart_display_data = array();
        $pie_chart_colors = array();
        $counter_display_matrix = array();
        $statsDataArray = array();

        $page = isset($args['page']) ? $args['page'] : 1;

        $oSurvey = new bc_survey();
        $oSurvey->retrieve($survey_id);
        $created_by_id = $oSurvey->created_by;
        $chartColor = array("#02c2da", "#3b4fbc", "#f12765", "#9c27b0", "#f3b221", "#8daf26", "#93451a", "#ff4e00", "#ff9800",
            "#494763", "#279688", "#fd767e", "#a7e13a", "#31588a", "#0962ea", "#4fc1e9", "#12d6c5", "#b7d083", "#bf8df2", "#aee7e5", "#9b9fce",
            "#828e50", "#cafb8b", "#d46a67", "#e98998", "#f2d27f", "#c86833", "#30a7bc", "#0579c1", "#ff312d", "#e89788", "#fd3262", "#edb195",
            "#2aa7c9", "#e5ee2f", "#8cd0e5", "#de786a", "#f8b976", "#2dde98", "#ff6c5f", "#fc4309", "#ff765c", "#ffb646", "#ff9900", "#ff6600",
            "#ffd55d", "#ff7c81", "#c0f6d2", "#a2e4f5", "#f5b697");

        $survey_start_date = ($oSurvey->start_date !== '') ? date("Y-m-d", strtotime($oSurvey->start_date)) : '';
        $survey_end_date = ($oSurvey->end_date !== '') ? date("Y-m-d", strtotime($oSurvey->end_date)) : '';
        $GF_saved_question_logic = array();
        // Global Filter :: Start
        $gf_filter_by = isset($args['gf_filter_by']) ? $args['gf_filter_by'] : '';
        if (in_array($gf_filter_by, array('by_date', 'by_question_logic'))) {

            if (!empty($args['gf_start_date'])) {
                $gf_start_date = TimeDate::getInstance()->to_db_date($args['gf_start_date'], false);
            }
            if (!empty($args['gf_end_date'])) {
                $gf_end_date = TimeDate::getInstance()->to_db_date($args['gf_end_date'], false);
            }

            if (empty($gf_end_date) && !empty($gf_start_date)) {
                $gf_end_date = date('Y-m-d'); // Take current date as End Date to retrieve result of filter by date
            }
            if (empty($gf_start_date) && !empty($gf_end_date)) {
                $gf_start_date = date("Y-m-d", strtotime($oSurvey->date_entered)); // Take survey created date as Start Date to retrieve result of filter by date 
            }
            $global_filter = array('gf_filter_by' => 'by_date', 'gf_start_date' => $gf_start_date, 'gf_end_date' => $gf_end_date);
        }
        if ($gf_filter_by == 'by_question_logic') {

            $global_filter = array('gf_filter_by' => 'by_question_logic', 'gf_start_date' => $gf_start_date, 'gf_end_date' => $gf_end_date);
            $GF_saved_question_logic = json_decode($args['GF_saved_question_logic']);
        }
        $global_filter['GF_match_case'] = $args['GF_match_case'];
        // Global Filter :: End
        //get total of send out survey
        $returnData = getUserAccessibleRecordsData($survey_id, $status_type, $gf_filter_by, $global_filter, $GF_saved_question_logic);
        $accesible_submissions = $returnData['accesible_submissions'];
        $accesible_submissionsAll = $returnData['accesible_submissionsAll'];
        $total_send_survey = $returnData['total_send_survey'];
        // Role Compatibility :: END
        $GF_QueLogic_Passed_Submissions = array_unique($accesible_submissions);
        $accesible_submissionsAll = array_unique($accesible_submissionsAll);

        $survey = getReportData($type, $survey_id, '', '', '', '', '', '', $status_type, '', '', $page, '', $accesible_submissionsAll);

        $details = array();
        $que_details = array();
        $name = array();
        $rating = "";
        $rating_final_count_array = array();
        $rating_final_percent_array = array();
        $rating_pecent = array();
        $rating_final_pecent = array();
        $statsSubmittedAnsSeqNumArray = array();
        $statsSubmittedAnsCountArray = array();
        $rating_count = array();
        $flag = 0; // to set layout of question wise report while multi select data

        $total_submitted_que = $total_send_survey;

        $trendsStatusReportDataArray = array();
        if ($type == 'status') {
            $trendsStatusReportDataArray = getTrendWiseSubmissionData($survey_id, $status_type, $GF_QueLogic_Passed_Submissions);
            $lineChart = getLineChart($survey_id, $status_type, $accesible_submissionsAll);
            foreach ($lineChart as $k => $dataMax) {
                if ($k != 0) {
                    $max_find_array[] = $dataMax[1];
                    $max_find_array[] = $dataMax[2];
        }
            }
            $maxStatusDataCount = max($max_find_array);
        }

        $trendsQuestionReportDataArray = array();
        // Get count of each answer in total submission by customer
        if ($type == 'question') {
            $trendsQuestionReportDataArray = getTrendQuestionWiseSubmissionData($survey_id, $status_type, $GF_QueLogic_Passed_Submissions);
            // $answerSubmissionCount = getAnswerSubmissionCount($survey_id, $status_type, $global_filter, $GF_QueLogic_Passed_Submissions);
            $AnsweredAndSkippedPerson = getAnswerSubmissionAnsweredAndSkipped($survey_id, $status_type, $total_submitted_que, $global_filter, $GF_QueLogic_Passed_Submissions);
        }
        // End 
        $page = isset($args['page']) ? $args['page'] : 1;
        if ($type == 'status') {
            $status_response = array('name' => $oSurvey->name, 'status_report_detail' => $survey, 'survey_start_date' => $survey_start_date, 'survey_end_date' => $survey_end_date);
        }
        $final_matrix_rowCount = array();
        $multi_data_forNPS = array();
        $multi_data_forBarColMatrix = array();
        if ($type == 'question') {
            $multi_data_array = array(); // store value of  bar chart

            $contactAnswered = 0;
            $matrixAnsweredPerson = 0;
            // order in question sequence
            $que_seqList = array();
            $otherPageQue = array();
            foreach ($survey as $qId => $qData) {
                if ($page == $qData[1]) {
                    $que_seqList[$qData[4]] = $qId;
                } else {
                    //   $otherPageQue[] = $qId;
                }
            }
            ksort($que_seqList);
            $orderedSurvey = array();
            // $counter = 0;
            // re create ordered list for question sequence wise data
            foreach ($que_seqList as $queSeq => $orderedqueID) {
                //  $counter++;
                $orderedSurvey[$orderedqueID] = $survey[$orderedqueID];
            }
            // add other pages for pagination
            foreach ($otherPageQue as $queSeqOther => $otherqueID) {
                //  $counter++;
                $orderedSurvey[$otherqueID] = $survey[$otherqueID];
            }
            $totalPages = 1;
            $rating = array();
            $final_matrix_rowCount = array();
            foreach ($orderedSurvey as $que_id => $question_name) {
                $oQuestion = BeanFactory::getBean('bc_survey_questions', $que_id);
                if ($oQuestion->question_type != 'section-header') {

                    if ($oQuestion->question_type != 'image' && $oQuestion->question_type != 'video' && $oQuestion->question_type != 'additional-text') {
                        $matrix_rows[$que_id] = !empty($oQuestion->matrix_row) ? json_decode(base64_decode($oQuestion->matrix_row)) : '';
                        $matrix_cols[$que_id] = !empty($oQuestion->matrix_col) ? json_decode(base64_decode($oQuestion->matrix_col)) : '';

                        $rating_final_count = array();
                        $page_seq = $question_name[1];
                        $details['page_title'][$page_seq] = $question_name[3];
                        $details[$que_id]['page_id'] = $page_seq;
                        $details[$que_id]['name'] = $question_name[0];
                        $details[$que_id]['que_seq'] = $question_name[4];
                        $totalPages = $question_name[5];

                        //Scoring is there or not
                        $details[$que_id]['enable_scoring'] = $oQuestion->enable_scoring;

                        $details[$que_id]['que_type'] = $oQuestion->question_type;
                        //calculated total count of submited question options
                        $getSubQ = "SELECT
                                    COUNT(*) AS total_submitted_que
                                  FROM
                                    bc_survey_submit_answer_calculation
                                    left join bc_survey_submission on bc_survey_submission.id = bc_survey_submit_answer_calculation.submission_id
                                    and bc_survey_submission.deleted = 0
                                  WHERE
                                    bc_survey_submission.deleted = 0 
                                    AND bc_survey_submit_answer_calculation.question_id = '{$que_id}'
                                    and bc_survey_submission.status = 'Submitted' and bc_survey_submission.submission_type in ('{$submissionTypeImplodeVal}')
                                  GROUP BY
                                    bc_survey_submit_answer_calculation.question_id ";
                        $runQ = $db->query($getSubQ);
                        $tSubmissionQ = $db->fetchByAssoc($runQ);
                        $answerSubmissionCount = array();
                        if (!in_array($oQuestion->question_type, array('commentbox', 'textbox', 'contact-information', 'date-time'))) {
                            $answerSubmissionCount = getAnswerSubmissionCount($survey_id, $status_type, $global_filter, $GF_QueLogic_Passed_Submissions, $que_id);
                        }
                        $total_submitted_que = (empty($tSubmissionQ['total_submitted_que'])) ? 0 : $tSubmissionQ['total_submitted_que'];
                        $details[$que_id]['total_answer_count'] = $total_submitted_que;

                        $details[$que_id]['total'] = $total_send_survey;

                        $oQuestion->load_relationship('bc_survey_answers_bc_survey_questions');
                        $answer_objects = $oQuestion->get_linked_beans('bc_survey_answers_bc_survey_questions', 'bc_survey_answers');

                        $individual_question_score = array();
                        foreach ($answer_objects as $answer_object) {
                            if ($oQuestion->is_image_option) {
                                $details[$que_id]['answers'][$answer_object->answer_sequence]['ans_name'] = '<span onmouseout="hideImage(this)" onmouseover="showImage(this)" id="optionimageSP_' . $answer_object->id . '"  class="option_image"><img src="' . $answer_object->radio_image . '" style="width:30px;height:30px;"></span><span class="ans-lbl" style="margin-left: 5px;margin-top: 3px;vertical-align: -webkit-baseline-middle;">' . $answer_object->answer_name . '</span>';
                                $details[$que_id]['answers'][$answer_object->answer_sequence]['ans_image'] = '<div style="display:none;z-index: 1;padding: 8px;border: 1px solid #dddddd;background: white;"  class="hover-img" id="hover_' . $answer_object->id . '" ><img width="200" height="200" src="' . $answer_object->radio_image . '"></div>';
                            } else {
                                $details[$que_id]['answers'][$answer_object->answer_sequence]['ans_name'] = $answer_object->answer_name;
                                $details[$que_id]['answers'][$answer_object->answer_sequence]['ans_image'] = '';
                            }
                            //// get submitted data
                            //calculated total submited person of survey

                            if (!in_array($oQuestion->question_type, array('commentbox', 'textbox', 'contact-information', 'date-time'))) {
                                if (!isset($answerSubmissionCount[$answer_object->id])) {
                                    $answerSubmissionCount[$answer_object->id] = 0;
                                }

                                $details[$que_id]['answers'][$answer_object->answer_sequence]['sub_ans'] = (isset($answerSubmissionCount[$answer_object->id])) ? $answerSubmissionCount[$answer_object->id] : 0;

                                $details[$que_id]['answers'][$answer_object->answer_sequence]['percent'] = number_format(($answerSubmissionCount[$answer_object->id] * 100) / ((empty($AnsweredAndSkippedPerson[$que_id]['answered']) || $AnsweredAndSkippedPerson[$que_id]['answered'] == 0 || $AnsweredAndSkippedPerson[$que_id]['answered'] == '0') ? 1 : $AnsweredAndSkippedPerson[$que_id]['answered']), 2);
                                // store individual response score for each answer
                                if ($answerSubmissionCount[$answer_object->id] > 0) {
                                    $individual_question_score[$answer_object->id] = (float) $answer_object->score_weight * $answerSubmissionCount[$answer_object->id];
                                }
                                $details[$que_id]['answers'][$answer_object->answer_sequence]['weight'] = $answer_object->score_weight;
                                $details[$que_id]['answers'][$answer_object->answer_sequence]['answer_sequence'] = $answer_object->answer_sequence;
                            }
                        }
                        // total obtained score for each answer
                        $total_score = 0;
                        foreach ($individual_question_score as $i_score) {
                            $total_score = $total_score + $i_score;
                        }
                        // average score calculation for individual question
                        $total_submitted_queVal = ($total_submitted_que == 0) ? 1 : $total_submitted_que;
                        $details[$que_id]['average_score'] = number_format((float) $total_score / $total_submitted_queVal, 2, '.', '');
                        //base score of individual que
                        $details[$que_id]['base_score'] = $oQuestion->base_weight;


                        if (isset($details[$que_id]['answers']) && is_array($details[$que_id]['answers']))
                            ksort($details[$que_id]['answers']);
                        if (in_array($oQuestion->question_type, array('commentbox', 'textbox', 'contact-information', 'rating', 'date-time', 'scale', 'matrix', 'doc-attachment'))) {

                            $res_value_question = getQuestionWiseData($survey_id, $que_id, $oQuestion, $status_type, $page, $global_filter, $GF_QueLogic_Passed_Submissions);

                            $scale_ans_count = 0;
                            $scale_answers = array(); // storing answer name for scale type of questions for counting answers.
                            $contactAnsweredCountEach = 0;
                            if ($oQuestion->question_type == 'contact-information') {

                                if (!empty($res_value_question[$oQuestion->id])) {

                                    $contactAnsweredCountEach = 0;
                                    $contactAnswered = 0;
                                    foreach ($res_value_question[$oQuestion->id]['answers'] as $anskey => $ansvalue) {
                                        // Role Compatibility :: START
                                                    $contact_information = JSON::decode(html_entity_decode($ansvalue['answer_name']));

                                       $details[$que_id]['answers'][$anskey]['ans_name'] = $contact_information;
                                                        }
                                    }
                            } else if ($oQuestion->question_type == 'rating' && $que_id == $oQuestion->id) {
                                foreach ($res_value_question[$oQuestion->id]['answers'] as $anskey => $ansvalue) {
                                    // Role Compatibility :: START
                                                if ($anskey != '') {
                                                    $details[$que_id]['answers'][$anskey]['ans_name'] = $ansvalue['answer_name'];
                                                    $details[$que_id]['rating_answers'] = (empty($ansvalue['answer_name']) || $ansvalue['answer_name'] == null) ? 'no_ans' : 'ans';

                                                    if (!empty($oQuestion->maxsize)) {
                                                        $starCount = $oQuestion->maxsize;
                                                    } else {
                                                        $starCount = 5;
                                                    }
                                                    $details[$que_id]['max_size'] = $starCount;
                                                    if (empty($res_value_question[$oQuestion->id]['question_title'])) {
                                                        $rating_final_count[0] += 1;
                                                    } else {
                                                        if (!isset($rating_final_count[$ansvalue['answer_name']])) {
                                                            $rating_final_count[$ansvalue['answer_name']] = 1;
                                                        } else {
                                                            $rating_final_count[$ansvalue['answer_name']] = $rating_final_count[$ansvalue['answer_name']] + 1;
                                                        }
                                                    }
                                                }

                                    // Role Compatibility :: END
                                }

                                if (!empty($details[$que_id]['answers'])) {
                                    foreach ($details[$que_id]['answers'] as $k => $ans) {
                                        if (empty($ans['ans_name'])) {
                                            unset($details[$que_id]['answers'][$k]);
                                        }
                                    }
                                }
                            } else if ($oQuestion->question_type == 'scale') {
                                $scale_ans_count++;
                                if (!in_array($res_value_question[$oQuestion->id]['question_title'], $scale_answers)) {
                                    array_push($scale_answers, $res_value_question[$oQuestion->id]['question_title']);
                                    foreach ($res_value_question[$oQuestion->id]['answers'] as $anskey => $ansvalue) {
                                        // Role Compatibility :: START
                                                    if ($ansvalue['answer_name'] != '') {
                                            $details[$que_id]['answers'][$ansvalue['answer_name']]['sub_ans'] = (!is_null($ansvalue['answer_name'])) ? $answerSubmissionCount[$oQuestion->id][$ansvalue['answer_name']] : 0;
                                            $details[$que_id]['answers'][$ansvalue['answer_name']]['percent'] = number_format(($answerSubmissionCount[$oQuestion->id][$ansvalue['answer_name']] * 100) / ((empty($answerSubmissionCount['scale'][$que_id]) || $answerSubmissionCount['scale'][$que_id] == 0 || $answerSubmissionCount['scale'][$que_id] == '0') ? 1 : $answerSubmissionCount['scale'][$que_id]), 2);
                                                        $details[$que_id]['answers'][$ansvalue['answer_name']]['ans_name'] = $ansvalue['answer_name'];
                                                        $details[$que_id]['answers'][$ansvalue['answer_name']]['answer_sequence'] = $ansvalue['answer_name'] + 1;
                                                        $details[$que_id]['min'] = $oQuestion->min;
                                                        $details[$que_id]['max'] = $oQuestion->max;
                                                        $details[$que_id]['scale_slot'] = $oQuestion->scale_slot;
                                                    }

                                        // Role Compatibility :: END
                                    }
                                }
                            } else if ($oQuestion->question_type == 'matrix') {
                                $final_answers = array();
                                $answer = getAnswerSubmissionDataForMatrix($survey_id, '', $que_id, $status_type, '', $global_filter, $GF_QueLogic_Passed_Submissions);

                                foreach ($answer as $recipient => $sub_answer) {
                                    foreach ($sub_answer as $akey => $aval) {
                                        array_push($final_answers, $aval);
                                    }
                                }

                                $details[$que_id]['answers']['ans_detail'] = $final_answers;
                                $matrixAnsweredPerson = count($answer);
                                // COrrection By Govind: 
                                foreach ($res_value_question[$oQuestion->id]['answers'] as $anskey => $ansvalue) {
                                    // Role Compatibility :: START
                                                $splited_value = explode('_', $ansvalue['answer_name']);
                                    $matSubData = array_sum($answerSubmissionCount['matrix'][$que_id][$splited_value[0]]);
                                    $final_matrix_rowCount[$que_id][$splited_value[0]] =$matSubData;
                                                $details[$que_id]['answers'][$ansvalue['answer_name']]['sub_ans'] = (isset($answerSubmissionCount['matrix'][$que_id])) ? $answerSubmissionCount['matrix'][$que_id] : 0;
                                                $details[$que_id]['answers'][$ansvalue['answer_name']]['percent'] = number_format(($answerSubmissionCount[$ansvalue['answer_name']] * 100) / ((empty($final_matrix_rowCount[$que_id][$splited_value[0]]) || $final_matrix_rowCount[$que_id][$splited_value[0]] == 0 || $final_matrix_rowCount[$que_id][$splited_value[0]] == '0') ? 1 : $final_matrix_rowCount[$que_id][$splited_value[0]]), 2);

                                    // Role Compatibility :: END
                                }
                                $details[$que_id]['answered'] = $matrixAnsweredPerson; // Resolved :: matrix precent count issue
                                $details[$que_id]['matrix_row'] = $matrix_rows[$que_id];
                                $details[$que_id]['matrix_col'] = $matrix_cols[$que_id];
                            } else if ($oQuestion->question_type == 'date-time') {
                                if ($oQuestion->is_datetime == 0) {
                                    foreach ($res_value_question[$oQuestion->id]['answers'] as $anskey => $ansvalue) {
                                        // Role Compatibility :: START
                                        if (!empty($ansvalue['answer_name']) && $ansvalue['answer_name'] != 'N/A' && $ansvalue['answer_name'] != 'n/a') {
                                                        $ansDate = date($datef, strtotime($ansvalue['answer_name']));
                                                    } else {
                                                        $ansDate = '';
                                                    }
                                                    $details[$oQuestion->id]['answers'][$anskey]['ans_name'] = $ansDate;
                                                }
                                } else {
                                    foreach ($res_value_question[$oQuestion->id]['answers'] as $anskey => $ansvalue) {
                                        // Role Compatibility :: START
                                        if (!empty($ansvalue['answer_name']) && $ansvalue['answer_name'] != 'N/A' && $ansvalue['answer_name'] != 'n/a') {
                                                        $ansDate = date($datef . ' ' . $timef, strtotime($ansvalue['answer_name']));
                                                    } else {
                                                        $ansDate = '';
                                                    }
                                                    $details[$oQuestion->id]['answers'][$anskey]['ans_name'] = $ansDate;
                                                }
                                            }
                            } else {
                                foreach ($res_value_question[$oQuestion->id]['answers'] as $anskey => $ansvalue) {
                                    if (!empty($ansvalue['answer_name']) && $ansvalue['answer_name'] != 'N/A' && $ansvalue['answer_name'] != 'n/a') {
                                        $ansDate = nl2br($ansvalue['answer_name']);
                                    } else {
                                        $ansDate = '';
                                            }
                                    $details[$oQuestion->id]['answers'][$anskey]['ans_name'] = $ansDate;
                                        }
                                    }
                        }

                        // Rating Calculation start
                        if ($oQuestion->question_type == 'rating') {

                            if (is_array($rating_final_count)) {
                                for ($i = 0; $i <= $starCount; $i++) {
                                    if (empty($rating_final_count[$i])) {
                                        $rating_final_count[$i] = 0;
                                    }
                                }
                            }
                            foreach ($rating_final_count as $key => $count) {
                                if (!empty($key)) {
                                    //check if total submitted question are greater than 1 or not and the key value is number or not
                                    if ($total_submitted_que != 0 && !is_array($count)) {
                                        $perCent = ($count * 100) / ((empty($AnsweredAndSkippedPerson[$que_id]['answered']) || $AnsweredAndSkippedPerson[$que_id]['answered'] == 0 || $AnsweredAndSkippedPerson[$que_id]['answered'] == '0') ? 1 : $AnsweredAndSkippedPerson[$que_id]['answered']);
                                        $rating_pecent[$key] = $perCent;
                                        $rating_final_pecent[$key] = number_format($perCent, 2);
                                    }
                                }
                                if ($key > 0 && $count > 0) {
                                    $statsSubmittedAnsSeqNumArray[$oQuestion->question_type][$que_id][$key] = $key;
                                    $statsSubmittedAnsCountArray[$oQuestion->question_type][$que_id][$key] = $count;
                                }
                            }
                            $rating_final_count_array[$que_id] = $rating_final_count;
                            $rating_final_percent_array[$que_id] = $rating_final_pecent;

                            // Rating Calculation End
                            $rating[$que_id] = "
                                    <script>
                                        $(document).ready(function () { 
                                            var starCount = $starCount;
                                                var rating_pecent  = " . json_encode($rating_pecent) . ";
                                                for (var i = 0; i <= starCount; i++) {
                                                   $('#question_report_data_{$status_type}').find('#progressbar-'+i+'_{$que_id}').find($('.bar')).css({
                                                         width: rating_pecent[i]+'%'
                                                   });
                                                }
                                           
                                        });
                                    </script>";
                        }
                        // NPS  Data Calculation start By Govind.
                        if ($oQuestion->question_type == 'netpromoterscore') {
                            // NPS datatable calculation. By Govind.
                            $totalDetractorsSubmission = array();
                            $totalPassivesSubmission = array();
                            $totalPromotersSubmission = array();
                            $totalNPSSubmittionCount = array_sum(array_column($details[$oQuestion->id]['answers'], 'sub_ans'));
                            $divisionVal = ($totalNPSSubmittionCount == 0) ? 1 : $totalNPSSubmittionCount;
                            $countKey = 1;
                            $npsdataTableArray = array();
                            foreach ($details[$oQuestion->id]['answers'] as $npsansArra) {
                                $ansNameVal = (int) $npsansArra['ans_name'];
                                if ($ansNameVal >= 0 && $ansNameVal <= 6) {
                                    $totalDetractorsSubmission[] = $npsansArra['sub_ans'];
                                    //random color display for chart
                                    if ($ansNameVal == 6) {
                                        $totalDetSubAns = array_sum($totalDetractorsSubmission);
                                        $detractorsPercent = ( $totalDetSubAns / $divisionVal * 100);
                                        $npsdataTableArray[$countKey]['ans_name'] = 'Detractors (0-6)';
                                        $npsdataTableArray[$countKey]['percent'] = ($totalNPSSubmittionCount > 0) ? number_format($detractorsPercent, 2) : 0;
                                        $npsdataTableArray[$countKey]['sub_ans'] = $totalDetSubAns;
                                        $npsdataTableArray[$countKey]['weight'] = $npsansArra['weight'];
                                        $npsdataTableArray[$countKey]['answer_sequence'] = 1;
                                        $countKey = $countKey + 1;
                                    }
                                } else if ($ansNameVal > 6 && $ansNameVal <= 8) {
                                    $totalPassivesSubmission[] = $npsansArra['sub_ans'];
                                    //random color display for chart
                                    if ($ansNameVal == 8) {
                                        $totalPasSubAns = array_sum($totalPassivesSubmission);
                                        $passivesPercent = ($totalPasSubAns / $divisionVal * 100);
                                        $npsdataTableArray[$countKey]['ans_name'] = 'Passives (7-8)';
                                        $npsdataTableArray[$countKey]['percent'] = ($totalNPSSubmittionCount > 0) ? number_format($passivesPercent, 2) : 0;
                                        $npsdataTableArray[$countKey]['sub_ans'] = $totalPasSubAns;
                                        $npsdataTableArray[$countKey]['weight'] = $npsansArra['weight'];
                                        $npsdataTableArray[$countKey]['answer_sequence'] = 2;
                                        $countKey = $countKey + 1;
                                    }
                                } else if ($ansNameVal > 8 && $ansNameVal <= 10) {
                                    $totalPromotersSubmission[] = $npsansArra['sub_ans'];
                                    //random color display for chart
                                    if ($ansNameVal == 10) {
                                        $totalProSubAns = array_sum($totalPromotersSubmission);
                                        $promoPercent = ($totalProSubAns / $divisionVal * 100);
                                        $npsdataTableArray[$countKey]['ans_name'] = 'Promoters (9-10)';
                                        $npsdataTableArray[$countKey]['percent'] = ($totalNPSSubmittionCount > 0) ? number_format($promoPercent, 2) : 0;
                                        $npsdataTableArray[$countKey]['sub_ans'] = $totalProSubAns;
                                        $npsdataTableArray[$countKey]['weight'] = $npsansArra['weight'];
                                        $npsdataTableArray[$countKey]['answer_sequence'] = 3;
                                        $countKey = $countKey + 1;
                                    }
                                }
                            }
                            $details[$oQuestion->id]['answers'] = $npsdataTableArray;
                            $npsscore = (float) ((($totalProSubAns - $totalDetSubAns) / $divisionVal) * 100);
                            $details[$oQuestion->id]['nps_default_data_table']['detractores'] = $totalDetSubAns;
                            $details[$oQuestion->id]['nps_default_data_table']['passives'] = $totalPasSubAns;
                            $details[$oQuestion->id]['nps_default_data_table']['promoters'] = $totalProSubAns;
                            $details[$oQuestion->id]['nps_default_data_table']['npsscore'] = ($totalNPSSubmittionCount > 0) ? number_format($npsscore, 2) : 0;
                        }
                        // End

                        if ($details[$que_id]['page_id'] != $page) {
                            unset($details[$que_id]);
                        }
                        $que_details[$page_seq]['page'] = $details;
                    }
                }
            }
            //set pagination
            $module_types = getReportData('individual', $survey_id);
            foreach ($module_types as $key => $val) {
                $module_id = $key;
            }
            if ($totalPages > 1) {
                $indexed_page_outer = $page - 1;
                $que_details[$indexed_page_outer] = $que_details[$page];
                for ($eachPage = 0; $eachPage <= $totalPages; $eachPage++) {
                    $indexed_page = $eachPage - 1;
                    if ($eachPage != 0 && $page != $totalPages && $indexed_page != $indexed_page_outer) {

                        $que_details[$indexed_page] = $que_details[$indexed_page_outer];
                    } else if ($page == $totalPages) {
                        if ($eachPage != 0 && $eachPage + 1 < $totalPages && $indexed_page != $indexed_page_outer) {

                            $que_details[$indexed_page] = $que_details[$indexed_page_outer];
                        }
                    }
                }
            }
            if (count($que_details)) {
                $pagination = new pagination($que_details, $page, 1);
                $pagination->setShowFirstAndLast(true);
                $QueReportData = $pagination->getResults();
                if (count($QueReportData) != 0) {
                    $queReoort_pageNumbers = $pagination->getQuestionLinks($_GET, $survey_id, '', $module_id);
                }
            }
            $subCOuntQ = "SELECT
                                count(*) as submission_count
                              FROM
                                bc_survey_submission
                              LEFT JOIN
                                bc_survey_submission_bc_survey_c AS ss 
                                ON ss.bc_survey_submission_bc_surveybc_survey_submission_idb = bc_survey_submission.id 
                                AND ss.bc_survey_submission_bc_surveybc_survey_ida = '{$survey_id}'
                              WHERE
                                bc_survey_submission.deleted = 0 AND ss.deleted = 0 and bc_survey_submission.status = 'Submitted'";
            $runQ = $db->query($subCOuntQ);
            $subCOuntData = $db->fetchByAssoc($runQ);
            $submission_count = (empty($subCOuntData['submission_count'])) ? (int) 0 : (int) $subCOuntData['submission_count'];

            if ($submission_count == 0 && $total_submitted_que == 0) {
                $QueReportData = "There is no submission for this Survey.";
            }

            $status_response = array(
                'survey_name' => $oSurvey->name,
                'total_submitted_que' => $total_send_survey,
                'QueReportData' => $QueReportData,
                'page' => $page,
                'AnsweredAndSkippedPerson' => $AnsweredAndSkippedPerson,
                'survey_for_rating' => $rating,
                'rating_final_count' => $rating_final_count_array,
                'rating_final_percent' => $rating_final_percent_array,
                'queReoort_pageNumbers' => $queReoort_pageNumbers,
            );
            $chart_flag = 0;
            //getting coulmn chart data for multi choice type of question data
            if (is_array($QueReportData)) {
                foreach ($QueReportData as $key => $QueReportData) {
                    $matrix_col_counter = 1;
                    $count = 0;
                    $matri_all_count_array_main = array();

                    $multi_data_forNPS = array();
                    $multi_data_forBarColMatrix = array();
                    foreach ($QueReportData['page'] as $qid => $survey_detail) {
                        $multi_data = array();
                        $matrixbarColData = array();
                        $counter_display_matrix[$qid] = array();
                        if ($qid != 'page_title') {

                            if ($survey_detail['que_type'] == 'scale') {
                                // if scale type then only provide count for each answer
                                $multi_data[] = array('Task', 'Percentage', array('role' => 'style'));
                                // set scale question ids for chrt display
                                array_push($scale_chart_ids, $qid);
                                asort($survey_detail['answers']);

                                $min = $survey_detail['min'] ? $survey_detail['min'] : 0;
                                $max = $survey_detail['max'] ? $survey_detail['max'] + 1 : 100;
                                $scale_slot = $survey_detail['scale_slot'] ? $survey_detail['scale_slot'] : 10;
                                //arrange slot for scale chart
                                $column_array = array();
                                for ($val = $min; $val < $max;) {
                                    $column_array[$val] = 0;
                                    $val = $val + $scale_slot;
                                }
                            } else if ($survey_detail['que_type'] == 'matrix') {
                                // Initialize counter - count number of rows & columns
                                $row_count = 0;
                                $col_count = 0;
                                // Do the loop
                                foreach ($matrix_rows[$qid] as $result) {
                                    // increment row counter
                                    $row_count++;
                                }
                                foreach ($matrix_cols[$qid] as $result) {
                                    // increment  column counter
                                    $col_count++;
                                }
                                $multi_data[] = array('Rows');
                                $multi_data_forBarColMatrix[$qid]['bar-col'][] = array('Rows', 'Percentage', array('role' => 'style'));
                                $matrix_chart_colors[$qid]['colors'] = array();
                                for ($i = 1; $i <= $row_count; $i++) {
                                    // increment row counter
                                    $multi_data[$i] = array($matrix_rows[$qid]->$i);
                                    for ($j = 1; $j <= $col_count + 1; $j++) {
                                        // increment  column counter
                                        if (!empty($matrix_cols[$qid]->$j)) {
                                            $multi_data[0][$j] = $matrix_cols[$qid]->$j;
                                            $random_colorNumber = array_rand($chartColor);
                                            $chartColorname = $chartColor[$random_colorNumber];
                                            $matrix_chart_colors[$qid]['colors'][] = $chartColorname;

                                            //updating column count to array rows
                                            array_push($multi_data[$i], 0);
                                        }
                                    }
                                }
                                //matrix chart ids for report
                                array_push($matrix_chart_ids, $qid);
                            } else if ($survey_detail['que_type'] == 'netpromoterscore') {
                                $multi_data_forNPS[$qid]['nps_gauge_chart'][] = array('Label', 'Value');
                                $multi_data[] = array('Task', 'Percentage', array('role' => 'style'));
                                array_push($chart_ids, $qid);
                            } else if ($survey_detail['que_type'] != 'doc-attachment') {
                                $multi_data[] = array('Task', 'Percentage', array('role' => 'style'));
                                array_push($chart_ids, $qid);
                            }
                            $matri_all_count_array = array();
                            foreach ($survey_detail['answers'] as $ansSeq => $answers) {
                                if ($survey_detail['que_type'] != 'matrix' && $survey_detail['que_type'] != 'rating') {
                                    if ($answers['sub_ans'] > 0) {
                                        if ($survey_detail['que_type'] == 'scale') {
                                            $statsSubmittedAnsSeqNumArray[$survey_detail['que_type']][$qid][$answers['ans_name']] = $answers['answer_sequence'];
                                        } else {
                                            $statsSubmittedAnsSeqNumArray[$survey_detail['que_type']][$qid][$answers['ans_name']] = $ansSeq;
                                        }
                                        $statsSubmittedAnsCountArray[$survey_detail['que_type']][$qid][$answers['ans_name']] = $answers['sub_ans'];
                                    }
                                }
                                if ($survey_detail['que_type'] == 'scale') {
                                    if (is_array($answers) && is_array($column_array)) {
                                        foreach ($column_array as $answer => $count) {
                                            // if answer submitted for given value then update the counter
                                            if ($answer == $answers['ans_name']) {
                                                $column_array[$answer] = $answers['percent'];
                                            }
                                        }
                                    }
                                    foreach ($column_array as $answer => $count) {
                                        if ($count != 0) {
                                            //random color display for chart
                                            $random_colorNumber = array_rand($chartColor);
                                            $random_color = $chartColor[$random_colorNumber];
                                            $multi_data[] = array((string) $answer, (float) ($count), $random_color);
                                            $chart_display_data[$qid] = $multi_data;
                                            $pie_chart_colors[$qid]['colors'][] = $random_color;
                                            $flag = 1;
                                        }
                                    }
                                    $multi_data = array();
                                    $multi_data[] = array('Task', 'Percentage', array('role' => 'style'));
                                } else if ($survey_detail['que_type'] != 'netpromoterscore' && $survey_detail['que_type'] != 'contact-information' && $survey_detail['que_type'] != 'commentbox' && $survey_detail['que_type'] != 'textbox' && $survey_detail['que_type'] != 'rating' && $survey_detail['que_type'] != 'date-time' && $survey_detail['que_type'] != 'scale' && $survey_detail['que_type'] != 'matrix') {
                                    if (is_array($answers)) {
                                        $ans_obj = explode('</span>', $answers['ans_name']);
                                        if (!empty($ans_obj[1])) {
                                            $ans_obj = explode('<span class="ans-lbl" style="margin-left: 5px;margin-top: 3px;vertical-align: -webkit-baseline-middle;">', $ans_obj[1]);
                                            $count_ans_obj = count($ans_obj);
                                            $answers['ans_name'] = $ans_obj[$count_ans_obj - 1];
                                        }
                                        //random color display for chart
                                        $random_colorNumber = array_rand($chartColor);
                                             $random_color = $chartColor[$random_colorNumber];
                                        $multi_data[] = array($answers['ans_name'], (float) $answers['percent'], $random_color);
                                        $chart_display_data[$qid] = $multi_data;
                                        $pie_chart_colors[$qid]['colors'][] = $random_color;
                                        $flag = 1;
                                    }
                                } else if ($survey_detail['que_type'] == 'netpromoterscore') {
                                    if (is_array($answers)) {
                                        //random color display for chart
                                        $random_colorNumber = array_rand($chartColor);
                                             $random_color = $chartColor[$random_colorNumber];
                                        $multi_data[] = array($answers['ans_name'], (float) $answers['percent'], $random_color);
                                        $chart_display_data[$qid] = $multi_data;
                                        $pie_chart_colors[$qid]['colors'][] = $random_color;
                                        $flag = 1;
                                    }
                                } else if ($survey_detail['que_type'] == 'matrix') {
                                    if (is_array($answers)) {
                                        foreach ($survey_detail['answers']['ans_detail'] as $aAns) {
                                            if (!empty($aAns)) {
                                                $matrix = explode('_', $aAns);
                                                for ($i = 1; $i <= $row_count; $i++) {
                                                    // increment row counter
                                                    for ($j = 1; $j <= $col_count + 1; $j++) {
                                                        // increment  column counter
                                                        if ($matrix[0] == $i && $matrix[1] == $j) {
                                                            if (!isset($final_matrix_rowCount[$qid][$i])) {
                                                                $final_matrix_rowCount[$qid][$i] = 0;
                                                            }
                                                            $matrixAnsweredPerson = $final_matrix_rowCount[$qid][$i];
                                                            if (isset($answers['sub_ans'])) {
                                                                $percentVal = number_format(($answers['sub_ans'][$i][$j] * 100) / ((empty($matrixAnsweredPerson) || $matrixAnsweredPerson == 0 || $matrixAnsweredPerson == '0') ? 1 : $matrixAnsweredPerson), 2);
                                                                $matri_all_count_array[$i][$j] = (empty($percentVal)) ? (float) 0 : (float) $percentVal;
                                                                $matri_all_count_array_main[$i][$j] = $answers['sub_ans'][$i][$j] . '&nbsp;(' . number_format(($answers['sub_ans'][$i][$j] * 100) / ((empty($matrixAnsweredPerson) || $matrixAnsweredPerson == 0 || $matrixAnsweredPerson == '0') ? 1 : $matrixAnsweredPerson), 2) . '%)';
                                                                if ($answers['sub_ans'][$i][$j] > 0) {
                                                                    foreach ($answers['sub_ans'] as $rowSeq => $colSeqSubData) {
                                                                        foreach ($colSeqSubData as $colSeq => $colSubCountDat) {
                                                                            $statsSubmittedAnsSeqNumArray[$survey_detail['que_type']][$qid][$matrix_rows[$qid]->$rowSeq][$matrix_cols[$qid]->$colSeq] = $colSeq;
                                                                            $statsSubmittedAnsCountArray[$survey_detail['que_type']][$qid][$matrix_rows[$qid]->$rowSeq][$matrix_cols[$qid]->$colSeq] = $colSubCountDat;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        if (!empty($matrix_cols[$qid]->$j)) {
                                                            $multi_data[$i][$j] = !empty($matri_all_count_array[$i][$j]) ? $matri_all_count_array[$i][$j] : 0;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        $chart_display_data[$qid] = $multi_data;
                                        $flag = 1;
                                        $matrix_col_counter++;
                                    }
                                }

                                if ($flag == 1) {
                                    $flag = 0; // reset flag for other question
                                    $chart_flag = 1; // to set flag for chart after all records data will be set in array and html
                                }
                            }
                            if ($survey_detail['que_type'] == 'rating') {
                                if (is_array($answers)) {
                                    ksort($rating_final_count_array[$qid]);
                                    foreach ($rating_final_count_array[$qid] as $rateStarCount => $submitRateVal) {
                                        if ($rateStarCount > 0) {
                                            //random color display for chart
                                           $random_colorNumber = array_rand($chartColor);
                                             $random_color = $chartColor[$random_colorNumber];
                                            $multi_data[] = array((string) $rateStarCount, (float) $rating_final_percent_array[$qid][$rateStarCount], $random_color);
                                            $pie_chart_colors[$qid]['colors'][] = $random_color;
                                        }
                                    }
                                    $chart_display_data[$qid] = $multi_data;
                                    $chart_flag = 1;
                                }
                            }
                            if ($survey_detail['que_type'] == 'matrix') {
                                foreach ($matrix_rows[$qid] as $k => $row) {
                                    $random_colorNumber = array_rand($chartColor);
                                    $random_color = $chartColor[$random_colorNumber];
                                    $matrixAnsweredPerson = $final_matrix_rowCount[$qid][$k];
                                    $percentV = number_format(($matrixAnsweredPerson / array_sum($final_matrix_rowCount[$qid])) * 100, 2);
                                    $matRixBarCOlPer = (empty($percentV)) ? (float) 0 : (float) $percentV;
                                    $multi_data_forBarColMatrix[$qid]['bar-col'][] = array($row, $matRixBarCOlPer, $random_color);
                                }
                            }
                            if ($survey_detail['que_type'] == 'netpromoterscore') {
                                $multi_data_forNPS[$qid]['nps_gauge_chart'][] = array('', (float) $survey_detail['nps_default_data_table']['npsscore']);
                                $chart_display_data[$qid] = $multi_data;
                                $chart_flag = 1;
                            }
                            if (empty($survey_detail['answers']) && $survey_detail['que_type'] == 'scale') {
                                $multi_data[] = array('0', (int) 0, '#fff');
                                $chart_display_data[$qid] = $multi_data;
                                $chart_flag = 1;
                            }
                        }
                        $counter_display_matrix[$qid] = $matri_all_count_array_main;
                    }

                    if ($chart_flag == 1) {
                        $multi_data_array = $chart_display_data;
                        $chart_flag = 0;
                    }
                }
                // Stats Data Calculation By Govind.
                if (!empty($statsSubmittedAnsSeqNumArray)) {
                    ksort($statsSubmittedAnsSeqNumArray[$survey_detail['que_type']][$qid]);
                }
                if (!empty($statsSubmittedAnsCountArray)) {
                    ksort($statsSubmittedAnsCountArray[$survey_detail['que_type']][$qid]);
                }
                $statsDataArray = statsQuestionReportData($statsSubmittedAnsSeqNumArray, $statsSubmittedAnsCountArray);
                                }
        } elseif ($type == 'individual') {

            $gf_start_date = (isset($global_filter['gf_start_date'])) ? $global_filter['gf_start_date'] : '';
            $gf_end_date = (isset($global_filter['gf_end_date'])) ? $global_filter['gf_end_date'] : '';
            $module_types = getReportData($type, $survey_id, '', '', '', $gf_start_date, $gf_end_date, '', '', '', '', '', $gf_filter_by, $GF_QueLogic_Passed_Submissions);
            foreach ($module_types as $id => $module_detail) {
                $module_name = (!empty($app_list_strings['moduleList'][$module_detail['module_type']])) ? $app_list_strings['moduleList'][$module_detail['module_type']] : '-';
                $name[$id] = array(
                    'name' => $module_detail['customer_name'],
                    'module_type' => $module_name,
                    'module_name' => $module_detail['module_type'],
                    'submission_type' => $module_detail['submission_type'],
                    'survey_status' => $module_detail['survey_status'],
                    'module_id' => $module_detail['module_id'],
                    'send_date' => $module_detail['send_date'],
                    'receive_date' => $module_detail['receive_date'],
                    'change_request' => $module_detail['change_request'],
                    'submission_id' => $module_detail['submission_id'],
                    'enable_agreement' => (isset($survey->enable_agreement)) ? $survey->enable_agreement : '',
                    'consent_accepted' => $module_detail['consent_accepted']
                );
                    }
            //if current user is authorized to access all rights of survey then set flag to true
            if (is_admin($current_user) || $created_by_id == $current_user->id) {
                $is_valid_user = "Yes";
            } else {
                $is_valid_user = "No";
            }
            
            $list_max_entries_per_page = !empty($sugar_config['list_max_entries_per_page']) ? $sugar_config['list_max_entries_per_page'] : 20;
            $status_response = array('Individual_ReportData' => $name, 'survey_id' => $survey_id, 'page' => $page, 'survey_name' => $oSurvey->name, 'max_records' => $list_max_entries_per_page);
        }
        return array('data' => $multi_data_array, 'html' => $status_response, 'chart_id' => $chart_ids, 'scale_chart_ids' => $scale_chart_ids, 'matrix_chart_ids' => $matrix_chart_ids, 'line_chart' => $lineChart, 'linechart_max_count' => $maxStatusDataCount, 'counter_display_matrix' => $counter_display_matrix, 'multi_data_forNPS' => $multi_data_forNPS, 'multi_data_forBarColMatrix' => $multi_data_forBarColMatrix, 'responseCountArray' => $final_matrix_rowCount, 'statsDataArray' => $statsDataArray, 'trendsStatusReportDataArray' => $trendsStatusReportDataArray, 'trendsQuestionReportDataArray' => $trendsQuestionReportDataArray, 'matrix_chart_colors' => $matrix_chart_colors, 'pie_chart_colors' => $pie_chart_colors);
    }

    /**
     * Function : getAllSurveyQuestions
     *   Retrieve all questions for Question Logic
     * 
     * @return array - $data
     */
    public function getAllSurveyQuestions($api, $args) {
        $record_id = $args['record_id'];

        $restricted_que_types = array('additional-text', 'image', 'video', 'doc-attachment', 'richtextareabox');

        $oSurvey = new bc_survey();
        $oSurvey->retrieve($record_id);
        $survey_theme = $oSurvey->survey_theme;
        $oSurvey->load_relationship('bc_survey_pages_bc_survey');

        $oSurvey_details = array();
        $questions = array();
        $que_seq = 0;

        foreach ($oSurvey->bc_survey_pages_bc_survey->getBeans() as $pages) {

            $pages->load_relationship('bc_survey_pages_bc_survey_questions');
            foreach ($pages->bc_survey_pages_bc_survey_questions->getBeans() as $survey_questions) {
                if (!in_array($survey_questions->question_type, $restricted_que_types)) {
                    $questions[$que_seq]['que_id'] = $survey_questions->id;
                    if ($survey_questions->question_type != 'additional-text') {

                        $questions[$que_seq]['que_title'] = $survey_questions->name;
                    }
                    $questions[$que_seq]['que_type'] = $survey_questions->question_type;

                    //advance options
                    if ($survey_questions->question_type == 'matrix') {
                        $questions[$que_seq]['matrix_row'] = (isset($survey_questions->matrix_row)) ? base64_decode($survey_questions->matrix_row) : '';
                        $questions[$que_seq]['matrix_col'] = (isset($survey_questions->matrix_col)) ? base64_decode($survey_questions->matrix_col) : '';
                    }
                    $survey_questions->load_relationship('bc_survey_answers_bc_survey_questions');
                    foreach ($survey_questions->bc_survey_answers_bc_survey_questions->getBeans() as $survey_answers) {
                        if ($survey_answers->answer_type != 'other') {
                            $questions[$que_seq]['answers'][$survey_answers->answer_sequence][$survey_answers->id]['option'] = $survey_answers->answer_name;
                            $questions[$que_seq]['answers'][$survey_answers->answer_sequence][$survey_answers->id]['radio_image'] = $survey_answers->radio_image;
                        } else {
                            $questions[$que_seq]['other_option'][$survey_answers->id]['option'] = $survey_answers->answer_name;
                            $questions[$que_seq]['other_option'][$survey_answers->id]['other_image'] = $survey_answers->radio_image;
                        }
                    }
                    if (isset($questions[$que_seq]['answers']) && is_array($questions[$que_seq]['answers'])) {
                        ksort($questions[$que_seq]['answers']);
                    }
                    $que_seq++;
                }
            }
            ksort($questions);
        }
        $final_ques_list = array();
        foreach ($questions as $qu_sq => $data) {
            $final_ques_list[$data['que_id']] = $data;
        }
        $survey_details = $final_ques_list;
        return $survey_details;
    }

    /**
     * Function : generateQueLogicSection
     *   Generate section for Question Logic
     * 
     * @return array - $data
     */
    public function generateQueLogicSection($api, $args) {
        $que_id = $args['que_id'];
        $logic_seq = $args['logic_seq'];
        $multi_questions = array('check-box', 'dropdownlist', 'radio-button', 'multiselectlist', 'boolean', 'emojis', 'netpromoterscore');
        $fix_multi_options = array();
        $single_select_question = array('textbox', 'commentbox', 'scale', 'date-time', 'contact-information', 'rating');
        $que_logic_data = '';

        // check whether question has details or not
        if (!empty($que_id)) {
            // Load Question bean
            $oQuestion = BeanFactory::getBean('bc_survey_questions', $que_id);
            if (!empty($oQuestion->id)) {
                // check for Multi Select type of question
                if (in_array($oQuestion->question_type, $multi_questions)) {
                    if ($oQuestion->question_type == 'netpromoterscore') {
                        $que_logic_data .= '<div class="data-page ui-droppable ui-sortable logic_answer_section" id="que_logic_answer_' . $logic_seq . '" data-dashlet="dashlet" >';
                        $que_logic_data .= '<div>Logic Operator : ';
                        $que_logic_data .= '<select name="logic_operator_' . $logic_seq . '" style="margin-top: 9px;">';
                        $que_logic_data .= '    <option value="equals_to">Equals To</option>';
                        $que_logic_data .= '    <option value="not_equals_to">Not Equals To</option>';
                        $que_logic_data .= '</select>';

                        $que_logic_data .= '&nbsp;<select name="logic_value_' . $logic_seq . '" style="margin-top: 9px;">';
                        $que_logic_data .= '<option value=""></option>';
                        $que_logic_data .= '<option value="0-6">0-6</option>';
                        $que_logic_data .= '<option value="7-8">7-8</option>';
                        $que_logic_data .= '<option value="9-10">9-10</option>';
                        $que_logic_data .= '</div>';
                        $que_logic_data .= "</div>";
                    } else {
                        $que_logic_data .= '<div class="data-page ui-droppable ui-sortable logic_answer_section" id="que_logic_answer_' . $logic_seq . '" data-dashlet="dashlet" >';
                        $que_logic_data .= '<div>Logic Operator : ';
                        $que_logic_data .= '<select name="logic_operator_' . $logic_seq . '" style="margin-top: 9px;">';
                        $que_logic_data .= '    <option value="equals_to">Equals To</option>';
                        $que_logic_data .= '    <option value="not_equals_to">Not Equals To</option>';
                        $que_logic_data .= '</select>';

                        $que_logic_data .= '&nbsp;<select name="logic_value_' . $logic_seq . '" style="margin-top: 9px;">';
                        $que_logic_data .= '<option value=""></option>';
                        if ($oQuestion->load_relationship('bc_survey_answers_bc_survey_questions')) {
                            foreach ($oQuestion->bc_survey_answers_bc_survey_questions->getBeans() as $survey_answers) {
                                $que_logic_data .= '<option value=' . $survey_answers->id . '>' . $survey_answers->answer_name . '</option>';
                            }
                        }
                        $que_logic_data .= '</div>';
                        $que_logic_data .= "</div>";
                    }
                }
                // check for Single Select type of question
                else if (in_array($oQuestion->question_type, $single_select_question)) {
                    // TEXTBOX AND COMMENTBOX type ****************************************************
                    if ($oQuestion->question_type == 'commentbox' || ($oQuestion->question_type == 'textbox' && ( (!empty($oQuestion->advance_type) && $oQuestion->advance_type == 'Char' || $oQuestion->advance_type == 'Email') || empty($oQuestion->advance_type) ))) {
                        $que_logic_data .= '<div class="data-page ui-droppable ui-sortable logic_answer_section" id="que_logic_answer_' . $logic_seq . '" data-dashlet="dashlet" >';
                        $que_logic_data .= '<div>Logic Operator : ';
                        $que_logic_data .= '<select name="logic_operator_' . $logic_seq . '" style="margin-top: 9px;">';
                        $que_logic_data .= '    <option value="equals_to">Equals To</option>';
                        $que_logic_data .= '    <option value="not_equals_to">Not Equals To</option>';
                        $que_logic_data .= '    <option value="starts_with">Starts With</option>';
                        $que_logic_data .= '    <option value="ends_with">Ends With</option>';
                        $que_logic_data .= '    <option value="contains">Contains</option>';
                        $que_logic_data .= '    <option value="not_contains">Not Contains</option>';
                        $que_logic_data .= '</select>';
                        $que_logic_data .= '&nbsp;<input type="text" class="logic_required" name="logic_value_' . $logic_seq . '" placeholder="Logic Value">';
                        $que_logic_data .= '</div>';
                        $que_logic_data .= "</div>";
                    }
                    // SCALE AND NUMERIC type ****************************************************
                    else if ($oQuestion->question_type == 'scale' || ($oQuestion->question_type == 'textbox' && ( (!empty($oQuestion->advance_type) && $oQuestion->advance_type == 'Integer' || $oQuestion->advance_type == 'Float') ))) {
                        $que_logic_data .= '<div class="data-page ui-droppable ui-sortable logic_answer_section" id="que_logic_answer_' . $logic_seq . '" data-dashlet="dashlet" >';
                        $que_logic_data .= '<div>Logic Operator : ';
                        $que_logic_data .= '<select name="logic_operator_' . $logic_seq . '" style="margin-top: 9px;" onchange="switchTextForLogicOperator(this,\'' . $logic_seq . '\')">';
                        $que_logic_data .= '    <option value="equals_to">Equals To</option>';
                        $que_logic_data .= '    <option value="not_equals_to">Not Equals To</option>';
                        $que_logic_data .= '    <option value="gt">Greater Than</option>';
                        $que_logic_data .= '    <option value="gt_equals_to">Greater Than or Equals To</option>';
                        $que_logic_data .= '    <option value="lt">Less Than</option>';
                        $que_logic_data .= '    <option value="lt_equals_to">Less Than or Equals To</option>';
                        $que_logic_data .= '    <option value="between">Between</option>';
                        $que_logic_data .= '    <option value="not_between">Not Between</option>';
                        $que_logic_data .= '</select>';
                        $que_logic_data .= '&nbsp;<input type="hidden" class="" name="queType_value_' . $logic_seq . '" value="' . $oQuestion->question_type . '">';
                        $que_logic_data .= '&nbsp;<input type="text" class="logic_required" name="logic_value_' . $logic_seq . '" placeholder="Logic Value">';
                        $que_logic_data .= '&nbsp;<input type="text" class="logic_required between_notbetween_text" name="between_notbetween_start_logic_value_' . $logic_seq . '" placeholder="Logic Value" style="display:none;width:80px;">';
                        $que_logic_data .= '&nbsp;<input type="text" class="logic_required between_notbetween_text" name="between_notbetween_end_logic_value_' . $logic_seq . '" placeholder="Logic Value" style="display:none;width:80px;">';
                        $que_logic_data .= '</div>';
                        $que_logic_data .= "</div>";
                    } else if ($oQuestion->question_type == 'rating') {
                        $que_logic_data .= '<div class="data-page ui-droppable ui-sortable logic_answer_section" id="que_logic_answer_' . $logic_seq . '" data-dashlet="dashlet" >';
                        $que_logic_data .= '<div>Logic Operator : ';
                        $que_logic_data .= '<select name="logic_operator_' . $logic_seq . '" style="margin-top: 9px;" onchange="switchTextForLogicOperator(this,\'' . $logic_seq . '\')">';
                        $que_logic_data .= '    <option value="equals_to">Equals To</option>';
                        $que_logic_data .= '    <option value="not_equals_to">Not Equals To</option>';
                        $que_logic_data .= '    <option value="gt">Greater Than</option>';
                        $que_logic_data .= '    <option value="gt_equals_to">Greater Than or Equals To</option>';
                        $que_logic_data .= '    <option value="lt">Less Than</option>';
                        $que_logic_data .= '    <option value="lt_equals_to">Less Than or Equals To</option>';
                        $que_logic_data .= '    <option value="between">Between</option>';
                        $que_logic_data .= '    <option value="not_between">Not Between</option>';
                        $que_logic_data .= '</select>&nbsp;';
                        $que_logic_data .= '<select name="logic_value_' . $logic_seq . '" style="margin-top: 9px;">';
                        $ratCount = ($oQuestion->maxsize == 0) ? 5 : $oQuestion->maxsize;
                        $que_logic_data .= '<option value=""></option>';
                        for ($i = 1; $i <= $ratCount; $i++) {
                            $que_logic_data .= '<option value=' . $i . '>' . $i . '</option>';
                        }
                        $que_logic_data .= '</select>';
                        $que_logic_data .= '&nbsp;<input type="hidden" class="" name="queType_value_' . $logic_seq . '" value="' . $oQuestion->question_type . '">';
                        $que_logic_data .= '&nbsp;<input type="text" class="logic_required between_notbetween_text" name="between_notbetween_start_logic_value_' . $logic_seq . '" placeholder="Logic Value" style="display:none;width:80px;">';
                        $que_logic_data .= '&nbsp;<input type="text" class="logic_required between_notbetween_text" name="between_notbetween_end_logic_value_' . $logic_seq . '" placeholder="Logic Value" style="display:none;width:80px;">';
                        $que_logic_data .= '</div>';
                        $que_logic_data .= "</div>";
                    }
                    // DATETIME type ****************************************************
                    else if ($oQuestion->question_type == 'date-time') {
                        if ($oQuestion->is_datetime == 1) {
                            $que_logic_data .= '<div class="data-page ui-droppable ui-sortable logic_answer_section" id="que_logic_answer_' . $logic_seq . '" data-dashlet="dashlet" >';
                            $que_logic_data .= '<div>Logic Operator : ';
                            $que_logic_data .= '<select name="logic_operator_' . $logic_seq . '" style="margin-top: 9px;width:120px;" onchange="switchTextForLogicOperator(this,\'' . $logic_seq . '\')">';
                            $que_logic_data .= '    <option value="equals_to">Equals To</option>';
                            $que_logic_data .= '    <option value="not_equals_to">Not Equals To</option>';
                            $que_logic_data .= '    <option value="gt">Greater Than</option>';
                            $que_logic_data .= '    <option value="gt_equals_to">Greater Than or Equals To</option>';
                            $que_logic_data .= '    <option value="lt">Less Than</option>';
                            $que_logic_data .= '    <option value="lt_equals_to">Less Than or Equals To</option>';
                            $que_logic_data .= '    <option value="between">Between</option>';
                            $que_logic_data .= '    <option value="not_between">Not Between</option>';
                            $que_logic_data .= '</select>';
                            $que_logic_data .= '<input type="hidden" class="" name="queType_value_' . $logic_seq . '" value="' . $oQuestion->question_type . '">';
                            $que_logic_data .= '&nbsp;<input type="text" class="show_datepicker datepicker ui-timepicker-input logic_required" name="logic_value_' . $logic_seq . '" placeholder="Date" style=" width: 145px;"> &nbsp; <input type="text" class="show_timepicker timepicker ui-timepicker-input" name="logic_value2_' . $logic_seq . '" placeholder="Time" style=" width: 65px;">';
                            $que_logic_data .= '&nbsp;<input type="text" class="show_datepicker datepicker ui-timepicker-input logic_required between_notbetween_text" name="between_notbetween_start_logic_value_' . $logic_seq . '" placeholder="Date" style="display:none;width:80px;"> &nbsp; <input type="text" class="between_notbetween_text show_timepicker timepicker ui-timepicker-input" name="between_notbetween_start_logic_value2_' . $logic_seq . '" placeholder="Time" style="display:none; width: 65px;">';
                            $que_logic_data .= '&nbsp;<input type="text" class="show_datepicker datepicker ui-timepicker-input logic_required between_notbetween_text" name="between_notbetween_end_logic_value_' . $logic_seq . '" placeholder="Date" style="display:none;width:80px;"> &nbsp; <input type="text" class="between_notbetween_text show_timepicker timepicker ui-timepicker-input" name="between_notbetween_end_logic_value2_' . $logic_seq . '" placeholder="Time" style="display:none; width: 65px;">';
                            $que_logic_data .= '</div>';
                            $que_logic_data .= "</div>";
                        } else {
                            $que_logic_data .= '<div class="data-page ui-droppable ui-sortable logic_answer_section" id="que_logic_answer_' . $logic_seq . '" data-dashlet="dashlet" >';
                            $que_logic_data .= '<div>Logic Operator : ';
                            $que_logic_data .= '<select name="logic_operator_' . $logic_seq . '" style="margin-top: 9px;width:120px;" onchange="switchTextForLogicOperator(this,\'' . $logic_seq . '\')">';
                            $que_logic_data .= '    <option value="equals_to">Equals To</option>';
                            $que_logic_data .= '    <option value="not_equals_to">Not Equals To</option>';
                            $que_logic_data .= '    <option value="gt">Greater Than</option>';
                            $que_logic_data .= '    <option value="gt_equals_to">Greater Than or Equals To</option>';
                            $que_logic_data .= '    <option value="lt">Less Than</option>';
                            $que_logic_data .= '    <option value="lt_equals_to">Less Than or Equals To</option>';
                            $que_logic_data .= '    <option value="between">Between</option>';
                            $que_logic_data .= '    <option value="not_between">Not Between</option>';
                            $que_logic_data .= '</select>';
                            $que_logic_data .= '<input type="hidden" class="" name="queType_value_' . $logic_seq . '" value="' . $oQuestion->question_type . '">';
                            $que_logic_data .= '&nbsp;<input type="text" class="show_datepicker datepicker ui-timepicker-input logic_required" name="logic_value_' . $logic_seq . '" placeholder="Logic Value">';
                            $que_logic_data .= '&nbsp;<input type="text" class="show_datepicker datepicker ui-timepicker-input logic_required between_notbetween_text" name="between_notbetween_start_logic_value_' . $logic_seq . '" placeholder="Date" style="display:none;width:80px;"> ';
                            $que_logic_data .= '&nbsp;<input type="text" class="show_datepicker datepicker ui-timepicker-input logic_required between_notbetween_text" name="between_notbetween_end_logic_value_' . $logic_seq . '" placeholder="Date" style="display:none;width:80px;">';
                            $que_logic_data .= '</div>';
                            $que_logic_data .= "</div>";
                        }
                    }
                    // CONTACT INFORMATION type ****************************************************
                    else if ($oQuestion->question_type == 'contact-information') {
                        $que_logic_data .= '<div class="data-page ui-droppable ui-sortable logic_answer_section" id="que_logic_answer_' . $logic_seq . '" data-dashlet="dashlet" >';
                        $que_logic_data .= '<div>Logic Operator : ';
                        $que_logic_data .= '<select name="logic_operator_' . $logic_seq . '" style="margin-top: 9px;">';
                        $que_logic_data .= '    <option value="contains">Contains</option>';
                        $que_logic_data .= '    <option value="not_contains">Not Contains</option>';
                        $que_logic_data .= '</select>';
                        $que_logic_data .= '&nbsp;<input class="logic_required" type="text" name="logic_value_' . $logic_seq . '" placeholder="Logic Value">';
                        $que_logic_data .= '</div>';
                        $que_logic_data .= "</div>";
                    }
                }
                // MATRIX type ****************************************************
                else if ($oQuestion->question_type == 'matrix') {
                    $que_logic_data .= '<div class="data-page ui-droppable ui-sortable logic_answer_section" id="que_logic_answer_' . $logic_seq . '" data-dashlet="dashlet" >';
                    $que_logic_data .= '<div>';

                    $matrix_row = base64_decode($oQuestion->matrix_row);
                    $matrix_col = base64_decode($oQuestion->matrix_col);

                    $rows = json_decode($matrix_col);
                    $cols = json_decode($matrix_row);

                    // Initialize counter - count number of rows & columns
                    $row_count = 1;
                    $col_count = 1;
                    // Do the loop
                    foreach ($rows as $result) {
                        // increment row counter
                        $row_count++;
                    }
                    foreach ($cols as $result) {
                        // increment  column counter
                        $col_count++;
                    }

                    // adjusting div width as per column
                    $width = '100%'; //(100 / ($col_count + 1)) + 10 . "%";

                    $que_logic_data .= '<div class="matrix-tbl-contner">';
                    $que_logic_data .= "<table>";
                    $op = 0;
                    for ($i = 1; $i <= $row_count; $i++) {

                        $que_logic_data .= '<tr class="matrix-row">';

                        for ($j = 1; $j <= $col_count + 1; $j++) {
                            $row = $i - 1;
                            $col = $j - 1;
                            //First row & first column as blank
                            if ($j == 1 && $i == 1) {
                                $que_logic_data .= "<th class='matrix-span' style='width:" . $width . "'>&nbsp;</th>";
                            }
                            // Rows Label
                            else if ($j == 1 && $i != 1) {
                                if (!empty($list_lang_detail[$que_id . '_matrix_row' . $row])) {
                                    $row_header = $list_lang_detail[$que_id . '_matrix_row' . $row];
                                } else {
                                    $row_header = $rows->$row;
                                }
                                $que_logic_data .= "<th class='matrix-span' style=' width:" . $width . ";' title='" . $row_header . "'>" . $row_header . "</th>";
                            } else {
                                //Columns label
                                if ($j <= ($col_count + 1) && $cols->$col != null && !($j == 1 && $i == 1) && ($i == 1 || $j == 1)) {
                                    if (!empty($list_lang_detail[$que_id . '_matrix_col' . $col])) {
                                        $col_header = $list_lang_detail[$que_id . '_matrix_col' . $col];
                                    } else {
                                        $col_header = $cols->$col;
                                    }
                                    $que_logic_data .= "<th class='matrix-span' style=' width:" . $width . "' title='" . $col_header . "'>" . $col_header . "</th>";
                                }
                                //Display answer input (RadioButton or Checkbox)
                                else if ($j != 1 && $i != 1 && $cols->$col != null) {
                                    $que_logic_data .= "<td class='matrix-span' style='width:" . $width . "; '>"
                                            . "<input class='logic_required' type='checkbox'   value='{$col}_{$row}' name='logic_value_" . $logic_seq . "'/>"
                                            . "</td>";
                                }
                                // If no value then display none
                                else {
                                    $que_logic_data .= "";
                                }
                            }
                            $op++;
                        }
                        $que_logic_data .= "</tr>";
                    }
                    $que_logic_data .= "</table></div>";

                    $que_logic_data .= '</div>';
                    $que_logic_data .= "</div>";
                }

                return array('html' => $que_logic_data, 'logic_seq' => $logic_seq);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Function : save_survey
     *    save record of survey and survey template
     * 
     * @return string - $record_id 
     */
    public function save_survey($api, $args) {

        global $db, $sugar_config;
        //survey data
        $asurvey_data = json_decode($args['survey_data']);
        $record_id = $asurvey_data->record_id;
        $copy_logo_ImgID = $asurvey_data->survey_logo_imgID;
        // To save copy logo from old survey/survey temp to new survey/surveytemp.
        if (!empty($copy_logo_ImgID)) {
            $newlogoId = create_guid();
            require_once('include/upload_file.php');
            $uploadFile = new UploadFile();
            $isCopy = $uploadFile->duplicate_file($copy_logo_ImgID, $newlogoId);
            if ($isCopy) {
                $db->query("update bc_survey set survey_logo = '{$newlogoId}' where id = '{$record_id}'");
            }
        }
        // End govind
        $survey_bg_imgID = $asurvey_data->survey_bg_imgID;
        // To save copy logo from old survey/survey temp to new survey/surveytemp.
        if (!empty($survey_bg_imgID)) {
            $newbgId = create_guid();
            require_once('include/upload_file.php');
            $uploadFile = new UploadFile();
            $isCopy = $uploadFile->duplicate_file($survey_bg_imgID, $newbgId);
            if ($isCopy) {
                $db->query("update bc_survey set survey_background_image = '{$newbgId}' where id = '{$record_id}'");
            }
        }
        //survey page data
        $page_data = $asurvey_data->pages;
        $page_count = 1;
        foreach ($page_data as $pg_index => $page_data) {
            // Save Page
            $oSurveyPage = new bc_survey_pages();

            $oSurveyPage->name = $page_data->page_title;
            $oSurveyPage->page_number = $page_count;
            if (isset($args['type']) && $args['type'] == 'SurveyTemplate') {
                $oSurveyPage->type = 'SurveyTemplate';
            } else {
                $oSurveyPage->type = 'Survey';
            }
            $oSurveyPage->page_sequence = $page_count;
            $oSurveyPage->save();
            if (isset($args['type']) && $args['type'] == 'SurveyTemplate') {
                // Set replationship b/w Template and Survey page
                $oSurveyPage->load_relationship('bc_survey_pages_bc_survey_template');
                $oSurveyPage->bc_survey_pages_bc_survey_template->add($record_id);
            } else {
                // Set replationship b/w Survey and Survey page
                $oSurveyPage->load_relationship('bc_survey_pages_bc_survey');
                $oSurveyPage->bc_survey_pages_bc_survey->add($record_id);
            }

            $que_count = 1;
            foreach ($page_data->questions as $que_index => $que_data) {
                //Save Questions
                $oSurveyQue = new bc_survey_questions();

                if ($que_data->que_type == 'additional-text') {
                    $oSurveyQue->description = $que_data->question;
                } else {
                    $oSurveyQue->name = $que_data->question;
                }
                $oSurveyQue->question_type = $que_data->que_type;
                // set is required filed
                if (isset($que_data->is_required)) {
                    if ($que_data->is_required == 'true') {
                        $oSurveyQue->is_required = 1;
                    } else {
                        $oSurveyQue->is_required = 0;
                    }
                }
                // set is required filed
                if (isset($que_data->is_question_seperator)) {
                    if ($que_data->is_question_seperator == 'true') {
                        $oSurveyQue->is_question_seperator = 1;
                    } else {
                        $oSurveyQue->is_question_seperator = 0;
                    }
                }
                // set file size filed
                if (isset($que_data->file_size)) {
                    $oSurveyQue->file_size = $que_data->file_size;
                }
                // set file extension filed
                if (isset($que_data->file_extension)) {
                    $oSurveyQue->file_extension = implode(',', $que_data->file_extension);
                }
                // set is datetime field for DateTime que type
                if (isset($que_data->is_datetime)) {
                    if ($que_data->is_datetime == 'true') {
                        $oSurveyQue->is_datetime = 1;
                    } else {
                        $oSurveyQue->is_datetime = 0;
                    }
                }
                // set is sorting allowed field for multi choice type of question
                if (isset($que_data->is_sort)) {
                    if ($que_data->is_sort == 'true') {
                        $oSurveyQue->is_sort = 1;
                    } else {
                        $oSurveyQue->is_sort = 0;
                    }
                }
                // set minimum answer limit for multi choice type of question
                $oSurveyQue->limit_min = 0;
                if (isset($que_data->limit_min)) {
                    if (!empty($que_data->limit_min)) {
                        $oSurveyQue->limit_min = $que_data->limit_min;
                    }
                }
                // set enable other option for multi choice type of question
                if (isset($que_data->enable_otherOption)) {
                    if ($que_data->enable_otherOption == 'true') {
                        $oSurveyQue->enable_otherOption = 1;
                    } else {
                        $oSurveyQue->enable_otherOption = 0;
                    }
                }
                // set enable scoring or not
                if (isset($que_data->enable_scoring)) {
                    if ($que_data->enable_scoring == "1") {
                        $oSurveyQue->enable_scoring = 1;
                    } else {
                        $oSurveyQue->enable_scoring = 0;
                    }
                }
                // set Is image option or not
                if (isset($que_data->is_image_option)) {
                    if ($que_data->is_image_option == "1") {
                        $oSurveyQue->is_image_option = 1;
                    } else {
                        $oSurveyQue->is_image_option = 0;
                    }
                }
                // set Show Option Text or nor
                if (isset($que_data->show_option_text)) {
                    if ($que_data->show_option_text == "1") {
                        $oSurveyQue->show_option_text = 1;
                    } else {
                        $oSurveyQue->show_option_text = 0;
                    }
                }
                // store advance options
                if ($que_data->que_type == 'richtextareabox') {
                    $oSurveyQue->richtextContent = (isset($que_data->richTextContent)) ? $que_data->richTextContent : '';
                } else if ($oSurveyQue->question_type == 'textbox') {
                    //store datatype  for textbox question field
                    $oSurveyQue->advance_type = (isset($que_data->datatype)) ? $que_data->datatype : '';
                } else if ($oSurveyQue->question_type == 'contact-information') {
                    //store require fieldsfor contact information question field
                    $oSurveyQue->advance_type = (isset($que_data->requireFields)) ? $que_data->requireFields : '';
                } else if ($oSurveyQue->question_type == 'radio-button' || $oSurveyQue->question_type == 'check-box') {
                    //store display options for multichoice question field
                    $oSurveyQue->advance_type = (isset($que_data->display)) ? $que_data->display : 'Horizontal';
                } else if ($oSurveyQue->question_type == 'image') {
                    //store image url for image question field
                    if ($que_data->question == 'uploadImage') {
                        $isUpdate = true;
                        $oSurveyQue->matrix_row = (isset($que_data->image)) ? base64_encode($que_data->image) : '';
                        $oSurveyQue->advance_type = '';
                    } else {
                        $oSurveyQue->advance_type = (isset($que_data->image)) ? $que_data->image : '';
                    }
                } else if ($oSurveyQue->question_type == 'video') {
                    //store video url for video question field
                    $oSurveyQue->advance_type = (isset($que_data->video)) ? $que_data->video : '';
                } else if ($oSurveyQue->question_type == 'scale') {
                    //store labels for scale question field
                    $oSurveyQue->advance_type = (isset($que_data->label)) ? $que_data->label : '';
                } else if ($oSurveyQue->question_type == 'netpromoterscore') {
                    //store labels for scale question field
                    $oSurveyQue->advance_type = (isset($que_data->label_netpromoterscore)) ? $que_data->label_netpromoterscore : '';
                } else if ($oSurveyQue->question_type == 'matrix') {
                    //store display_type for matrix question field
                    $oSurveyQue->advance_type = (isset($que_data->display_type)) ? $que_data->display_type : '';
                }

                if ($oSurveyQue->question_type == 'textbox' || $oSurveyQue->question_type == 'commentbox') {
                    //store maxsize
                    $oSurveyQue->maxsize = (isset($que_data->maxsize)) ? $que_data->maxsize : '';
                } else if ($oSurveyQue->question_type == 'rating') {
                    //store star number for rating field
                    $oSurveyQue->maxsize = (isset($que_data->star_no)) ? $que_data->star_no : '';
                }

                if ($oSurveyQue->question_type == 'textbox') {
                    //store min & max value for textbox
                    $oSurveyQue->min = (isset($que_data->minvalue)) ? $que_data->minvalue : '';
                    $oSurveyQue->max = (isset($que_data->maxvalue)) ? $que_data->maxvalue : '';
                } else if ($oSurveyQue->question_type == 'commentbox') {
                    // stor allowed rows & cols for comment box textarea
                    $oSurveyQue->min = (isset($que_data->rows)) ? $que_data->rows : '';
                    $oSurveyQue->max = (isset($que_data->cols)) ? $que_data->cols : '';
                } else if ($oSurveyQue->question_type == 'date-time') {
                    // store allowed start & end date for date time question type
                    $oSurveyQue->min = (isset($que_data->start_date)) ? $que_data->start_date : '';
                    $oSurveyQue->max = (isset($que_data->end_date)) ? $que_data->end_date : '';

                    // set allow_future_dates field
                    if (isset($que_data->allow_future_dates)) {
                        if ($que_data->allow_future_dates == 'true') {
                            $oSurveyQue->allow_future_dates = 1;
                        } else {
                            $oSurveyQue->allow_future_dates = 0;
                        }
                    }
                } else if ($oSurveyQue->question_type == 'scale') {
                    // store allowed start & end date for scale question type
                    $oSurveyQue->min = (isset($que_data->start)) ? $que_data->start : '';
                    $oSurveyQue->max = (isset($que_data->end)) ? $que_data->end : '';
                }

                if ($oSurveyQue->question_type == 'matrix') {
                    //store rows & columns for matrix question field
                    $rows = (isset($que_data->rows)) ? json_encode($que_data->rows) : '';
                    $oSurveyQue->matrix_row = base64_encode($rows);
                    //cols
                    $cols = (isset($que_data->cols)) ? json_encode($que_data->cols) : '';
                    $oSurveyQue->matrix_col = base64_encode($cols);
                }
                //Video description
                if ($que_data->que_type != 'additional-text') {
                    $oSurveyQue->description = (isset($que_data->description)) ? $que_data->description : '';
                }

                $oSurveyQue->precision_value = (isset($que_data->precision)) ? $que_data->precision : '';
                $oSurveyQue->scale_slot = (isset($que_data->scale_slot)) ? $que_data->scale_slot : '';

                // set enable scoring or not
                if (isset($que_data->disable_piping)) {
                    if ($que_data->disable_piping == "1") {
                        $oSurveyQue->disable_piping = 1;
                        // Sync Field
                        $oSurveyQue->sync_field = '';
                    } else {
                        $oSurveyQue->disable_piping = 0;
                        // Sync Field
                        $oSurveyQue->sync_field = $que_data->sync_field;
                    }
                }


                $oSurveyQue->question_sequence = $que_count;
                $oSurveyQue->question_help_comment = isset($que_data->helptips) ? $que_data->helptips : '';
                $oSurveyQue->display_boolean_label = isset($que_data->display_boolean_label) ? $que_data->display_boolean_label : '';

                if ((isset($args['type']) && $args['type'] != 'SurveyTemplate' || !isset($args['type'])) && isset($que_data->survey_type) && $que_data->survey_type == 'poll') {
                    $survey_type = 'poll';
                } else if ((isset($args['type']) && $args['type'] != 'SurveyTemplate' || !isset($args['type']))) {
                    $survey_type = 'survey';
                } else {
                    $survey_type = 'survey';
                }
                $base_count = array();
                if (isset($que_data->answers)) {
                    foreach ($que_data->answers as $ans_index => $answer) {
                        // store all options weight
                        if (isset($answer->weight)) {
                            $weight = $answer->weight;
                            if (number_format($weight) > 0) {
                                $base_count[] = $weight;
                            }
                        }
                    }
                }

                $base_weight = 0;
                $other_weight = 0;
                if (isset($base_count) && !empty($base_count) && $oSurveyQue->question_type == 'radio-button' || $oSurveyQue->question_type == 'dropdownlist' || $oSurveyQue->question_type == 'boolean') {
                    $base_weight = max($base_count);
                } elseif ($oSurveyQue->question_type == 'check-box' || $oSurveyQue->question_type == 'multiselectlist') {

                    foreach ($base_count as $base_index => $weight) {
                        // get all options base weight
                        $base_weight = $base_weight + $weight;
                    }
                }
                if (isset($que_data->enable_otherOption) && $que_data->enable_otherOption == 'true' && ($oSurveyQue->question_type == 'check-box' || $oSurveyQue->question_type == 'multiselectlist')) {
                    $other_weight = $que_data->score_otherOption;
                    $new_weight = $other_weight + $base_weight;
                } else if (isset($que_data->enable_otherOption) && $que_data->enable_otherOption == 'true' && ($oSurveyQue->question_type == 'radio-button' || $oSurveyQue->question_type == 'dropdownlist')) {
                    $base_count[] = $que_data->score_otherOption;
                    if (isset($base_count) && !empty($base_count)) {
                        $new_weight = max($base_count);
                    }
                } else {
                    $new_weight = $base_weight;
                }
                $oSurveyQue->base_weight = $new_weight;
                $oSurveyQue->save();

                if ($oSurveyQue->question_type == 'image') {
                    //store image url for image question field
                    if ($que_data->question == 'uploadImage') {
                        $isUpdate = true;
                        $oSurveyQue->matrix_row = (isset($que_data->image)) ? base64_encode($que_data->image) : '';
                        $oSurveyQue->advance_type = '';

                        if ((isset($que_data->image))) {

                            require_once('include/upload_file.php');

                            $UploadStream = new UploadStream();

                            $data = $que_data->image;
                            $image_data = explode(',', $data);
                            $ext = explode('data:image/', $image_data[0]);
                            $ext_arr = explode(';base64', $ext[1]);
                            $final_ext = '.' . $ext_arr[0];

                            $ifp = $UploadStream->stream_open('123456789' . $oSurveyQue->id . $final_ext, "wb"); // Fix :: added dummy content bcz it get extracted letter in internal process

                            $UploadStream->stream_write(base64_decode($image_data[1]));

                            $UploadStream->stream_close();
                        }
                    }
                }

                // Set replationship b/w Survey page and Survey Questions
                //   $oSurveyQue->bc_survey_pages_bc_survey_questions->delete($oSurveyQue->id, $oSurveyPage->id);
                $oSurveyQue->load_relationship('bc_survey_pages_bc_survey_questions');
                $oSurveyQue->bc_survey_pages_bc_survey_questions->add($oSurveyPage->id);

                // Set replationship b/w Survey and Survey Questions
                //    $oSurveyQue->bc_survey_bc_survey_questions->delete($oSurveyQue->id, $survey->id);
                $oSurveyQue->load_relationship('bc_survey_bc_survey_questions');
                $oSurveyQue->bc_survey_bc_survey_questions->add($record_id);

                //Save Survey Answers
                $ans_count = 1;

                if (isset($que_data->answers)) {
                    foreach ($que_data->answers as $ans_index => $answer) {
                        $oSurveyAns = new bc_survey_answers();
                        $oSurveyAns->answer_name = $answer->option;
                        $oSurveyAns->name = $answer->option; // fix for report module support
                        if (isset($answer->weight)) {
                            $oSurveyAns->score_weight = $answer->weight;
                        }
                        $oSurveyAns->answer_sequence = $ans_count;
                        if ($que_data->is_image_option == "1" && !empty($answer->radio_image)) {
                            $oSurveyAns->radio_image = $answer->radio_image;
                        }
                        $ansID = $oSurveyAns->save();

                        if ($que_data->is_image_option == "1" && !empty($answer->radio_image)) {
                            $oSurveyAns->radio_image = $answer->radio_image;
                            require_once('include/upload_file.php');

                            $UploadStream = new UploadStream();

                            $data = $answer->radio_image;
                            $image_data = explode(',', $data);
                            $ext = explode('data:image/', $image_data[0]);
                            $ext_arr = explode(';base64', $ext[1]);
                            $final_ext = '.' . $ext_arr[0];

                            $ifp = $UploadStream->stream_open('123456789' . $ansID . $final_ext, "wb"); // Fix :: added dummy content bcz it get extracted letter in internal process

                            $UploadStream->stream_write(base64_decode($image_data[1]));

                            $UploadStream->stream_close();
                        }
                        //set rlationship b/w Survey question and Survey answers
                        //    $oSurveyAns->bc_survey_answers_bc_survey_questions->delete($oSurveyAns->id, $oSurveyQue->id);
                        $oSurveyAns->load_relationship('bc_survey_answers_bc_survey_questions');
                        $oSurveyAns->bc_survey_answers_bc_survey_questions->add($oSurveyQue->id);
                        $ans_count++;
                    }
                }
                // Store other option as answer
                if (isset($que_data->enable_otherOption) && $que_data->enable_otherOption == 'true') {
                    $oSurveyAns = new bc_survey_answers();
                    $oSurveyAns->answer_name = $que_data->label_otherOption;
                    $oSurveyAns->name = $que_data->label_otherOption; // fix for report module support
                    $oSurveyAns->score_weight = $que_data->score_otherOption;
                    $oSurveyAns->answer_type = 'other';
                    $oSurveyAns->answer_sequence = $ans_count;

                    if ($que_data->is_image_option == "1" && !empty($answer->radio_image)) {
                        $oSurveyAns->radio_image = $que_data->image_otherOption;
                    }

                    $ansID = $oSurveyAns->save();
                    // Image for Other Option
                    if ($que_data->is_image_option == "1" && isset($que_data->image_otherOption)) {
                        $oSurveyAns->radio_image = $que_data->image_otherOption;
                        require_once('include/upload_file.php');
                        $UploadStream = new UploadStream();

                        $data = $que_data->image_otherOption;
                        $image_data = explode(',', $data);
                        $ext = explode('data:image/', $image_data[0]);
                        $ext_arr = explode(';base64', $ext[1]);
                        $final_ext = '.' . $ext_arr[0];

                        $ifp = $UploadStream->stream_open('123456789' . $ansID . $final_ext, "wb"); // Fix :: added dummy content bcz it get extracted letter in internal process

                        $UploadStream->stream_write(base64_decode($image_data[1]));

                        $UploadStream->stream_close();
                    }

                    //set rlationship b/w Survey question and Survey answers
                    //    $oSurveyAns->bc_survey_answers_bc_survey_questions->delete($oSurveyAns->id, $oSurveyQue->id);
                    $oSurveyAns->load_relationship('bc_survey_answers_bc_survey_questions');
                    $oSurveyAns->bc_survey_answers_bc_survey_questions->add($oSurveyQue->id);
                }

                $que_count++;
            }
            $page_count++;
        }

        if ((isset($args['type']) && $args['type'] != "SurveyTemplate") || !isset($args['type'])) {

            //Get Survey Questions score weight
            $obSurvey = new bc_survey();
            $obSurvey->retrieve($record_id);
            $obSurvey->load_relationship('bc_survey_bc_survey_questions');

            $base_score = 0;
            foreach ($obSurvey->bc_survey_bc_survey_questions->getBeans() as $survey_questions) {
                // if scoring is enabled
                if (isset($survey_questions->enable_scoring) && $survey_questions->enable_scoring == 1) {
                    $base_score = $base_score + number_format($survey_questions->base_weight);
                }
            }

            require_once('include/upload_file.php');
            //save survey theme

            $survey_logo = $obSurvey->survey_logo;
            $survey_theme = (!empty($asurvey_data->survey_theme)) ? $asurvey_data->survey_theme : 'theme0';

            $uploadFile = new UploadFile();

            //get the file location
            $uploadFile->temp_file_location = UploadFile::get_upload_path($survey_logo);
            $file_contents = addslashes($uploadFile->get_file_contents());

            // Upload Survey Logo with Image file extension
            if ((isset($survey_logo)) && !empty($survey_logo)) {

                $UploadStream = new UploadStream();

                $final_ext = '.' . $this->getImgType('upload/' . $survey_logo);

                $GLOBALS['log']->fatal('This is the $img_upload : --- ', print_r($img_arr, 1));
                $uploadFile->duplicate_file($survey_logo, $survey_logo . $final_ext);
            }

            if (!empty($obSurvey->survey_background_image)) {
                $survey_background_image = $obSurvey->survey_background_image;
                //get the file location
                $uploadFile->temp_file_location = UploadFile::get_upload_path($survey_background_image);
                $survey_background_image_file_contents = addslashes($uploadFile->get_file_contents());
            }

            $db->query("UPDATE bc_survey SET image = '{$file_contents}', background_image_lb = '{$survey_background_image_file_contents}', survey_theme = '{$survey_theme}',base_score = {$base_score},default_survey_language = '{$sugar_config['default_language']}',survey_type='{$survey_type}' WHERE id = '{$record_id}' ");
        }
        return $record_id;
    }

    /**
     * Function : get_survey
     *    get survey detail
     * 
     * @return array - $data 
     */
    public function get_survey($api, $args) {
        $record_id = $args['record_id'];
        if ((isset($args['type']) && $args['type'] != 'SurveyTemplate' || !isset($args['type']))) {
            $oSurvey = new bc_survey();
            $oSurvey->retrieve($record_id);
            $survey_theme = $oSurvey->survey_theme;
            $oSurvey->load_relationship('bc_survey_pages_bc_survey');
        } else {
            $oSurvey = new bc_survey_template();
            $oSurvey->retrieve($record_id);
            $oSurvey->load_relationship('bc_survey_pages_bc_survey_template');
        }
        $oSurvey_details = array();
        $questions = array();
        if ((isset($args['type']) && $args['type'] != 'SurveyTemplate' || !isset($args['type']))) {
            foreach ($oSurvey->bc_survey_pages_bc_survey->getBeans() as $pages) {
                unset($questions);
                $survey_details[$pages->page_sequence]['page_title'] = $pages->name;
                $survey_details[$pages->page_sequence]['page_number'] = $pages->page_number;
                $survey_details[$pages->page_sequence]['page_id'] = $pages->id;
                $pages->load_relationship('bc_survey_pages_bc_survey_questions');
                foreach ($pages->bc_survey_pages_bc_survey_questions->getBeans() as $survey_questions) {
                    $questions[$survey_questions->question_sequence]['que_id'] = $survey_questions->id;
                    if ($survey_questions->question_type == 'additional-text') {
                        $questions[$survey_questions->question_sequence]['que_title'] = $survey_questions->description;
                    } else {
                        $questions[$survey_questions->question_sequence]['que_title'] = $survey_questions->name;
                    }
                    $questions[$survey_questions->question_sequence]['richtextContent'] = $survey_questions->richtextContent;
                    $questions[$survey_questions->question_sequence]['que_type'] = $survey_questions->question_type;
                    $questions[$survey_questions->question_sequence]['question_help_comment'] = (empty($survey_questions->question_help_comment)) ? 'N/A' : $survey_questions->question_help_comment;
                    $questions[$survey_questions->question_sequence]['display_boolean_label'] = (empty($survey_questions->display_boolean_label)) ? 'N/A' : $survey_questions->display_boolean_label;
                    $questions[$survey_questions->question_sequence]['is_required'] = ($survey_questions->is_required == 1) ? 'Yes' : 'No';
                    $questions[$survey_questions->question_sequence]['is_question_seperator'] = ($survey_questions->is_question_seperator == 1) ? 'Yes' : 'No';
                    $questions[$survey_questions->question_sequence]['file_size'] = $survey_questions->file_size;
                    $questions[$survey_questions->question_sequence]['file_extension'] = $survey_questions->file_extension;
                    $questions[$survey_questions->question_sequence]['enable_scoring'] = ($survey_questions->enable_scoring == 1) ? 'Yes' : 'No';
                    $questions[$survey_questions->question_sequence]['sync_field'] = $survey_questions->sync_field;
                    $questions[$survey_questions->question_sequence]['is_image_option'] = ($survey_questions->is_image_option == 1) ? 'Yes' : 'No';
                    $questions[$survey_questions->question_sequence]['show_option_text'] = ($survey_questions->show_option_text == 1) ? 'Yes' : 'No';

                    //advance options
                    $questions[$survey_questions->question_sequence]['advance_type'] = (isset($survey_questions->advance_type)) ? $survey_questions->advance_type : '';
                    $questions[$survey_questions->question_sequence]['maxsize'] = (isset($survey_questions->maxsize)) ? $survey_questions->maxsize : '';
                    $questions[$survey_questions->question_sequence]['min'] = (isset($survey_questions->min)) ? $survey_questions->min : '';
                    $questions[$survey_questions->question_sequence]['max'] = (isset($survey_questions->max)) ? $survey_questions->max : '';
                    $questions[$survey_questions->question_sequence]['precision'] = (isset($survey_questions->precision_value)) ? $survey_questions->precision_value : '';
                    $questions[$survey_questions->question_sequence]['scale_slot'] = (isset($survey_questions->scale_slot)) ? $survey_questions->scale_slot : '';
                    $questions[$survey_questions->question_sequence]['is_datetime'] = (isset($survey_questions->is_datetime) && $survey_questions->is_datetime == 1 ) ? 'Yes' : 'No';
                    $questions[$survey_questions->question_sequence]['is_sort'] = (isset($survey_questions->is_sort) && $survey_questions->is_sort == 1 ) ? 'Yes' : 'No';
                    $questions[$survey_questions->question_sequence]['limit_min'] = (isset($survey_questions->limit_min)) ? $survey_questions->limit_min : '';
                    $questions[$survey_questions->question_sequence]['enable_otherOption'] = (isset($survey_questions->enable_otherOption) && $survey_questions->enable_otherOption == 1 ) ? 'Yes' : 'No';
                    $questions[$survey_questions->question_sequence]['matrix_row'] = (isset($survey_questions->matrix_row)) ? base64_decode($survey_questions->matrix_row) : '';
                    $questions[$survey_questions->question_sequence]['matrix_col'] = (isset($survey_questions->matrix_col)) ? base64_decode($survey_questions->matrix_col) : '';
                    $questions[$survey_questions->question_sequence]['description'] = (isset($survey_questions->description)) ? $survey_questions->description : '';
                    $questions[$survey_questions->question_sequence]['disable_piping'] = (isset($survey_questions->disable_piping) && $survey_questions->disable_piping == 1 ) ? 'Yes' : 'No';
                    $questions[$survey_questions->question_sequence]['allow_future_dates'] = (isset($survey_questions->allow_future_dates) && $survey_questions->allow_future_dates == 1 ) ? 'Yes' : 'No';

                    $survey_questions->load_relationship('bc_survey_answers_bc_survey_questions');
                    foreach ($survey_questions->bc_survey_answers_bc_survey_questions->getBeans() as $survey_answers) {
                        if ($survey_answers->answer_type != 'other') {
                            $questions[$survey_questions->question_sequence]['answers'][$survey_answers->answer_sequence][$survey_answers->id]['option'] = $survey_answers->answer_name;
                            $questions[$survey_questions->question_sequence]['answers'][$survey_answers->answer_sequence][$survey_answers->id]['weight'] = $survey_answers->score_weight;
                            $questions[$survey_questions->question_sequence]['answers'][$survey_answers->answer_sequence][$survey_answers->id]['answer_type'] = $survey_answers->answer_type;
                            $questions[$survey_questions->question_sequence]['answers'][$survey_answers->answer_sequence][$survey_answers->id]['radio_image'] = $survey_answers->radio_image;
                        } else {
                            $questions[$survey_questions->question_sequence]['other_option'][$survey_answers->id]['option'] = $survey_answers->answer_name;
                            $questions[$survey_questions->question_sequence]['other_option'][$survey_answers->id]['weight'] = $survey_answers->score_weight;
                            $questions[$survey_questions->question_sequence]['other_option'][$survey_answers->id]['answer_type'] = $survey_answers->answer_type;
                            $questions[$survey_questions->question_sequence]['other_option'][$survey_answers->id]['other_image'] = $survey_answers->radio_image;
                        }
                        //To add stored skip logic action and targets on option/answer based
                        $questions[$survey_questions->question_sequence]['skip_logic'][$survey_answers->id]['logic_action'] = $survey_answers->logic_action;
                        $questions[$survey_questions->question_sequence]['skip_logic'][$survey_answers->id]['logic_target'] = $survey_answers->logic_target;
                        // End
                    }
                    if (isset($questions[$survey_questions->question_sequence]['answers']) && is_array($questions[$survey_questions->question_sequence]['answers']))
                        ksort($questions[$survey_questions->question_sequence]['answers']);
                }
                ksort($questions);
                $survey_details[$pages->page_sequence]['page_questions'] = $questions;
                $survey_details['survey_theme'] = $survey_theme;
                $survey_details['enable_data_piping'] = (isset($oSurvey->enable_data_piping) && $oSurvey->enable_data_piping == 1 ) ? 'Yes' : 'No';
            }
        } else {
            foreach ($oSurvey->bc_survey_pages_bc_survey_template->getBeans() as $pages) {
                unset($questions);
                $survey_details[$pages->page_sequence]['page_title'] = $pages->name;
                $survey_details[$pages->page_sequence]['page_number'] = $pages->page_number;
                $survey_details[$pages->page_sequence]['page_id'] = $pages->id;
                $pages->load_relationship('bc_survey_pages_bc_survey_questions');
                foreach ($pages->bc_survey_pages_bc_survey_questions->getBeans() as $survey_questions) {
                    $questions[$survey_questions->question_sequence]['que_id'] = $survey_questions->id;
                    if ($survey_questions->question_type == 'additional-text') {
                        $questions[$survey_questions->question_sequence]['que_title'] = $survey_questions->description;
                    } else {
                        $questions[$survey_questions->question_sequence]['que_title'] = $survey_questions->name;
                    }
                    $questions[$survey_questions->question_sequence]['richtextContent'] = $survey_questions->richtextContent;
                    $questions[$survey_questions->question_sequence]['que_type'] = $survey_questions->question_type;
                    $questions[$survey_questions->question_sequence]['question_help_comment'] = (empty($survey_questions->question_help_comment)) ? 'N/A' : $survey_questions->question_help_comment;
                    $questions[$survey_questions->question_sequence]['display_boolean_label'] = (empty($survey_questions->display_boolean_label)) ? 'N/A' : $survey_questions->display_boolean_label;
                    $questions[$survey_questions->question_sequence]['is_required'] = ($survey_questions->is_required == 1) ? 'Yes' : 'No';
                    $questions[$survey_questions->question_sequence]['is_question_seperator'] = ($survey_questions->is_question_seperator == 1) ? 'Yes' : 'No';
                    $questions[$survey_questions->question_sequence]['file_size'] = $survey_questions->file_size;
                    $questions[$survey_questions->question_sequence]['file_extension'] = $survey_questions->file_extension;
                    $questions[$survey_questions->question_sequence]['enable_scoring'] = ($survey_questions->enable_scoring == 1) ? 'Yes' : 'No';
                    $questions[$survey_questions->question_sequence]['is_image_option'] = ($survey_questions->is_image_option == 1) ? 'Yes' : 'No';
                    $questions[$survey_questions->question_sequence]['show_option_text'] = ($survey_questions->show_option_text == 1) ? 'Yes' : 'No';

                    //advance options
                    $questions[$survey_questions->question_sequence]['advance_type'] = (isset($survey_questions->advance_type)) ? $survey_questions->advance_type : '';
                    $questions[$survey_questions->question_sequence]['maxsize'] = (isset($survey_questions->maxsize)) ? $survey_questions->maxsize : '';
                    $questions[$survey_questions->question_sequence]['min'] = (isset($survey_questions->min)) ? $survey_questions->min : '';
                    $questions[$survey_questions->question_sequence]['max'] = (isset($survey_questions->max)) ? $survey_questions->max : '';
                    $questions[$survey_questions->question_sequence]['precision'] = (isset($survey_questions->precision_value)) ? $survey_questions->precision_value : '';
                    $questions[$survey_questions->question_sequence]['scale_slot'] = (isset($survey_questions->scale_slot)) ? $survey_questions->scale_slot : '';
                    $questions[$survey_questions->question_sequence]['is_datetime'] = (isset($survey_questions->is_datetime) && $survey_questions->is_datetime == 1 ) ? 'Yes' : 'No';
                    $questions[$survey_questions->question_sequence]['is_sort'] = (isset($survey_questions->is_sort) && $survey_questions->is_sort == 1 ) ? 'Yes' : 'No';
                    $questions[$survey_questions->question_sequence]['limit_min'] = (isset($survey_questions->limit_min)) ? $survey_questions->limit_min : '';
                    $questions[$survey_questions->question_sequence]['enable_otherOption'] = (isset($survey_questions->enable_otherOption) && $survey_questions->enable_otherOption == 1 ) ? 'Yes' : 'No';
                    $questions[$survey_questions->question_sequence]['matrix_row'] = (isset($survey_questions->matrix_row)) ? base64_decode($survey_questions->matrix_row) : '';
                    $questions[$survey_questions->question_sequence]['matrix_col'] = (isset($survey_questions->matrix_col)) ? base64_decode($survey_questions->matrix_col) : '';
                    $questions[$survey_questions->question_sequence]['description'] = (isset($survey_questions->description)) ? $survey_questions->description : '';
                    $questions[$survey_questions->question_sequence]['allow_future_dates'] = (isset($survey_questions->allow_future_dates) && $survey_questions->allow_future_dates == 1 ) ? 'Yes' : 'No';

                    $survey_questions->load_relationship('bc_survey_answers_bc_survey_questions');
                    foreach ($survey_questions->bc_survey_answers_bc_survey_questions->getBeans() as $survey_answers) {
                        if ($survey_answers->answer_type != 'other') {
                            $questions[$survey_questions->question_sequence]['answers'][$survey_answers->answer_sequence][$survey_answers->id]['option'] = htmlspecialchars_decode($survey_answers->answer_name);
                            $questions[$survey_questions->question_sequence]['answers'][$survey_answers->answer_sequence][$survey_answers->id]['weight'] = $survey_answers->score_weight;
                            $questions[$survey_questions->question_sequence]['answers'][$survey_answers->answer_sequence][$survey_answers->id]['answer_type'] = $survey_answers->answer_type;
                            $questions[$survey_questions->question_sequence]['answers'][$survey_answers->answer_sequence][$survey_answers->id]['radio_image'] = $survey_answers->radio_image;
                        } else {
                            $questions[$survey_questions->question_sequence]['other_option'][$survey_answers->id]['option'] = $survey_answers->answer_name;
                            $questions[$survey_questions->question_sequence]['other_option'][$survey_answers->id]['weight'] = $survey_answers->score_weight;
                            $questions[$survey_questions->question_sequence]['other_option'][$survey_answers->id]['answer_type'] = $survey_answers->answer_type;
                            $questions[$survey_questions->question_sequence]['other_option'][$survey_answers->id]['other_image'] = $survey_answers->radio_image;
                        }
                    }
                    if (isset($questions[$survey_questions->question_sequence]['answers']) && is_array($questions[$survey_questions->question_sequence]['answers']))
                        ksort($questions[$survey_questions->question_sequence]['answers']);
                }

                if (isset($questions) && !empty($questions)) {
                    ksort($questions);
                }
                $survey_details[$pages->page_sequence]['page_questions'] = $questions;
                $survey_details['survey_theme'] = $survey_theme;
            }
        }
        if (isset($survey_details) && !empty($survey_details)) {
            ksort($survey_details);
            $data = json_encode($survey_details);
            return $data;
        } else {
            return '';
        }
    }

    /**
     * Function : save_edited_survey
     *    save edited record of survey and survey template
     * 
     * @return string - $record_id 
     */
    public function save_edited_survey($api, array $args) {

        global $db;
        //survey edited data
        $aedited_survey_data = json_decode($args['edited_survey_data']);

        $record_id = $args['survey_id'];
        $individual_edit = $args['individual_edit'];
        //survey page data
        $page_data = $aedited_survey_data->pages;
        $que_ids_saved = array();
        $page_seq = 0;
        foreach ($page_data as $pg_index => $page_data) {
            $page_seq++;
            $pos_page = strpos($pg_index, 'page_');
            if ($pos_page === false) {
                $new_page_id = '';
            } else {
                $new_page_id = explode('_', $pg_index);
            }
            // Save Page
            $oSurveyPage = new bc_survey_pages();
            if (empty($new_page_id)) {
                $oSurveyPage->id = $pg_index;
            }
            if (isset($oSurveyPage->id)) {
                $oSurveyPage->retrieve($oSurveyPage->id);
            }
            $oSurveyPage->name = $page_data->page_title;
            if ($individual_edit) {
                $oSurveyPage->page_number = $page_data->page_sequence;
                $oSurveyPage->page_sequence = $page_data->page_sequence;
            } else {
                $oSurveyPage->page_number = $page_seq;
                $oSurveyPage->page_sequence = $page_seq;
            }
            if ($args['type'] != "SurveyTemplate") {
                $oSurveyPage->type = 'Survey';
            } else {
                $oSurveyPage->type = 'SurveyTemplate';
            }

            $oSurveyPage->save();

            // Set replationship b/w Survey and Survey page
            if ($args['type'] != "SurveyTemplate") {
                $oSurveyPage->load_relationship('bc_survey_pages_bc_survey');
                $oSurveyPage->bc_survey_pages_bc_survey->add($record_id);
            } else {
                $oSurveyPage->load_relationship('bc_survey_pages_bc_survey_template');
                $oSurveyPage->bc_survey_pages_bc_survey_template->add($record_id);
            }
            $que_seq = 0;
            // if (is_array($page_data)) {
            foreach ($page_data->questions as $que_index => $que_data) {
                $que_seq++;
                $pos_que = strpos($que_index, 'question_');
                if ($pos_que === false) {
                    $new_question_id = '';
                } else {
                    $new_question_id = explode('_', $que_index);
                }
                //Save Questions
                $oSurveyQue = new bc_survey_questions();
                if (empty($new_question_id)) {
                    array_push($que_ids_saved, $que_index);
                    $oSurveyQue->id = $que_index;
                }
                if (isset($oSurveyQue->id)) {
                    $oSurveyQue->retrieve($oSurveyQue->id);
                }
                if ($que_data->que_type == 'additional-text') {
                    $oSurveyQue->description = $que_data->question;
                } else {
                    $oSurveyQue->name = $que_data->question;
                }
                $oSurveyQue->question_type = $que_data->que_type;
                if (isset($que_data->is_required)) {
                    if ($que_data->is_required == 'true') {
                        $oSurveyQue->is_required = 1;
                    } else {
                        $oSurveyQue->is_required = 0;
                    }
                }
                if (isset($que_data->is_question_seperator)) {
                    if ($que_data->is_question_seperator == 'true') {
                        $oSurveyQue->is_question_seperator = 1;
                    } else {
                        $oSurveyQue->is_question_seperator = 0;
                    }
                }

                // set file size filed
                if (isset($que_data->file_size)) {
                    $oSurveyQue->file_size = $que_data->file_size;
                }
                // set file extension filed
                if (isset($que_data->file_extension)) {
                    $oSurveyQue->file_extension = implode(',', $que_data->file_extension);
                }
                if (isset($que_data->is_datetime)) {
                    if ($que_data->is_datetime == 'true') {
                        $oSurveyQue->is_datetime = 1;
                    } else {
                        $oSurveyQue->is_datetime = 0;
                    }
                }
                if (isset($que_data->is_sort)) {
                    if ($que_data->is_sort == 'true') {
                        $oSurveyQue->is_sort = 1;
                    } else {
                        $oSurveyQue->is_sort = 0;
                    }
                }
                // set minimum answer limit for multi choice type of question
                $oSurveyQue->limit_min = 0;
                if (isset($que_data->limit_min)) {
                    if (!empty($que_data->limit_min)) {
                        $oSurveyQue->limit_min = $que_data->limit_min;
                    }
                }
                // set enable other option for multi choice type of question
                if (isset($que_data->enable_otherOption)) {
                    if ($que_data->enable_otherOption == 'true') {
                        $oSurveyQue->enable_otherOption = 1;
                    } else {
                        $oSurveyQue->enable_otherOption = 0;
                    }
                }
                // set enable scoring or not
                if (isset($que_data->enable_scoring)) {
                    if ($que_data->enable_scoring == "1") {
                        $oSurveyQue->enable_scoring = 1;
                    } else {
                        $oSurveyQue->enable_scoring = 0;
                    }
                }
                // set Is image option or not
                if (isset($que_data->is_image_option)) {
                    if ($que_data->is_image_option == "1") {
                        $oSurveyQue->is_image_option = 1;
                    } else {
                        $oSurveyQue->is_image_option = 0;
                    }
                }
                // set Show Option Text or nor
                if (isset($que_data->show_option_text)) {
                    if ($que_data->show_option_text == "1") {
                        $oSurveyQue->show_option_text = 1;
                    } else {
                        $oSurveyQue->show_option_text = 0;
                    }
                }
                // store advance options
                if ($que_data->que_type == 'richtextareabox') {
                    $oSurveyQue->richtextContent = (isset($que_data->richTextContent)) ? $que_data->richTextContent : '';
                } else if ($oSurveyQue->question_type == 'textbox') {
                    //store datatype  for textbox question field
                    $oSurveyQue->advance_type = (isset($que_data->datatype)) ? $que_data->datatype : '';
                } else if ($oSurveyQue->question_type == 'contact-information') {
                    //store require fieldsfor contact information question field
                    $oSurveyQue->advance_type = (isset($que_data->requireFields)) ? $que_data->requireFields : '';
                } else if ($oSurveyQue->question_type == 'radio-button' || $oSurveyQue->question_type == 'check-box') {
                    //store display options for multichoice question field
                    $oSurveyQue->advance_type = (isset($que_data->display)) ? $que_data->display : 'Horizontal';
                } else if ($oSurveyQue->question_type == 'image') {
                    //store image url for image question field
                    if ($que_data->question == 'uploadImage') {
                        $isUpdate = true;
                        $oSurveyQue->matrix_row = (isset($que_data->image)) ? base64_encode($que_data->image) : '';
                        $oSurveyQue->advance_type = '';
                    } else {
                        $oSurveyQue->advance_type = (isset($que_data->image)) ? $que_data->image : '';
                    }
                } else if ($oSurveyQue->question_type == 'video') {
                    //store video url for video question field
                    $oSurveyQue->advance_type = (isset($que_data->video)) ? $que_data->video : '';
                } else if ($oSurveyQue->question_type == 'scale') {
                    //store labels for scale question field
                    $oSurveyQue->advance_type = (isset($que_data->label)) ? $que_data->label : '';
                } else if ($oSurveyQue->question_type == 'netpromoterscore') {
                    //store labels for scale question field
                    $oSurveyQue->advance_type = (isset($que_data->label_netpromoterscore)) ? $que_data->label_netpromoterscore : '';
                } else if ($oSurveyQue->question_type == 'matrix') {
                    //store display_type for matrix question field
                    $oSurveyQue->advance_type = (isset($que_data->display_type)) ? $que_data->display_type : '';
                }


                if ($oSurveyQue->question_type == 'textbox' || $oSurveyQue->question_type == 'commentbox') {
                    $oSurveyQue->maxsize = (isset($que_data->maxsize)) ? $que_data->maxsize : '';
                } else if ($oSurveyQue->question_type == 'rating') {
                    $oSurveyQue->maxsize = (isset($que_data->star_no)) ? $que_data->star_no : '';
                }

                if ($oSurveyQue->question_type == 'textbox') {
                    $oSurveyQue->min = (isset($que_data->minvalue)) ? $que_data->minvalue : '';
                    $oSurveyQue->max = (isset($que_data->maxvalue)) ? $que_data->maxvalue : '';
                } else if ($oSurveyQue->question_type == 'commentbox') {
                    $oSurveyQue->min = (isset($que_data->rows)) ? $que_data->rows : '';
                    $oSurveyQue->max = (isset($que_data->cols)) ? $que_data->cols : '';
                } else if ($oSurveyQue->question_type == 'date-time') {
                    // store allowed start & end date for date time question type
                    $oSurveyQue->min = (isset($que_data->start_date)) ? $que_data->start_date : '';
                    $oSurveyQue->max = (isset($que_data->end_date)) ? $que_data->end_date : '';

                    // set allow_future_dates field
                    if (isset($que_data->allow_future_dates)) {
                        if ($que_data->allow_future_dates == 'true') {
                            $oSurveyQue->allow_future_dates = 1;
                        } else {
                            $oSurveyQue->allow_future_dates = 0;
                        }
                    }
                } else if ($oSurveyQue->question_type == 'scale') {
                    // store allowed start & end date for scale question type
                    $oSurveyQue->min = (isset($que_data->start)) ? $que_data->start : '';
                    $oSurveyQue->max = (isset($que_data->end)) ? $que_data->end : '';
                }

                if ($oSurveyQue->question_type == 'matrix') {
                    //store rows & columns for matrix question field
                    $rows = (isset($que_data->rows)) ? json_encode($que_data->rows) : '';
                    $oSurveyQue->matrix_row = base64_encode($rows);
                    //cols
                    $cols = (isset($que_data->cols)) ? json_encode($que_data->cols) : '';
                    $oSurveyQue->matrix_col = base64_encode($cols);
                }
                //Video description
                if ($que_data->que_type != 'additional-text') {
                    $oSurveyQue->description = (isset($que_data->description)) ? $que_data->description : '';
                }

                $oSurveyQue->precision_value = (isset($que_data->precision)) ? $que_data->precision : '';
                $oSurveyQue->scale_slot = (isset($que_data->scale_slot)) ? $que_data->scale_slot : '';



                // set enable scoring or not
                if (isset($que_data->disable_piping)) {
                    if ($que_data->disable_piping == "1") {
                        $oSurveyQue->disable_piping = 1;
                        // Sync Field
                        $oSurveyQue->sync_field = '';
                    } else {
                        $oSurveyQue->disable_piping = 0;
                        // Sync Field
                        $oSurveyQue->sync_field = $que_data->sync_field;
                    }
                }

                $oSurveyQue->question_sequence = $que_seq;
                $oSurveyQue->question_help_comment = isset($que_data->helptips) ? $que_data->helptips : '';
                $oSurveyQue->display_boolean_label = isset($que_data->display_boolean_label) ? $que_data->display_boolean_label : ''; // 2
                $oSurveyQue->is_skip_logic = 0;
                //Check if skip logic apply for question
                if (isset($que_data->skip_logic)) {
                    $skipLogicArr = (array) $que_data->skip_logic;
                    foreach ($skipLogicArr as $keyLQid => $logicArray) {
                        if (isset($logicArray->logic_action) && $logicArray->logic_action != 'no_logic' && !empty($logicArray->logic_action)) {
                            $isLogic = true;
                        }
                    }
                    if (isset($isLogic) && $isLogic == true) {
                        $oSurveyQue->is_skip_logic = 1;
                    }
                }
                //End
                $base_count = array();
                if (isset($que_data->answers)) {
                    foreach ($que_data->answers as $ans_index => $answer) {
                        // store all options weight
                        if (isset($answer->weight)) {
                            $weight = $answer->weight;
                        } else {
                            $weight = 0;
                        }
                        if (number_format($weight) > 0) {
                            $base_count[] = $weight;
                        }
                    }
                }

                $base_weight = 0;
                $other_weight = 0;
                if (isset($base_count) && !empty($base_count) && ($oSurveyQue->question_type == 'radio-button' || $oSurveyQue->question_type == 'dropdownlist' || $oSurveyQue->question_type == 'boolean')) {
                    $base_weight = max($base_count);
                } elseif ($oSurveyQue->question_type == 'check-box' || $oSurveyQue->question_type == 'multiselectlist') {

                    foreach ($base_count as $base_index => $weight) {
                        // get all options base weight
                        $base_weight = $base_weight + $weight;
                    }
                }
                // Store other option as answer
                if (isset($que_data->enable_otherOption) && $que_data->enable_otherOption == 'true' && ($oSurveyQue->question_type == 'check-box' || $oSurveyQue->question_type == 'multiselectlist')) {
                    $other_weight = $que_data->score_otherOption;
                    $new_weight = $other_weight + $base_weight;
                } else if (isset($que_data->enable_otherOption) && $que_data->enable_otherOption == 'true' && ($oSurveyQue->question_type == 'radio-button' || $oSurveyQue->question_type == 'dropdownlist')) {
                    $base_count[] = $que_data->score_otherOption;
                    if (!empty($base_count)) {
                        $new_weight = max($base_count);
                    }
                } else {
                    $new_weight = $base_weight;
                }
                $new_weight = $other_weight + $base_weight;
                $oSurveyQue->base_weight = $new_weight;
                $oSurveyQue->save();

                if ($oSurveyQue->question_type == 'image') {
                    //store image url for image question field
                    if ($que_data->question == 'uploadImage') {
                        $isUpdate = true;
                        $oSurveyQue->matrix_row = (isset($que_data->image)) ? base64_encode($que_data->image) : '';
                        $oSurveyQue->advance_type = '';

                        if ((isset($que_data->image))) {

                            require_once('include/upload_file.php');

                            $UploadStream = new UploadStream();

                            $data = $que_data->image;
                            $image_data = explode(',', $data);
                            $ext = explode('data:image/', $image_data[0]);
                            $ext_arr = explode(';base64', $ext[1]);
                            $final_ext = '.' . $ext_arr[0];

                            $ifp = $UploadStream->stream_open('123456789' . $oSurveyQue->id . $final_ext, "wb"); // Fix :: added dummy content bcz it get extracted letter in internal process

                            $UploadStream->stream_write(base64_decode($image_data[1]));

                            $UploadStream->stream_close();
                        }
                    }
                }


                $oSurveyQue->load_relationship('bc_survey_pages_bc_survey_questions');
                $oSurveyQue->bc_survey_pages_bc_survey_questions->add($oSurveyPage->id);
                $oSurveyQue->load_relationship('bc_survey_bc_survey_questions');
                $oSurveyQue->bc_survey_bc_survey_questions->add($record_id);

                // Retrieve related other option id
                $other_option_id = '';
                $oSurveyQue->load_relationship('bc_survey_answers_bc_survey_questions');
                foreach ($oSurveyQue->bc_survey_answers_bc_survey_questions->getBeans() as $oAns) {
                    if ($oAns->answer_type == 'other') {
                        $other_option_id = $oAns->id;
                    }
                }


                //remove survey answers (options & its relationship) for editing question type from multichoice to any other

                $oSurveyQue->load_relationship('bc_survey_answers_bc_survey_questions');
                foreach ($oSurveyQue->bc_survey_answers_bc_survey_questions->getBeans() as $oAns) {

                    //Delete relationship
                    $oSurveyQue->bc_survey_answers_bc_survey_questions->delete($oSurveyQue->id, $oAns->id);
                }

                //Save Survey Answers
                $ans_count = 1;
                if (isset($que_data->answers)) {
                    foreach ($que_data->answers as $ans_index => $answer) {
                        $pos_opt = strpos($ans_index, 'option_');
                        if ($pos_opt === false) {
                            $new_option_id = '';
                        } else {
                            $new_option_id = explode('_', $ans_index);
                        }
                        $oSurveyAns = new bc_survey_answers();
                        if (empty($new_option_id)) {
                            $oSurveyAns->id = $ans_index;
                        }
                        if (isset($oSurveyAns->id)) {
                            $oSurveyAns->retrieve($oSurveyAns->id);
                        }
                        $oSurveyAns->answer_name = $answer->option;
                        $oSurveyAns->name = $answer->option; // fix for report module support

                        if (isset($answer->weight)) {
                            $oSurveyAns->score_weight = $answer->weight;
                        } else {
                            $oSurveyAns->score_weight = 0;
                        }
                        $oSurveyAns->answer_sequence = $ans_count;
                        if (isset($skipLogicArr[$ans_index]->logic_target)) {
                            $redirect_url_logic = $skipLogicArr[$ans_index]->logic_target;
                        }
                        //To  stored skip logic action and targets on option/answer based
                        if (isset($skipLogicArr[$ans_index]->logic_action)) {
                            $oSurveyAns->logic_action = $skipLogicArr[$ans_index]->logic_action;

                            if ($skipLogicArr[$ans_index]->logic_action == 'redirect_to_url') {
                                // check valid URL or not

                                if (!preg_match("@^[hf]tt?ps?://@", $redirect_url_logic)) {
                                    $redirect_url_logic = "http://" . $redirect_url_logic;
                                }
                            }
                            if ($skipLogicArr[$ans_index]->logic_action == 'show_hide_question') {
                                $oSurveyAns->logic_target = implode(",", $skipLogicArr[$ans_index]->logic_target);
                            } else {
                                $oSurveyAns->logic_target = $redirect_url_logic;
                            }
                        }
                        if ($que_data->is_image_option == "1" && !empty($answer->radio_image)) {
                            $oSurveyAns->radio_image = $answer->radio_image;
                        }
                        $ansID = $oSurveyAns->save();
                        // End
                        // Radio Image
                        if ($que_data->is_image_option == "1" && !empty($answer->radio_image)) {

                            require_once('include/upload_file.php');

                            $UploadStream = new UploadStream();

                            $data = $answer->radio_image;
                            $image_data = explode(',', $data);
                            $ext = explode('data:image/', $image_data[0]);
                            $ext_arr = explode(';base64', $ext[1]);
                            $final_ext = '.' . $ext_arr[0];

                            $ifp = $UploadStream->stream_open('123456789' . $ansID . $final_ext, "wb"); // Fix :: added dummy content bcz it get extracted letter in internal process

                            $UploadStream->stream_write(base64_decode($image_data[1]));

                            $UploadStream->stream_close();
                        }
                        $oSurveyAns->load_relationship('bc_survey_answers_bc_survey_questions');
                        $oSurveyAns->bc_survey_answers_bc_survey_questions->add($oSurveyQue->id);
                        $ans_count++;
                    }
                }

                // Store other option as answer
                if (isset($que_data->enable_otherOption) && $que_data->enable_otherOption == 'true') {
                    // check other option already exists for current question or not

                    $oSurveyAns = new bc_survey_answers();
                    $oSurveyAns->retrieve($other_option_id);
                    $oSurveyAns->answer_name = $que_data->label_otherOption;
                    $oSurveyAns->name = $que_data->label_otherOption; // fix for report module support
                    $oSurveyAns->score_weight = $que_data->score_otherOption;
                    $oSurveyAns->answer_type = 'other';
                    $oSurveyAns->answer_sequence = $ans_count;
                    $redirect_url_logic = $skipLogicArr[$other_option_id]->logic_target;
                    //To  stored skip logic action and targets on option/answer based
                    $oSurveyAns->logic_action = $skipLogicArr[$other_option_id]->logic_action;
                    if ($skipLogicArr[$other_option_id]->logic_action == 'redirect_to_url') {
                        // check valid URL or not

                        if (!preg_match("@^[hf]tt?ps?://@", $redirect_url_logic)) {
                            $redirect_url_logic = "http://" . $redirect_url_logic;
                        }
                    }
                    if ($skipLogicArr[$other_option_id]->logic_action == 'show_hide_question') {
                        $oSurveyAns->logic_target = implode(",", $skipLogicArr[$other_option_id]->logic_target);
                    } else {
                        $oSurveyAns->logic_target = $redirect_url_logic;
                    }

                    // Radio Image
                    if ($que_data->is_image_option == "1" && !empty($answer->radio_image)) {
                        $oSurveyAns->radio_image = $que_data->image_otherOption;
                    }
                    $ansID = $oSurveyAns->save();
                    // Image for Other Option
                    if ($que_data->is_image_option == "1" && isset($que_data->image_otherOption)) {
                        require_once('include/upload_file.php');

                        $UploadStream = new UploadStream();

                        $data = $que_data->image_otherOption;
                        $image_data = explode(',', $data);
                        $ext = explode('data:image/', $image_data[0]);
                        $ext_arr = explode(';base64', $ext[1]);
                        $final_ext = '.' . $ext_arr[0];

                        $ifp = $UploadStream->stream_open('123456789' . $ansID . $final_ext, "wb"); // Fix :: added dummy content bcz it get extracted letter in internal process

                        $UploadStream->stream_write(base64_decode($image_data[1]));

                        $UploadStream->stream_close();
                    }
                    //set rlationship b/w Survey question and Survey answers
                    //    $oSurveyAns->bc_survey_answers_bc_survey_questions->delete($oSurveyAns->id, $oSurveyQue->id);
                    $oSurveyAns->load_relationship('bc_survey_answers_bc_survey_questions');
                    $oSurveyAns->bc_survey_answers_bc_survey_questions->add($oSurveyQue->id);
                    // End
                }
            }
        }
        //for remove page and its question answer records while edit
        $pages_deleted = json_decode($args['remove_page_ids']);
        if (isset($pages_deleted) && $pages_deleted != '' && $pages_deleted != 'null') {
            foreach ($pages_deleted as $page_for_delete => $page_id) {
                $oSurveyPage = new bc_survey_pages();
                $oSurveyPage->retrieve($page_id);
                $oSurveyPage->load_relationship('bc_survey_pages_bc_survey_questions');
                foreach ($oSurveyPage->bc_survey_pages_bc_survey_questions->getBeans() as $questions) {
                    $oSurveyQue = new bc_survey_questions();
                    $oSurveyQue->retrieve($questions->id);
                    $oSurveyQue->load_relationship('bc_survey_answers_bc_survey_questions');
                    foreach ($oSurveyQue->bc_survey_answers_bc_survey_questions->getBeans() as $answers) {
                        $oSurveyans = new bc_survey_answers();
                        $oSurveyans->retrieve($answers->id);
                        $oSurveyans->deleted = 1;
                        $oSurveyans->save();
                    }
                    $oSurveyQue->deleted = 1;
                    $oSurveyQue->save();
                }
                $oSurveyPage->deleted = 1;
                $oSurveyPage->save();
            }
        }
        //for remove question and its answer while edit
        $questions_deleted = json_decode($args['remove_que_ids']);

        if (isset($questions_deleted) && $questions_deleted != '' && $questions_deleted != 'null') {

            foreach ($questions_deleted as $question_for_delete => $que_id) {
                if (!in_array($que_id, $que_ids_saved)) {
                    $oSurveyQue = new bc_survey_questions();
                    $oSurveyQue->retrieve($que_id);
                    $oSurveyQue->load_relationship('bc_survey_answers_bc_survey_questions');
                    foreach ($oSurveyQue->bc_survey_answers_bc_survey_questions->getBeans() as $answers) {
                        $oSurveyans = new bc_survey_answers();
                        $oSurveyans->retrieve($answers->id);
                        $oSurveyans->deleted = 1;
                        $oSurveyans->save();
                    }
                    $oSurveyQue->deleted = 1;
                    $oSurveyQue->save();
                }
            }
        }
        // for remove answer while edit
        $answers_deleted = json_decode($args['remove_option_ids']);
        if (isset($answers_deleted) || $answers_deleted != "" || $answers_deleted != "null") {
            foreach ($answers_deleted as $answer_for_delete) {
                $survey_ans = new bc_survey_answers();
                $survey_ans->retrieve($answer_for_delete);
                $survey_ans->deleted = 1;
                $survey_ans->save();
            }
        }
        if ($args['type'] != "SurveyTemplate") {
            //Get Survey Questions score weight
            $obSurvey = new bc_survey();
            $obSurvey->retrieve($record_id);
            $obSurvey->load_relationship('bc_survey_bc_survey_questions');

            $base_score = 0;
            foreach ($obSurvey->bc_survey_bc_survey_questions->getBeans() as $survey_questions) {
                // if scoring is enabled
                if ($survey_questions->enable_scoring == "1") {
                    $base_score = $base_score + number_format($survey_questions->base_weight);
                }
            }

            //save survey theme
            $survey_logo = $obSurvey->survey_logo;
            $survey_theme = (!empty($aedited_survey_data->survey_theme)) ? $aedited_survey_data->survey_theme : 'theme0';

            require_once('include/upload_file.php');

            $uploadFile = new UploadFile();

            //get the file location
            $uploadFile->temp_file_location = UploadFile::get_upload_path($survey_logo);
            $file_contents = addslashes($uploadFile->get_file_contents());
            //  $GLOBALS['log']->fatal('This is the $file_contents : --- ', print_r($file_contents, 1));
            // Upload Survey Logo with Image file extension
            if ((isset($survey_logo)) && !empty($survey_logo)) {

                $UploadStream = new UploadStream();

                $final_ext = '.' . $this->getImgType('upload/' . $survey_logo);

                $GLOBALS['log']->fatal('This is the $img_upload : --- ', print_r($img_arr, 1));
                $uploadFile->duplicate_file($survey_logo, $survey_logo . $final_ext);
            }

            if (!empty($obSurvey->survey_background_image)) {
                $survey_background_image = $obSurvey->survey_background_image;
                //get the file location
                $uploadFile->temp_file_location = UploadFile::get_upload_path($survey_background_image);
                $survey_background_image_file_contents = addslashes($uploadFile->get_file_contents());
            }

            $db->query("UPDATE bc_survey SET image = '{$file_contents}', background_image_lb = '{$survey_background_image_file_contents}' , survey_theme = '{$survey_theme}',base_score = {$base_score} WHERE id = '{$record_id}' ");
        }


        return $record_id;
    }

    /*
     * Find Image Type
     */

    function getImgType($filepath) {
        if (exif_imagetype($filepath) == IMAGETYPE_JPEG) {
            return 'jpg';
        } elseif (exif_imagetype($filepath) == IMAGETYPE_PNG) {
            return 'png';
        } else {
            $types = explode('IMAGETYPE_', exif_imagetype($filepath));
            return strtolower($types[1]);
        }
    }

    /**
     * Function : getIndividualPersonReport
     *    get result for individual report
     * 
     * @return array - $reponse 
     */
    public function getIndividualPersonReport($api, $args) {

        global $db, $current_user;
        $datef = $current_user->getPreference('datef');
        $timef = $current_user->getPreference('timef');

        $survey_id = $args['survey_id'];
        $module_id = $args['module_id'];
        $customer_name = $args['customer_name'];
        $submission_id = $args['submission_id'];
        $page = $args['page'];
        if (isset($args['isFromSubpanel']) && $args['isFromSubpanel'] == "1") {
            $isFromSubpanel = "1";
        } else {
            $isFromSubpanel = "";
        }

        $html = "";
        $resultArray = array();
        // get individual response for a person
        $oSurvey = BeanFactory::getBean('bc_survey', $survey_id);
        $resultArray['survey_name'] = $oSurvey->name;

        if (empty($submission_id)) {
            $submission_where = (!empty($module_id) && str_split($module_id, 8)[0] != 'Web Link') ? " target_parent_id='{$module_id}' " : " customer_name = '{$customer_name}'";
            $submissionList = $oSurvey->get_linked_beans('bc_survey_submission_bc_survey', 'bc_survey_submission', array(), '', '', '', $submission_where);
        } else {
            $osubmission = BeanFactory::getBean('bc_survey_submission', $submission_id);
            $submissionList = array(0 => $osubmission);
        }

        // survey related submission
        $track_time_spent_on_survey = '';
        foreach ($submissionList as $oSubmission) {

            // current record of module recipient
            //  if ($oSubmission->target_parent_id == $module_id || $oSubmission->customer_name == $customer_name) {
            $resultArray['submission_id'] = $oSubmission->id;
            $resultArray['status'] = $oSubmission->status;
            $resultArray['target_parent_type'] = $oSubmission->target_parent_type;
            $resultArray['customer_name'] = $oSubmission->customer_name;
            $resultArray['base_score'] = $oSubmission->base_score;
            $resultArray['obtained_score'] = $oSubmission->obtained_score;
            $resultArray['send_date'] = TimeDate::getInstance()->to_display_date_time($oSubmission->schedule_on);
            $resultArray['receive_date'] = TimeDate::getInstance()->to_display_date_time($oSubmission->submission_date);

            // Time spent on survey DateTime BugFix :: START
            //get total of send out survey
            require_once('include/SugarQuery/SugarQuery.php');

            $query = new SugarQuery();
            $query->from(BeanFactory::getBean('bc_survey_submission'));

            // select fields
            $query->select->fieldRaw("submission_date", "submission_date");
            $query->select->fieldRaw("survey_trackdatetime", "survey_trackdatetime");
            // where condition
            $query->where()->equals('bc_survey_submission.id', $oSubmission->id);
            $submission_result = $query->execute();

            $submission_dateTimestamp = strtotime($submission_result[0]['submission_date']);
            $survey_trackdatetimeTimestamp = strtotime($submission_result[0]['survey_trackdatetime']);
            $difference = ($submission_dateTimestamp - $survey_trackdatetimeTimestamp);
            // Time spent on survey DateTime BugFix :: END

            if (!empty($submission_dateTimestamp) && !empty($survey_trackdatetimeTimestamp)) {
                $datetime1 = new DateTime("@$submission_dateTimestamp");
                $datetime2 = new DateTime("@$survey_trackdatetimeTimestamp");
                $interval = $datetime1->diff($datetime2);
                $track_time_spent_on_survey = $interval->format('%Hh : %Im : %Ss');
            }
            $resultArray['base_score'] = $oSubmission->base_score;
            $resultArray['consent_accepted'] = (!empty($oSubmission->consent_accepted) && $oSubmission->consent_accepted == 1) ? 'Yes' : 'No';

            $selected_lang = $oSubmission->submission_language;

            // list of lang wise survey detail
            if (!empty($selected_lang)) {
                $list_lang_detail_array = return_app_list_strings_language($selected_lang);
                $list_lang_detail = $list_lang_detail_array[$survey_id];
            } else {
                $list_lang_detail = '';
            }

            $resultArray['description'] = (!empty($list_lang_detail[$survey_id . '_survey_description'])) ? $list_lang_detail[$survey_id . '_survey_description'] : nl2br($oSurvey->description);

            // submission related submitted data
            $submittedData = $oSubmission->get_linked_beans('bc_submission_data_bc_survey_submission', 'bc_submission_data');
            $submitedAndIds = array();
            foreach ($submittedData as $oSubmissionData) {
                require_once('include/SugarQuery/SugarQuery.php');
                $query = new SugarQuery();
                $query->from(BeanFactory::getBean('bc_submission_data'));
                $query->join('bc_submission_data_bc_survey_answers', array('alias' => 'related_survey_answers'));
                $query->select(array("related_survey_answers.id"));
                $query->where()->queryAnd()->equals('bc_submission_data.id', $oSubmissionData->id);

                $scDataQryRes = $query->execute();
                foreach ($scDataQryRes as $subAns) {
                    $query = new SugarQuery();
                    $query->from(BeanFactory::getBean('bc_survey_answers'));
                    $query->join('bc_survey_answers_bc_survey_questions', array('alias' => 'related_survey_questions'));

                    $query->select(array("related_survey_questions.id"));
                    $query->where()->queryAnd()->equals('bc_survey_answers.id', $subAns['id']);

                    $scDataQryRes1 = $query->execute();

                    if (!empty($scDataQryRes1)) {

                        foreach ($scDataQryRes1 as $subQue) {
                            $query = new SugarQuery();
                            $query->from(BeanFactory::getBean('bc_survey_questions'));
                            $query->join('bc_survey_pages_bc_survey_questions', array('alias' => 'related_survey_pages'));
                            $query->select(array("related_survey_answers.id"));
                            $query->where()->queryAnd()->equals('bc_survey_questions.id', $subQue['id'])->equals('related_survey_pages.page_sequence', $page);

                            $scDataQryRes2 = $query->execute();
                            foreach ($scDataQryRes2 as $subQue) {
                                $submitedAndIds[] = $subAns['id'];
                            }
                        }
                    } else {

                        $submittedQueData = $oSubmissionData->get_linked_beans('bc_submission_data_bc_survey_questions', 'bc_survey_questions');
                        foreach ($submittedQueData as $oSubmissionQue) {
                            $submittedPageData = $oSubmissionQue->get_linked_beans('bc_survey_pages_bc_survey_questions', 'bc_survey_pages');
                            foreach ($submittedPageData as $oSubmissionPage) {
                                if ($oSubmissionPage->page_sequence == $page) {
                                    $submitedAndIds[] = $subAns['id'];
                                }
                            }
                        }
                    }
                }
            }
            $GLOBALS['log']->fatal('This is the submitedAnsIds : --- ', print_r($submitedAndIds, 1));

            // get actual survey pages and details
            $surveyPages = $oSurvey->get_linked_beans('bc_survey_pages_bc_survey', 'bc_survey_pages');

            foreach ($surveyPages as $oPage) {
                if ($oPage->page_sequence == $page) {

                    $queList = $oPage->get_linked_beans('bc_survey_pages_bc_survey_questions', 'bc_survey_questions', array('question_sequence'));
                    foreach ($queList as $oQuestion) {
                        if ($oQuestion->question_type != 'section-header' && $oQuestion->question_type != 'richtextareabox') {
                            // result of Question Detail
                            $resultArray['pages'][$oPage->id][$oQuestion->id]['matrix_rows'] = $oQuestion->matrix_row;
                            $resultArray['pages'][$oPage->id][$oQuestion->id]['matrix_cols'] = $oQuestion->matrix_col;
                            $resultArray['pages'][$oPage->id][$oQuestion->id]['question_title'] = (!empty($list_lang_detail[$oQuestion->id . '_que_title'])) ? $list_lang_detail[$oQuestion->id . '_que_title'] : $oQuestion->name;

                            $resultArray['pages'][$oPage->id][$oQuestion->id]['max_size'] = $oQuestion->maxsize;
                            $resultArray['pages'][$oPage->id][$oQuestion->id]['base_weight'] = $oQuestion->base_weight;
                            $resultArray['pages'][$oPage->id][$oQuestion->id]['enable_scoring'] = $oQuestion->enable_scoring;
                            $resultArray['pages'][$oPage->id][$oQuestion->id]['question_id'] = $oQuestion->id;
                            $resultArray['pages'][$oPage->id][$oQuestion->id]['question_type'] = $oQuestion->question_type;
                            $resultArray['pages'][$oPage->id][$oQuestion->id]['is_datetime'] = $oQuestion->is_datetime;
                            $resultArray['pages'][$oPage->id][$oQuestion->id]['page_seq'] = $oPage->page_sequence;
                            $resultArray['pages'][$oPage->id][$oQuestion->id]['que_seq'] = $oQuestion->question_sequence;
                            $resultArray['pages'][$oPage->id][$oQuestion->id]['enable_otherOption'] = $oQuestion->enable_otherOption;

                            $ansList = $oQuestion->get_linked_beans('bc_survey_answers_bc_survey_questions', 'bc_survey_answers');
                            if ($oQuestion->question_type == 'radio-button' || $oQuestion->question_type == 'check-box' || $oQuestion->question_type == 'multiselectlist' || $oQuestion->question_type == 'dropdownlist' || $oQuestion->question_type == 'boolean') {
                                $optionIds = array();
                                foreach ($ansList as $oAnswer) {

                                    if (in_array($oAnswer->id, $submitedAndIds) && $oAnswer->answer_type != 'other') {
                                        $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$oAnswer->id]['answer_id'] = $oAnswer->id;
                                        if ($oQuestion->is_image_option) {
                                            $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$oAnswer->id]['name'] = (!empty($list_lang_detail[$oAnswer->id])) ? '<span class="option_image option_image_indreport"><img src="' . $oAnswer->radio_image . '" style="height:30px;width:30px;"><div class="hover-img"><img src="' . $oAnswer->radio_image . '"></div></span>' . $list_lang_detail[$oAnswer->id] : '<span class="option_image option_image_indreport"><img src="' . $oAnswer->radio_image . '" style="height:30px;width:30px;"><div class="hover-img"><img src="' . $oAnswer->radio_image . '"></div></span><span style="margin-left: 5px;vertical-align: -webkit-baseline-middle;">' . $oAnswer->answer_name . '</span>';
                                        } else {
                                            $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$oAnswer->id]['name'] = (!empty($list_lang_detail[$oAnswer->id])) ? $list_lang_detail[$oAnswer->id] : $oAnswer->answer_name;
                                        }
                                        $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$oAnswer->id]['score_weight'] = $oAnswer->score_weight;
                                    } else if ($oAnswer->answer_type == 'other') {
                                        $otherScore = $oAnswer->score_weight;
                                    }
                                    $optionIds[] = $oAnswer->id;
                                }
                            }
                            // get answers of other than multi select question type
                            else if ($oQuestion->question_type != 'radio-button' || $oQuestion->question_type != 'check-box' || $oQuestion->question_type != 'multiselectlist' || $oQuestion->question_type != 'dropdownlist' || $oQuestion->question_type == 'boolean') {
                                $submitted_ans_id = '';
                                $submitted_ans_name = '';
                                foreach ($submitedAndIds as $key => $subAns) {
                                    // check for answer
                                    $oAnswer = BeanFactory::getBean('bc_survey_answers', $subAns);
                                    $subData = $oAnswer->get_linked_beans('bc_submission_data_bc_survey_answers', 'bc_submission_data');
                                    foreach ($subData as $sub) {
                                        $quesSubList = $sub->get_linked_beans('bc_submission_data_bc_survey_questions', 'bc_survey_questions');
                                        foreach ($quesSubList as $subQue) {
                                            if ($subQue->id == $oQuestion->id) {
                                                $submitted_ans_id = $subAns;
                                                $submitted_ans_name = html_entity_decode(htmlentities($oAnswer->answer_name));
                                                $submitted_ans_seq = $oAnswer->answer_sequence;
                                            }
                                        }
                                    }
                                }
                                // submitted answer

                                $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$submitted_ans_id]['answer_id'] = $submitted_ans_id;
                                $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$submitted_ans_id]['name'] = $submitted_ans_name;
                                $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$submitted_ans_id]['answer_sequence'] = $submitted_ans_seq;
                            }
                            if ($oQuestion->enable_otherOption == 1) {

                                $submitted_ans_id = '';
                                $submitted_ans_name = '';
                                foreach ($submittedData as $oSubmissionData) {
                                    $current_submited_id = '';

                                    // check answer for current question only
                                    $submittedQueList = $oSubmissionData->get_linked_beans('bc_submission_data_bc_survey_questions', 'bc_survey_questions');
                                    foreach ($submittedQueList as $subQue) {
                                        if ($subQue->id == $oQuestion->id) {
                                            $current_submited_id = $oSubmissionData->id;
                                        }
                                    }
                                    if (!empty($current_submited_id)) {
                                        // get related questions submitted

                                        $submittedAnsList = $oSubmissionData->get_linked_beans('bc_submission_data_bc_survey_answers', 'bc_survey_answers', array('date_modified'));

                                        foreach ($submittedAnsList as $subAns) {

                                            if (!in_array($subAns->id, $optionIds) && $subAns->answer_type != 'other') {
                                                $submitted_ans_id = $subAns->id;
                                                $submitted_ans_name = $subAns->answer_name;
                                            }
                                        }
                                    }
                                }

                                if ($submitted_ans_id) {
                                    // submitted answer
                                    $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$submitted_ans_id]['answer_id'] = $submitted_ans_id;
                                    $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$submitted_ans_id]['name'] = $submitted_ans_name;
                                    $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$submitted_ans_id]['score_weight'] = $otherScore;
                                }
                            }
                            // if answer is not given then set blank answer for the same
                            if (!isset($resultArray['pages'][$oPage->id][$oQuestion->id]['answers'])) {
                                $resultArray['pages'][$oPage->id][$oQuestion->id]['answers']['n/a']['answer_id'] = 'N/A';
                                $resultArray['pages'][$oPage->id][$oQuestion->id]['answers']['n/a']['name'] = 'N/A';
                            }
                        }
                    }
                }
                // }
            }
        }
        $totalPages = count($surveyPages);

        // order in question sequence
        $que_seqList = array();
        $otherPageQue = array();
        // get page wise sequence
        foreach ($resultArray['pages'] as $pageKey => $pData) {
            foreach ($pData as $qId => $pDetail) {
                // sort question by question sequence
                $sorted_ques[$pDetail['que_seq']] = $pDetail;
            }
            ksort($sorted_ques);
            foreach ($sorted_ques as $que_seq => $que_detail) {
                // check sequence for current page
                if ($pDetail['page_seq'] == $page) {
                    $que_seqList[$pageKey][$que_detail['question_id']] = $que_detail;
                } else {
                    $otherPageQue[$pageKey][$que_detail['question_id']] = $que_detail;
                }
            }
        }
        ksort($que_seqList);
        $orderedSurvey = array();
        // $counter = 0;
        // re create ordered list for question sequence wise data
        foreach ($que_seqList as $queSeq => $orderedqueID) {
            //  $counter++;
            $orderedSurvey['pages'][$queSeq] = $orderedqueID;
        }
        // add other pages for pagination
        foreach ($otherPageQue as $queSeqOther => $otherqueID) {
            //  $counter++;
            $orderedSurvey['pages'][$queSeqOther] = $otherqueID;
        }
        $row_data = array();
        $detail_array = array();
        $i = 0;
        //    while ($row = $db->fetchByAssoc($result)) {
        //   foreach ($resultArray as $key => $detail) {
        // page details
        foreach ($orderedSurvey['pages'] as $page_id => $page_detail) {
            // question detail
            foreach ($page_detail as $que_id => $que_detail) {
                $answer_submitted = '';

                if ($que_detail['question_type'] != 'image' && $que_detail['question_type'] != 'video' && $que_detail['question_type'] != 'additional-text' && $que_detail['question_type'] != 'richtextareabox') {
                    $rows = json_decode(base64_decode(($que_detail['matrix_rows'])));
                    $cols = json_decode(base64_decode(($que_detail['matrix_cols'])));
                    if ((!empty($list_lang_detail[$que_id . '_matrix_row1']))) {
                        foreach ($rows as $key => $row) {
                            $rows->$key = $list_lang_detail[$que_id . '_matrix_row' . $key];
                        }

                        foreach ($cols as $key => $col) {
                            $cols->$key = $list_lang_detail[$que_id . '_matrix_col' . $key];
                        }
                    }

                    $que_detail['matrix_rows'] = $rows;
                    $que_detail['matrix_cols'] = $cols;
                    $row_data[$que_detail['page_seq']][$que_detail['question_id']] = $que_detail;
                    $row_data[$que_detail['page_seq']]['status'] = $resultArray['status'];
                    $row_data[$que_detail['page_seq']]['description'] = $resultArray['description'];
                    $row_data[$que_detail['page_seq']]['send_date'] = $resultArray['send_date'];
                    $row_data[$que_detail['page_seq']]['receive_date'] = $resultArray['receive_date'];
                    $row_data[$que_detail['page_seq']]['track_time_spent_on_survey'] = $track_time_spent_on_survey;
                    $row_data[$que_detail['page_seq']]['survey_name'] = $resultArray['survey_name'];
                    $row_data[$que_detail['page_seq']]['customer_name'] = $resultArray['customer_name'];
                    $row_data[$que_detail['page_seq']]['base_score'] = $resultArray['base_score'];
                    $row_data[$que_detail['page_seq']]['obtained_score'] = $resultArray['obtained_score'];
                    if ($oSurvey->enable_agreement == 1) {
                        $row_data[$que_detail['page_seq']]['consent_accepted'] = $resultArray['consent_accepted'];
                    }

                    if ($resultArray['status'] == 'Pending') {

                        $html = "<div id='individual'>There is no submission response for this Survey.</div>";
                    } else if ($resultArray['status'] == null) {
                        $html = '';
                    } else {
                        if ($resultArray['status'] == 'Submitted') {
                            //Contact Information then retrieve all answer from db & store in variable
                            if (!empty($que_detail['question_type']) && $que_detail['question_type'] == 'contact-information') {
                                // answer detail
                                foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                                    $contact_information = JSON::decode(html_entity_decode($ans_detail['name']));

                                    $detail_array[$que_detail['page_seq']][$que_detail['question_id']][$que_detail['question_title']][$ans_detail['answer_id']] = $contact_information;
                                }
                            }
                            // Matrix type then get rows & columns value & generate selected answer layout
                            else if (!empty($que_detail['question_type']) && $que_detail['question_type'] == 'matrix') {
                                $finalAnswers = array();
                                // set matrix answer to question array
                                if (empty($module_id)) {
                                    $rec_id = $resultArray['customer_name'];
                                } else {
                                    $rec_id = $module_id;
                                }
                                if (str_split($resultArray['customer_name'], 8)[0] == 'Web Link') {
                                    $rec_id = $resultArray['customer_name'];
                                }
                                $answer = getAnswerSubmissionDataForMatrix($survey_id, $rec_id, $que_detail['question_id'], '');

                                foreach ($answer as $recipient => $sub_answer) {
                                    foreach ($sub_answer as $akey => $aval) {
                                        array_push($finalAnswers, $aval);
                                    }
                                }
                                $detail_array[$que_detail['page_seq']][$que_detail['question_id']][$que_detail['question_title']]['matrix_answer'][] = $finalAnswers;
                            }
                            // Rating then generate selected star value
                            elseif (!empty($que_detail['question_type']) && $que_detail['question_type'] == 'rating') {
                                $rating = "";
                                if (!empty($que_detail['max_size'])) {
                                    $starCount = $que_detail['max_size'];
                                } else {
                                    $starCount = 5;
                                }
                                // answer detail
                                foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                                    for ($i = 0; $i < $starCount; $i++) {
                                        if ($i < $ans_detail['name']) {
                                            $selected = "selected";
                                        } else {
                                            $selected = "";
                                        }
                                        $rating .= "<li class='rating {$selected}' style='display: inline;font-size: x-large'>&#9733;</li>";
                                    }

                                    $detail_array[$que_detail['page_seq']][$que_detail['question_id']][$que_detail['question_title']][$ans_detail['answer_id']] = $rating;
                                }
                            }
                            // Other type of Question
                            else {
                                if ($que_detail['question_type'] == 'radio-button' || $que_detail['question_type'] == 'check-box' || $que_detail['question_type'] == 'multiselectlist' || $que_detail['question_type'] == 'dropdownlist' || $que_detail['question_type'] == 'boolean') {
                                    // answer detail
                                    foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                                        if (array_key_exists($que_detail['question_title'], $detail_array)) {

                                            $score_weight = $detail_array[$que_detail['page_seq']][$que_detail['question_id']][$que_detail['question_title']]['obtained_que_score'];
                                            $detail_array[$que_detail['page_seq']][$que_detail['question_id']][$que_detail['question_title']]['obtained_que_score'] = $score_weight + $ans_detail['score_weight'];

                                            $bc_survey_que = BeanFactory::getBean('bc_survey_questions', $que_detail['question_id']);
                                            $bc_survey_que->load_relationship('bc_survey_answers_bc_survey_questions');
                                            foreach ($bc_survey_que->bc_survey_answers_bc_survey_questions->getBeans() as $bc_survey_answers) {
                                                if ($bc_survey_answers->id == $ans_detail['answer_id']) {
                                                    if (($que_detail['question_type'] == 'radio-button' || $que_detail['question_type'] == 'check-box') && $bc_survey_que->is_image_option) {
                                                        $all_options[$que_detail['question_id']][$bc_survey_answers->id] = array('ans' => '<span class="option_image option_image_indreport"><img src="' . $bc_survey_answers->radio_image . '" style="height:30px;width:30px;"><div class="hover-img"><img src="' . $bc_survey_answers->radio_image . '"></div></span><span style="margin-left: 5px;vertical-align: -webkit-baseline-middle;">' . $bc_survey_answers->answer_name . '</span>', 'selected' => true, 'type' => $que_detail['question_type']);
                                                    } else {
                                                        $all_options[$que_detail['question_id']][$bc_survey_answers->id] = array('ans' => $bc_survey_answers->answer_name, 'selected' => true, 'type' => $que_detail['question_type']);
                                                    }
                                                } else {
                                                    $all_options[$que_detail['question_id']][$ans_detail['answer_id']] = array('ans' => $ans_detail['name'], 'selected' => true, 'type' => $que_detail['question_type']);
                                                }
                                            }
                                            $detail_array[$que_detail['page_seq']][$que_detail['question_id']][$que_detail['question_title']]['all_answers'] = $all_options[$que_detail['question_id']];
                                        } else {
                                            $bc_survey_que = BeanFactory::getBean('bc_survey_questions', $que_detail['question_id']);
                                            $bc_survey_que->load_relationship('bc_survey_answers_bc_survey_questions');
                                            foreach ($bc_survey_que->bc_survey_answers_bc_survey_questions->getBeans() as $bc_survey_answers) {
                                                if ($bc_survey_answers->id == $ans_detail['answer_id']) {
                                                    if (($que_detail['question_type'] == 'radio-button' || $que_detail['question_type'] == 'check-box') && $bc_survey_que->is_image_option) {
                                                        $all_options[$que_detail['question_id']][$bc_survey_answers->id] = array('ans' => '<span class="option_image option_image_indreport"><img src="' . $bc_survey_answers->radio_image . '" style="height:30px;width:30px;"><div class="hover-img"><img src="' . $bc_survey_answers->radio_image . '"></div></span><span style="margin-left: 5px;vertical-align: -webkit-baseline-middle;">' . $bc_survey_answers->answer_name . '</span>', 'selected' => true, 'type' => $que_detail['question_type']);
                                                    } else {
                                                        $all_options[$que_detail['question_id']][$bc_survey_answers->id] = array('ans' => $bc_survey_answers->answer_name, 'selected' => true, 'type' => $que_detail['question_type']);
                                                    }
                                                } else {
                                                    $all_options[$que_detail['question_id']][$ans_detail['answer_id']] = array('ans' => $ans_detail['name'], 'selected' => true, 'type' => $que_detail['question_type']);
                                                }
                                            }
                                            $detail_array[$que_detail['page_seq']][$que_detail['question_id']][$que_detail['question_title']]['all_answers'] = $all_options[$que_detail['question_id']];
                                            $score_weight = isset($detail_array[$que_detail['page_seq']][$que_detail['question_id']][$que_detail['question_title']]['obtained_que_score']) ? $detail_array[$que_detail['page_seq']][$que_detail['question_id']][$que_detail['question_title']]['obtained_que_score'] : 0;
                                            $detail_array[$que_detail['page_seq']][$que_detail['question_id']][$que_detail['question_title']]['obtained_que_score'] = $score_weight + $ans_detail['score_weight'];
                                            $detail_array[$que_detail['page_seq']][$que_detail['question_id']][$que_detail['question_title']]['base_que_score'] = $que_detail['base_weight'];
                                        }
                                    }
                                } else {
                                    // answer detail
                                    $npsAnsArray = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10');
                                    $emojisImges = array(
                                        1 => "<img src='custom/include/images/ext-unsatisfy.png' />",
                                        2 => "<img src='custom/include/images/unsatisfy.png'  />",
                                        3 => "<img src='custom/include/images/nuteral.png' />",
                                        4 => "<img src='custom/include/images/satisfy.png' />",
                                        5 => "<img src='custom/include/images/ext-satisfy.png'/>",
                                    );
                                    foreach ($que_detail['answers'] as $ans_id => $ans_detail) {
                                        $ans = !empty($ans_detail['name']) ? $ans_detail['name'] : 'N/A';
                                        if ($que_detail['question_type'] == 'date-time') {
                                            if ($que_detail['is_datetime'] == 0) {

                                                if (!empty($ans_detail['name'])) {
                                                    $ansDate = date($datef, strtotime($ans_detail['name']));
                                                } else {
                                                    $ansDate = 'N/A';
                                                }
                                                $ans = $ansDate;
                                            } else {

                                                if (!empty($ans_detail['name'])) {
                                                    $ansDate = date($datef . ' ' . $timef, strtotime($ans_detail['name']));
                                                } else {
                                                    $ansDate = 'N/A';
                                                }
                                                $ans = $ansDate;
                                            }
                                        }
                                        if ($que_detail['question_type'] == 'doc-attachment') {
                                            $answer_submitted = $ans;
                                        } else if ($que_detail['question_type'] == 'netpromoterscore') {
                                            $answer_submitted .= "<div id=''>
                                            <table class='nps_submission_table' >
                                            <tr>";
                                            foreach ($npsAnsArray as $answer_nps) {
                                                if ($answer_nps < 7) {
                                                    if ($ans == $answer_nps) {
                                                        $answer_submitted .= "<th><div class='score_pannel' style='background-color:#a1cbff;border: 2px solid black !important'>" . $answer_nps . "</div></th>";
                                                    } else {
                                                        $answer_submitted .= "<th><div class='score_pannel' style='background-color:#ff5353'>" . $answer_nps . "</div></th>";
                                                    }
                                                } else if ($answer_nps >= 7 && $answer_nps < 9) {
                                                    if ($ans == $answer_nps) {
                                                        $answer_submitted .= "<th><div class='score_pannel' style='background-color:#a1cbff;border: 2px solid black  !important;'>" . $answer_nps . "</div></th>";
                                                    } else {
                                                        $answer_submitted .= "<th><div class='score_pannel' style='background-color:#e9e817'>" . $answer_nps . "</div></th>";
                                                    }
                                                } else if ($answer_nps >= 9 && $answer_nps <= 10) {
                                                    if ($ans == $answer_nps) {
                                                        $answer_submitted .= "<th><div class='score_pannel' style='background-color:#a1cbff;border: 2px solid black  !important;'>" . $answer_nps . "</div></th>";
                                                    } else {
                                                        $answer_submitted .= "<th><div class='score_pannel' style='background-color:#92d51a'>" . $answer_nps . "</div></th>";
                                                    }
                                                }
                                            }
                                            $answer_submitted .= "</tr>
                                                    </table>
                                                    </div>";
                                        } else if ($que_detail['question_type'] == 'emojis') {
                                            $answer_submitted .= "<div>";
                                            if (!empty($ans_detail['answer_id'])) {
                                                $answer_submitted .= "<div class='emoji-ans' >{$emojisImges[$ans_detail['answer_sequence']]}  <div>{$ans_detail['name']}</div></div>";
                                            } else {
                                                $answer_submitted .= "<div class='emoji-ans' ><div>{$ans}</div></div>";
                                            }
                                            $answer_submitted .= "</div>";
                                        } else {
                                            $answer_submitted = '<span>' . nl2br(htmlentities($ans)) . '</span>';
                                        }
                                        $detail_array[$que_detail['page_seq']][$que_detail['question_id']][$que_detail['question_title']][$que_detail['answer_id']] = $answer_submitted;
                                    }
                                }
                            }
                        }
                        $detail_array[$que_detail['page_seq']][$que_detail['question_id']]['page_id'] = $que_detail['page_seq'];

                        if ($detail_array[$que_detail['page_seq']][$que_detail['question_id']]['page_id'] != $page) {
                            unset($detail_array[$que_detail['page_seq']][$que_detail['question_id']]);
                        }
                        $survey_details[$que_detail['page_seq']]['page'] = $detail_array;
                    }
                }
                if ($totalPages > 1) {
                    $indexed_page_outer = $page - 1;
                    $survey_details[$indexed_page_outer] = $survey_details[$page];
                    for ($eachPage = 0; $eachPage <= $totalPages; $eachPage++) {
                        $indexed_page = $eachPage - 1;
                        if ($eachPage != 0 && $page != $totalPages && $indexed_page != $indexed_page_outer) {

                            $survey_details[$indexed_page] = $survey_details[$indexed_page_outer];
                        } else if ($page == $totalPages) {
                            if ($eachPage != 0 && $eachPage + 1 < $totalPages && $indexed_page != $indexed_page_outer) {

                                $survey_details[$indexed_page] = $que_details[$indexed_page_outer];
                            }
                        }
                    }
                }
                //set pagination
                if (count($survey_details) && $module_id != 'Select Record') {
                    $pagination = new pagination($survey_details, (isset($_GET['page']) ? $_GET['page'] : 1), 1);
                    $pagination->setShowFirstAndLast(true);
                    $IndivisualReportData = $pagination->getResults();
                    if (count($IndivisualReportData) != 0) {
                        $_POST['action'] = 'viewreport';
                        $_POST['type'] = 'individual';

                        $queReoort_pageNumbers = $pagination->getLinks($_POST, $survey_id, $page, $module_id, $isFromSubpanel, $submission_id);
                    }
                }
            }
        }

        return array('row' => $row_data, 'detail_array' => $detail_array, 'queReoort_pageNumbers' => $queReoort_pageNumbers);
    }

    /**
     * Function : getSearchResult
     *    get search result for individual report
     * 
     * @return array - $reponse 
     */
    public function getSearchResult($api, $args) {
        require_once 'custom/include/utilsfunction.php';
        global $app_list_strings, $sugar_config;
        $getRequestData = $args['newData'];
        $dataArray = json_decode(html_entity_decode($getRequestData));
        $postDataArray = array(
            'search_value' => $dataArray->search_value,
            'module_type' => $dataArray->module_type,
            'submission_type' => $dataArray->submission_type,
            'survey_status' => $dataArray->survey_status,
            'survey_id' => $dataArray->survey_id,
            'report_type' => $dataArray->report_type,
            'page' => $dataArray->page,
            'submission_start_date' => $dataArray->submission_start_date,
            'submission_end_date' => $dataArray->submission_end_date,
            'sort' => $dataArray->sort,
            'sort_order' => $dataArray->sort_order,
            'gf_filter_by' => $dataArray->gf_filter_by,
        );
        $name = $postDataArray['search_value'];
        $module = $postDataArray['module_type'];
        $type = $postDataArray['submission_type'];
        $status = $postDataArray['survey_status'];
        $survey_id = $postDataArray['survey_id'];
        $report_type = $postDataArray['report_type'];
        $page = $postDataArray['page'];
        $sort = $postDataArray['sort'];
        $sort_order = $postDataArray['sort_order'];
        $submission_start_date = $postDataArray['submission_start_date'];
        $submission_end_date = $postDataArray['submission_end_date'];
        $gf_filter_by = $postDataArray['gf_filter_by'];
        $returnData = getUserAccessibleRecordsData($survey_id);
        $accesible_submissions = $returnData['accesible_submissions'];
        $GF_QueLogic_Passed_Submissions = array_unique($accesible_submissions);
   
        $records = getReportData($report_type, $survey_id, $name, $module, '', $submission_start_date, $submission_end_date, $type, '', $sort, $sort_order, '', $gf_filter_by, $GF_QueLogic_Passed_Submissions);
        if (count($records) > 0) {
            //set pagination
            $pagination = new pagination($records, (isset($page) ? $page : 1), 10);
            $pagination->setShowFirstAndLast(true);
            $IndividualReportData = $pagination->getResults();
            $post_data = array();
            if (count($IndividualReportData) != 0) {
                $post_data = $postDataArray;
                unset($post_data['search_value']);
                unset($post_data['module_type']);
                unset($post_data['survey_status']);
                $Individual_Report_pageNumbers = $pagination->getIndividual_SearchLinks($post_data, $survey_id);
            }
            $list_max_entries_per_page = !empty($sugar_config['list_max_entries_per_page']) ? $sugar_config['list_max_entries_per_page'] : 20;
            return array('records' => $records, 'Individual_Report_pageNumbers' => $Individual_Report_pageNumbers, 'IndividualReportData' => $records,'max_records' => $list_max_entries_per_page);
        }
    }

    /**
     * Function : approveRequest
     *    approve change request or resend survey from individual report
     * 
     * @return array - $reponse 
     */
    public function approveRequest($api, $args) {
        require_once 'custom/include/utilsfunction.php';
        require_once('include/SugarQuery/SugarQuery.php');
        global $sugar_config;
        $reponse = array();

        if (isset($args['submission_id']) && !empty($args['submission_id'])) {
            $oSubmission = BeanFactory::getBean('bc_survey_submission', $args['submission_id']);
            if ($oSubmission->submission_type == 'Open Ended') {
                $reponse['status'] = 'This survey can not be resend as this submission is done by open survey link.';
                return json_encode($reponse);
            }
        }

        //get submission
        $query = new SugarQuery();
        $query->from(BeanFactory::getBean('bc_survey_submission'));
        // $query->join('bc_survey_submission_bc_survey', array('alias' => 'bc_survey'));
        // select fields
        $query->select->fieldRaw("id", "submission_id");
        $query->select->fieldRaw("survey_send", "survey_send");
        $query->select->fieldRaw("submission_type", "submission_type");
        // where condition
        $query->where()->equals('target_parent_id', $args['module_id']);
        $query->where()->equals('target_parent_type', $args['module_name']);
        //  $query->where()->equals('bc_survey.id', $args['survey_id']);
        $submission_res = $query->execute();

        foreach ($submission_res as $submission_row_each) {
            $submission_id_each = $submission_row_each['submission_id'];
        }

        $surveyObj = new bc_survey();
        $surveyObj->retrieve($args['survey_id']);

        // Survey Status :: LoadedTech Customization
        if ($surveyObj->survey_status == 'Active') {

            $reponse['request_status'] = $args['status'];

            switch ($args['module_name']) {
                case "Accounts":
                    $focus = new Account();
                    $recip_prefix = '$account';
                    break;
                case "Contacts":
                    $focus = new Contact();
                    $recip_prefix = '$contact';
                    break;
                case "Leads":
                    $focus = new Lead();
                    $recip_prefix = '$contact';
                    break;
                case "Prospects":
                    $focus = new Prospect();
                    $recip_prefix = '$contact';
                    break;
            }
            $focus->retrieve($args['module_id']);
            $getSurveyEmailTemplateID = getEmailTemplateBySurveyID($surveyObj->id);
            $emailtemplateObj = new EmailTemplate();
            $emailtemplateObj->retrieve($getSurveyEmailTemplateID);
            $mailSubject = (!empty($emailtemplateObj->subject)) ? $emailtemplateObj->subject : $surveyObj->name;
            $emailSubject = htmlspecialchars_decode($mailSubject, ENT_QUOTES);
            $survey_url = $sugar_config['site_url'] . '/survey_submission.php?survey_id=';
            $sugar_survey_Url = $survey_url; //create survey submission url
            $encoded_param = base64_encode($args['survey_id'] . '&ctype=' . $args['module_name'] . '&cid=' . $args['module_id']) . '&sub_id=' . $oSubmission->id;
            $sugar_survey_Url = str_replace('survey_id=', 'q=', $sugar_survey_Url);
            $surveyURL = $sugar_survey_Url . $encoded_param;
            $to_Email = $focus->email1;
            $moduleDetail = "&module_name=" . $args['module_name'] . "&module_id=" . $args['module_id'];
            $encodedData = base64_encode($moduleDetail);
            $opt_out_url = $sugar_config['site_url'] . '/index.php?entryPoint=unsubscribe&q=' . $encodedData;
            if (!empty($emailtemplateObj->id)) {
                if ((empty($args['status']) && isset($args['resend'])) || ($args['resendFromSubpanel'] == 1 && $args['isSurveyAlreadySend'] == "true")) {
                    $emailBody = "Dear " . $focus->name . ",<br/><br/>Admin has requested you to re-submit your response for <b>" . $surveyObj->name . "</b>.<br/><br/>You can re-submit your response on following link.<br/><br/><a href='" . $surveyURL . "' target='_blank'>click here</a>";
                    $emailBody .= '<br/><br/><span style="font-size:0.8em">To remove yourself from this email list  <a href="' . $opt_out_url . '" target="_blank">click here</a></span>';
                } else if ($args['resendFromSubpanel'] == 1 && $args['isSurveyAlreadySend'] == "false") {
                    //replace prefix for recipient name if exists email template for other module
                    if ($recip_prefix == '$contact') {
                        $search_prefix1 = '$account';
                        $search_prefix2 = '$contact_user';
                    } else if ($recip_prefix == '$account') {
                        $search_prefix1 = '$contact';
                        $search_prefix2 = '$contact_user';
                    }

                    $emailtemplateObj->body_html = str_replace($search_prefix1, $recip_prefix, $emailtemplateObj->body_html);
                    $emailtemplateObj->body_html = str_replace($search_prefix2, $recip_prefix, $emailtemplateObj->body_html);

                    if ($args['module_name'] == 'Leads' || $args['module_name'] == 'Prospects') {
                        $email_module = 'Contacts';
                    } else {
                        $email_module = $args['module_name'];
                    }
                    $macro_nv = array();

                    $template_data = $emailtemplateObj->parse_email_template(array(
                        "subject" => $mailSubject,
                        "body_html" => $emailtemplateObj->body_html,
                        "body" => $emailtemplateObj->body), $email_module, $focus, $macro_nv);


                    // create new url for survey with encryption*****************************************

                    $module_id = $focus->id; // module record id
                    // survey URL current with survey_id
                    $replacing_url = $sugar_config['site_url'] . '/survey_submission.php?survey_id=SURVEY_PARAMS';

                    // data to be encoded sufficient data
                    $pure_data = $args['survey_id'] . '&ctype=' . $args['module_name'] . '&cid=' . $module_id . '&sub_id=' . $oSubmission->id;

                    $encoded_data = base64_encode($pure_data);

                    $new_url = $sugar_config['site_url'] . '/survey_submission.php?q=' . $encoded_data;

                    //replace into current mail body for encoded survey URL
                    $template_data['body_html'] = str_replace($replacing_url, $new_url, $template_data['body_html']);

                    // **************************************************************************************
                    $emailBody = $template_data["body_html"];
                    $image_src = "{$sugar_config['site_url']}/index.php?entryPoint=checkEmailOpened&submission_id={$submission_id_each}";
                    $image_url = "<img src='{$image_src}'>";
                    $emailBody .= $image_url;
                    $emailBody .= '<br/><span style="font-size:0.8em">To remove yourself from this email list  <a href="' . $opt_out_url . '" target="_blank">click here</a></span>';
                } else {
                    $emailBody = "Dear " . $focus->name . ",<br/><br/>Admin has approved your request to edit your response for <b>" . $surveyObj->name . "</b>.<br/><br/>You can re-submit your response on following link.<br/><br/><a href='" . $surveyURL . "' target='_blank'>click here</a>";
                    $emailBody .= '<br/><br/><span style="font-size:0.8em">To remove yourself from this email list  <a href="' . $opt_out_url . '" target="_blank">click here</a></span>';
                }

                $response_status = CustomSendEmail($to_Email, $emailSubject, htmlspecialchars_decode($emailBody, ENT_QUOTES), $args['module_id'], $args['module_name']);
                foreach ($submission_res as $submission_row) {
                    // check survey
                    $oSubmission = BeanFactory::getBean('bc_survey_submission', $submission_row['submission_id']);
                    $SurveyObj = $oSubmission->get_linked_beans('bc_survey_submission_bc_survey', 'bc_survey');
                    foreach ($SurveyObj as $objSurvey) {
                        // check survey is current survey or not
                        if ($objSurvey->id == $args['survey_id']) {
                            if ($response_status == 'send') {
                                $gmtdatetime = TimeDate::getInstance()->nowDb();
                                $reponse['status'] = 'sucess';
                                if (!empty($args['status']) && $args['resubmit']) {
                                    $obSurvey = BeanFactory::getBean('bc_survey_submission', $submission_row['submission_id']);
                                    $obSurvey->change_request = $args['status'];
                                    $obSurvey->resubmit = 1;
                                    $obSurvey->last_send_on = $gmtdatetime;
                                    $obSurvey->save();
                                } else if ($submission_row['survey_send'] == 0 && $args['resendFromSubpanel'] == 1 && $args['isSurveyAlreadySend'] == "false") {
                                    $obSurvey = BeanFactory::getBean('bc_survey_submission', $submission_row['submission_id']);
                                    $obSurvey->survey_send = 1;
                                    $obSurvey->resubmit = 1;
                                    $obSurvey->last_send_on = $gmtdatetime;
                                    $obSurvey->save();
                                } else if (!empty($args['resend']) || ($args['resendFromSubpanel'] == 1 && $args['isSurveyAlreadySend'] == "true" )) {
                                    $obSurvey = BeanFactory::getBean('bc_survey_submission', $submission_row['submission_id']);
                                    $resendCount = (int) $obSurvey->resend_counter + 1;
                                    $obSurvey->resubmit = 1;
                                    $obSurvey->last_send_on = $gmtdatetime;
                                    $obSurvey->resend_counter = $resendCount;
                                    $obSurvey->save();
                                }
                            } else {
                                $reponse['status'] = $response_status;
                            }
                        }
                    }
                }
            }
        }
        // Survey Status :: LoadedTech Customization
        else {
            $reponse['status'] = "Sorry, the Survey you are trying to send is no longer active";
        }
        // Survey Status :: LoadedTech Customization END
        return json_encode($reponse);
    }

    /**
     * Function : GetSurveys
     *    get survey list
     * 
     * @return array - $survey_data
     *          bool - 0 - no list found 
     */
    public function GetSurveys($api, $args) {
        require_once 'custom/include/utilsfunction.php';
        $condition = '';
        $current_recipient_module = $args['current_recipient_module'];
        $current_date = gmdate('Y-m-d H:i:s');
        $clear = 'hidden';
        if (!empty($args['search_string']) && $args['search_string'] != 'undefined') {
            $condition = $args['search_string'];
            $clear = "visible";
        }
        require_once('include/SugarQuery/SugarQuery.php');

        $query = new SugarQuery();
        $query->from(BeanFactory::getBean('bc_survey'));
        // select fields
        $query->select->fieldRaw("bc_survey.name", "title");
        $query->select->fieldRaw("bc_survey.id", "id");
        $query->select->fieldRaw("bc_survey.survey_type", "survey_type");
        $query->select->fieldRaw("bc_survey.enable_data_piping", "enable_data_piping");
        $query->select->fieldRaw("bc_survey.sync_module", "sync_module");
        // Survey Status :: LoadedTech Customization
        $query->select->fieldRaw("bc_survey.survey_status", "survey_status");
        // Survey Status :: LoadedTech Customization END

        $query->select->fieldRaw("bc_survey.enable_data_piping", 0);
        if ($args['surveyModule'] == 'poll') {
            $query->where()->equals("bc_survey.survey_type", "poll");
        } else {
            $query->where()->queryOr()->isEmpty("bc_survey.survey_type")->notEquals("bc_survey.survey_type", "poll");
            $query->where()->queryOr()->equals("enable_data_piping", 0)->equals('sync_module', $current_recipient_module);
        }
        // Survey Status :: LoadedTech Customization
        $query->where()->equals("bc_survey.survey_status", "Active");
        // Survey Status :: LoadedTech Customization END

        $query->where()->equals("bc_survey.deleted", 0);


        /*  $query = 'SELECT
          bc_survey.name as title,
          bc_survey.id as id
          FROM bc_survey
          WHERE deleted = 0'; */
        if (!empty($condition)) {
            $condition = $args['search_string'];
            // where condition
            $query->where()->contains('bc_survey.name', $condition);
            //  $query .= " AND bc_survey.name LIKE '%{$condition}%'";
        }
        $query->orderBy('name');
        // $query .= " ORDER BY title";

        $query_result = $query->execute();

        $index = 1;
        $survey_data = array();
        if (!empty($query_result)) {
            foreach ($query_result as $survey) {

                $schedule_surveyDivID = 'sehedule_div_' . $survey['id'];
                $schedule_surveyTRID = 'sehedule_row_' . $survey['id'];
                $survey['schedule_surveyDivID'] = $schedule_surveyDivID;
                $survey['schedule_surveyTRID'] = $schedule_surveyTRID;
                $survey['current_date'] = $current_date;
                $survey['condition'] = $condition;
                $survey_data[$index] = $survey;
                $index++;
            }
            return $survey_data;
        } else {
            return 0;
        }
    }

    /**
     * Function : GetSurveyTemplates
     *    get survey template list
     * 
     * @return array - $survey_data
     *          bool - 0 - no list found 
     */
    public function GetSurveyTemplates($api, $args) {
        require_once 'custom/include/utilsfunction.php';
        $condition = '';
        if (!empty($args['search_string']) && $args['search_string'] != 'undefined') {
            $condition = $args['search_string'];
        }

        require_once('include/SugarQuery/SugarQuery.php');

        $query = new SugarQuery();
        $query->from(BeanFactory::getBean('bc_survey_template'));
        // select fields
        $query->select->fieldRaw("bc_survey_template.name", "title");
        $query->select->fieldRaw("bc_survey_template.id", "id");


        if (!empty($condition)) {
            $condition = $args['search_string'];
            $query->where()->contains('bc_survey_template.name', $condition);
        }
        $query->orderBy('name');

        $query_result = $query->execute();

        $index = 1;
        $survey_data = array();
        if (!empty($query_result)) {
            foreach ($query_result as $survey) {

                $survey['condition'] = $condition;
                $survey_data[$index] = $survey;
                $index++;
            }
            return $survey_data;
        } else {
            return 0;
        }
    }

    /**
     * Function : checkEmailTemplateForSurvey
     *    check email template exist or not for the selected survey
     * 
     * @return string - $emailTempID 
     */
    function checkEmailTemplateForSurvey($api, $args) {
        require_once 'custom/include/utilsfunction.php';
        $emailTempID = '';
        if (!empty($args['survey_ID'])) {
            $emailTempID = getEmailTemplateBySurveyID($args['survey_ID']);
        }
        return $emailTempID;
    }

    /**
     * Function : SendSurveyEmail
     *    send mail to all client selected record 
     * 
     * @return array - $returnDataArray 
     */
    function SendSurveyEmail($api, $args) {
        require_once 'custom/include/utilsfunction.php';
        $customersSummary = array();
        $returnDataArray = array();
        $records = $args['records'];
        $module_name = $args['module_name'];
        $surveySingularModule = $args['surveySingularModule'];
        $survey_id = $args['id_survey'];
        $origin_module = !empty($args['origin_module']) ? $args['origin_module'] : '';
        $origin_module_id = !empty($args['origin_module_id']) ? $args['origin_module_id'] : '';

        $total_seleted_records = ($args['total_selected'] != "0") ? $args['total_selected'] : 1;
        $schedule_on_date = (!empty($args['schedule_on_date']) && $args['schedule_on_date'] != 'current_date') ? $args['schedule_on_date'] : '';
        $schedule_on_time = (!empty($args['schedule_on_time']) && $args['schedule_on_time'] != 'current_time') ? $args['schedule_on_time'] : '';

        $dataArray = sendSurveyEmailsModuleRecords($records, $module_name, $survey_id, $schedule_on_date, $schedule_on_time, false, '', '', $origin_module, $origin_module_id);
        $is_processed = $dataArray['is_send'];
        $customersSummary['MailSentSuccessfullyFirstTime'] = isset($dataArray['MailSentSuccessfullyFirstTime']) ? $dataArray['MailSentSuccessfullyFirstTime'] : '';
        $customersSummary['ResponseSubmitted'] = isset($dataArray['ResponseSubmitted']) ? $dataArray['ResponseSubmitted'] : '';
        $customersSummary['ResponseNotSubmitted'] = isset($dataArray['ResponseNotSubmitted']) ? $dataArray['ResponseNotSubmitted'] : '';
        $customersSummary['unsubscribeCustomers'] = isset($dataArray['unsubscribeCustomers']) ? $dataArray['unsubscribeCustomers'] : '';
        $customersSummary['alreadyOptOut'] = isset($dataArray['alreadyOptOut']) ? $dataArray['alreadyOptOut'] : '';
        $contentPopUP = createContentForMailStatusPopup($customersSummary, $survey_id, $module_name, $total_seleted_records, false, '', '', '', $surveySingularModule);
        $returnDataArray['mailStatus'] = $is_processed;
        $returnDataArray['contentPopUP'] = $contentPopUP;
        $returnDataArray = json_encode($returnDataArray);
        return $returnDataArray;
    }

    /**
     * Function : SendImmediateEmail
     *    send immidiate mail to client from record view
     * 
     * @return array - $returnDataArray 
     */
    function SendImmediateEmail($api, $args) {

        global $sugar_config;
        $isSendSuccess = false;
        $record_name = '';
        require_once 'custom/include/utilsfunction.php';
        $customersSummary = array();
        $returnDataArray = array();
        $records = $args['records'];
        $module_name = $args['module_name'];
        $surveySingularModule = $args['surveySingularModule'];
        $survey_id = $args['id_survey'];
        $origin_module = !empty($args['origin_module']) ? $args['origin_module'] : $args['module_name'];
        $origin_module_id = !empty($args['origin_module_id']) ? $args['origin_module_id'] : $args['records'];
        $schedule_on_date = (!empty($args['schedule_on_date']) && $args['schedule_on_date'] != 'current_date') ? $args['schedule_on_date'] : '';
        $schedule_on_time = (!empty($args['schedule_on_time']) && $args['schedule_on_time'] != 'current_time') ? $args['schedule_on_time'] : '';

        $dataArray = sendSurveyEmailsModuleRecords($records, $module_name, $survey_id, $schedule_on_date, $schedule_on_time, true, '', '', $origin_module, $origin_module_id);
        $is_processed = $dataArray['is_send'];
        $isDetailView = true;

        if ($dataArray['is_send'] == 'scheduled') {
            switch ($args['module_name']) {
                case "Accounts":
                    $focus = new Account();
                    $recip_prefix = '$account';
                    break;
                case "Contacts":
                    $focus = new Contact();
                    $recip_prefix = '$contact';
                    break;
                case "Leads":
                    $focus = new Lead();
                    $recip_prefix = '$contact';
                    break;
                case "Prospects":
                    $focus = new Prospect();
                    $recip_prefix = '$contact';
                    break;
            }
            //retrieve record name of given module
            $focus->retrieve($args['records']);
            $record_name = $focus->name;

            $getSurveyEmailTemplateID = getEmailTemplateBySurveyID($args['id_survey']);
            $emailtemplateObj = new EmailTemplate();
            $emailtemplateObj->retrieve($getSurveyEmailTemplateID);

            //retrieve survey title
            $oSurvey = new bc_survey();
            $oSurvey->retrieve($args['id_survey']);
            $survey_title = $oSurvey->name;

            //replace prefix for recipient name if exists email template for other module
            if ($recip_prefix == '$contact') {
                $search_prefix1 = '$account';
                $search_prefix2 = '$contact_user';
            } else if ($recip_prefix == '$account') {
                $search_prefix1 = '$contact';
                $search_prefix2 = '$contact_user';
            }

            $emailtemplateObj->body_html = str_replace($search_prefix1, $recip_prefix, $emailtemplateObj->body_html);
            $emailtemplateObj->body_html = str_replace($search_prefix2, $recip_prefix, $emailtemplateObj->body_html);

            $mailSubject = (!empty($emailtemplateObj->subject)) ? $emailtemplateObj->subject : $survey_title;
            $emailSubject = htmlspecialchars_decode($mailSubject, ENT_QUOTES);
            $survey_url = $sugar_config['site_url'] . '/survey_submission.php?survey_id=' . $args['id_survey'] . '&ctype=' . $args['module_name'] . '&cid=' . $args['records'] . '&sub_id=' . $dataArray['submission_id'];
            $to_Email = $focus->email1;
            $moduleDetail = "&module_name=" . $args['module_name'] . "&module_id=" . $args['records'];
            $encodedData = base64_encode($moduleDetail);
            $opt_out_url = $sugar_config['site_url'] . '/index.php?entryPoint=unsubscribe&q=' . $encodedData;

            if ($args['module_name'] == 'Leads' || $args['module_name'] == 'Prospects') {
                $email_module = 'Contacts';
            } else {
                $email_module = $args['module_name'];
            }
            $macro_nv = array();

            $template_data = $emailtemplateObj->parse_email_template(array(
                "subject" => $mailSubject,
                "body_html" => $emailtemplateObj->body_html,
                "body" => $emailtemplateObj->body), $email_module, $focus, $macro_nv);

            // create new url for survey with encryption*****************************************

            $module_id = $focus->id; // module record id
            // survey URL current with survey_id
            $survey_url = explode('"', substr($template_data['body_html'], strpos($template_data['body_html'], 'href=')));

            // host name
            $host = strtok($survey_url[1], '?');

            // data to be encoded sufficient data
            $pure_data = $args['id_survey'] . '&ctype=' . $args['module_name'] . '&cid=' . $module_id . '&sub_id=' . $dataArray['submission_id'];

            $encoded_data = base64_encode($pure_data);

            $new_url = $host . '?q=' . $encoded_data;

            //replace into current mail body for encoded survey URL
            $template_data['body_html'] = str_replace($survey_url[1], $new_url, $template_data['body_html']);

            // **************************************************************************************
            $emailBody = $template_data["body_html"];
            $mailSubject = $template_data["subject"];
            $emailSubject = $mailSubject;
            $to_Email = $focus->email1;
            //$image_src = "{$sugar_config['site_url']}/check_email_opened.jpg/{$rec_module_detail['submission_id']}";
            $image_src = "{$sugar_config['site_url']}/index.php?entryPoint=checkEmailOpened&submission_id={$dataArray['submission_id']}";
            $image_url = "<img src='{$image_src}'>";
            $emailBody .= $image_url;
            $emailBody .= '<br/><span style="font-size:0.8em">To remove yourself from this email list  <a href="' . $opt_out_url . '" target="_blank">click here</a></span>';
            $sendMail = CustomSendEmail($to_Email, $emailSubject, $emailBody, $args['records'], $args['module_name']);
            /*
             * Store survey data
             */
            if (trim($sendMail) == 'send') {
                $gmtdatetime = TimeDate::getInstance()->nowDb();
                $survey_submission = new bc_survey_submission();
                $survey_submission->retrieve($dataArray['submission_id']);
                $survey_submission->mail_status = 'sent successfully';
                $survey_submission->last_send_on = $gmtdatetime;
                $survey_submission->survey_send = 1;
                $survey_submission->resend = 0;
                $survey_submission->save();
                $isSendSuccess = 'send';

                $oSurvey->survey_send_status = 'active';
                $oSurvey->save();
            } else if (trim($sendMail) != 'send' && trim($sendMail) != 'notsend') {
                $survey_submission = new bc_survey_submission();
                $survey_submission->retrieve($dataArray['submission_id']);
                $survey_submission->mail_status = $sendMail;
                $isSendSuccess = $sendMail;
                $survey_submission->save();
            } else {
                $survey_submission = new bc_survey_submission();
                $survey_submission->retrieve($dataArray['submission_id']);
                $survey_submission->mail_status = 'Mail Delievery Failed due to invalid email address';
                $survey_submission->survey_send = 0;
                $survey_submission->save();
                $isSendSuccess = $sendMail;
            }
            $isSendNow = true;
        }
        $customersSummary['MailSentSuccessfullyFirstTime'] = isset($dataArray['MailSentSuccessfullyFirstTime']) ? $dataArray['MailSentSuccessfullyFirstTime'] : '';
        $customersSummary['ResponseSubmitted'] = isset($dataArray['ResponseSubmitted']) ? $dataArray['ResponseSubmitted'] : '';
        $customersSummary['ResponseNotSubmitted'] = isset($dataArray['ResponseNotSubmitted']) ? $dataArray['ResponseNotSubmitted'] : '';
        $customersSummary['unsubscribeCustomers'] = isset($dataArray['unsubscribeCustomers']) ? $dataArray['unsubscribeCustomers'] : '';
        $customersSummary['alreadyOptOut'] = isset($dataArray['alreadyOptOut']) ? $dataArray['alreadyOptOut'] : '';
        $total_selected = !isset($args['total_selected']) ? $args['total_selected'] : 1;
        $contentPopUP = createContentForMailStatusPopup($customersSummary, $survey_id, $module_name, $total_selected, $isSendNow, $record_name, $isSendSuccess, $isDetailView, $surveySingularModule);
        $returnDataArray['mailStatus'] = $is_processed;
        $returnDataArray['contentPopUP'] = $contentPopUP;
        $returnDataArray = json_encode($returnDataArray);
        return $returnDataArray;
    }

    /**
     * Function : openSummaryDetailView
     *    get summery view detail
     * 
     * @return array - $dataArr 
     */
    public function openSummaryDetailView($api, $args) {
        global $db, $sugar_config;
        $survey_id = $args['survey_id'];
        $module_name = $args['module_name'];
        $type = $args['type'];
        $currentRecordCount = $args['currentRecordCount'];
        $summaryDataArray = array();
        $offset = 0;
        $limit = (!empty($currentRecordCount)) ? $sugar_config['list_max_entries_per_page'] + (int) $currentRecordCount : $sugar_config['list_max_entries_per_page'];
        $show_more = false;
        if (trim($type) == 'pending_res') {
            if (empty($args['pending_res_record'])) {
                // get pending resonse submission data
                require_once('include/SugarQuery/SugarQuery.php');

                $query = new SugarQuery();
                $query->from(BeanFactory::getBean('bc_survey_submission'));

                // select fields
                $query->select(array('id', 'status', 'survey_send', 'date_entered', 'date_modified', 'target_parent_id'));
                // where condition
                $query->where()->equals('bc_survey.id', $survey_id);
                $query->where()->equals('target_parent_type', $module_name);
                $query->where()->equals('survey_send', 1);
                $query->where()->equals('status', 'Pending');

                $PendingRes = $query->execute();

                $pending_res_record = array();
                foreach ($PendingRes as $PendingRows) {

                    $obSubmission = BeanFactory::getBean('bc_survey_submission', $countResponse['id']);
                    $oSurveyList = $obSubmission->get_linked_beans('bc_survey_submission_bc_survey', 'bc_survey');
                    foreach ($oSurveyList as $oSurvey) {
                        if ($survey_id == $oSurvey->id) {


                            $pending_res_record[] = $PendingRows['target_parent_id'];
                        }
                    }
                }
            } else {
                $pending_res_record = explode(',', $args['pending_res_record']);
            }
            $query = new SugarQuery();
            $query->from(BeanFactory::getBean('bc_survey_submission'));
            $query->join('bc_survey_submission_bc_survey', array('alias' => 'bc_survey'));
            // select fields
            $query->select(array('id', 'status', 'survey_send', 'date_entered', 'date_modified', 'target_parent_id'));
            // where condition
            $query->where()->equals('bc_survey.id', $survey_id);
            $query->where()->equals('target_parent_type', $module_name);
            $query->where()->equals('survey_send', 1);
            $query->where()->equals('status', 'Pending');
            $query->where()->in('target_parent_id', $pending_res_record);

            $query->offset($offset);
            $query->limit($limit);


            $countRes = $query->execute();

            $result_count = 0;
            foreach ($countRes as $countResponse) {
                $result_count++;
            }

            $checkQryRes = $db->query($checkQry);
            $alreadySendCount = 0;
            $returnDataSurvey = array();
            $customersPendingResponse = array();
            if ($result_count > 0) {
                foreach ($countRes as $result) {
                    $obSubmission = BeanFactory::getBean('bc_survey_submission', $result['id']);
                    $oSurveyList = $obSubmission->get_linked_beans('bc_survey_submission_bc_survey', 'bc_survey');
                    foreach ($oSurveyList as $oSurvey) {
                        if ($survey_id == $oSurvey->id) {

                            switch ($module_name) {
                                case "Accounts":
                                    $module = 'Accounts';
                                    break;
                                case "Contacts":
                                    $module = 'Contacts';
                                    break;
                                case "Leads":
                                    $module = 'Leads';
                                    break;
                                case "Prospects":
                                    $module = 'Prospects';
                                    break;
                                case "ProspectLists":
                                    $module = 'ProspectLists';
                                    break;
                            }
                            $bean = BeanFactory::getBean($module);
                            $bean->retrieve($result['target_parent_id']);
                            $name = $bean->name;
                            $id = $bean->id;

                            $returnDataSurvey['ResponseNotSubmitted'][$alreadySendCount]['count'] = $alreadySendCount + 1;
                            $returnDataSurvey['ResponseNotSubmitted'][$alreadySendCount]['recordID'] = $id;
                            $returnDataSurvey['ResponseNotSubmitted'][$alreadySendCount]['recordName'] = $name;
                            $returnDataSurvey['ResponseNotSubmitted'][$alreadySendCount]['SurveySendDate'] = TimeDate::getInstance()->to_display_date_time($result['date_entered']);
                            $alreadySendCount++;
                        }
                    }
                }


                if ($currentRecordCount < $result_count) {
                    $show_more = true;
                    $offset_param = $offset;
                } else {
                    $show_more = false;
                    $offset_param = $offset;
                }
                $customersPendingResponse = (isset($returnDataSurvey['ResponseNotSubmitted']) && !empty($returnDataSurvey['ResponseNotSubmitted'])) ? $returnDataSurvey['ResponseNotSubmitted'] : array();
            }
            $summaryDataArray = $customersPendingResponse;
        } elseif (trim($type) == 'opted_out') {
            $optOutEmailDetails = array();
            $opted_out_record = array();
            if (!empty($args['opted_out_record'])) {
                $opted_out_record[$module_name] = explode(',', $args['opted_out_record']);
            } else {

                  }
            $index = 0;
            $count = 1;
            foreach ($opted_out_record as $survey_mod => $survey_mod_ids) {
                foreach ($survey_mod_ids as $moduleID) {
                    switch ($survey_mod) {
                        case "Accounts":
                            $focus = new Account();
                            break;
                        case "Contacts":
                            $focus = new Contact();
                            break;
                        case "Leads":
                            $focus = new Lead();
                            break;
                        case "Prospects":
                            $focus = new Prospect();
                            break;
                    }
                    $focus->retrieve($moduleID);
                    $record_name = $focus->name;
                    $email = $focus->email1;
                    $optOutEmailDetails[$index]['count'] = $count;
                    $optOutEmailDetails[$index]['record_name'] = $record_name;
                    $optOutEmailDetails[$index]['email'] = $email;
                    $count++;
                    $index++;
                }
            }
            $summaryDataArray = $optOutEmailDetails;
        }
        $have_records = (empty($summaryDataArray)) ? false : true;
        $dataArr = array('SummaryData' => $summaryDataArray,
            'type' => $type,
            'module_name' => $module_name,
            'survey_id' => $survey_id,
            'have_records' => $have_records,
            'show_more' => $show_more,
            'offset_param' => $offset_param);
        return $dataArr;
    }

    /**
     * Function : SendSurveyReminder
     *   send survey reminder
     * 
     * @return array - 'mail status' 
     */
    public function SendSurveyReminder($api, $args) {
        require_once 'custom/include/utilsfunction.php';
        $module_ids = json_decode(html_entity_decode($args['moduleID']));
        $module = $args['moduleName'];
        $survey_id = $args['surveyID'];
        if ($module == 'ProspectLists') {
            $recipients = manageTargetListsModuleForSendSurvey($module_ids, $module);
        } else {
            $recipients[$module] = $module_ids;
        }
        foreach ($recipients as $moduleName => $module_id) {
            if (!is_array($module_id)) {
                $mailStatus = sendSurveyReminderEmails($module_id, $moduleName, $survey_id);
            } else {
                foreach ($module_id as $modID) {
                    $mailStatus = sendSurveyReminderEmails($modID, $moduleName, $survey_id);
                }
            }
        }
        return $mailStatus;
    }

    /**
     * Function : checkingLicenseStatus
     *    check license is validated or not
     * 
     * @return string - 'licence status' - license not validated
     *                  'success' - license validated and user is admin
     *                  'false' - current user is not admin
     */
    public function checkingLicenseStatus() {
        require_once 'custom/biz/classes/Surveyutils.php';
        $checkSurveySubscription = Surveyutils::validateSurveySubscription();

        if (!$checkSurveySubscription['success']) {
            if (!empty($checkSurveySubscription['message'])) {
                // license not validated
                return '<div style="color: #F11147;text-align: center;background: #FAD7EC;padding: 10px;margin: 3% auto;width: 70%;top: 50%;left: 0;right: 0;border: 1px solid #F8B3CC;font-size : 14px;">' . $checkSurveySubscription['message'] . '</div>';
            }
        } else { //--------- module enabled--------
            return 'success';
        }
    }

    /**
     * Function : exportToExcel
     *    export data to excel sheet
     * 
     * @return string - 'content'
     */
    public function exportToExcel($api, $args) {
        require_once 'custom/include/utilsfunction.php';
        global $app_list_strings, $current_language;
        $name = $args['module_name'];
        $module = $args['module_type'];
        $type = $args['submission_type'];
        $status = $args['survey_status'];
        $survey_id = $args['survey_id'];
        $report_type = $args['report_type'];
        $page = $args['page'];
        $submission_start_date = $args['submission_start_date'];
        $submission_end_date = $args['submission_end_date'];
       $del = "\t";
        $surveyObj = new bc_survey();
        $surveyObj->retrieve($survey_id);
        $filename = str_replace(" ", "_", $surveyObj->name);
        $finalExportData = getAllExportData($report_type, $survey_id, $name, $module, $type, $status, $submission_start_date, $submission_end_date);

        /*
         * Get all fields array for export headers
         */
        $ResetedRes = array_values($finalExportData);
        $FirstRes = (isset($ResetedRes[0])) ? $ResetedRes[0] : array();
        $Ques_keys = array();
        foreach ($FirstRes['Response'] as $Q => $a) {
            $Que = array_keys($a);
            array_push($Ques_keys, $Que[0]);
        }
        unset($FirstRes['Response']);
        $column_keys = array_keys($FirstRes);
        $pre_definedlan = array(
            'customer_name' => 'Customer Name',
            'module_type' => 'Module',
            'submission_type' => 'Type',
            'survey_status' => 'Status',
            'send_date' => 'Survey Send Date',
            'receive_date' => 'Survey Receive Date',
            'change_request' => 'Change Request',
            'consent_accepted' => 'Consent Accepted?',
        );
        $filed_keys = array();
        foreach ($column_keys as $coloum) {
            $filed_keys[] = $pre_definedlan[$coloum];
        }
        $exportFields = array_merge($filed_keys, $Ques_keys);
        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename={$filename}.csv");
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        
        $content = '';

        foreach ($exportFields as $key => $str) {
            $str = preg_replace("/\t/", "\\t", $str);
            $str = preg_replace("/&nbsp;/", "", $str);
            if (strstr($str, '"'))
                $str = '"' . str_replace('"', '""', $str) . '"';
            $exportFields[$key] = $str;
        }

        $content .= htmlspecialchars_decode("\"" . implode("\"" . $del . "\"", array_values($exportFields)), ENT_QUOTES) . "\"\r\n";
        
        foreach ($finalExportData as $row) {
            $response = $row['Response'];
            unset($row['Response']);
            $clientData = array_values($row);
            $surValues = array();
            foreach ($response as $key => $value) {
                $val = array_values($value);
                $pushVal = (empty($val[0])) ? 'N/A' : $val[0];
                array_push($surValues, $pushVal);
            }
            $ExportRow = array_merge($clientData, $surValues);
            foreach ($ExportRow as $key => $str) {
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/&nbsp;/", "", $str);
                $ExportRow[$key] = html_entity_decode($str, ENT_QUOTES);
            }

            $content .= htmlspecialchars_decode("\"" . implode("\"" . $del . "\"", array_values($ExportRow)), ENT_QUOTES) . "\"\r\n";
        }
        return $content;
    }

    /**
     * Function : isSurveySend
     *    survey is already sent or not
     * 
     * @return string - '0' - not sent
     *                  '1' - sent
     */
    public function isSurveySend($api, $args) {
        global $db, $sugar_version;
        /*
         * Check already sent to other
         */
        $oSurvey = BeanFactory::getBean('bc_survey', $args['record']);

        // To allow survey edit untill the survey form has not opened. By Govind.
        $oSubmissionList = array();
        if (!empty($oSurvey->id)) {
            $oSubmissionList = $oSurvey->get_linked_beans('bc_survey_submission_bc_survey', 'bc_survey',array(), 0 , 1);
        }
        if ($oSurvey->form_seen == true && count($oSubmissionList) > 0) {
            $total_submission = 1;
        } else {
            $total_submission = 0;
        }
        // End
        if ($total_submission > 0) {
            // if total submission is not 0 then set flag to 1 for restricting edit survey
            $restrict_edit = "1";
        } else {
            // if total submission is 0 then set flag to 0 for allow editing survey
            $restrict_edit = "0";
        }

        // Check sugar version 7.7 or less
        if (version_compare($sugar_version, '7.7', '>')) {
            $sugarLatest = "1";
        } else {
            $sugarLatest = "0";
        }
        // Survey Status :: LoadedTech Customization
        if ($oSurvey->survey_status == 'Active') {
            $survey_status = "1";
        } else {
            $survey_status = "0";
        }

        $resultArray = array();
        $resultArray['restrict_edit'] = $restrict_edit;
        $resultArray['sugar_latest'] = $sugarLatest;
        $resultArray['survey_status'] = $survey_status;
        // Survey Status :: LoadedTech Customization END
        return $resultArray;
    }

    /**
     * Function : getSurveyURL
     *    get survey form url
     * 
     * @return string - 'surveyUrl' 
     */
    public function getSurveyURL($api, $args) {
        //getting survey url 
        global $sugar_config;
        require_once('modules/Administration/Administration.php');
        $administrationObj = new Administration();
        $administrationObj->retrieveSettings('SurveyPlugin');
        // url of survey
        $survey_url_for_email = $administrationObj->settings['SurveyPlugin_survey_url_for_email'];
        $sugar_survey_Url = $sugar_config['site_url'] . $survey_url_for_email; //create survey submission url
        $encoded_param = base64_encode($args['survey_id'] . '&ctype=' . $args['module_type'] . '&cid=' . $args['module_id'] . '&sub_id=' . $args['submission_id']);
        $sugar_survey_Url = str_replace('survey_id=', 'q=', $sugar_survey_Url);
        //whole survey url created
        $surveyURL = $sugar_survey_Url . $encoded_param . '&submitted_by=sender';
        return $surveyURL;
    }

    /**
     * Function : getResubmissionStatus
     *    get resubmission status
     * 
     * @return string - 'true' - resubmission
     *                  'false' - not a resubmission
     */
    public function getResubmissionStatus($api, $args) {
        //getting survey re submission status


        $submission_id = $args['submission_id'];
        $oSubmission = BeanFactory::getBean('bc_survey_submission', $submission_id);


        if (!empty($oSubmission->id)) {
            //while ($row = $db->fetchByAssoc($result)) {
            if ($oSubmission->resubmit == 1 || $oSubmission->resend == 1) {
                $result = 'true';
            } else {
                $result = 'false';
            }
        }
        return $result;
    }

    function getTargetRelatedtoForSubmission($api, $args) {
        // retrieve submission details
        global $app_list_strings;
        $submission_id = $args['submission_id'];
        $oSubmission = new bc_survey_submission();
        $oSubmission->retrieve($submission_id);

        $target_parent_id = $oSubmission->target_parent_id; // parent id
        $target_parent_type = $oSubmission->target_parent_type; // parent type

        $parent_id = $oSubmission->parent_id; // parent id
        $parent_name = $oSubmission->parent_name; // parent type

        $origin_type = $oSubmission->parent_type;
        $target_type = $oSubmission->target_parent_type;

        if (!empty($target_parent_id) && !empty($target_parent_type)) {
            $oTargetModule = BeanFactory::getBean($target_parent_type, $target_parent_id);
            $target_parent_name = $oTargetModule->name;

            return array('target_parent_name' => $target_parent_name, 'target_parent_id' => $target_parent_id, 'origin_type' => $origin_type, 'target_type' => $target_type, 'parent_id' => $parent_id, 'parent_name' => $parent_name);
        } else {
            return false;
        }
    }

    public function delete_transaction($api, $args) {
        global $db;
        $submission_id = $args['submission_id'];
        $surveyID = $args['surveyID'];
        // Retrieve related submited data
        $submission = BeanFactory::getBean('bc_survey_submission', $submission_id);
        $submission_data_obj = $submission->get_linked_beans('bc_submission_data_bc_survey_submission', 'bc_submission_data');

        foreach ($submission_data_obj as $submited_data) {

            $GLOBALS['log']->debug("This is the submitted data :------- " . print_r($submited_data->id, 1));
            // delete submited data
            $submited_data->deleted = 1;
            $submited_data->save();
            // deleted submission and submited data relationship
            $submission->bc_submission_data_bc_survey_submission->delete($submission->id, $submited_data->id);

            if (is_object($submited_data->bc_submission_data_bc_survey_answers)) {
                foreach ($submited_data->bc_submission_data_bc_survey_answers->getBeans() as $submited_ans) {

                    $GLOBALS['log']->debug("This is the submitted answer :------- " . print_r($submited_ans->id, 1));

                    // deleted submission and answer relationship
                    $submited_data->bc_submission_data_bc_survey_answers->delete($submited_data->id, $submited_ans->id);
                }
            }
            if (is_object($submited_data->bc_submission_data_bc_survey_questions)) {
                foreach ($submited_data->bc_submission_data_bc_survey_questions->getBeans() as $submited_que) {

                    $GLOBALS['log']->debug("This is the submitted question :------- " . print_r($submited_que->id, 1));

                    // deleted submission and question relationship
                    $submited_data->bc_submission_data_bc_survey_questions->delete($submited_data->id, $submited_que->id);
                }
            }
        }

        $rm_old_qry = "delete from bc_survey_submit_answer_calculation WHERE 
                                           submission_id = '{$submission->id}'
                                      ";
        
        $db->query($rm_old_qry);

        // Remove submissions entry from history table
        $rm_history_qry = "delete from bc_submission_history_individual WHERE 
                                            submission_id = '{$submission->id}' 
                                      ";

        $db->query($rm_history_qry);

        // delete submission
        $submission->deleted = 1; // delete submission
        $submission->save();

        // Set Send Status as "Unpublished" if no any other submission found for current survey
        $oSurvey = BeanFactory::getBean('bc_survey', $surveyID);
        $oSubmissions = $oSurvey->get_linked_beans('bc_survey_submission_bc_survey', 'bc_survey_submission');
        if (count($oSubmissions) == 0) {
            $oSurvey->survey_send_status = 'inactive';
            $oSurvey->save();
        }
        return $submission_id;
    }

    public function get_survey_language($api, $args) {
        global $sugar_config;
        $result = array();
        $survey_id = $args['survey_id'];
        $oSurvey = BeanFactory::getBean('bc_survey', $survey_id);
        $result['default_survey_language'] = $oSurvey->default_survey_language;
        $result['supported_survey_language'] = unencodeMultienum($oSurvey->supported_survey_language);
        $result['default_crm_language'] = $sugar_config['default_language'];
        $result['survey_title'] = $oSurvey->name;
        $result['survey_type'] = ucfirst($oSurvey->survey_type);

        // get language related detail from language module
        require_once('include/SugarQuery/SugarQuery.php');
        $query = new SugarQuery();
        $query->from(BeanFactory::getBean('bc_survey_language'));
        // select fields
        $query->select(array('id', 'status', 'text_direction', 'survey_lang', 'bc_survey_id_c', 'translated'));
        // where condition
        $query->where()->equals('bc_survey_id_c', $survey_id);

        $query->offset($offset);
        $query->limit($limit);

        $LangRes = $query->execute();

        $lang_detail = array();
        $edit_lang_detail = array();
        foreach ($LangRes as $key => $langValue) {
            if ($langValue['id'] == $args['lang_id']) {
                $edit_lang_detail = array('id' => $langValue['id'], 'survey_lang' => $langValue['survey_lang'], 'status' => $langValue['status'], 'text_direction' => $langValue['text_direction'], 'translated' => $langValue['translated']);
            }
            $lang_detail[$langValue['survey_lang']] = array('id' => $langValue['id'], 'status' => $langValue['status'], 'text_direction' => $langValue['text_direction'], 'translated' => $langValue['translated']);
        }
        $result['lang_detail'] = $lang_detail;
        $result['edit_lang_detail'] = $edit_lang_detail;

        return $result;
    }

    public function save_new_language($api, $args) {

        $survey_id = $args['survey_id'];
        $survey_lang_id = $args['lang_id'];
        $new_lang = $args['new_lang'];
        $alloow_copy = $args['allow_copy'];
        $text_direction = $args['text_direction'];
        $status = $args['status'];
        if (empty($survey_lang_id)) { // add new record
            $oSurvey = BeanFactory::getBean('bc_survey', $survey_id);
            if (!empty($oSurvey->supported_survey_language)) {
                $new_lang = $oSurvey->supported_survey_language . ',^' . $new_lang . '^';
            } else {
                $new_lang = '^' . $new_lang . '^';
            }
            $oSurvey->supported_survey_language = $new_lang;
            $oSurvey->save();
        }
        if (empty($survey_lang_id)) { // add new record
            $oSurveyLang = BeanFactory::getBean('bc_survey_language');
            $oSurveyLang->text_direction = $text_direction;
            $oSurveyLang->bc_survey_id_c = $survey_id;
            $oSurveyLang->survey_lang = $args['new_lang'];
            $oSurveyLang->status = $status;
            $oSurveyLang->translated = 0;
            $oSurveyLang->save();
        } else { // update existing record
            $oSurveyLang = BeanFactory::getBean('bc_survey_language', $survey_lang_id);
            $oSurveyLang->text_direction = $text_direction;
            $oSurveyLang->status = $status;
            $oSurveyLang->save();
        }

        return $oSurveyLang->id;
    }

    public function remove_language($api, $args) {
        global $sugar_config;
        $result = array();
        $survey_id = $args['survey_id'];
        $survey_lang_id = $args['lang_id'];
        $sel_lang = $args['sel_lang'];
        $oSurvey = BeanFactory::getBean('bc_survey', $survey_id);
        $curreLang = unencodeMultienum($oSurvey->supported_survey_language);
        foreach ($curreLang as $lang) {
            if ($lang != $sel_lang) {
                $newLang[] = $lang;
            }
        }
        $newEncodedLang = encodeMultienumValue($newLang);
        $oSurvey->supported_survey_language = $newEncodedLang;
        $oSurvey->save();

        // delete language from survey language module
        $oSurveyLang = BeanFactory::getBean('bc_survey_language', $survey_lang_id);
        $oSurveyLang->deleted = 1;
        $oSurveyLang->save();

        // Empty language labels to custom file
        require_once('modules/ModuleBuilder/MB/ModuleBuilder.php');
        require_once('modules/ModuleBuilder/parsers/parser.dropdown.php');
        global $app_list_strings;
        $parser = new ParserDropDown();
        $params = array();
        $_REQUEST['view_package'] = 'studio'; //need this in parser.dropdown.php
        $_REQUEST['dropdown_lang'] = $sel_lang;
        $params['view_package'] = $_REQUEST['view_package'];
        $params['dropdown_name'] = $survey_id; //replace with the dropdown name with survey id
        $params['dropdown_lang'] = $sel_lang;
        $params['skip_sync'] = 'yes';
        $dropdwon_list = $app_list_strings[$params['dropdown_name']];

        $drop_list[] = array();
        $params['list_value'] = json_encode($drop_list);
        $parser->saveDropDown($params);

        return $oSurvey->id;
    }

    public function save_default_language($api, $args) {

        $survey_id = $args['survey_id'];
        $new_lang = $args['sel_lang'];
        $oSurvey = BeanFactory::getBean('bc_survey', $survey_id);

        $oSurvey->default_survey_language = $new_lang;
        $oSurvey->save();

        return $oSurvey->id;
    }

    /**
     * Function : get_survey
     *    get survey detail
     * 
     * @return array - $data 
     */
    public function get_survey_detail_to_translate_lang($api, $args) {
        global $app_list_strings;
        $record_id = $args['record_id'];
        $all_survey_details = array();
        if ($record_id != 'SurveyTemplate') {
            $oSurvey = new bc_survey();
            $oSurvey->retrieve($record_id);
            $oSurvey->load_relationship('bc_survey_pages_bc_survey');
            $all_survey_details['survey_id'] = $oSurvey->id;
            $all_survey_details['survey_title'] = $oSurvey->name;
            $all_survey_details['survey_description'] = $oSurvey->description;
            $all_survey_details['survey_welcome_page'] = $oSurvey->survey_welcome_page;
            $all_survey_details['survey_thanks_page'] = $oSurvey->survey_thanks_page;
            $all_survey_details['review_mail_content'] = $oSurvey->review_mail_content;
        }

        $questions = array();

        foreach ($oSurvey->bc_survey_pages_bc_survey->getBeans() as $pages) {
            unset($questions);
            $survey_details[$pages->page_sequence]['page_title'] = $pages->name;
            $survey_details[$pages->page_sequence]['page_number'] = $pages->page_number;
            $survey_details[$pages->page_sequence]['page_id'] = $pages->id;
            $pages->load_relationship('bc_survey_pages_bc_survey_questions');
            foreach ($pages->bc_survey_pages_bc_survey_questions->getBeans() as $survey_questions) {
                $questions[$survey_questions->question_sequence]['que_id'] = $survey_questions->id;
                $questions[$survey_questions->question_sequence]['que_title'] = $survey_questions->name;
                $questions[$survey_questions->question_sequence]['que_type'] = $survey_questions->question_type;
                $questions[$survey_questions->question_sequence]['question_help_comment'] = $survey_questions->question_help_comment;
                //advance options
                $questions[$survey_questions->question_sequence]['advance_type'] = (isset($survey_questions->advance_type)) ? $survey_questions->advance_type : '';
                $questions[$survey_questions->question_sequence]['enable_otherOption'] = (isset($survey_questions->enable_otherOption) && $survey_questions->enable_otherOption == 1 ) ? 'Yes' : 'No';
                $questions[$survey_questions->question_sequence]['matrix_row'] = (isset($survey_questions->matrix_row)) ? base64_decode($survey_questions->matrix_row) : '';
                $questions[$survey_questions->question_sequence]['matrix_col'] = (isset($survey_questions->matrix_col)) ? base64_decode($survey_questions->matrix_col) : '';
                $questions[$survey_questions->question_sequence]['description'] = (isset($survey_questions->description)) ? $survey_questions->description : '';


                $survey_questions->load_relationship('bc_survey_answers_bc_survey_questions');
                if ($survey_questions->question_type != 'boolean') {
                    foreach ($survey_questions->bc_survey_answers_bc_survey_questions->getBeans() as $survey_answers) {

                        $questions[$survey_questions->question_sequence]['answers'][$survey_answers->answer_sequence][$survey_answers->id]['option'] = $survey_answers->answer_name;
                        $questions[$survey_questions->question_sequence]['answers'][$survey_answers->answer_sequence][$survey_answers->id]['answer_type'] = $survey_answers->answer_type;
                    }
                    if (isset($questions[$survey_questions->question_sequence]['answers']) && is_array($questions[$survey_questions->question_sequence]['answers']))
                        ksort($questions[$survey_questions->question_sequence]['answers']);
                }
            }
            ksort($questions);
            $survey_details[$pages->page_sequence]['page_questions'] = $questions;
        }


        ksort($survey_details);
        $all_survey_details['pages'] = $survey_details;
        $result['survey_detail'] = $all_survey_details;

        // get survey language detail
        $survey_lang_detail_array = return_app_list_strings_language($args['selected_lang']);
        $survey_lang_detail = $survey_lang_detail_array[$record_id];
        foreach ($survey_lang_detail as $key => $value) {
            if (($key == 'survey_welcome_page' || $key == 'survey_thanks_page' || $key == 'review_mail_content') && !empty($value)) {
                $value = base64_decode($value);
                $survey_lang_detail[$key] = $value;
            }
        }
        $result['survey_lang_detail'] = $survey_lang_detail;

        $data = json_encode($result);
        return $data;
    }

    public function save_language_translation($api, $args) {
        global $sugar_config;

        $survey_id = $args['survey_id'];
        $survey_lang_id = $args['lang_id'];
        $paramsToSave = json_decode($args['params']);

        if (!empty($survey_lang_id)) { // edit record
            $oSurveyLang = BeanFactory::getBean('bc_survey_language', $survey_lang_id);
            $oSurveyLang->translated = 1;
            $oSurveyLang->save();
        }
        if ($oSurveyLang->survey_lang != $sugar_config['default_language']) {
            // Save language labels to custom file
            require_once('modules/ModuleBuilder/MB/ModuleBuilder.php');
            require_once('modules/ModuleBuilder/parsers/parser.dropdown.php');

            $parser = new ParserDropDown();
            $params = array();
            $_REQUEST['view_package'] = 'studio'; //need this in parser.dropdown.php
            $_REQUEST['dropdown_lang'] = $oSurveyLang->survey_lang;
            $params['view_package'] = $_REQUEST['view_package'];
            $params['dropdown_name'] = $survey_id; //replace with the dropdown name with survey id
            $params['dropdown_lang'] = $oSurveyLang->survey_lang;
            //    $params['skip_sync'] = 'yes';
            $params['use_push'] = 'yes';


            foreach ($paramsToSave as $key => $value) {
                if (($key == 'survey_welcome_page' || $key == 'survey_thanks_page' || $key == 'review_mail_content') && !empty($value)) {
                    $value = base64_encode($value);
                }
                if (!empty($key) && $key != 'undefined') {
                    if (is_object($value)) {
                        $new_array = array();
                        foreach ($value as $array_key => $array_value) {
                            $drop_list[] = array($key . _ . $array_key, $array_value);
                        }
                    } else {
                        $drop_list[] = array($key, $value);
                    }
                }
            }

            $params['list_value'] = json_encode($drop_list);
            $parser->saveDropDown($params);
        }
        return $oSurveyLang->id;
    }

    function generate_unique_survey_submit_id($api, $args) {
        global $sugar_config;

        $survey_id = $args['survey_id'];
        $oSurvey = BeanFactory::getBean('bc_survey', $survey_id);
        if (empty($oSurvey->survey_submit_unique_id) && empty($args['status'])) {
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
            $uid = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 6; $i++) {
                $n = rand(0, $alphaLength);
                $uid[] = $alphabet[$n];
            }
            $oSurvey->survey_submit_unique_id = implode($uid);
            $oSurvey->save();
        }
        // sharable survey link
        if (empty($oSurvey->survey_submit_unique_id)) {
            return false;
        } else {
            $survey_sharable_link = $sugar_config['site_url'] . '/survey_submission.php?q=' . $oSurvey->survey_submit_unique_id;
            return $survey_sharable_link;
        }
    }

    /*
     * Function get_sync_module_fields
     *      Get Sync Module All fields for Data Piping
     */

    function get_sync_module_fields($api, $args = '') {
        // Sync Module List
        $sync_module_array = array('Accounts', 'Contacts', 'Leads', 'Prospects');
        $allowed_field_type = array('name', 'text', 'int', 'varchar', 'enum', 'multienum', 'radioenum', 'phone', 'email', 'date', 'datetime', 'datetimecombo');
        $result_sync_fields = array();
        $result_sync_fields_type = array();

        // Getfields from vardef
        foreach ($sync_module_array as $module) {
            $lang = return_module_language('en_us', $module);
            // Retrieve Module Object
            $dom_Obj = BeanFactory::getBean($module);
            foreach ($dom_Obj->field_defs as $key => $field) {
                if (in_array($field['type'], $allowed_field_type) && (!isset($field['studio']) || (isset($field['studio']) && $field['studio'] == 'visible') || $field['name'] == 'email1' ) && $field['name'] != 'preferred_language' && $field['name'] != 'email' && $field['name'] != 'email2' && $field['name'] != 'email_addresses_non_primary' && $field['name'] != 'tracker_key' && $field['name'] != 'date_modified' && $field['name'] != 'date_entered') {
                    $labelValue = trim($lang[$field['vname']], ':');
                    $result_sync_fields[$module][$field['name']] = $labelValue;
                    $result_sync_fields_type[$module][$field['name']] = array($labelValue => $field['type']);
                }
                if ($field['type'] == 'bool' && (!isset($field['studio']) || (isset($field['studio']) && $field['studio'] == 'visible')) && (!isset($field['source']) || (isset($field['source']) && $field['source'] != 'non-db')) && $field['name'] != 'preferred_language' && $field['name'] != 'email' && $field['name'] != 'email2' && $field['name'] != 'email_addresses_non_primary' && $field['name'] != 'tracker_key' && $field['name'] != 'deleted') {
                    $labelValue = trim($lang[$field['vname']], ':');
                    $result_sync_field_boolean[$module][$field['name']] = $labelValue;
                    $result_sync_fields_type_boolean[$module][$field['name']] = array($labelValue => $field['type']);
                }
            }
            asort($result_sync_fields[$module]);
        }

        //    $GLOBALS['log']->debug("This is the result of sync field : " . print_r($result_sync_fields_type, 1));
        $result = array();
        $result['field_labels'] = $result_sync_fields;
        $result['field_types'] = $result_sync_fields_type;
        $result['field_labels_boolean'] = $result_sync_field_boolean;

        //  $GLOBALS['log']->debug("This is the result of sync field : " . print_r(   $result['field_types'], 1));


        return $result;
    }

    function compare_survey_field_with_module_field($api, $args) {
        global $app_list_strings;
        $sync_field = $args['sync_field'];
        $sync_module = $args['sync_module'];
        $current_que_type = $args['current_que_type'];
        $result = array();

        // Retrieve Module Object
        $dom_Obj = BeanFactory::getBean($sync_module);
        // Retrieve Sync Field type
        $sync_field_type = $dom_Obj->field_defs[$sync_field]['type'];

        if ($sync_field == 'email1') {
            $sync_field_type = 'email';
        }

        // check field is required or not
        $is_required_sync_field = $dom_Obj->field_defs[$sync_field]['required'];

        // check current question type matches to sync field type or not
        if (($sync_field_type == 'name' || $sync_field_type == 'varchar' || $sync_field_type == 'phone')) {
            $result = array('correct_que_type' => 'textbox', 'correct_data_type' => 'Char', 'is_required' => $is_required_sync_field);
        } else if ($sync_field_type == 'int') {
            $result = array('correct_que_type' => 'textbox', 'correct_data_type' => 'Integer', 'is_required' => $is_required_sync_field);
        } else if ($sync_field_type == 'email') {
            $result = array('correct_que_type' => 'textbox', 'correct_data_type' => 'Email', 'is_required' => $is_required_sync_field);
        } else if ($sync_field_type == 'text') {
            $result = array('correct_que_type' => 'commentbox', 'is_required' => $is_required_sync_field);
        } else if ($sync_field_type == 'enum') {
            $options_dom = $dom_Obj->field_defs[$sync_field]['options'];
            if (is_array($options_dom)) {
                $options = $options_dom;
            } else {
                $options = $app_list_strings[$options_dom];
            }
            $result = array('correct_que_type' => 'dropdownlist', 'options' => $options, 'is_required' => $is_required_sync_field);
        } else if ($sync_field_type == 'multienum') {
            $options_dom = $dom_Obj->field_defs[$sync_field]['options'];
            if (is_array($options_dom)) {
                $options = $options_dom;
            } else {
                $options = $app_list_strings[$options_dom];
            }
            $result = array('correct_que_type' => 'multiselectlist', 'options' => $options, 'is_required' => $is_required_sync_field);
        } else if ($sync_field_type == 'radioenum') {
            $options_dom = $dom_Obj->field_defs[$sync_field]['options'];
            if (is_array($options_dom)) {
                $options = $options_dom;
            } else {
                $options = $app_list_strings[$options_dom];
            }
            $result = array('correct_que_type' => 'radio-button', 'options' => $options, 'is_required' => $is_required_sync_field);
        } else if ($sync_field_type == 'date') {
            $result = array('correct_que_type' => 'date-time', 'is_required' => $is_required_sync_field, 'is_datetime' => false);
        } else if ($sync_field_type == 'datetime' || $sync_field_type == 'datetimecombo') {
            $result = array('correct_que_type' => 'date-time', 'is_required' => $is_required_sync_field, 'is_datetime' => true);
        }

        return json_encode($result);
    }

    function retrieve_all_module_field_required_status($api, $args) {
        global $app_list_strings;
        $result = array();
        $all_fields = $this->get_sync_module_fields($api, $args);



        // Retrieve Sync Field type
        foreach ($all_fields['field_labels'] as $module => $sync_fields) {
            foreach ($sync_fields as $field => $field_label) {
                // Retrieve Module Object
                $dom_Obj = BeanFactory::getBean($module);
                // check field is required or not
                if (isset($dom_Obj->field_defs[$field]) && isset($dom_Obj->field_defs[$field]['required'])) {
                    $is_required_sync_field = $dom_Obj->field_defs[$field]['required'];
                }

                // check current question type matches to sync field type or not
                if (!isset($is_required_sync_field)) {
                    $is_required_sync_field = '';
                }
            }
        }

        // Retrieve Sync Field type
        foreach ($all_fields['field_types'] as $module => $sync_fields) {
            $GLOBALS['log']->fatal('This is the $sync_fields : ', print_r($sync_fields, 1));
            foreach ($sync_fields as $field => $field_label) {
                // Retrieve Module Object
                $dom_Obj = BeanFactory::getBean($module);
                // check field is required or not
                $is_required_sync_field = (!empty($dom_Obj->field_defs[$field]['required'])) ? $dom_Obj->field_defs[$field]['required'] : '';

                // check current question type matches to sync field type or not
                foreach ($field_label as $k_label => $type) {
                    $label = $k_label;
                }
                $result[$module][$field] = array('is_required' => $is_required_sync_field, 'label' => $label);
            }
        }

        // Retrieve Sync Field type
        foreach ($all_fields['field_labels_boolean'] as $module => $sync_fields) {

            foreach ($sync_fields as $field => $field_label) {
                // Retrieve Module Object
                $dom_Obj = BeanFactory::getBean($module);
                // check field is required or not
                $is_required_sync_field = (!empty($dom_Obj->field_defs[$field]['required'])) ? $dom_Obj->field_defs[$field]['required'] : '';

                // check current question type matches to sync field type or not
                $result[$module][$field] = array('is_required' => $is_required_sync_field, 'label' => $field_label);
            }
        }

        return ($result);
    }

    /**
     * Description :: This function is used to check license validation.
     * 
     * @return bool '$result' - 1 - license validated
     *                          0 - license not validated
     */
    public function validateLicense($api, $args) {
        require_once 'custom/biz/classes/Surveyutils.php';
        // get validate license status
        $key = $args['k'];
        $CheckResult = Surveyutils::checkPluginLicense($key);
        return $CheckResult;
    }

    /**
     * Description :: This function is used to enable or disable plugin.
     * 
     * @return bool '$result' - true - plugin enabled
     */
    public function enableDisableSurvey($api, $args) {
        //used to enable/disable plugin
        require_once('modules/Administration/Administration.php');
        require_once 'custom/biz/classes/autoFillSurveyReportModule.php';
        $enabled = $args['enabled'];
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
        // Execute only once when click on Save:
        // To repair report data.
        oneTimeScriptToRepairReportData();
        return true;
    }

    public function save_surveysmtp_setting($api, $args) {
        require_once('modules/Administration/Administration.php');
        $administrationObj = new Administration();
        $administrationObj->saveSetting("SurveySmtp", "survey_notify_fromname", $args['survey_notify_fromname']);
        $administrationObj->saveSetting("SurveySmtp", "survey_notify_fromaddress", $args['survey_notify_fromaddress']);
        $administrationObj->saveSetting("SurveySmtp", "survey_smtp_email_provider", $args['survey_smtp_email_provider']);
        $administrationObj->saveSetting("SurveySmtp", "survey_mail_smtp_host", $args['survey_mail_smtp_host']);
        $administrationObj->saveSetting("SurveySmtp", "survey_mail_smtpport", $args['survey_mail_smtpport']);
        $administrationObj->saveSetting("SurveySmtp", "survey_mail_smtpssl", $args['survey_mail_smtpssl']);
        $administrationObj->saveSetting("SurveySmtp", "survey_mail_smtp_smtpauth_req", $args['survey_mail_smtp_smtpauth_req']);
        $administrationObj->saveSetting("SurveySmtp", "survey_mail_smtp_username", $args['survey_mail_smtp_username']);
        $administrationObj->saveSetting("SurveySmtp", "survey_mail_smtp_password", $args['survey_mail_smtp_password']);
        $administrationObj->saveSetting("SurveySmtp", "survey_mail_smtp_retype_password", $args['survey_mail_smtp_retype_password']);

        return true;
    }

    // Survey Status :: LoadedTech Customization
    public function change_survey_status($api, $args) {
        if ($args['survey_status'] == '1') {
            $survey_status = 'Active';
        } else {
            $survey_status = 'Inactive';
        }
        if (!empty($args['record_id'])) {
            $oSurvey = BeanFactory::getBean('bc_survey', $args['record_id']);
            $oSurvey->survey_status = $survey_status;
            $oSurvey->save();
            return 'Survey status has been updated as ' . $survey_status;
        } else {
            return 'Survey not found to update status.';
        }
    }

    public function generateIndividualHistory($api, $args) {
        global $db;
        $submission_id = $args['sub_id'];
        $que_id = $args['que_id'];

        $selQry = "SELECT * FROM bc_submission_history_individual WHERE question_id = '$que_id' and  submission_id = '$submission_id' ORDER BY submission_date DESC";
        $result = $db->query($selQry);

        $answer_Submitted = array();
        $dbFormat = TimeDate::getInstance()->get_db_date_time_format();
        while ($row = $db->fetchByAssoc($result)) {
            $answer_Submitted[] = $row;
}

        $isDocLinkAdded = false;
        $html = '';
        if (!empty($answer_Submitted)) {
            $html = '<div class="answerHistoryDetail" style="padding: 10px 3%; max-height: 375px; overflow: auto;">';
            // Retrieve Question Title
            $resultQue = $db->query("SELECT name,maxsize,matrix_row,matrix_col,is_image_option FROM bc_survey_questions WHERE id='$que_id' ");
            $que_detail = $db->fetchByAssoc($resultQue);
            $html .= "  <div class='que-rwo'> <p class='que'><b>Question</b>" . $que_detail['name'] . '</p>';

            $multiChoiceQueType = array('check-box', 'multiselectlist', 'radio-button', 'dropdownlist', 'boolean');
            foreach ($answer_Submitted as $k => $subDetail) {
                $subDate = date($dbFormat,strtotime($subDetail['submission_date']));
                $subDetail['submission_date'] = TimeDate::getInstance()->to_display_date_time($subDate);
                // Submission Row 
                $html .= '<div class="row subDateRow"><span class="span8"> <span class="btn  answerHistory" style="margin-left:0px;"><i class="fa fa-clock-o"></i></span> <span style="background-color: #f6f6f6;">' . $subDetail['submission_date'] . '</span></span></div>';

                // Multi Choice and other already stored Question Types
                if (in_array($subDetail['question_type'], $multiChoiceQueType)) {
                    $answersList = explode(',', $subDetail['submitted_answer']);

                    $html .= '<div class="row answerRow"><span class="span8"><span><ul style="margin-left:40px;" class="ind-reportr-ul-class">';
                    if (!empty($subDetail['submitted_answer']) && $subDetail['submitted_answer'] != 'selection_default_value_dropdown') {
                        foreach ($answersList as $k => $answer_id) {
                            $oAnswer = BeanFactory::getBean('bc_survey_answers', $answer_id);
                            if(empty($oAnswer->id)){
                                $oAnswer->answer_name = $answer_id; // Other answer
                            }
                            if ($oAnswer->answer_type != 'other') {
                            if ($que_detail['is_image_option']) {
                                $html .= ' <li><span class="option_image option_image_indreport"><img src="' . $oAnswer->radio_image . '" style="height:30px;width:30px;"><div class="hover-img"><img src="' . $oAnswer->radio_image . '"></div></span><span style="margin-left: 5px;vertical-align: -webkit-baseline-middle;">' . $oAnswer->answer_name . '</span></li>';
                            } else {
                                $html .= ' <li> ' . $oAnswer->answer_name . '</li>';
                            }
                        }
                        }
                    } else {
                        $html .= ' <li>N/A</li>';
                    }
                    $html .= '</ul></span></span></div>';
                }
                // NPS
                else if ($subDetail['question_type'] == 'netpromoterscore') {
                    // answer detail
                    $npsAnsArray = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10');

                    $oAnswer = BeanFactory::getBean('bc_survey_answers', $subDetail['submitted_answer']);
                    $ans = $oAnswer->answer_name;
                    $html .= '<div class="row answerRow"><span class="span8" style="margin-left:40px;padding-top:10px;padding-bottom:10px;">';
                    $html .= "<div>
                                            <table class='nps_submission_table'>
                                            <tr>";
                    foreach ($npsAnsArray as $answer_nps) {
                        if ($answer_nps < 7) {
                            if ($ans == $answer_nps) {
                                $html .= "<th><div class='score_pannel' style='background-color:#a1cbff;border: 2px solid black  !important;'>" . $answer_nps . "</div></th>";
                            } else {
                                $html .= "<th><div class='score_pannel' style='background-color:#ff5353'>" . $answer_nps . "</div></th>";
                            }
                        } else if ($answer_nps >= 7 && $answer_nps < 9) {
                            if ($ans == $answer_nps) {
                                $html .= "<th><div class='score_pannel' style='background-color:#a1cbff;border: 2px solid black  !important;'>" . $answer_nps . "</div></th>";
                            } else {
                                $html .= "<th><div class='score_pannel' style='background-color:#e9e817'>" . $answer_nps . "</div></th>";
                            }
                        } else if ($answer_nps >= 9 && $answer_nps <= 10) {
                            if ($ans == $answer_nps) {
                                $html .= "<th><div class='score_pannel' style='background-color:#a1cbff;border: 2px solid black  !important;'>" . $answer_nps . "</div></th>";
                            } else {
                                $html .= "<th><div class='score_pannel' style='background-color:#92d51a'>" . $answer_nps . "</div></th>";
                            }
                        }
                    }
                    $html .= "</tr>
                            </table>
                            </div>";
                    $html .= '</span></div>';
                }
                // EMOJIS
                else if ($subDetail['question_type'] == 'emojis') {
                    $emojisImges = array(
                        1 => "<img src='custom/include/images/ext-unsatisfy.png' />",
                        2 => "<img src='custom/include/images/unsatisfy.png'  />",
                        3 => "<img src='custom/include/images/nuteral.png' />",
                        4 => "<img src='custom/include/images/satisfy.png' />",
                        5 => "<img src='custom/include/images/ext-satisfy.png'/>",
                    );
                    $answersList = explode(',', $subDetail['submitted_answer']);
                    $html .= '<div class="row answerRow"><span class="span8"><span><ul style="margin-left:40px;" class="ind-reportr-ul-class">';
                    if (!empty($subDetail['submitted_answer'])) {
                        foreach ($answersList as $k => $answer_id) {
                            $oAnswer = BeanFactory::getBean('bc_survey_answers', $answer_id);

                            $html .= ' <div class="emoji-ans">' . $emojisImges[$oAnswer->answer_sequence] . '' . $oAnswer->name . '</div>';
                        }
                    }else{
                        $html .= 'N/A';
                    }
                    $html .= '</ul></span></span></div>';
                }
                // RATING
                else if ($subDetail['question_type'] == 'rating') {

                    $html .= '<div class="row answerRow"><span class="span8 ans" style="margin-left:40px;padding-top:10px;padding-bottom:10px;">';

                    // answer detail
                    $starCount = !empty($que_detail['maxsize']) ? $que_detail['maxsize'] : 5;
                    for ($i = 0; $i < $starCount; $i++) {
                        if ($i < $subDetail['submitted_answer']) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                        $html .= "<li class='rating {$selected}' style='display: inline;font-size: x-large'>&#9733;</li>";
                    }

                    $html .= '</span></div>';
                }
                // Contact Information
                else if ($subDetail['question_type'] == 'contact-information') {

                    $html .= '<div class="row answerRow"><div class="span8" style="margin-left:40px;padding-top:10px;padding-bottom:10px;">';

                    // answer detail
                    $contact_information = JSON::decode(html_entity_decode($subDetail['submitted_answer']));
                    $haveContactInfo = array();
                    foreach ($contact_information as $val) {
                        if (trim($val) == '') {
                            $haveContactInfo[] = false;
                        } else {
                            $haveContactInfo[] = true;
                        }
                    }
                    if (in_array(true, $haveContactInfo)) {
                    $html .= "<b>Company Name : </b>" . $contact_information['Company'];
                    $html .= "<br/><b>Name : </b>" . $contact_information['Name'];
                    $html .= "<br/><b>Street1 :</b> " . $contact_information['Address'];
                    $html .= "<br/><b>Street2 : </b>" . $contact_information['Address2'] . "<br/>";
                    if ($contact_information['City/Town'] != '') {
                        $html .= $contact_information['City/Town'] . ", ";
                    }
                    if ($contact_information['Zip/Postal Code'] != '') {
                        $html .= $contact_information['Zip/Postal Code'] . ", ";
                    }
                    if ($contact_information['State/Province'] != '') {
                        $html .= $contact_information['State/Province'] . ", ";
                    }
                    if ($contact_information['Country'] != '') {
                        $html .= $contact_information['Country'];
                    }
                    $html .= "<br/><b>Email : </b>" . $contact_information['Email Address'];
                    $html .= "<br/><b>Phone : </b>" . $contact_information['Phone Number'];
                    } else {
                         $html .="N/A";
                    }
                    $html .= '</div></div>';
                }
                // Matrix
                else if ($subDetail['question_type'] == 'matrix') {
                    $html .= '<div class="row answerRow"><div class="span8" style="margin-left:20px;padding-top:10px;padding-bottom:10px;">';

                    // answer detail
                    $matrix_answer_array = explode(',', $subDetail['submitted_answer']);
                    // Initialize counter - count number of rows & columns
                    $row_count = 1;
                    $col_count = 1;
                    $rows = json_decode(base64_decode(($que_detail['matrix_row'])));
                    $cols = json_decode(base64_decode(($que_detail['matrix_col'])));
                    // Do the loop
                    foreach ($rows as $result) {
                        // increment row counter
                        $row_count++;
                    }
                    foreach ($cols as $result) {
                        // increment  column counter
                        $col_count++;
                    }
                    $width = round(70 / ($col_count + 1)) - 1;
                    $width = $width . '%';

                    $matrix_html = '<table style="margin-left: 5px;margin-top: 4px;">';
                    for ($i = 1; $i <= $row_count; $i++) {
                        $matrix_html .= '<tr>';
                        for ($j = 1; $j <= $col_count + 1; $j++) {
                            $row = $i - 1;
                            $col = $j - 1;
                            //First row & first column as blank
                            if ($j == 1 && $i == 1) {
                                $matrix_html .= "<td class='matrix-span' style='width:" . $width . ";text-align:left;border: 1px solid #D4CECE; padding:10px; margin:0px;'>&nbsp;</td>";
                            }
                            // Rows Label
                            else if ($j == 1 && $i != 1) {
                                $matrix_html .= "<td class='matrix-span {$que_id}' value='{$row}' style='font-weight:bold; width:" . $width . ";text-align:left;border: 1px solid #D4CECE;padding:10px; margin:0px;'>" . $rows->$row . "</td>";
                            } else {
                                //Columns label
                                if ($j <= ($col_count + 1) && $cols->$col != null && !($j == 1 && $i == 1) && ($i == 1 || $j == 1)) {
                                    $matrix_html .= "<td class='matrix-span' style='font-weight:bold; width:" . $width . ";border: 1px solid #D4CECE;padding:10px; margin:0px;'>" . $cols->$col . "</td>";
                                }
                                //Display answer input (RadioButton or Checkbox)
                                else if ($j != 1 && $i != 1 && $cols->$col != null) {
                                    $matrix_html .= "<td class='matrix-span' style='width:" . $width . ";border: 1px solid #D4CECE;padding:10px; margin:0px; '>";
                                    $current_value = $row . '_' . $col;
                                    if (in_array($current_value, $matrix_answer_array)) {
                                        $matrix_html .= "<input type='radio' checked disabled>";
                                    } else {
                                        $matrix_html .= "<input type='radio' disabled>";
                                    }
                                    $matrix_html .= "</td>";
                                }
                                // If no value then display none
                                else {
                                    $matrix_html .= "";
                                }
                            }
                        }
                        $matrix_html .= "</tr>";
                    }
                    $matrix_html .= "</table>";
                    $html .= $matrix_html;
                    $html .= '</div></div>';
                }
                // Attachment
                else if ($subDetail['question_type'] == 'doc-attachment') {

                    $answersList = explode('_documentID_', $subDetail['submitted_answer']);
                    $file_name = $answersList[1];
                    $html .= '<div class="row answerRow"><span class="span8" style="margin-left:40px;padding-top:10px;padding-bottom:10px;"><span>';
                    if (!empty($subDetail['submitted_answer'])) {
                        if ($isDocLinkAdded) {
                            $html .= '<span>' . $file_name . '</span>';
                        } else {
                            $html .= '<a onclick=" window.open(&quot;#bwc/index.php?module=Documents&amp;action=DetailView&amp;record=' . $answersList[0] . '&quot;)">' . $file_name . '</a>';
                        }
                    } else {
                        $html .= 'N/A';
                    }
                    $html .= '</span></span></div>';
                    $isDocLinkAdded = true;
                }
                // TextBox, CommentBox, DateTime, Scale
                else {
                    $historyAns = (!empty($subDetail['submitted_answer'])) ? $subDetail['submitted_answer'] : 'N/A';
                    $html .= '<div class="row answerRow"><span class="span8" style="margin-left:40px;padding-top:10px;padding-bottom:10px;"><span>';
                    $html .= nl2br($historyAns);
                    $html .= '</span></span></div>';
                }
            }
            $html .= '  </div>';
            $html .= '</div>';
            return $html;
        } else {
            return $html;
        }
    }

}
