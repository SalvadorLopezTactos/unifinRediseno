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

require_once('data/SugarBeanApiHelper.php');

class TasksApiHelper extends SugarBeanApiHelper
{
    /**
     * Formats the bean so it is ready to be handed back to the API's client.
     *
     * @param $bean SugarBean The Task you want formatted
     * @param $fieldList array Which fields do you want formatted and returned (leave blank for all fields)
     * @param $options array Currently no options are supported
     * @return array The bean in array format, ready for passing out the API to clients.
     */
    public function formatForApi(SugarBean $bean, array $fieldList = array(), array $options = array())
    {
        $data = parent::formatForApi($bean, $fieldList, $options);
        if (isset($bean->contact_id)) {
            $contact = BeanFactory::getBean('Contacts', $bean->contact_id);

            if (!empty($contact) && $contact->id != "") {
                if (isset($data['contact_name'])) {
                    $data['contact_name'] = empty($contact->full_name) ? '' : $contact->full_name;
                }
                if (isset($data['contact_phone'])) {
                    $data['contact_phone'] = empty($contact->phone_work) ? '' : $contact->phone_work;
                }
            }
        }
        return $data;
    }
}

