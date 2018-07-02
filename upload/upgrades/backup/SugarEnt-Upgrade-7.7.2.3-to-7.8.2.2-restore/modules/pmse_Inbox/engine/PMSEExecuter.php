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

require_once 'modules/pmse_Inbox/engine/PMSELogger.php';
require_once 'modules/pmse_Inbox/engine/PMSEHandlers/PMSECaseFlowHandler.php';
require_once 'modules/pmse_Inbox/engine/PMSEFlowRouter.php';
require_once 'modules/pmse_Inbox/engine/PMSEExceptions/PMSEElementException.php';

class PMSEExecuter
{
    /**
     *
     * @var PMSECaseFlowHandler
     */
    protected $caseFlowHandler;

    /**
     *
     * @var PMSEFlowRouter
     */
    protected $flowRouter;

    /**
     *
     * @var PMSELogger
     */
    protected $logger;

    /**
     *
     * @var int
     */
    protected $maxExecutionTimeout;

    /**
     *
     * @var int
     */
    protected $maxExecutionCycleNumber;

    /**
     *
     * @var array
     */
    protected $executedElements;

    /**
     *
     * @var array
     */
    protected $executionTime;

    /**
     * PMSEExecuter constructor
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        global $sugar_config;
        $this->caseFlowHandler = new PMSECaseFlowHandler();
        $this->flowRouter = new PMSEFlowRouter();
        $this->logger = PMSELogger::getInstance();

        $settings = $sugar_config['pmse_settings_default'];
        $this->maxExecutionCycleNumber = (int)$settings['error_number_of_cycles'];
        $this->maxExecutionTimeout = (int)$settings['error_timeout'];
        $this->executedElements = array();
        $this->executionTime = 0;
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getCaseFlowHandler()
    {
        return $this->caseFlowHandler;
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getFlowRouter()
    {
        return $this->flowRouter;
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     *
     * @param type $caseFlowHandler
     * @codeCoverageIgnore
     */
    public function setCaseFlowHandler($caseFlowHandler)
    {
        $this->caseFlowHandler = $caseFlowHandler;
    }

    /**
     *
     * @param type $flowRouter
     * @codeCoverageIgnore
     */
    public function setFlowRouter($flowRouter)
    {
        $this->flowRouter = $flowRouter;
    }

    /**
     *
     * @param type $logger
     * @codeCoverageIgnore
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     *
     * @param type $elementName
     * @return PMSEElement
     * @codeCoverageIgnore
     */
    public function retrievePMSEElement($elementName = '')
    {
        $modulePath = 'modules/pmse_Inbox/engine/PMSEElements';
        switch ($elementName) {
            case 'PMSEStartEvent':
                require_once $modulePath . '/PMSEStartEvent.php';
                return new PMSEStartEvent();
            case 'PMSEEndEvent':
                require_once $modulePath . '/PMSEEndEvent.php';
                return new PMSEEndEvent();
            case 'PMSEEndSendMessageEvent':
                require_once $modulePath . '/PMSEEndSendMessageEvent.php';
                return new PMSEEndSendMessageEvent();
            case 'PMSETerminateEvent':
                require_once $modulePath . '/PMSETerminateEvent.php';
                return new PMSETerminateEvent();
            case 'PMSESendMessageEvent':
                require_once $modulePath . '/PMSESendMessageEvent.php';
                return new PMSESendMessageEvent();
            case 'PMSEReceiveMessageEvent':
                require_once $modulePath . '/PMSEReceiveMessageEvent.php';
                return new PMSEReceiveMessageEvent();
            case 'PMSETimerEvent':
                require_once $modulePath . '/PMSETimerEvent.php';
                return new PMSETimerEvent();
            case 'PMSEUserTask':
                require_once $modulePath . '/PMSEUserTask.php';
                return new PMSEUserTask();
            case 'PMSEBusinessRule':
                require_once $modulePath . '/PMSEBusinessRule.php';
                return new PMSEBusinessRule();
            case 'PMSEChangeField':
                require_once $modulePath . '/PMSEChangeField.php';
                return new PMSEChangeField();
            case 'PMSERoundRobin':
                require_once $modulePath . '/PMSERoundRobin.php';
                return new PMSERoundRobin();
            case 'PMSEAssignUser':
                require_once $modulePath . '/PMSEAssignUser.php';
                return new PMSEAssignUser();
            case 'PMSEAddRelatedRecord':
                require_once $modulePath . '/PMSEAddRelatedRecord.php';
                return new PMSEAddRelatedRecord();
            case 'PMSEConvergingParallelGateway':
                require_once $modulePath . '/PMSEConvergingParallelGateway.php';
                return new PMSEConvergingParallelGateway();
            case 'PMSEDivergingParallelGateway':
                require_once $modulePath . '/PMSEDivergingParallelGateway.php';
                return new PMSEDivergingParallelGateway();
            case 'PMSEConvergingExclusiveGateway':
                require_once $modulePath . '/PMSEConvergingExclusiveGateway.php';
                return new PMSEConvergingExclusiveGateway();
            case 'PMSEDivergingExclusiveGateway':
                require_once $modulePath . '/PMSEDivergingExclusiveGateway.php';
                return new PMSEDivergingExclusiveGateway();
            case 'PMSEDivergingInclusiveGateway':
                require_once $modulePath . '/PMSEDivergingInclusiveGateway.php';
                return new PMSEDivergingInclusiveGateway();
            case 'PMSEDivergingEventBasedGateway':
                require_once $modulePath . '/PMSEDivergingEventBasedGateway.php';
                return new PMSEDivergingEventBasedGateway();
            case 'PMSESequenceFlow':
                require_once $modulePath . '/PMSESequenceFlow.php';
                return new PMSESequenceFlow();
            case 'PMSEInvalidElement':
                require_once $modulePath . '/PMSEInvalidElement.php';
                return new PMSEInvalidElement();
            default:
                require_once $modulePath . '/PMSEElement.php';
                return new PMSEElement();
        }
    }

