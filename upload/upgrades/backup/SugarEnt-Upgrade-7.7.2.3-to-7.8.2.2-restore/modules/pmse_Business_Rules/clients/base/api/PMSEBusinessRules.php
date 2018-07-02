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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'data/BeanFactory.php';
require_once 'clients/base/api/vCardApi.php';

require_once 'modules/pmse_Inbox/engine/PMSEBusinessRuleExporter.php';
require_once 'modules/pmse_Inbox/engine/PMSEBusinessRuleImporter.php';

class PMSEBusinessRules extends vCardApi
{
    public function registerApiRest()
    {
        return array(
            'businessRuleDownload' => array(
                'reqType' => 'GET',
                'path' => array('pmse_Business_Rules', '?', 'brules'),
                'pathVars' => array('module', 'record', ''),
                'method' => 'businessRuleDownload',
                'rawReply' => true,
                'allowDownloadCookie' => true,
                'acl' => 'view',
//                'shortHelp' => 'Exports a .pbr file with a Process Business Rules definition',
            ),
            'businessRulesImportPost' => array(
                'reqType' => 'POST',
                'path' => array('pmse_Business_Rules', 'file', 'businessrules_import'),
                'pathVars' => array('module', '', ''),
                'method' => 'businessRulesImport',
                'rawPostContents' => true,
                'acl' => 'create',
//                'shortHelp' => 'Imports a Process Business Rules record from a .pbr file',
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

    /**
     * @param $api
     * @param $args
     * @return array
     * @throws SugarApiExceptionMissingParameter
     * @throws SugarApiExceptionRequestMethodFailure
     * @throws SugarApiExceptionNotAuthorized
     */
    public function businessRulesImport($api, $args)
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
                && !empty($_FILES[$first_key]['size'])
            ) {
                $importerObject = new PMSEBusinessRuleImporter();
                $name = $_FILES[$first_key]['name'];
                $extension = pathinfo($name,  PATHINFO_EXTENSION);
                if ($extension == $importerObject->getExtension()) {
                    try {
                        $data = $importerObject->importProject($_FILES[$first_key]['tmp_name']);
                    } catch (SugarApiExceptionNotAuthorized $e) {
                        throw new SugarApiExceptionNotAuthorized('ERROR_UPLOAD_ACCESS_BR');
                    }
                    $results = array('businessrules_import' => $data);
                } else  {
                    throw new SugarApiExceptionRequestMethodFailure('ERROR_UPLOAD_FAILED');
                }
                return $results;
            }
        } else {
            throw new SugarApiExceptionMissingParameter('ERROR_UPLOAD_FAILED');
        }
    }

    /**
     * @param $api
     * @param $args
     * @return string
     * @throws SugarApiExceptionMissingParameter
     */
    public function businessRuleDownload($api, $args)
    {
        $this->checkACL($api, $args);
        $emailTemplate = $this->getPMSEBusinessRuleExporter();
        $requiredFields = array('record', 'module');
        foreach ($requiredFields as $fieldName) {
            if (!array_key_exists($fieldName, $args)) {
                throw new SugarApiExceptionMissingParameter('Missing parameter: ' . $fieldName);
            }
        }

        if (PMSEEngineUtils::isExportDisabled($args['module'])) {
            throw new SugarApiExceptionNotAuthorized($GLOBALS['app_strings']['ERR_EXPORT_DISABLED']);
        }

        return $emailTemplate->exportProject($args['record'], $api);
    }

    /*
     * @return PMSEBusinessRuleExporter
     */
    public function getPMSEBusinessRuleExporter()
    {
        return new PMSEBusinessRuleExporter();
    }
}
