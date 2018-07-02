<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
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

require_once 'modules/ModuleBuilder/parsers/ModuleBuilderParser.php';
require_once 'modules/Administration/Administration.php';
require_once 'modules/MySettings/TabController.php';

class ParserModifyPortalConfig extends ModuleBuilderParser
{

    /**
     * Constructor
     */
    function init()
    {
    }

    /**
     * handles portal config save and creating of portal users
     */
    function handleSave()
    {
        // Initialize `MySettings_tab` (setting containing the list of module
        // tabs) if not set.
        $tabController = new TabController();
        $tabs = $tabController->getPortalTabs();

        $portalFields = array('appStatus', 'defaultUser', 'appName', 'logoURL', 'serverUrl', 'maxQueryResult', 'maxSearchQueryResult');
        $portalConfig = array(
            'platform' => 'portal',
            'debugSugarApi' => true,
            'logLevel' => 'ERROR',
            'logWriter' => 'ConsoleWriter',
            'logFormatter' => 'SimpleFormatter',
            'metadataTypes' => array(),
            'defaultModule' => 'Cases',
            'orderByDefaults' => array(
                'Cases' => array(
                    'field' => 'case_number',
                    'direction' => 'desc'
                ),
                'Bugs' => array(
                    'field' => 'bug_number',
                    'direction' => 'desc'
                ),
                'Notes' => array(
                    'field' => 'date_modified',
                    'direction' => 'desc'
                ),
                'KBDocuments' => array(
                    'field' => 'date_modified',
                    'direction' => 'desc'
                )
            )
        );
        if (inDeveloperMode()) {
            $portalConfig['logLevel'] = 'DEBUG';
        }
        foreach ($portalFields as $field) {
            if (isset($_REQUEST[$field])) {
                $portalConfig[$field] = $_REQUEST[$field];
            }
        }

        //Get the current portal status because if it has changed we need to clear the base metadata
        if (isset($portalConfig['appStatus']) && $portalConfig['appStatus'] == 'true') {
            $portalConfig['appStatus'] = 'online';
            $portalConfig['on'] = 1;
        } else {
            $portalConfig['appStatus'] = 'offline';
            $portalConfig['on'] = 0;
        }
        //TODO: Remove after we resolve issues with test associated to this
        $GLOBALS['log']->info("Updating portal config");
        foreach ($portalConfig as $fieldKey => $fieldValue) {

            // TODO: category should be `support`, platform should be `portal`
            if(!$GLOBALS ['system_config']->saveSetting('portal', $fieldKey, json_encode($fieldValue), 'support')){
                $GLOBALS['log']->fatal("Error saving portal config var $fieldKey, orig: $fieldValue , json:".json_encode($fieldValue));
            }

        }

        // Verify the existence of the javascript config file
        if (!file_exists('portal2/config.js')) {
            require_once 'ModuleInstall/ModuleInstaller.php';
            ModuleInstaller::handlePortalConfig();
        }

        if (isset($portalConfig['on']) && $portalConfig['on'] == 1) {
            $u = $this->getPortalUser();
            $role = $this->getPortalACLRole();

            if (!($u->check_role_membership($role->name))) {
                $u->load_relationship('aclroles');
                $u->aclroles->add($role);
                $u->save();
            }
        } else {
            $this->removeOAuthForPortalUser();
        }
        //Refresh cache so that module metadata is rebuilt
        MetaDataManager::refreshCache(array('base', 'portal'));

    }

    /**
     * Creates Portal User
     * @return User
     */
    function removeOAuthForPortalUser()
    {
        // Try to retrieve the portal user. If exists, check for
        // corresponding oauth2 and mark deleted.
        $portalUserName = "SugarCustomerSupportPortalUser";
        $id = User::retrieve_user_id($portalUserName);
        if ($id) {
            $clientSeed = BeanFactory::newBean('OAuthKeys');
            $clientBean = $clientSeed->fetchKey('support_portal', 'oauth2');
            if ($clientBean) {
                $clientSeed->mark_deleted($clientBean->id);
            }
        }
    }
        