    /**
     *
     * @param type $flowData
     * @return type
     */
    public function retrieveElementByType($flowData)
    {
        switch ($flowData['bpmn_type']) {
            case 'bpmnActivity':
                $bpmnElement = $this->retrieveActivityElement($flowData['bpmn_id']);
                break;
            case 'bpmnEvent':
                $bpmnElement = $this->retrieveEventElement($flowData['bpmn_id']);
                break;
            case 'bpmnGateway':
                $bpmnElement = $this->retrieveGatewayElement($flowData['bpmn_id']);
                break;
            case 'bpmnFlow':
                $bpmnElement = $this->retrieveFlowElement($flowData['bpmn_id']);
                break;
            default:
                $bpmnElement = $this->retrievePMSEElement();
                break;
        }

        return $bpmnElement;
    }

    /**
     *
     * @param type $id
     * @return boolean
     */
    public function retrieveActivityElement($id)
    {
        $bpmnBean = $this->caseFlowHandler->retrieveBean('pmse_BpmnActivity');
        $definitionBean = $this->caseFlowHandler->retrieveBean('pmse_BpmActivityDefinition');
        $bpmnBean->retrieve($id);
        $definitionBean->retrieve($id);

        $bpmElement = false;
        switch ($bpmnBean->act_task_type) {
            case 'SCRIPTTASK':
                switch ($bpmnBean->act_script_type) {
                    case 'BUSINESS_RULE':
                        $bpmElement = $this->retrievePMSEElement('PMSEBusinessRule');
                        break;
                    case 'CHANGE_FIELD':
                        $bpmElement = $this->retrievePMSEElement('PMSEChangeField');
                        break;
                    case 'ASSIGN_TEAM':
                        $bpmElement = $this->retrievePMSEElement('PMSERoundRobin');
                        break;
                    case 'ASSIGN_USER':
                        $bpmElement = $this->retrievePMSEElement('PMSEAssignUser');
                        break;
                    case 'ADD_RELATED_RECORD':
                        $bpmElement = $this->retrievePMSEElement('PMSEAddRelatedRecord');
                        break;
                    default:
                        $bpmElement = $this->retrievePMSEElement('PMSEInvalidElement');
                        break;
                }
                break;
            case 'USERTASK':
                $bpmElement = $this->retrievePMSEElement('PMSEUserTask');
                break;
            default :
                $bpmElement = $this->retrievePMSEElement();
                break;
        }

        $bpmElement->setExecutionMode($definitionBean->execution_mode);
        return $bpmElement;
    }

