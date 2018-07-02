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

require_once('data/BeanFactory.php');
require_once('include/api/SugarApi.php');

class ModuleApi extends SugarApi {
    public function registerApiRest() {
        return array(
            'create' => array(
                'reqType' => 'POST',
                'path' => array('<module>'),
                'pathVars' => array('module'),
                'method' => 'createRecord',
                'shortHelp' => 'This method creates a new record of the specified type',
                'longHelp' => 'include/api/help/module_post_help.html',
            ),
            'retrieve' => array(
                'reqType' => 'GET',
                'path' => array('<module>','?'),
                'pathVars' => array('module','record'),
                'method' => 'retrieveRecord',
                'shortHelp' => 'Returns a single record',
                'longHelp' => 'include/api/help/module_record_get_help.html',
            ),
            'update' => array(
                'reqType' => 'PUT',
                'path' => array('<module>','?'),
                'pathVars' => array('module','record'),
                'method' => 'updateRecord',
                'shortHelp' => 'This method updates a record of the specified type',
                'longHelp' => 'include/api/help/module_record_put_help.html',
            ),
            'delete' => array(
                'reqType' => 'DELETE',
                'path' => array('<module>','?'),
                'pathVars' => array('module','record'),
                'method' => 'deleteRecord',
                'shortHelp' => 'This method deletes a record of the specified type',
                'longHelp' => 'include/api/help/module_record_delete_help.html',
            ),
            'favorite' => array(
                'reqType' => 'PUT',
                'path' => array('<module>','?', 'favorite'),
                'pathVars' => array('module','record', 'favorite'),
                'method' => 'setFavorite',
                'shortHelp' => 'This method sets a record of the specified type as a favorite',
                'longHelp' => 'include/api/help/module_record_favorite_put_help.html',
            ),
            'deleteFavorite' => array(
                'reqType' => 'DELETE',
                'path' => array('<module>','?', 'favorite'),
                'pathVars' => array('module','record', 'favorite'),
                'method' => 'unsetFavorite',
                'shortHelp' => 'This method unsets a record of the specified type as a favorite',
                'longHelp' => 'include/api/help/module_record_favorite_delete_help.html',
            ),
            'unfavorite' => array(
                'reqType' => 'PUT',
                'path' => array('<module>','?', 'unfavorite'),
                'pathVars' => array('module','record', 'unfavorite'),
                'method' => 'unsetFavorite',
                'shortHelp' => 'This method unsets a record of the specified type as a favorite',
                'longHelp' => 'include/api/help/module_record_favorite_delete_help.html',
            ),
            'enum' => array(
                'reqType' => 'GET',
                'path' => array('<module>','enum','?'),
                'pathVars' => array('module', 'enum', 'field'),
                'method' => 'getEnumValues',
                'shortHelp' => 'This method returns enum values for a specified field',
                'longHelp' => 'include/api/help/module_enum_get_help.html',
            ),
        );
    }

    /**
     * This method returns the dropdown options of a given field
     * @param array $api
     * @param array $args
     * @return array
     */
    public function getEnumValues($api, $args) {
        $this->requireArgs($args, array('module','field'));

        $bean = BeanFactory::newBean($args['module']);

        if(!isset($bean->field_defs[$args['field']])) {
           throw new SugarApiExceptionNotFound('field not found');
        }

        $vardef = $bean->field_defs[$args['field']];

        $value = null;
        $cache_age = 0;

        if(isset($vardef['function'])) {
            if ( isset($vardef['function']['returns']) && $vardef['function']['returns'] == 'html' ) {
                throw new SugarApiExceptionError('html dropdowns are not supported');
            }

            $value = getFunctionValue(isset($vardef['function_bean']) ? $vardef['function_bean'] : null, $vardef['function']);
            $cache_age = 60;
        }
        else {
            if(!isset($GLOBALS['app_list_strings'][$vardef['options']])) {
                throw new SugarApiExceptionNotFound('options not found');
            }
            $value =  $GLOBALS['app_list_strings'][$vardef['options']];
            $cache_age = 3600;
        }
        // If a particular field has an option list that is expensive to calculate and/or rarely changes,
        // set the cache_setting property on the vardef to the age in seconds you want browsers to wait before refreshing
        if(isset($vardef['cache_setting'])) {
            $cache_age = $vardef['cache_setting'];
        }
        generateEtagHeader(md5(serialize($value)), $cache_age);
        return $value;
    }

    public function createRecord($api, $args) {
        $api->action = 'save';
        $this->requireArgs($args,array('module'));

        $bean = BeanFactory::newBean($args['module']);

        // TODO: When the create ACL goes in to effect, add it here.
        if (!$bean->ACLAccess('save')) {
            // No create access so we construct an error message and throw the exception
            $moduleName = null;
            if(isset($args['module'])){
                $failed_module_strings = return_module_language($GLOBALS['current_language'], $args['module']);
                $moduleName = $failed_module_strings['LBL_MODULE_NAME'];
            }
            $args = null;
            if(!empty($moduleName)){
                $args = array('moduleName' => $moduleName);
            }
            throw new SugarApiExceptionNotAuthorized('EXCEPTION_CREATE_MODULE_NOT_AUTHORIZED', $args);
        }

        if (!empty($args['id'])) {
            // Check if record already exists
            if (BeanFactory::getBean(
                $args['module'],
                $args['id'],
                array('strict_retrieve' => true, 'disable_row_level_security' => true)
            )) {
                throw new SugarApiExceptionInvalidParameter(
                    'Record already exists: ' . $args['id'] . ' in module: ' . $args['module']
                );
            }
            // Don't create a new id if passed in
            $bean->new_with_id = true;
        }

        $id = $this->updateBean($bean, $api, $args);

        $args['record'] = $id;

        $this->processAfterCreateOperations($args, $bean);

        return $this->getLoadedAndFormattedBean($api, $args);
    }

