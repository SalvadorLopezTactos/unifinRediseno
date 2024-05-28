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

use Sugarcrm\Sugarcrm\CustomerJourney\ConfigurationManager;

require_once 'data/SugarACLStrategy.php';

/**
 * This class is used to enforce ACLs on Sugar Automate modules.
 */
class SugarACLCustomerJourney extends SugarACLStrategy
{
    private static $regularUsersNoAccessModules = [
        'DRI_Workflow_Templates',
        'DRI_Workflow_Task_Templates',
        'DRI_SubWorkflow_Templates',
    ];

    private static $regularUsersAccessibleModules = [
        'DRI_Workflows',
        'CJ_Forms',
        'DRI_SubWorkflows',
        'CJ_WebHooks',
    ];

    /**
     * Only allow access to users with the user admin setting
     *
     * @param string $module
     * @param string $view
     * @param array $context
     * @return bool
     */
    public function checkAccess($module, $view, $context)
    {
        try {
            $user = $this->getCurrentUser($context);
            $isAdminUser = $user->isAdmin();
            
            //CJ-545: In case of fresh install return true so that enabled tabs list
            //only has the modules added in performsetup enabledtabs  list
            if (isset($GLOBALS['installing']) && $GLOBALS['installing'] === true) {
                return true;
            }
            
            $isAutomateUser = ConfigurationManager::ensureAutomateUser();

            if ($isAdminUser || in_array($module, self::$regularUsersAccessibleModules)) {
                return $isAutomateUser;
            }

            if (in_array($module, self::$regularUsersNoAccessModules)) {
                // always allow to read data in all Sugar Automate modules
                if (in_array(strtolower($view), ['view', 'list', 'access'], true)) {
                    return true;
                }

                if ($view === 'field' &&
                    in_array(strtolower($context['action']), ['list', 'detail', 'read', 'access'], true)
                ) {
                    return true;
                }
            }
        } catch (Exception $e) {
            return false;
        }

        return false;
    }
}