    /**
     *
     * @param type $id
     * @return boolean
     * @codeCoverageIgnore
     */
    public function retrieveEventElement($id)
    {
        $bpmnBean = $this->caseFlowHandler->retrieveBean('pmse_BpmnEvent');
        $definitionBean = $this->caseFlowHandler->retrieveBean('pmse_BpmEventDefinition');
        $bpmnBean->retrieve($id);
        $definitionBean->retrieve($id);

        $bpmElement = false;

        switch ($bpmnBean->evn_type) {
            case 'START':
                $bpmElement = $this->retrievePMSEElement('PMSEStartEvent');
                break;
            case 'INTERMEDIATE':
                switch ($bpmnBean->evn_marker) {
                    case 'MESSAGE':
                        $bpmElement = $bpmnBean->evn_behavior === 'THROW' ? $this->retrievePMSEElement('PMSESendMessageEvent') : $this->retrievePMSEElement('PMSEReceiveMessageEvent');
                        break;
                    case 'TIMER':
                        $bpmElement = $this->retrievePMSEElement('PMSETimerEvent');
                        break;
                }
                break;
            case 'END':
                switch ($bpmnBean->evn_marker) {
                    case 'MESSAGE':
                        $bpmElement = $this->retrievePMSEElement('PMSEEndSendMessageEvent');
                        break;
                    case 'TERMINATE':
                        $bpmElement = $this->retrievePMSEElement('PMSETerminateEvent');
                        break;
                    default:
                        $bpmElement = $this->retrievePMSEElement('PMSEEndEvent');
                        break;
                }
                break;
            default :
                $bpmElement = false;
                break;
        }
        $bpmElement->setExecutionMode($definitionBean->execution_mode);
        return $bpmElement;
    }

    /**
     *
     * @param type $id
     * @return boolean
     * @codeCoverageIgnore
     */
    public function retrieveGatewayElement($id)
    {
        $bpmnBean = $this->caseFlowHandler->retrieveBean('pmse_BpmnGateway');
        $definitionBean = $this->caseFlowHandler->retrieveBean('pmse_BpmGatewayDefinition');
        $bpmnBean->retrieve($id);
        $definitionBean->retrieve($id);
        $bpmElement = false;

        switch ($bpmnBean->gat_type) {
            case 'PARALLEL':
                $bpmElement = $bpmnBean->gat_direction == 'CONVERGING' ? $this->retrievePMSEElement('PMSEConvergingParallelGateway') : $this->retrievePMSEElement('PMSEDivergingParallelGateway');
                break;
            case 'EXCLUSIVE':
                $bpmElement = $bpmnBean->gat_direction == 'CONVERGING' ? $this->retrievePMSEElement('PMSEConvergingExclusiveGateway') : $this->retrievePMSEElement('PMSEDivergingExclusiveGateway');
                break;
            case 'INCLUSIVE':
                $bpmElement = $this->retrievePMSEElement('PMSEDivergingInclusiveGateway');
                break;
            case 'EVENTBASED':
                $bpmElement = $this->retrievePMSEElement('PMSEDivergingEventBasedGateway');
                break;
            default :
                $bpmElement = false;
                break;
        }
        $bpmElement->setExecutionMode($definitionBean->execution_mode);
        return $bpmElement;
    }

    /**
     *
     * @param type $id
     * @return boolean
     * @codeCoverageIgnore
     */
    public function retrieveFlowElement($id)
    {
        $bpmnBean = $this->caseFlowHandler->retrieveBean('pmse_BpmnFlow');
        $bpmnBean->retrieve($id);
        $bpmElement = false;

        switch ($bpmnBean->flo_type) {
            case 'SEQUENCE':
            case 'DEFAULT':
                $bpmElement = $this->retrievePMSEElement('PMSESequenceFlow');
                break;
            default :
                $bpmElement = false;
                break;
        }
        return $bpmElement;
    }

