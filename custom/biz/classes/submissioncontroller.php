<?php

/**
 * The file used to handle actions comes from entryPoint for survey
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
//provide current site url to open preview survey page
if ($_REQUEST['method'] == 'preview_survey') {
    global $sugar_config;
    $site_url = $sugar_config['site_url'];
    echo $site_url;
}

//get survey related detail for checking validation in survey-form using ajax call
if ($_REQUEST['method'] == 'get_survey') {
    require_once 'data/BeanFactory.php';
    require_once 'custom/include/utilsfunction.php';
    $record_id = $_REQUEST['record_id'];
    $module_id = $_REQUEST['cid'];
    $sub_id = $_REQUEST['sub_id'];
    $sel_lang = (isset($_REQUEST['selected_lang'])) ? $_REQUEST['selected_lang'] : '';
    $customer_name = $_REQUEST['customer_name'];
    $oSurvey = new bc_survey();
    $oSurvey->retrieve($record_id);
    $oSurvey->load_relationship('bc_survey_pages_bc_survey');
    
    $sbmtSurvData = getPerson_SubmissionExportData($record_id, $module_id, false,$customer_name,$sub_id);

    $oSurvey_details = array();
    $questions = array();
    $rel = $oSurvey->bc_survey_pages_bc_survey;

    foreach ($oSurvey->bc_survey_pages_bc_survey->getBeans() as $pages) {
        unset($questions);
        $survey_details[$pages->page_sequence]['page_number'] = $pages->page_number;
        $survey_details[$pages->page_sequence]['page_id'] = $pages->id;
        $pages->load_relationship('bc_survey_pages_bc_survey_questions');
        foreach ($pages->bc_survey_pages_bc_survey_questions->getBeans() as $survey_questions) {
            $questions[$survey_questions->question_sequence]['que_id'] = $survey_questions->id;
            $questions[$survey_questions->question_sequence]['que_type'] = $survey_questions->question_type;
            $questions[$survey_questions->question_sequence]['is_required'] = ($survey_questions->is_required == 1) ? 'Yes' : 'No';
            $questions[$survey_questions->question_sequence]['is_question_seperator'] = ($survey_questions->is_question_seperator == 1) ? 'Yes' : 'No';
            $questions[$survey_questions->question_sequence]['file_size'] = $survey_questions->file_size;
            $questions[$survey_questions->question_sequence]['file_extension'] = $survey_questions->file_extension;
            //advance options
            $questions[$survey_questions->question_sequence]['advance_type'] = (isset($survey_questions->advance_type)) ? $survey_questions->advance_type : '';
            $questions[$survey_questions->question_sequence]['maxsize'] = (isset($survey_questions->maxsize)) ? $survey_questions->maxsize : '';
            $questions[$survey_questions->question_sequence]['min'] = (isset($survey_questions->min)) ? $survey_questions->min : '';
            $questions[$survey_questions->question_sequence]['max'] = (isset($survey_questions->max)) ? $survey_questions->max : '';
            $questions[$survey_questions->question_sequence]['precision'] = (isset($survey_questions->precision_value)) ? $survey_questions->precision_value : '';
            $questions[$survey_questions->question_sequence]['scale_slot'] = (isset($survey_questions->scale_slot)) ? $survey_questions->scale_slot : '';
            $questions[$survey_questions->question_sequence]['is_datetime'] = (isset($survey_questions->is_datetime) && $survey_questions->is_datetime == 1 ) ? 'Yes' : 'No';
            $questions[$survey_questions->question_sequence]['is_sort'] = (isset($survey_questions->is_sort) && $survey_questions->is_sort == 1 ) ? 'Yes' : 'No';
            $questions[$survey_questions->question_sequence]['limit_min'] = (!empty($survey_questions->limit_min)) ? $survey_questions->limit_min : 0;
            $questions[$survey_questions->question_sequence]['matrix_row'] = (isset($survey_questions->matrix_row)) ? json_decode($survey_questions->matrix_row) : '';
            $questions[$survey_questions->question_sequence]['matrix_col'] = (isset($survey_questions->matrix_col)) ? json_decode($survey_questions->matrix_col) : '';
            $questions[$survey_questions->question_sequence]['allow_future_dates'] = (isset($survey_questions->allow_future_dates) && $survey_questions->allow_future_dates == 1 ) ? 'Yes' : 'No';

            $survey_questions->load_relationship('bc_survey_answers_bc_survey_questions');
            foreach ($survey_questions->bc_survey_answers_bc_survey_questions->getBeans() as $survey_answers) {
                $questions[$survey_questions->question_sequence]['answers'][$survey_answers->answer_sequence][$survey_answers->id] = $survey_answers->answer_name;
            }
            if (isset($questions[$survey_questions->question_sequence]['answers']) && is_array($questions[$survey_questions->question_sequence]['answers'])) {
                ksort($questions[$survey_questions->question_sequence]['answers']);
            } else if ($survey_questions->question_type == 'scale') {
                
                $queArray = (isset($sbmtSurvData[$questions[$survey_questions->question_sequence]['que_id']])) ? $sbmtSurvData[$questions[$survey_questions->question_sequence]['que_id']] : array();
                $queAnsArray = array_values($queArray);

                $answer = (isset($queAnsArray[0])) ? $queAnsArray[0] : "";
                $questions[$survey_questions->question_sequence]['answers'] = $answer;
            }
        }
        ksort($questions);

        $survey_details[$pages->page_sequence]['page_questions'] = $questions;
    }

    ksort($survey_details);

    $data['survey_details'] = $survey_details;
    $lang_survey_details = return_app_list_strings_language($sel_lang);
    $data['lang_survey_details'] = (isset($lang_survey_details[$record_id])) ? $lang_survey_details[$record_id] : "";
    $result = json_encode($data);
    
    echo $result;
}
