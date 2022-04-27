<?php

/**
 * The file used to set scheduler job for making pending survey transaction entry
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$job_strings[] = 'schedulesurveys';

/**
 * Used to send survey after matching all conditions
 *
 * @return     bool TRUE - survey is send
 */
function schedulesurveys() {

    global $db;
    
    $get_qry = "SELECT * FROM survey_submission_pending_entries GROUP BY module_id,survey_id,module_name";
    $result = $db->query($get_qry);
    while($row = $db->fetchByAssoc($result)){
        if(!empty($row['module_id'])){
            $response = submission_entry($row['module_name'],$row['module_id'],$row['survey_id']);
            if($response == true){
                $db->query("DELETE FROM survey_submission_pending_entries WHERE survey_id = '{$row['survey_id']}' AND module_id = '{$row['module_id']}' AND module_name = '{$row['module_name']}' ");
            }
        }
    }
}

/*
 * this function is used for checking conditions for given modules are met or not
 * 
 * @params
 * $automizerId - automizer id
 * $isNew - is new record saving or updating flag
 * $bean - current bean
 */

function submission_entry($module_name, $rec_module_id, $survey_id) {
    
    if (!empty($schedule_on_date) && !(empty($schedule_on_time))) {
        $gmtdatetime = TimeDate::getInstance()->to_db($schedule_on_date . " " . $schedule_on_time);
    } else {
        $gmtdatetime = TimeDate::getInstance()->nowDb();
    }

    switch ($module_name) {
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

    $focus->retrieve($rec_module_id);
    $record_name = $focus->name;
    $rec_module = $module_name;

    /*
     * Store survey data start
     */

    $survey = BeanFactory::getBean('bc_survey', $survey_id);

    //Get Survey Questions score weight
    $base_score = $survey->base_score;

    //assigned user and team
    //origin
    if (!empty($rec_module_id) && !empty($module_name)) {
        $oOrigin = BeanFactory::getBean($module_name, $rec_module_id);
    }
    $assigned_user_id = $oOrigin->assigned_user_id;
    $team_id = $oOrigin->team_id;
    $team_set_id = $oOrigin->team_set_id;


    $survey_submission = new bc_survey_submission();
    $survey_submission->submission_date = '';
    $survey_submission->email_opened = 0;
    if (!empty($gmtdatetime)) {
        $survey_submission->survey_send = 0;
    }
    $survey_submission->name = $record_name;
    $survey_submission->customer_name = $record_name;
    $survey_submission->schedule_on = $gmtdatetime;
    $survey_submission->status = 'Pending';
    $survey_submission->recipient_as = 'to';
    $survey_submission->base_score = $base_score;
    $survey_submission->parent_type =  $rec_module;
    $survey_submission->parent_id =  $rec_module_id;
    $survey_submission->target_parent_type = $rec_module;
    $survey_submission->target_parent_id = $rec_module_id;
    $survey_submission->assigned_user_id = $assigned_user_id;
    $survey_submission->team_set_id = $team_set_id;
    $survey_submission->team_id = $team_id;
    $survey_submission->submission_type = 'Email';
    $survey_submission->bc_survey_submission_bc_surveybc_survey_ida = $survey->id;

    $survey_submission->save();
    // commented to remove relationships
    /*
     * relate to modules
     */

    $survey_relationship = 'bc_survey_' . strtolower($rec_module);
    $focus->load_relationship($survey_relationship);
    $focus->$survey_relationship->add($survey->id);
    
    if(!empty($survey_submission->id)){
        return true;
    } else {
        return false;
    }
}
