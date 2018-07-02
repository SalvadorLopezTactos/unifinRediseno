<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

require_once('data/SugarBeanApiHelper.php');

class MeetingsApiHelper extends SugarBeanApiHelper
{
    /**
     * This function adds the Meetings specific saves for leads, contacts, and users on a call also updates the vcal
     * @param SugarBean $bean
     * @param array $submittedData
     * @param array $options
     * @return array
     */
    public function populateFromApi(SugarBean $bean, array $submittedData, array $options = array())
    {
        global $db;
        $data = parent::populateFromApi($bean, $submittedData, $options);

        $leadInvitees = array();
        $contactInvitees = array();
        $userInvitees = array();

        $userInvitees[] = $bean->assigned_user_id;
        if($bean->assigned_user_id != $GLOBALS['current_user']->id) {
            $userInvitees[] = $GLOBALS['current_user']->id;
        }

        $bean->update_vcal = false;    // Bug #49195 : don't update vcal b/s related users aren't saved yet, create vcal cache below

        // add current userInvitees to this list as well so they don't get removed
        $q = 'SELECT mu.user_id FROM meetings_users mu WHERE mu.meeting_id = \''.$bean->id.'\'';
        $r = $db->query($q);
        while($user = $db->fetchByAssoc($r)) {
            if(!in_array($user['user_id'], $userInvitees)) {
                $userInvitees[] = $user['user_id'];
            }
        }

        if ($bean->load_relationship('leads')) {
            $leadInvitees = $bean->leads->get();
        }

        if ($bean->load_relationship('contacts')) {
            $contactInvitees = $bean->contacts->get();
        }

        $bean->users_arr = $userInvitees;
        $bean->leads_arr = $leadInvitees;
        $bean->contacts_arr = $contactInvitees;

        return $data;
    }

    /**
     * Formats the bean so it is ready to be handed back to the API's client. Certian fields will get extra processing
     * to make them easier to work with from the client end.
     *
     * @param $bean SugarBean The bean you want formatted
     * @param $fieldList array Which fields do you want formatted and returned (leave blank for all fields)
     * @param $options array Currently no options are supported
     * @return array The bean in array format, ready for passing out the API to clients.
     */
    public function formatForApi(SugarBean $bean, array $fieldList = array(), array $options = array())
    {
        $data = parent::formatForApi($bean, $fieldList, $options);

        if(!empty($bean->contact_id)) {
            $contact = BeanFactory::getBean('Contacts', $bean->contact_id);
            if($contact instanceof Contact) {
                $data['contact_name'] = $contact->full_name;
            }
        }
        
        return $data;
    }    

}