    /**
     *
     * @param type $flowData
     * @param type $createThread
     * @param type $bean
     * @param type $externalAction
     * @param type $arguments
     * @return boolean
     * @codeCoverageIgnore
     */
    public function runEngine(
        $flowData,
        $createThread = false,
        $bean = null,
        $externalAction = '',
        $arguments = array()
    ) {
        
        // Load the bean if the request comes from a RESUME_EXECUTION related origin
        // like for example: a timer event execution.
        if (is_null($bean)) {
            $bean = BeanFactory::retrieveBean($flowData['cas_sugar_module'], $flowData['cas_sugar_object_id']);
        }

        // Validating unreferenced elements when cron jobs are executed, after MACAROON-518 shouldn't have
        // unreferenced elements. This will validate previous records created before this fix.
        if ($externalAction == 'WAKE_UP') {
            $elementBean = BeanFactory::getBean('pmse_BpmnEvent', $flowData['bpmn_id']);
            if (!isset($elementBean->id)) {

                // Setting active flow to deleted
                $fd = BeanFactory::getBean('pmse_BpmFlow', $flowData['id']);
                $fd->cas_flow_status = 'DELETED';
                $fd->save();

                // Updating process to error
                $cf = new PMSECaseFlowHandler();
                $cf->changeCaseStatus($flowData['cas_id'], 'TERMINATED');

                // Exiting without errors
                return true;
            }
        }
        
        $preparedData = $this->caseFlowHandler->prepareFlowData($flowData, $createThread);
        $this->logger->debug("Begin process Element {$flowData['bpmn_type']}");

        try {
            $executionData = $this->processElement($preparedData, $bean, $externalAction, $arguments);
            if (isset($executionData['process_bean']) && !empty($executionData['process_bean'])) {
                $bean = $executionData['process_bean'];
            }
            $this->validateFailSafes($flowData, $executionData);
            $routeData = $this->flowRouter->routeFlow($executionData, $flowData, $createThread);
        } catch (PMSEElementException $e) {
            $this->logger->alert($e->getMessage());
            $element = $e->getElement();
            $flow = $e->getFlowData();
            $state = (empty($flow['id'])) ? 'CREATE' : 'UPDATE';
            $executionData = $element->prepareResponse($flow, 'ERROR', $state);
            // If the status is put into error then the Inbox record should be updated as well
            $this->caseFlowHandler->changeCaseStatus($executionData['flow_data']['cas_id'], 'ERROR');
            $routeData = $this->flowRouter->routeFlow($executionData, $flowData, $createThread);
        } catch (Exception $e) {
            $this->logger->alert($e->getMessage());
            $element = $this->retrievePMSEElement('');
            $status = $e->getCode() == 0 ? 'QUEUE' : 'ERROR';
            $preparedData['cas_flow_status'] = $status;
            $executionData = $element->prepareResponse($preparedData, $status, 'CREATE');
            // If the status is put into error then the Inbox record should be updated as well
            if ($status == 'ERROR') {
                $this->caseFlowHandler->changeCaseStatus($executionData['flow_data']['cas_id'], 'ERROR');
            }
            $routeData = $this->flowRouter->routeFlow($executionData, $flowData, $createThread);
        }

        if ($this->caseFlowHandler->numberOfCasesByStatus($flowData,
                'ERROR') <= 0 && $externalAction == 'RESUME_EXECUTION'
        ) {
            $this->caseFlowHandler->changeCaseStatus($flowData['cas_id'], 'IN PROGRESS');
        }

        if (!empty($routeData['next_elements'])) {
            $createThread = sizeof($routeData['next_elements']) > 1;
            if ($createThread) {
                $startTime = ($this->maxExecutionTimeout - $this->executionTime) / sizeof($routeData['next_elements']);
            }
            foreach ($routeData['next_elements'] as $elementData) {
                //reset execution time if the derivation is in parallel
                $this->executionTime = $createThread ? $startTime : $this->executionTime;
                $this->runEngine($elementData, $createThread, $bean);
            }
        } else {
            // Quick fix to the 0 output printed by some element, 
            // TODO: Don't remove until the fix to the element is commited
            ob_get_clean();
            return true;
        }
        return true;
    }

