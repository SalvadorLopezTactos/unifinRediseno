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

require_once 'clients/base/api/ModuleApi.php';
require_once 'data/BeanFactory.php';

$wrapperPath = 'modules/pmse_Project/clients/base/api/wrappers/';
require_once $wrapperPath . 'PMSEProjectWrapper.php';
require_once $wrapperPath . 'PMSECrmDataWrapper.php';
require_once $wrapperPath . 'PMSEActivityDefinitionWrapper.php';
require_once $wrapperPath . 'PMSEEventDefinitionWrapper.php';
require_once $wrapperPath . 'PMSEGatewayDefinitionWrapper.php';
require_once $wrapperPath . 'PMSEDynaForm.php';
require_once $wrapperPath . 'PMSEObservers/PMSEEventObserver.php';
require_once $wrapperPath . 'PMSEObservers/PMSEProcessObserver.php';

$enginePath = 'modules/pmse_Inbox/engine/';
require_once $enginePath . 'PMSEProjectImporter.php';
require_once $enginePath . 'PMSEProjectExporter.php';

class PMSEProjectApi extends ModuleApi
{
    /**
     * PMSEProjectWrapper object
     * @var PMSEProjectWrapper
     */
    protected $projectWrapper;

    /**
     * PMSECrmDataWrapper object
     * @var PMSECrmDataWrapper
     */
    protected $crmDataWrapper;

    /**
     * PMSEActivityDefinitionWrapper object
     * @var PMSEActivityDefinitionWrapper
     */
    protected $activityDefinitionWrapper;

    /**
     * PMSEEventDefinitionWrapper object
     * @var PMSEEventDefinitionWrapper
     */
    protected $eventDefinitionWrapper;

    /**
     * PMSEGatewayDefinitionWrapper object
     * @var PMSEGatewayDefinitionWrapper
     */
    protected $gatewayDefinitionWrapper;

    public function __construct()
    {
        $this->projectWrapper = new PMSEProjectWrapper();
        $this->crmDataWrapper = new PMSECrmDataWrapper();
        $this->activityDefinitionWrapper = new PMSEActivityDefinitionWrapper();
        $this->eventDefinitionWrapper = new PMSEEventDefinitionWrapper();
        $this->gatewayDefinitionWrapper = new PMSEGatewayDefinitionWrapper();
    }

