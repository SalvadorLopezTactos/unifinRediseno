<?PHP

/**
 * The file used to manage actions for Automizer 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */

class bc_survey_automizer extends Basic {

    public $new_schema = true;
    public $module_dir = 'bc_survey_automizer';
    public $object_name = 'bc_survey_automizer';
    public $table_name = 'bc_survey_automizer';
    public $importable = false;
    public $team_id;
    public $team_set_id;
    public $team_count;
    public $team_name;
    public $team_link;
    public $team_count_link;
    public $teams;
    public $assigned_user_id;
    public $assigned_user_name;
    public $assigned_user_link;
    public $id;
    public $name;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $modified_by_name;
    public $created_by;
    public $created_by_name;
    public $doc_owner;
    public $user_favorites;
    public $description;
    public $deleted;
    public $created_by_link;
    public $modified_user_link;
    public $activities;
    public $following;
    public $following_link;
    public $my_favorite;
    public $favorite_link;

    public function __construct() {
        parent::__construct();
    }

    public function bean_implements($interface) {
        switch ($interface) {
            case 'ACL': return true;
        }
        return false;
    }

}
