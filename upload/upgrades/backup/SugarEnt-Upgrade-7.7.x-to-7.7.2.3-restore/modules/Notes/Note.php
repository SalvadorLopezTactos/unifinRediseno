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

require_once 'include/upload_file.php';

// Note is used to store customer information.
class Note extends SugarBean
{
    var $field_name_map;
    // Stored fields
    var $id;
    var $date_entered;
    var $date_modified;
    var $modified_user_id;
    var $assigned_user_id;
    var $created_by;
    var $created_by_name;
    var $modified_by_name;
    var $description;
    var $name;
    var $filename;
    // handle to an upload_file object
    // used in emails
    var $file;
    var $embed_flag; // inline image flag
    var $parent_type;
    var $parent_id;
    var $contact_id;
    var $portal_flag;
    var $team_id;

    var $parent_name;
    var $contact_name;
    var $contact_phone;
    var $contact_email;
    var $file_mime_type;
    var $module_dir = "Notes";
    var $default_note_name_dom = array('Meeting notes', 'Reminder');
    var $table_name = "notes";
    var $new_schema = true;
    var $object_name = "Note";
    var $importable = true;

    // This is used to retrieve related fields from form posts.
    var $additional_column_fields = array(
        'contact_name',
        'contact_phone',
        'contact_email',
        'parent_name',
        'first_name',
        'last_name'
    );

    /**
     * This is deprecated since 7.7.0 and will be removed in 7.9.0.
     * Please use __construct() instead.
     * @deprecated 7.7.0
     * @see __construct
     */
    public function Note()
    {
        self::__construct();
        $GLOBALS['log']->deprecated('Note::Note() is deprecated since 7.7.0. and will be removed in 7.9.0. ' .
            'Please use Note::__construct() instead.');
    }

    public function __construct()
    {
        parent::__construct();
    }

    function safeAttachmentName()
    {
        global $sugar_config;

        // get position of last "." in file name
        $file_ext_beg = strrpos($this->filename, ".");
        $file_ext = "";

        // get file extension
        if ($file_ext_beg !== false) {
            $file_ext = substr($this->filename, $file_ext_beg + 1);
        }

        // check to see if this is a file with extension located in "badext"
        foreach ($sugar_config['upload_badext'] as $badExt) {
            if (strtolower($file_ext) == strtolower($badExt)) {
                // if found, then append with .txt and break out of lookup
                $this->name = $this->name . ".txt";
                $this->file_mime_type = 'text/';
                $this->filename = $this->filename . ".txt";
                break; // no need to look for more
            }
        }
    }

    /**
     * overrides SugarBean's method.
     * If a system setting is set, it will mark all related notes as deleted, and attempt to delete files that are
     * related to those notes
     * @param string id ID
     */
    function mark_deleted($id)
    {
        global $sugar_config;

        if ($this->parent_type == 'Emails') {
            if (isset($sugar_config['email_default_delete_attachments']) &&
                $sugar_config['email_default_delete_attachments'] == true
            ) {
                $removeFile = "upload://$id";
                if (file_exists($removeFile)) {
                    if (!unlink($removeFile)) {
                        $GLOBALS['log']->error("*** Could not unlink() file: [ {$removeFile} ]");
                    }
                }
            }
        }

        // delete note
        parent::mark_deleted($id);
    }

    function deleteAttachment($isduplicate = "false")
    {
        if ($this->ACLAccess('edit')) {
            if ($isduplicate=="true") {
                return true;
            }
            $removeFile = "upload://{$this->id}";
        }

        if (file_exists($removeFile)) {
            if (!unlink($removeFile)) {
                $GLOBALS['log']->error("*** Could not unlink() file: [ {$removeFile} ]");
            } else {
                $this->filename = '';
                $this->file_mime_type = '';
                $this->file = '';
                $this->save();
                return true;
            }
        } else {
            $this->filename = '';
            $this->file_mime_type = '';
            $this->file = '';
            $this->save();
            return true;
        }
        return false;
    }

    function get_summary_text()
    {
        return "$this->name";
    }

