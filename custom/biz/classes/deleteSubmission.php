<?php

/**
 * The file used to delete a survey submission of currently deleted record.
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

require_once 'custom/include/utilsfunction.php';

class deletedSubmission {
    /*
     * this function is used for checking survey submission record is linked with deleted record or not if there then delete that related record
     */

    function deletedSubmission_method($bean, $event, $arguments) {
        global $db;

        $acceptable_modules = array('Accounts', 'Contacts', 'Leads', 'Prospects'); // acceptable module who contains survey submission record
        if (in_array($bean->module_name, $acceptable_modules)) {
            $GLOBALS['log']->debug("This is the deleted record : " . print_r($bean->id, 1));
            foreach ($bean->field_defs as $field) {

                // If related module survey submission exists then remove related submission
                if ($field['module'] == 'bc_survey_submission') {

                    $relationship_name = $field['relationship']; // relation ship name for submission
                    $GLOBALS['log']->debug("This is the rel name : " . print_r($relationship_name, 1));
                    $submission_obj = $bean->get_linked_beans($relationship_name, 'bc_survey_submission');


                    foreach ($submission_obj as $submission) {
                        $survey = $submission->get_linked_beans('bc_survey_submission_bc_survey', 'bc_survey');
                        $survey_id = $survey[0]->id;
                        $GLOBALS['log']->debug("This is the submission id :--- " . print_r($submission->id, 1));

                        // Retrieve related submited data
                        $submission_data_obj = $submission->get_linked_beans('bc_submission_data_bc_survey_submission', 'bc_submission_data');

                        foreach ($submission_data_obj as $submited_data) {

                            $GLOBALS['log']->debug("This is the submitted data :------- " . print_r($submited_data->id, 1));
                            // delete submited data
                            $submited_data->deleted = 1;
                            $submited_data->save();
                            // deleted submission and submited data relationship
                            $submission->bc_submission_data_bc_survey_submission->delete($submission->id, $submited_data->id);


                            foreach ($submited_data->bc_submission_data_bc_survey_answers->getBeans() as $submited_ans) {

                                $GLOBALS['log']->debug("This is the submitted answer :------- " . print_r($submited_ans->id, 1));

                                // deleted submission and answer relationship
                                $submited_data->bc_submission_data_bc_survey_answers->delete($submited_data->id, $submited_ans->id);
                            }

                            foreach ($submited_data->bc_submission_data_bc_survey_questions->getBeans() as $submited_que) {

                                $GLOBALS['log']->debug("This is the submitted question :------- " . print_r($submited_que->id, 1));

                                // deleted submission and question relationship
                                $submited_data->bc_submission_data_bc_survey_questions->delete($submited_data->id, $submited_que->id);
                            }
                        }


                        $oSurveys = $submission->get_linked_beans('bc_survey_submission_bc_survey', 'bc_survey');

                        foreach ($oSurveys as $oSurvey) {
                            $survey_id = $oSurvey->id;
                            // Set Send Status as "Unpublished" if no any other submission found for current survey
                            $oSubmissions = $oSurvey->get_linked_beans('bc_survey_submission_bc_survey', 'bc_survey_submission', array(), 0, 1, 0, " bc_survey_submission.id!='{$submission->id}' ");
                            if (count($oSubmissions) == 0) {
                                $oSurvey->survey_send_status = 'inactive';
                                $oSurvey->save();
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


                        $submission->load_relationship('bc_survey_submit_question_bc_survey_submission');
                        foreach ($submission->bc_survey_submit_question_bc_survey_submission->getBeans() as $submited_que) {

                            $GLOBALS['log']->debug("This is the submitted question :------- " . print_r($submited_que->id, 1));

                            // deleted submission and question relationship
                            $submission->bc_survey_submit_question_bc_survey_submission->delete($submission->id, $submited_que->id);
                        }
                        
                        // Delete Report supported module entries
                        $submitted_Ques = $submission->get_linked_beans('bc_survey_submit_question_bc_survey_submission', 'bc_survey_submit_question');
                        foreach ($submitted_Ques as $submitted_que) {
                            $submitted_que->deleted = 1;
                            $submitted_que->save();
                        }

                        $submission->deleted = 1; // delete submission
                        $submission->save();
                    }
                }
            }
        }
    }

}