    /**
     * Creates Portal User
     * @return User
     */
    function getPortalUser()
    {
        $portalUserName = "SugarCustomerSupportPortalUser";
        $id = User::retrieve_user_id($portalUserName);
        if (!$id) {
            $user = BeanFactory::getBean('Users');
            $user->user_name = $portalUserName;
            $user->title = 'Sugar Customer Support Portal User';
            $user->description = $user->title;
            $user->first_name = "";
            $user->last_name = $user->title;
            $user->status = 'Active';
            $user->receive_notifications = 0;
            $user->is_admin = 0;
            $random = time() . mt_rand();
            $user->authenicate_id = md5($random);
            $user->user_hash = User::getPasswordHash($random);
            $user->default_team = '1';
            $user->created_by = '1';
            $user->portal_only = '1';
            $user->save();
            $id = $user->id;

            // set user id in system settings
            $GLOBALS ['system_config']->saveSetting('supportPortal', 'RegCreatedBy', $id);
        }
        $this->createOAuthForPortalUser();
        $resultUser = BeanFactory::getBean('Users', $id);
        return $resultUser;
    }

    // Make the oauthkey record for this portal user now if it doesn't exists
    function createOAuthForPortalUser() 
    {
        $clientSeed = BeanFactory::newBean('OAuthKeys');
        $clientBean = $clientSeed->fetchKey('support_portal', 'oauth2');
        if (!$clientBean) {
            $newKey = BeanFactory::newBean('OAuthKeys');
            $newKey->oauth_type = 'oauth2';
            $newKey->c_secret = '';
            $newKey->client_type = 'support_portal';
            $newKey->c_key = 'support_portal';
            $newKey->name = 'OAuth Support Portal Key';
            $newKey->description = 'This OAuth key is automatically created by the OAuth2.0 system to enable logins to the serf-service portal system in Sugar.';
            $newKey->save();
        }
    }

    /**
     * Creates Portal role and sets ACLS
     * @return ACLRole
     */
    function getPortalACLRole()
    {
        global $mod_strings;
        $allowedModules = array('Bugs', 'Cases', 'Notes', 'KBDocuments', 'Contacts');
        $allowedActions = array('edit', 'admin', 'access', 'list', 'view');
        $role = BeanFactory::getBean('ACLRoles');
        $role->retrieve_by_string_fields(array('name' => 'Customer Self-Service Portal Role'));
        if (empty($role->id)) {
            $role->name = "Customer Self-Service Portal Role";
            $role->description = $mod_strings['LBL_PORTAL_ROLE_DESC'];
            $role->save();
            $roleActions = $role->getRoleActions($role->id);
            foreach ($roleActions as $moduleName => $actions) {
                // enable allowed moduels
                if (isset($actions['module']['access']['id']) && !in_array($moduleName, $allowedModules)) {
                    $role->setAction($role->id, $actions['module']['access']['id'], ACL_ALLOW_DISABLED);
                } elseif (isset($actions['module']['access']['id']) && in_array($moduleName, $allowedModules)) {
                    $role->setAction($role->id, $actions['module']['access']['id'], ACL_ALLOW_ENABLED);
                } else {
                    foreach ($actions as $action => $actionName) {
                        if (isset($actions[$action]['access']['id'])) {
                            $role->setAction($role->id, $actions[$action]['access']['id'], ACL_ALLOW_DISABLED);
                        }
                    }
                }
                if (in_array($moduleName, $allowedModules)) {
                    $role->setAction($role->id, $actions['module']['access']['id'], ACL_ALLOW_ENABLED);
                    $role->setAction($role->id, $actions['module']['admin']['id'], ACL_ALLOW_ALL);
                    foreach ($actions['module'] as $actionName => $action) {
                        if (in_array($actionName, $allowedActions)) {
                            $aclAllow = ACL_ALLOW_ALL;
                        } else {
                            $aclAllow = ACL_ALLOW_NONE;
                        }
                        if ($moduleName == 'KBDocuments' && $actionName == 'edit') {
                            $aclAllow = ACL_ALLOW_NONE;
                        }
                        if ($moduleName == 'Contacts') {
                            if ($actionName == 'edit' || $actionName == 'view') {
                                $aclAllow = ACL_ALLOW_OWNER;
                            } else {
                                $aclAllow = ACL_ALLOW_NONE;
                            }

                        }
                        if ($actionName != 'access') {
                            $role->setAction($role->id, $action['id'], $aclAllow);
                        }

                    }
                }
            }
        }
        return $role;
    }
}
