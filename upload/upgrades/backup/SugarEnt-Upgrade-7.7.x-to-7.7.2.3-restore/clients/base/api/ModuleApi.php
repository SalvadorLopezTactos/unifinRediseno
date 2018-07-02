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

    /** @var RelateRecordApi */
    protected $relateRecordApi;
    private $aclCheckOptions = array('source' => 'module_api');

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
            $cache_age = 60;
        } else {
            $cache_age = 3600;
        }
        $value = getOptionsFromVardef($vardef);
        if ($value === false) {
            throw new SugarApiExceptionNotFound('options not found');
        }
        // If a particular field has an option list that is expensive to calculate and/or rarely changes,
        // set the cache_setting property on the vardef to the age in seconds you want browsers to wait before refreshing
        if(isset($vardef['cache_setting'])) {
            $cache_age = $vardef['cache_setting'];
        }
        generateEtagHeader(md5(serialize($value)), $cache_age);
        return $value;
    }

    /**
     * Creates new record of the given module and returns its formatted representation
     *
     * @param ServiceBase $api
     * @param array $args API arguments
     *
     * @return array Formatted representation of the bean
     * @throws SugarApiExceptionInvalidParameter
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionNotAuthorized
     */
    public function createRecord(ServiceBase $api, array $args)
    {
        $bean = $this->createBean($api, $args);
        $data = $this->formatBeanAfterSave($api, $args, $bean);

        return $data;
    }

    /**
     * Creates new bean of the given module
     *
     * @param ServiceBase $api
     * @param array $args API arguments
     * @param array $additionalProperties Additional properties to be set on the bean
     *
     * @return SugarBean
     * @throws SugarApiExceptionInvalidParameter
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionNotAuthorized
     */
    public function createBean(ServiceBase $api, array $args, array $additionalProperties = array())
    {
        $api->action = 'save';
        $this->requireArgs($args,array('module'));

        $bean = BeanFactory::newBean($args['module']);

        // TODO: When the create ACL goes in to effect, add it here.
        if (!$bean->ACLAccess('save', $this->aclCheckOptions)) {
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
        } else {
            $args['id'] = create_guid();
        }

        $bean->id = $args['id'];
        $bean->new_with_id = true;

        $additionalProperties['additional_rel_values'] = $this->getRelatedFields($args, $bean);

        // register newly created bean so that it could be accessible by related beans before it's saved
        BeanFactory::registerBean($bean);

        foreach ($additionalProperties as $property => $value) {
            $bean->$property = $value;
        }

        // populate parent bean before saving related ones
        $this->populateBean($bean, $api, $args);

        // If we uploaded files during the record creation, move them from
        // the temporary folder to the configured upload folder.
        // FIXME Moving temporary files will be handled better in BR-2059.
        $this->moveTemporaryFiles($args, $bean);

        $relateArgs = $this->getRelatedRecordArguments($bean, $args, 'add');
        $this->linkRelatedRecords($api, $bean, $relateArgs, 'create', 'view');

        $relateArgs = $this->getRelatedRecordArguments($bean, $args, 'create');
        $this->createRelatedRecords($api, $bean, $relateArgs);

        // finally save parent bean
        $this->saveBean($bean, $api, $args);

        $args['record'] = $bean->id;

        $this->processAfterCreateOperations($args, $bean);

        return $this->reloadBean($api, $args);
    }

    public function updateRecord($api, $args) {
        $api->action = 'view';
        $this->requireArgs($args,array('module','record'));

        $bean = $this->loadBean($api, $args, 'save', $this->aclCheckOptions);
        $api->action = 'save';

        // If we uploaded files during the record update, move them from
        // the temporary folder to the configured upload folder.
        // FIXME Moving temporary files will be handled better in BR-2059.
        $this->moveTemporaryFiles($args, $bean);
        $this->updateBean($bean, $api, $args);

        $relateArgs = $this->getRelatedRecordArguments($bean, $args, 'delete');
        $this->unlinkRelatedRecords($api, $bean, $relateArgs);

        $relateArgs = $this->getRelatedRecordArguments($bean, $args, 'add');
        $this->linkRelatedRecords($api, $bean, $relateArgs);

        $relateArgs = $this->getRelatedRecordArguments($bean, $args, 'create');
        $this->createRelatedRecords($api, $bean, $relateArgs);

        return $this->getLoadedAndFormattedBean($api, $args);
    }

    public function retrieveRecord($api, $args) {
        $this->requireArgs($args,array('module','record'));

        $bean = $this->loadBean($api, $args, 'view');
        
        // formatBean is soft on view so that creates without view access will still work
        if (!$bean->ACLAccess('view', $this->aclCheckOptions)) {
            throw new SugarApiExceptionNotAuthorized('SUGAR_API_EXCEPTION_RECORD_NOT_AUTHORIZED',array('view'));
        }

        $api->action = 'view';
        $data = $this->formatBean($api, $args, $bean);

        return $data;

    }

    public function deleteRecord($api, $args) {
        $this->requireArgs($args,array('module','record'));

        $bean = $this->loadBean($api, $args, 'delete', $this->aclCheckOptions);
        $bean->mark_deleted($args['record']);

        return array('id'=>$bean->id);
    }

    public function setFavorite($api, $args) {
        $this->requireArgs($args, array('module', 'record'));
        $bean = $this->loadBean($api, $args, 'view');

        if (!$bean->ACLAccess('view', $this->aclCheckOptions)) {
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

        if (!$bean->ACLAccess('view', $this->aclCheckOptions)) {
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
     * Gets an array of additional related fields, to be set during bean relationship save
     *
     * @param array $args The request arguments.
     * @param SugarBean $bean The bean associated.
     * @return array Array of additional related fields
     */
    protected function getRelatedFields($args, SugarBean $bean)
    {
        $additional_rel_fields = array();

        foreach ($bean->field_defs as $fieldName => $fieldDef) {
            if (isset($fieldDef['rname_link']) && !empty($args[$fieldDef['name']])) {
                $additional_rel_fields[$fieldDef['rname_link']] = $args[$fieldDef['name']];
            }
        }
        return $additional_rel_fields;
    }

    /**
     * Moves temporary files associated with the bean from the temporary folder
     * to the upload folder.
     *
     * @param array $args The request arguments.
     * @param SugarBean $bean The bean associated with the file.
     * @throws SugarApiExceptionInvalidParameter If the file mime types differ
     *   from $imageFileMimeTypes.
     */
    protected function moveTemporaryFiles($args, SugarBean $bean)
    {
        require_once 'include/upload_file.php';
        require_once 'include/SugarFields/SugarFieldHandler.php';

        $fileFields = $bean->getFieldDefinitions('type', array('file', 'image'));
        $sfh = new SugarFieldHandler();
        // FIXME This path should be changed with BR-1955.
        $basepath = UploadStream::path('upload://tmp/');
        $configDir = SugarConfig::getInstance()->get('upload_dir', 'upload');

        foreach ($fileFields as $fieldName => $def) {
            if (empty($args[$fieldName . '_guid'])) {
                continue;
            }
            $this->verifyFieldAccess($bean, $fieldName);
            $filepath = $basepath . $args[$fieldName . '_guid'];

            if (!is_file($filepath)) {
                continue;
            }

            if ($def['type'] === 'image') {
                $filename = $args[$fieldName . '_guid'];
                $bean->$fieldName = $filename;
            } else {
                // FIXME Image verification and mime type updating
                // should not be duplicated from SugarFieldFile.
                // SC-3338 is tracking this.
                require_once 'include/utils/file_utils.php';
                $filename = $bean->id;
                $mimeType = get_file_mime_type($filepath, 'application/octet-stream');
                $sf = $sfh->getSugarField($def['type']);
                $extension = pathinfo($fieldName, PATHINFO_EXTENSION);

                if (in_array($mimeType, $sf::$imageFileMimeTypes) &&
                    !verify_image_file($filepath)
                ) {
                    throw new SugarApiExceptionInvalidParameter(string_format(
                        $GLOBALS['app_strings']['LBL_UPLOAD_IMAGE_FILE_NOT_SUPPORTED'],
                        array($extension)
                    ));
                }

                $bean->file_mime_type = $mimeType;
                $bean->file_ext = $extension;
            }

            $destination = rtrim($configDir, '/\\') . '/' . $filename;
            // FIXME BR-1956 will address having multiple files
            // associated with a record.
            rename($filepath, $destination);
        }
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
        $bean = $this->reloadBean($api, $args);
        $data = $this->formatBeanAfterSave($api, $args, $bean);

        return $data;
    }

    /**
     * Reloads the bean defined by arguments bypassing cache
     *
     * @param ServiceBase $api
     * @param array $args API arguments
     *
     * @return SugarBean
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiExceptionNotFound
     */
    protected function reloadBean(ServiceBase $api, array $args)
    {
        // Load the bean fresh to ensure the cache entry from the create process
        // doesn't get in the way of visibility checks
        return $this->loadBean($api, $args, 'view', array('use_cache' => false));
    }

    /**
     * Formats the bean which was previously saved with admission that the bean may be not accessible
     * to the current user anymore
     *
     * @param ServiceBase $api
     * @param array $args API arguments
     * @param SugarBean $bean The saved bean
     *
     * @return array Formatted representation of the bean
     */
    protected function formatBeanAfterSave(ServiceBase $api, array $args, SugarBean $bean)
    {
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

    /**
     * Returns arguments for RelateRecordApi for the given action
     *
     * @param SugarBean $bean Primary bean
     * @param array $args This API arguments
     * @param string $action Related record action.
     *
     * @return array
     * @throws SugarApiExceptionInvalidParameter
     */
    protected function getRelatedRecordArguments(SugarBean $bean, array $args, $action)
    {
        $arguments = array();
        foreach ($bean->getFieldDefinitions() as $field => $definition) {
            if (!isset($definition['type']) || $definition['type'] != 'link') {
                continue;
            }
            if (!isset($args[$field])) {
                continue;
            }
            if (!is_array($args[$field])) {
                throw new SugarApiExceptionInvalidParameter(
                    sprintf(
                        'Link field must contain array of actions, %s given',
                        gettype($field)
                    )
                );
            }
            if (!isset($args[$field][$action])) {
                continue;
            }

            $data = $args[$field][$action];

            if (!is_array($data)) {
                throw new SugarApiExceptionInvalidParameter(
                    sprintf(
                        'Link action data must be array, %s given',
                        gettype($data)
                    )
                );
            }

            $arguments[$field] = $data;
        }

        return $arguments;
    }

    /**
     * Links related records to the given bean
     *
     * @param ServiceBase $service
     * @param SugarBean $bean Primary bean
     * @param array $ids Related record IDs
     * @param string $securityTypeLocal What ACL to check on the near side of the link
     * @param string $securityTypeRemote What ACL to check on the far side of the link
     *
     * @throws SugarApiExceptionInvalidParameter
     * @throws SugarApiExceptionNotFound
     */
    protected function linkRelatedRecords(
        ServiceBase $service,
        SugarBean $bean,
        array $ids,
        $securityTypeLocal = 'view',
        $securityTypeRemote = 'view'
    ) {
        $api = $this->getRelateRecordApi();
        foreach ($ids as $linkName => $items) {
            $api->createRelatedLinks($service, array(
                'module' => $bean->module_name,
                'record' => $bean->id,
                'link_name' => $linkName,
                'ids' => $items,
            ), $securityTypeLocal, $securityTypeRemote);
        }
    }

    /**
     * Unlinks related records from the given bean
     *
     * @param ServiceBase $service
     * @param SugarBean $bean Primary bean
     * @param array $ids Related record IDs
     *
     * @throws SugarApiExceptionNotFound
     */
    protected function unlinkRelatedRecords(ServiceBase $service, SugarBean $bean, array $ids)
    {
        $api = $this->getRelateRecordApi();
        foreach ($ids as $linkName => $items) {
            foreach ($items as $id) {
                $api->deleteRelatedLink($service, array(
                    'module' => $bean->module_name,
                    'record' => $bean->id,
                    'link_name' => $linkName,
                    'remote_id' => $id,
                ));
            }
        }
    }

    /**
     * Creates related records for the given bean
     *
     * @param ServiceBase $service
     * @param SugarBean $bean Primary bean
     * @param array $data New record data
     */
    protected function createRelatedRecords(ServiceBase $service, SugarBean $bean, array $data)
    {
        $api = $this->getRelateRecordApi();
        foreach ($data as $linkName => $records) {
            foreach ($records as $record) {
                $api->createRelatedRecord($service, array_merge($record, array(
                    'module' => $bean->module_name,
                    'record' => $bean->id,
                    'link_name' => $linkName,
                )));
            }
        }
    }

    /**
     * Lazily loads RelateRecord API
     *
     * @return RelateRecordApi
     */
    protected function getRelateRecordApi()
    {
        if (!$this->relateRecordApi) {
            require_once 'clients/base/api/RelateRecordApi.php';
            $this->relateRecordApi = new RelateRecordApi();
        }

        return $this->relateRecordApi;
    }
}
