<?PHP

/**
 * The file used to handle functions for survey submission
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
class bc_survey_submission extends Basic {

    public $new_schema = true;
    public $module_dir = 'bc_survey_submission';
    public $object_name = 'bc_survey_submission';
    public $table_name = 'bc_survey_submission';
    public $importable = false;
    public $disable_row_level_security = true; // to ensure that modules created and deployed under CE will continue to function under team security if the instance is upgraded to PRO
    public $id;
    public $name;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $modified_by_name;
    public $created_by;
    public $created_by_name;
    public $description;
    public $deleted;
    public $created_by_link;
    public $modified_user_link;
    public $assigned_user_id;
    public $assigned_user_name;
    public $assigned_user_link;
    public $module_id;
    public $module_name;
    public $submission_date;
    public $email_opened;
    public $survey_send;
    public $schedule_on;
    public $status;
    public $team_id;
    public $team_set_id;
    public $team_count;
    public $team_name;
    public $team_link;
    public $team_count_link;
    public $teams;

    public function __construct() {
        parent::__construct();
    }

    function bean_implements($interface) {
        switch ($interface) {
            case 'ACL': return true;
        }
        return false;
    }

    function get_list_view_data() {
        $temp_array = parent::get_list_view_data();
        $survey_sub = new bc_survey_submission();
        $survey_sub->retrieve($this->id);
        $survey_sub->load_relationship('bc_survey_submission_bc_survey');
        $survey = $survey_sub->get_linked_beans('bc_survey_submission_bc_survey', 'bc_survey');
        $temp_array['SURVEY_NAME'] = $survey[0]->name;
        $temp_array['ID'] = $survey[0]->id;
        return $temp_array;
    }

    /**
     * This function should be overridden in each module.  It marks an item as deleted.
     *
     * If it is not overridden, then marking this type of item is not allowed
     */
    public function mark_deleted($id) {
        global $current_user, $db;
        $date_modified = $GLOBALS['timedate']->nowDb();
        if (isset($_SESSION['show_deleted'])) {
            $this->mark_undeleted($id);
        } else {
            // Ensure that Activity Messages do not occur in the context of a Delete action (e.g. unlink)
            // and do so for all nested calls within the Top Level Delete Context
            $opflag = static::enterOperation('delete');
            $aflag = Activity::isEnabled();
            Activity::disable();

            // call the custom business logic
            $custom_logic_arguments['id'] = $id;
            $this->call_custom_logic("before_delete", $custom_logic_arguments);

            // retrieve Submission
            $submission = BeanFactory::getBean('bc_survey_submission', $id);
            $survey = $submission->get_linked_beans('bc_survey_submission_bc_survey', 'bc_survey');
            $survey_id = $survey[0]->id;

            // Retrieve related submited data
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

            $oSurveys = $submission->get_linked_beans('bc_survey_submission_bc_survey', 'bc_survey');

            foreach ($oSurveys as $oSurvey) {
                $survey_id = $oSurvey->id;
                
                // Set Send Status as "Unpublished" if no any other submission found for current survey
                $oSubmissions = $oSurvey->get_linked_beans('bc_survey_submission_bc_survey', 'bc_survey_submission',array(),0,-1,0," bc_survey_submission.id!='{$submission->id}' ");
                if(count($oSubmissions) == 0){
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

            // Delete Report supported module entries
            $submitted_Ques = $submission->get_linked_beans('bc_survey_submit_question_bc_survey_submission','bc_survey_submit_question');
            foreach ($submitted_Ques as $submitted_que) {
                $submitted_que->deleted = 1;
                $submitted_que->save();
            }

            $this->deleted = 1; // delete given record

            $this->mark_relationships_deleted($id);
            if (isset($this->field_defs['modified_user_id'])) {
                if (!empty($current_user)) {
                    $this->modified_user_id = $current_user->id;
                } else {
                    $this->modified_user_id = 1;
                }
                $query = "UPDATE $this->table_name set deleted=1, date_modified = '$date_modified',
                            modified_user_id = '$this->modified_user_id' where id='$id'";
                if ($this->isFavoritesEnabled()) {
                    SugarFavorites::markRecordDeletedInFavorites($id, $date_modified, $this->modified_user_id);
                }
            } else {
                $query = "UPDATE $this->table_name set deleted=1 , date_modified = '$date_modified' where id='$id'";
                if ($this->isFavoritesEnabled()) {
                    SugarFavorites::markRecordDeletedInFavorites($id, $date_modified);
                }
            }
            $this->db->query($query, true, "Error marking record deleted: ");

            // Take the item off the recently viewed lists
            $tracker = BeanFactory::getBean('Trackers');
            $tracker->makeInvisibleForAll($id);

            require_once('include/SugarSearchEngine/SugarSearchEngineFactory.php');
            $searchEngine = SugarSearchEngineFactory::getInstance();
            $searchEngine->delete($this);

            SugarRelationship::resaveRelatedBeans();
            // call the custom business logic
            $this->call_custom_logic("after_delete", $custom_logic_arguments);
            if (static::leaveOperation('delete', $opflag) && $aflag) {
                Activity::enable();
            }
        }
    }

}
?>