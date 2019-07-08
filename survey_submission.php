<?php
/**
 * The file used to handle survey submission form 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
if (!defined('sugarEntry') || !sugarEntry)
    define('sugarEntry', true);
include_once('config.php');
require_once('include/entryPoint.php');
require_once('data/SugarBean.php');
require_once('data/BeanFactory.php');
require_once('include/utils.php');
require_once('include/database/DBManager.php');
require_once('include/database/DBManagerFactory.php');
require_once('modules/Administration/Administration.php');
require_once 'modules/Documents/DocumentSoap.php';
require_once 'custom/include/utilsfunction.php';

$themeObject = SugarThemeRegistry::current();
$favicon = $themeObject->getImageURL('sugar_icon.ico', false);

global $sugar_config, $db;

// survey is currently submitted by whom : receipient or sender
if (isset($_REQUEST['submitted_by'])) {
    $submitted_by = $_REQUEST['submitted_by'];
} else {
    $submitted_by = 'receipient';
}

$encoded_param = $_REQUEST['q'];
$decoded_param = base64_decode($encoded_param);


$survey_id = substr($decoded_param, 0, 36);
$module_id = '';
$module_type = '';
$customer_name = '';

// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

// if open URL
if (strlen($_REQUEST['q']) == 6) {
    $isOpenSurveyLink = true;
    $survey = new bc_survey();
    $survey->retrieve_by_string_fields(array('survey_submit_unique_id' => $_REQUEST['q']));
    $survey_id = $survey->id;
    if (!empty($survey_id)) {
        $ip_address = get_client_ip();
        $isNotSubmitted = false;
        $subList = $survey->get_linked_beans('bc_survey_submission_bc_survey', 'bc_survey_submission');
        foreach ($subList as $beanSubmission) {
            if ($beanSubmission->submission_ip_address == $ip_address && $beanSubmission->status != 'Pending' && !$isNotSubmitted) {
                $submission_id = $beanSubmission->id;
                $isAlreadySubmissionEntry = true;
            }
            if ($beanSubmission->submission_ip_address == $ip_address && $beanSubmission->status == 'Pending') {
                $submission_id = $beanSubmission->id;
                $isNotSubmitted = true;
                $isAlreadySubmissionEntry = true;
            }
        }

        // first submission from given ip
        if (!isset($isAlreadySubmissionEntry) || ($survey->allow_redundant_answers == 1)) {
            if (!$isNotSubmitted) {
                $gmtdatetime = TimeDate::getInstance()->nowDb();
                $objSubmission = BeanFactory::getBean('bc_survey_submission');
                $objSubmission->submission_ip_address = $ip_address;
                $objSubmission->submission_type = 'Open Ended';

                $objSubmission->email_opened = 1;
                $objSubmission->survey_send = 1;
                $web_link_updated = $survey->web_link_counter + 1;
                $objSubmission->customer_name = 'Web Link ' . $web_link_updated;
                $objSubmission->name = 'Web Link ' . $web_link_updated;
                $objSubmission->schedule_on = $gmtdatetime;
                $objSubmission->status = 'Pending';
                $objSubmission->recipient_as = 'to';
                $objSubmission->base_score = $survey->base_score;

                $objSubmission->save();

                $objSubmission->load_relationship('bc_survey_submission_bc_survey');
                $objSubmission->bc_survey_submission_bc_survey->add($survey->id);

//                $survey->web_link_counter = $web_link_updated;
//                $survey->save();
                $survey->survey_send_status = 'active';
                $survey->form_seen = 1;
              //  $survey->save();
                $survey->update_web_link_counter($survey_id, $web_link_updated);
                $submission_id = $objSubmission->id;
            }
        }
    }
}
// If email link
else {

    $module_type_array = explode('=', substr($decoded_param, strpos($decoded_param, 'ctype='), 42));
    $module_type_array = explode('&', $module_type_array[1]);
    $module_type = $module_type_array[0];

    $module_id_array = explode('=', substr($decoded_param, strpos($decoded_param, 'cid='), 40));
    $module_id = $module_id_array[1];

    $sub_id_array = explode('=', substr($decoded_param, strpos($decoded_param, 'sub_id='), 43));
    $submission_id = $sub_id_array[1];

    if (empty($submission_id)) {
        if (!empty($_REQUEST['sub_id'])) {
            $submission_id = $_REQUEST['sub_id'];
        }
    }

    $survey = new bc_survey();
    $survey->retrieve($survey_id);
}
$db->query("Update bc_survey set form_seen = '1' where id = '{$survey_id}'");
// Make a code to submit survey open date to Track Survey Spent Time. 
/*if (!isset($_REQUEST['btnsend'])) {
    if ($submission_id == '' || $submission_id == null) {
        $selectSubmission = "SELECT
                                bc_survey_submission.id
                              FROM
                                bc_survey_submission
                              left JOIN
                                bc_survey_submission_bc_survey_c ON bc_survey_submission_bc_survey_c.bc_survey_submission_bc_surveybc_survey_submission_idb = bc_survey_submission.id AND bc_survey_submission.deleted = 0
                              left JOIN
                                bc_survey ON bc_survey.id = bc_survey_submission_bc_survey_c.bc_survey_submission_bc_surveybc_survey_ida AND bc_survey.deleted = 0 AND bc_survey_submission_bc_survey_c.deleted = 0
                              WHERE
                                bc_survey_submission.target_parent_id = '{$module_id}' AND bc_survey.id = '{$survey_id}'";
        $subMissionData = $db->fetchByAssoc($db->query($selectSubmission));
        $sumission_EnrtyID = $subMissionData['id'];
    } else {
        $sumission_EnrtyID = $submission_id;
    }
    $survey_submissiontempObj = BeanFactory::getBean('bc_survey_submission', $sumission_EnrtyID);
    $submissionDate = $survey_submissiontempObj->submission_date;
    $surveyOpenDate = TimeDate::getInstance()->nowDb();
    if ($submissionDate == '') {
        $db->query("update bc_survey_submission set survey_trackdatetime = '{$surveyOpenDate}' where id = '{$sumission_EnrtyID}'");
    }
}*/
if ($isOpenSurveyLink && $survey->allow_redundant_answers == 1) {
    $survey_submission = BeanFactory::getBean('bc_survey_submission', $submission_id);
    $reSubmitCount = (int) $survey_submission->resubmit_counter + 1;
} else {
    $reSubmitCount = (!empty($survey->allowed_resubmit_count)) ? $survey->allowed_resubmit_count : 0;
}


if ($isOpenSurveyLink) {
    $userSbmtCount = 0;
    foreach ($subList as $beanSubmission) {
        if ($beanSubmission->submission_ip_address == $ip_address && $beanSubmission->status == 'Submitted') {
            $userSbmtCount++;
        }
    }
}

// first submission from given ip
//if ($isOpenSurveyLink && $userSbmtCount != 0 && $reSubmitCount > 1 && $userSbmtCount < $reSubmitCount && empty($objSubmission->id)) {
//    if (!$isNotSubmitted) {
//        $gmtdatetime = TimeDate::getInstance()->nowDb();
//        $objSubmission = BeanFactory::getBean('bc_survey_submission');
//        $objSubmission->submission_ip_address = $ip_address;
//        $objSubmission->submission_type = 'Open Ended';
//
//        $objSubmission->email_opened = 1;
//        $objSubmission->survey_send = 1;
//        $web_link_updated = $survey->web_link_counter + 1;
//        $objSubmission->customer_name = 'Web Link ' . $web_link_updated;
//        $objSubmission->schedule_on = $gmtdatetime;
//        $objSubmission->status = 'Pending';
//        $objSubmission->recipient_as = 'to';
//        $objSubmission->base_score = $survey->base_score;
//
//        $objSubmission->save();
//
//        $objSubmission->load_relationship('bc_survey_submission_bc_survey');
//        $objSubmission->bc_survey_submission_bc_survey->add($survey->id);
//
//        $survey->web_link_counter = $web_link_updated;
//        $survey->update_web_link_counter($survey->id, $web_link_updated);
//       // $survey->save();
//        $submission_id = $objSubmission->id;
//    }
//}
$default_survey_language = $survey->default_survey_language;
if (empty($submission_id)) {
    $subList = $survey->get_linked_beans('bc_survey_submission_bc_survey', 'bc_survey_submission');
    foreach ($subList as $beanSubmission) {
        if ($beanSubmission->target_parent_id == $module_id) {
            $survey_submission = BeanFactory::getBean('bc_survey_submission', $submission_id);
        }
    }
} else {
    $survey_submission = BeanFactory::getBean('bc_survey_submission', $submission_id);
}
$submission_language = $survey_submission->submission_language;
// get survey supported language
if (empty($_REQUEST['selected_lang'])) {
    $selected_lang = $default_survey_language;
} else if (isset($_REQUEST['selected_lang']) && !empty($_REQUEST['selected_lang'])) {
    $selected_lang = $_REQUEST['selected_lang'];
} else if (!empty($submission_language)) {
    $selected_lang = $submission_language;
} else {
    $selected_lang = $sugar_config['default_language'];
}

$langValues_array = return_app_list_strings_language($selected_lang);
$langValues = $langValues_array['available_language_dom'];
$supported_lang = unencodeMultienum($survey->supported_survey_language);

foreach ($supported_lang as $key => $slang) {
    $oLang = BeanFactory::getBean('bc_survey_language');
    $oLang->retrieve_by_string_fields(array('bc_survey_id_c' => $survey_id, 'survey_lang' => $slang, 'translated' => 1, 'status' => 'enabled'));
    if (!empty($oLang->id)) {
        $available_lang[$slang] = $langValues[$slang];
    }
}

// list of lang wise survey detail
$list_lang_detail_array = return_app_list_strings_language($selected_lang);
$list_lang_detail = isset($list_lang_detail_array[$survey_id]) ? $list_lang_detail_array[$survey_id] : array();
// redirect url for redirecting user after successfull submission
$redirect_url = $survey->redirect_url;
// if set 1 than show page compelition progressbar
$is_progress_indicator = $survey->is_progress;
// counter of allowed resubmit of response


$survey->load_relationship('bc_survey_pages_bc_survey');
$survey_details = array();
$questions = array();
$skip_logicArrForHideQues = array();
$skip_logicArrForAll = array();
$showHideQuesArrayOnPageload = array();
$msg = '';

// get piping data
$enable_data_piping = $survey->enable_data_piping;
if ($enable_data_piping == 1) {
    $sync_module = $survey->sync_module;
    $sync_type = $survey->sync_type;
}

if (!empty($module_type) && !empty($module_id)) {
    $moduleBeanObj = BeanFactory::getBean($module_type);
    $moduleBeanObj->disable_row_level_security = true;
    $moduleBeanObj->retrieve($module_id);
}

// Static value
    $submission_status = $survey_submission->status;
    $submisstion_id = $survey_submission->id;
    $userSbmtCount = $survey_submission->resubmit_counter;
    $requestApproved = $survey_submission->resubmit;

$user = new User();
$user->retrieve($survey->created_by);

date_default_timezone_set('UTC');

$timedate = new TimeDate();
$date_to_now = date('Y-m-d H:i');
$datetime = new datetime($date_to_now);
$current_date = $date_to_now; //$timedate->asUser($datetime, $user);
//$current_date = gmdate('Y-m-d H:i:s');
$oStart_date = $survey->start_date;
$oEnd_date = $survey->end_date;

// get default time-date format
$format = $sugar_config['default_date_format'] . ' ' . $sugar_config['default_time_format'];
if (!empty($oStart_date)) {

    $sdate = DateTime::createFromFormat($format, $survey->start_date);
    //$survey_start_date = $sdate->format('Y-m-d H:i:s');
    $survey_start_date = $survey->start_date;
} else {
    $survey_start_date = '';
}
if (!empty($oEnd_date)) {
    $edate = DateTime::createFromFormat($format, $survey->end_date);
    //  $survey_end_date = $edate->format('Y-m-d H:i:s');
    $survey_end_date = $survey->end_date;
} else {
    $survey_end_date = '';
}


$startDateTime = TimeDate::getInstance()->to_display_date_time($survey_start_date, true, true, $user);
$endDateTime = TimeDate::getInstance()->to_display_date_time($survey_end_date, true, true, $user);


// end static
// create resubmit request URL with encoded URL
$survey_resubmit_request_url = $sugar_config['site_url'] . '/survey_re_submit_request.php?survey_id=';

$sugar_survey_Url = $survey_resubmit_request_url; //create survey submission url
$encoded_param = base64_encode($survey_id . '&ctype=' . $module_type . '&cid=' . $module_id);
$sugar_survey_Url = str_replace('survey_id=', 'q=', $sugar_survey_Url);
$surveyReQURL = $sugar_survey_Url . $encoded_param . '&selected_lang=' . $selected_lang;

//retrieve module record
$rec_table = strtolower($module_type);
if (!empty($rec_table)) {
    $focus_recivier_qry = "select deleted from $rec_table where id = '{$module_id}'";
    $isdeletedResult = $db->query($focus_recivier_qry);
    $isDeletedRecipient = $db->fetchByAssoc($isdeletedResult);
}
$resubmit_request_msg = '';
if (!$isOpenSurveyLink) {
    $resubmit_request_msg = " <a href='{$surveyReQURL}'>Click here...</a>";
}

$already_sub_msg = "You have already submitted this " . ucfirst($survey->survey_type) . ".";
if (!empty($list_lang_detail) && !empty($list_lang_detail['already_sub_msg'])) {
    $already_sub_msg = $list_lang_detail['already_sub_msg'];
}

if ($isOpenSurveyLink) {
    $already_sub_msg = "" . ucfirst($survey->survey_type) . " has been already submitted from the same location.";
    if (!empty($list_lang_detail) && !empty($list_lang_detail['location_already_sub_msg'])) {
        $already_sub_msg = $list_lang_detail['location_already_sub_msg'];
    }
}
$req_msg = '';
if (!$isOpenSurveyLink) {
    $req_msg = "For request to admin to resubmit your " . ucfirst($survey->survey_type) . "";
    if (!empty($list_lang_detail) && !empty($list_lang_detail['req_msg'])) {
        $req_msg = $list_lang_detail['req_msg'];
    }
}

$survey_notstart_msg = "This " . ucfirst($survey->survey_type) . " has not started yet, Please try after {$startDateTime} ";
if (!empty($list_lang_detail) && !empty($list_lang_detail['survey_notstart_msg'])) {
    $survey_notstart_msg = $list_lang_detail['survey_notstart_msg'];
    $survey_notstart_msg = str_replace('$startDateTime', $startDateTime, $survey_notstart_msg);
}

$survey_exp_msg = "Sorry... This " . ucfirst($survey->survey_type) . " expired on {$endDateTime} ";
if (!empty($list_lang_detail) && !empty($list_lang_detail['survey_exp_msg'])) {
    $survey_exp_msg = $list_lang_detail['survey_exp_msg'];
    $survey_exp_msg = str_replace('$endDateTime', $endDateTime, $survey_exp_msg);
}

$survey_deleted_msg = " Sorry! This " . ucfirst($survey->survey_type) . " has been deactivated by the owner. You can't attend it.";
if (!empty($list_lang_detail) && !empty($list_lang_detail['survey_deleted_msg'])) {
    $survey_deleted_msg = $list_lang_detail['survey_deleted_msg'];
}

$rec_deleted_msg = "  Sorry! This recipient record is deleted by the owner. You can't attend it.";
if (!empty($list_lang_detail) && !empty($list_lang_detail['rec_deleted_msg'])) {
    $rec_deleted_msg = $list_lang_detail['rec_deleted_msg'];
}

// if preview from email template
if (isset($_REQUEST['survey_id']) && $_REQUEST['survey_id'] == 'SURVEY_PARAMS') {
    $msg1 = "<div class='failure_msg'> " . ucfirst($survey->survey_type) . " Preview not available here. Please preview " . ucfirst($survey->survey_type) . " from survey module.</div>";
}
// Survey Status :: LoadedTech Customization
// if survey is disabled
else if ($survey->survey_status == 'Inactive') {
    $msg1 .= "<div class='failure_msg'>Sorry, the survey you are trying to attend is no longer active.</div>";
}
// Survey Status :: LoadedTech Customization END
// if user has already submitted this survey & also not a request is approved for the re submission
elseif (($submission_status == 'Submitted') && !($requestApproved) && ($userSbmtCount >= $reSubmitCount) && ($survey->allow_redundant_answers == 0 || !$isOpenSurveyLink)) {
    $msg1 = "<div class='success_msg'> {$already_sub_msg} {$req_msg} {$resubmit_request_msg}</div>";
}
//  if survey not started yet 
elseif (($submission_status == 'Pending') && !empty($oStart_date) && ((strtotime($current_date) < strtotime($oStart_date)))) {
    $db->query("Update bc_survey set form_seen = '0' where id = '{$survey->id}'");
    $msg1 = "<div class='failure_msg'>$survey_notstart_msg</div>";
}
// if survey is already expired
elseif (($submission_status == 'Pending') && !empty($oEnd_date) && (strtotime($current_date) > strtotime($oEnd_date))) {
    $msg1 = "<div class='failure_msg'>$survey_exp_msg</div>";
}
// if user re submission count is reached then make request to resubmit
elseif (!($requestApproved) && ($userSbmtCount >= $reSubmitCount) && (!$isOpenSurveyLink)) {
    $msg1 = "<div class='success_msg'>$already_sub_msg {$req_msg} {$resubmit_request_msg}</div>";
}
// if user re submission count is reached then make request to resubmit for open ended
elseif (!($requestApproved) && ($userSbmtCount >= $reSubmitCount) && ($survey->allow_redundant_answers == 0 && $isOpenSurveyLink) && ($submission_status == 'Submitted')) {
    $msg1 = "<div class='success_msg'>$already_sub_msg {$req_msg} {$resubmit_request_msg}</div>";
}
// if survey is deactivated / deleted by the sender
elseif (empty($survey->id)) {
    $msg1 .= "<div class='failure_msg'>$survey_deleted_msg</div>";
}
// if survey is deactivated / deleted by the sender
elseif (isset($isDeletedRecipient) && $isDeletedRecipient['deleted'] == 1 || (empty($survey_submission->id) && (!$isOpenSurveyLink))) {
    $msg1 = "<div class='failure_msg'>$rec_deleted_msg</div>";
}
// survey is still not submitted then allow to submit or come for re submission then prefill response data
else {
    // To update Survey Track Date and time get proper Time Spent data.
    if (!isset($_REQUEST['btnsend'])) {
        if ($submission_id == '' || $submission_id == null) {
            $selectSubmission = "SELECT
                                bc_survey_submission.id
                              FROM
                                bc_survey_submission
                              left JOIN
                                bc_survey_submission_bc_survey_c ON bc_survey_submission_bc_survey_c.bc_survey_submission_bc_surveybc_survey_submission_idb = bc_survey_submission.id AND bc_survey_submission.deleted = 0
                              left JOIN
                                bc_survey ON bc_survey.id = bc_survey_submission_bc_survey_c.bc_survey_submission_bc_surveybc_survey_ida AND bc_survey.deleted = 0 AND bc_survey_submission_bc_survey_c.deleted = 0
                              WHERE
                                bc_survey_submission.target_parent_id = '{$module_id}' AND bc_survey.id = '{$survey_id}'";
            $subMissionData = $db->fetchByAssoc($db->query($selectSubmission));
            $sumission_EnrtyID = $subMissionData['id'];
        } else {
            $sumission_EnrtyID = $submission_id;
        }
        $surveyOpenDate = TimeDate::getInstance()->nowDb();
        $db->query("update bc_survey_submission set survey_trackdatetime_temp = '{$surveyOpenDate}' where id = '{$sumission_EnrtyID}'");
    }

    /*
     * Get Already submitted details
     */
    $sbmtSurvData = array();
    if ($survey_submission->status == 'Submitted') {
        $sbmtSurvData = getPerson_SubmissionExportData($survey_id, $module_id, false, $survey_submission->customer_name, $submission_id);
    }

    $deleteAnsIdsOnResubmitArray = array();
    foreach ($sbmtSurvData as $questionId => $ansDetails) {
        if (!is_null($ansDetails['answerId']) && !empty($ansDetails['answerId'])) {
            if (is_array($ansDetails['answerId'])) {
                foreach ($ansDetails['answerId'] as $k => $ansID) {
                    $deleteAnsIdsOnResubmitArray[] = $ansID;
                }
            } else {
                $deleteAnsIdsOnResubmitArray[] = $ansDetails['answerId'];
            }
        }
    }
    $deleteAnsIdsOnResubmit = "'" . implode("','", $deleteAnsIdsOnResubmitArray) . "'";

    $survey_answer_prefill = array();
    $survey_answer_update_module_field_name = array();
    foreach ($survey->bc_survey_pages_bc_survey->getBeans() as $pages) {
        unset($questions);
        $survey_details[$pages->page_sequence]['page_title'] = (!empty($list_lang_detail) && !empty($list_lang_detail[$pages->id])) ? $list_lang_detail[$pages->id] : $pages->name;
        $survey_details[$pages->page_sequence]['page_number'] = $pages->page_number;
        $survey_details[$pages->page_sequence]['page_id'] = $pages->id;
        $pages->load_relationship('bc_survey_pages_bc_survey_questions');
        foreach ($pages->bc_survey_pages_bc_survey_questions->getBeans() as $survey_questions) {
            $questions[$survey_questions->question_sequence]['que_id'] = $survey_questions->id;
            $questions[$survey_questions->question_sequence]['que_title'] = (!empty($list_lang_detail) && !empty($list_lang_detail[$survey_questions->id . '_que_title'])) ? $list_lang_detail[$survey_questions->id . '_que_title'] : $survey_questions->name;
            $questions[$survey_questions->question_sequence]['que_type'] = $survey_questions->question_type;
            if ($survey_questions->question_type == 'richtextareabox') {
                $questions[$survey_questions->question_sequence]['richtextContent'] = $survey_questions->richtextContent;
            }
            $questions[$survey_questions->question_sequence]['is_required'] = $survey_questions->is_required;
            $questions[$survey_questions->question_sequence]['is_question_seperator'] = $survey_questions->is_question_seperator;
            $questions[$survey_questions->question_sequence]['file_size'] = $survey_questions->file_size;
            $questions[$survey_questions->question_sequence]['file_extension'] = $survey_questions->file_extension;
            $questions[$survey_questions->question_sequence]['question_help_comment'] = (!empty($list_lang_detail[$survey_questions->id . '_question_help_comment'])) ? $list_lang_detail[$survey_questions->id . '_question_help_comment'] : $survey_questions->question_help_comment;
            $questions[$survey_questions->question_sequence]['display_boolean_label'] = (!empty($list_lang_detail[$survey_questions->id . '_display_boolean_label'])) ? $list_lang_detail[$survey_questions->id . '_display_boolean_label'] : $survey_questions->display_boolean_label;
            $questions[$survey_questions->question_sequence]['is_image_option'] = $survey_questions->is_image_option;
            $questions[$survey_questions->question_sequence]['show_option_text'] = $survey_questions->show_option_text;

            //advance options
            $questions[$survey_questions->question_sequence]['advance_type'] = (isset($survey_questions->advance_type)) ? $survey_questions->advance_type : '';
            $questions[$survey_questions->question_sequence]['maxsize'] = (isset($survey_questions->maxsize)) ? $survey_questions->maxsize : '';
            $questions[$survey_questions->question_sequence]['min'] = (isset($survey_questions->min)) ? $survey_questions->min : '';
            $questions[$survey_questions->question_sequence]['max'] = (isset($survey_questions->max)) ? $survey_questions->max : '';
            $questions[$survey_questions->question_sequence]['precision'] = (isset($survey_questions->precision_value)) ? $survey_questions->precision_value : '';
            $questions[$survey_questions->question_sequence]['is_datetime'] = (isset($survey_questions->is_datetime) ) ? $survey_questions->is_datetime : '';
            $questions[$survey_questions->question_sequence]['is_sort'] = (isset($survey_questions->is_sort) ) ? $survey_questions->is_sort : '';
            $questions[$survey_questions->question_sequence]['enable_otherOption'] = (isset($survey_questions->enable_otherOption) ) ? $survey_questions->enable_otherOption : '';
            $questions[$survey_questions->question_sequence]['matrix_row'] = (isset($survey_questions->matrix_row)) ? base64_decode($survey_questions->matrix_row) : '';
            $questions[$survey_questions->question_sequence]['matrix_col'] = (isset($survey_questions->matrix_col)) ? base64_decode($survey_questions->matrix_col) : '';
            $questions[$survey_questions->question_sequence]['description'] = (isset($survey_questions->description)) ? $survey_questions->description : '';
            $questions[$survey_questions->question_sequence]['is_skip_logic'] = (isset($survey_questions->is_skip_logic)) ? $survey_questions->is_skip_logic : 0;

            // Retrieve Sync Field
            $sync_field = $survey_questions->sync_field;
            $questions[$survey_questions->question_sequence]['sync_field'] = (isset($survey_questions->sync_field)) ? $survey_questions->sync_field : '';

            // check if sync field is added to question and is not email
            if ($enable_data_piping == 1 && $sync_type != 'create_records' && !empty($sync_field)) {
                $moduleFieldValue = $moduleBeanObj->$sync_field;

                // set prefill data
                $survey_answer_prefill[$survey_questions->id] = (isset($moduleFieldValue)) ? $moduleFieldValue : '';
                // set sync field for question
                $survey_answer_update_module_field_name[$survey_questions->id] = $sync_field;
            } else if ($enable_data_piping == 1 && $sync_type == 'create_records' && !empty($sync_field)) {

                // set prefill data
                $survey_answer_prefill[$survey_questions->id] = '';
                // set sync field for question
                $survey_answer_update_module_field_name[$survey_questions->id] = $sync_field;
            }

            $survey_questions->load_relationship('bc_survey_answers_bc_survey_questions');
            $questions[$survey_questions->question_sequence]['answers'] = array();
            $optionIds = array();
            foreach ($survey_questions->bc_survey_answers_bc_survey_questions->getBeans() as $survey_answers) {
                if ($questions[$survey_questions->question_sequence]['is_required'] && !isset($survey_answers->answer_name)) {
                    continue;
                } else {
                    $questions[$survey_questions->question_sequence]['answers'][$survey_answers->answer_sequence][$survey_answers->id] = (!empty($list_lang_detail) && !empty($list_lang_detail[$survey_answers->id])) ? $list_lang_detail[$survey_answers->id] : $survey_answers->answer_name;
                    if ($survey_answers->logic_action == "show_hide_question") {
                        $showHideQuesArrayOnPageload[$pages->page_sequence][$survey_answers->id] = explode(",", $survey_answers->logic_target);
                        $skip_logicArrForHideQues[$survey_answers->logic_action][$pages->page_sequence][] = explode(",", $survey_answers->logic_target);
                        $skip_logicArrForAll[$survey_answers->id][$survey_answers->logic_action] = explode(",", $survey_answers->logic_target);
                    } else {
                        //$skip_logicArrForHideQues[$survey_answers->logic_action][$pages->page_sequence] = $survey_answers->logic_target;
                        $skip_logicArrForAll[$survey_answers->id][$survey_answers->logic_action] = $survey_answers->logic_target;
                    }
                }
                $optionIds[] = $survey_answers->id;
            }
            ksort($questions[$survey_questions->question_sequence]['answers']);

            // Retrieve Other Submitted answer for current submission
            $submittedData = $survey_submission->get_linked_beans('bc_submission_data_bc_survey_submission', 'bc_submission_data');

            $submitedAndIds = array();
            foreach ($submittedData as $oSubmissionData) {
                $current_submited_id = '';
                // check answer for current question only
                $submittedQueList = $oSubmissionData->get_linked_beans('bc_submission_data_bc_survey_questions', 'bc_survey_questions');
                foreach ($submittedQueList as $subQue) {
                    if ($subQue->id == $survey_questions->id) {
                        $current_submited_id = $oSubmissionData->id;
                    }
                }
                if (!empty($current_submited_id)) {
                    // get related questions submitted
                    $submittedAnsList = $oSubmissionData->get_linked_beans('bc_submission_data_bc_survey_answers', 'bc_survey_answers', array('date_modified'));

                    foreach ($submittedAnsList as $subAns) {

                        if (!in_array($subAns->id, $optionIds) && $subAns->answer_type != 'other') {

                            $questions[$survey_questions->question_sequence]['answer_other'][$subAns->id] = $subAns->answer_name;
                        }
                    }
                }
            }
        }
        ksort($questions);
        $survey_details[$pages->page_sequence]['page_questions'] = $questions;
        ksort($survey_details);
    }
}
/* * Create layout of question and answer for the preview
 * 
 * @param type $answers - options for multi choice
 * @param type $type - question type
 * @param type $que_id - question id of 36 char
 * @param type $is_required - is required or not 
 * @param type $submittedAns - submitted answer to prefill data
 * @param type $maxsize - max size allowed for answer
 * @param type $min - min value for answer
 * @param type $max - max value for answer
 * @param type $precision - precision value for float type
 * @param type $scale_slot - scale slot value for scale type
 * @param type $is_sort - sorting
 * @param type $is_datetime - is datetime selected or not for date-time question
 * @param type $advancetype - advance option for question
 * @param type $que_title - question title
 * @param type $matrix_row - matrix rows detail
 * @param type $matrix_col - matrix cols detail
 * @param type $description - question description
 * @return string
 */

