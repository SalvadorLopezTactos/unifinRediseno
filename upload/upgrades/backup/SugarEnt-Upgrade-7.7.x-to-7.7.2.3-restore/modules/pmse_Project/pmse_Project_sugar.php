<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

class pmse_Project_sugar extends Basic
{
    var $new_schema = true;
    var $module_name = 'pmse_Project';
    var $module_dir = 'pmse_Project';
    var $object_name = 'pmse_Project';
    var $table_name = 'pmse_project';
    var $importable = false;
    var $id;
    var $name;
    var $date_entered;
    var $date_modified;
    var $modified_user_id;
    var $modified_by_name;
    var $created_by;
    var $created_by_name;
    var $description;
    var $deleted;
    var $created_by_link;
    var $modified_user_link;
    var $activities;
    var $team_id;
    var $team_set_id;
    var $team_count;
    var $team_name;
    var $team_link;
    var $team_count_link;
    var $teams;
    var $assigned_user_id;
    var $assigned_user_name;
    var $assigned_user_link;
    var $prj_uid;
    var $prj_target_namespace;
    var $prj_expression_language;
    var $prj_type_language;
    var $prj_exporter;
    var $prj_exporter_version;
    var $prj_author;
    var $prj_author_version;
    var $prj_original_source;
    var $prj_status;
    var $prj_module;

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @depreciated
     */
    function pmse_Project_sugar()
    {
        self::__construct();
    }

    public function __construct()
    {
        parent::__construct();
    }

    public function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':
                return true;
        }
        return false;
    }

}

?>