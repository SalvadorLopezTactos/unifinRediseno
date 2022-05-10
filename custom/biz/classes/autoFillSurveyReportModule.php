<?php
/*
 * The file used to auto fill Survey Report supported module entries
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

require_once('include/entryPoint.php');
require_once('include/SugarQuery/SugarQuery.php');

function oneTimeScriptToRepairReportData() {
    global $sugar_config, $app_strings, $db;
    $adminObj = new Administration();
    $adminObj->retrieveSettings('SurveyPlugin');
    $isDataRepair = $adminObj->settings['SurveyPlugin_ReportDataRepair'];
    if (!$isDataRepair || $isDataRepair == '') {
        $adminObj->saveSetting("SurveyPlugin", "ReportDataRepair", 1);

//check bc_survey_submit_answer_calculation table exists or not
        $sql = $db->query("SELECT 
                       distinct table_name 
                    FROM
                        information_schema.tables
                    WHERE
                        table_name = 'bc_survey_submit_question'");
        $count_num_rows = 0;
        while ($anser_rows = $db->fetchByAssoc($sql)) {
            $count_num_rows++;
        }

// Table exists for Survey Report Support
        if ($count_num_rows >= 1) { //*******************!!!!!!!!!!!!!!!!!!!!!!!
            $result = $db->query("SELECT * FROM bc_survey_submit_question");
            $count_num_rows1 = 0;
            while ($anser_rows = $db->fetchByAssoc($result)) {
                $count_num_rows1++;
                break;
            }
            // If survey submitted question table is empty then insert data from survey submission accordingly
            if ($count_num_rows1 >= (int) 0) { //*******************!!!!!!!!!!!!!!!!!!!!!!!
                $surveysResult = $db->query("SELECT id,target_parent_id FROM bc_survey_submission WHERE status='Submitted' and deleted=0  ");
                while ($row = $db->fetchByAssoc($surveysResult)) {

                    // check whether the same entry exists in submited table or not 
                    $submission_id = $row['id'];
                    $result = $db->query("SELECT * FROM bc_survey_submit_question WHERE submission_id = '$submission_id'");
                    $count_num_rows2 = 0;
                    while ($anser_rows = $db->fetchByAssoc($result)) {
                        $count_num_rows2++;
                        break;
                    }
                    if ($count_num_rows2 == (int) 0) { //*******************!!!!!!!!!!!!!!!!!!!!!!!
                        $oSubmission = BeanFactory::getBean('bc_survey_submission', $submission_id);
                        $oSurveyList = $oSubmission->get_linked_beans('bc_survey_submission_bc_survey', 'bc_survey');

                        $oSurvey = $oSurveyList[0];

                        $survey_id = $oSurvey->id;

                        $isFromSubpanel = "";

                        $resultArray = array();

                        // submission related submitted data
                        $submittedData = $oSubmission->get_linked_beans('bc_submission_data_bc_survey_submission', 'bc_submission_data');
                        $submitedAndIds = array();
                        foreach ($submittedData as $oSubmissionData) {
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
                                        $query->where()->equals('bc_survey_questions.id', $subQue['id']);

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

                                            $submitedAndIds[] = $subAns['id'];
                                        }
                                    }
                                }
                            }
                        }

                        // get actual survey pages and details
                        $surveyPages = $oSurvey->get_linked_beans('bc_survey_pages_bc_survey', 'bc_survey_pages');

                        foreach ($surveyPages as $oPage) {

                            $queList = $oPage->get_linked_beans('bc_survey_pages_bc_survey_questions', 'bc_survey_questions', array('question_sequence'));
                            foreach ($queList as $oQuestion) {
                                if ($oQuestion->question_type != 'section-header' && $oQuestion->question_type != 'richtextareabox' && $oQuestion->question_type != 'image' && $oQuestion->question_type != 'video' && $oQuestion->question_type != 'attachment') {
                                    // addded for report *************************************************************//
                                    $submitted_question_obj = new bc_survey_submit_question();
                                    $submitted_question_obj->retrieve_by_string_fields(array('question_id' => $oQuestion->id, 'receiver_name' => $oSubmission->customer_name));

                                    $submitted_question_obj->question_id = $oQuestion->id;
                                    $submitted_question_obj->receiver_name = $oSubmission->customer_name;
                                    $submitted_question_obj->question_type = $oQuestion->question_type;
                                    $submitted_question_obj->submission_type = $oSubmission->submission_type;
                                    $submitted_question_obj->submission_ip_address = $oSubmission->submission_ip_address;
                                    $submitted_question_obj->submission_date = TimeDate::getInstance()->nowDb();
                                    $submitted_question_obj->schedule_on = $oSubmission->schedule_on;
                                    $submitted_question_obj->survey_title = $oSurvey->name;

                                    $submitted_question_obj->submission_id = $oSubmission->id;
                                    $submitted_question_obj->survey_ID = $survey_id;

                                    $submitted_question_obj->reciepient_module = $oSubmission->target_parent_type;

                                    $submitted_question_obj->name = $oQuestion->name;
                                    $submitted_question_obj->save();
                                    $submitted_question_obj->load_relationship('bc_survey_submit_question_bc_survey_submission');
                                    foreach ($submitted_question_obj->bc_survey_submit_question_bc_survey_submission->getBeans() as $submiss) {
                                        $submitted_question_obj->bc_survey_submit_question_bc_survey_submission->delete($submitted_question_obj->id, $submiss->id);
                                    }
                                    $submitted_question_obj->bc_survey_submit_question_bc_survey_submission->add($oSubmission->id);
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
                                    $submitted_question_obj->bc_survey_questions_bc_survey_submit_question_1->add($oQuestion->id);
                                    // END ***************************************************************************//
                                    // result of Question Detail
                                    $resultArray['pages'][$oPage->id][$oQuestion->id]['matrix_rows'] = $oQuestion->matrix_row;
                                    $resultArray['pages'][$oPage->id][$oQuestion->id]['matrix_cols'] = $oQuestion->matrix_col;
                                    $resultArray['pages'][$oPage->id][$oQuestion->id]['question_title'] = $oQuestion->name;

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
                                        $ansArrForMultAndCheckBoxQues = array();
                                        $ansIDArrForMultAndCheckBoxQues = array();
                                        foreach ($ansList as $oAnswer) {

                                            if (in_array($oAnswer->id, $submitedAndIds) && $oAnswer->answer_type != 'other') {
                                                $ansArrForMultAndCheckBoxQues[] = $oAnswer->answer_name;
                                                $ansIDArrForMultAndCheckBoxQues[] = $oAnswer->id;
                                                $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$oAnswer->id]['answer_id'] = $oAnswer->id;
                                                if ($oQuestion->is_image_option) {
                                                    $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$oAnswer->id]['name'] = (!empty($list_lang_detail[$oAnswer->id])) ? '<span class="option_image"><img src="' . $oAnswer->radio_image . '" style="height:30px;width:30px;"><div class="hover-img"><img src="' . $oAnswer->radio_image . '"></div></span>' . $list_lang_detail[$oAnswer->id] : '<span class="option_image"><img src="' . $oAnswer->radio_image . '" style="height:30px;width:30px;"><div class="hover-img"><img src="' . $oAnswer->radio_image . '"></div></span><span style="margin-left: 5px;vertical-align: -webkit-baseline-middle;">' . $oAnswer->answer_name . '</span>';
                                                } else {
                                                    $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$oAnswer->id]['name'] = (!empty($list_lang_detail[$oAnswer->id])) ? $list_lang_detail[$oAnswer->id] : $oAnswer->answer_name;
                                                }
                                                $resultArray['pages'][$oPage->id][$oQuestion->id]['answers'][$oAnswer->id]['score_weight'] = $oAnswer->score_weight;
                                            } else if ($oAnswer->answer_type == 'other') {
                                                $otherScore = $oAnswer->score_weight;
                                            }
                                            $optionIds[] = $oAnswer->id;
                                        }

                                        // addded for report *************************************************************//
                                        $submitted_ans_obj = new bc_survey_answers();
                                        $submitted_ans_obj->answer_name = implode(',', $ansArrForMultAndCheckBoxQues);
                                        $submitted_ans_obj->name = implode(',', $ansArrForMultAndCheckBoxQues); // fix for report module support
                                        $submitted_ans_obj->description = implode(',', $ansIDArrForMultAndCheckBoxQues); // fix for global filter
                                        $submitted_ans_obj->save();
                                        $submitted_question_obj->load_relationship('bc_survey_submit_question_bc_survey_answers');
                                        $submitted_question_obj->bc_survey_submit_question_bc_survey_answers->add($submitted_ans_obj->id);
                                        //END ****************************************************************************//
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
                                                    // Added Code To DIsplay Matrix Type Question In Sugar Report module. By Biztech
                                                    if ($subQue->id == $oQuestion->id && $oQuestion->question_type == 'matrix') {
                                                        // set matrix answer to question array
                                                        $matrix_row = json_decode(base64_decode(($oQuestion->matrix_row)));
                                                        $matrix_col = json_decode(base64_decode(($oQuestion->matrix_col)));
                                                        $splited_answer = explode('_', $subAns);
                                                        $sp_ans1 = $splited_answer[0];
                                                        $sp_ans2 = $splited_answer[1];
                                                        $ansFinal = $matrix_row->$sp_ans1 . '(' . $matrix_col->$sp_ans2 . ')';
                                                        $submitted_ans_obj = new bc_survey_answers();
                                                        $submitted_ans_obj->answer_name = $ansFinal;
                                                        $submitted_ans_obj->name = $ansFinal; // fix for report module support
                                                        $submitted_ans_obj->save();
                                                        // addded for report *************************************************************//
                                                        $submitted_question_obj->load_relationship('bc_survey_submit_question_bc_survey_answers');
                                                        $submitted_question_obj->bc_survey_submit_question_bc_survey_answers->add($submitted_ans_obj->id);
                                                        //END *************************************************************//
                                                    } else if ($subQue->id == $oQuestion->id) {
                                                        $submitted_ans_id = $subAns;
                                                        $submitted_ans_name = $oAnswer->answer_name;
                                                        $submitted_ans_seq = $oAnswer->answer_sequence;

                                                        // addded for report *************************************************************//
                                                        $oAnswer->name = $oAnswer->answer_name; // fix for report module support
                                                        $oAnswer->save();
                                                        if (!in_array($oQuestion->question_type, $multiselectQuesTypeArra)) {
                                                            $submitted_question_obj->load_relationship('bc_survey_submit_question_bc_survey_answers');
                                                            $submitted_question_obj->bc_survey_submit_question_bc_survey_answers->add($oAnswer->id);
                                                        }
                                                        //END *************************************************************//
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

                                                        // addded for report *************************************************************//
                                                        $subAns->name = $subAns->answer_name; // fix for report module support
                                                        $subAns->save();
                                                        if (!in_array($oQuestion->question_type, $multiselectQuesTypeArra)) {
                                                            $submitted_question_obj->load_relationship('bc_survey_submit_question_bc_survey_answers');
                                                            $submitted_question_obj->bc_survey_submit_question_bc_survey_answers->add($subAns->id);
                                                        }
                                                        //END *************************************************************//
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
                            // each Question Completed
                        }
                        //each Page completed
                    }
                    // each page detailed
                }
                // row of submitted surveys completed
            }
            // submitted table is not empty checked completed
        }
    }
}