function getMultiselectHTML($skip_logicArrForAll, $queArr = array(), $submittedAns, $survey_theme, $list_lang_detail, $survey_answer_prefillArra = array(), $richtextContent) {
    $ans_detail = json_encode($skip_logicArrForAll);
    $display_boolean_label = (isset($queArr['display_boolean_label'])) ? $queArr['display_boolean_label'] : '';
    $answers = (isset($queArr['answers'])) ? $queArr['answers'] : '';
    $type = (isset($queArr['que_type'])) ? $queArr['que_type'] : '';
    $que_id = (isset($queArr['que_id'])) ? $queArr['que_id'] : '';
    $is_required = (isset($queArr['is_required'])) ? $queArr['is_required'] : '';
    $submittedAnsOther = (isset($queArr['answer_other'])) ? $queArr['answer_other'] : '';
    $maxsize = (isset($queArr['maxsize'])) ? $queArr['maxsize'] : '';
    $min = (isset($queArr['min'])) ? $queArr['min'] : '';
    $max = (isset($queArr['max'])) ? $queArr['max'] : '';
    $precision = (isset($queArr['precision'])) ? $queArr['precision'] : '';
    $scale_slot = (isset($queArr['scale_slot'])) ? $queArr['scale_slot'] : '';
    $is_sort = (isset($queArr['is_sort'])) ? $queArr['is_sort'] : '';
    $enableOtherOption = (isset($queArr['enable_otherOption'])) ? $queArr['enable_otherOption'] : '';
    $is_datetime = (isset($queArr['is_datetime'])) ? $queArr['is_datetime'] : '';
    $advancetype = (isset($queArr['advance_type'])) ? $queArr['advance_type'] : '';
    $que_title = (isset($queArr['que_title'])) ? $queArr['que_title'] : '';
    $matrix_row = (isset($queArr['matrix_row'])) ? $queArr['matrix_row'] : '';
    $matrix_col = (isset($queArr['matrix_col'])) ? $queArr['matrix_col'] : '';
    $description = (isset($queArr['description'])) ? $queArr['description'] : '';
    $is_skipp = (isset($queArr['is_skip_logic'])) ? $queArr['is_skip_logic'] : '';
    $survey_answer_prefill = (isset($survey_answer_prefillArra[$que_id])) ? $survey_answer_prefillArra[$que_id] : '';
    $is_image_option = (isset($queArr['is_image_option'])) ? $queArr['is_image_option'] : '';
    $show_option_text = (isset($queArr['show_option_text'])) ? $queArr['show_option_text'] : '';
    $file_size = $queArr['file_size'];
    $file_extension = $queArr['file_extension'];
    $html = "";
    switch ($type) {
        case 'multiselectlist':
            $placeholder_label_other = '';
            if (!empty($list_lang_detail) && $list_lang_detail[$que_id . '_other_placeholder_label']) {
                $placeholder_label_other = $list_lang_detail[$que_id . '_other_placeholder_label'];
            }
            $html = "<div class='option multiselect-list  two-col' id='{$que_id}_div'>"
                    . "<input type='hidden' name='placeholder_label_other_{$que_id}' value='{$placeholder_label_other}' />";
            if ($is_skipp == 1) {

                $html .= "<select class='form-control multiselect {$que_id}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' multiple='' size='10' name='{$que_id}[]' >";
            } else {
                $html .= "<select class='form-control multiselect {$que_id}' multiple='' size='10' name='{$que_id}[]' onchange='addOtherField(this);'>";
            }

                $other_answer = array();
                foreach ($answers as $ans) {
                    foreach ($ans as $ans_id => $answer) {
                        $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                        if ($oAnswer->answer_type == 'other') {
                            $other_answer[$ans_id] = $answer;
                        } else {
                            $options[$ans_id] = $answer;
                        }
                    }
                }
                asort($options);
                if (!empty($other_answer)) {
                    foreach ($other_answer as $o_k => $o_v) {
                        $options[$o_k] = $o_v;
                    }
                }

            // if sorting
            if ($is_sort == 1) {
                foreach ($options as $ans_id => $answer) {
                    // check if answer is other type of or not
                    $is_other = '';
                    $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                    if ($oAnswer->answer_type == 'other') {
                        $is_other = 'is_other_option';
                        // Make Other as selected as we got Other answer
                        if ((is_array($submittedAns) && strtolower($submittedAns[0]) != 'n/a' && array_key_exists($submittedAns, $options)) || !is_array($submittedAns) && !empty($submittedAns) && !array_key_exists($submittedAns, $options)) {
                            $submittedAns = $ans_id;
                        }
                    }
                    if (is_array($submittedAns) && in_array($ans_id, $submittedAns)) {
                        $html .= "<option value='{$ans_id}' selected='true' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                    } else if (!is_array($submittedAns) && ($ans_id == $submittedAns)) {
                        $html .= "<option value='{$ans_id}' selected='true' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                    } else if (is_array($survey_answer_prefill) && in_array($answer, $survey_answer_prefill)) {
                        $html .= "<option value='{$ans_id}' selected='true' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                    } else if (!is_array($survey_answer_prefill) && ($answer == $survey_answer_prefill)) {
                        $html .= "<option value='{$ans_id}' selected='true' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                    } else {
                        $html .= "<option value='{$ans_id}' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                    }
                    if (!empty($is_other)) {
                        $otherAnswer = true;
                    }
                }
                $html .= "</select>";
                // Retrieve Other answer from answers and submission
                if (is_array($submittedAnsOther) && $otherAnswer == true) {
                    foreach ($submittedAnsOther as $aid => $subAns) {

                        // Other answer
                        $otherAnswerbyUser = $subAns;
                    }
                    $css = '';
                    if ($survey_theme == 'theme0') {
                        $css = 'margin-left:25px;';
                    }
                    $html .= "<input style='margin-top:20px;width:55%;$css' class='form-control {$que_id}_other other_option_input' type='text' name='{$que_id}[]' class='{$que_id}' placeholder='{$placeholder_label_other}' value='{$otherAnswerbyUser}'>";
                }
            }
            // if not sorting
            else {

                foreach ($answers as $ans) {
                    foreach ($ans as $ans_id => $answer) {
                        // check if answer is other type of or not
                        $is_other = '';
                        $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                        if ($oAnswer->answer_type == 'other') {
                            $is_other = 'is_other_option';
                            // Make Other as selected as we got Other answer
                            if ((is_array($submittedAns) && strtolower($submittedAns[0]) != 'n/a' && array_key_exists($submittedAns, $options)) || !is_array($submittedAns) && !empty($submittedAns) && !array_key_exists($submittedAns, $options)) {
                                $submittedAns = $ans_id;
                            }
                        }
                        if (is_array($submittedAns) && in_array($ans_id, $submittedAns)) {
                            $html .= "<option value='{$ans_id}' selected='true' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                        } else if (!is_array($submittedAns) && ($ans_id == $submittedAns)) {
                            $html .= "<option value='{$ans_id}' selected='true' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                        } else if (is_array($survey_answer_prefill) && in_array($answer, $survey_answer_prefill)) {
                            $html .= "<option value='{$ans_id}' selected='true' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                        } else if (!is_array($survey_answer_prefill) && ($answer == $survey_answer_prefill)) {
                            $html .= "<option value='{$ans_id}' selected='true' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                        } else {
                            $html .= "<option value='{$ans_id}' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                        }

                        if (!empty($is_other)) {
                            $otherAnswer = true;
                        }
                    }
                }
                $html .= "</select>";
                // Retrieve Other answer from answers and submission
                if (is_array($submittedAnsOther) && $otherAnswer == true) {
                    foreach ($submittedAnsOther as $aid => $subAns) {

                        // Other answer
                        $otherAnswerbyUser = $subAns;
                    }
                    $css = '';
                    if ($survey_theme == 'theme0') {
                        $css = 'margin-left:25px;';
                    }
                    $html .= "<input style='margin-top:20px;width:55%;$css' class='form-control {$que_id}_other other_option_input' type='text' name='{$que_id}[]' class='{$que_id}' placeholder='{$placeholder_label_other}' value='{$otherAnswerbyUser}'>";
                }
            }

            $html .= "</div>";
            return $html;
            break;
        case 'check-box':
            $placeholder_label_other = '';
            if (!empty($list_lang_detail) && $list_lang_detail[$que_id . '_other_placeholder_label']) {
                $placeholder_label_other = $list_lang_detail[$que_id . '_other_placeholder_label'];
            }
            $html = "<div class='option checkbox-list' id='{$que_id}_div'>"
                    . "<input type='hidden' name='placeholder_label_other_{$que_id}' value='{$placeholder_label_other}' />";
            if ($advancetype == 'Horizontal') {
                //changes for normal horizontal option by kairvi 22/11/2018
                if ($is_image_option) {
                    $html .= '<ul class="horizontal-options is_image_horizontal">';
                } else {
                    $html .= '<ul class="horizontal-options">';
                }
            } else {
                $html .= '<ul>';
            }

                $other_answer = array();
                foreach ($answers as $ans) {
                    foreach ($ans as $ans_id => $answer) {
                        $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                        if ($oAnswer->answer_type == 'other') {
                            $other_answer[$ans_id] = $answer;
                        } else {
                            $options[$ans_id] = $answer;
                        }
                    }
                }
                asort($options);
                if (!empty($other_answer)) {
                    foreach ($other_answer as $o_k => $o_v) {
                        $options[$o_k] = $o_v;
                    }
                }
            // if sorting
            if ($is_sort == 1) {
                // if horizontal
                if ($advancetype == 'Horizontal') {
                    $op = 1;
                    if ($is_image_option) {
                        foreach ($options as $ans_id => $answer) {
                            // check if answer is other type of or not
                            $is_other = '';
                            $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                            if ($oAnswer->answer_type == 'other') {
                                $is_other = 'is_other_option';
                                // Make Other as selected as we got Other answer
                                if ((is_array($submittedAns) && strtolower($submittedAns[0]) != 'n/a' && array_key_exists($submittedAns, $options)) || !is_array($submittedAns) && !empty($submittedAns) && !array_key_exists($submittedAns, $options)) {
                                    $submittedAns = $ans_id;
                                }
                            }
                            $optionText = "<p>" . htmlspecialchars_decode($answer) . "</p>";
                            if (!$show_option_text) {
                                $optionText = '';
                            }
                            if (is_array($submittedAns) && in_array($ans_id, $submittedAns)) {
                                if ($is_skipp == 1) {

                                    $html .= "<li class='md-checkbox' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-check {$is_other}' checked='true'> $optionText <label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= "<li class='md-checkbox' style='display:inline;'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-check {$is_other}' checked='true' onchange='addOtherField(this);'> " . $optionText . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            } else if (!is_array($submittedAns) && ($ans_id == $submittedAns)) {
                                if ($is_skipp == 1) {

                                    $html .= "<li class='md-checkbox' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-check {$is_other}' checked='true'> " . $optionText . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= "<li class='md-checkbox' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-check {$is_other}' checked='true' onchange='addOtherField(this);'> " . $optionText . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            } else {
                                if ($is_skipp == 1) {

                                    $html .= "<li class='md-checkbox' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-check {$is_other}'> " . $optionText . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= "<li class='md-checkbox' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-check {$is_other}' onchange='addOtherField(this);'> " . $optionText . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            }
                            if (!empty($is_other)) {
                                $otherAnswer = true;
                            }
                            $op++;
                        }
                    } else {
                        foreach ($options as $ans_id => $answer) {
                            // check if answer is other type of or not
                            $is_other = '';
                            $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                            if ($oAnswer->answer_type == 'other') {
                                $is_other = 'is_other_option';
                                // Make Other as selected as we got Other answer
                                if ((is_array($submittedAns) && strtolower($submittedAns[0]) != 'n/a' && array_key_exists($submittedAns, $options)) || !is_array($submittedAns) && !empty($submittedAns) && !array_key_exists($submittedAns, $options)) {
                                    $submittedAns = $ans_id;
                                }
                            }
                            if (is_array($submittedAns) && in_array($ans_id, $submittedAns)) {
                                if ($is_skipp == 1) {

                                    $html .= "<li class='md-checkbox' style='display:inline;'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-check {$is_other}' checked='true'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= "<li class='md-checkbox' style='display:inline;'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-check {$is_other}' checked='true' onchange='addOtherField(this);'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            } else if (!is_array($submittedAns) && ($ans_id == $submittedAns)) {
                                if ($is_skipp == 1) {

                                    $html .= "<li class='md-checkbox' style='display:inline;'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-check {$is_other}' checked='true'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= "<li class='md-checkbox' style='display:inline;'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-check {$is_other}' checked='true' onchange='addOtherField(this);'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            } else {
                                if ($is_skipp == 1) {

                                    $html .= "<li class='md-checkbox' style='display:inline;'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-check {$is_other}'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= "<li class='md-checkbox' style='display:inline;'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-check {$is_other}' onchange='addOtherField(this);'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            }
                            if (!empty($is_other)) {
                                $otherAnswer = true;
                            }
                            $op++;
                        }
                        $html .= "</ul>";
                        // Retrieve Other answer from answers and submission
                        if (is_array($submittedAnsOther) && $otherAnswer == true) {
                            foreach ($submittedAnsOther as $aid => $subAns) {

                                // Other answer
                                $otherAnswerbyUser = $subAns;
                            }
                            $css = '';
                            if ($survey_theme == 'theme0') {
                                $css = 'margin-left:25px;';
                            }
                            $html .= "<input style='margin-top:10px;width:55%;$css' class='form-control {$que_id}_other other_option_input' type='text' name='{$que_id}[]' class='{$que_id}' placeholder='{$placeholder_label_other}' value='{$otherAnswerbyUser}'>";
                        }
                    }
                }
                // if vertical
                else {
                    $op = 1;
                    foreach ($options as $ans_id => $answer) {
                        // check if answer is other type of or not
                        $is_other = '';
                        $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                        if ($oAnswer->answer_type == 'other') {
                            $is_other = 'is_other_option';
                            // Make Other as selected as we got Other answer
                            if ((is_array($submittedAns) && strtolower($submittedAns[0]) != 'n/a' && array_key_exists($submittedAns, $options)) || !is_array($submittedAns) && !empty($submittedAns) && !array_key_exists($submittedAns, $options)) {
                                $submittedAns = $ans_id;
                            }
                        }
                        if (is_array($submittedAns) && in_array($ans_id, $submittedAns)) {
                            if ($is_skipp == 1) {

                                $html .= "<li class='md-checkbox'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-check {$is_other}' checked='true'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                            } else {
                                $html .= "<li class='md-checkbox'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-check {$is_other}' checked='true' onchange='addOtherField(this);'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                            }
                        } else if (!is_array($submittedAns) && ($ans_id == $submittedAns)) {
                            if ($is_skipp == 1) {

                                $html .= "<li class='md-checkbox'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-check {$is_other}' checked='true'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                            } else {
                                $html .= "<li class='md-checkbox'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-check {$is_other}' checked='true' onchange='addOtherField(this);'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                            }
                        } else {
                            if ($is_skipp == 1) {

                                $html .= "<li class='md-checkbox'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-check {$is_other}'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                            } else {
                                $html .= "<li class='md-checkbox'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-check {$is_other}' onchange='addOtherField(this);'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                            }
                        }
                        if (!empty($is_other)) {
                            $otherAnswer = true;
                        }
                        $op++;
                    }
                    $html .= "</ul>";
                    // Retrieve Other answer from answers and submission
                    if (is_array($submittedAnsOther) && $otherAnswer) {
                        foreach ($submittedAnsOther as $aid => $subAns) {

                            // Other answer
                            $otherAnswerbyUser = $subAns;
                        }
                        $css = '';
                        if ($survey_theme == 'theme0') {
                            $css = 'margin-left:25px;';
                        }
                        $html .= "<input style='margin-top:10px;width:55%;$css' class='form-control {$que_id}_other other_option_input' type='text' name='{$que_id}[]' class='{$que_id}' placeholder='{$placeholder_label_other}' value='{$otherAnswerbyUser}'>";
                    }
                }
            }
            // if not sorting
            else {
                // if horizontal
                if ($advancetype == 'Horizontal') {
                    $op = 1;
                    if ($is_image_option) {
                        foreach ($answers as $ans) {
                            foreach ($ans as $ans_id => $answer) {
                                // check if answer is other type of or not
                                $is_other = '';
                                $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                                if ($oAnswer->answer_type == 'other') {
                                    $is_other = 'is_other_option';
                                    // Make Other as selected as we got Other answer
                                    if ((is_array($submittedAns) && strtolower($submittedAns[0]) != 'n/a' && array_key_exists($submittedAns, $options)) || !is_array($submittedAns) && !empty($submittedAns) && !array_key_exists($submittedAns, $options)) {
                                        $submittedAns = $ans_id;
                                    }
                                }
                                $optionText = "<p>" . htmlspecialchars_decode($answer) . "</p>";
                                if (!$show_option_text) {
                                    $optionText = '';
                                }
                                if (is_array($submittedAns) && in_array($ans_id, $submittedAns)) {
                                    if ($is_skipp == 1) {

                                        $html .= "<li class='md-checkbox' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-check {$is_other}' checked='true'> " . $optionText . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    } else {
                                        $html .= "<li class='md-checkbox' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-check {$is_other}' checked='true' onchange='addOtherField(this);'> " . $optionText . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    }
                                } else if (!is_array($submittedAns) && ($ans_id == $submittedAns)) {
                                    if ($is_skipp == 1) {

                                        $html .= "<li class='md-checkbox' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail);  ' class='{$que_id} md-check {$is_other}' checked='true'> " . $optionText . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    } else {
                                        $html .= "<li class='md-checkbox' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-check {$is_other}' checked='true' onchange='addOtherField(this);'> " . $optionText . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    }
                                } else {
                                    if ($is_skipp == 1) {

                                        $html .= "<li class='md-checkbox' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}'  onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-check {$is_other}'> " . $optionText . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    } else {
                                        $html .= "<li class='md-checkbox' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-check {$is_other}' onchange='addOtherField(this);'> " . $optionText . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    }
                                }
                                if (!empty($is_other)) {
                                    $otherAnswer = true;
                                }
                                $op++;
                            }
                        }
                    } else {
                        foreach ($answers as $ans) {
                            foreach ($ans as $ans_id => $answer) {
                                // check if answer is other type of or not
                                $is_other = '';
                                $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                                if ($oAnswer->answer_type == 'other') {
                                    $is_other = 'is_other_option';
                                    // Make Other as selected as we got Other answer
                                    if ((is_array($submittedAns) && strtolower($submittedAns[0]) != 'n/a' && array_key_exists($submittedAns, $options)) || !is_array($submittedAns) && !empty($submittedAns) && !array_key_exists($submittedAns, $options)) {
                                        $submittedAns = $ans_id;
                                    }
                                }
                                if (is_array($submittedAns) && in_array($ans_id, $submittedAns)) {
                                    if ($is_skipp == 1) {

                                        $html .= "<li class='md-checkbox' style='display:inline;'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-check {$is_other}' checked='true'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    } else {
                                        $html .= "<li class='md-checkbox' style='display:inline;'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-check {$is_other}' checked='true' onchange='addOtherField(this);'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    }
                                } else if (!is_array($submittedAns) && ($ans_id == $submittedAns)) {
                                    if ($is_skipp == 1) {

                                        $html .= "<li class='md-checkbox' style='display:inline;'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail);  ' class='{$que_id} md-check {$is_other}' checked='true'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    } else {
                                        $html .= "<li class='md-checkbox' style='display:inline;'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-check {$is_other}' checked='true' onchange='addOtherField(this);'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    }
                                } else {
                                    if ($is_skipp == 1) {

                                        $html .= "<li class='md-checkbox' style='display:inline;'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}'  onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-check {$is_other}'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    } else {
                                        $html .= "<li class='md-checkbox' style='display:inline;'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-check {$is_other}' onchange='addOtherField(this);'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    }
                                }
                                if (!empty($is_other)) {
                                    $otherAnswer = true;
                                }
                                $op++;
                            }
                        }
                    }
                    $html .= "</ul>";

                    // Retrieve Other answer from answers and submission
                    if (is_array($submittedAnsOther) && $otherAnswer) {
                        foreach ($submittedAnsOther as $aid => $subAns) {

                            // Other answer
                            $otherAnswerbyUser = $subAns;
                        }
                        $css = '';
                        if ($survey_theme == 'theme0') {
                            $css = 'margin-left:25px;';
                        }
                        $html .= "<input style='margin-top:10px;width:55%;$css' class='form-control {$que_id}_other other_option_input' type='text' name='{$que_id}[]' class='{$que_id}' placeholder='{$placeholder_label_other}' value='{$otherAnswerbyUser}'>";
                    }
                }
                // if vertical
                else {
                    $op = 1;
                    foreach ($answers as $ans) {
                        foreach ($ans as $ans_id => $answer) {
                            // check if answer is other type of or not
                            $is_other = '';
                            $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                            if ($oAnswer->answer_type == 'other') {
                                $is_other = 'is_other_option';
                                // Make Other as selected as we got Other answer
                                if ((is_array($submittedAns) && strtolower($submittedAns[0] && array_key_exists($submittedAns, $options)) != 'n/a' && array_key_exists($submittedAns, $options)) || !is_array($submittedAns) && !empty($submittedAns) && !array_key_exists($submittedAns, $options)) {
                                    $submittedAns = $ans_id;
                                }
                            }
                            if (is_array($submittedAns) && in_array($ans_id, $submittedAns)) {
                                if ($is_skipp == 1) {

                                    $html .= "<li class='md-checkbox'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}'  onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-check {$is_other}' checked='true'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= "<li class='md-checkbox'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-check {$is_other}' checked='true' onchange='addOtherField(this);'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            } else if (!is_array($submittedAns) && ($ans_id == $submittedAns)) {
                                if ($is_skipp == 1) {

                                    $html .= "<li class='md-checkbox'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-check {$is_other}' checked='true'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= "<li class='md-checkbox'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-check {$is_other}' checked='true' onchange='addOtherField(this);'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            } else {
                                if ($is_skipp == 1) {

                                    $html .= "<li class='md-checkbox'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-check {$is_other}'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= "<li class='md-checkbox'><label><input type='checkbox' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-check {$is_other}' onchange='addOtherField(this);'> " . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            }
                            if (!empty($is_other)) {
                                $otherAnswer = true;
                            }
                            $op++;
                        }
                    }
                    $html .= "</ul>";
                    // Retrieve Other answer from answers and submission
                    if (is_array($submittedAnsOther) && $otherAnswer) {
                        foreach ($submittedAnsOther as $aid => $subAns) {

                            // Other answer
                            $otherAnswerbyUser = $subAns;
                        }
                        $css = '';
                        if ($survey_theme == 'theme0') {
                            $css = 'margin-left:25px;';
                        }
                        $html .= "<input style='margin-top:10px;width:55%;$css' class='form-control {$que_id}_other other_option_input' type='text' name='{$que_id}[]' class='{$que_id}' placeholder='{$placeholder_label_other}' value='{$otherAnswerbyUser}'>";
                    }
                }
            }
            $html .= "</div>";
            return $html;
            break;
        case 'boolean':
            $newAnsArray = array();
            foreach ($answers as $key => $ansDetails) {
                foreach ($ansDetails as $ansID => $ansVal) {
                    $newAnsArray[$ansVal] = $ansID;
                    $newSubAnsArray[$ansID] = $ansVal;
                }
            }
            $checked = '';
            if (!empty($submittedAns) && $submittedAns != 'Yes' && $submittedAns != 'No') {
                $submittedAns = $newSubAnsArray[$submittedAns];
            }
            switch ($submittedAns) {
                case '':
                    $falseAnsID = $newAnsArray['No'];
                    $trueAnsID = $newAnsArray['Yes'];
                    break;
                case 'Yes':
                    $trueAnsID = $newAnsArray['Yes'];
                    $falseAnsID = $newAnsArray['No'];
                    $checked = 'checked';
                    break;
                case 'No':
                    $falseAnsID = $newAnsArray['No'];
                    $trueAnsID = $newAnsArray['Yes'];
                    break;
                default:
                    break;
            }
            $html = "<div class='option boolean-list' id='{$que_id}_div'>";
            $html .= '<ul>';
            if ($is_skipp == 1) {
                $html .= "<li class='md-checkbox' style='display:inline;'>
                          <label><input type='checkbox' id='{$que_id}' name='{$que_id}[]' class='{$que_id}' value='{$trueAnsID}'  onchange='addOtherField(this); changeBoolCheckBoxVal(this); skipp_logic_question(this,$ans_detail); ' {$checked}> 
                             <label for='{$que_id}'>
                                <span></span>
                                <span class='check'></span>
                                <span class='box'></span>
                                <p style=''>{$display_boolean_label}</p>
                                </label>
                            </label>
                          </li>";
            } else {
                $html .= "<li class='md-checkbox' style='display:inline;'><label><input type='checkbox' id='{$que_id}' name='{$que_id}[]' class='{$que_id}' value='{$trueAnsID}'  onchange='addOtherField(this); changeBoolCheckBoxVal(this);' {$checked}>
                           <label for='{$que_id}'>
                                <span></span>
                                <span class='check'></span>
                                <span class='box'></span>
                                <p style=''>{$display_boolean_label}</p>
                                </label>
                                </label></li>";
            }
            if ($checked == 'checked') {
                $html .= "</ui><input type='hidden' class='hidden_bool_false' value='' false-ans-id='{$falseAnsID}' id='{$que_id}_hidden' name='{$que_id}[]' class='{$que_id}_hidden'></div>";
            } else {
                $html .= "</ui><input type='hidden' class='hidden_bool_false' value='{$falseAnsID}'  id='{$que_id}_hidden' name='{$que_id}[]' class='{$que_id}_hidden'></div>";
            }
            return $html;
            break;
        case 'radio-button':
            $placeholder_label_other = '';
            if (!empty($list_lang_detail) && $list_lang_detail[$que_id . '_other_placeholder_label']) {
                $placeholder_label_other = $list_lang_detail[$que_id . '_other_placeholder_label'];
            }
            $html = "<div class='option radio-list' id='{$que_id}_div'>"
                    . "<input type='hidden' name='placeholder_label_other_{$que_id}' value='{$placeholder_label_other}' />";
            if ($advancetype == 'Horizontal') {
                //changes for normal horizontal option by kairvi 22/11/2018
                if ($is_image_option) {
                    $html .= '<ul class="horizontal-options is_image_horizontal">';
                } else {
                    $html .= '<ul class="horizontal-options">';
                }
            } else {
                $html .= '<ul>';
            }

                $other_answer = array();
                foreach ($answers as $ans) {
                    foreach ($ans as $ans_id => $answer) {
                        $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                        if ($oAnswer->answer_type == 'other') {
                            $other_answer[$ans_id] = $answer;
                        } else {
                            $options[$ans_id] = $answer;
                        }
                    }
                }
                asort($options);
                if (!empty($other_answer)) {
                    foreach ($other_answer as $o_k => $o_v) {
                        $options[$o_k] = $o_v;
                    }
                }
            // if sorting
            if ($is_sort == 1) {

                // if horizontal
                if ($advancetype == 'Horizontal') {
                    $op = 1;
                    if ($is_image_option) {
                        foreach ($options as $ans_id => $answer) {
                            // check if answer is other type of or not
                            $is_other = '';
                            $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);

                            if ($oAnswer->answer_type == 'other') {
                                $is_other = 'is_other_option';
                                // Make Other as selected as we got Other answer
                                if ((is_array($submittedAns) && strtolower($submittedAns[0]) != 'n/a') || !is_array($submittedAns) && !empty($submittedAns) && strtolower($submittedAns) != 'n/a' && !array_key_exists($submittedAns, $options)) {
                                    $submittedAns = $ans_id;
                                }
                            }
                            $optionText = "<p>" . htmlspecialchars_decode($answer) . "</p>";
                            if (!$show_option_text) {
                                $answer = '';
                                $optionText = '';
                            }
                            if (is_array($submittedAns) && in_array($ans_id, $submittedAns)) {
                                if ($is_skipp == 1) {

                                    $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}' checked='true'>$optionText<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>$optionText<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            } else if (!is_array($submittedAns) && ($ans_id == $submittedAns)) {
                                if ($is_skipp == 1) {

                                    $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}' checked='true'>$optionText<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>$optionText<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            } else if (is_array($survey_answer_prefill) && in_array($answer, $survey_answer_prefill)) {
                                if ($is_skipp == 1) {

                                    $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}' checked='true'>$optionText<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>$optionText<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            } else if (!is_array($survey_answer_prefill) && ($answer == $survey_answer_prefill)) {
                                if ($is_skipp == 1) {

                                    $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}' checked='true'>$optionText<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>$optionText<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            } else {
                                if ($is_skipp == 1) {

                                    $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}'>$optionText<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' onchange='addOtherField(this);'>$optionText<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            }
                            if (!empty($is_other)) {
                                $otherAnswer = true;
                            }
                            $op++;
                        }
                    } else {
                        foreach ($options as $ans_id => $answer) {
                            // check if answer is other type of or not
                            $is_other = '';
                            $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                            if ($oAnswer->answer_type == 'other') {
                                $is_other = 'is_other_option';
                                // Make Other as selected as we got Other answer
                                if ((is_array($submittedAns) && strtolower($submittedAns[0]) != 'n/a') || !is_array($submittedAns) && !empty($submittedAns) && strtolower($submittedAns) != 'n/a' && !array_key_exists($submittedAns, $options)) {
                                    $submittedAns = $ans_id;
                                }
                            }
                            if (is_array($submittedAns) && in_array($ans_id, $submittedAns)) {
                                if ($is_skipp == 1) {

                                    $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}' checked='true'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            } else if (!is_array($submittedAns) && ($ans_id == $submittedAns)) {
                                if ($is_skipp == 1) {

                                    $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}' checked='true'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            } else if (is_array($survey_answer_prefill) && in_array($answer, $survey_answer_prefill)) {
                                if ($is_skipp == 1) {

                                    $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}' checked='true'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            } else if (!is_array($survey_answer_prefill) && ($answer == $survey_answer_prefill)) {
                                if ($is_skipp == 1) {

                                    $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}' checked='true'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            } else {
                                if ($is_skipp == 1) {

                                    $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            }
                            if (!empty($is_other)) {
                                $otherAnswer = true;
                            }
                            $op++;
                        }
                    }
                    $html .= "</ul>";
                    // Retrieve Other answer from answers and submission
                    if (is_array($submittedAnsOther) && $otherAnswer) {
                        foreach ($submittedAnsOther as $aid => $subAns) {

                            // Other answer
                            $otherAnswerbyUser = $subAns;
                        }
                        $css = '';
                        if ($survey_theme == 'theme0') {
                            $css = 'margin-left:25px;';
                        }
                        $html .= "<input style='margin-top:10px;width:55%;$css' class='form-control {$que_id}_other other_option_input' type='text' name='{$que_id}[]' class='{$que_id}' placeholder='{$placeholder_label_other}' value='{$otherAnswerbyUser}'>";
                    }
                }
                // if vertical
                else {
                    $op = 1;
                    foreach ($options as $ans_id => $answer) {
                        // check if answer is other type of or not
                        $is_other = '';
                        $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                        if ($oAnswer->answer_type == 'other') {
                            $is_other = 'is_other_option';
                            // Make Other as selected as we got Other answer
                            if ((is_array($submittedAns) && strtolower($submittedAns[0]) != 'n/a') || !is_array($submittedAns) && !empty($submittedAns) && strtolower($submittedAns) != 'n/a' && !array_key_exists($submittedAns, $options)) {
                                $submittedAns = $ans_id;
                            }
                        }
                        if (is_array($submittedAns) && in_array($ans_id, $submittedAns)) {
                            if ($is_skipp == 1) {

                                $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail);' class='{$que_id} md-radiobtn {$is_other}' checked='true'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                            } else {
                                $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                            }
                        } else if (!is_array($submittedAns) && ($ans_id == $submittedAns)) {
                            if ($is_skipp == 1) {

                                $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}' checked='true'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                            } else {
                                $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                            }
                        } else if (is_array($survey_answer_prefill) && in_array($answer, $survey_answer_prefill)) {
                            if ($is_skipp == 1) {

                                $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail);' class='{$que_id} md-radiobtn {$is_other}' checked='true'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                            } else {
                                $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                            }
                        } else if (!is_array($survey_answer_prefill) && ($answer == $survey_answer_prefill)) {
                            if ($is_skipp == 1) {

                                $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}' checked='true'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                            } else {
                                $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                            }
                        } else {
                            if ($is_skipp == 1) {

                                $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                            } else {
                                $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                            }
                        }
                        if (!empty($is_other)) {
                            $otherAnswer = true;
                        }
                        $op++;
                    }
                    $html .= "</ul>";
                    // Retrieve Other answer from answers and submission
                    if (is_array($submittedAnsOther) && $otherAnswer) {
                        foreach ($submittedAnsOther as $aid => $subAns) {
                            // Other answer
                            $otherAnswerbyUser = $subAns;
                        }
                        $css = '';
                        if ($survey_theme == 'theme0') {
                            $css = 'margin-left:25px;';
                        }
                        $html .= "<input style='margin-top:10px;width:55%;$css' class='form-control {$que_id}_other other_option_input' type='text' name='{$que_id}[]' class='{$que_id}' placeholder='{$placeholder_label_other}' value='{$otherAnswerbyUser}'>";
                    }
                }
            }
            // if not sorting
            else {
                // if horizontal
                if ($advancetype == 'Horizontal') {
                    $op = 1;
                    if ($is_image_option) {
                        foreach ($answers as $ans) {
                            foreach ($ans as $ans_id => $answer) {
                                // check if answer is other type of or not
                                $is_other = '';
                                $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                                if ($oAnswer->answer_type == 'other') {
                                    $is_other = 'is_other_option';
                                    // Make Other as selected as we got Other answer
                                    if ((is_array($submittedAns) && strtolower($submittedAns[0]) != 'n/a') || !is_array($submittedAns) && !empty($submittedAns) && strtolower($submittedAns) != 'n/a' && !array_key_exists($submittedAns, $options)) {
                                        $submittedAns = $ans_id;
                                    }
                                }
                                $optionText = "<p>" . htmlspecialchars_decode($answer) . "</p>";
                                if (!$show_option_text) {
                                    $optionText = '';
                                }
                                if (is_array($submittedAns) && in_array($ans_id, $submittedAns)) {
                                    if ($is_skipp == 1) {

                                        $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' name='{$que_id}[]' class='{$que_id} md-radiobtn {$is_other}' checked='true'>$optionText<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    } else {
                                        $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' name='{$que_id}[]' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>$optionText<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    }
                                } else if (!is_array($submittedAns) && ($ans_id == $submittedAns)) {
                                    if ($is_skipp == 1) {

                                        $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' name='{$que_id}[]' class='{$que_id} md-radiobtn {$is_other}' checked='true'>$optionText<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    } else {
                                        $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' name='{$que_id}[]' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>$optionText<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    }
                                } else if (is_array($survey_answer_prefill) && in_array($answer, $survey_answer_prefill)) {
                                    if ($is_skipp == 1) {

                                        $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' name='{$que_id}[]' class='{$que_id} md-radiobtn {$is_other}' checked='true'>$optionText<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    } else {
                                        $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' name='{$que_id}[]' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>$optionText<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    }
                                } else if (!is_array($survey_answer_prefill) && ($answer == $survey_answer_prefill)) {
                                    if ($is_skipp == 1) {

                                        $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' name='{$que_id}[]' class='{$que_id} md-radiobtn {$is_other}' checked='true'>$optionText<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    } else {
                                        $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' name='{$que_id}[]' class='{$que_id} md-radiobtn {$is_other}' onchange='addOtherField(this);'>$optionText<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    }
                                } else {
                                    if ($is_skipp == 1) {

                                        $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' name='{$que_id}[]' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}'>$optionText<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    } else {
                                        $html .= " <li class='md-radio' style='display:inline;'><label><img src='" . $oAnswer->radio_image . "'><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' name='{$que_id}[]' class='{$que_id} md-radiobtn {$is_other}' onchange='addOtherField(this);'>$optionText<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    }
                                }
                                if (!empty($is_other)) {
                                    $otherAnswer = true;
                                }
                                $op++;
                            }
                        }
                    } else {
                        foreach ($answers as $ans) {
                            foreach ($ans as $ans_id => $answer) {
                                // check if answer is other type of or not
                                $is_other = '';
                                $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                                if ($oAnswer->answer_type == 'other') {
                                    $is_other = 'is_other_option';
                                    // Make Other as selected as we got Other answer
                                    if ((is_array($submittedAns) && strtolower($submittedAns[0]) != 'n/a') || !is_array($submittedAns) && !empty($submittedAns) && strtolower($submittedAns) != 'n/a' && !array_key_exists($submittedAns, $options)) {
                                        $submittedAns = $ans_id;
                                    }
                                }
                                if (is_array($submittedAns) && in_array($ans_id, $submittedAns)) {
                                    if ($is_skipp == 1) {

                                        $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' name='{$que_id}[]' class='{$que_id} md-radiobtn {$is_other}' checked='true'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    } else {
                                        $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' name='{$que_id}[]' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    }
                                } else if (!is_array($submittedAns) && ($ans_id == $submittedAns)) {
                                    if ($is_skipp == 1) {

                                        $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' name='{$que_id}[]' class='{$que_id} md-radiobtn {$is_other}' checked='true'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    } else {
                                        $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' name='{$que_id}[]' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    }
                                } else if (is_array($survey_answer_prefill) && in_array($answer, $survey_answer_prefill)) {
                                    if ($is_skipp == 1) {

                                        $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' name='{$que_id}[]' class='{$que_id} md-radiobtn {$is_other}' checked='true'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    } else {
                                        $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' name='{$que_id}[]' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    }
                                } else if (!is_array($survey_answer_prefill) && ($answer == $survey_answer_prefill)) {
                                    if ($is_skipp == 1) {

                                        $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' name='{$que_id}[]' class='{$que_id} md-radiobtn {$is_other}' checked='true'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    } else {
                                        $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' name='{$que_id}[]' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    }
                                } else {
                                    if ($is_skipp == 1) {

                                        $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' name='{$que_id}[]' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    } else {
                                        $html .= " <li class='md-radio' style='display:inline;'><label><input type='radio' value='{$ans_id}' id='{$que_id}_{$op}' name='{$que_id}[]' class='{$que_id} md-radiobtn {$is_other}' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                    }
                                }
                                if (!empty($is_other)) {
                                    $otherAnswer = true;
                                }
                                $op++;
                            }
                        }
                    }
                    $html .= "</ul>";
                    // Retrieve Other answer from answers and submission
                    if (is_array($submittedAnsOther) && $otherAnswer) {
                        foreach ($submittedAnsOther as $aid => $subAns) {

                            // Other answer
                            $otherAnswerbyUser = $subAns;
                        }
                        $css = '';
                        if ($survey_theme == 'theme0') {
                            $css = 'margin-left:25px;';
                        }
                        $html .= "<input style='margin-top:10px;width:55%;$css' class='form-control {$que_id}_other other_option_input' type='text' name='{$que_id}[]' class='{$que_id}' placeholder='{$placeholder_label_other}' value='{$otherAnswerbyUser}'>";
                    }
                }
                // if vertical
                else {
                    $op = 1;
                    foreach ($answers as $ans) {
                        foreach ($ans as $ans_id => $answer) {
                            // check if answer is other type of or not
                            $is_other = '';
                            $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                            if ($oAnswer->answer_type == 'other') {
                                $is_other = 'is_other_option';
                                // Make Other as selected as we got Other answer
                                if ((is_array($submittedAns) && strtolower($submittedAns[0]) != 'n/a' ) || !is_array($submittedAns) && !empty($submittedAns) && strtolower($submittedAns) != 'n/a' && !array_key_exists($submittedAns, $options)) {
                                    $submittedAns = $ans_id;
                                }
                            }
                            if (is_array($submittedAns) && in_array($ans_id, $submittedAns)) {
                                if ($is_skipp == 1) {

                                    $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}' checked='true'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            } else if (!is_array($submittedAns) && ($ans_id == $submittedAns)) {
                                if ($is_skipp == 1) {

                                    $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}' checked='true'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            } else if (is_array($survey_answer_prefill) && in_array($answer, $survey_answer_prefill)) {
                                if ($is_skipp == 1) {

                                    $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}' checked='true'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            } else if (!is_array($survey_answer_prefill) && ($answer == $survey_answer_prefill)) {
                                if ($is_skipp == 1) {

                                    $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}' checked='true'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' checked='true' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            } else {
                                if ($is_skipp == 1) {

                                    $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail); ' class='{$que_id} md-radiobtn {$is_other}'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                } else {
                                    $html .= " <li class='md-radio'><label><input type='radio' value='{$ans_id}' name='{$que_id}[]' id='{$que_id}_{$op}' class='{$que_id} md-radiobtn {$is_other}' onchange='addOtherField(this);'>" . htmlspecialchars_decode($answer) . "<label for='{$que_id}_{$op}'>
                                    <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                }
                            }
                            if (!empty($is_other)) {
                                $otherAnswer = true;
                            }
                            $op++;
                        }
                    }
                    $html .= "</ul>";
                    // Retrieve Other answer from answers and submission
                    if (is_array($submittedAnsOther) && $otherAnswer) {
                        foreach ($submittedAnsOther as $aid => $subAns) {

                            // Other answer
                            $otherAnswerbyUser = $subAns;
                        }
                        $css = '';
                        if ($survey_theme == 'theme0') {
                            $css = 'margin-left:25px;';
                        }
                        $html .= "<input style='margin-top:10px;width:55%;$css' class='form-control {$que_id}_other other_option_input' type='text' name='{$que_id}[]' class='{$que_id}' placeholder='{$placeholder_label_other}' value='{$otherAnswerbyUser}'>";
                    }
                }
            }
            $html .= "</div>";
            return $html;
            break;
        case 'dropdownlist':
            $placeholder_label_other = '';
            if (!empty($list_lang_detail) && $list_lang_detail[$que_id . '_other_placeholder_label']) {
                $placeholder_label_other = $list_lang_detail[$que_id . '_other_placeholder_label'];
            }
            $html = "<div class='option select-list two-col' id='{$que_id}_div'>"
                    . "<input type='hidden' name='placeholder_label_other_{$que_id}' value='{$placeholder_label_other}' /><ul><li><div class='styled-select'>";
            if ($is_skipp == 1) {

                $html .= "<select name='{$que_id}[]' class='form-control required {$que_id}' onchange='addOtherField(this); skipp_logic_question(this,$ans_detail);'><option selected='' value='selection_default_value_dropdown'>Select</option>";
            } else {
                $html .= "<select name='{$que_id}[]' class='form-control required {$que_id}' onchange='addOtherField(this);'><option selected='' value='selection_default_value_dropdown'>Select</option>";
            }

                $other_answer = array();
                foreach ($answers as $ans) {
                    foreach ($ans as $ans_id => $answer) {
                        $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                        if ($oAnswer->answer_type == 'other') {
                            $other_answer[$ans_id] = $answer;
                        } else {
                            $options[$ans_id] = $answer;
                        }
                    }
                }
                asort($options);
                if (!empty($other_answer)) {
                    foreach ($other_answer as $o_k => $o_v) {
                        $options[$o_k] = $o_v;
                    }
                }

            // if sorting
            if ($is_sort == 1) {


                foreach ($options as $ans_id => $answer) {
                    // check if answer is other type of or not
                    $is_other = '';
                    $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                    if ($oAnswer->answer_type == 'other') {
                        $is_other = 'is_other_option';
                        // Make Other as selected as we got Other answer
                        if ((is_array($submittedAns) && strtolower($submittedAns[0]) != 'n/a') || !is_array($submittedAns) && !empty($submittedAns) && strtolower($submittedAns) != 'n/a' && !array_key_exists($submittedAns, $options)) {
                            $submittedAns = $ans_id;
                        }
                    }
                    if (is_array($submittedAns) && in_array($ans_id, $submittedAns)) {
                        $html .= "<option value='{$ans_id}' selected='true' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                    } else if (!is_array($submittedAns) && ($ans_id == $submittedAns)) {
                        $html .= "<option value='{$ans_id}' selected='true' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                    } else if (is_array($survey_answer_prefill) && in_array($answer, $survey_answer_prefill)) {
                        $html .= "<option value='{$ans_id}' selected='true' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                    } else if (!is_array($survey_answer_prefill) && ($answer == $survey_answer_prefill)) {
                        $html .= "<option value='{$ans_id}' selected='true' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                    } else {
                        $html .= "<option value='{$ans_id}' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                    }
                    if (!empty($is_other)) {
                        $otherAnswer = true;
                    }
                }
                $html .= "</select></div></li></ul>";
                // Retrieve Other answer from answers and submission
                if (is_array($submittedAnsOther) && $otherAnswer) {
                    foreach ($submittedAnsOther as $aid => $subAns) {

                        // Other answer
                        $otherAnswerbyUser = $subAns;
                    }
                    $css = '';
                    if ($survey_theme == 'theme0') {
                        $css = 'margin-left:25px;';
                    }
                    $html .= "<input style='margin-top:10px;width:55%;$css' class='form-control {$que_id}_other other_option_input' type='text' name='{$que_id}[]' class='{$que_id}' placeholder='{$placeholder_label_other}' value='{$otherAnswerbyUser}'>";
                }
            }
            // if not sorting
            else {
                foreach ($answers as $ans) {
                    foreach ($ans as $ans_id => $answer) {
                        // check if answer is other type of or not
                        $is_other = '';
                        $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                        if ($oAnswer->answer_type == 'other') {
                            $is_other = 'is_other_option';
                            // Make Other as selected as we got Other answer
                            if ((is_array($submittedAns) && strtolower($submittedAns[0]) != 'n/a') || !is_array($submittedAns) && !empty($submittedAns) && strtolower($submittedAns) != 'n/a' && !array_key_exists($submittedAns, $options)) {
                                $submittedAns = $ans_id;
                            }
                        }
                        if (is_array($submittedAns) && in_array($ans_id, $submittedAns)) {
                            $html .= "<option value='{$ans_id}' selected='true' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                        } else if (!is_array($submittedAns) && ($ans_id == $submittedAns)) {
                            $html .= "<option value='{$ans_id}' selected='true' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                        } else if (is_array($survey_answer_prefill) && in_array($answer, $survey_answer_prefill)) {
                            $html .= "<option value='{$ans_id}' selected='true' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                        } else if (!is_array($survey_answer_prefill) && ($answer == $survey_answer_prefill)) {
                            $html .= "<option value='{$ans_id}' selected='true' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                        } else {
                            $html .= "<option value='{$ans_id}' class='{$is_other}'>" . htmlspecialchars_decode($answer) . "</option>";
                        }
                        if (!empty($is_other) && $ans_id == $submittedAns) {
                            $otherAnswer = true;
                        }
                    }
                }
                $html .= "</select></div></li></ul>";
                // Retrieve Other answer from answers and submission
                if (is_array($submittedAnsOther) && $otherAnswer) {
                    foreach ($submittedAnsOther as $aid => $subAns) {

                        // Other answer
                        $otherAnswerbyUser = $subAns;
                    }
                    $css = '';
                    if ($survey_theme == 'theme0') {
                        $css = 'margin-left:25px;';
                    }
                    $html .= "<input style='margin-top:10px;width:55%;$css' class='form-control {$que_id}_other other_option_input' type='text' name='{$que_id}[]' class='{$que_id}' placeholder='{$placeholder_label_other}' value='{$otherAnswerbyUser}'>";
                }
            }

            $html .= "</div>";
            return $html;
            break;
        case 'textbox':
            $html = "<div class='option select-list two-col' id='{$que_id}_div'><ul><li>";
            // if interger then add class to validate with prefill submitted answer
            if (!is_array($submittedAns) && !empty($submittedAns) && $advancetype == 'Integer') {
                $html .= "<input class='form-control {$que_id} numericField' type='text' name='{$que_id}[]' value='{$submittedAns}' class='{$que_id}'>";
            }
            // if float then add class to validate with prefill submitted answer
            else if (!is_array($submittedAns) && !empty($submittedAns) && $advancetype == 'Float') {
                $html .= "<input class='form-control {$que_id} decimalField' type='text' name='{$que_id}[]' value='{$submittedAns}' class='{$que_id}'>";
            }
            // if float then add class to validate with prefill submitted answer
            else if (!is_array($submittedAns) && !empty($submittedAns)) {
                $html .= "<input class='form-control {$que_id} ' type='text' name='{$que_id}[]' value='{$submittedAns}' class='{$que_id}'>";
            } else if (!is_array($survey_answer_prefill) && !empty($survey_answer_prefill) && $advancetype == 'Integer') {
                $html .= "<input class='form-control {$que_id} numericField' type='text' name='{$que_id}[]' value='{$survey_answer_prefill}' class='{$que_id}'>";
            }
            // if float then add class to validate with prefill submitted answer
            else if (!is_array($survey_answer_prefill) && !empty($survey_answer_prefill) && $advancetype == 'Float') {
                $html .= "<input class='form-control {$que_id} decimalField' type='text' name='{$que_id}[]' value='{$survey_answer_prefill}' class='{$que_id}'>";
            }
            // if float then add class to validate with prefill submitted answer
            else if (!is_array($survey_answer_prefill) && !empty($survey_answer_prefill)) {
                $html .= "<input class='form-control {$que_id} ' type='text' name='{$que_id}[]' value='{$survey_answer_prefill}' class='{$que_id}'>";
            }
            // if interger then add class to validate
            else if (empty($submittedAns) && $advancetype == 'Integer') {
                $html .= "<input class='form-control {$que_id} numericField' type='text' name='{$que_id}[]' class='{$que_id}'>";
            }
            // if float then add class to validate
            else if (empty($submittedAns) && $advancetype == 'Float') {
                $html .= "<input class='form-control {$que_id} decimalField' type='text' name='{$que_id}[]' class='{$que_id}'>";
            }
            // default textbox
            else {
                $html .= "<input class='form-control {$que_id} ' type='text' name='{$que_id}[]' class='{$que_id}'>";
            }
            $html .= "</li></ul></div>";
            return $html;
            break;
        case 'commentbox':
            $html = "<div class='option select-list two-col' id='{$que_id}_div'><ul><li>";
            // if already submitted answer then prefill data
            if (!is_array($submittedAns) && !empty($submittedAns)) {
                // layout with given rows and columns
                if (!empty($min) || !empty($max)) {
                    $html .= "<textarea style='height:auto;width:auto;' class='commentbox-class form-control {$que_id}' rows='{$min}' cols='{$max}' name='{$que_id}[]'>{$submittedAns}</textarea>";
                }
                // default textarea
                else {
                    $html .= "<textarea class='commentbox-class form-control {$que_id}' rows='4' cols='20' name='{$que_id}[]'>{$submittedAns}</textarea>";
                }
            } else if (!is_array($survey_answer_prefill) && !empty($survey_answer_prefill)) {
                // layout with given rows and columns
                if (!empty($min) || !empty($max)) {
                    $html .= "<textarea style='height:auto;width:auto;' class='commentbox-class form-control {$que_id}' rows='{$min}' cols='{$max}' name='{$que_id}[]'>{$survey_answer_prefill}</textarea>";
                }
                // default textarea
                else {
                    $html .= "<textarea class='commentbox-class form-control {$que_id}' rows='4' cols='20' name='{$que_id}[]'>{$survey_answer_prefill}</textarea>";
                }
            }
            // not submitted answer
            else {
                // layout with given rows and columns
                if (!empty($min) || !empty($max)) {
                    $html .= "<textarea style='height:auto;width:auto;' class='commentbox-class form-control {$que_id}' rows='{$min}' cols='{$max}' name='{$que_id}[]'></textarea>";
                }
                // default textarea
                else {
                    $html .= "<textarea class='commentbox-class form-control {$que_id}' rows='4' cols='20' name='{$que_id}[]'></textarea>";
                }
            }
            $html .= "</li></ul></div>";
            return $html;
            break;
        case 'rating':
            $html = "<div class='option select-list' id='{$que_id}_div'>";
            $html .= "<ul onMouseOut='resetRating(\"{$que_id}\")'>";
            // star count is given
            if (!empty($maxsize)) {
                $starCount = $maxsize;
            }
            //default 5 star
            else {
                $starCount = 5;
            }
            //generate star as per given star numbers
            for ($i = 1; $i <= $starCount; $i++) {
                if (!is_array($submittedAns) && !empty($submittedAns) && (int) $submittedAns >= $i) {
                    $selected = "highlight";
                } else {
                    $selected = "";
                }
                $html .= "<li class='rating {$selected}' style='display: inline;font-size: x-large' onmouseover='highlightStar(this,\"{$que_id}\");'  onmouseout='removeHighlight(\"{$que_id}\");' onclick='addRating(this,\"{$que_id}\")'>&#9733;</li>";
            }
            $html .= "</ul>";
            $html .= "</div>";
            $html .= "<input type='hidden'  name='{$que_id}[]' class='{$que_id}' id='{$que_id}_hidden' value='{$submittedAns}'>";
            return $html;
            break;
        case 'contact-information':
            $placeholder_name = 'Name';
            if (!empty($list_lang_detail) && !empty($list_lang_detail[$que_id . '_placeholder_label_Name'])) {
                $placeholder_name = $list_lang_detail[$que_id . '_placeholder_label_Name'];
            }
            $placeholder_email = 'Email Address';
            if (!empty($list_lang_detail) && !empty($list_lang_detail[$que_id . '_placeholder_label_Email Address'])) {
                $placeholder_email = $list_lang_detail[$que_id . '_placeholder_label_Email Address'];
            }
            $placeholder_phone = 'Phone Number';
            if (!empty($list_lang_detail) && !empty($list_lang_detail[$que_id . '_placeholder_label_Phone Number'])) {
                $placeholder_phone = $list_lang_detail[$que_id . '_placeholder_label_Phone Number'];
            }
            $placeholder_address = 'Street1';
            if (!empty($list_lang_detail) && !empty($list_lang_detail[$que_id . '_placeholder_label_Address'])) {
                $placeholder_address = $list_lang_detail[$que_id . '_placeholder_label_Address'];
            }
            $placeholder_address2 = 'Street2';
            if (!empty($list_lang_detail) && !empty($list_lang_detail[$que_id . '_placeholder_label_Address2'])) {
                $placeholder_address2 = $list_lang_detail[$que_id . '_placeholder_label_Address2'];
            }
            $placeholder_city = 'City/Town';
            if (!empty($list_lang_detail) && !empty($list_lang_detail[$que_id . '_placeholder_label_City/Town'])) {
                $placeholder_city = $list_lang_detail[$que_id . '_placeholder_label_City/Town'];
            }
            $placeholder_state = 'State/Province';
            if (!empty($list_lang_detail) && !empty($list_lang_detail[$que_id . '_placeholder_label_State/Province'])) {
                $placeholder_state = $list_lang_detail[$que_id . '_placeholder_label_State/Province'];
            }
            $placeholder_zip = 'ZIP/Postal Code';
            if (!empty($list_lang_detail) && !empty($list_lang_detail[$que_id . '_placeholder_label_ZIP/Postal Code'])) {
                $placeholder_zip = $list_lang_detail[$que_id . '_placeholder_label_ZIP/Postal Code'];
            }
            $placeholder_country = 'Country';
            if (!empty($list_lang_detail) && !empty($list_lang_detail[$que_id . '_placeholder_label_Country'])) {
                $placeholder_country = $list_lang_detail[$que_id . '_placeholder_label_Country'];
            }
            $placeholder_company = 'Company';
            if (!empty($list_lang_detail) && !empty($list_lang_detail[$que_id . '_placeholder_label_Company'])) {
                $placeholder_company = $list_lang_detail[$que_id . '_placeholder_label_Company'];
            }

            $contactInfo = array();
            if (is_array($submittedAns) && count($submittedAns) > 0) {
                foreach ($submittedAns as $inx => $ans) {
                    if (!empty($ans)) {
                        $cnArr = explode(':', $ans);
                        $cnArr_index_0 = (!empty($cnArr[0])) ? $cnArr[0] : '';
                        $cnArr_index_1 = (!empty($cnArr[1])) ? $cnArr[1] : '';
                        $contactInfo[str_replace(" ", "", $cnArr_index_0)] = trim($cnArr_index_1);
                    }
                }
            }

            if ($is_required == 1 && empty($advancetype)) {
                $html = "<div class='option input-list two-col' id='{$que_id}_div'><ul>";
                if ((count($submittedAns) > 0) && !empty($contactInfo['Name'])) {
                    $html .= "<li><input placeholder='{$placeholder_name} *' class='form-control {$que_id} {$que_id}_name'  type='text' name='{$que_id}[{$que_id}][Name]' value='{$contactInfo['Name']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_name} *' class='form-control {$que_id} {$que_id}_name'  type='text' name='{$que_id}[{$que_id}][Name]'></li>";
                }
                if ((count($submittedAns) > 0) && !empty($contactInfo['EmailAddress'])) {
                    $html .= "<li><input placeholder='{$placeholder_email} *'  class='form-control {$que_id} {$que_id}_email'  type='text' name='{$que_id}[{$que_id}][Email Address]' value='{$contactInfo['EmailAddress']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_email} *'  class='form-control {$que_id} {$que_id}_email'  type='text' name='{$que_id}[{$que_id}][Email Address]'></li>";
                }
                if ((count($submittedAns) > 0) && !empty($contactInfo['Company'])) {
                    $html .= "<li><input placeholder='{$placeholder_company}' class='form-control {$que_id} {$que_id}_company'  type='text' name='{$que_id}[{$que_id}][Company]' value='{$contactInfo['Company']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_company}' class='form-control {$que_id} {$que_id}_company'  type='text' name='{$que_id}[{$que_id}][Company]'></li>";
                }
                if ((count($submittedAns) > 0) && !empty($contactInfo['PhoneNumber'])) {
                    $html .= "<li><input placeholder='{$placeholder_phone} *' class='form-control {$que_id} {$que_id}_phone'  type='text' name='{$que_id}[{$que_id}][Phone Number]' value='{$contactInfo['PhoneNumber']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_phone} *' class='form-control {$que_id} {$que_id}_phone'  type='text' name='{$que_id}[{$que_id}][Phone Number]'></li>";
                }
                if ((count($submittedAns) > 0) && !empty($contactInfo['Address'])) {
                    $html .= "<li><input placeholder='{$placeholder_address}' class='form-control {$que_id} {$que_id}_address'  type='text' name='{$que_id}[{$que_id}][Address]' value='{$contactInfo['Address']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_address}' class='form-control {$que_id} {$que_id}_address'  type='text' name='{$que_id}[{$que_id}][Address]'></li>";
                }
                if ((count($submittedAns) > 0) && !empty($contactInfo['Address2'])) {
                    $html .= "<li><input placeholder='{$placeholder_address2}'class='form-control {$que_id} {$que_id}_address2'  type='text' name='{$que_id}[{$que_id}][Address2]' value='{$contactInfo['Address2']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_address2}'class='form-control {$que_id} {$que_id}_address2'  type='text' name='{$que_id}[{$que_id}][Address2]'></li>";
                }
                if ((count($submittedAns) > 0) && !empty($contactInfo['City/Town'])) {
                    $html .= "<li><input placeholder='{$placeholder_city}' class='form-control {$que_id} {$que_id}_city'  type='text' name='{$que_id}[{$que_id}][City/Town]' value='{$contactInfo['City/Town']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_city}' class='form-control {$que_id} {$que_id}_city'  type='text' name='{$que_id}[{$que_id}][City/Town]'></li>";
                }
                if ((count($submittedAns) > 0) && !empty($contactInfo['State/Province'])) {
                    $html .= "<li><input placeholder='{$placeholder_state}' class='form-control {$que_id} {$que_id}_state'  type='text' name='{$que_id}[{$que_id}][State/Province]' value='{$contactInfo['State/Province']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_state}' class='form-control {$que_id} {$que_id}_state'  type='text' name='{$que_id}[{$que_id}][State/Province]'></li>";
                }
                if ((count($submittedAns) > 0) && !empty($contactInfo['Zip/PostalCode'])) {
                    $html .= "<li><input placeholder='{$placeholder_zip}' class='form-control {$que_id} {$que_id}_zip'  type='text' name='{$que_id}[{$que_id}][Zip/Postal Code]' value='{$contactInfo['Zip/PostalCode']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_zip}' class='form-control {$que_id} {$que_id}_zip'  type='text' name='{$que_id}[{$que_id}][Zip/Postal Code]'></li>";
                }
                if ((count($submittedAns) > 0) && !empty($contactInfo['Country'])) {
                    $html .= "<li><input placeholder='{$placeholder_country}' class='form-control {$que_id} {$que_id}_country'  type='text' name='{$que_id}[{$que_id}][Country]' value='{$contactInfo['Country']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_country}' class='form-control {$que_id} {$que_id}_country'  type='text' name='{$que_id}[{$que_id}][Country]'></li>";
                }
                $html .= "</ul></div>";
            }
            // if required fields array is given then set html as per the same
            else if ($is_required == 1 && !empty($advancetype)) {
                $requireFields = explode(' ', $advancetype);
                $html = "<div class='option input-list two-col' id='{$que_id}_div'><ul>";
                //if name field is required then set placeholder
                if (in_array($placeholder_name, $requireFields)) {
                    if ((count($submittedAns) > 0) && !empty($contactInfo[$placeholder_name])) {
                        $html .= "<li><input placeholder='{$placeholder_name} *' class='form-control {$que_id} {$que_id}_name'  type='text' name='{$que_id}[{$que_id}][Name]' value='{$contactInfo['Name']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_name} *' class='form-control {$que_id} {$que_id}_name'  type='text' name='{$que_id}[{$que_id}][Name]'></li>";
                    }
                } else {
                    if ((count($submittedAns) > 0) && !empty($contactInfo['Name'])) {
                        $html .= "<li><input placeholder='{$placeholder_name} ' class='form-control {$que_id} {$que_id}_name'  type='text' name='{$que_id}[{$que_id}][Name]' value='{$contactInfo['Name']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_name} ' class='form-control {$que_id} {$que_id}_name'  type='text' name='{$que_id}[{$que_id}][Name]'></li>";
                    }
                }
                //if email field is required then set placeholder
                if (in_array('Email', $requireFields)) {
                    if ((count($submittedAns) > 0) && !empty($contactInfo['EmailAddress'])) {
                        $html .= "<li><input placeholder='{$placeholder_email} *'  class='form-control {$que_id} {$que_id}_email'  type='text' name='{$que_id}[{$que_id}][Email Address]' value='{$contactInfo['EmailAddress']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_email} *'  class='form-control {$que_id} {$que_id}_email'  type='text' name='{$que_id}[{$que_id}][Email Address]'></li>";
                    }
                } else {
                    if ((count($submittedAns) > 0) && !empty($contactInfo['EmailAddress'])) {
                        $html .= "<li><input placeholder='{$placeholder_email} '  class='form-control {$que_id} {$que_id}_email'  type='text' name='{$que_id}[{$que_id}][Email Address]' value='{$contactInfo['EmailAddress']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_email} '  class='form-control {$que_id} {$que_id}_email'  type='text' name='{$que_id}[{$que_id}][Email Address]'></li>";
                    }
                }
                //if company field is required then set placeholder
                if (in_array('Company', $requireFields)) {
                    if ((count($submittedAns) > 0) && !empty($contactInfo['Company'])) {
                        $html .= "<li><input placeholder='{$placeholder_company} *' class='form-control {$que_id} {$que_id}_company'  type='text' name='{$que_id}[{$que_id}][Company]' value='{$contactInfo['Company']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_company} *' class='form-control {$que_id} {$que_id}_company'  type='text' name='{$que_id}[{$que_id}][Company]'></li>";
                    }
                } else {
                    if ((count($submittedAns) > 0) && !empty($contactInfo['Company'])) {
                        $html .= "<li><input placeholder='{$placeholder_company}' class='form-control {$que_id} {$que_id}_company'  type='text' name='{$que_id}[{$que_id}][Company]' value='{$contactInfo['Company']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_company}' class='form-control {$que_id} {$que_id}_company'  type='text' name='{$que_id}[{$que_id}][Company]'></li>";
                    }
                }
                //if phone field is required then set placeholder
                if (in_array('Phone', $requireFields)) {
                    if ((count($submittedAns) > 0) && !empty($contactInfo['PhoneNumber'])) {
                        $html .= "<li><input placeholder='{$placeholder_phone} *' class='form-control {$que_id} {$que_id}_phone'  type='text' name='{$que_id}[{$que_id}][Phone Number]' value='{$contactInfo['PhoneNumber']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_phone} *' class='form-control {$que_id} {$que_id}_phone'  type='text' name='{$que_id}[{$que_id}][Phone Number]'></li>";
                    }
                } else {
                    if ((count($submittedAns) > 0) && !empty($contactInfo['PhoneNumber'])) {
                        $html .= "<li><input placeholder='{$placeholder_phone} ' class='form-control {$que_id} {$que_id}_phone'  type='text' name='{$que_id}[{$que_id}][Phone Number]' value='{$contactInfo['PhoneNumber']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_phone} ' class='form-control {$que_id} {$que_id}_phone'  type='text' name='{$que_id}[{$que_id}][Phone Number]'></li>";
                    }
                }
                //if address field is required then set placeholder
                if (in_array('Address', $requireFields)) {
                    if ((count($submittedAns) > 0) && !empty($contactInfo['Address'])) {
                        $html .= "<li><input placeholder='{$placeholder_address} *' class='form-control {$que_id} {$que_id}_address'  type='text' name='{$que_id}[{$que_id}][Address]' value='{$contactInfo['Address']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_address} *' class='form-control {$que_id} {$que_id}_address'  type='text' name='{$que_id}[{$que_id}][Address]'></li>";
                    }
                } else {
                    //Added by charmi 14-09-2018 changed from address2 to address
                    if ((count($submittedAns) > 0) && !empty($contactInfo['Address'])) {
                        $html .= "<li><input placeholder='{$placeholder_address}' class='form-control {$que_id} {$que_id}_address'  type='text' name='{$que_id}[{$que_id}][Address]' value='{$contactInfo['Address']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_address}' class='form-control {$que_id} {$que_id}_address'  type='text' name='{$que_id}[{$que_id}][Address]'></li>";
                    }
                }
                //if address2 field is required then set placeholder
                if (in_array('Address2', $requireFields)) {
                    if ((count($submittedAns) > 0) && !empty($contactInfo['Address2'])) {
                        $html .= "<li><input placeholder='{$placeholder_address2} *'class='form-control {$que_id} {$que_id}_address2'  type='text' name='{$que_id}[{$que_id}][Address2]' value='{$contactInfo['Address2']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_address2} *'class='form-control {$que_id} {$que_id}_address2'  type='text' name='{$que_id}[{$que_id}][Address2]'></li>";
                    }
                } else {
                    if ((count($submittedAns) > 0) && !empty($contactInfo['Address2'])) {
                        $html .= "<li><input placeholder='{$placeholder_address2}'class='form-control {$que_id} {$que_id}_address2'  type='text' name='{$que_id}[{$que_id}][Address2]' value='{$contactInfo['Address2']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_address2}'class='form-control {$que_id} {$que_id}_address2'  type='text' name='{$que_id}[{$que_id}][Address2]'></li>";
                    }
                }
                //if city field is required then set placeholder
                if (in_array('City', $requireFields)) {
                    if ((count($submittedAns) > 0) && !empty($contactInfo['City/Town'])) {
                        $html .= "<li><input placeholder='{$placeholder_city} *' class='form-control {$que_id} {$que_id}_city'  type='text' name='{$que_id}[{$que_id}][City/Town]' value='{$contactInfo['City/Town']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_city} *' class='form-control {$que_id} {$que_id}_city'  type='text' name='{$que_id}[{$que_id}][City/Town]'></li>";
                    }
                } else {
                    if ((count($submittedAns) > 0) && !empty($contactInfo['City/Town'])) {
                        $html .= "<li><input placeholder='{$placeholder_city}' class='form-control {$que_id} {$que_id}_city'  type='text' name='{$que_id}[{$que_id}][City/Town]' value='{$contactInfo['City/Town']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_city}' class='form-control {$que_id} {$que_id}_city'  type='text' name='{$que_id}[{$que_id}][City/Town]'></li>";
                    }
                }
                //if state field is required then set placeholder
                if (in_array('State', $requireFields)) {
                    if ((count($submittedAns) > 0) && !empty($contactInfo['State/Province'])) {
                        $html .= "<li><input placeholder='{$placeholder_state} *' class='form-control {$que_id} {$que_id}_state'  type='text' name='{$que_id}[{$que_id}][State/Province]' value='{$contactInfo['State/Province']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_state} *' class='form-control {$que_id} {$que_id}_state'  type='text' name='{$que_id}[{$que_id}][State/Province]'></li>";
                    }
                } else {
                    if ((count($submittedAns) > 0) && !empty($contactInfo['State/Province'])) {
                        $html .= "<li><input placeholder='{$placeholder_state}' class='form-control {$que_id} {$que_id}_state'  type='text' name='{$que_id}[{$que_id}][State/Province]' value='{$contactInfo['State/Province']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_state}' class='form-control {$que_id} {$que_id}_state'  type='text' name='{$que_id}[{$que_id}][State/Province]'></li>";
                    }
                }
                //if zip field is required then set placeholder
                if (in_array('Zip', $requireFields)) {
                    if ((count($submittedAns) > 0) && !empty($contactInfo['Zip/PostalCode'])) {
                        $html .= "<li><input placeholder='{$placeholder_zip} *' class='form-control {$que_id} {$que_id}_zip'  type='text' name='{$que_id}[{$que_id}][Zip/Postal Code]' value='{$contactInfo['Zip/PostalCode']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_zip} *' class='form-control {$que_id} {$que_id}_zip'  type='text' name='{$que_id}[{$que_id}][Zip/Postal Code]'></li>";
                    }
                } else {
                    if ((count($submittedAns) > 0) && !empty($contactInfo['Zip/PostalCode'])) {
                        $html .= "<li><input placeholder='{$placeholder_zip}' class='form-control {$que_id} {$que_id}_zip'  type='text' name='{$que_id}[{$que_id}][Zip/Postal Code]' value='{$contactInfo['Zip/PostalCode']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_zip}' class='form-control {$que_id} {$que_id}_zip'  type='text' name='{$que_id}[{$que_id}][Zip/Postal Code]'></li>";
                    }
                }
                //if email field is required then set placeholder
                if (in_array('Country', $requireFields)) {
                    if ((count($submittedAns) > 0) && !empty($contactInfo['Country'])) {
                        $html .= "<li><input placeholder='{$placeholder_country} *' class='form-control {$que_id} {$que_id}_country'  type='text' name='{$que_id}[{$que_id}][Country]' value='{$contactInfo['Country']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_country} *' class='form-control {$que_id} {$que_id}_country'  type='text' name='{$que_id}[{$que_id}][Country]'></li>";
                    }
                } else {
                    if ((count($submittedAns) > 0) && !empty($contactInfo['Country'])) {
                        $html .= "<li><input placeholder='{$placeholder_country}' class='form-control {$que_id} {$que_id}_country'  type='text' name='{$que_id}[{$que_id}][Country]' value='{$contactInfo['Country']}'></li>";
                    } else {
                        $html .= "<li><input placeholder='{$placeholder_country}' class='form-control {$que_id} {$que_id}_country'  type='text' name='{$que_id}[{$que_id}][Country]'></li>";
                    }
                }
                $html .= "</ul></div>";
            } else {
                $html = "<div class='option input-list two-col' id='{$que_id}_div'><ul>";
                if ((count($submittedAns) > 0) && !empty($contactInfo['Name'])) {
                    $html .= "<li><input placeholder='{$placeholder_name}' class='form-control {$que_id} {$que_id}_name'  type='text' name='{$que_id}[{$que_id}][Name]' value='{$contactInfo['Name']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_name}' class='form-control {$que_id} {$que_id}_name'  type='text' name='{$que_id}[{$que_id}][Name]'></li>";
                }
                if ((count($submittedAns) > 0) && !empty($contactInfo['EmailAddress'])) {
                    $html .= "<li><input placeholder='{$placeholder_email}'  class='form-control {$que_id} {$que_id}_email'  type='text' name='{$que_id}[{$que_id}][Email Address]' value='{$contactInfo['EmailAddress']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_email}'  class='form-control {$que_id} {$que_id}_email'  type='text' name='{$que_id}[{$que_id}][Email Address]'></li>";
                }
                if ((count($submittedAns) > 0) && !empty($contactInfo['Company'])) {
                    $html .= "<li><input placeholder='{$placeholder_company}' class='form-control {$que_id}'  type='text' name='{$que_id}[{$que_id}][Company]' value='{$contactInfo['Company']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_company}' class='form-control {$que_id}'  type='text' name='{$que_id}[{$que_id}][Company]'></li>";
                }
                if ((count($submittedAns) > 0) && !empty($contactInfo['PhoneNumber'])) {
                    $html .= "<li><input placeholder='{$placeholder_phone}' class='form-control {$que_id} {$que_id}_phone'  type='text' name='{$que_id}[{$que_id}][Phone Number]' value='{$contactInfo['PhoneNumber']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_phone}' class='form-control {$que_id} {$que_id}_phone'  type='text' name='{$que_id}[{$que_id}][Phone Number]'></li>";
                }
                if ((count($submittedAns) > 0) && !empty($contactInfo['Address'])) {
                    $html .= "<li><input placeholder='{$placeholder_address}' class='form-control {$que_id}'  type='text' name='{$que_id}[{$que_id}][Address]' value='{$contactInfo['Address']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_address}' class='form-control {$que_id}'  type='text' name='{$que_id}[{$que_id}][Address]'></li>";
                }
                if ((count($submittedAns) > 0) && !empty($contactInfo['Address2'])) {
                    $html .= "<li><input placeholder='{$placeholder_address2}'class='form-control {$que_id}'  type='text' name='{$que_id}[{$que_id}][Address2]' value='{$contactInfo['Address2']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_address2}'class='form-control {$que_id}'  type='text' name='{$que_id}[{$que_id}][Address2]'></li>";
                }
                if ((count($submittedAns) > 0) && !empty($contactInfo['City/Town'])) {
                    $html .= "<li><input placeholder='{$placeholder_city}' class='form-control {$que_id}'  type='text' name='{$que_id}[{$que_id}][City/Town]' value='{$contactInfo['City/Town']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_city}' class='form-control {$que_id}'  type='text' name='{$que_id}[{$que_id}][City/Town]'></li>";
                }
                if ((count($submittedAns) > 0) && !empty($contactInfo['State/Province'])) {
                    $html .= "<li><input placeholder='{$placeholder_state}' class='form-control {$que_id}'  type='text' name='{$que_id}[{$que_id}][State/Province]' value='{$contactInfo['State/Province']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_state}' class='form-control {$que_id}'  type='text' name='{$que_id}[{$que_id}][State/Province]'></li>";
                }
                if ((count($submittedAns) > 0) && !empty($contactInfo['Zip/PostalCode'])) {
                    $html .= "<li><input placeholder='{$placeholder_zip}' class='form-control {$que_id}'  type='text' name='{$que_id}[{$que_id}][Zip/Postal Code]' value='{$contactInfo['Zip/PostalCode']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_zip}' class='form-control {$que_id}'  type='text' name='{$que_id}[{$que_id}][Zip/Postal Code]'></li>";
                }
                if ((count($submittedAns) > 0) && !empty($contactInfo['Country'])) {
                    $html .= "<li><input placeholder='{$placeholder_country}' class='form-control {$que_id}'  type='text' name='{$que_id}[{$que_id}][Country]' value='{$contactInfo['Country']}'></li>";
                } else {
                    $html .= "<li><input placeholder='{$placeholder_country}' class='form-control {$que_id}'  type='text' name='{$que_id}[{$que_id}][Country]'></li>";
                }
                $html .= "</ul></div>";
            }
            return $html;
            break;
        case 'date-time':
            $html = "<div class='option select-list two-col' id='{$que_id}_div'><ul><li>";
            // already submitted answer
            if (!is_array($submittedAns) && !empty($submittedAns)) {
                // if is date and time
                if ($is_datetime == 1) {
                    $html .= "<input class='form-control setdatetime {$que_id}_datetime' value='{$submittedAns}' type='text' name='{$que_id}[]' class='{$que_id}'>";
                }
                // only date
                else {
                    $html .= "<input class='form-control setdate {$que_id}_datetime' type='text' value='{$submittedAns}' name='{$que_id}[]' class='{$que_id}'>";
                }
            }
            // not submitted answer
            else {
                // if is date and time
                if ($is_datetime == 1) {
                    $html .= "<input class='form-control setdatetime {$que_id}_datetime' type='text' name='{$que_id}[]' class='{$que_id}'>";
                }
                // only date
                else {
                    $html .= "<input class='form-control setdate {$que_id}_datetime' type='text' name='{$que_id}[]' class='{$que_id}'>";
                }
            }
            $html .= "</li></ul></div>";
            return $html;
            break;
        case 'image':
            $html = "<div class='option select-list' id='{$que_id}_div'><ul><li>";
            if ($que_title == "uploadImage") {
                $imgURL = $matrix_row;
            } else {
                $imgURL = $advancetype;
            }
            $html .= ""
                    . "<img style='cursor: default;' src='{$imgURL}' class='  {$que_id}_datetime' alt='no-image'  name='{$que_id}[]' >";

            $html .= "</li></ul></div>";
            return $html;
            break;
        case 'video':
            $html = "<div class='option select-list' id='{$que_id}_div'><ul><li>";
            $html .= '<iframe width="420" height="315"
                                src="' . $advancetype . '">
                      </iframe>';
            if (!empty($description)) {
                $html .= "<p>" . $description . "</p>";
            }
            $html .= "</li></ul></div>";
            return $html;
            break;
        case 'scale':
            if (!is_array($submittedAns) && !empty($submittedAns)) {
                $selected = $submittedAns;
            } else {
                $selected = "";
            }
            $lables = !empty($advancetype) ? explode('-', $advancetype) : '';
            $left = !empty($list_lang_detail[$que_id . '_display_label_left']) ? $list_lang_detail[$que_id . '_display_label_left'] : (!empty($lables) ? $lables[0] : '');
            $middle = !empty($list_lang_detail[$que_id . '_display_label_middle']) ? $list_lang_detail[$que_id . '_display_label_middle'] : (!empty($lables) ? $lables[1] : '');
            $right = !empty($list_lang_detail[$que_id . '_display_label_right']) ? $list_lang_detail[$que_id . '_display_label_right'] : (!empty($lables) ? $lables[2] : '');

            if (!isset($min) || !isset($max)) {
                $min = 0;
                $max = 10;
            }
            //display scale input field
            $html = "<div id='{$que_id}_div' style='padding-left:16px;padding-top:15px;'>";
            $html .= '<div style="width:60%"> 
                        <span class="equal">' . $min . '</span> 
                        <span class="equal" ></span>
                        <span class="equal" style="text-align:right">' . $max . '</span>
                    </div>';
            $html .= '<br/><section style="width:60%;padding-top: 0px !important;" class=' . $que_id . '> 
                        <div id="slider"></div>
                    </section>';
            $html .= '<div style="width:60%;height:30px;"> 
                        <span class="equal">' . $left . '</span> 
                        <span class="equal" style="text-align:center">' . $middle . '</span>
                        <span class="equal" style="text-align:right">' . $right . '</span>
                    </div>';
            $html .= "<input type='hidden'  name='{$que_id}[]' class='{$que_id}_scale' id='{$que_id}_hidden' value='{$submittedAns}'>";
            $html .= "</div>";
            return $html;
            break;
        case 'matrix':
            $submittedAnsDetail = array();
            $submittedAnsDetail = explode(',', $submittedAns);
//            foreach ($submittedAns[$que_title] as $k => $AnsDetail) {
//                foreach ($AnsDetail as $key => $SubAnsDetail) {
//                    foreach ($SubAnsDetail as $i => $Ans) {
//                        $submittedAnsDetail[$i] = $Ans;
//                    }
//                }
//            }
            // display selection type for matrix
            $display_type = $advancetype == 'checkbox' ? 'checkbox' : 'radio';
            $rows = array();
            $rows = json_decode($matrix_row);
            $cols = json_decode($matrix_col);

            // Initialize counter - count number of rows & columns
            $row_count = 1;
            $col_count = 1;
            if (is_array($submittedAnsDetail)) {
                // foreach ($matrix as $key => $data) {
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
                $width = 100 / ($col_count + 1);
                $margin_block = $width + 20 . '%';

                $html = '<div class="matrix-tbl-contner">';
                $html .= "<table class='survey_tmp_matrix' id='{$que_id}_div'>";
                $op = 0;
                for ($i = 1; $i <= $row_count; $i++) {
                    $html .= '<tr class="row">';
                    for ($j = 1; $j <= $col_count + 1; $j++) {
                        $row = $i - 1;
                        $col = $j - 1;
                        //First row & first column as blank
                        if ($j == 1 && $i == 1) {
                            $html .= "<th class='matrix-span' style='width:" . $width . "'>&nbsp;</th>";
                        }
                        // Rows Label
                        else if ($j == 1 && $i != 1) {
                            if (!empty($list_lang_detail) && !empty($list_lang_detail[$que_id . '_matrix_row' . $row])) {
                                $row_header = $list_lang_detail[$que_id . '_matrix_row' . $row];
                            } else {
                                $row_header = $rows->$row;
                            }
                            $html .= "<th class='matrix-span {$que_id}_matrix' value='{$row}' style='font-weight:bold; width:" . $width . ";text-align:left;'>" . $row_header . "</th>";
                        } else {
                            //Columns label
                            if ($j <= ($col_count + 1) && isset($cols->$col) && $cols->$col != null && !($j == 1 && $i == 1) && ($i == 1 || $j == 1)) {
                                if (!empty($list_lang_detail) && !empty($list_lang_detail[$que_id . '_matrix_col' . $col])) {
                                    $col_header = $list_lang_detail[$que_id . '_matrix_col' . $col];
                                } else {
                                    $col_header = $cols->$col;
                                }
                                $html .= "<th class='matrix-span' style='font-weight:bold; width:" . $width . "'>" . $col_header . "</th>";
                            }
                            //Display answer input (RadioButton or Checkbox)
                            else if ($j != 1 && $i != 1 && isset($cols->$col) && $cols->$col != null) {
                                // $html .= "<td class='matrix-span' style='width:" . $width . "; '>";
                                $current_value = $row . '_' . $col;
                                if (in_array($current_value, $submittedAnsDetail)) {
                                    if ($display_type == 'checkbox') {
                                        $html .= "<td class='matrix-span' style='width:" . $width . "; '><span class='md-checkbox' style='margin-left:" . $margin_block . "'><input checked type='" . $display_type . "' id='{$que_id}_{$op}'  value='{$row}_{$col}' class='{$que_id} md-check' name='{$que_id}[{$row}][]'/><label for='{$que_id}_{$op}'>
                                                            <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></span></td>";
                                    } else {
                                        $html .= "<td class='matrix-span' style='width:" . $width . "; '><span class='md-radio' style='margin-left:" . $margin_block . "'><input checked type='" . $display_type . "' id='{$que_id}_{$op}' class='{$que_id} md-radio' value='{$row}_{$col}' name='{$que_id}[{$row}][]'/><label for='{$que_id}_{$op}'>
                                                            <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></span></td>";
                                    }
                                } else {
                                    if ($display_type == 'checkbox') {
                                        $html .= "<td class='matrix-span' style='width:" . $width . "; '><span class='md-checkbox' style='margin-left:" . $margin_block . "'><input type='" . $display_type . "' id='{$que_id}_{$op}'  value='{$row}_{$col}' class='{$que_id} md-check' name='{$que_id}[{$row}][]'/><label for='{$que_id}_{$op}'>
                                                            <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></span></td>";
                                    } else {
                                        $html .= "<td class='matrix-span' style='width:" . $width . "; '><span class='md-radio' style='margin-left:" . $margin_block . "'><input type='" . $display_type . "' id='{$que_id}_{$op}' class='{$que_id} md-radio' value='{$row}_{$col}' name='{$que_id}[{$row}][]'/><label for='{$que_id}_{$op}'>
                                                            <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></span></td>";
                                    }
                                }
                                //   $html .= "</td>";
                            }
                            // If no value then display none
                            else {
                                $html .= "";
                            }
                        }
                        $op++;
                    }
                    $html .= "</tr>";
                }
                //   }
            } else {
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
                $width = 100 / ($col_count + 1);
                $margin_block = $width + 20 . '%';

                $html = '<div class="matrix-tbl-contner">';
                $html .= "<table class='survey_tmp_matrix' id='{$que_id}_div'>";
                $op = 0;
                for ($i = 1; $i <= $row_count; $i++) {
                    $html .= '<tr class="row">';
                    for ($j = 1; $j <= $col_count + 1; $j++) {
                        $row = $i - 1;
                        $col = $j - 1;
                        //First row & first column as blank
                        if ($j == 1 && $i == 1) {
                            $html .= "<th class='matrix-span' style='width:" . $width . "'>&nbsp;</th>";
                        }
                        // Rows Label
                        else if ($j == 1 && $i != 1) {
                            $html .= "<th class='matrix-span {$que_id}_matrix' value='{$row}' style='font-weight:bold; width:" . $width . ";text-align:left;'>" . $rows->$row . "</th>";
                        } else {
                            //Columns label
                            if ($j <= ($col_count + 1) && $cols->$col != null && !($j == 1 && $i == 1) && ($i == 1 || $j == 1)) {
                                $html .= "<th class='matrix-span' style='font-weight:bold; width:" . $width . "'>" . $cols->$col . "</th>";
                            }
                            //Display answer input (RadioButton or Checkbox)
                            else if ($j != 1 && $i != 1 && $cols->$col != null) {
                                if ($display_type == 'checkbox') {
                                    $html .= "<td class='matrix-span' style='width:" . $width . "; '><span class='md-checkbox' style='margin-left:" . $margin_block . "'><div class='matrix-span' style='width:" . $width . "; '><input type='" . $display_type . "'  value='{$row}_{$col}' id='{$que_id}_{$op}' name='{$que_id}[{$row}][]'/><label for='{$que_id}_{$op}'>
                                                            <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></span></div></td>";
                                } else {
                                    $html .= "<td class='matrix-span' style='width:" . $width . "; '><span class='md-radio' style='margin-left:" . $margin_block . "'><div class='matrix-span' style='width:" . $width . "; '><input type='" . $display_type . "' id='{$que_id}_{$op}' value='{$row}_{$col}' name='{$que_id}[{$row}][]'/><label for='{$que_id}_{$op}'>
                                                            <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></span></div></td>";
                                }
                            }
                            // If no value then display none
                            else {
                                $html .= "";
                            }
                        }
                        $op++;
                    }
                    $html .= "</tr>";
                }
            }
            $html .= "</table></div>";
            return $html;
            break;
        case 'doc-attachment':
            $file_attched = '';
            if (!empty($submittedAns)) {
                $spit_file = explode('_documentID_', $submittedAns);
                $file_attched = $spit_file[1];
                $attched_doc_id = $spit_file[0];
            }
            $html = "<div class='option select-list two-col' id='{$que_id}_div'><ul><li style='margin: 0 1% 3px 0; width: 100%;'>";
            $html .= "<div class='doc-attachment-btn'><span>Choose File</span>"
                    . "<input class='form-control upload {$que_id}' type='file' value='{$file_attched}' onchange='validateUploadedFile(this,\"" . $file_size . "\",\"" . $file_extension . "\")' name='{$que_id}'>"
                    . "<input class='file_uploaded_content' type='hidden' value='' name='{$que_id}_file_uploaded_content'>"
                    . "</div>";
            if (!empty($file_attched)) {
                $html .= "<div class='file_uploaded'><span class='imgcontent'>" . $file_attched . "</span> &nbsp;&nbsp;<a style='cursor:pointer; color:red;' onclick='removeAttachment(this)'>Remove</a></div>"
                        . "<input class='attched_doc' type='hidden' value='{$attched_doc_id}' name='{$que_id}_attched_document'>"
                        . "<input class='removed_doc' type='hidden' value='' name='{$que_id}_removed_attched_document'>"
                        . "<input class='attached_file_name' type='hidden' value='{$file_attched}' name='{$que_id}_attached_file_name'>";
            } else {
                $html .= "<div class='file_uploaded'><span class='imgcontent'></span></div>";
            }
            $html .= "<div style='display:none; height:30px; margin:0px 0px -10px 0px; display: inline-block;cursor: default;' class='val-msg-upload'></div>"
                    . "<input type='hidden' id='{$que_id}_fileContent' />";
            $html .= "</li></ul></div>";


            return $html;
            break;
        case 'richtextareabox':
            $html = "<div class='option select-list' id='{$que_id}_div'><ul><li style='cursor: default;'>";
            $richtextContent = html_entity_decode($richtextContent);
            $html .= "<div class='richContect'>{$richtextContent}</div><input type='hidden' name='richTextTypeQueID[]' value='{$que_id}' />";
            $html .= "</li></ul></div>";
            return $html;
            break;
        case 'netpromoterscore':
            if (!is_array($submittedAns) && !empty($submittedAns)) {
                $selected = $submittedAns;
            } else {
                $selected = "";
            }
            $lables = !empty($advancetype) ? explode('-', $advancetype) : '';
            $left = !empty($list_lang_detail[$que_id . '_display_label_left']) ? $list_lang_detail[$que_id . '_display_label_left'] : (!empty($lables) ? $lables[0] : '');
            $right = !empty($list_lang_detail[$que_id . '_display_label_right']) ? $list_lang_detail[$que_id . '_display_label_right'] : (!empty($lables) ? $lables[1] : '');
            if (empty($min) || empty($max)) {
                $min = 0;
                $max = 10;
            }
            //display scale input field
            $html .= "<div id='{$que_id}_div'>";
            $html .= "<div class='score_pannel_wrapper' id='score_pannel_{$que_id}'>
                        <table class='nps_submission_table' >
                        <tr>";
            foreach ($answers as $ans) {
                foreach ($ans as $ans_id => $answer) {
                    $oAnswer = BeanFactory::getBean('bc_survey_answers', $ans_id);
                    if ($answer < 7) {
                        if ($submittedAns == $answer) {
                            if ($is_skipp == 1) {
                                $html .= "<th><div onclick='applyNPSSelectedColor(this); skipp_logic_question(this,$ans_detail);' class='score_pannel' id='$ans_id' value='$answer' style='background-color:#a1cbff'>" . $answer . "</div></th>";
                            } else {
                                $html .= "<th><div  onclick='applyNPSSelectedColor(this);' class='score_pannel' id='$ans_id' value='$answer' style='background-color:#a1cbff'>" . $answer . "</div></th>";
                            }
                        } else {
                            if ($is_skipp == 1) {
                                $html .= "<th><div onclick='applyNPSSelectedColor(this); skipp_logic_question(this,$ans_detail);' class='score_pannel' id='$ans_id' value='$answer' style='background-color:#ff5353'>" . $answer . "</div></th>";
                            } else {
                                $html .= "<th><div onclick='applyNPSSelectedColor(this);' class='score_pannel' id='$ans_id' value='$answer' style='background-color:#ff5353'>" . $answer . "</div></th>";
                            }
                        }
                    } else if ($answer >= 7 && $answer < 9) {
                        if ($submittedAns == $answer) {
                            if ($is_skipp == 1) {
                                $html .= "<th><div onclick='applyNPSSelectedColor(this); skipp_logic_question(this,$ans_detail);' class='score_pannel' id='$ans_id' value='$answer' style='background-color:#a1cbff'>" . $answer . "</div></th>";
                            } else {
                                $html .= "<th><div onclick='applyNPSSelectedColor(this);' class='score_pannel' id='$ans_id' value='$answer' style='background-color:#a1cbff'>" . $answer . "</div></th>";
                            }
                        } else {
                            if ($is_skipp == 1) {
                                $html .= "<th><div onclick='applyNPSSelectedColor(this); skipp_logic_question(this,$ans_detail);' class='score_pannel' id='$ans_id' value='$answer'style='background-color:#e9e817'>" . $answer . "</div></th>";
                            } else {
                                $html .= "<th><div  onclick='applyNPSSelectedColor(this);' class='score_pannel' id='$ans_id' value='$answer'style='background-color:#e9e817'>" . $answer . "</div></th>";
                            }
                        }
                    } else if ($answer >= 9 && $answer <= 10) {
                        if ($submittedAns == $answer) {
                            if ($is_skipp == 1) {
                                $html .= "<th><div onclick='applyNPSSelectedColor(this); skipp_logic_question(this,$ans_detail);' class='score_pannel' id='$ans_id' value='$answer' style='background-color:#a1cbff'>" . $answer . "</div></th>";
                            } else {
                                $html .= "<th><div  onclick='applyNPSSelectedColor(this);' class='score_pannel' id='$ans_id' value='$answer' style='background-color:#a1cbff'>" . $answer . "</div></th>";
                            }
                        } else {
                            if ($is_skipp == 1) {
                                $html .= "<th><div onclick='applyNPSSelectedColor(this); skipp_logic_question(this,$ans_detail);' class='score_pannel' id='$ans_id' value='$answer' style='background-color:#92d51a'>" . $answer . "</div></th>";
                            } else {
                                $html .= "<th><div onclick='applyNPSSelectedColor(this);'  class='score_pannel' id='$ans_id' value='$answer' style='background-color:#92d51a'>" . $answer . "</div></th>";
                            }
                        }
                    }
                    if ($answer == $submittedAns) {
                        $html .= "<input type='hidden' value='{$ans_id}' class='nps_hidden_selected_values_id' id='hidden_selected_values_id_{$que_id}'/>";
                        $html .= "<input type='hidden' value='{$answer}' class='nps_hidden_selected_values' id='hidden_selected_values_{$que_id}'/>";
                    }
                }
            }
            $html .= "</tr>
                        </table>";
            $html .= '<div class="score_pannel_result"> 
                        <span class="equal">' . $left . '</span> 
                        <span class="equal" style="text-align:right">' . $right . '</span>
                    </div></div>';

            if (!empty($submittedAns[0])) {
                foreach ($answers as $answerskey => $answersvalue) {
                    if (in_array($submittedAns[0], $answersvalue)) {
                        foreach ($answersvalue as $answersvaluekey => $answersvaluevalue) {
                            if ($submittedAns[0] == $answersvaluevalue) {
                                $html .= "<input type='hidden'  name='{$que_id}[0]' class='{$que_id}_nps[0]' id='previous_nps_selected_id_hidden_{$que_id}' value='{$answersvaluekey}'/>";
                            }
                        }
                    }
                }
            } else {
                $html .= "<input type='hidden'  name='{$que_id}[0]' class='{$que_id}_nps[0]' id='previous_nps_selected_id_hidden_{$que_id}' value=''/>";
            }

//            $html .= "<input type='hidden'  name='{$que_id}[1]' class='{$que_id}_nps[1]' id='selected_nps_value_hidden_{$que_id}' value=''>";
            $html .= "</div>";
            return $html;
            break;
        case 'emojis':
            //display scale input field
            $html .= "<div id='{$que_id}_div'>";
            $html .= "<div class='emojis_class' id='emojis_{$que_id}'>";
            $op = 1;
            $emojisImges = array(
                1 => "custom/include/images/ext-unsatisfy.png",
                2 => "custom/include/images/unsatisfy.png",
                3 => "custom/include/images/nuteral.png",
                4 => "custom/include/images/satisfy.png",
                5 => "custom/include/images/ext-satisfy.png",
            );
            $emojisImgesGrey = array(
                1 => "custom/include/images/ext-unsatisfy-grey.png",
                2 => "custom/include/images/unsatisfy-grey.png",
                3 => "custom/include/images/nuteral-grey.png",
                4 => "custom/include/images/satisfy-grey.png",
                5 => "custom/include/images/ext-satisfy-grey.png",
            );
            $html .= '<ul>';
            foreach ($answers as $ans) {
                $imgDis = 'display:none';
                foreach ($ans as $ans_id => $answer) {
                    if ($ans_id == $submittedAns['answerId']) {
                        if ($is_skipp == 1) {
                            $html .= "<div  class='md-emojis' onclick='switchEmojis(this,\"{$op}\",\"{$que_id}\");skipp_logic_question(this,$ans_detail);'><li class='md-radio' style='display:inline;background-color: #ebebeb;'><label>
                                 <img class='Grey_Emoji' id='Grey_emojis_" . $op . "' src='{$emojisImgesGrey[$op]}' height='40' width='45' style='display:none;' value='Grey_emojis_" . $op . ".png_{$que_id}'>
                                    <img class='Emoji' id='emojis_" . $op . "' src='{$emojisImges[$op]}' height='40' width='45' style='display:inline-block;' value='emojis_" . $op . ".png_{$que_id}'>
                                        <input type='radio' id='{$que_id}_{$op}' value='{$ans_id}' name='{$que_id}[]' class='{$que_id} md-radiobtn ' checked='true' >
                                            <div>" . htmlspecialchars_decode($answer) . "</div>
                           <label for='{$que_id}_{$op}'>
                                <span></span>
                                <span style='display:none;' class='check'></span>
                                <span style='display:none;' class='box'></span></label></label></li>
                            </div>";
                            $op++;
                        } else {
                            $html .= "<div  class='md-emojis' onclick='switchEmojis(this,\"{$op}\",\"{$que_id}\")'><li class='md-radio' style='display:inline;background-color: #ebebeb;'><label>
                                 <img class='Grey_Emoji' id='Grey_emojis_" . $op . "' src='{$emojisImgesGrey[$op]}' height='40' width='45' style='display:none;' value='Grey_emojis_" . $op . ".png_{$que_id}'>
                                    <img class='Emoji' id='emojis_" . $op . "' src='{$emojisImges[$op]}' height='40' width='45' style='display:inline-block;' value='emojis_" . $op . ".png_{$que_id}'>
                                        <input type='radio' id='{$que_id}_{$op}' value='{$ans_id}' name='{$que_id}[]' class='{$que_id} md-radiobtn ' checked='true' >
                                            <div>" . htmlspecialchars_decode($answer) . "</div>
                           <label for='{$que_id}_{$op}'>
                                <span></span>
                                <span style='display:none;' class='check'></span>
                                <span style='display:none;' class='box'></span></label></label></li>
                            </div>";
                            $op++;
                        }
                    } else {
                        if ($is_skipp == 1) {
                            $html .= "<div  class='md-emojis' onclick='switchEmojis(this,\"{$op}\",\"{$que_id}\");skipp_logic_question(this,$ans_detail);'><li class='md-radio' style='display:inline;background-color: #ebebeb;'><label>
                                 <img class='Grey_Emoji' id='Grey_emojis_" . $op . "' src='{$emojisImgesGrey[$op]}' height='40' width='45' style='display:inline-block;' value='Grey_emojis_" . $op . ".png_{$que_id}'>
                                    <img class='Emoji' id='emojis_" . $op . "' src='{$emojisImges[$op]}' height='40' width='45' style='display:none;' value='emojis_" . $op . ".png_{$que_id}'>
                                        <input type='radio' id='{$que_id}_{$op}' value='{$ans_id}' name='{$que_id}[]' class='{$que_id} md-radiobtn ' >
                                            <div>" . htmlspecialchars_decode($answer) . "</div>
                           <label for='{$que_id}_{$op}'>
                                <span></span>
                                <span style='display:none;' class='check'></span>
                                <span style='display:none;' class='box'></span></label></label></li>
                            </div>";
                            $op++;
                        } else {
                            $html .= "<div  class='md-emojis' onclick='switchEmojis(this,\"{$op}\",\"{$que_id}\");'><li class='md-radio' style='display:inline;background-color: #ebebeb;'><label>
                                 <img class='Grey_Emoji' id='Grey_emojis_" . $op . "' src='{$emojisImgesGrey[$op]}' height='40' width='45' style='display:inline-block;' value='Grey_emojis_" . $op . ".png_{$que_id}'>
                                    <img class='Emoji' id='emojis_" . $op . "' src='{$emojisImges[$op]}' height='40' width='45' style='display:none;' value='emojis_" . $op . ".png_{$que_id}'>
                                        <input type='radio' id='{$que_id}_{$op}' value='{$ans_id}' name='{$que_id}[]' class='{$que_id} md-radiobtn ' >
                                            <div>" . htmlspecialchars_decode($answer) . "</div>
                           <label for='{$que_id}_{$op}'>
                                <span></span>
                                <span style='display:none;' class='check'></span>
                                <span style='display:none;' class='box'></span></label></label></li>
                            </div>";
                            $op++;
                        }
                    }
                }
            }
            $html .= "</ul></div></div>";
            return $html;
            break;
    }
}

$redirect_flag = false;
// Insert in Submission Data Module
if (isset($_REQUEST['btnsend']) && $_REQUEST['btnsend'] != '' && empty($msg1)) {


    /*  if (($submission_status == 'Submitted') && !($requestApproved) && ($userSbmtCount >= $reSubmitCount)) {
      $msg1 = "<div class='success_msg'>You have already submitted this " . ucfirst($survey->survey_type) . ". {$resubmit_request_msg}</div>";
      } elseif (($submission_status == 'Pending') && !empty($oStart_date) && !empty($oEnd_date) && ((strtotime($current_date) < strtotime($survey_start_date)))) {
      $msg1 = "<div class='failure_msg'>This " . ucfirst($survey->survey_type) . " has not started yet, Please try after {$startDateTime}.</div>";
      } elseif (($submission_status == 'Pending') && !empty($oStart_date) && !empty($oEnd_date) && (strtotime($current_date) > strtotime($survey_end_date))) {
      $msg1 = "<div class='failure_msg'>Sorry... This " . ucfirst($survey->survey_type) . " expired on {$endDateTime}.</div>";
      } elseif (!($requestApproved) && ($userSbmtCount >= $reSubmitCount)) {
      $msg1 = "<div class='success_msg'>You have already submitted this Survey. {$resubmit_request_msg}</div>";
      } else { */ // commented due to no use at this time
    $IganswersRes = array();
    $relQues = $survey->get_linked_beans('bc_survey_bc_survey_questions', 'bc_survey_questions');
    foreach ($relQues as $oQuestion) {
        $relAns = $oQuestion->get_linked_beans('bc_survey_answers_bc_survey_questions', 'bc_survey_answers');
        foreach ($relAns as $oAnswer) {
            $IganswersRes[] = $oAnswer->id;
        }
    }
    $commIGAns = "'" . implode("','", $IganswersRes) . "'";
    $submited_ans = '';
    $query = new SugarQuery();
    $query->from(BeanFactory::getBean('bc_survey_answers'));
    // select fields
    $query->select(array('id'));
    // where condition
    $query->where()->in('id', $deleteAnsIdsOnResubmitArray);
    if (!empty($IganswersRes)) {
        $query->where()->notIn('id', $IganswersRes);
    }
    $deleteAns_result = $query->execute();

    foreach ($deleteAns_result as $delAnsId) {
        $oAnswerDel = BeanFactory::getBean('bc_survey_answers', $delAnsId['id']);
        $oAnswerDel->deleted = 1;
        $oAnswerDel->save();
    }

    if (empty($survey_submission->id)) {
        $survey_submission = BeanFactory::getBean('bc_survey_submission', $submisstion_id);
    }
    
    // BugFix :: Advanced Workflow :: Populate $current_user for PMSE :: START
    global $current_user;
    // Populate $current_user for PMSE
    $current_user = new User();
    $current_user->retrieve($survey->assigned_user_id);
    // BugFix :: Advanced Workflow :: Populate $current_user for PMSE :: END
    // remove previously submitted answers
    $forcedelete = 0;
    $prevSubmitData = $survey_submission->get_linked_beans('bc_submission_data_bc_survey_submission', 'bc_submission_data');
    foreach ($prevSubmitData as $submited_data) {

        $GLOBALS['log']->debug("This is the submitted data :------- " . print_r($submited_data->id, 1));

        // deleted submission and submited data relationship
        $survey_submission->bc_submission_data_bc_survey_submission->delete($survey_submission->id, $submited_data->id);


        foreach ($submited_data->bc_submission_data_bc_survey_answers->getBeans() as $submited_ans) {

            $GLOBALS['log']->debug("This is the submitted answer :------- " . print_r($submited_ans->id, 1));

            // deleted submission and answer relationship
            $submited_data->bc_submission_data_bc_survey_answers->delete($submited_data->id, $submited_ans->id);
            $forcedelete = 1;
        }

        foreach ($submited_data->bc_submission_data_bc_survey_questions->getBeans() as $submited_que) {

            $GLOBALS['log']->debug("This is the submitted question :------- " . print_r($submited_que->id, 1));

            // deleted submission and question relationship
            $submited_data->bc_submission_data_bc_survey_questions->delete($submited_data->id, $submited_que->id);
        }
    }

    //delete from answers_calculation table only first time goes to submitSurveyResponseCalulation function
    $delete_flag = 0;
    $manage_que_type = array(); // manage flag for same type of question to delete resubmit time old data
    $obtained_score = 0;
    $showedQuestions = explode(',', $_POST['show_question_list']);
    $richTextTypeQueID = isset($_POST['richTextTypeQueID']) ? $_POST['richTextTypeQueID'] : array();
    $answer_to_update = array();
    $DocumentAttached = array();
    $multiselectQuesTypeArra = array('check-box', 'multiselectlist');

    $gmtdatetime = TimeDate::getInstance()->nowDb();

    foreach ($_REQUEST['questions'] as $submitted_que) {
        // file checking variables
        $file = '';
        $filepath = '';
        $already_attached_document_id = '';
        $submitted_ans = array();
        if (in_array($submitted_que, $showedQuestions) && $submited_ans != 'selection_default_value_dropdown') {
            $question_obj = new bc_survey_questions();
            $question_obj->retrieve($submitted_que);
            if ($question_obj->question_type == 'doc-attachment') {
                // file information
                $file = $_FILES[$submitted_que]['name'];
                $filepath = $_FILES[$submitted_que]['tmp_name'];
                if (empty($file) && empty($filepath) && isset($_REQUEST[$submitted_que . '_removed_attched_document']) && empty($_REQUEST[$submitted_que . '_removed_attched_document']) && isset($_REQUEST[$submitted_que . '_attched_document']) && !empty($_REQUEST[$submitted_que . '_attched_document'])) {
                    $already_attached_document_id = $_REQUEST[$submitted_que . '_attched_document'];
                    $submitted_ans = array($_REQUEST[$submitted_que . '_attached_file_name']);
                } else {
                    $submitted_ans = array($file);
                }
            } else {
                $submitted_ans = (isset($_REQUEST[$submitted_que])) ? $_REQUEST[$submitted_que] : '';
            }
            // addded for report *************************************************************//
            $submitted_question_obj = new bc_survey_submit_question();
            $submitted_question_obj->retrieve_by_string_fields(array('question_id' => $submitted_que, 'receiver_name' => $survey_submission->customer_name, 'submission_id' => $survey_submission->id));

            $submitted_question_obj->question_id = $submitted_que;
            $submitted_question_obj->receiver_name = $survey_submission->customer_name;
            $submitted_question_obj->question_type = $question_obj->question_type;
            $submitted_question_obj->submission_type = $survey_submission->submission_type;
            $submitted_question_obj->submission_ip_address = $survey_submission->submission_ip_address;
            $submitted_question_obj->submission_date = TimeDate::getInstance()->nowDb();
            $submitted_question_obj->schedule_on = $survey_submission->schedule_on;
            $submitted_question_obj->survey_title = $survey->name;
            // To Improve Performance While Exporting report from Survey Report.
            // By Biztech. 
            $submitted_question_obj->submission_id = $survey_submission->id;
            $submitted_question_obj->survey_ID = $survey_id;
            //End
            $submitted_question_obj->reciepient_module = $survey_submission->target_parent_type;

            $submitted_question_obj->name = $question_obj->name;
            $submitted_question_obj->save();
            $submitted_question_obj->load_relationship('bc_survey_submit_question_bc_survey_submission');
            foreach ($submitted_question_obj->bc_survey_submit_question_bc_survey_submission->getBeans() as $submiss) {
                $submitted_question_obj->bc_survey_submit_question_bc_survey_submission->delete($submitted_question_obj->id, $submiss->id);
            }
            $submitted_question_obj->bc_survey_submit_question_bc_survey_submission->add($survey_submission->id);
            $GLOBALS['log']->fatal('This is the $submitted_question_obj id : ----------------------------- ', print_r($submitted_question_obj->id, 1));
            // delete all previous answers stored
            $submitted_question_obj->load_relationship('bc_survey_submit_question_bc_survey_answers');
            foreach ($submitted_question_obj->bc_survey_submit_question_bc_survey_answers->getBeans() as $answers) {
                $submitted_question_obj->bc_survey_submit_question_bc_survey_answers->delete($submitted_question_obj->id, $answers->id);
            }
            $submitted_question_obj->load_relationship('bc_survey_questions_bc_survey_submit_question_1');
            foreach ($submitted_question_obj->bc_survey_questions_bc_survey_submit_question_1->getBeans() as $surQue) {
                $submitted_question_obj->bc_survey_questions_bc_survey_submit_question_1->delete($submitted_question_obj->id, $surQue->id);
            }
            $submitted_question_obj->bc_survey_questions_bc_survey_submit_question_1->add($submitted_que);
            // END *************************************************************//

            if (in_array($question_obj->id, $manage_que_type)) {
                $delete_flag++;
            } else {
                $delete_flag = 0;
            }
            // Update and Insert answer on each submission.
            if ($isOpenSurveyLink) {
                $survey_receiverID = $survey_submission->customer_name;
            } else {
                $survey_receiverID = $module_id;
            }
            submitSurveyResponseCalulation($submitted_ans, $survey_id, $survey_receiverID, $question_obj->question_type, $submisstion_id, $delete_flag, $submitted_que, 0, $forcedelete);

            $manage_que_type[] = $question_obj->id;

            // Create Document
            if ((!empty($file) && !empty($filepath)) || (!empty($_REQUEST[$submitted_que . '_attached_file_name']))) {
                // Create Document
                if (empty($file)) {
                    $file = $_REQUEST[$submitted_que . '_attached_file_name'];
                }
                if (isset($_REQUEST[$submitted_que . '_attched_document']) && !empty($_REQUEST[$submitted_que . '_attched_document'])) {
                    $already_attached_document_id = $_REQUEST[$submitted_que . '_attched_document'];
                }
                $gmtdatetime = TimeDate::getInstance()->nowDb();
                $gmtdate = TimeDate::getInstance()->nowDbDate();
                $oDocument = BeanFactory::getBean('Documents');
                if (!empty($already_attached_document_id)) {
                    $oDocument->disable_row_level_security = true;
                    $oDocument->retrieve($already_attached_document_id);
                } else {
                    $oDocument->active_date = $gmtdate;
                    $oDocument->publish_date = $gmtdatetime;
                }
                $oDocument->document_name = 'Survey Submission ' . $question_obj->name;
                $oDocument->revision = (empty($oDocument->revision)) ? "1" : (int) $oDocument->revision + 1;
                $oDocument->last_rev_create_date = $gmtdatetime;
                $oDocument->save();

                if (!empty($file) && !empty($filepath)) {


                    $file_contents_plain = $_REQUEST[$submitted_que . '_file_uploaded_content'];
                    $splitted_content = explode('base64,', $file_contents_plain);
                    $file_type = $splitted_content[0];
                    $coded_content = $splitted_content[1];

                    // Create Document Revision
                    $dr = new DocumentSoap();
                    $document_revision = array('id' => $oDocument->id, 'file' => $coded_content, 'filename' => $file, 'revision' => '1');
                    $document_revision_id = $dr->saveFile($document_revision, true);

                    $DocumentAttached[$document_revision_id] = $oDocument->id;
                }

                $submitted_ans = array($oDocument->id . '_documentID_' . $file);

                // addded for history individual Attachment *************************************************************//
                $submit_details = array();
                if (!empty($submitted_ans)) {
                    $ans_history = $oDocument->id . '_documentID_' . $file;
                } else {
                    $ans_history = '';
                }
                $submit_details['date_entered'] = $gmtdatetime;
                $submit_details['submission_id'] = $survey_submission->id;
                $submit_details['survey_id'] = $survey_id;
                $submit_details['question_id'] = $question_obj->id;
                $submit_details['question_type'] = $question_obj->question_type;
                $submit_details['submitted_answer'] = $ans_history;
                $submit_details['submission_date'] = $gmtdatetime;
                $submit_details['resubmit_count'] = ((int) $survey_submission->resubmit_counter) + 1;
                Save_bc_submission_history_individual($submit_details);
                // END ***************************************************************************************//
            } else if ($question_obj->question_type == 'doc-attachment' && empty($file) && empty($file_path)) {
                if (isset($_REQUEST[$submitted_que . '_removed_attched_document']) && !empty($_REQUEST[$submitted_que . '_removed_attched_document']) && isset($_REQUEST[$submitted_que . '_attched_document']) && !empty($_REQUEST[$submitted_que . '_attched_document'])) {

                    if (isset($_REQUEST[$submitted_que . '_attched_document']) && !empty($_REQUEST[$submitted_que . '_attched_document'])) {
                        $already_attached_document_id = $_REQUEST[$submitted_que . '_attched_document'];
                    }
                    $oDocument = BeanFactory::getBean('Documents');
                    if (!empty($already_attached_document_id)) {
                        $oDocument->disable_row_level_security = true;
                        $oDocument->retrieve($already_attached_document_id);
                        $oDocument->deleted = 1;
                        $oDocument->save();
                    }
                }
            }

            // End
            // check Other option is selected or not
            $allAnswersBean = $question_obj->get_linked_beans('bc_survey_answers_bc_survey_questions', 'bc_survey_answers');
            foreach ($allAnswersBean as $allAns) {
                if ($allAns->answer_type == 'other' && in_array($allAns->id, $submitted_ans)) {
                    $isOtherSelected = true;
                }
            }
            $ansArrForMultAndCheckBoxQues = array();
            $ansIDArrForMultAndCheckBoxQues = array();
            $submitted_ans_matrix = array();
            $submitted_ans = (is_string($submitted_ans)) ? array() : $submitted_ans;
            foreach ($submitted_ans as $sub_ans) {
                //    if ($sub_ans != 'selection_default_value_dropdown') {
                $sub_ans = ($sub_ans != 'selection_default_value_dropdown') ? $sub_ans : '';
                $submission_data = new bc_submission_data();
                $submission_data->save();
                $submission_data->load_relationship('bc_submission_data_bc_survey_submission');
                $submission_data->bc_submission_data_bc_survey_submission->add($survey_submission->id);

                $submission_data->load_relationship('bc_submission_data_bc_survey_questions');
                $submission_data->bc_submission_data_bc_survey_questions->add($submitted_que);


                $pattern = "/^[a-z\d]{8}-[a-z\d]{4}-[a-z\d]{4}-[a-z\d]{4}-[a-z\d]{12}+$/i";
                if (!is_array($sub_ans) && preg_match($pattern, $sub_ans)) {
                    $submitted_weight = 0;
                    // Create new answer for other option
                    $submitted_ans_obj = new bc_survey_answers();
                    $submitted_ans_obj->retrieve($sub_ans);
                    if (empty($submitted_ans_obj->id) && $isOtherSelected) {
                        $submitted_ans_obj = new bc_survey_answers();
                        $submitted_ans_obj->answer_name = $sub_ans;
                        $submitted_ans_obj->name = $sub_ans; // fix for report module support
                        $submitted_ans_obj->save();
                        $sub_ans = $submitted_ans_obj->id;
                    }
                    $submission_data->load_relationship('bc_submission_data_bc_survey_answers');
                    $submission_data->bc_submission_data_bc_survey_answers->add($sub_ans);
                    if (in_array($question_obj->question_type, $multiselectQuesTypeArra)) {
                        $ansArrForMultAndCheckBoxQues[] = $submitted_ans_obj->answer_name;
                        $ansIDArrForMultAndCheckBoxQues[] = $submitted_ans_obj->id;
                    }

                    // addded for report *************************************************************//
                    if (!in_array($question_obj->question_type, $multiselectQuesTypeArra)) {
                        $submitted_question_obj->load_relationship('bc_survey_submit_question_bc_survey_answers');
                        $submitted_question_obj->bc_survey_submit_question_bc_survey_answers->add($sub_ans);
                    }
                    //END *************************************************************//
                    // addded for history individual (Multi Choice Question types) *************************************************************//
                    if (!in_array($question_obj->question_type, $multiselectQuesTypeArra) && $submitted_ans_obj->answer_type != 'other') {
                        $submit_details = array();
                        $submit_details['date_entered'] = $gmtdatetime;
                        $submit_details['submission_id'] = $survey_submission->id;
                        $submit_details['survey_id'] = $survey_id;
                        $submit_details['question_id'] = $question_obj->id;
                        $submit_details['question_type'] = $question_obj->question_type;
                        $submit_details['submitted_answer'] = $sub_ans;
                        $submit_details['submission_date'] = $gmtdatetime;
                        $submit_details['resubmit_count'] = ((int) $survey_submission->resubmit_counter) + 1;
                        Save_bc_submission_history_individual($submit_details);
                    }
                    // END ***************************************************************************************//
                    // if scoring is enabled than calculate each answer weight
                    $submitted_que_obj = new bc_survey_questions();
                    $submitted_que_obj->retrieve($submitted_que);

                    $submitted_ans_obj = new bc_survey_answers();
                    $submitted_ans_obj->retrieve($sub_ans);

                    if (array_key_exists($submitted_que, $survey_answer_prefill)) {
                        if (!empty($answer_to_update[$survey_answer_update_module_field_name[$submitted_que]])) {
                            $answer_to_update[$survey_answer_update_module_field_name[$submitted_que]] = $answer_to_update[$survey_answer_update_module_field_name[$submitted_que]] . ',' . $submitted_ans_obj->answer_name;
                        } else {
                            $answer_to_update[$survey_answer_update_module_field_name[$submitted_que]] = $submitted_ans_obj->answer_name;
                        }
                    }

                    if ($submitted_que_obj->enable_scoring == 1) {
                        $submitted_weight = $submitted_weight + number_format($submitted_ans_obj->score_weight);
                    }
                    //calculte obtained score
                    $obtained_score = $obtained_score + $submitted_weight;
                } else {
                    if ($question_obj->question_type == 'contact-information') {
                        $submitted_ans_obj = new bc_survey_answers();
                        $submitted_ans_obj->answer_name = json_encode($sub_ans, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
                        $submitted_ans_obj->name = json_encode($sub_ans, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); // fix for report module support
                        $submitted_ans_obj->save();
                        $submission_data->load_relationship('bc_submission_data_bc_survey_answers');
                        $submission_data->bc_submission_data_bc_survey_answers->add($submitted_ans_obj->id);

                        // Added Code To DIsplay Contact Type Question In Sugar Report module. By Biztech *************************************************************//
                        $submitted_ans_obj = new bc_survey_answers();
                        $final_ans_ci = '';
                        if (!empty($sub_ans['Name'])) {
                            $final_ans_ci = '(Name) : ' . $sub_ans['Name'] . ' ';
                        }
                        if (!empty($sub_ans['Email Address'])) {
                            $final_ans_ci .= '(Email Address) : ' . $sub_ans['Email Address'] . ', ';
                        }
                        if (!empty($sub_ans['Company'])) {
                            $final_ans_ci .= '(Company) : ' . $sub_ans['Company'] . ' ';
                        }
                        if (!empty($sub_ans['Phone Number'])) {
                            $final_ans_ci .= '(Phone Number) : ' . $sub_ans['Phone Number'] . ', ';
                        }
                        if (!empty($sub_ans['Address'])) {
                            $final_ans_ci .= '(Address) : ' . $sub_ans['Address'] . ', ';
                        }
                        if (!empty($sub_ans['Address2'])) {
                            $final_ans_ci .= '(Address2) : ' . $sub_ans['Address2'] . ', ';
                        }
                        if (!empty($sub_ans['City/Town'])) {
                            $final_ans_ci .= '(City/Town) : ' . $sub_ans['City/Town'] . ', ';
                        }
                        if (!empty($sub_ans['State/Province'])) {
                            $final_ans_ci .= '(State/Province) : ' . $sub_ans['State/Province'] . ', ';
                        }
                        if (!empty($sub_ans['Zip/Postal Code'])) {
                            $final_ans_ci .= '(Zip/Postal Code) : ' . $sub_ans['Zip/Postal Code'] . ', ';
                        }
                        if (!empty($sub_ans['Country'])) {
                            $final_ans_ci .= '(Country) : ' . $sub_ans['Country'] . ' ';
                        }
                        $submitted_ans_obj->answer_name = $final_ans_ci;
                        $submitted_ans_obj->name = $final_ans_ci; // fix for report module support
                        $submitted_ans_obj->save();
                        $submitted_question_obj->load_relationship('bc_survey_submit_question_bc_survey_answers');
                        $submitted_question_obj->bc_survey_submit_question_bc_survey_answers->add($submitted_ans_obj->id);
                        //END *************************************************************//
                        // addded for history individual (Contact Information) *************************************************************//
                        $submit_details = array();
                        $submit_details['date_entered'] = $gmtdatetime;
                        $submit_details['submission_id'] = $survey_submission->id;
                        $submit_details['survey_id'] = $survey_id;
                        $submit_details['question_id'] = $question_obj->id;
                        $submit_details['question_type'] = $question_obj->question_type;
                        $submittedAnsContactArr = array();
                        $contactSubAns = array();
                        foreach ($sub_ans as $name => $val) {
                            $contactSubAns[$name] = html_entity_decode($val);
                        }
                        $answersData = json_encode($contactSubAns, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
                        $submit_details['submitted_answer'] = $answersData;
                        $submit_details['submission_date'] = $gmtdatetime;
                        $submit_details['resubmit_count'] = ((int) $survey_submission->resubmit_counter) + 1;
                        Save_bc_submission_history_individual($submit_details);
                        // END ***************************************************************************************//
                    } else {
                        $submitted_ans_obj = new bc_survey_answers();
                        if (is_array($sub_ans)) {
                            foreach ($sub_ans as $value) {
                                // Added Code To DIsplay Matrix Type Question In Sugar Report module. By Biztech
                                if ($question_obj->question_type == 'matrix') {
                                    // set matrix answer to question array
                                    $matrix_row = json_decode(base64_decode(($question_obj->matrix_row)));
                                    $matrix_col = json_decode(base64_decode(($question_obj->matrix_col)));
                                    $splited_answer = explode('_', $value);
                                    $sp_ans1 = $splited_answer[0];
                                    $sp_ans2 = $splited_answer[1];
                                    $ansFinal = $matrix_row->$sp_ans1 . '(' . $matrix_col->$sp_ans2 . ')';
                                    $submitted_ans_obj = new bc_survey_answers();
                                    $submitted_ans_obj->answer_name = $ansFinal;
                                    $submitted_ans_obj->name = $ansFinal; // fix for report module support
                                    $submitted_ans_obj->description = $value; // fix for global filter
                                    $submitted_ans_obj->save();
                                    // addded for report *************************************************************//
                                    $submitted_question_obj->load_relationship('bc_survey_submit_question_bc_survey_answers');
                                    $submitted_question_obj->bc_survey_submit_question_bc_survey_answers->add($submitted_ans_obj->id);
                                    //END *************************************************************//
                                    if (!empty($value)) {
                                        $submitted_ans_matrix[] = $value;
                                }
                                }
                                // END
                                $ansFinal = $value;
                                $submitted_ans_obj = new bc_survey_answers();
                                $submitted_ans_obj->answer_name = $ansFinal;
                                $submitted_ans_obj->name = $ansFinal; // fix for report module support
                                $submitted_ans_obj->save();
                                $submission_data->load_relationship('bc_submission_data_bc_survey_answers');
                                $submission_data->bc_submission_data_bc_survey_answers->add($submitted_ans_obj->id);

                                if (isset($survey_answer_prefill) && array_key_exists($submitted_que, $survey_answer_prefill)) {
                                    $answer_to_update[$survey_answer_update_module_field_name[$submitted_que]] = $submitted_ans_obj->answer_name;
                                }
                            }
                        } else {
                            $submitted_ans_obj = new bc_survey_answers();
                            $submitted_ans_obj->answer_name = $sub_ans;
                            $submitted_ans_obj->name = $sub_ans; // fix for report module support
                            $submitted_ans_obj->save();
                            $submission_data->load_relationship('bc_submission_data_bc_survey_answers');
                            $submission_data->bc_submission_data_bc_survey_answers->add($submitted_ans_obj->id);

                            // addded for report *************************************************************//
                            if (!empty($sub_ans)) {
                                $submitted_question_obj->load_relationship('bc_survey_submit_question_bc_survey_answers');
                                $submitted_question_obj->bc_survey_submit_question_bc_survey_answers->add($submitted_ans_obj->id);
                            }
                            //END *************************************************************//
                            // addded for history individual (Other type of question : Textbox , Commentbox, Rating, Scale, etc) *************************************************************//
                            if (in_array($question_obj->question_type, $multiselectQuesTypeArra)) {
                                $ansIDArrForMultAndCheckBoxQues[] = $sub_ans; // Other Answer
                            } else {
                            $submit_details = array();
                            $submit_details['date_entered'] = $gmtdatetime;
                            $submit_details['submission_id'] = $survey_submission->id;
                            $submit_details['survey_id'] = $survey_id;
                            $submit_details['question_id'] = $question_obj->id;
                            $submit_details['question_type'] = $question_obj->question_type;
                                $multi_chice_que_types = array('check-box', 'multiselectlist', 'dropdownlist', 'radio-button');
                            $submit_details['submitted_answer'] = $sub_ans;
                            $submit_details['submission_date'] = $gmtdatetime;
                            $submit_details['resubmit_count'] = ((int) $survey_submission->resubmit_counter) + 1;
                            Save_bc_submission_history_individual($submit_details);
                            }
                            // END ***************************************************************************************//
                            if (isset($survey_answer_prefill) && array_key_exists($submitted_que, $survey_answer_prefill)) {
                                $answer_to_update[$survey_answer_update_module_field_name[$submitted_que]] = $submitted_ans_obj->answer_name;
                            }
                        }
                    }
                }
                // }
            }
            if (empty($submitted_ans)) {
                $submit_details = array();
                $submit_details['date_entered'] = $gmtdatetime;
                $submit_details['submission_id'] = $survey_submission->id;
                $submit_details['survey_id'] = $survey_id;
                $submit_details['question_id'] = $question_obj->id;
                $submit_details['question_type'] = $question_obj->question_type;
                $submit_details['submitted_answer'] = ''; // Answer not submitted so store blank answer in history table
                $submit_details['submission_date'] = $gmtdatetime;
                $submit_details['resubmit_count'] = ((int) $survey_submission->resubmit_counter) + 1;
                Save_bc_submission_history_individual($submit_details);
            }
            unset($submitted_ans);
        } else {
            // delete hidden question answer from answer calculation
            $submitted_ans = (isset($_REQUEST[$submitted_que])) ? $_REQUEST[$submitted_que] : '';
            $question_obj = new bc_survey_questions();
            $question_obj->retrieve($submitted_que);

            if (isset($survey_answer_prefill) && array_key_exists($submitted_que, $survey_answer_prefill)) {
                $answer_to_update[$survey_answer_update_module_field_name[$submitted_que]] = $submitted_ans;
            }

            // Update and Insert answer on each submission.
            submitSurveyResponseCalulation($submitted_ans, $survey_id, $module_id, $question_obj->question_type, $submisstion_id, 0, $submitted_que, 1);
        }
        if (in_array($question_obj->question_type, $multiselectQuesTypeArra)) {
            //  if (!empty($ansArrForMultAndCheckBoxQues)) {
                $submitted_ans_obj = new bc_survey_answers();
                $submitted_ans_obj->answer_name = implode(',', $ansArrForMultAndCheckBoxQues);
                $submitted_ans_obj->name = implode(',', $ansArrForMultAndCheckBoxQues); // fix for report module support
                $submitted_ans_obj->description = implode(',', $ansIDArrForMultAndCheckBoxQues); // fix for global filter
                $submitted_ans_obj->save();
                $submitted_question_obj->load_relationship('bc_survey_submit_question_bc_survey_answers');
                $submitted_question_obj->bc_survey_submit_question_bc_survey_answers->add($submitted_ans_obj->id);

            // addded for history individual (Multi Choice Question types) *************************************************************//
            $submit_details = array();
            $submit_details['date_entered'] = $gmtdatetime;
            $submit_details['submission_id'] = $survey_submission->id;
            $submit_details['survey_id'] = $survey_id;
            $submit_details['question_id'] = $question_obj->id;
            $submit_details['question_type'] = $question_obj->question_type;
            $submit_details['submitted_answer'] = implode(',', $ansIDArrForMultAndCheckBoxQues);
            $submit_details['submission_date'] = $gmtdatetime;
            $submit_details['resubmit_count'] = ((int) $survey_submission->resubmit_counter) + 1;
            Save_bc_submission_history_individual($submit_details);
            // END ***************************************************************************************//
            }
        if ($question_obj->question_type == 'matrix') {
            // addded for history individual (Matrix) *************************************************************//
            $submit_details = array();
            $submit_details['date_entered'] = $gmtdatetime;
            $submit_details['submission_id'] = $survey_submission->id;
            $submit_details['survey_id'] = $survey_id;
            $submit_details['question_id'] = $question_obj->id;
            $submit_details['question_type'] = $question_obj->question_type;
            $submit_details['submitted_answer'] = implode(',', $submitted_ans_matrix);
            $submit_details['submission_date'] = $gmtdatetime;
            $submit_details['resubmit_count'] = ((int) $survey_submission->resubmit_counter) + 1;
            Save_bc_submission_history_individual($submit_details);
            // END ***************************************************************************************//
        }
    }
    $GLOBALS['log']->fatal("This is the answer to update : " . print_r($answer_to_update, 1));
    if (!empty($answer_to_update) && $enable_data_piping == 1 && $sync_type == 'create_or_update_records' && !empty($module_type) && !empty($module_id)) {
        // update record 
        if (is_array($answer_to_update)) {
            foreach ($answer_to_update as $field_name => $field_value) {
                // if multi enum
                if ($moduleBeanObj->field_defs[$field_name]['type'] == 'multienum') {
                    // splitted values in array
                    $splitted_values = explode(',', $field_value);
                    // get all options with key
                    $app_list_strings_options = return_app_list_strings_language('en_us');
                    $find_options_array = $app_list_strings_options[$moduleBeanObj->field_defs[$field_name]['options']];
                    $splitted_values_new = array();
                    foreach ($find_options_array as $key => $val) {
                        if (in_array($val, $splitted_values)) {
                            $splitted_values_new[] = $key;
                        }
                    }
                    $splitted_values_new_imploaded = implode(',', $splitted_values_new);
                    $new_value = encodeMultienumValue($splitted_values_new);
                    $moduleBeanObj->$field_name = $new_value;
                }
                // if date field then convert date properly
                else if ($moduleBeanObj->field_defs[$field_name]['type'] == 'date') {
                    $date = date_create($field_value);
                    $new_value = date_format($date, "Y-m-d H:i:s");
                    $new_date_as_format = $timedate->to_display_date_time($new_value, true, false, $user);
                    $new_date = date_create($new_date_as_format);
                    $to_db_date_new = $timedate->asDb($new_date);
                    $date_only_array = explode(' ', $to_db_date_new);
                    $moduleBeanObjNew->$field_name = $date_only_array[0];
                }
                // if datetime field then convert date properly
                else if ($moduleBeanObj->field_defs[$field_name]['type'] == 'datetime' || $moduleBeanObj->field_defs[$field_name]['type'] == 'datetimecombo') {
                    $date = date_create($field_value);
                    $new_value = date_format($date, "Y-m-d H:i:s");
                    $new_date_as_format = $timedate->to_display_date_time($new_value, true, false, $user);
                    $new_date = date_create($new_date_as_format, timezone_open($user->getPreference('timezone', 'global')));
                    $to_db_date_new = $timedate->asDb($new_date);
                    $moduleBeanObj->$field_name = $to_db_date_new;
                } else if ($moduleBeanObj->field_defs[$field_name]['type'] == 'bool') {
                    // check true or not
                    if ($field_value != 'No') {
                        $new_value = 1;
                    } else {
                        $new_value = 0;
                    }
                    $moduleBeanObj->$field_name = $new_value;
                } else {
                    $new_field_value = $field_value;
                    $app_list_strings_options = return_app_list_strings_language('en_us');
                    $find_options_array = $app_list_strings_options[$moduleBeanObj->field_defs[$field_name]['options']];
                    foreach ($find_options_array as $key => $val) {
                        if ($val == $field_value) {
                            $new_field_value = $key;
                        }
                    }
                    $moduleBeanObj->$field_name = $new_field_value;
                }
            }
            $moduleBeanObj->save();
        }
    } else if (!empty($answer_to_update) && $enable_data_piping == 1 && $sync_type == 'create_records' && !empty($sync_module) && !$requestApproved) {
        // create record 
        if (is_array($answer_to_update)) {
            $moduleBeanObjNew = BeanFactory::getBean($sync_module);
            // $moduleBeanObjNew->disable_row_level_security = true;
            foreach ($answer_to_update as $field_name => $field_value) {
                if ($moduleBeanObjNew->field_defs[$field_name]['type'] == 'multienum') {
                    // splitted values in array
                    $splitted_values = explode(',', $field_value);
                    // get all options with key
                    $app_list_strings_options = return_app_list_strings_language('en_us');
                    $find_options_array = $app_list_strings_options[$moduleBeanObjNew->field_defs[$field_name]['options']];
                    $splitted_values_new = array();
                    foreach ($find_options_array as $key => $val) {
                        if (in_array($val, $splitted_values)) {
                            $splitted_values_new[] = $key;
                        }
                    }
                    $splitted_values_new_imploaded = implode(',', $splitted_values_new);
                    $new_value = encodeMultienumValue($splitted_values_new);
                    $moduleBeanObjNew->$field_name = $new_value;
                }
                // if date field then convert date properly
                else if ($moduleBeanObjNew->field_defs[$field_name]['type'] == 'date') {
                    $date = date_create($field_value);
                    $new_value = date_format($date, "Y-m-d H:i:s");
                    $new_date_as_format = $timedate->to_display_date_time($new_value, true, false, $user);

                    $new_date = date_create($new_date_as_format);
                    $to_db_date_new = $timedate->asDb($new_date);
                    $date_only_array = explode(' ', $to_db_date_new);
                    $moduleBeanObjNew->$field_name = $date_only_array[0];
                }
                // if datetime field then convert date properly
                else if ($moduleBeanObjNew->field_defs[$field_name]['type'] == 'datetime' || $moduleBeanObjNew->field_defs[$field_name]['type'] == 'datetimecombo') {
                    $date = date_create($field_value);
                    $new_value = date_format($date, "Y-m-d H:i:s");
                    $new_date_as_format = $timedate->to_display_date_time($new_value, true, false, $user);

                    $new_date = date_create($new_date_as_format, timezone_open($user->getPreference('timezone', 'global')));
                    $to_db_date_new = $timedate->asDb($new_date);
                    $moduleBeanObjNew->$field_name = $to_db_date_new;
                } else if ($moduleBeanObjNew->field_defs[$field_name]['type'] == 'multienum') {
                    $splitted_values = explode(',', $field_value);
                    $new_value = encodeMultienumValue($splitted_values);
                    $moduleBeanObjNew->$field_name = $new_values;
                } else if ($moduleBeanObjNew->field_defs[$field_name]['type'] == 'bool') {
                    // check true or not
                    if ($field_value != 'No') {
                        $new_value = 1;
                    } else {
                        $new_value = 0;
                    }
                    $moduleBeanObjNew->$field_name = $new_value;
                } else {
                    $new_field_value = $field_value;
                    $app_list_strings_options = return_app_list_strings_language('en_us');
                    $find_options_array = $app_list_strings_options[$moduleBeanObjNew->field_defs[$field_name]['options']];
                    foreach ($find_options_array as $key => $val) {
                        if ($val == $field_value) {
                            $new_field_value = $key;
                        }
                    }

                    $moduleBeanObjNew->$field_name = $new_field_value;
                }
            }
            $moduleBeanObjNew->save();
            $survey_submission->new_record_id = $moduleBeanObjNew->id;
        }
    } else if (!empty($answer_to_update) && $enable_data_piping == 1 && $sync_type == 'create_records' && !empty($sync_module) && $requestApproved) {
        // update record 
        if (is_array($answer_to_update)) {
            $moduleBeanObjNew = BeanFactory::getBean($sync_module);
            $moduleBeanObjNew->disable_row_level_security = true;
            $moduleBeanObjNew->retrieve($survey_submission->new_record_id);

            foreach ($answer_to_update as $field_name => $field_value) {
                if ($moduleBeanObjNew->field_defs[$field_name]['type'] == 'multienum') {
                    // splitted values in array
                    $splitted_values = explode(',', $field_value);
                    // get all options with key
                    $app_list_strings_options = return_app_list_strings_language('en_us');
                    $find_options_array = $app_list_strings_options[$moduleBeanObjNew->field_defs[$field_name]['options']];
                    $splitted_values_new = array();
                    foreach ($find_options_array as $key => $val) {
                        if (in_array($val, $splitted_values)) {
                            $splitted_values_new[] = $key;
                        }
                    }
                    $splitted_values_new_imploaded = implode(',', $splitted_values_new);
                    $new_value = encodeMultienumValue($splitted_values_new);
                    $moduleBeanObjNew->$field_name = $new_value;
                }
                // if date field then convert date properly
                else if ($moduleBeanObjNew->field_defs[$field_name]['type'] == 'date') {
                    $date = date_create($field_value);
                    $new_value = date_format($date, "Y-m-d H:i:s");
                    $new_date_as_format = $timedate->to_display_date_time($new_value, true, false, $user);

                    $new_date = date_create($new_date_as_format);
                    $to_db_date_new = $timedate->asDb($new_date);
                    $date_only_array = explode(' ', $to_db_date_new);
                    $moduleBeanObjNew->$field_name = $date_only_array[0];
                }
                // if datetime field then convert date properly
                else if ($moduleBeanObjNew->field_defs[$field_name]['type'] == 'datetime' || $moduleBeanObjNew->field_defs[$field_name]['type'] == 'datetimecombo') {
                    $date = date_create($field_value);
                    $new_value = date_format($date, "Y-m-d H:i:s");
                    $new_date_as_format = $timedate->to_display_date_time($new_value, true, false, $user);
                    $new_date = date_create($new_date_as_format, timezone_open($user->getPreference('timezone', 'global')));
                    $to_db_date_new = $timedate->asDb($new_date);
                    $moduleBeanObjNew->$field_name = $to_db_date_new;
                } else if ($moduleBeanObjNew->field_defs[$field_name]['type'] == 'bool') {
                    // check true or not
                    if ($field_value != 'No') {
                        $new_value = 1;
                    } else {
                        $new_value = 0;
                    }
                    $moduleBeanObjNew->$field_name = $new_value;
                } else {
                    $new_field_value = $field_value;
                    $app_list_strings_options = return_app_list_strings_language('en_us');
                    $find_options_array = $app_list_strings_options[$moduleBeanObjNew->field_defs[$field_name]['options']];
                    foreach ($find_options_array as $key => $val) {
                        if ($val == $field_value) {
                            $new_field_value = $key;
                        }
                    }

                    $moduleBeanObjNew->$field_name = $new_field_value;
                }
            }
            $moduleBeanObjNew->save();
            $survey_submission->new_record_id = $moduleBeanObjNew->id;
        }
    } else if (!empty($answer_to_update) && $enable_data_piping == 1 && !empty($sync_module)) {
        // create record 
        if (is_array($answer_to_update)) {
            $moduleBeanObjNew = BeanFactory::getBean($sync_module);

            //    $moduleBeanObjNew->disable_row_level_security = true;
            foreach ($answer_to_update as $field_name => $field_value) {
                if ($moduleBeanObjNew->field_defs[$field_name]['type'] == 'multienum') {
                    // splitted values in array
                    $splitted_values = explode(',', $field_value);
                    // get all options with key
                    $app_list_strings_options = return_app_list_strings_language('en_us');
                    $find_options_array = $app_list_strings_options[$moduleBeanObjNew->field_defs[$field_name]['options']];
                    $splitted_values_new = array();
                    foreach ($find_options_array as $key => $val) {
                        if (in_array($val, $splitted_values)) {
                            $splitted_values_new[] = $key;
                        }
                    }
                    $splitted_values_new_imploaded = implode(',', $splitted_values_new);
                    $new_value = encodeMultienumValue($splitted_values_new);
                    $moduleBeanObjNew->$field_name = $new_value;
                }
                // if date field then convert date properly
                else if ($moduleBeanObjNew->field_defs[$field_name]['type'] == 'date') {
                    $date = date_create($field_value);
                    $new_value = date_format($date, "Y-m-d H:i:s");
                    $new_date_as_format = $timedate->to_display_date_time($new_value, true, false, $user);

                    $new_date = date_create($new_date_as_format);
                    $to_db_date_new = $timedate->asDb($new_date);
                    $date_only_array = explode(' ', $to_db_date_new);
                    $moduleBeanObjNew->$field_name = $date_only_array[0];
                }
                // if datetime field then convert date properly
                else if ($moduleBeanObjNew->field_defs[$field_name]['type'] == 'datetime' || $moduleBeanObjNew->field_defs[$field_name]['type'] == 'datetimecombo') {
                    $date = date_create($field_value);
                    $new_value = date_format($date, "Y-m-d H:i:s");
                    $new_date_as_format = $timedate->to_display_date_time($new_value, true, false, $user);
                    $new_date = date_create($new_date_as_format, timezone_open($user->getPreference('timezone', 'global')));
                    $to_db_date_new = $timedate->asDb($new_date);
                    $moduleBeanObjNew->$field_name = $to_db_date_new;
                } else if ($moduleBeanObjNew->field_defs[$field_name]['type'] == 'bool') {
                    // check true or not
                    if ($field_value != 'No') {
                        $new_value = 1;
                    } else {
                        $new_value = 0;
                    }
                    $moduleBeanObjNew->$field_name = $new_value;
                } else {
                    $new_field_value = $field_value;
                    $app_list_strings_options = return_app_list_strings_language('en_us');
                    $find_options_array = $app_list_strings_options[$moduleBeanObjNew->field_defs[$field_name]['options']];
                    foreach ($find_options_array as $key => $val) {
                        if ($val == $field_value) {
                            $new_field_value = $key;
                        }
                    }

                    $moduleBeanObjNew->$field_name = $new_field_value;
                }
            }
            $moduleBeanObjNew->save();
            $survey_submission->new_record_id = $moduleBeanObjNew->id;
        }
    }

    if ($isOpenSurveyLink && !empty($moduleBeanObjNew->id)) {
        // Link newly created module with survey submission when submitted via Web link
        $survey_submission->target_parent_id = $moduleBeanObjNew->id;
        $survey_submission->target_parent_type = $moduleBeanObjNew->module_name;
        $survey_submission->parent_id = $moduleBeanObjNew->id;
        $survey_submission->parent_type = $moduleBeanObjNew->module_name;
    }


    // Relate Document with Specified module
    if (isset($DocumentAttached) && !empty($DocumentAttached)) {
        foreach ($DocumentAttached as $doc_rev_id => $document_id) {
            $matchDocumentRelationship = false;
            // If data piping is enabled and will create new record then attach doc with that newly created record
            if (!empty($moduleBeanObjNew->id)) {
                foreach ($moduleBeanObjNew->field_defs as $field) {

                    // If focus module having relationship with docuemnt
                    if ($field['module'] == 'Documents' || $field['name'] == 'documents') {

                        $relationship_name = $field['name']; // relation ship name for submission
                        $moduleBeanObjNew->load_relationship($relationship_name);
                        $moduleBeanObjNew->$relationship_name->add($document_id);
                        $matchDocumentRelationship = true;

                        // Add Document assigned to user
                        $oDocumentRe = BeanFactory::getBean('Documents', $document_id);
                        $oDocumentRe->last_rev_created_name = !empty($moduleBeanObjNew->assigned_user_id) ? $moduleBeanObjNew->assigned_user_id : $survey->assigned_user_id;
                        $oDocumentRe->assigned_user_id = !empty($moduleBeanObjNew->assigned_user_id) ? $moduleBeanObjNew->assigned_user_id : $survey->assigned_user_id;
                        $oDocumentRe->save();

                        $revision = new DocumentRevision();
                        $revision->retrieve($doc_rev_id);
                        $revision->created_by = !empty($moduleBeanObjNew->assigned_user_id) ? $moduleBeanObjNew->assigned_user_id : $survey->assigned_user_id;
                        $revision->save();
                    }
                }
            }
            // If Email send or Data Piping used to update same sending record than attach doc to that module
            else if (!empty($module_id) && !empty($module_type)) {
                $moduleFocus = BeanFactory::getBean($module_type);
                $moduleFocus->disable_row_level_security = true;
                $moduleFocus->retrieve($module_id);
                foreach ($moduleFocus->field_defs as $field) {

                    // If focus module having relationship with docuemnt
                    if ($field['module'] == 'Documents' || $field['name'] == 'documents') {

                        $relationship_name = $field['name']; // relation ship name for submission
                        $moduleFocus->load_relationship($relationship_name);
                        $moduleFocus->$relationship_name->add($document_id);
                        $matchDocumentRelationship = true;

                        // Add Document assigned to user
                        $oDocumentRe = BeanFactory::getBean('Documents', $document_id);
                        $oDocumentRe->last_rev_created_name = !empty($moduleBeanObjNew->assigned_user_id) ? $moduleBeanObjNew->assigned_user_id : $survey->assigned_user_id;
                        $oDocumentRe->assigned_user_id = !empty($moduleBeanObjNew->assigned_user_id) ? $moduleBeanObjNew->assigned_user_id : $survey->assigned_user_id;
                        $oDocumentRe->save();

                        $revision = new DocumentRevision();
                        $revision->retrieve($doc_rev_id);
                        $revision->created_by = !empty($moduleBeanObjNew->assigned_user_id) ? $moduleBeanObjNew->assigned_user_id : $survey->assigned_user_id;
                        $revision->save();
                    }
                }
            }
            // if no any module found than attach doc with Survey Submission
            else {
                $matchDocumentRelationship = false;
            }

            // If not found any document relationship then attach doc with survey submission
            if ($matchDocumentRelationship == false) {
                foreach ($survey_submission->field_defs as $field) {

                    // If focus module having relationship with docuemnt
                    if ((isset($field['module']) && $field['module'] == 'Documents') || $field['name'] == 'documents') {

                        // Add Document assigned to user
                        $oDocumentRe = BeanFactory::getBean('Documents', $document_id);
                        $oDocumentRe->last_rev_created_name = $survey->assigned_user_id;
                        $oDocumentRe->assigned_user_id = $survey->assigned_user_id;
                        $oDocumentRe->save();

                        $revision = new DocumentRevision();
                        $revision->retrieve($doc_rev_id);
                        $revision->created_by = $survey->assigned_user_id;
                        $revision->save();

                        $relationship_name = $field['name']; // relation ship name for submission
                        $survey_submission->load_relationship($relationship_name);
                        $survey_submission->$relationship_name->add($document_id);
                    }
                }
            }
        }
    }

    if (!empty($survey->survey_thanks_page) && $survey->survey_thanks_page != '&lt;p&gt;&lt;br data-mce-bogus=&quot;1&quot;&gt;&lt;/p&gt;' && $survey->survey_thanks_page != '&lt;p&gt;&amp;nbsp;&lt;br&gt;&lt;/p&gt;') {
        $isSumitted = true;
        if (!empty($list_lang_detail) && !empty($list_lang_detail['survey_thanks_page'])) {
            $thanks_content = base64_decode($list_lang_detail['survey_thanks_page']);
        } else {
            $thanks_content = $survey->survey_thanks_page;
        }
        $msg .= '<div class="container">
                            <div class="survey-form form-desc">';
        $msg .= '     <div class="form-body thanks-page" style="margin-top:20px; margin-bottom:20px;">' . html_entity_decode_utf8($thanks_content) . '</div>';

        $msg .= '   </div>
                          </div>';
        if ($survey->footer_content != "") {
            $msg .= '<div class="survey-footer">';
            $msg .= '     <center>' . html_entity_decode($survey->footer_content) . '</center>';
            $msg .= '</div>';
        }
    } else if ($survey->enable_review_mail && !$isOpenSurveyLink) {
        $success_submit_msg = 'Your response has been submitted successfully and summary email sent to your email address.';
        if (!empty($list_lang_detail) && $list_lang_detail['success_submit_msg'] != '') {
            $success_submit_msg = $list_lang_detail['success_submit_msg'];
        }
        $msg = " <div class='success_msg'>{$success_submit_msg}</div>";
    } else {
        $email_success_submit_msg = 'Your response has been submitted successfully.';
        if (!empty($list_lang_detail) && $list_lang_detail['email_success_submit_msg'] != '') {
            $email_success_submit_msg = $list_lang_detail['email_success_submit_msg'];
        }
        $msg = " <div class='success_msg'>{$email_success_submit_msg}</div>";
    }
    $redirect_flag = true;
    if ($_REQUEST['redirect_action'] != '') {
        $redirect_url = $_REQUEST['redirect_action'];
    }
    $resubmit_counter = ((int) $survey_submission->resubmit_counter) + 1;

    $gmtdatetime = TimeDate::getInstance()->nowDb();
    // Update Record in Survey Submission Module
    if ($survey->allow_redundant_answers != 1 && !$isOpenSurveyLink) {
        $survey_submission->resubmit = 0;
        $survey_submission->resend = 0;
    } else if (!$isOpenSurveyLink) {
        $survey_submission->resubmit = 0;
        $survey_submission->resend = 0;
    }
    $survey_submission->resubmit_counter = $resubmit_counter;
    $survey_submission->status = 'Submitted';
    $survey_submission->submitted_by = $submitted_by;
    $survey_submission->submission_date = $gmtdatetime;
    $survey_submission->survey_trackdatetime = $survey_submission->survey_trackdatetime_temp;
    $survey_submission->submission_language = $selected_lang;

    // Consent accepted or not
    $survey_submission->consent_accepted = (isset($_REQUEST['consent_accepted']) && $_REQUEST['consent_accepted'] == "on") ? 1 : 0;

    //update obtained score
    $survey_submission->obtained_score = $obtained_score;
    $base_score = $survey_submission->base_score;
    if ($base_score != 0) {
        $obtScorePer = $obtained_score * 100 / $base_score;
    } else {
        $obtScorePer = 0;
    }

    if (empty($obtScorePer)) {
        $obtained_perc = 0;
    } else {
        $obtained_perc = $obtScorePer;
    }
    $survey_submission->score_percentage = $obtained_perc;

    $survey_submission->save();

    // Send Thanks mail to Customer
    if ($survey->enable_review_mail && !$isOpenSurveyLink) {

        // Review mail content
        $mail_content_custom = $survey->review_mail_content;
        if (!empty($list_lang_detail) && !empty($list_lang_detail['review_mail_content'])) {
            $mail_content_custom = base64_decode($list_lang_detail['review_mail_content']);
        }


        $q = "SELECT ea.email_address FROM email_addresses ea
               LEFT JOIN email_addr_bean_rel ear ON ea.id = ear.email_address_id
               WHERE ear.bean_module = '" . $module_type . "'
               AND ear.bean_id = '" . $module_id . "'
               AND ear.deleted = 0
               AND ea.invalid_email = 0
               ORDER BY ear.primary_address DESC";
        $r = $db->limitQuery($q, 0, 1);
        $a = $db->fetchByAssoc($r);

        if (isset($a['email_address'])) {
            $email_address = $a['email_address'];
        }

        $name = $survey_submission->customer_name;

        $subject = "Reviewed your Survey for Improved Service";
        $survey_data = array();

        $survey_data = getPerson_SubmissionData($survey_id, $module_id, $module_type, $survey_submission);
        // if recipient submitted the survey then mail content will be as following
        if ($submitted_by == 'receipient') {
            $html = "Dear {$name},<br><br>" . $mail_content_custom;
        }
        // if sender submitted the survey then mail content will be as following
        else {
            $html = "Dear {$name},<br><br>
                     Admin has successfully submitted the " . ucfirst($survey->survey_type) . " on behalf of you.<br>
                     
                    We’ve taken into account your concerns submitted with this " . ucfirst($survey->survey_type) . ".<br>

                    This will help us serve you better in future! <br><br>

                    Thank you once again for your time and efforts!<br>";
        }
        $survey_name = !empty($list_lang_detail[$survey_id . '_survey_title']) ? $list_lang_detail[$survey_id . '_survey_title'] : $survey->name;
        $html .= "<br>
<!DOCTYPE html>
<html lang='en' xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>
<head>

    <!-- CSS Reset : BEGIN -->
    <style>

        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important; font-family: calibri, Arial, Helvetica, sans-serif; font-size: 17px;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*='margin: 16px 0'] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        table table table {
            table-layout: auto;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode:bicubic;
        }
        img {max-width: 100%;height: auto; margin: 0 auto; }
       p {margin-bottom: 15px; margin-top: 10px; }

        /* What it does: A work-around for email clients meddling in triggered links. */
        *[x-apple-data-detectors],  /* iOS */
        .x-gmail-data-detectors,    /* Gmail */
        .x-gmail-data-detectors *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }
        table.footer-content {
          margin: initial !important;
        }
        /* What it does: Prevents Gmail from displaying an download button on large, non-linked images. */
        .a6S {
           display: none !important;
           opacity: 0.01 !important;
       }
       /* If the above doesn't work, add a .g-img class to any image in question. */
       img.g-img + div {
           display: none !important;
       }

       /* What it does: Prevents underlining the button text in Windows 10 */
        .button-link {
            text-decoration: none !important;
        }

        .search-btn{background: url('http://g.indiaondesk.com/appjetty/mailer/search-btn.png') no-repeat scroll 0% 0%; border: none; position: absolute; top: 10px; width: 24px; left: 75%; height: 24px;}

        #search{ background: url('http://g.indiaondesk.com/appjetty/mailer/search-back.jpg') no-repeat scroll 0% 0%; border: none; width: 485px; height: 42px; padding-left: 10px;}
           
           .client-query-data div:nth-child(odd) {
                 background: #f1fcff;padding: 20px 30px;
            }

            .client-query-data div:nth-child(even) {
                background: #f8fff2;padding: 20px 30px 20px 60px; margin-bottom: 15px; margin-top: 15px;
            }


        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
        /* Create one of these media queries for each additional viewport size you'd like to fix */
        /* Thanks to Eric Lepetit (@ericlepetitsf) for help troubleshooting */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) { /* iPhone 6 and 6+ */
            .email-container {
                min-width: 375px !important;
            }
        }

        @media screen and (max-width: 480px) {
            /* What it does: Forces Gmail app to display email full width */
            u ~ div .email-container {
                min-width: 100vw;
                width: 100% !important;
            }
        }
         
    </style>
    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
    <style>

        /* What it does: Hover styles for buttons */
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover,
        .button-a:hover {
            /*background: #555555 !important;
            border-color: #555555 !important;*/
        }

        /* Media Queries */
        @media screen and (max-width: 650px) {

            .email-container {
                width: 100% !important;
                margin: auto !important;
            }
            
            table.footer-content {
             margin: auto !important;
        }
            .search-btn{ left: 250px;background-size: contain; max-width: 15px; top:5px;}


            /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
            .fluid {
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            /* What it does: Forces table cells into full-width rows. */
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;
            }

            /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }
            table.center-on-narrow {
                display: inline-block !important;
            }

            /* What it does: Adjust typography on small screens to improve readability */
           .email-container p, .email-container div, .email-container li a, .email-container a, .email-container li, .email-container td {
                font-size: 17px !important; line-height: 23px;
            }

            #search{background-size: contain; line-height: 23px; width: 100%; height: auto; }

            .email-container.footer p, .email-container.footer div, .email-container.footer li a, .email-container.footer a, .email-container.footer li, .email-container.footer td {  font-size: 13px !important; margin-top: 1px !important; margin-bottom: 1px !important; line-height: 20px !important}
        }


          @media screen and (max-width: 360px) {
            
            .email-container p, .email-container div, .email-container li a, .email-container a, .email-container li, .email-container td {
                font-size: 17px !important; line-height: 23px;
            }

             .email-container.footer p, .email-container.footer div, .email-container.footer li a, .email-container.footer a, .email-container.footer li, .email-container.footer td {  font-size: 13px !important; margin-top: 1px !important; margin-bottom: 1px !important; line-height: 20px !important}

           } 

    </style>
    <!-- Progressive Enhancements : END -->

    <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->

</head>            
<body style='margin: 0; mso-line-height-rule: exactly;'>
            <center style='width: 100%; background: #f5f5f5; text-align: left;'>
                
                <!-- Email Header : BEGIN -->
                    <table role='presentation' cellspacing='0' cellpadding='0' border='0' align='center' width='650' style='margin: auto;' class='email-container new-ticket'>
                    <tr>
                            <td style='text-align: center; font-family: calibri, Arial, Helvetica, sans-serif;
                                background-color: #5491d5;
                                padding-top: 30px;
                                padding-bottom: 30px;
                                color: #fff;
                                font-size: 30px;'>
                                {$survey_name}
                            </td>
                                        </tr>
                                    </table>
                <!-- Email Header : END -->

                <!-- Email Body : BEGIN -->
                    <table role='presentation' cellspacing='0' cellpadding='0' border='0' align='center' width='650' style='margin: auto;' class='email-container ticket-comp'><tbody>";



        foreach ($survey_data as $que_id => $que_title) {
            if (in_array($que_id, $showedQuestions)) {
                // Avoid display richtext box question type content in review email. By GSR
                if (!in_array($que_id, $richTextTypeQueID)) {
                    $matrix_answer_array = array();
                    foreach ($que_title as $title => $answers) {
                        $is_matrix = false;
                        // Initialize counter - count number of rows & columns
                        $row_count = 1;
                        $col_count = 1;
                        $rows = $answers['matrix_rows'];
                        $cols = $answers['matrix_cols'];
                        if (!empty($list_lang_detail) && !empty($list_lang_detail[$que_id . '_matrix_row1'])) {
                            foreach ($rows as $key => $row) {
                                $rows->$key = $list_lang_detail[$que_id . '_matrix_row' . $key];
                            }

                            foreach ($cols as $key => $col) {
                                $cols->$key = $list_lang_detail[$que_id . '_matrix_col' . $key];
                            }
                        }

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
                        $width = 100 / ($col_count + 1) . "%";

                        // Question title Language wise
                        $que_title = (!empty($list_lang_detail[$que_id . '_que_title'])) ? $list_lang_detail[$que_id . '_que_title'] : $title;
                        $html .= "<tr>
                            <td style='padding:20px 0px 10px' valign='top' align='left'>
                                <table style='padding:0px;margin:0px;font-family:Calibri,Arial;background-color:#f7fafe;border:1px solid #e5e5e5;border-collapse:collapse; table-layout: auto !important;' width='100%' cellspacing='0' cellpadding='0' border='1' bgcolor='#fff'>
                            <tbody>
                                <tr>
                                            <td style='margin:0 0 8px 0;padding:5px;font-size:15px;color:#808080;border:1px solid #e5e5e5;background-color:#ececec' width='110'><strong>Question:</strong></td>
                                            <td style='margin:0 0 8px 0;padding:5px;font-size:14px;color:#808080;border:1px solid #e5e5e5;background-color:#ececec'>{$que_title}</td>
                                </tr>";
                        foreach ($answers as $key => $answer) {
                            if ($key != 'matrix_rows' && $key != 'matrix_cols' && $key != 'answer_detail' && $key != 'nps' && $key != 'nps_value' && $key != 'emojis_val') {
                                $ans_count = count($answer);
                                if (is_array($answer)) {
                                    $html .= "<td width='110' style='margin:0 0 8px 0; padding:5px; font-size:15px; color:#808080; border:1px solid #e5e5e5;background-color: #ececec;background-color: #f3f3f3;' ><strong>Answer:</strong></td>
                              <td colspan='{$ans_count}' style='margin:0 0 8px 0; padding:5px; font-size:14px; color:#808080; border:1px solid #e5e5e5;background-color: #f3f3f3;'>
                                <table width='100%' cellspacing='0' cellpadding='0' border='1' bgcolor='#fff' style='padding: 0px; margin: 0px; font-family: Calibri,Arial; background-color: #f7fafe; border:1px solid #e5e5e5; border-collapse:collapse; '>
                                    <tbody>";
                                    foreach ($answer as $ans_label => $ans) {
                                        if ($ans != 'is_other_option') {
                                            if ($ans_label == 'Address') {
                                                $ans_label = 'Street1';
                                            } else if ($ans_label == 'Address2') {
                                                $ans_label = 'Street2';
                                            }

                                            $ans = (!empty($list_lang_detail[$key])) ? $list_lang_detail[$key] : $ans;


                                            $submitted_ans = $ans != '' ? $ans : 'N/A';
                                            $html .= "<tr>
                                        <td width='150' style='margin:0 0 8px 0; padding:5px; font-size:15px; color:#808080; border:1px solid #e5e5e5;background-color: #f3f3f3;' ><strong>{$ans_label}</strong></td>
                                        <td style='margin:0 0 8px 0; padding:5px; font-size:14px; color:#808080; border:1px solid #e5e5e5;background-color: #f3f3f3;'>{$submitted_ans}</td>
                                      </tr>";
                                        }
                                    }
                                    $html .= "</tbody>
                                    </table>
                                </td>";
                                } else {
                                    if ($answer != 'is_other_option') {
                                        $answer = (!empty($list_lang_detail[$key])) ? $list_lang_detail[$key] : $answer;
                                        $submitted_answer = $answer != '' ? nl2br($answer) : 'N/A';
                                        $oQuestionRetrieve = BeanFactory::getBean('bc_survey_questions', $que_id);
                                        if (!empty($answer) && $oQuestionRetrieve->question_type == 'doc-attachment') {
                                            $splitted_answer = explode('_documentID_', $answer);
                                            $submitted_answer = $splitted_answer[1];
                                        }
                                        $html .= "<tr>
                                            <td colspan='{$ans_count}' style='margin:0 0 8px 0;padding:5px;font-size:15px;color:#808080;border:1px solid #e5e5e5;background-color:#f3f3f3' width='110'><strong>Answer:</strong></td>
                                            <td style='margin:0 0 8px 0;padding:5px;font-size:14px;color:#808080;border:1px solid #e5e5e5;background-color:#f3f3f3'>{$submitted_answer}</td>
                                                  </tr>";
                                    }
                                }
                            } else if ($key == 'answer_detail') {
                                $is_matrix = true;
                                foreach ($answer as $ans_label => $ans) {
                                    foreach ($ans as $k => $selAns) {
                                        $matrix_answer_array[] = $selAns;
                                    }
                                }
                            } else if ($key == 'nps_value') {
                                $nps_data = '';
                                $nps_values = 0;
                                $ans_count = count($answer);
                                if (is_array($answer)) {
                                    $html .= "<td width='110' style='margin:0 0 8px 0; padding:5px; font-size:15px; color:#808080; border:1px solid #e5e5e5;background-color: #ececec;background-color: #f3f3f3;' ><strong>Answer:</strong></td>
                              <td colspan='{$ans_count}' style='margin:0 0 8px 0; padding:5px; font-size:14px; color:#808080; border:1px solid #e5e5e5;background-color: #f3f3f3;'>
                                <table width='100%' cellspacing='0' cellpadding='0' border='1' bgcolor='#fff' style='padding: 0px; margin: 0px; font-family: Calibri,Arial; background-color: #f7fafe; border:1px solid #e5e5e5; border-collapse:collapse; '>
                                    <tbody><tr>";
                                    foreach ($answer as $answer_key => $answer_value) {
                                        for ($nps_values = 0; $nps_values <= 10; $nps_values++) {
                                            if ($nps_values >= 0 && $nps_values < 7) {
                                                if ((int) $answer_value === $nps_values && !empty($answer_value)) {
                                                    $html .= "<th style='background-color:#a1cbff;border:2px solid black;height:30px;width:20px;'>{$nps_values}</th> ";
                                                } else {
                                                    $html .= "<th style='background-color:#ff5353;height:30px;width:20px;'>{$nps_values}</th> ";
                                                }
                                            } else if ($nps_values > 6 && $nps_values < 9) {
                                                if ((int) $answer_value === $nps_values && !empty($answer_value)) {
                                                    $html .= "<th style='background-color:#a1cbff;border:2px solid black;height:30px;width:20px;'>{$nps_values}</th>";
                                                } else {
                                                    $html .= "<th style='background-color:#e9e817;height:30px;width:20px;'>{$nps_values}</th>";
                                                }
                                            } else if ((int) $nps_values >= 8 && $nps_values < 11) {
                                                if ($answer_value === $nps_values && !empty($answer_value)) {
                                                    $html .= "<th  style='background-color:#a1cbff;border:2px solid black;height:30px;width:20px;'>{$nps_values}</th>";
                                                } else {
                                                    $html .= "<th style='background-color:#92d51a;height:30px;width:20px;'> {$nps_values}</th>";
                                                }
                                            }
                                        }
                                    }


                                    $html .= "</tr></tbody>
                                    </table>
                                </td>";
                                }
                            } else if ($key == 'emojis_val') {
                                global $sugar_config;
                                $baseUrl = $sugar_config['site_url'];
                                $emojisImges = array(
                                    1 => $baseUrl . "/custom/include/images/ext-unsatisfy.png",
                                    2 => $baseUrl . "/custom/include/images/unsatisfy.png",
                                    3 => $baseUrl . "/custom/include/images/nuteral.png",
                                    4 => $baseUrl . "/custom/include/images/satisfy.png",
                                    5 => $baseUrl . "/custom/include/images/ext-satisfy.png",
                                );
                                $html .= "<td width='110' style='margin:0 0 8px 0; padding:5px; font-size:15px; color:#808080; border:1px solid #e5e5e5;background-color: #ececec;background-color: #f3f3f3;' ><strong>Answer:</strong></td>
                              <td colspan='{$ans_count}' style='margin:0 0 8px 0; padding:5px; font-size:14px; color:#808080; border:1px solid #e5e5e5;background-color: #f3f3f3;'>
                                <table width='100%' cellspacing='0' cellpadding='0' border='1' bgcolor='#fff' style='padding: 0px; margin: 0px; font-family: Calibri,Arial; background-color: #f3f3f3; border:none; border-collapse:collapse; '>
                                    <tbody><tr>";
                                if (!empty($answer) && $answer['emojis_ans_text'] != null) {
                                    $html .= "<td><img width='20px' height='20px' style='vertical-align: middle;' src='{$emojisImges[$answer['emojis_ans_seq']]}' >  {$answer['emojis_ans_text']}</td>";
                                } else {
                                    $html .= "<td>N/A</td>";
                                }
                                $html .= "</tr></tbody></table></td>";
                            }
                        }
                        if ($is_matrix) {
                            $matrix_html .= '<td width="110" style="margin:0 0 8px 0; padding:5px; font-size:15px; color:#808080; border:1px solid #e5e5e5;background-color: #ececec;"><strong>Answer : </td><td></strong><table style="padding: 0px; margin:0px 0px 0px 0px !important; font-family: Calibri,Arial; background-color: #f7fafe; border:1px solid #e5e5e5; border-collapse:collapse; ">';
                            for ($i = 1; $i <= $row_count; $i++) {
                                $matrix_html .= '<tr>';
                                for ($j = 1; $j <= $col_count + 1; $j++) {
                                    $row = $i - 1;
                                    $col = $j - 1;
                                    //First row & first column as blank
                                    if ($j == 1 && $i == 1) {
                                        $matrix_html .= "<td class='matrix-span' style='width:" . $width . ";padding:5px;'>&nbsp;</td>";
                                    }
                                    // Rows Label
                                    else if ($j == 1 && $i != 1) {
                                        $matrix_html .= "<td class='matrix-span {$que_id}' value='{$row}' style='font-weight:bold;color: #808080; width:" . $width . ";text-align:left;padding:5px;'>" . $rows->$row . "</td>";
                                    } else {
                                        //Columns label
                                        if ($j <= ($col_count + 1) && $cols->$col != null && !($j == 1 && $i == 1) && ($i == 1 || $j == 1)) {
                                            $matrix_html .= "<td class='matrix-span' style='font-weight:bold;color: #808080; width:" . $width . ";padding:5px;'>" . $cols->$col . "</td>";
                                        }
                                        //Display answer input (RadioButton or Checkbox)
                                        else if ($j != 1 && $i != 1 && $cols->$col != null) {
                                            $matrix_html .= "<td class='matrix-span' style='width:" . $width . ";padding:5px; '>";
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

                            $matrix_html .= "</table></td>";
                            $html .= $matrix_html;

                            $matrix_html = '';
                        }
                        $html .= " </tbody>
                        </table>
                      </td>
                    </tr>";
                    }
                }
            }
        }
        // survey url encoded
        $survey_url = $sugar_config['site_url'] . '/survey_submission.php?survey_id=';
        $sugar_survey_Url = $survey_url; //create survey submission url
        $encoded_param = base64_encode($survey_id . '&ctype=' . $module_type . '&cid=' . $module_id . '&sub_id=' . $survey_submission->id);
        $sugar_survey_Url = str_replace('survey_id=', 'q=', $sugar_survey_Url);
        $surveyURL = $sugar_survey_Url . $encoded_param;

        // $survey_url = $sugar_config['site_url'] . '/survey_re_submit_request.php?survey_id=' . $survey_id . '&ctype=' . $module_type . '&cid=' . $module_id;
        $resubmitHtml = '';
        if ($reSubmitCount > 0) {
            $resubmitHtml = "<td style='text-align:center;margin:0 0 8px 0;padding:5px;font-size:15px;color:#808080;border:1px solid #e5e5e5;background-color:#f3f3f3'>Note: Admin allow you {$reSubmitCount} time to submit your survey. To edit your submitted response for survey  <a href='{$surveyURL}' target='_blank' >Click here....</a></td></tr>";
        }
        $body = "{$html}
            <tr><td></td></tr><tr>
                 {$resubmitHtml}<tr><td height='20'>&nbsp;</td></tr>
                                    </tbody></table>


              </td>
            </tr>

                    </table>
                <!-- Email Body : END -->
    
                <!-- Email Footer : BEGIN -->
                    <table role='presentation' cellspacing='0' cellpadding='0' border='0' align='center' width='650px' style='max-width: 680px; font-family: calibri, Arial, Helvetica, sans-serif; color: #151515; font-size: 13px; line-height: 140%;' class='email-container footer'>
            <tr>
                            <td style='padding: 10px 30px 10px 30px; width: 100%; font-family: calibri, Arial, Helvetica, sans-serif; font-size: 12px; line-height: 16px; text-align: left; color: #151515; background-color: #5491d5;' >


                                <table role='presentation' width='100%' border='0' cellspacing='0' cellpadding='0'>
                                    <tbody>
                    <tr>
                                            <td style='text-align: center;

                                                font-family: calibri, Arial, Helvetica, sans-serif;
                                                background-color: #5491d5;
                                                padding-top: 14px;
                                                padding-bottom: 13px;
                                                color: #fff;
                                                font-size: 18px;
                                                font-weight: bold;'>Thank You</td>
                  </tr>
                                    </tbody></table>


                    </td>
                  </tr>
                </table>
                <!-- Email Footer : END -->

        </center>
        </body>
        </html>";

        CustomSendEmail($email_address, $subject, $body, $module_id, $module_type);
    }
    // }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="google" content="notranslate">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo $favicon; ?>" type="image/x-icon">
        <?php if ($survey->survey_type == 'poll') { ?>
            <title>Poll</title>
        <?php } else { ?>
            <title>Survey</title>
        <?php } ?>
        <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
        <script src="custom/include/js/survey_js/jquery.datetimepicker.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="custom/include/css/survey_css/jquery.datetimepicker.css">
        <link href="<?php echo $sugar_config['site_url'] . '/custom/include/css/survey_css/survey-form.css' ?>" rel="stylesheet">
        <?php
        if (!empty($survey->survey_background_image)) {
            $sql = "SELECT background_image_lb FROM bc_survey WHERE id='{$survey->id}'";

            // the result of the query
            $result = $db->query($sql);

            // set the header for the image
            while ($row = $db->fetchRow($result)) {
                $base64BG = base64_encode($row['background_image_lb']);
            }
        }
        if ($survey->survey_theme == 'theme0') {
            ?>

            <link href="<?php echo $sugar_config['site_url'] . '/themes/default/less/sugar.less'; ?>" rel="stylesheet">
            <link href="<?php echo $sugar_config['site_url'] . '/themes/Sugar/css/style.css'; ?>" rel="stylesheet">
            <link href="<?php echo $sugar_config['site_url'] . '/themes/default/css/bootstrap.css'; ?>" rel="stylesheet">
            <link href="<?php echo $sugar_config['site_url'] . '/themes/default/css/bootstrap.css'; ?>" rel="stylesheet">
        <?php } ?>
        <link href="<?php
        $survey->survey_theme = (!empty($survey->survey_theme)) ? $survey->survey_theme : 'theme1';
        echo $sugar_config['site_url'] . '/custom/include/css/survey_css/' . $survey->survey_theme . '.css';
        ?>" rel="stylesheet">
        <link href="<?php echo $sugar_config['site_url'] . '/custom/include/css/survey_css/jquery.bxslider.css' ?>" rel="stylesheet">
        <link href="<?php echo $sugar_config['site_url'] . '/custom/include/css/survey_css/custom-form.css' ?>" rel="stylesheet">

        <script src="<?php echo $sugar_config['site_url'] . '/custom/include/js/survey_js/jquery.bxslider.min.js' ?>"></script>
        <script src="<?php echo $sugar_config['site_url'] . '/custom/include/js/survey_js/rate.js' ?>"></script>
        <script src="<?php echo $sugar_config['site_url'] . '/custom/include/js/survey_js/custom_code.js' ?>"></script>
        <style type="text/css">
            .hideBtn{
                visibility:hidden;
            }
            .showBtn{
                visibility:visible;
            }
        </style>
        <script type="text/javascript">
            jQuery(document).ready(function (el) {
                // To avoide Form Submission On Enter key.
                $(document).on("keypress", "input", function (e) {
                    var code = e.keyCode || e.which;
                    if (code == 13) {
                        e.preventDefault();
                        return false;
                    }
                });
                
                /*  BugFix :: Words cut off in survey form :: Resolved : START */
                setTimeout(function () {
                    $(".bx-viewport").css("height", $('.active-slide').css('height'));
                }, 1000);
                /*  BugFix :: Words cut off in survey form :: Resolved : END */

                // set background image
<?php if (!empty($base64BG)) { ?>
                    $('.bg').css('background', 'url("data:image/png;base64,<?php echo $base64BG; ?>")');
<?php } else { ?>
                    $('.bg').css('filter', 'blur(5px)');
<?php } ?>

                $('#overlay').fadeOut();
                var maxWidth = 0;
                $('.ew-ul li').width('auto').each(function () {
                    maxWidth = $(this).width() > maxWidth ? $(this).width() : maxWidth;
                }).width(maxWidth);
                //initially active first page
                $('.progress-bar').children('li:nth-child(1)').addClass('active');

                // ajax call for getting survey detail
                var survey_detail = Array();
                $.ajax({
                    url: "index.php?entryPoint=preview_survey",
                    type: "POST",
                    data: {'method': 'get_survey', 'record_id': '<?php echo $survey_id; ?>', 'cid': '<?php echo $module_id; ?>', 'selected_lang': $('#selected_lang').val(), 'customer_name': '<?php echo $survey_submission->customer_name; ?>' , 'module_name': '<?php echo $module_type; ?>', 'sub_id': '<?php echo $submission_id; ?>'},
                    success: function (result) {

                        result = JSON.parse(result);
                        survey_detail = result['survey_details'];
                        var lang_detail = result['lang_survey_details'];
                        var slider_detail = new Object();
                        var not_allowed_future_date_detail = new Object();
                        $.each(survey_detail, function (pindex, page_data) {
                            $.each(page_data, function (qindex, que_data) {
                                if (qindex == 'page_questions') {
                                    $.each(que_data, function (qi, q_data) {
                                        if (q_data['que_type'] == 'scale')
                                        {
                                            var detail = new Object();
                                            // if min-max-slot value is not set then set default value
                                            if (!q_data['min'] || !q_data['max'] || !q_data['scale_slot']) {
                                                detail['min'] = 0;
                                                detail['max'] = 10;
                                                detail['scale_slot'] = 1;
                                            } else {
                                                detail['min'] = q_data['min'];
                                                detail['max'] = q_data['max'];
                                                detail['scale_slot'] = q_data['scale_slot'];
                                            }
                                            detail['answer'] = q_data['answers'];
                                            slider_detail[q_data['que_id']] = detail;
                                        } else if (q_data['que_type'] == 'date-time')
                                        {
                                            if (q_data['allow_future_dates'] == 'No')
                                                not_allowed_future_date_detail[q_data['que_id']] = q_data['que_id'];
                                        }
                                    });
                                }
                            });
                        });

                        //set datetime picker for datetime question type
                        $('.setdatetime').click(function (el) {
                            var que_id = $(el.currentTarget).parents('.option').attr('id').split('_')[0];
                            if (not_allowed_future_date_detail[que_id])
                            {
                                $(el.currentTarget).datetimepicker({step: 1, maxDate: '0'}).datetimepicker("show");
                            } else {
                                $(el.currentTarget).datetimepicker({step: 1}).datetimepicker("show");
                            }
                            $(el.currentTarget).datetimepicker({step: 1}).datetimepicker("show");
                        });
                        //set date picker for datetime question type
                        $('.setdate').click(function (el) {
                            var que_id = $(el.currentTarget).parents('.option').attr('id').split('_')[0];
                            if (not_allowed_future_date_detail[que_id])
                            {
                                $(el.currentTarget).datepicker({
                                    changeMonth: true,
                                    changeYear: true,
                                    yearRange: '-100y:+100y',
                                    maxDate: '0',
                                }).datepicker("show");
                            } else {
                                $(el.currentTarget).datepicker({
                                    changeMonth: true,
                                    changeYear: true,
                                    yearRange: '-100y:+100y'
                                }).datepicker("show");
                            }
                        });

                        //bind next prev button click function
                        var prev_slide;

                        $(".bx-next,#btnsend").click(function (el) {
                            var obj =<?php echo json_encode($skip_logicArrForAll); ?>;
                            var flag = 0;
                            var selected_answer_ids = new Object();
                            var multi_select_ansid = new Array();
                            var question_wise_data = new Object();
                            var answerCount = 0;
                            //getting selected option ids
                            $.each($('.active-slide').find('.survey-form').find('div.form-body'), function () {
                                var question_type = $(this).attr('class').split(' ')[1];
                                var question_id = $(this).find('.questionHiddenField').val();
                                question_wise_data[question_id] = new Array();
                                if (question_type == 'dropdownlist') {
                                    if ($(this).find('option:selected').val() != 'selection_default_value_dropdown')
                                    {
                                        selected_answer_ids[answerCount] = $(this).find('option:selected').val();
                                    }
                                    answerCount++;
                                } else if (question_type == 'boolean') {
                                    if ($(this).find('input[type=checkbox]:checked').length == 1) {
                                        selected_answer_ids[answerCount] = $(this).find('input[type=checkbox]:checked').val();
                                        answerCount++;
                                    }
                                    answerCount++;
                                } else if (question_type == "radio-button") {
                                    selected_answer_ids[answerCount] = $(this).find('input[type=radio]:checked').val();
                                    answerCount++;
                                } else if (question_type == "emojis") {
                                    selected_answer_ids[answerCount] = $(this).find('input[type=radio]:checked').val();
                                    answerCount++;
                                } else if (question_type == "netpromoterscore") {
                                    selected_answer_ids[answerCount] = $('#hidden_selected_values_id_' + question_id).val();
                                    answerCount++;
                                } else if (question_type == "check-box") {
                                    if ($(this).find('input[type=checkbox]:checked').length == 1) {
                                        selected_answer_ids[answerCount] = $(this).find('input[type=checkbox]:checked').val();
                                        answerCount++;
                                    } else {
                                        //  question_wise_data[question_id] = new Array();
                                        $.each($(this).find('input[type=checkbox]:checked'), function () {
                                            selected_answer_ids[answerCount] = $(this).val();
                                            question_wise_data[question_id].push($(this).val());
                                            multi_select_ansid.push($(this).val());
                                            answerCount++;
                                        });
                                    }

                                } else if (question_type == "multiselectlist") {
                                    if ($(this).find('option:selected').length == 1) {
                                        selected_answer_ids[answerCount] = $(this).find('option:selected').val();
                                        answerCount++;
                                    } else {
                                        $.each($(this).find('option:selected'), function () {
                                            selected_answer_ids[answerCount] = $(this).val();
                                            question_wise_data[question_id].push($(this).val());
                                            multi_select_ansid.push($(this).val());
                                            answerCount++;
                                        });
                                    }
                                } else if (question_type == "netpromoterscore") {
                                    selected_answer_ids.push($(".nps_hidden_selected_values_id").val());

                                }

                            });
                            var action = '';
                            var target = '';
                            var action_array = new Array();
                            var is_multi = true;
                            //while multi select option value ids
                            $.each(selected_answer_ids, function (key_id, value) {
                                if ($.inArray(value, multi_select_ansid) != -1) {
                                    $.each(question_wise_data, function (question_id, options) {
                                        if (question_id != undefined && value != "") {
                                            // if action array already exists then dont create new array
                                            if (!action_array[question_id])
                                            {
                                                action_array[question_id] = new Array();
                                            }
                                            if ($.inArray(value, options) != -1) {
                                                if (value != 'is_other_option')
                                                {
                                                    $.each(obj[value], function (skip_action, skip_target) {
                                                        if (skip_action != "no_logic" && skip_target != "") {
                                                            if (skip_action != "show_hide_question" && !action_array[question_id][skip_action]) {

                                                                action_array[question_id][skip_action] = skip_target;
                                                                is_multi = true;
                                                            }
                                                        }
                                                    });
                                                }
                                            }
                                        }
                                    });
                                }
                                //while single select option value ids
                                else {
                                    if (value != undefined && value != "" && value != "is_other_option") {
                                        $.each(obj[value], function (skip_action, skip_target) {
                                            if (skip_action != "no_logic" && skip_target != "") {
                                                if (skip_action != "show_hide_question") {
                                                    action = skip_action;
                                                    target = skip_target;
                                                    is_multi = false;
                                                }
                                            }
                                        });
                                    }

                                }
                            });
                            //first action is perform for multiple choice question
                            if (is_multi) {
                                for (var key in action_array) {
                                    for (var val in action_array[key])
                                    {
                                        action = val;
                                        target = action_array[key][val];
                                    }
                                }
                            }
                            //perform action
                            if (action == "redirect_to_url") {
                                flag = 1;
                                $('#btnnext').prop('type', 'submit');
                                $('#btnnext').prop('name', 'btnsend');
                                $('#btnnext').removeClass('bx-next');
                                $('#redirect_action_value').val(target);
                                //current page
                                var curr_slide = slider.getCurrentSlide();
                                var total_pages = parseInt($('.page-no').length);
                                // hide all after pages
                                var afterPages = new Object();
                                if ($('.welcome-form').length != 0)
                                {
                                    total_pages = total_pages + 1;
                                }
                                for (var i = curr_slide + 1; i < total_pages; i++) {
                                    afterPages[i] = i;
                                }
                                $.each(afterPages, function (key, pages)
                                {
                                    if (pages != gotoslide && pages != prev_slide)
                                    {
                                        var pageToHide = $('.survey-form')[pages + 1];
                                        $(pageToHide).addClass('hiddenPage');
                                    }
                                });
                                //*Added by charmi 14-09-2018*/
                                if (curr_slide < total_pages) {
                                    $('.agreement_section').css('display', 'block');
                                }
                            } else if (action == "eop") {
                                flag = 1;
                                $('#btnnext').prop('type', 'submit');
                                $('#btnnext').prop('name', 'btnsend');
                                $('#btnnext').removeClass('bx-next');
                                //current page
                                var curr_slide = slider.getCurrentSlide();
                                var total_pages = parseInt($('.page-no').length);
                                // hide all after pages
                                var afterPages = new Object();
                                if ($('.welcome-form').length != 0)
                                {
                                    total_pages = total_pages + 1;
                                }
                                for (var i = curr_slide + 1; i < total_pages; i++) {
                                    afterPages[i] = i;
                                }
                                $.each(afterPages, function (key, pages)
                                {
                                    if (pages != gotoslide && pages != prev_slide)
                                    {
                                        var pageToHide = $('.survey-form')[pages + 1];
                                        $(pageToHide).addClass('hiddenPage');
                                    }
                                });
                                //*Added by charmi 14-09-2018*/
                                if (curr_slide < total_pages) {
                                    $('.agreement_section').css('display', 'block');
                                }
                            } else if (action == "redirect_to_page") {
                                flag = 1;
                                $('#btnnext').prop('type', 'button');
                                $('#btnnext').prop('name', 'btnnext');
                                $('#btnnext').addClass('bx-next');
                                // set type button to do not submit but redirect to page
                                if ($(this).attr('name') == 'btnsend')
                                {
                                    $('#btnsend').prop('type', 'button');
                                }
                                /*Added by charmi 14-09 if welcome page exists page redirects do not work*/
                                // got to slide
                                if ($('.welcome-form').length == 1) {
                                    var gotoslide = parseInt($('#' + target).val());
                                } else {
                                    var gotoslide = parseInt($('#' + target).val()) - 1;
                                }
                                prev_slide = slider.getCurrentSlide();
                                // hide all in between pages
                                var inbetweenPages = new Object();
                                for (var i = prev_slide + 1; i < gotoslide; i++) {
                                    inbetweenPages[i] = i;
                                }
                                $.each(inbetweenPages, function (key, pages)
                                {
                                    if (pages != gotoslide && pages != prev_slide)
                                    {
                                        var pageToHide = $('.survey-form')[pages + 1];
                                        $(pageToHide).addClass('hiddenPage');
                                    }
                                });
                                slider.goToSlide(gotoslide, 'next');
                                var pageToShow = $('.survey-form')[gotoslide + 1];
                                $(pageToShow).removeClass('hiddenPage');
                            } else if (action == "") {
                                $('#btnnext').prop('type', 'button');
                                $('#btnnext').prop('name', 'btnnext');
                                $('#btnnext').addClass('bx-next');
                            }

                            var validationQuestionValue = new Array();
                            // set submit type if not set for submission
                            if ($(this).attr('name') == 'btnsend')
                            {
                                $('#btnsend').prop('type', 'submit');


                                // check agreement required validation
                                if ($('.agreement_survey').length != 0 && $('.agreement_survey').prop('required')) {
                                    if ($('.agreement_survey:checked').length == 0) {
                                        // Agreement is required
                                        $('.required_agree').show();
                                        //  return false;
                                        validationQuestionValue.push(false);
                                    } else {
                                        $('.required_agree').hide();
                                    }
                                }

                                $('#overlay').fadeIn();
                            }

                            var validationReturnVal = '';
                            var allTtpeArray = new Array(
                                    'multiselectlist', 'check-box',
                                    'radio-button', 'dropdownlist',
                                    'textbox', 'commentbox',
                                    'rating', 'contact-information',
                                    'date-time', 'image', 'video', 'scale', 'matrix', 'doc-attachment', 'boolean', 'netpromoterscore', 'emojis'
                                    );
                            var is_require = 0;
                            var type = '';
                            var queID, datatype, is_datetime, is_sort = '';
                            var min, max, maxsize, precision, scale_slot, limit_min = 0;
                            var que_detail = new Object();
                            $('.active-slide > .survey-form > .form-body').each(function () {
                                queID = $(this).find('.questionHiddenField').val();
                                var self = this;
                                //getting other question detail
                                $.each(survey_detail, function (pindex, page_data) {
                                    $.each(page_data, function (qindex, que_data) {
                                        if (qindex == 'page_questions') {
                                            $.each(que_data, function (qi, q_data) {

                                                if (q_data['que_id'] == queID) {
                                                    min = q_data['min'];
                                                    max = q_data['max'];
                                                    maxsize = q_data['maxsize'];
                                                    precision = q_data['precision'];
                                                    scale_slot = q_data['scale_slot'];
                                                    datatype = q_data['advance_type'];
                                                    is_datetime = q_data['is_datetime'];
                                                    is_sort = q_data['is_sort'];
                                                    limit_min = q_data['limit_min'];
                                                    que_detail[queID] = new Object();
                                                    que_detail[queID]['min'] = min;
                                                    que_detail[queID]['max'] = max;
                                                    que_detail[queID]['maxsize'] = maxsize;
                                                    que_detail[queID]['precision'] = precision;
                                                    que_detail[queID]['scale_slot'] = scale_slot;
                                                    que_detail[queID]['advance_type'] = datatype;
                                                    que_detail[queID]['is_datetime'] = is_datetime;
                                                    que_detail[queID]['is_sort'] = is_sort;
                                                    que_detail[queID]['limit_min'] = limit_min;
                                                }
                                            });
                                        }
                                    });
                                });
                                var setTypaClass = $(self)[0].classList;
                                if (typeof setTypaClass == "undefined") {
                                    var setTypaClass = $(self)[0].className.split(" ");
                                }
                                $(setTypaClass).each(function (index) {
                                    if ($.inArray(setTypaClass[index], allTtpeArray) != -1) {
                                        type = setTypaClass[index];
                                    }
                                });
                                if ($(self).find('h3').find('span').hasClass('is_required')) {
                                    is_require = 1;
                                }
                                if ($('.active-slide').find('.welcome-form').length == 0)
                                {
                                    validationReturnVal = surveySliderValidationOnNextPrevClick(type, queID, is_require, que_detail[queID]['min'], que_detail[queID]['max'], que_detail[queID]['maxsize'], que_detail[queID]['precision'], que_detail[queID]['advance_type'], que_detail[queID]['is_datetime'], que_detail[queID]['is_sort'], que_detail[queID]['scale_slot'], que_detail[queID]['limit_min'], lang_detail);
                                    validationQuestionValue.push(validationReturnVal);
                                }
                                is_require = 0;
                                type = '';
                                queID = '';
                            });
                            if ($('.active-slide').find('.welcome-form').length == 1 || $.inArray(false, validationQuestionValue) == -1) {

                                if (flag == 0) {
                                    prev_slide = slider.getCurrentSlide();
                                    var currentSlidePage = slider.getCurrentSlide() + 1;
                                    var totalPageCount = slider.getSlideCount();
                                    if (currentSlidePage == totalPageCount - 1) {
                                        $(this).removeClass('showBtn').addClass('hideBtn');
                                    } else {
                                        if ($(this)[0].id != 'btnsend') {
                                            $("#btnprev").removeClass('hideBtn').addClass('showBtn');
                                        }
                                    }
                                    slider.goToNextSlide();
                                    $('html, body').animate({scrollTop: 0}, 800);
                                    if ($(this).hasClass('hideBtn')) {
                                        $("#btnsend").show();
                                        $("#btnprev").removeClass('hideBtn').addClass('showBtn');
                                    }

                                    // disable submit button after submission
                                    if ($(this)[0].id == 'btnsend' && $('#btnsend').css('display') != 'none')
                                    {
                                        $('#btnsend').attr('id', 'btnsent');
                                        $('#btnsent').css('opacity', '0.5');
                                    }
                                }
                            } else {
                                $('#overlay').fadeOut();
                                $('.validation-tooltip').fadeIn();
                                return false;
                            }

                            // currently showing question ids
                            var ShowQueIds = '';
                            $.each($('div.form-body'), function () {

                                var isHidden = false;
                                var isHiddenPageParent = $(this).parent('.survey-form');
                                if ($(isHiddenPageParent).hasClass('hiddenPage'))
                                {
                                    isHidden = true;
                                }
                                if ($(this).css('display') != 'none' && $(this).find('.questionHiddenField').val() && !isHidden)
                                {
                                    var queId = $(this).find('.questionHiddenField').val();
                                    ShowQueIds += queId + ',';
                                }
                            });
                            // set show que ids to hidden variable
                            $('.show_question_list').val(ShowQueIds);
                        });
                        $(".bx-prev").click(function () {

                            $('.validation-tooltip').fadeOut();
                            var currentSlidePage = slider.getCurrentSlide();
                            if (currentSlidePage == prev_slide) {
                                prev_slide = slider.getCurrentSlide() - 1;
                            }
                            //prev_slide = slider.getCurrentSlide();
                            if (currentSlidePage == 1) {
                                $(this).removeClass('showBtn').addClass('hideBtn');
                                $('#btnnext').removeClass('hideBtn').addClass('showBtn');
                            } else {
                                $("#btnnext").removeClass('hideBtn').addClass('showBtn');
                            }
                            slider.goToSlide(prev_slide);
                            $('html, body').animate({scrollTop: 0}, 800);
                            $("#btnsend").hide();
                        });
                        //setting slider
                        $(function () {
                            var que_id = '';
                            $.each(slider_detail, function (qid, slider_data) {
                                var answer = parseInt(slider_data.answer) ? parseInt(slider_data.answer) : '';
                                // scale slider
                                var slider = $('.' + qid).find("#slider").slider({
                                    slide: function (event, ui) {
                                        $(ui.handle).find('.tooltip-score').html('<div>' + ui.value + '</div>');
                                        $('.' + qid + '_scale').val(ui.value);
                                    },
                                    range: "min",
                                    value: answer,
                                    min: parseInt(slider_data.min),
                                    max: parseInt(slider_data.max),
                                    step: parseInt(slider_data.scale_slot),
                                    create: function (event, ui) {
                                        var tooltip = $('<div class="tooltip-score">' + answer + '</div>');
                                        $(event.target).find('.ui-slider-handle').append(tooltip);
                                    },
                                    change: function (event, ui) {
                                        $('.' + qid + '_scale').val(ui.value);
                                        $(ui.handle).find('.tooltip-score').html('<div>' + ui.value + '</div>');
                                    }
                                });
                            });
                        });
                    }
                });
                var slider = jQuery('.bxslider').bxSlider({
                    touchEnabled: false,
                    adaptiveHeight: true,
                    infiniteLoop: false,
                    hideControlOnEnd: true,
                    mode: 'fade', pager: true,
                    controls: false,
                    nextSelector: '#btnnext',
                    prevSelector: '#btnprev',
                    onSliderLoad: function (currentIndex) {
                    $('.bx-viewport').addClass('survey-form-height');
                        $('.bx-viewport').find('.bxslider').children().eq(currentIndex).addClass('active-slide');
                        //hide propgress bar at welcomepage                         
                        if ($('.active-slide').find('.welcome-form').length != 0)
                        {
                            $('.form-desc').hide();
                            $('.agreement_section').hide();
                        } else {
                            $('.form-desc').show();
                        }
                    },
                    onSlideBefore: function ($slideElement) {
$('.bx-viewport').addClass('survey-form-height');
                        $('.bx-viewport').find('.bxslider').children().removeClass('active-slide');
                        $slideElement.addClass('active-slide');
                        var total_pages = parseInt($('.page-no').length);
                        var page_no = parseInt($('.active-slide').find('.page-no > i').html());
                        page_no = page_no - 1;
                        // page progress bar
                        //Setting page state on the top
                        for (var i = 1; i <= total_pages; i++) {
                            if (i < page_no)
                            {
                                $('.progress-bar').children('li:nth-child(' + i + ')').addClass('completed');
                                $('.progress-bar').children('li:nth-child(' + i + ')').removeClass('active');
                            } else if (i == page_no) {
                                $('.progress-bar').children('li:nth-child(' + i + ')').addClass('active');
                                $('.progress-bar').children('li:nth-child(' + i + ')').removeClass('completed');
                            } else {
                                $('.progress-bar').children('li:nth-child(' + i + ')').removeClass('completed');
                                $('.progress-bar').children('li:nth-child(' + i + ')').removeClass('active');
                            }
                        }
                        var progress_percentage = Math.floor((page_no * 100) / total_pages);
                        var progress = $("#progress").slider({
                            range: "min",
                            value: progress_percentage,
                            disabled: true,
                        });
                        //add extra div for designing
                        $('#progress').find('.tooltip-score').html('<div>' + progress_percentage + '<div>');
                        $('#pagecount').html(page_no + "/" + total_pages);
                        $('#progress-percentage').html(progress_percentage + "%");
                        //hide propgress bar at welcomepage  

                        if ($('.active-slide').find('.welcome-form').length != 0)
                        {
                            $('.form-desc').hide();
                            $('.agreement_section').hide();
                        } else {
                            $('.form-desc').show();
                            $('.agreement_section').hide();
                        }
                    },
                    onSlideAfter: function () {

                        var currentSlidePage = slider.getCurrentSlide() + 1;
                        var totalPageCount = slider.getSlideCount();
                        if (currentSlidePage == 1) {
                            $("#btnprev").removeClass('showBtn').addClass('hideBtn');
                            $('#btnnext').removeClass('hideBtn').addClass('showBtn');
                            $("#btnsend").hide();
                        } else if (currentSlidePage == totalPageCount) {
                            $("#btnsend").show();
                            $("#btnprev").removeClass('hideBtn').addClass('showBtn');
                            $('#btnnext').removeClass('showBtn').addClass('hideBtn');
                        } else {
                            $("#btnprev").removeClass('hideBtn').addClass('showBtn');
                            $('#btnnext').removeClass('hideBtn').addClass('showBtn');
                            $("#btnsend").hide();
                        }

                        if ($('.thanks-page').length != 0 && currentSlidePage == (totalPageCount - 1)) {
                            $('.agreement_section').show();
                        } else if ($('.thanks-page').length == 0 && currentSlidePage == totalPageCount) {
                            $('.agreement_section').show();
                        } else {
                            $('.agreement_section').hide();
                        }
                    },
                });
                var total_pages = parseInt($('.page-no').length);
                var page_no = 0;
                var progress_percentage = Math.floor((page_no * 100) / total_pages);
                // page progress bar
                var progress = $("#progress").slider({range: "min", value: progress_percentage,
                    disabled: true,
                    create: function (event, ui) {
                        var tooltip = $('<div></div><div class="tooltip-score"><div>' + progress_percentage + '<div></div>');
                        $(event.target).find('.ui-slider-handle').append(tooltip);
                    },
                });
                $('#pagecount').html(page_no + "/" + total_pages);
                $('#progress-percentage').html(progress_percentage + "%");
                if ($(".bx-prev").hasClass('hideBtn')) {
                    $("#btnsend").hide();
                }
                if ($(".bx-prev").hasClass('hideBtn') && $(".bx-next").hasClass('hideBtn')) {
                    $("#btnsend").show();
                }
                //Allow only Numeric Value to textbox validation
                $('.numericField').keypress(function (e) {
                    //if the letter is not digit then display error and don't type anything
                    if (e.which != 8 && e.which != 0 && e.which != 45 && (e.which < 48 || e.which > 57)) {

                        return false;
                    }
                });
                //Allow only Float Value to textbox validation
                $('.decimalField').keypress(function (e) {
                    //if dot already not entered
                    var dot_flag = $(e.currentTarget).val().includes('.');
                    //if the letter is not digit then display error and don't type anything
                    if ((e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) || (dot_flag && e.which == 46)) {

                        return false;
                    }
                });
                $('.setdatetime').keypress(function (e) {
                    //if the letter is  digit then display error and don't type anything
                    if (e.which != 8 && e.which != 0 && (e.which > 48 || e.which < 57)) {

                        return false;
                    }
                });
                $('.setdate').keypress(function (e) {
                    //if the letter is  digit then display error and don't type anything
                    if (e.which != 8 && e.which != 0 && (e.which > 48 || e.which < 57)) {

                        return false;
                    }
                });
                $('#selected_lang').change(function () {
                    // change survey language
                    if (confirm('Are you sure want to change survey language ?'))
                    {
                        var url = window.location.href;
                        url = window.location.href.split('&selected_lang=');
                        window.location.assign(url[0] + '&selected_lang=' + $('#selected_lang').val());
                    }
                });
            });

            function switchEmojis(el, op, queID) {
                var id = $(el).find('.Grey_Emoji').attr('id')
                $(el).parents('.emojis_class').find('.Emoji').hide();
                $(el).parents('.emojis_class').find('.Grey_Emoji').show();
                $(el).parents('.emojis_class').find('input[type=radio]').removeAttr('checked');
                if (id == 'Grey_emojis_' + op) {
                    $(el).find('#' + queID + '_' + op).prop('checked', 'true');
                    $(el).find('#emojis_' + op).show();
                    $(el).find('#Grey_emojis_' + op).hide();
                } else {
                    $(el).find('#Grey_emojis_' + op).show();
                    $(el).find('#emojis_' + op).hide();
                }
            }

            function applyNPSSelectedColor(el) {
                var selected_id = $(el).attr('id');
//                    var split_selected_id = selected_id.split("_");
                var question_id = $('#' + selected_id).parent().parent().parent().parent().parent().parent().attr('id');

                var split_que_id = question_id.split("_");
                var selected_value = $('#' + selected_id).attr('value');

                var previous_nps_selected_id_hidden = $('#hidden_selected_values_id_' + split_que_id[0]).val();
                var selected_nps_value_hidden = $('#hidden_selected_values_' + split_que_id[0]).val();
                $("#hidden_selected_values_id_" + split_que_id[0]).remove();
                $("#hidden_selected_values_" + split_que_id[0]).remove();
                $('#score_pannel_' + split_que_id[0]).append('<input type="hidden" class="nps_hidden_selected_values_id" value="' + selected_id + '" id="hidden_selected_values_id_' + split_que_id[0] + '"/>')
                $('#score_pannel_' + split_que_id[0]).append('<input type="hidden" class="nps_hidden_selected_values" value="' + selected_value + '" id="hidden_selected_values_' + split_que_id[0] + '"/>')

                if (selected_id != previous_nps_selected_id_hidden && selected_value != selected_nps_value_hidden) {
                    $('#' + selected_id).css('background-color', '#a1cbff');
                    if (selected_nps_value_hidden < 7) {
                        $('#' + previous_nps_selected_id_hidden).css('background-color', '#ff5353');
                    } else if (selected_nps_value_hidden >= 7 && selected_nps_value_hidden <= 8) {
                        $('#' + previous_nps_selected_id_hidden).css('background-color', '#e9e817');
                    } else if (selected_nps_value_hidden > 8 && selected_nps_value_hidden <= 10) {
                        $('#' + previous_nps_selected_id_hidden).css('background-color', '#92d51a');
                    }
                    $('#previous_nps_selected_id_hidden_' + split_que_id[0]).val(selected_id);

                }
                $('#' + selected_id).css('background-color', '#a1cbff');
            }

            function skipp_logic_question(el, answers) {
                //hide question onload
                var question_type = $(el).parents('.form-body').attr('class').split(' ')[1];
                //while question type is boolean on showhide question
                if (question_type == "netpromoterscore") {
                    $.each($(el).parents('.nps_submission_table').find('div.score_pannel'), function () {
                        $.each(answers[this.id], function (action, target) {
                            if (action == "show_hide_question") {
                                var showHideQuesIdsArr = target;
                                $.each(showHideQuesIdsArr, function (idx, queId) {

                                    if ($('#' + queId + '_div').parents('.form-body').css('display') != 'none') {
                                        var newHeight = $('.bx-viewport').height() - ($('#' + queId + '_div').parents('.form-body').innerHeight() + 15);
                                        $('.bx-viewport').height(newHeight);
                                    }
                                    $('#' + queId + '_div').parents('.form-body').hide();
                                    //re-setting value while uncheck the element
                                    var hide_question_type = $('#' + queId + '_div').parents('.form-body').attr('class').split(' ')[1];
                                    if (hide_question_type == "radio-button") {
                                        $.each($('#' + queId + '_div').find('input[type=radio]'), function () {
                                            $(this).prop('checked', false);
                                        });
                                    } else if (hide_question_type == "emojis") {
                                        $('.' + queId).parents('.emojis_class').find('.Emoji').hide();
                                        $('.' + queId).parents('.emojis_class').find('.Grey_Emoji').show();
                                    } else if (hide_question_type == "netpromoterscore") {
                                        var npsSelID = $('#' + queId + '_div').find('.nps_hidden_selected_values_id').val();
                                        var npsSelVal = $('#' + queId + '_div').find('.nps_hidden_selected_values').val();
                                        if (npsSelID != '') {
                                            var bgcolor = '#ff5353';
                                            if (npsSelVal > 6 && npsSelVal <= 8) {
                                                bgcolor = '#e9e817';
                                            } else if (npsSelVal > 8 && npsSelVal <= 10) {
                                                bgcolor = '#92d51a';
                                            }
                                            $('#' + queId + '_div').find('#' + npsSelID).css('background-color', bgcolor);
                                            $('#' + queId + '_div').find('.nps_hidden_selected_values_id').val('');
                                            $('#' + queId + '_div').find('.nps_hidden_selected_values').val('');
                                        }
                                    } else if (hide_question_type == "check-box" || hide_question_type == "boolean") {
                                        $.each($('#' + queId + '_div').find('input[type=checkbox]'), function () {
                                            $(this).prop('checked', false);
                                        });
                                    } else if (hide_question_type == "scale") {
                                        $('.' + queId).find('.ui-slider-range').css('width', '0%');
                                        $('.' + queId).find('.ui-slider-handle').css('left', '0%');
                                        $('.' + queId).find('.tooltip-score').find('div').html('0');
                                        $('.' + queId + '_scale').val('0')
                                    } else if (hide_question_type == "date-time") {
                                        $('.' + queId + '_datetime').val('');
                                    } else if (hide_question_type == "rating") {
                                        $('#' + queId + '_div').find('.rating').removeClass('selected');
                                        $('.' + queId).val('');
                                    } else if (hide_question_type == "matrix") {
                                        $.each($('#' + queId + '_div').find('input[type=radio]'), function () {
                                            $(this).prop('checked', false);
                                        });
                                        $.each($('#' + queId + '_div').find('input[type=checkbox]'), function () {
                                            $(this).prop('checked', false);
                                        });
                                    } else if (hide_question_type == "dropdownlist") {
                                        $('.' + queId).val('selection_default_value_dropdown');
                                    } else {
                                        $('.' + queId).val('');
                                    }
                                });
                            }
                        });
                    });
                }
                if (question_type == "boolean") {
                    $.each($(el).parent().parent().parent().find('input[type=checkbox]'), function () {
                        $.each(answers[this.value], function (action, target) {
                            if (action == "show_hide_question") {
                                var showHideQuesIdsArr = target;
                                $.each(showHideQuesIdsArr, function (idx, queId) {

                                    if ($('#' + queId + '_div').parents('.form-body').css('display') != 'none') {
                                        var newHeight = $('.bx-viewport').height() - ($('#' + queId + '_div').parents('.form-body').innerHeight() + 15);
                                        $('.bx-viewport').height(newHeight);
                                    }
                                    $('#' + queId + '_div').parents('.form-body').hide();
                                    //re-setting value while uncheck the element
                                    var hide_question_type = $('#' + queId + '_div').parents('.form-body').attr('class').split(' ')[1];
                                    if (hide_question_type == "radio-button") {
                                        $.each($('#' + queId + '_div').find('input[type=radio]'), function () {
                                            $(this).prop('checked', false);
                                        });
                                    } else if (hide_question_type == "emojis") {
                                        $('.' + queId).parents('.emojis_class').find('.Emoji').hide();
                                        $('.' + queId).parents('.emojis_class').find('.Grey_Emoji').show();
                                    } else if (hide_question_type == "netpromoterscore") {
                                        var npsSelID = $('#' + queId + '_div').find('.nps_hidden_selected_values_id').val();
                                        var npsSelVal = $('#' + queId + '_div').find('.nps_hidden_selected_values').val();
                                        if (npsSelID != '') {
                                            var bgcolor = '#ff5353';
                                            if (npsSelVal > 6 && npsSelVal <= 8) {
                                                bgcolor = '#e9e817';
                                            } else if (npsSelVal > 8 && npsSelVal <= 10) {
                                                bgcolor = '#92d51a';
                                            }
                                            $('#' + queId + '_div').find('#' + npsSelID).css('background-color', bgcolor);
                                            $('#' + queId + '_div').find('.nps_hidden_selected_values_id').val('');
                                            $('#' + queId + '_div').find('.nps_hidden_selected_values').val('');
                                        }
                                    } else if (hide_question_type == "check-box" || hide_question_type == "boolean") {
                                        $.each($('#' + queId + '_div').find('input[type=checkbox]'), function () {
                                            $(this).prop('checked', false);
                                        });
                                    } else if (hide_question_type == "scale") {
                                        $('.' + queId).find('.ui-slider-range').css('width', '0%');
                                        $('.' + queId).find('.ui-slider-handle').css('left', '0%');
                                        $('.' + queId).find('.tooltip-score').find('div').html('0');
                                        $('.' + queId + '_scale').val('0')
                                    } else if (hide_question_type == "date-time") {
                                        $('.' + queId + '_datetime').val('');
                                    } else if (hide_question_type == "rating") {
                                        $('#' + queId + '_div').find('.rating').removeClass('selected');
                                        $('.' + queId).val('');
                                    } else if (hide_question_type == "matrix") {
                                        $.each($('#' + queId + '_div').find('input[type=radio]'), function () {
                                            $(this).prop('checked', false);
                                        });
                                        $.each($('#' + queId + '_div').find('input[type=checkbox]'), function () {
                                            $(this).prop('checked', false);
                                        });
                                    } else if (hide_question_type == "dropdownlist") {
                                        $('.' + queId).val('selection_default_value_dropdown');
                                    } else {
                                        $('.' + queId).val('');
                                    }
                                });
                            }
                        });
                    });
                } else if (question_type == "radio-button") {
                    $.each($(el).parent().parent().parent().find('input[type=radio]'), function () {
                        $.each(answers[this.value], function (action, target) {
                            if (action == "show_hide_question") {
                                var showHideQuesIdsArr = target;
                                $.each(showHideQuesIdsArr, function (idx, queId) {

                                    if ($('#' + queId + '_div').parents('.form-body').css('display') != 'none') {
                                        var newHeight = $('.bx-viewport').height() - ($('#' + queId + '_div').parents('.form-body').innerHeight() + 15);
                                        $('.bx-viewport').height(newHeight);
                                    }
                                    $('#' + queId + '_div').parents('.form-body').hide();
                                    //re-setting value while uncheck the element
                                    var hide_question_type = $('#' + queId + '_div').parents('.form-body').attr('class').split(' ')[1];
                                    if (hide_question_type == "radio-button") {
                                        $.each($('#' + queId + '_div').find('input[type=radio]'), function () {
                                            $(this).prop('checked', false);
                                        });
                                    } else if (hide_question_type == "emojis") {
                                        $('.' + queId).parents('.emojis_class').find('.Emoji').hide();
                                        $('.' + queId).parents('.emojis_class').find('.Grey_Emoji').show();
                                    } else if (hide_question_type == "netpromoterscore") {
                                        var npsSelID = $('#' + queId + '_div').find('.nps_hidden_selected_values_id').val();
                                        var npsSelVal = $('#' + queId + '_div').find('.nps_hidden_selected_values').val();
                                        if (npsSelID != '') {
                                            var bgcolor = '#ff5353';
                                            if (npsSelVal > 6 && npsSelVal <= 8) {
                                                bgcolor = '#e9e817';
                                            } else if (npsSelVal > 8 && npsSelVal <= 10) {
                                                bgcolor = '#92d51a';
                                            }
                                            $('#' + queId + '_div').find('#' + npsSelID).css('background-color', bgcolor);
                                            $('#' + queId + '_div').find('.nps_hidden_selected_values_id').val('');
                                            $('#' + queId + '_div').find('.nps_hidden_selected_values').val('');
                                        }
                                    } else if (hide_question_type == "check-box" || hide_question_type == "boolean") {
                                        $.each($('#' + queId + '_div').find('input[type=checkbox]'), function () {
                                            $(this).prop('checked', false);
                                        });
                                    } else if (hide_question_type == "scale") {
                                        $('.' + queId).find('.ui-slider-range').css('width', '0%');
                                        $('.' + queId).find('.ui-slider-handle').css('left', '0%');
                                        $('.' + queId).find('.tooltip-score').find('div').html('0');
                                        $('.' + queId + '_scale').val('0')
                                    } else if (hide_question_type == "date-time") {
                                        $('.' + queId + '_datetime').val('');
                                    } else if (hide_question_type == "rating") {
                                        $('#' + queId + '_div').find('.rating').removeClass('selected');
                                        $('.' + queId).val('');
                                    } else if (hide_question_type == "matrix") {
                                        $.each($('#' + queId + '_div').find('input[type=radio]'), function () {
                                            $(this).prop('checked', false);
                                        });
                                        $.each($('#' + queId + '_div').find('input[type=checkbox]'), function () {
                                            $(this).prop('checked', false);
                                        });
                                    } else if (hide_question_type == "dropdownlist") {
                                        $('.' + queId).val('selection_default_value_dropdown');
                                    } else {
                                        $('.' + queId).val('');
                                    }
                                });
                            }
                        });
                    });
                } else if (question_type == "emojis") {
                    $.each($(el).parents('.emojis_class').find('input[type=radio]'), function () {
                        $.each(answers[this.value], function (action, target) {
                            if (action == "show_hide_question") {
                                var showHideQuesIdsArr = target;
                                $.each(showHideQuesIdsArr, function (idx, queId) {

                                    if ($('#' + queId + '_div').parents('.form-body').css('display') != 'none') {
                                        var newHeight = $('.bx-viewport').height() - ($('#' + queId + '_div').parents('.form-body').innerHeight() + 15);
                                        $('.bx-viewport').height(newHeight);
                                    }
                                    $('#' + queId + '_div').parents('.form-body').hide();
                                    //re-setting value while uncheck the element
                                    var hide_question_type = $('#' + queId + '_div').parents('.form-body').attr('class').split(' ')[1];
                                    if (hide_question_type == "radio-button") {
                                        $.each($('#' + queId + '_div').find('input[type=radio]'), function () {
                                            $(this).prop('checked', false);
                                        });
                                    } else if (hide_question_type == "emojis") {
                                        $('.' + queId).parents('.emojis_class').find('.Emoji').hide();
                                        $('.' + queId).parents('.emojis_class').find('.Grey_Emoji').show();
                                    } else if (hide_question_type == "netpromoterscore") {
                                        var npsSelID = $('#' + queId + '_div').find('.nps_hidden_selected_values_id').val();
                                        var npsSelVal = $('#' + queId + '_div').find('.nps_hidden_selected_values').val();
                                        if (npsSelID != '') {
                                            var bgcolor = '#ff5353';
                                            if (npsSelVal > 6 && npsSelVal <= 8) {
                                                bgcolor = '#e9e817';
                                            } else if (npsSelVal > 8 && npsSelVal <= 10) {
                                                bgcolor = '#92d51a';
                                            }
                                            $('#' + queId + '_div').find('#' + npsSelID).css('background-color', bgcolor);
                                            $('#' + queId + '_div').find('.nps_hidden_selected_values_id').val('');
                                            $('#' + queId + '_div').find('.nps_hidden_selected_values').val('');
                                        }
                                    } else if (hide_question_type == "check-box" || hide_question_type == "boolean") {
                                        $.each($('#' + queId + '_div').find('input[type=checkbox]'), function () {
                                            $(this).prop('checked', false);
                                        });
                                    } else if (hide_question_type == "scale") {
                                        $('.' + queId).find('.ui-slider-range').css('width', '0%');
                                        $('.' + queId).find('.ui-slider-handle').css('left', '0%');
                                        $('.' + queId).find('.tooltip-score').find('div').html('0');
                                        $('.' + queId + '_scale').val('0')
                                    } else if (hide_question_type == "date-time") {
                                        $('.' + queId + '_datetime').val('');
                                    } else if (hide_question_type == "rating") {
                                        $('#' + queId + '_div').find('.rating').removeClass('selected');
                                        $('.' + queId).val('');
                                    } else if (hide_question_type == "matrix") {
                                        $.each($('#' + queId + '_div').find('input[type=radio]'), function () {
                                            $(this).prop('checked', false);
                                        });
                                        $.each($('#' + queId + '_div').find('input[type=checkbox]'), function () {
                                            $(this).prop('checked', false);
                                        });
                                    } else if (hide_question_type == "dropdownlist") {
                                        $('.' + queId).val('selection_default_value_dropdown');
                                    } else {
                                        $('.' + queId).val('');
                                    }
                                });
                            }
                        });
                    });
                }
                //while question type is checkbox on showhide question
                else if (question_type == "check-box") {

                    if (!$(el).prop('checked')) {
                        var answer_id = el.value;
                        var showHideQuesIds = $(el).parents('.form-body').parent().find('#show_hide_question_Ids_' + answer_id).val();
                        if (showHideQuesIds != null && showHideQuesIds != '') {
                            var showHideQuesIdsArr = showHideQuesIds.split(",");
                            $.each(showHideQuesIdsArr, function (idx, queId) {

                                var newHeight = $('.bx-viewport').height() - ($('#' + queId + '_div').parents('.form-body').innerHeight() + 15);
                                $('.bx-viewport').height(newHeight);
                                $('#' + queId + '_div').parents('.form-body').hide();
                                var hide_question_type = $('#' + queId + '_div').parents('.form-body').attr('class').split(' ')[1];
                                //re-setting value while uncheck the element
                                if (hide_question_type == "radio-button") {
                                    $.each($('#' + queId + '_div').find('input[type=radio]'), function () {
                                        $(this).prop('checked', false);
                                    });
                                } else if (hide_question_type == "emojis") {
                                    $('.' + queId).parents('.emojis_class').find('.Emoji').hide();
                                    $('.' + queId).parents('.emojis_class').find('.Grey_Emoji').show();
                                } else if (hide_question_type == "netpromoterscore") {
                                    var npsSelID = $('#' + queId + '_div').find('.nps_hidden_selected_values_id').val();
                                    var npsSelVal = $('#' + queId + '_div').find('.nps_hidden_selected_values').val();
                                    if (npsSelID != '') {
                                        var bgcolor = '#ff5353';
                                        if (npsSelVal > 6 && npsSelVal <= 8) {
                                            bgcolor = '#e9e817';
                                        } else if (npsSelVal > 8 && npsSelVal <= 10) {
                                            bgcolor = '#92d51a';
                                        }
                                        $('#' + queId + '_div').find('#' + npsSelID).css('background-color', bgcolor);
                                        $('#' + queId + '_div').find('.nps_hidden_selected_values_id').val('');
                                        $('#' + queId + '_div').find('.nps_hidden_selected_values').val('');
                                    }
                                } else if (hide_question_type == "check-box" || hide_question_type == "boolean") {
                                    $.each($('#' + queId + '_div').find('input[type=checkbox]'), function () {
                                        $(this).prop('checked', false);
                                    });
                                } else if (hide_question_type == "scale") {
                                    $('.' + queId).find('.ui-slider-range').css('width', '0%');
                                    $('.' + queId).find('.ui-slider-handle').css('left', '0%');
                                    $('.' + queId).find('.tooltip-score').find('div').html('0');
                                    $('.' + queId + '_scale').val('0')
                                } else if (hide_question_type == "date-time") {
                                    $('.' + queId + '_datetime').val('');
                                } else if (hide_question_type == "rating") {
                                    $('#' + queId + '_div').find('.rating').removeClass('selected');
                                    $('.' + queId).val('');
                                } else if (hide_question_type == "matrix") {
                                    $.each($('#' + queId + '_div').find('input[type=radio]'), function () {
                                        $(this).prop('checked', false);
                                    });
                                    $.each($('#' + queId + '_div').find('input[type=checkbox]'), function () {
                                        $(this).prop('checked', false);
                                    });
                                } else if (hide_question_type == "dropdownlist") {
                                    $('.' + queId).val('selection_default_value_dropdown');
                                } else {
                                    $('.' + queId).val('');
                                }
                            });
                        }
                    }
                }
                //while question type is multiselect on showhide question
                else if (question_type == "multiselectlist") {
                    $.each($(el).parent().find('option'), function () {
                        if (this.value != '') {
                            $.each(answers[this.value], function (action, target) {
                                if (action == "show_hide_question") {
                                    var showHideQuesIdsArr = target;
                                    $.each(showHideQuesIdsArr, function (idx, queId) {
                                        if ($('#' + queId + '_div').parents('.form-body').css('display') != 'none') {
                                            var newHeight = $('.bx-viewport').height() - ($('#' + queId + '_div').parents('.form-body').innerHeight() + 15);
                                            $('.bx-viewport').height(newHeight);
                                        }
                                        $('#' + queId + '_div').parents('.form-body').hide();
                                        var hide_question_type = $('#' + queId + '_div').parents('.form-body').attr('class').split(' ')[1];
                                        //re-setting value while uncheck the element
                                        if (hide_question_type == "radio-button") {
                                            $.each($('#' + queId + '_div').find('input[type=radio]'), function () {
                                                $(this).prop('checked', false);
                                            });
                                        } else if (hide_question_type == "emojis") {
                                            $('.' + queId).parents('.emojis_class').find('.Emoji').hide();
                                            $('.' + queId).parents('.emojis_class').find('.Grey_Emoji').show();
                                        } else if (hide_question_type == "netpromoterscore") {
                                            var npsSelID = $('#' + queId + '_div').find('.nps_hidden_selected_values_id').val();
                                            var npsSelVal = $('#' + queId + '_div').find('.nps_hidden_selected_values').val();
                                            if (npsSelID != '') {
                                                var bgcolor = '#ff5353';
                                                if (npsSelVal > 6 && npsSelVal <= 8) {
                                                    bgcolor = '#e9e817';
                                                } else if (npsSelVal > 8 && npsSelVal <= 10) {
                                                    bgcolor = '#92d51a';
                                                }
                                                $('#' + queId + '_div').find('#' + npsSelID).css('background-color', bgcolor);
                                                $('#' + queId + '_div').find('.nps_hidden_selected_values_id').val('');
                                                $('#' + queId + '_div').find('.nps_hidden_selected_values').val('');
                                            }
                                        } else if (hide_question_type == "check-box" || hide_question_type == "boolean") {
                                            $.each($('#' + queId + '_div').find('input[type=checkbox]'), function () {
                                                $(this).prop('checked', false);
                                            });
                                        } else if (hide_question_type == "scale") {
                                            $('.' + queId).find('.ui-slider-range').css('width', '0%');
                                            $('.' + queId).find('.ui-slider-handle').css('left', '0%');
                                            $('.' + queId).find('.tooltip-score').find('div').html('0');
                                            $('.' + queId + '_scale').val('0')
                                        } else if (hide_question_type == "date-time") {
                                            $('.' + queId + '_datetime').val('');
                                        } else if (hide_question_type == "rating") {
                                            $('#' + queId + '_div').find('.rating').removeClass('selected');
                                            $('.' + queId).val('');
                                        } else if (hide_question_type == "matrix") {
                                            $.each($('#' + queId + '_div').find('input[type=radio]'), function () {
                                                $(this).prop('checked', false);
                                            });
                                            $.each($('#' + queId + '_div').find('input[type=checkbox]'), function () {
                                                $(this).prop('checked', false);
                                            });
                                        } else if (hide_question_type == "dropdownlist") {
                                            $('.' + queId).val('selection_default_value_dropdown');
                                        } else {
                                            $('.' + queId).val('');
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
                //while question type is dropdown on showhide question
                else if (question_type == "dropdownlist") {
                    $.each($(el).find('option'), function () {
                        if (this.value != '' && this.value != 'selection_default_value_dropdown') {
                            $.each(answers[this.value], function (action, target) {
                                if (action == "show_hide_question") {
                                    var showHideQuesIdsArr = target;
                                    $.each(showHideQuesIdsArr, function (idx, queId) {
                                        if ($('#' + queId + '_div').parents('.form-body').css('display') != 'none') {
                                            var newHeight = $('.bx-viewport').height() - ($('#' + queId + '_div').parents('.form-body').innerHeight() + 15);
                                            $('.bx-viewport').height(newHeight);
                                        }
                                        $('#' + queId + '_div').parents('.form-body').hide();
                                        var hide_question_type = $('#' + queId + '_div').parents('.form-body').attr('class').split(' ')[1];
                                        //re-setting value while uncheck the element
                                        if (hide_question_type == "radio-button") {
                                            $.each($('#' + queId + '_div').find('input[type=radio]'), function () {
                                                $(this).prop('checked', false);
                                            });
                                        } else if (hide_question_type == "emojis") {
                                            $('.' + queId).parents('.emojis_class').find('.Emoji').hide();
                                            $('.' + queId).parents('.emojis_class').find('.Grey_Emoji').show();
                                        } else if (hide_question_type == "netpromoterscore") {
                                            var npsSelID = $('#' + queId + '_div').find('.nps_hidden_selected_values_id').val();
                                            var npsSelVal = $('#' + queId + '_div').find('.nps_hidden_selected_values').val();
                                            if (npsSelID != '') {
                                                var bgcolor = '#ff5353';
                                                if (npsSelVal > 6 && npsSelVal <= 8) {
                                                    bgcolor = '#e9e817';
                                                } else if (npsSelVal > 8 && npsSelVal <= 10) {
                                                    bgcolor = '#92d51a';
                                                }
                                                $('#' + queId + '_div').find('#' + npsSelID).css('background-color', bgcolor);
                                                $('#' + queId + '_div').find('.nps_hidden_selected_values_id').val('');
                                                $('#' + queId + '_div').find('.nps_hidden_selected_values').val('');
                                            }
                                        } else if (hide_question_type == "check-box" || hide_question_type == "boolean") {
                                            $.each($('#' + queId + '_div').find('input[type=checkbox]'), function () {
                                                $(this).prop('checked', false);
                                            });
                                        } else if (hide_question_type == "scale") {
                                            $('.' + queId).find('.ui-slider-range').css('width', '0%');
                                            $('.' + queId).find('.ui-slider-handle').css('left', '0%');
                                            $('.' + queId).find('.tooltip-score').find('div').html('0');
                                            $('.' + queId + '_scale').val('0')
                                        } else if (hide_question_type == "date-time") {
                                            $('.' + queId + '_datetime').val('');
                                        } else if (hide_question_type == "rating") {
                                            $('#' + queId + '_div').find('.rating').removeClass('selected');
                                            $('.' + queId).val('');
                                        } else if (hide_question_type == "matrix") {
                                            $.each($('#' + queId + '_div').find('input[type=radio]'), function () {
                                                $(this).prop('checked', false);
                                            });
                                            $.each($('#' + queId + '_div').find('input[type=checkbox]'), function () {
                                                $(this).prop('checked', false);
                                            });
                                        } else if (hide_question_type == "dropdownlist") {
                                            $('.' + queId).val('selection_default_value_dropdown');
                                        } else {
                                            $('.' + queId).val('');
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
                var sel_optIds = new Array();
                //while multiple choice option for show hide question
                if (question_type == "multiselectlist" || question_type == "check-box") {
                    if (question_type == "multiselectlist") {
                        var ans_id = $(el).val();
                    } else {
                        var ans_id = new Array();
                        $.each($(el).parent().parent().parent().find('input[type=checkbox]:checked'), function () {
                            ans_id.push(this.value);
                        });
                    }
                    var action = new Object();
                    $.each(ans_id, function (indx, value) {
                        $.each(answers[value], function (key, value) {
                            if (key != "no_logic") {
                                action[key] = value
                            }
                        });
                    });
                    var logic_target = '';
                    var logic_action = '';
                    $.each(action, function (act, tar) {
                        if (act == 'show_hide_question') {
                            sel_optIds.push(true);
                            logic_action = act;
                            logic_target = tar;
                        } else {
                            sel_optIds.push(false);
                        }
                    });
                    var answers_obj = answers;
                    if (sel_optIds.indexOf(true) !== -1) {
                        $.each(logic_target, function (idx, queId) {
                            if (answers_obj[$(el).val()] && answers_obj[$(el).val()]['show_hide_question'] && $.inArray(queId, answers_obj[$(el).val()]['show_hide_question']) !== -1)
                            {
                                var newHeight = $('#' + queId + '_div').parents('.form-body').innerHeight() + $('.bx-viewport').height() + 15;
                                $('.bx-viewport').height(newHeight);
                                $('#' + queId + '_div').parents('.form-body').show();
                            }
                        });
                    }
                }
                //while single choice option for show hide question
                else if (question_type == "emojis" || question_type == "radio-button" || question_type == "dropdownlist" || question_type == "boolean" || question_type == "netpromoterscore") {

                    var ans_id = el.value
                    if (question_type == "netpromoterscore") {
                        ans_id = el.id
                    }
                    if (question_type == "emojis") {
                        ans_id = $(el).find('input[type=radio]').val();
                    }
                    $.each(answers[ans_id], function (key, value) {
                        logic_action = key;
                    });
                    var logic_target = answers[ans_id][logic_action];
                    var act = '';
                    $.each(answers[ans_id], function (key, value) {
                        act = key;
                    });
                    if (!$(el).prop('checked') && question_type == "boolean") {
                        act = 'no_logic';
                    }
                    if (act == 'show_hide_question') {
                        $.each(logic_target, function (idx, queId) {
                            var newHeight = $('#' + queId + '_div').parents('.form-body').innerHeight() + $('.bx-viewport').height() + 15;
                            $('.bx-viewport').height(newHeight);
                            $('#' + queId + '_div').parents('.form-body').show();
                        });
                    }
                }
            }
            function addOtherField(el) {
                var que_id = $(el).parents('.form-body').find('.questionHiddenField').val();
                var placeholder_label = $('[name=placeholder_label_other_' + que_id + ']').val();
                if (!placeholder_label)
                {
                    placeholder_label = 'Other';
                }

                if ($(el).val())
                {
                    var isOtherSelected = false;
                    // Radio type of answer
                    if (el.type == 'radio')
                    {
                        var value_selected = $(el).attr('class');
                    }
                    // Dropdown type of answer
                    else if (el.type == 'select-one')
                    {
                        var value_selected = $('[value=' + $(el).val() + ']').attr('class');
                    }
                    // Multi select list 
                    else if (el.type == 'select-multiple') {
                        var selected_ans_ids = $(el).val();
                        var value_selected = '';
                        $.each(selected_ans_ids, function (key, id)
                        {
                            value_selected += $('[value=' + id + ']').attr('class');
                        });
                    }
                    // other than check box type than get value from array of selected values
                    if (el.type != 'checkbox' && value_selected.includes('is_other_option'))
                    {
                        isOtherSelected = true;
                    }
                    // if check box then retrieve value from all selected values by class id
                    else if (el.type == 'checkbox')
                    {
                        value_selected = el.classList[0];
                        var sel_array = new Array();
                        $.each($('.' + value_selected + ':checked'), function () {
                            if (this.className.includes('is_other_option'))
                            {
                                isOtherSelected = true;
                            }
                        });
                    }
                }
                // if othet input field not exists and other option selected then show it
                if (isOtherSelected && $(el).parents('.option').find('.other_option_input').length == 0)
                {
                    if (el.type == 'select-one' && $('#survey_theme').val() == 'theme0')
                    {
                        var add = 'style="width:55%;margin-top:10px;margin-left:20px;';
                    } else if (el.type == 'select-one')
                    {
                        var add = 'style="width:55%;margin-top:10px;';
                    } else if (el.type == 'select-multiple') {
                        var add = 'style="margin-top:20px;width:55%;';
                    } else {
                        var add = 'style="margin-top:10px;width:55%;';
                    }
                    if ($('#survey_theme').val() == 'theme0')
                    {
                        add += 'margin-top:10px;width:55%;margin-left:25px;';
                    }
                    add += '"';
                    var question_id = $(el).parents('.form-body').find('.questionHiddenField').val();
                    $(el).parents('.option').append("<input " + add + " class='form-control " + question_id + "_other other_option_input' type='text' name='" + el.name + "' class='{$que_id}' placeholder='" + placeholder_label + "'>");
                    var newHeight = $('.bx-viewport').height() + $(el).parents('.option').find('.other_option_input').height() + 15;
                    $('.bx-viewport').height(newHeight);
                }
                // other option not selected and if other input field exists then remove it
                else if (!isOtherSelected) {
                    if ($(el).parents('.option').find('.other_option_input').length != 0)
                    {
                        var newHeight = $('.bx-viewport').height() - ($('.other_option_input').height() + 15);
                        $('.bx-viewport').height(newHeight);
                    }
                    $(el).parents('.option').find('.other_option_input').remove();
                }
            }
            function validateUploadedFile(evt, fileSize, fileExtension) {
                var valid_fileext = fileExtension.split(',');
                var file_sizeBytes = {'1000000': '1 MB', '2000000': '2 MB', '3000000': '3 MB', '4000000': '4 MB', '5000000': '5 MB'};
                var file_size_validated = true;
                var file_name = evt.value;
                var len = file_name.split('.').length;
                var extracted_filename = file_name.split('.');
                var file_ext = extracted_filename[len - 1];
                file_ext = file_ext.toUpperCase();
                if ($.inArray(file_ext, valid_fileext) == '-1') {
                    evt.value = '';
                    $(evt).parents('.doc-attachment').find('.file_uploaded').find('.imgcontent').html('');
                    $(evt).parents('.doc-attachment').find('.val-msg-upload').html('You have uploaded Invalid file.<div style="display: inline-block;float: right;"><img class="questionImgIcon" style="top:initial" onmouseout="removeHelpTipPopUpDiv();" onmouseover="openFileUploadPopUpSurvey(this,\'' + fileExtension + '\' );" src="custom/include/survey-img/question.png" ></div>');
                    $(evt).parents('.doc-attachment').find('.val-msg-upload').css('display', 'inline-block');
                } else if (evt.files[0].size > fileSize) {
                    file_size_validated = false;
                    evt.value = '';
                    $(evt).parents('.doc-attachment').find('.file_uploaded').find('.imgcontent').html('');
                    $(evt).parents('.doc-attachment').find('.val-msg-upload').html('Please upload file upto size ' + file_sizeBytes[fileSize]);
                    $(evt).parents('.doc-attachment').find('.val-msg-upload').css('display', 'inline-block');
                }
                if (file_size_validated) {
                    var ext = file_ext;
                    switch (ext.toLowerCase()) {
                        case 'csv':
                        case 'doc':
                        case 'docx':
                        case 'html':
                        case 'htm':
                        case 'jpg':
                        case 'jpeg':
                        case 'ods':
                        case 'odt':
                        case 'pdf':
                        case 'png':
                        case 'ppt':
                        case 'pps':
                        case 'rtf':
                        case 'sxw':
                        case 'tab':
                        case 'txt':
                        case 'text':
                        case 'tsv':
                        case 'xls':
                        case 'xlsx':
                            $(evt).parents('.doc-attachment').find('.file_uploaded').find('.imgcontent').html(evt.files[0].name + '&nbsp;&nbsp;<a style="cursor:pointer; color:red;" onclick="removeAttachment(this)">Remove</a>');
                            $(evt).parents('.doc-attachment').find('.val-msg-upload').css('display', 'none');
                            var reader = new FileReader();
                            // Closure to capture the file information.
                            reader.onload = (function (theFile) {
                                return function (e) {
                                    // Render thumbnail.
                                    $(evt).parents('.doc-attachment').find('.file_uploaded_content').val(e.target.result);

                                };
                            })(evt.files[0]);
                            // Read in the image file as a data URL.
                            reader.readAsDataURL(evt.files[0]);
                            break;
                        default:
                            evt.value = '';
                            $(evt).parents('.doc-attachment').find('.file_uploaded').find('.imgcontent').html('');
                            $(evt).parents('.doc-attachment').find('.val-msg-upload').html('You have uploaded Invalid file.<div style="display: inline-block;float: right;"><img class="questionImgIcon" style="top:initial" onmouseout="removeHelpTipPopUpDiv();" onmouseover="openFileUploadPopUpSurvey(this,\'' + fileExtension + '\' );"  src="custom/include/survey-img/question.png" ></div>');
                            $(evt).parents('.doc-attachment').find('.val-msg-upload').css('display', 'inline-block');

                    }
                }
            }
            function removeAttachment(el)
            {
                if ($(el).parents('.doc-attachment').find('.attched_doc').length != 0)
                {
                    var doc_id = $(el).parents('.doc-attachment').find('.attched_doc').val();
                    $(el).parents('.doc-attachment').find('.removed_doc').val(doc_id);
                    $(el).parents('.doc-attachment').find('.attached_file_name').val('');
                }
                $(el).parents('.doc-attachment').find('input[type=file]').val('');
                $(el).parents('.doc-attachment').find('.file_uploaded').find('.imgcontent').html('');
                $(el).remove();
            }
            function changeBoolCheckBoxVal(el) {
                if ($(el).prop('checked'))
                {
                    var false_que_id = $(el).parents('.boolean-list').find('.hidden_bool_false').val();
                    $(el).parents('.boolean-list').find('.hidden_bool_false').attr('false-ans-id', false_que_id);
                    $(el).parents('.boolean-list').find('.hidden_bool_false').val('');
                } else {
                    var false_que_id = $(el).parents('.boolean-list').find('.hidden_bool_false').attr('false-ans-id');
                    $(el).parents('.boolean-list').find('.hidden_bool_false').val(false_que_id);
                }
            }
        </script>
    </head>
    <div id="overlay" class="overlay">
        <div id="formProcessLoader" align="center"><img src="themes/default/images/sqsWait.gif" ><b>Please wait...</b></div>
        <div id="formLoaderDisabledScreenDiv" class=""  style="background:none repeat scroll 0 0 #000000; opacity: 0.15;z-index: 999;position: fixed;top: 0;left: 0;right: 0;bottom: 0; height:auto;">&nbsp;</div>
    </div>
    <body>
        <?php
        if ($survey->survey_theme == 'theme0') {

            require_once 'include/utils/autoloader.php';
            SugarAutoloader::init();
            $file_custom = 'custom/themes/default/images/company_logo.png';
            $file_default = 'themes/default/images/company_logo.png';
            if (SugarAutoloader::fileExists($file_custom)) {
                $company_logo = $file_custom;
            } else if (SugarAutoloader::fileExists($file_default)) {
                $company_logo = $file_default;
            }

            // Set Sugar Header
            ?>
            <div id="sugarcrm">
                <div id="sidecar">
                    <div id="header">
                        <div class="navbar">
                            <div class="navbar-inner">
                                <div class="nav-collapse" style="padding:10px">

                                    <img src="<?php echo $company_logo; ?>" alt="SugarCRM" style="height:27px;">

                                </div><!-- /navbar-inner -->
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <input type ="hidden" id="customer_name" value="<?php echo $customer_name; ?>"/>
                    <input type="hidden" id="survey_theme" value="<?php echo $survey->survey_theme; ?>">
                    <?php foreach ($survey_details as $page_sequence => $detail) { ?>
                        <input type="hidden" value="<?php echo $page_sequence ?>" id="<?php echo $detail['page_id']; ?>" name="skipp_page_sequence"/>
                    <?php } ?>
                    <div class="bg"></div>
                    <?php if (isset($available_lang) && count($available_lang) != 0) {
                        ?>
                        <div id="lang_selection">
                            <p>
                                Select Survey Language : <select id="selected_lang">
                                    <option value="<?php echo $sugar_config['default_language']; ?>"><?php echo $langValues[$sugar_config['default_language']]; ?></option>
                                    <?php
                                    foreach ($available_lang as $key => $lang) {
                                        $selected = '';

                                        if ($key == $selected_lang) {
                                            $selected = 'selected';
                                        }
                                        ?>
                                        <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $lang ?> </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </p>
                        </div>
                    <?php } ?>
                    <div class="main-container">

                        <div id='tooltipDiv'></div>

                        <form method="post" name="survey_submisssion" action="" id="survey_submisssion" enctype="multipart/form-data">
                            <input type="hidden" value="" id="btn_submit_click_flag" name="btn_submit_click_flag" />
                            <input type="hidden" value="" class="show_question_list" name="show_question_list" />
                            <?php foreach ($survey_details as $page_sequence => $detail) { ?>
                                <input type="hidden" value="<?php echo $page_sequence ?>" id="<?php echo $detail['page_id']; ?>" name="skipp_page_sequence"/>
                            <?php } ?>
                            <?php
                            $totalpages = count($survey_details);
                            if ($survey->id) {
                                $sql = "SELECT image FROM bc_survey WHERE id='{$survey->id}'";

                                // the result of the query
                                $result = $db->query($sql);

                                // set the header for the image
                                while ($row = $db->fetchRow($result)) {
                                    $base64 = base64_encode($row['image']);
                                }
                            }
                            if (!empty($survey->id)) {
                                ?>

                                <div class="top-section">
                                    <div class="header">
                                        <div class="">
                                            <?php
                                            if ($survey->survey_theme != 'theme0') {
                                                // Set Sugar Header
                                                ?>
                                                <h1 class="logo">
                                                <?php } else { ?>
                                                    <h1 class="survey-logo">
                                                        <?php
                                                    }

                                                    if (!empty($base64)) {
                                                        ?>
                                                        <img src="data:image/png;base64,<?php echo $base64; ?>" alt=""/>
                                                    <?php } ?>
                                                </h1>
                                                <div class="survey-header"><h2> <?php
                                                    if (!empty($list_lang_detail) && !empty($list_lang_detail[$survey_id . '_survey_title'])) {
                                                        echo $list_lang_detail[$survey_id . '_survey_title'];
                                                    } else {
                                                        echo html_entity_decode($survey->name);
                                                    }
                                                    ?></h2></div> 
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            if ($survey->survey_theme == 'theme0') {
                                // Set Sugar Header
                                ?><p></p>
                            <?php } ?>
                            <div class="survey-container">
                                <input type="hidden" name="redirect_action" value="" id="redirect_action_value">
                                <?php
                                if (!empty($redirect_url) && trim($redirect_url) != "http://" && $redirect_flag == true) {
                                    if (!preg_match("@^[hf]tt?ps?://@", $redirect_url)) {
                                        $redirect_url = "http://" . $redirect_url;
                                    }
                                    echo "<script>window.location.replace('" . $redirect_url . "');</script>";
                                } else if ($msg != '') {
                                    echo $msg . "<script type='text/javascript'>$('#overlay').fadeOut();</script>";
                                    exit;
                                }
                                ?>
                                <?php
                                if (isset($msg1) && $msg1 != '') {
                                    echo "{$msg1}" . "</div><script type='text/javascript'>$('#overlay').fadeOut();</script>";
                                    if ($survey->footer_content != "") {
                                        $footer = '<div class="survey-footer">';
                                        $footer .= '     <center>' . html_entity_decode($survey->footer_content) . '</center>';
                                        $footer .= '</div>';
                                        echo $footer;
                                    }
                                } else {
                                    ?>
                                    <div class="container">
                                        <div class="survey-form form-desc">
                                            <div class="form-body">
                                                <?php if ($totalpages > 1) { ?>
                                                    <ul class="progress-bar">

                                                        <?php
                                                        // Setting Page Header
                                                        if ($is_progress_indicator != 1) {
                                                            foreach ($survey_details as $page_sequence => $detail) {
                                                                if ($survey->survey_theme == 'theme2' || $survey->survey_theme == 'theme6' || $survey->survey_theme == 'theme7' || $survey->survey_theme == 'theme8') {
                                                                    ?>

                                                                    <li class="hexagon" style='cursor: default'><span class="pro-text"><?php echo 'Page ' . $page_sequence; ?></span><a style='cursor: default'><?php echo $page_sequence; ?></a></li> 

                                                                    <?php
                                                                } else {
                                                                    ?>

                                                                    <li class="hexagon" style='cursor: default'><span class="pro-text"><?php echo 'Page'; ?></span><a style='cursor: default'><?php echo $page_sequence; ?></a></li> 

                                                                    <?php
                                                                }
                                                            }
                                                        } else {
                                                            ?>
                                                            <section style="width:100%">
                                                                <div id="pagecount" class="equal text"  style="width:5%"></div>
                                                                <div id="progress" class="equal" style="width:85%"></div>
                                                                <div id="progress-percentage" class="equal text last" style="width:5%"></div>
                                                            </section>
                                                        <?php } ?>
                                                        <div class="shape">
                                                            <span class="arr-right"></span>
                                                        </div>
                                                        </li>
                                                    </ul>
                                                <?php } else { ?>

                                                    <?php
                                                }
                                                if (!empty($list_lang_detail) && !empty($list_lang_detail[$survey_id . '_survey_description'])) {
                                                    echo nl2br($list_lang_detail[$survey_id . '_survey_description']);
                                                } else {
                                                    echo nl2br($survey->description);
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <ul class="bxslider">
                                            <?php
                                            $addClass = '';
                                            $totalpages = count($survey_details);
                                            if ($totalpages <= 1 && (empty($survey->survey_welcome_page) || $survey->survey_welcome_page == '&lt;p&gt;&lt;br data-mce-bogus=&quot;1&quot;&gt;&lt;/p&gt;' || $survey->survey_welcome_page == '&lt;p&gt;&amp;nbsp;&lt;br&gt;&lt;/p&gt;')) {
                                                $addClass = 'hideBtn';
                                            }
                                            $img_flag = false;
                                            $que_no = 0;

                                            // set up WELCOME Page
                                            if (!empty($survey->survey_welcome_page) && $survey->survey_welcome_page != '&lt;p&gt;&lt;br data-mce-bogus=&quot;1&quot;&gt;&lt;/p&gt;' && $survey->survey_welcome_page != '&lt;p&gt;&amp;nbsp;&lt;br&gt;&lt;/p&gt;') {
                                                ?>				
                                                <li>
                                                    <div class="survey-form welcome-form">
                                                        <?php
                                                        if (!empty($list_lang_detail) && !empty($list_lang_detail['survey_welcome_page'])) {
                                                            $welcome_content = base64_decode($list_lang_detail['survey_welcome_page']);
                                                        } else {
                                                            $welcome_content = $survey->survey_welcome_page;
                                                        }
                                                        echo '<div class="form-body">' . html_entity_decode_utf8($welcome_content) . '</div>';
                                                        ?>

                                                    </div>
                                                </li>
                                                <?php
                                            }

                                            foreach ($survey_details as $page_sequence => $detail) {
                                                $queArraylist[$page_sequence] = getSubmittedAnswerByReciever($survey_id, $module_id);
                                                ?>
                                                <li>
                                                    <div class="survey-form">
                                                        <div class="form-header">
                                                            <h1><?php echo $detail['page_title']; ?></h1>
                                                            <span class="page-no"><i><?php echo $page_sequence ?></i></span>
                                                        </div>
                                                        <?php
                                                        if (isset($showHideQuesArrayOnPageload[$page_sequence])) {
                                                            foreach ($showHideQuesArrayOnPageload[$page_sequence] as $ans_ID => $hideQuesarray) {
                                                                ?>
                                                                <input type='hidden' id='show_hide_question_Ids_<?php echo $ans_ID; ?>' value='<?php echo implode(',', $hideQuesarray) ?>'/>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        <?php foreach ($detail['page_questions'] as $que_sequence => $question) { ?>
                                                            <?php
                                                            $separator_css = '';
                                                            if ($question['is_question_seperator'] == 1) {
                                                                $separator_css = 'border-bottom: 1px solid #dddddd !important';
                                                            }
                                                            $display_qes = "display:''";
                                                            $showOnload = false;
                                                            if (isset($queArraylist[$page_sequence])) {
                                                                foreach ($queArraylist[$page_sequence] as $submitAns) {
                                                                    if (in_array($question['que_id'], $showHideQuesArrayOnPageload[$page_sequence][$submitAns])) {
                                                                        $showOnload = true;
                                                                    }
                                                                }
                                                            }
                                                            if (isset($skip_logicArrForHideQues['show_hide_question']) && isset($skip_logicArrForHideQues['show_hide_question'][$page_sequence])) {
                                                                foreach ($skip_logicArrForHideQues['show_hide_question'][$page_sequence] as $indx => $questionid) {
                                                                    if (in_array($question['que_id'], $skip_logicArrForHideQues['show_hide_question'][$page_sequence][$indx]) && !$showOnload) {
                                                                        $display_qes = 'display:none';
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                            <div class="form-body <?php echo $question['que_type']; ?>" style="<?php echo $display_qes; ?>;margin-top: 14px;<?php echo $separator_css; ?>">
                                                                <input type="hidden" class="questionHiddenField" name="questions[]" value="<?php echo $question['que_id'] ?>"  >
                                                                <?php
                                                                $queArray = isset($sbmtSurvData[$question['que_id']]) ? $sbmtSurvData[$question['que_id']] : array();
                                                                $queAnsArray = array_values($queArray);
                                                                $answer = isset($queAnsArray[0]) && $queAnsArray[0] != 'N/A' ? $queAnsArray[0] : '';
                                                                if ($question['que_type'] == "emojis") {
                                                                    $answerId = (isset($queArray['answerId'])) ? $queArray['answerId']: '';
                                                                    $answer_sequence = (isset($queArray['answer_sequence'])) ? $queArray['answer_sequence']: '';
                                                                    $answer_name = (isset($queArray['answer_name'])) ? $queArray['answer_name']: '';
                                                                    $answer = array('answerId' => $answerId, 'answer_sequence' => $answer_sequence, 'answer_name' => $answer_name);
                                                                }
                                                                if ($question['que_type'] == "contact-information") {
                                                                    $answer = explode(",", $answer);
                                                                }
                                                                if ($question['que_type'] == 'section-header') {
                                                                    $que_class = 'section-header-div';
                                                                } else if ($question['que_type'] == 'additional-text') {
                                                                    echo '<div style="font-size:14px;">' . nl2br($question['description']) . '</div>';
                                                                } else {
                                                                    $que_class = '';
                                                                    ?>

                                                                    <h3 class="questions <?php echo $que_class ?>">
                                                                        <?php
                                                                        if ($question['que_type'] == 'image' || $question['que_type'] == 'video') {
                                                                            echo $question['question_help_comment'];
                                                                        } else if ($question['que_type'] == 'section-header') {
                                                                            echo '<div class="question-section">' . $question['que_title'] . '</div>';
                                                                        } else if ($question['que_type'] == 'additional-text' || $question['que_type'] == 'richtextareabox') {
                                                                            // nothing display here
                                                                        } else {
                                                                            $que_no++;
                                                                            $img_flag = false;
                                                                            echo $que_no;
                                                                            ?> .&nbsp; <?php
                                                                            echo $question['que_title'];
                                                                        }
                                                                        ?> 


                                                                        <?php if ($question['is_required'] == 1) { ?> 
                                                                            <span class="is_required" style="color:red;">   *</span>
                                                                            <?php
                                                                        }
                                                                        if ($question['que_type'] == 'image' || $question['que_type'] == 'video') {
                                                                            
                                                                        } else if (!empty($question['question_help_comment'])) {
                                                                            if ($oSurvey->survey_theme != 'theme0') {
                                                                                $extracss = 'padding-right: 35px;';
                                                                            }
                                                                            ?> <div style="display: inline-block;float: right !important; position:absolute;<?php echo $extracss; ?>"><img class="questionImgIcon" onmouseout="removeHelpTipPopUpDiv();" onmouseover="openHelpTipsPopUpSurvey(this, '<?php echo $question['question_help_comment']; ?>');" src="custom/include/survey-img/question.png" ></div>
                                                                        <?php } ?></h3>
                                                                        <?php
                                                                    $GLOBALS['log']->debug("This is the result prefill ----------------- : " . print_r($answer, 1));
                                                                    $richtextContent = '';
                                                                    if ($question['que_type'] == 'richtextareabox') {
                                                                        $richtextContent = $question['richtextContent'];
                                                                    }
                                                                }
                                                                $elementHTML = getMultiselectHTML($skip_logicArrForAll,$question, $answer,$survey->survey_theme, $list_lang_detail, $survey_answer_prefill, $richtextContent);
                                                                echo $elementHTML;
                                                                ?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </li>

                                            <?php } ?>
                                        </ul>
                                        <?php
                                        if (!empty($list_lang_detail) && !empty($list_lang_detail['next_button'])) {
                                            $next_button_label = $list_lang_detail['next_button'];
                                        } else {
                                            $next_button_label = 'Next';
                                        }
                                        if (!empty($list_lang_detail) && !empty($list_lang_detail['prev_button'])) {
                                            $prev_button_label = $list_lang_detail['prev_button'];
                                        } else {
                                            $prev_button_label = 'Prev';
                                        }
                                        if (!empty($list_lang_detail) && !empty($list_lang_detail['submit_button'])) {

                                            $submit_button_label = $list_lang_detail['submit_button'];
                                        } else {
                                            $submit_button_label = 'Submit';
                                        }
                                        ?>

                                    </div>

                                </div>
                                <div class="survey-footer">
                                    <?php
                                    // Agreement
                                    if ($survey->enable_agreement == 1 && !empty($survey->agreement_content)) {
                                        $required_agrement = '';
                                        if ($survey->is_required_agreement == 1) {
                                            $required_agrement = "required='true'";
                                        }
                                        $displaySection = 'style="display:none"';
                                        if (empty($survey->survey_thanks_page) && empty($survey->survey_welcome_page) && $totalpages == 1) {
                                            $displaySection = '';
                                        }
                                        $agreement_html = '<div class="form-body agreement_section" ' . $displaySection . '><div class="form-body">';
                                        $agreement_html .= "<li class='md-checkbox'><label><input type='checkbox' {$required_agrement}  id='agreement_survey' name='consent_accepted' class='agreement_survey'>{$survey->agreement_content}<label for='agreement_survey'>
                                                        <span></span>
                                                            <span class='check'></span>
                                                            <span class='box'></span></label></label></li>";
                                        $agreement_html .= '</div>';
                                        if ($survey->is_required_agreement == 1) {
                                            $agreement_html .= '<div class="required_agree" style="color:red;display:none;"> * This field is required.</div></div>';
                                        } else {
                                            $agreement_html .= '</div>';
                                        }
                                        echo $agreement_html;
                                    }
                                    ?>
                                    <div class="action-block">

                                        <?php if (!empty($module_id) || $isOpenSurveyLink) { ?>
                                            <input class='button btn-submit'  type='submit' value='<?php echo $submit_button_label; ?>' name="btnsend" id="btnsend">
                                        <?php } ?>


                                        <div style="display: inline-block;float: right;"> <input class='bx-prev button hideBtn'  type='button' value='<?php echo $prev_button_label; ?>' name="btnprev" id="btnprev">
                                            <input class='bx-next button <?php echo $addClass; ?> '  type='button' value='<?php echo $next_button_label; ?>' name="btnnext" id="btnnext"></div>
                                    </div>
                                    <?php if ($survey->footer_content != "") { ?>
                                        <center><?php echo html_entity_decode($survey->footer_content); ?></center>
                                    <?php } ?>  
                                </div>
                            <?php } ?>

                        </form>
                    </div>
                    </body>
                    </html>