    /**
     *
     * @return type
     */
    public function registerApiRest()
    {
        return array(
            'readCustomProject' => array(
                'reqType' => 'GET',
                'path' => array('pmse_Project', 'project', '?'),
                'pathVars' => array('module', 'customAction', 'record'),
                'method' => 'retrieveCustomProject',
                'acl' => 'view',
//                'shortHelp' => 'Returns the Process Definition schema to be used by PA designer',
            ),
            'updateCustomProject' => array(
                'reqType' => 'PUT',
                'path' => array('pmse_Project', 'project', '?'),
                'pathVars' => array('module', 'customAction', 'record'),
                'method' => 'updateCustomProject',
                'acl' => 'create',
//                'shortHelp' => 'Update the process definition schema edited in PA designer',
            ),
            'readBRFields' => array(
                'reqType' => 'GET',
                'path' => array('ProcessBusinessRules', 'fields', '?'),
                'pathVars' => array('module', 'data', 'filter'),
                'method' => 'getBRFields',
                'acl' => 'view',
//                'shortHelp' => 'Returns information about Fields to be exposed in the Business Rules designer.',
            ),
            'readCrmData' => array(
                'reqType' => 'GET',
                'path' => array('pmse_Project', 'CrmData', '?', '?'),
                'pathVars' => array('module', '', 'data', 'filter'),
                'method' => 'getCrmData',
                'acl' => 'view',
//                'shortHelp' => 'Returns information about Fields, Modules, Users, Roles, etc.',
            ),
            'updateCrmData' => array(
                'reqType' => 'PUT',
                'path' => array('pmse_Project', 'CrmData', '?', '?'),
                'pathVars' => array('module', '', 'record', 'filter'),
                'method' => 'putCrmData',
                'acl' => 'create',
//                'shortHelp' => 'Update information about Fields, Modules, Users, Roles, etc.',
            ),
            'readCrmDataWithoutFilters' => array(
                'reqType' => 'GET',
                'path' => array('pmse_Project', 'CrmData', '?'),
                'pathVars' => array('module', '', 'data'),
                'method' => 'getCrmData',
                'acl' => 'view',
//                'shortHelp' => 'Returns information without send filter about Fields, Modules, Users, Roles,',
            ),
            'readActivityDefinition' => array(
                'reqType' => 'GET',
                'path' => array('pmse_Project', 'ActivityDefinition', '?'),
                'pathVars' => array('module', '', 'record'),
                'method' => 'getActivityDefinition',
                'acl' => 'view',
//                'shortHelp' => 'Returns definition data for activities',
            ),
            'updateActivityDefinition' => array(
                'reqType' => 'PUT',
                'path' => array('pmse_Project', 'ActivityDefinition', '?'),
                'pathVars' => array('module', '', 'record'),
                'method' => 'putActivityDefinition',
                'acl' => 'create',
//                'shortHelp' => 'Update definition data for activities',
            ),
            'readEventDefinition' => array(
                'reqType' => 'GET',
                'path' => array('pmse_Project', 'EventDefinition', '?'),
                'pathVars' => array('module', '', 'record'),
                'method' => 'getEventDefinition',
                'acl' => 'view',
//                'shortHelp' => 'Returns definition data for events',
            ),
            'updateEventDefinition' => array(
                'reqType' => 'PUT',
                'path' => array('pmse_Project', 'EventDefinition', '?'),
                'pathVars' => array('module', '', 'record'),
                'method' => 'putEventDefinition',
                'acl' => 'create',
//                'shortHelp' => 'Update definition data for events',
            ),
            'readGatewayDefinition' => array(
                'reqType' => 'GET',
                'path' => array('pmse_Project', 'GatewayDefinition', '?'),
                'pathVars' => array('module', '', 'record'),
                'method' => 'getGatewayDefinition',
                'acl' => 'view',
//                'shortHelp' => 'Returns definition data for gateways',
            ),
            'updateGatewayDefinition' => array(
                'reqType' => 'PUT',
                'path' => array('pmse_Project', 'GatewayDefinition', '?'),
                'pathVars' => array('module', '', 'record'),
                'method' => 'putGatewayDefinition',
                'acl' => 'create',
//                'shortHelp' => 'Update definition data for gateways',
            ),
            'verifyRunningProcess' => array(
                'reqType' => 'GET',
                'path' => array('pmse_Project', '?', 'verify'),
                'pathVars' => array('module', 'record', 'verify'),
                'method' => 'verifyRunningProcess',
                'acl' => 'view',
//                'shortHelp' => 'Informs if the Process Definition has pending processes',
            )
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

    public function retrieveCustomProject($api, $args)
    {
        $this->checkACL($api, $args);
        $api->action = "read";
        $this->requireArgs($args, array('record'));

        return $this->projectWrapper->retrieveProject($args['record']);
    }

    public function updateCustomProject($api, $args)
    {
        $this->checkACL($api, $args);
        $api->action = "update";
        $this->requireArgs($args, array('record'));

        return $this->projectWrapper->updateProject($args['record'], $args);
    }

    /**
     * Shared method from create and update process that handles records that
     * might not pass visibility checks. This method assumes the API has validated
     * the authorization to create/edit records prior to this point.
     *
     * @param ServiceBase $api The service object
     * @param array $args Request arguments
     * @param SugarBean $bean The bean for this process
     * @return array Array of formatted fields
     */
    protected function getLoadedAndFormattedBean($api, $args, SugarBean $bean)
    {
        $addNoAccessAcl = false;
        // Load the bean fresh to ensure the cache entry from the create process
        // doesn't get in the way of visibility checks
        try {
            $bean = $this->loadBean($api, $args, 'view', array('use_cache' => false));
        } catch (SugarApiExceptionNotAuthorized $e) {
            // If there was an exception thrown from the load process then strip
            // the field list down and return only id and date_modified. This will
            // happen on new records created with visibility rules that conflict
            // with the current user or from edits made to records that do the same
            // thing.
            $args['fields'] = 'id,date_modified';
            $addNoAccessAcl = true;
        }

        $api->action = 'view';
        $data = $this->formatBean($api, $args, $bean);

        if ($addNoAccessAcl) {
            $data['_acl'] = array(
                'access' => 'no',
                'view' => 'no',
            );
        }

        return $data;
    }

    /**
     *
     * @param ServiceBase $api
     * @param array $args
     * @return type
     */
    public function getBRFields($api, $args)
    {
        $args['module'] = 'pmse_Project';
        $args['data'] = 'oneToOneRelated';
        $args['filter'] = $args['base_module'];
        return $this->getCrmData($api, $args);
    }

    /**
     *
     * @param ServiceBase $api
     * @param array $args
     * @return type
     */
    public function getCrmData($api, $args)
    {
        $this->checkACL($api, $args);
        return $this->crmDataWrapper->_get($args, $this);
    }

    /**
     *
     * @param ServiceBase $api
     * @param array $args
     * @return type
     */
    public function putCrmData($api, $args)
    {
        $this->checkACL($api, $args);
        $processObserver = new PMSEProcessObserver();
        $this->crmDataWrapper->attach($processObserver);
        return $this->crmDataWrapper->_put($args);
    }

    /**
     *
     * @param ServiceBase $api
     * @param array $args
     * @return type
     */
    public function getActivityDefinition($api, $args)
    {
        $this->checkACL($api, $args);
        return $this->activityDefinitionWrapper->_get($args);
    }

    public function putActivityDefinition($api, $args)
    {
        $this->checkACL($api, $args);
        return $this->activityDefinitionWrapper->_put($args);
    }

    /**
     *
     * @param ServiceBase $api
     * @param array $args
     * @return type
     */
    public function getEventDefinition($api, $args)
    {
        $this->checkACL($api, $args);
        return $this->eventDefinitionWrapper->_get($args);
    }

    public function putEventDefinition($api, $args)
    {
        $this->checkACL($api, $args);
        $observer = new PMSEEventObserver();
        $this->eventDefinitionWrapper->attach($observer);
        $this->eventDefinitionWrapper->_put($args);
    }

    public function getGatewayDefinition($api, $args)
    {
        $this->checkACL($api, $args);
        return $this->gatewayDefinitionWrapper->_get($args);
    }

    public function putGatewayDefinition($api, $args)
    {
        $this->checkACL($api, $args);
        return $this->gatewayDefinitionWrapper->_put($args);
    }

    public function verifyRunningProcess($api, $args)
    {
        $this->checkACL($api, $args);
        if (empty($args['baseModule'])) {
            $projectBean = BeanFactory::getBean($args['module'], $args['record'],
                array('strict_retrieve' => true, 'disable_row_level_security' => true));
            $processBean = BeanFactory::getBean('pmse_BpmnProcess')->retrieve_by_string_fields(array("prj_id" => $projectBean->id));
            $casesBean = BeanFactory::getBean('pmse_Inbox');
            $sql = new SugarQuery();
            $sql->select('id');
            $sql->from($casesBean);
            $sql->where()
                ->queryAnd()
                ->equals('pro_id', $processBean->id)
                ->notEquals('cas_status', 'COMPLETED')
                ->notEquals('cas_status', 'TERMINATED')
                ->notEquals('cas_status', 'CANCELLED');
            if ($sql->execute()) {
                return true;
            }
        } else {
            switch ($args['baseModule']) {
                case 'pmse_Business_Rules':
                    $bean = BeanFactory::getBean('pmse_BpmActivityDefinition');
                    $where = 'act_fields';
                    break;
                case 'pmse_Emails_Templates':
                    $bean = BeanFactory::getBean('pmse_BpmEventDefinition');
                    $where = 'evn_criteria';
                    break;
                default:
                    return false;
            }
            $id = $args['record'];
            $sql = new SugarQuery();
            $sql->select(array('pro_id'));
            $sql->from($bean);
            $sql->where()->equals($where, $id);
            $processes = $sql->execute();
            if (!empty($processes)) {
                foreach ($processes as $process) {
                    $process_definition = BeanFactory::getBean('pmse_BpmProcessDefinition', $process['pro_id']);
                    if ($process_definition->pro_status == 'ACTIVE') {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
