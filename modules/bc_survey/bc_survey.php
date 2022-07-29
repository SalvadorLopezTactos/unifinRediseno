<?PHP

/**
 * The file used to handle survey actions
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */

class bc_survey extends Basic {

    public $new_schema = true;
    public $module_dir = 'bc_survey';
    public $object_name = 'bc_survey';
    public $table_name = 'bc_survey';
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
    public $logo;
    public $start_date;
    public $end_date;
    public $theme;
    public $email_template;
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

            // remove related survey submission
            $bc_survey = BeanFactory::getBean('bc_survey', $id);
            $bc_survey->load_relationship('bc_survey_submission_bc_survey');
            foreach ($bc_survey->bc_survey_submission_bc_survey->getBeans() as $submission) {
                $submission->deleted = 1;
                $submission->processed = true;
                $submission->save();
            }

            // delete related relationship records wirh bc_automizer_actions
            require_once('include/SugarQuery/SugarQuery.php');
            $query = new SugarQuery();

            $query->select(array('id'));

            $query->from(BeanFactory::getBean('bc_automizer_actions'));

            $query->where()->equals('survey_id', $id);

            $result_actions = $query->execute();

            foreach ($result_actions as $action) {
                $survey_automizer_action = BeanFactory::getBean('bc_automizer_actions');
                $survey_automizer_action->retrieve($action['id']);
                $survey_automizer_action->deleted = 1;
                $survey_automizer_action->processed = true;
                $survey_automizer_action->save();
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

    public function update_web_link_counter($survey_id, $counter) {
        global $db;
        $get_qry = "UPDATE bc_survey SET web_link_counter=" . $counter . ", survey_send_status = 'active', form_seen = '1' WHERE id='{$survey_id}' ";
        $db->query($get_qry);
    }

}

?>
