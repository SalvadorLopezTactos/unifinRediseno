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

require_once 'data/BeanFactory.php';
require_once 'clients/base/api/vCardApi.php';
require_once 'modules/pmse_Inbox/engine/PMSEProjectImporter.php';
require_once 'modules/pmse_Inbox/engine/PMSEProjectExporter.php';

class PMSEProjectImportExportApi extends vCardApi
{
    /**
     *
     * @return type
     */
    public function registerApiRest()
    {
        return array(
            'projectImportPost' => array(
                'reqType' => 'POST',
                'path' => array('pmse_Project', 'file', 'project_import'),
                'pathVars' => array('module', '', ''),
                'method' => 'projectImport',
                'rawPostContents' => true,
                'acl' => 'create',
//                'shortHelp' => 'Imports a Process Definition from a .bpm file',
            ),
            'projectDownload' => array(
                'reqType' => 'GET',
                'path' => array('pmse_Project', '?', 'dproject'),
                'pathVars' => array('module', 'record', ''),
                'method' => 'projectDownload',
                'rawReply' => true,
                'allowDownloadCookie' => true,
                'acl' => 'view',
//                'shortHelp' => 'Exports a .bpm file with a Process Definition',
            ),
        );
    }

    /**
     * This method check acl access in custom APIs
     * @param $api
     * @param $args
     * @throws SugarApiExceptionNotAuthorized
     */
    private function checkACL($api, $args)
    {
        $route = $api->getRequest()->getRoute();
        if (isset($route['acl'])) {
            $acl = $route['acl'];

            $seed = BeanFactory::newBean($args['module']);

            if (!$seed->ACLAccess($acl)) {
                throw new SugarApiExceptionNotAuthorized('No access to view/edit records for module: ' . $args['module']);
            }
        }
    }

    public function projectDownload($api, $args)
    {
        $this->checkACL($api, $args);
        $projectBean = new PMSEProjectExporter();
        $requiredFields = array('record', 'module');
        foreach ($requiredFields as $fieldName) {
            if (!array_key_exists($fieldName, $args)) {
                throw new SugarApiExceptionMissingParameter('Missing parameter: ' . $fieldName);
            }
        }
        
        if (PMSEEngineUtils::isExportDisabled($args['module'])) {
            throw new SugarApiExceptionNotAuthorized($GLOBALS['app_strings']['ERR_EXPORT_DISABLED']);
        }

        return $projectBean->exportProject($args['record'], $api);
    }

    public function projectImport($api, $args)
    {
        $this->checkACL($api, $args);
        $this->requireArgs($args, array('module'));

        $bean = BeanFactory::getBean($args['module']);
        if (!$bean->ACLAccess('save') || !$bean->ACLAccess('import')) {
            throw new SugarApiExceptionNotAuthorized('EXCEPTION_NOT_AUTHORIZED');
        }

        if (isset($_FILES) && count($_FILES) === 1) {
            reset($_FILES);
            $first_key = key($_FILES);
            if (isset($_FILES[$first_key]['tmp_name'])
                && $this->isUploadedFile($_FILES[$first_key]['tmp_name'])
                && isset($_FILES[$first_key]['size'])
                && isset($_FILES[$first_key]['size']) > 0
            ) {
                $importerObject = new PMSEProjectImporter();
                $name = $_FILES[$first_key]['name'];
                $extension = pathinfo($name,  PATHINFO_EXTENSION);
                if ($extension == $importerObject->getExtension()) {
                    try {
                        $data = $importerObject->importProject($_FILES[$first_key]['tmp_name']);
                    } catch (SugarApiExceptionNotAuthorized $e) {
                        throw new SugarApiExceptionNotAuthorized('ERROR_UPLOAD_ACCESS_PD');
                    }
                    $results = array('project_import' => $data);
                } else  {
                    throw new SugarApiExceptionRequestMethodFailure('ERROR_UPLOAD_FAILED');
                }
                return $results;
            }
        } else {
            throw new SugarApiExceptionMissingParameter('ERROR_UPLOAD_FAILED');
        }
    }
}