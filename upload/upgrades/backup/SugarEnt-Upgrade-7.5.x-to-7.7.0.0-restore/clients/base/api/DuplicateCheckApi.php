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

class DuplicateCheckApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'duplicateCheck' => array(
                'reqType' => 'POST',
                'path' => array('<module>','duplicateCheck'),
                'pathVars' => array('module',''),
                'method' => 'checkForDuplicates',
                'shortHelp' => 'Check for duplicate records within a module',
                'longHelp' => 'include/api/help/module_duplicatecheck_post_help.html',
            ),
        );
    }

    /**
     * Using the appropriate duplicate check service, search for duplicates in the system
     * TODO: we should refactor some of the bean loading in SugarApi so we can move some of this logic there
     *
     * @param ServiceBase $api
     * @param array $args
     */
    function checkForDuplicates(ServiceBase $api, array $args)
    {
        //create a new bean & check ACLs
        $bean = BeanFactory::newBean($args['module']);

        $this->handleEmptyBean($bean);

        $args=$this->trimArgs($args);

        if (!$bean->ACLAccess('read')) {
            throw new SugarApiExceptionNotAuthorized('No access to read records for module: '.$args['module']);
        }

        //populate bean
        $options = array('acl' => 'read');
        $errors = $this->populateFromApi($api, $bean, $args, $options);
        if ($errors !== true) {
            $displayErrors = print_r($errors, true);
            throw new SugarApiExceptionInvalidParameter("Unable to run duplicate check. There were validation errors on the submitted data: $displayErrors");
        }

        //retrieve possible duplicates
        $results = $bean->findDuplicates();

        if ($results) {
            return $results;
        } else {
            return array();
        }

    }

    protected function handleEmptyBean($bean)
    {
        if (empty($bean)) {
            throw new SugarApiExceptionInvalidParameter('Unable to run duplicate check. Bean was empty after attempting to populate from API');
        }
    }

    protected function trimArgs($args)
    {
        $args2 = array();
        foreach($args as $key => $value) {
            $args2[trim($key)] = (is_string($value)) ? trim($value) : $value;
        }
        return $args2;
    }

    protected function populateFromApi($api, $bean, $args, $options=array())
    {
        $errors = ApiHelper::getHelper($api,$bean)->populateFromApi($bean,$args,$options);

        // remove email_addr_bean_rel records created by SugarFieldEmail::apiSave() for new bean (empty id)
        if (empty($args['id']) && !empty($bean->emailAddress)) {
            $bean->emailAddress->deleteLinks($bean->id, $bean->module_dir);
        }

        return $errors;
    }
}