    public function updateRecord($api, $args) {
        $api->action = 'view';
        $this->requireArgs($args,array('module','record'));

        $bean = $this->loadBean($api, $args, 'save');
        $api->action = 'save';
        $this->updateBean($bean, $api, $args);

        return $this->getLoadedAndFormattedBean($api, $args);
    }

    public function retrieveRecord($api, $args) {
        $this->requireArgs($args,array('module','record'));

        $bean = $this->loadBean($api, $args, 'view');
        
        // formatBean is soft on view so that creates without view access will still work
        if (!$bean->ACLAccess('view')) {
            throw new SugarApiExceptionNotAuthorized('SUGAR_API_EXCEPTION_RECORD_NOT_AUTHORIZED',array('view'));
        }

        $api->action = 'view';
        $data = $this->formatBean($api, $args, $bean);

        return $data;

    }

    public function deleteRecord($api, $args) {
        $this->requireArgs($args,array('module','record'));

        $bean = $this->loadBean($api, $args, 'delete');
        $bean->mark_deleted($args['record']);

        return array('id'=>$bean->id);
    }

    public function setFavorite($api, $args) {
        $this->requireArgs($args, array('module', 'record'));
        $bean = $this->loadBean($api, $args, 'view');

        if (!$bean->ACLAccess('view')) {
            // No create access so we construct an error message and throw the exception
            $moduleName = null;
            if (isset($args['module'])) {
                $failed_module_strings = return_module_language($GLOBALS['current_language'], $args['module']);
                $moduleName = $failed_module_strings['LBL_MODULE_NAME'];
            }
            $args = null;
            if (!empty($moduleName)) {
                $args = array('moduleName' => $moduleName);
            }
            throw new SugarApiExceptionNotAuthorized('EXCEPTION_FAVORITE_MODULE_NOT_AUTHORIZED', $args);
        }

        $this->toggleFavorites($bean, true);
        $bean = BeanFactory::getBean($bean->module_dir, $bean->id, array('use_cache' => false));        
        $api->action = 'view';
        $data = $this->formatBean($api, $args, $bean);
        return $data;
    }

    public function unsetFavorite($api, $args) {
        $this->requireArgs($args, array('module', 'record'));
        $bean = $this->loadBean($api, $args, 'view');

        if (!$bean->ACLAccess('view')) {
            // No create access so we construct an error message and throw the exception
            $moduleName = null;
            if (isset($args['module'])) {
                $failed_module_strings = return_module_language($GLOBALS['current_language'], $args['module']);
                $moduleName = $failed_module_strings['LBL_MODULE_NAME'];
            }
            $args = null;
            if (!empty($moduleName)) {
                $args = array('moduleName' => $moduleName);
            }
            throw new SugarApiExceptionNotAuthorized('EXCEPTION_FAVORITE_MODULE_NOT_AUTHORIZED', $args);
        }

        $this->toggleFavorites($bean, false);
        $bean = BeanFactory::getBean($bean->module_dir, $bean->id, array('use_cache' => false));        
        $api->action = 'view';
        $data = $this->formatBean($api, $args, $bean);
        return $data;
    }

    /**
     * Shared method from create and update process that handles records that 
     * might not pass visibility checks. This method assumes the API has validated
     * the authorization to create/edit records prior to this point.
     * 
     * @param ServiceBase $api The service object
     * @param array $args Request arguments
     * @return array Array of formatted fields
     */
    protected function getLoadedAndFormattedBean($api, $args)
    {
        // Load the bean fresh to ensure the cache entry from the create process
        // doesn't get in the way of visibility checks
        $bean = $this->loadBean($api, $args, 'view', array('use_cache' => false));

        $api->action = 'view';
        $data = $this->formatBean($api, $args, $bean, array(
            'display_acl' => true,
        ));

        return $data;
    }

    /**
     * Process all after create operations:
     * copy_rel_from - Copies relationships from a specified record. The relationship that should be copied is specified
     *                 in the vardef.
     *
     * @param $args
     * @param SugarBean $bean
     */
    protected function processAfterCreateOperations($args, SugarBean $bean) {
        $this->requireArgs($args, array('module'));

        global $dictionary;
        $afterCreateKey = 'after_create';
        $copyRelationshipsFromKey = 'copy_rel_from';
        $module = $args['module'];
        $objectName = BeanFactory::getObjectName($module);

        if (array_key_exists($afterCreateKey, $args)
            && array_key_exists($copyRelationshipsFromKey, $args[$afterCreateKey])
            && array_key_exists($afterCreateKey, $dictionary[$objectName])
            && array_key_exists($copyRelationshipsFromKey, $dictionary[$objectName][$afterCreateKey])
        ) {
            $relationshipsToCopy = $dictionary[$objectName][$afterCreateKey][$copyRelationshipsFromKey];
            $beanCopiedFrom = BeanFactory::getBean($module, $args[$afterCreateKey][$copyRelationshipsFromKey]);

            foreach ($relationshipsToCopy as $linkName) {
                $bean->load_relationship($linkName);
                $beanCopiedFrom->load_relationship($linkName);

                $beanCopiedFrom->$linkName->getBeans();
                $bean->$linkName->add($beanCopiedFrom->$linkName->beans);
            }
        }
    }
}