    /**
     * It processes an element based in the assumption that should be executed
     * Synchronously or Asynchronously
     *
     * @param array $flowData
     * @param type $bean
     * @param type $externalAction
     * @return type
     * @codeCoverageIgnore
     */
    public function processElement($flowData, $bean, $externalAction = '', $arguments = array())
    {
        $startTime = microtime(true);
        $executionResult = array();
        $pmseElement = $this->retrieveElementByType($flowData);

        if (!empty($externalAction) && $externalAction == 'RESUME_EXECUTION') {
            $executionMode = $externalAction;
        } else {
            $executionMode = $pmseElement->getExecutionMode();
        }

        switch ($executionMode) {
            case 'RESUME_EXECUTION':
                $executionResult = $pmseElement->run($flowData, $bean, $externalAction, $arguments);
                $executionResult['flow_action'] = isset($executionResult['flow_action']) ?
                    $executionResult['flow_action'] :
                    'UPDATE';
                $executionResult['flow_id'] = $flowData['id'];
                break;
            case 'ASYNC':
                $flowData['cas_flow_status'] = 'QUEUE';
                $executionResult = $pmseElement->prepareResponse($flowData, 'QUEUE', 'CREATE');
                break;
            case 'SYNC':
            default:
                $executionResult = $pmseElement->run($flowData, $bean, $externalAction, $arguments);
                break;
        }
        $endTime = microtime(true);
        $executionResult['elapsed_time'] = $endTime - $startTime;
        return $executionResult;
    }

    public function retrievePMSEStartTime()
    {
        $result = 0;
        if (isset($_SESSION['pmse_start_time']) && !empty($_SESSION['pmse_start_time'])) {
            $result = $_SESSION['pmse_start_time'];
        }
        return $result;
    }

    public function validateExecutionTime($elementElapsedTime)
    {
        $this->executionTime += $elementElapsedTime;
        $maxExecutionTime = ini_get('max_execution_time');
        if ($maxExecutionTime == 0) {
            $maxExecutionTime = $this->maxExecutionTimeout;
        }
        $remain = $this->executionTime > $maxExecutionTime;
        if ($remain) {
            throw new Exception("Script execution is taking too much time", 0);
        } else {
            return $this->executionTime;
        }
    }

    public function validateNestedLoopCount($flowData)
    {
        // start elements doesn't have id, and they only execute once, so no need to count
        if (!empty($flowData['cas_sugar_object_id'])) {
            $sugar_id = $flowData['cas_sugar_object_id'];
            $element_id = $flowData['bpmn_id'];

            // If the element (activity, flow, etc) is triggered by the record for first time
            // initiate the counter by executedElements[record_id][element_id]
            // else increase the counter
            if (empty($this->executedElements[$sugar_id][$element_id])) {
                $this->executedElements[$sugar_id][$element_id] = 1;
            } else {
                $this->executedElements[$sugar_id][$element_id]++;
            }

            // if count exceed the cycle number throw a exception.
            $count = $this->executedElements[$sugar_id][$element_id];
            $limit = $this->maxExecutionCycleNumber;

            if ($count > $limit) {
                throw new Exception("Nested loops limit of {$limit} reached", 1);
            } else {
                return $count;
            }
        } else {
            return 0;
        }
    }

    public function validateFailSafes($flowData, $executionData)
    {
        $nestedCount = $this->validateNestedLoopCount($flowData);
        $executionTime = $this->validateExecutionTime($executionData['elapsed_time']);
        return array(
            'executionTime' => $executionTime,
            'nestedCount' => $nestedCount
        );
    }

    public function logErrorActivity($flowData, $bean)
    {
        $params = $this->processTags($flowData, $bean);
        $params['module_name'] = 'pmse_Inbox';
        $this->logger->activity('The task &0 of case &1 registered an execution error for the record &2 from module &3.',
            $params);
    }

    public function processTags($params, $bean)
    {
        $result = array();
        $tags = array('task', 'case', 'record', 'module');
        foreach ($tags as $value) {
            switch ($value) {
                case 'task':
                    $result['tags'][] = array(
                        "id" => $params['id'],
                        "name" => $params['bpmn_type'],
                        "module" => "pmse_Inbox"
                    );
                    break;
                case 'case':
                    $result['tags'][] = array(
                        "id" => $params['id'],
                        "name" => $params['cas_id'],
                        "module" => "pmse_Inbox"
                    );
                case 'record':
                    $result['tags'][] = array(
                        "id" => $bean->id,
                        "name" => $bean->name,
                        "module" => $bean->module_name
                    );
                    break;
                case 'module':
                    $result['tags'][] = array(
                        "id" => $bean->id,
                        "name" => $bean->module_name,
                        "module" => $bean->module_name
                    );
                    break;
                default:
                    break;
            }
        }
        return $result;
    }

}
