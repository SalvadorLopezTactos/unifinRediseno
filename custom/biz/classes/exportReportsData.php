<?php

if (!defined('sugarEntry') || !sugarEntry)
    define('sugarEntry', true);

require_once('include/entryPoint.php');

global $current_user;
if ($current_user->id == null || $current_user->id == '') {
    $userID = $_REQUEST['userID'];
    $current_user = BeanFactory::getBean('Users', $userID);
}
require_once 'custom/include/utilsfunction.php';
$exportReport = $_REQUEST['export_report'];
$type = $_REQUEST['export_from'];
$exportAs = $_REQUEST['export_as'];
$exportBy = $_REQUEST['export_by'];
$survey_id = $_REQUEST['survey_id'];
$report_type = $_REQUEST['report_type'];
$selectedRange = json_decode(html_entity_decode($_REQUEST['selectedRange']), true);
$gffilterData = json_decode($_REQUEST['JsonGfData'], true);
if (empty($gffilterData)) {
    $gffilterData = json_decode(html_entity_decode($_REQUEST['JsonGfData']), true);
}
$oSurvey = BeanFactory::getBean('bc_survey', $survey_id);
$extensionArr = array(
    'csv' => array('short' => 'csv', 'long' => 'Csv'),
    'pdf' => array('short' => 'pdf', 'long' => 'Pdf'),
);
$currentExtShort = $extensionArr[$exportAs]['short'];
$currentExtlong = $extensionArr[$exportAs]['long'];
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
$surveyObj = new bc_survey();
$surveyObj->retrieve($survey_id);
$filename = str_replace(" ", "_", $surveyObj->name);
$surveyName = $surveyObj->name;
$finalExportData = array();
$returnData = getUserAccessibleRecordsData($survey_id, $type, $gf_filter_by, $global_filter, $GF_saved_question_logic);
if ($currentExtShort == 'pdf') {

    $questionPDFData = json_decode(html_entity_decode($_REQUEST['questionPDFData']), true);
    if ($report_type == 'question' && $exportReport == 'normal') {
        exportQuestionNormalReportDataAsPDF($questionPDFData, $survey_id, $type, $returnData, $surveyName, '', false);
    } elseif ($report_type == 'question' && $exportReport == 'trend') {
        exportQuestionTrendReportDataAsPDF($questionPDFData, $survey_id, $type, $returnData, $selectedRange, $surveyName, '', false);
    }
    if ($report_type == 'status') {
        $finalExportData = getAllQuestionExportData($report_type, $survey_id, $exportReport, $exportBy, $exportAs, $type, $selectedRange, $returnData);
        $statusPieImgData = $_REQUEST['statusPieImgData'];
        $statusLnImgData = $_REQUEST['statusLnImgData'];
        exportStatusReportDataAsPDF($report_type, $exportReport, $statusPieImgData, $statusLnImgData, $oSurvey->name, $finalExportData);
    }
} else {
    $finalExportData = getAllQuestionExportData($report_type, $survey_id, $exportReport, $exportBy, $exportAs, $type, $selectedRange, $returnData);
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
    $del = "\t";
    $content = '';
    if ($report_type == 'question') {
        if ($exportReport == 'normal') {
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
                    if (strstr($str, '"'))
                        $str = '"' . str_replace('"', '""', $str) . '"';
                    $ExportRow[$key] = html_entity_decode($str, ENT_QUOTES);
                            }

                $content .= htmlspecialchars_decode("\"" . implode("\"" . $del . "\"", array_values($ExportRow)), ENT_QUOTES) . "\"\r\n";
                        }
                    } else {
            $i = 0;
            foreach ($finalExportData as $exportData) {
                if ($i == 0) {
                    $exportFields = array_keys($exportData);
                    foreach ($exportFields as $key => $str) {
                        $str = preg_replace("/\t/", "\\t", $str);
                        $str = preg_replace("/&nbsp;/", "", $str);
                        if (strstr($str, '"'))
                            $str = '"' . str_replace('"', '""', $str) . '"';
                        $exportFields[$key] = $str;
                    }
                    $i++;
                    $content .= htmlspecialchars_decode("\"" . implode("\"" . $del . "\"", array_values($exportFields)), ENT_QUOTES) . "\"\r\n";
                }
                $exportFields = array_values($exportData);
                foreach ($exportFields as $key => $str) {
                    $str = preg_replace("/\t/", "\\t", $str);
                    $str = preg_replace("/&nbsp;/", "", $str);
                    if (strstr($str, '"'))
                        $str = '"' . str_replace('"', '""', $str) . '"';
                    $exportFields[$key] = $str;
                }

                $content .= htmlspecialchars_decode("\"" . implode("\"" . $del . "\"", array_values($exportFields)), ENT_QUOTES) . "\"\r\n";
            }
        }
    } else {
        $exportFields = array_keys($finalExportData);
        foreach ($exportFields as $key => $str) {
            $str = preg_replace("/\t/", "\\t", $str);
            $str = preg_replace("/&nbsp;/", "", $str);
            if (strstr($str, '"'))
                $str = '"' . str_replace('"', '""', $str) . '"';
            $exportFields[$key] = $str;
        }

        $content .= htmlspecialchars_decode("\"" . implode("\"" . $del . "\"", array_values($exportFields)), ENT_QUOTES) . "\"\r\n";
        $exportFields = array_values($finalExportData);
        foreach ($exportFields as $key => $str) {
            $str = preg_replace("/\t/", "\\t", $str);
            $str = preg_replace("/&nbsp;/", "", $str);
            if (strstr($str, '"'))
                $str = '"' . str_replace('"', '""', $str) . '"';
            $exportFields[$key] = $str;
        }

        $content .= htmlspecialchars_decode("\"" . implode("\"" . $del . "\"", array_values($exportFields)), ENT_QUOTES) . "\"\r\n";
    }
    echo $content;
    exit;
}
