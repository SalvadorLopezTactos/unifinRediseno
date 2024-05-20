<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */



class pmse_Inbox_sugar extends Basic
{
    var $new_schema = true;
    var $module_name = 'pmse_Inbox';
    var $module_dir = 'pmse_Inbox';
    var $object_name = 'pmse_Inbox';
    var $table_name = 'pmse_inbox';
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
    var $cas_id;
    var $cas_parent;
    var $cas_status;
    var $pro_id;
    var $cas_title;
    var $pro_title;
    var $cas_custom_status;
    var $cas_init_user;
    var $cas_create_date;
    var $cas_update_date;
    var $cas_finish_date;
    var $cas_pin;
    var $cas_assigned_status;

    public const CAS_STATUS_COMPLETED = 'COMPLETED';
    public const CAS_STATUS_TERMINATED = 'TERMINATED';
    public const CAS_STATUS_IN_PROGRESS = 'IN PROGRESS';
    public const CAS_STATUS_CANCELLED = 'CANCELLED';
    public const CAS_STATUS_ERROR = 'ERROR';


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

    /**
     * Populate the cas_status enum field. Marked as final so that these values can never be overwritten by extending
     * the class
     * @return array
     */
    final public function getCasStatusTypes(): array
    {
        return [
            static::CAS_STATUS_COMPLETED => translate('LBL_STATUS_COMPLETED_ENUM', 'pmse_Inbox'),
            static::CAS_STATUS_TERMINATED => translate('LBL_STATUS_TERMINATED_ENUM', 'pmse_Inbox'),
            static::CAS_STATUS_IN_PROGRESS => translate('LBL_STATUS_IN_PROGRESS_ENUM', 'pmse_Inbox'),
            static::CAS_STATUS_CANCELLED => translate('LBL_STATUS_CANCELLED_ENUM', 'pmse_Inbox'),
            static::CAS_STATUS_ERROR => translate('LBL_STATUS_ERROR_ENUM', 'pmse_Inbox'),
        ];
    }
}
