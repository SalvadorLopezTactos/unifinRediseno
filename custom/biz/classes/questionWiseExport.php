<?php

if (!defined('sugarEntry') || !sugarEntry)
    define('sugarEntry', true);

require_once('include/entryPoint.php');
require_once 'custom/include/utilsfunction.php';
global $current_user;
if ($current_user->id == null || $current_user->id == '') {
    $userID = $_REQUEST['userID'];
    $current_user = BeanFactory::getBean('Users', $userID);
}
$chartImg = $_REQUEST['canvasUrl'];
$que_id = $_REQUEST['que_id'];
$exportAs = $_REQUEST['exportAS'];
$textHtml = $_REQUEST['textHtml'];
$surveyQObj = BeanFactory::getBean('bc_survey_questions', $que_id);
$questionName = $surveyQObj->name;
$qType = $surveyQObj->question_type;
trim($questionName);
if ($exportAs == 'pdf') {
    $textHtml = html_entity_decode($textHtml, ENT_QUOTES);
         generateExportReportInPdf($questionName, $textHtml, $removebaleFile);
} else {
    $fileName = str_replace(' ', '_', $questionName);
    $questionName = $fileName . '.png';
    header('Content-Description: File Transfer');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header("Content-Disposition: attachment;filename={$questionName}");
    header('Content-Type: application/force-download');
    echo base64_decode($chartImg);
    exit;
}




