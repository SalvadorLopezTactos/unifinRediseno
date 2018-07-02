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

require_once('clients/base/api/ModuleApi.php');

class BugsApi extends ModuleApi
{
    public function registerApiRest()
    {
        return array(
            'create' => array(
                'reqType'   => 'POST',
                'path'      => array('Bugs'),
                'pathVars'  => array('module'),
                'method'    => 'createRecord',
                'shortHelp' => 'This method creates a new Bug record with option to add Contact and Account relationships',
                'longHelp'  => 'modules/Bugs/api/help/BugsApi.html',
            ),
        );
    }

    /**
     * Create the bug record and optionally perform post-save actions for Portal
     */
    public function createRecord($api, $args)
    {
        //create the bug using the ModuleApi

        $contact = null;
        if (isset($_SESSION['type']) && $_SESSION['type'] == 'support_portal') {
            $contact = BeanFactory::getBean('Contacts', $_SESSION['contact_id'], array('strict_retrieve' => true));

            if (!empty($contact)) {
                $args['assigned_user_id'] = $contact->assigned_user_id;
                $args['team_id']     = $contact->fetched_row['team_id'];
                $args['team_set_id'] = $contact->fetched_row['team_set_id'];
            }
        }

        $data = parent::createRecord($api, $args);

        $bugId = null;
        if (isset($data['id']) && !empty($data['id'])) {
            $bugId = $data['id'];
        } else {
            //bug not created, can't do post-processes - bail out
            return $data;
        }

        if (!empty($bugId) && !empty($contact)) {
            $bug = BeanFactory::getBean('Bugs', $bugId);
            $bug->load_relationship('contacts');
            $bug->contacts->add($contact->id);
            $bug->load_relationship('accounts');
            $bug->accounts->add($contact->account_id);
        }

        return $data;
    }
}
