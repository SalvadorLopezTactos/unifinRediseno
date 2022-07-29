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


class UsersApi extends ModuleApi
{
    public function registerApiRest()
    {
        return array(
            'create' => array(
                'reqType' => 'POST',
                'path' => array('Users'),
                'pathVars' => array('module'),
                'method' => 'createUser',
                'minVersion' => '11.6',
                'shortHelp' => 'This method creates a User record',
                'longHelp'  => 'modules/Users/clients/base/api/help/UsersApi_create.html',
                'ignoreSystemStatusError' => true,
            ),
            'update' => array(
                'reqType' => 'PUT',
                'path' => array('Users', '?'),
                'pathVars' => array('module','record'),
                'method' => 'updateUser',
                'minVersion' => '11.6',
                'shortHelp' => 'This method updates a User record',
                'longHelp'  => 'modules/Users/clients/base/api/help/UsersApi_update.html',
                'ignoreSystemStatusError' => true,
            ),
            'delete' => array(
                'reqType'   => 'DELETE',
                'path'      => array('Users', '?'),
                'pathVars'  => array('module', 'record'),
                'method'    => 'deleteUser',
                'shortHelp' => 'This method deletes a User record',
                'longHelp'  => 'modules/Users/clients/base/api/help/UsersApi.html',
                'ignoreSystemStatusError' => true,
            ),
            'getFreeBusySchedule' => array(
                'reqType' => 'GET',
                'path' => array("Users", '?', "freebusy"),
                'pathVars' => array('module', 'record', ''),
                'method' => 'getFreeBusySchedule',
                'shortHelp' => 'Retrieve a list of calendar event start and end times for specified person',
                'longHelp' => 'include/api/help/user_get_freebusy_help.html',
            ),
        );
    }

    /**
     * create user for REST version >= 11.6, enforce license type validation
     * @param ServiceBase $api
     * @param array $args
     * @return array
     * @throws SugarApiExceptionInvalidParameter
     */
    public function createUser(ServiceBase $api, array $args)
    {
        // need to enforce license type is provided.
        $this->requireArgs($args, array('module', 'license_type'));
        // validate license types and empty is not allowed
        if (!$this->validateLicenseTypes($args['license_type'])) {
            throw new SugarApiExceptionInvalidParameter('Invalid license_type in module: Users');
        }
        $moduleApi = new ModuleApi();
        return $moduleApi->createRecord($api, $args);
    }

    /**
     * update user for REST API version >= 11.6
     * @param ServiceBase $api
     * @param array $args
     * @return array
     * @throws SugarApiExceptionInvalidParameter
     */
    public function updateUser(ServiceBase $api, array $args)
    {
        $moduleApi = new ModuleApi();
        return $moduleApi->updateRecord($api, $args);
    }

    /**
     * Delete the user record and set the appropriate flags. Handled in a separate api call from the base one because
     * the base api delete field doesn't set user status to 'inactive' or employee_status to 'Terminated'
     *
     * The non-api User deletion logic is handled in /modules/Users/controller.php::action_delete()
     *
     * @param  ServiceBase $api
     * @param  array       $args
     * @return array
     */
    public function deleteUser(ServiceBase $api, array $args)
    {
        // Users can be deleted only in cloud console for IDM mode.
        if (in_array($args['module'], $this->idmModeDisabledModules)
            && $this->isIDMModeEnabled()
            && empty($args['skip_idm_mode_restrictions'])) {
            throw new SugarApiExceptionNotAuthorized();
        }

        // Ensure we have admin access to this module
        if (!($api->user->isAdmin() || $api->user->isAdminForModule('Users'))) {
            throw new SugarApiExceptionNotAuthorized();
        }

        $this->requireArgs($args, array('module', 'record'));
        // loadBean() handles exceptions for bean validation
        $user = $this->loadBean($api, $args, 'delete');

        $user->mark_deleted($user->id);

        return array('id' => $user->id);
    }

    /**
     * Retrieve a list of calendar event start and end times for specified person
     * @param ServiceBase $api
     * @param array $args
     * @return array
     */
    public function getFreeBusySchedule(ServiceBase $api, array $args)
    {
        $bean = $this->loadBean($api, $args, 'view');
        return array(
            "module" => $bean->module_name,
            "id" => $bean->id,
            "freebusy" => $bean->getFreeBusySchedule($args),
        );
    }

    /**
     * validate license types. Only allow system entitled license types to go through
     *
     * @param $licenseTypes
     *
     * @return bool
     */
    protected function validateLicenseTypes($licenseTypes) : bool
    {
        $seed = BeanFactory::newBean('Users');
        return $seed->validateLicenseTypes($seed->processLicenseTypes($licenseTypes));
    }
}
