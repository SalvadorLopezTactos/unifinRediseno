<?php
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
require_once 'include/SugarObjects/templates/basic/Basic.php';

class UserSignature extends Basic
{
    public $id;
    public $date_entered;
    public $date_modified;
    public $deleted;
    public $user_id;
    public $name;
    public $signature;
    public $table_name = 'users_signatures';
    public $module_dir = 'UserSignatures';
    public $object_name = 'UserSignature';
    public $disable_custom_fields = true;
    public $disable_row_level_security = true;
    public $set_created_by = false;

    /**
     * Override's SugarBean's
     */
    public function get_list_view_data()
    {
        $temp_array = $this->get_list_view_array();
        $temp_array['MAILBOX_TYPE_NAME'] = $GLOBALS['app_list_strings']['dom_mailbox_type'][$this->mailbox_type];
        return $temp_array;
    }

    /**
     * Override's SugarBean's
     */
    public function fill_in_additional_list_fields()
    {
        $this->fill_in_additional_detail_fields();
    }

    /**
     * Override's SugarBean's
     */
    public function fill_in_additional_detail_fields()
    {
    }

    /**
     * {@inheritDoc}
     *
     * The created_by field must be kept in sync with the user_id field in order for the $created filter to work. This
     * fix (for jira: MAR-1841; SI: 67320) should be replaced by a refactor of the UserSignatures module so that the
     * user_id field can be dropped in favor of created_by.
     *
     * @param bool $check_notify
     * @return String
     */
    public function save($check_notify = false)
    {
        if (empty($this->user_id)) {
            $this->user_id = $GLOBALS['current_user']->id;
        }
        if ($this->created_by !== $this->user_id) {
            $this->created_by = $this->user_id;
        }
        return parent::save($check_notify);
    }
}