    function fill_in_additional_list_fields()
    {
        $this->fill_in_additional_detail_fields();
    }

    function fill_in_additional_detail_fields()
    {
        parent::fill_in_additional_detail_fields();
        // TODO: Seems odd we need to clear out these values so that list views
        // don't show the previous rows value if current value is blank
        $this->getRelatedFields(
            'Contacts',
            $this->contact_id,
            array('name'=>'contact_name', 'phone_work'=>'contact_phone')
        );
        if (!empty($this->contact_name)) {
            $emailAddress = BeanFactory::getBean('EmailAddresses');
            $this->contact_email = $emailAddress->getPrimaryAddress(false, $this->contact_id, 'Contacts');
        }

        if (isset($this->contact_id) && $this->contact_id != '') {
            $contact = BeanFactory::getBean('Contacts', $this->contact_id);
            if (isset($contact->id)) {
                $this->contact_name = $contact->full_name;
            }
        }
    }

    function get_list_view_data()
    {
        $note_fields = $this->get_list_view_array();
        global $app_list_strings, $focus, $action, $currentModule,$mod_strings, $sugar_config;

        if (isset($this->parent_type)) {
            $note_fields['PARENT_MODULE'] = $this->parent_type;
        }

        if (!empty($this->filename)) {
            if (file_exists("upload://{$this->id}")) {
                $note_fields['FILENAME'] = $this->filename;
                $note_fields['FILE_URL'] = UploadFile::get_upload_url($this);
            } elseif (!empty($sugar_config['disc_client']) && $sugar_config['disc_client']) {
                $file_display = " (".$mod_strings['LBL_OC_FILE_NOTICE'].")";
                $note_fields['FILENAME'] = $file_display;
            }
        }
        if (isset($this->contact_id) && $this->contact_id != '') {
            $contact = BeanFactory::getBean('Contacts', $this->contact_id);
            if (isset($contact->id)) {
                $this->contact_name = $contact->full_name;
            }
        }
        if (isset($this->contact_name)) {
            $note_fields['CONTACT_NAME'] = $this->contact_name;
        }

        global $current_language;
        $mod_strings = return_module_language($current_language, 'Notes');
        $note_fields['STATUS']=$mod_strings['LBL_NOTE_STATUS'];

        return $note_fields;
    }

    /**
     * Assigns message variables to email template
     *
     * @param XTemplate $xtpl Email template
     * @param Note      $note Source note
     *
     * @return XTemplate
     */
    public function set_notification_body(XTemplate $xtpl, Note $note)
    {
        $xtpl->assign('NOTE_SUBJECT', $note->name);
        $xtpl->assign('NOTE_DESCRIPTION', $note->description);
        return $xtpl;
    }

    function listviewACLHelper()
    {
        $array_assign = parent::listviewACLHelper();
        $is_owner = false;
        if (!empty($this->parent_name)) {
            if (!empty($this->parent_name_owner)) {
                global $current_user;
                $is_owner = $current_user->id == $this->parent_name_owner;
            }
        }

        if (!ACLController::moduleSupportsACL($this->parent_type) ||
            ACLController::checkAccess($this->parent_type, 'view', $is_owner)
        ) {
            $array_assign['PARENT'] = 'a';
        } else {
            $array_assign['PARENT'] = 'span';
        }

        $is_owner = false;
        if (!empty($this->contact_name)) {
            if (!empty($this->contact_name_owner)) {
                global $current_user;
                $is_owner = $current_user->id == $this->contact_name_owner;
            }
        }

        if (ACLController::checkAccess('Contacts', 'view', $is_owner)) {
            $array_assign['CONTACT'] = 'a';
        } else {
            $array_assign['CONTACT'] = 'span';
        }

        return $array_assign;
    }

    function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':
                return true;
        }
        return false;
    }

    /**
     * Gets the file id under upload/ dir for this note.
     * @return string
     */
    public function getUploadId()
    {
        return !empty($this->upload_id) ? $this->upload_id : $this->id;
    }
}
