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

require_once 'modules/pmse_Inbox/engine/PMSEExecuter.php';
require_once 'modules/pmse_Inbox/engine/PMSEHandlers/PMSECaseFlowHandler.php';
require_once 'modules/pmse_Inbox/engine/PMSEEvaluator.php';
require_once 'modules/pmse_Inbox/engine/PMSELogger.php';
require_once 'modules/pmse_Inbox/engine/PMSEPreProcessor/PMSEValidator.php';
require_once 'modules/pmse_Inbox/engine/PMSEPreProcessor/PMSERequest.php';

class PMSEPreProcessor
{
    /**
     *
     * @var type
     */
    private static $instance;

    /**
     *
     * @var type
     */
    private $executer;

    /**
     *
     * @var PMSEValidator
     */
    private $validator;

    /**
     *
     * @var PMSELogger
     */
    protected $logger;

    /**
     *
     * @var type
     */
    protected $caseFlowHandler;

    /**
     *
     * @var type
     */
    protected $evaluator;

    /**
     * Pre Processor constructor method
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        $this->executer = new PMSEExecuter();
        $this->validator = new PMSEValidator();
        $this->caseFlowHandler = new PMSECaseFlowHandler();
        $this->logger = PMSELogger::getInstance();
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new PMSEPreProcessor();
        }
        return self::$instance;
    }

    /**
     *
     * @param type $module
     * @param type $id
     * @codeCoverageIgnore
     */
    public function retrieveBean($module, $id = null)
    {
        return BeanFactory::getBean($module, $id);
    }

    /**
     *
     * @param type $module
     * @param type $id
     * @codeCoverageIgnore
     */
    public function retrieveRequest($module, $id = null)
    {
        return new PMSERequest();
    }

    /**
     *
     * @param type $module
     * @param type $id
     * @codeCoverageIgnore
     */
    public function retrieveSugarQuery()
    {
        return new SugarQuery();
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getExecuter()
    {
        return $this->executer;
    }

    /**
     *
     * @param type $executer
     * @codeCoverageIgnore
     */
    public function setExecuter($executer)
    {
        $this->executer = $executer;
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
     * @param PMSELogger $logger
     * @codeCoverageIgnore
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     *
     * @param PMSEValidate $validator
     * @codeCoverageIgnore
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
    }

    /**
     *
     * @param type $request
     * @param type $createThread
     * @param type $bean
     * @param type $externalAction
     * @return type
     */
    public function processRequest(PMSERequest $request)
    {
        if ($request->getExternalAction() == 'TERMINATE_CASE') {
            $this->terminateCaseByBeanAndProcess($request->getBean());
        } else {
            if (!isset($_SESSION['triggeredFlows'])) {
                $_SESSION['triggeredFlows'] = array();
            }
            $flowDataList = $this->getFlowDataList($request);
            foreach ($flowDataList as $flowData) {
                // Process the flow data and also the bean object data
                $request->setFlowData($this->processFlowData($flowData));
                $request->setBean($this->processBean($request->getBean(), $request->getFlowData()));
                $request->getBean()->load_relationships();
                // is essential that the request should be initialized as valid for the next flow
                $request->validate();
                // validatind the request with the initial Data
                $validatedRequest = $this->validator->validateRequest($request);

                if ($validatedRequest->isValid()) {
                    $data = $validatedRequest->getFlowData();

                    if (!(isset($data['evn_type']) && $data['evn_type'] == 'GLOBAL_TERMINATE')) {
                        if (!PMSEEngineUtils::isTargetModule($flowData, $validatedRequest->getBean())) {
                            $parentBean = PMSEEngineUtils::getParentBean($flowData, $validatedRequest->getBean());
                            // Only when start bean is different of target module in PD
                            // should override original bean
                            $request->setBean($parentBean);
                        }

                        $this->logger->info('Request validated for element: ' . $data['bpmn_type'] . ' with id: ' . $data['bpmn_id']);
                        $_SESSION['pmse_start_time'] = microtime(true);

                        $result = $this->executer->runEngine(
                            $validatedRequest->getFlowData(), $validatedRequest->getCreateThread(),
                            $validatedRequest->getBean(), $validatedRequest->getExternalAction(),
                            $validatedRequest->getArguments()
                        );
                        $this->logger->info('Execution of case: #' . $data['cas_id'] . ' completed');
                    }

                } else {
                    $data = $request->getFlowData();
                    $this->logger->info('Request not validated for element: ' . $data['bpmn_type'] . ' with id: ' . $data['bpmn_id']);
                }

                if ($request->getResult() == 'TERMINATE_CASE') {
                    $this->terminateCaseByBeanAndProcess($request->getBean(), $data);
                }
            }
        }
    }

    public function retrieveCasesByBean($bean)
    {
        $sugarQuery = $this->retrieveSugarQuery();
        $flowBean = $this->retrieveBean('pmse_BpmFlow');
        $fields = array('cas_id', 'cas_index', 'pro_id');
        $sugarQuery->select($fields);
        $sugarQuery->from($flowBean, array('alias' => 'flow'));
        $sugarQuery->joinRaw("INNER JOIN pmse_bpm_process_definition definition ON definition.id = flow.pro_id");
        $sugarQuery->where()->queryAnd()
            ->addRaw("cas_sugar_object_id = '{$bean->id}' AND cas_sugar_module = '{$bean->module_name}' AND cas_flow_status <> 'CLOSED'");
        $sugarQuery->select->fieldRaw('definition.pro_terminate_variables');
        $flows = $sugarQuery->execute();
        $query = $sugarQuery->compileSql();
        return $flows;
    }

    public function retrieveProcessBean($bean, $flowData = array())
    {
        if (!PMSEEngineUtils::isTargetModule($flowData, $bean)) {
            $parentBean = PMSEEngineUtils::getParentBean($flowData, $bean);
        }
        return (!empty($parentBean) && is_object($parentBean)) ? $parentBean: $bean;
    }

    public function terminateCaseByBeanAndProcess($bean, $data = array())
    {
        $processBean = $this->retrieveProcessBean($bean, $data);
        $flows = $this->retrieveCasesByBean($processBean);
        $verifiedProcesses = array();
        foreach ($flows as $flow) {
            if (empty($data) || $flow['pro_id'] == $data['pro_id']) {
                if (!array_key_exists($flow['cas_id'], $verifiedProcesses)) {
                    $verifiedProcesses[$flow['cas_id']] = true;
                }
                if ($verifiedProcesses[$flow['cas_id']]) {
                    $this->caseFlowHandler->terminateCase($flow, $processBean, "TERMINATED");
                    $verifiedProcesses[$flow['cas_id']] = false;
                }
            }
        }
    }

    /**
     * Optimized version of get all events method.
     * @param type $bean
     * @return type
     */
    public function getAllEvents($bean = '')
    {
        $fields = array(
            'evn_id',
            'evn_uid',
            'prj_id',
            'pro_id',
            'evn_type',
            'evn_marker',
            'evn_is_interrupting',
            'evn_attached_to',
            'evn_cancel_activity',
            'evn_activity_ref',
            'evn_wait_for_completion',
            'evn_error_name',
            'evn_error_code',
            'evn_escalation_name',
            'evn_escalation_code',
            'evn_condition',
            'evn_message',
            'evn_operation_name',
            'evn_operation_implementation',
            'evn_time_date',
            'evn_time_cycle',
            'evn_time_duration',
            'evn_behavior',
            'evn_status',
            'evn_type',
            'evn_module',
            'evn_criteria',
            'evn_params',
            'evn_script',
            'rel_process_module',
            'rel_element_relationship',
            'rel_element_module',
            'pro_module',
            'pro_status',
            'pro_locked_variables',
            'pro_terminate_variables',
            'date_entered',
        );

        $relatedDependency = $this->retrieveBean('pmse_BpmRelatedDependency');
        $q = $this->retrieveSugarQuery();
        $q->select($fields);
        $q->from($relatedDependency, array('alias' => 'hp'));
        $q->joinRaw("LEFT JOIN pmse_bpm_flow flow ON rel_element_id = flow.bpmn_id AND (cas_flow_status IS NULL OR cas_flow_status='WAITING')",
            array('alias' => 'flow'));
        $q->where()->queryAnd()
            ->addRaw("(".
                // Where for Start Events
                "(evn_type = 'START' AND evn_module = '$bean->module_name')".
                " OR ".
                // Where for Terminate Process
                "(evn_type = 'GLOBAL_TERMINATE' AND (flow.cas_flow_status IS NULL OR flow.cas_flow_status != 'WAITING') ".
                " AND  rel_element_module='$bean->module_name')".
                " OR ".
                // Where for Receive Message
                "(evn_type = 'INTERMEDIATE'" .
                " AND evn_marker = 'MESSAGE'" .
                " AND evn_behavior = 'CATCH'" .
                " AND flow.cas_flow_status = 'WAITING'" .
                " AND rel_element_module = '$bean->module_name')".
                ") " .
                "AND pro_status != 'INACTIVE' AND (hp.deleted IS NULL OR hp.deleted=0)");

        $q->select->fieldRaw('flow.id, flow.cas_id, flow.cas_index, flow.bpmn_id, flow.bpmn_type, flow.cas_user_id, flow.cas_thread, flow.cas_sugar_module, flow.cas_sugar_object_id');
        $query = $q->compileSql();
        $start = microtime(true);
        $rows = $q->execute();
        $time = (microtime(true) - $start) * 1000;
        $this->logger->debug('Query in order to retrieve all valid start and receive message events: ' . $query . ' \n in ' . $time . ' milliseconds');
        return $rows;
    }

    /**
     *
     * @param type $data
     * @return type
     * @codeCoverageIgnore
     */
    public function getFlowById($id)
    {
        $flow = $this->retrieveBean('pmse_BpmFlow', $id);
        return array($flow->toArray());
    }

    /**
     *
     * @param type $data
     * @return type
     */
    public function getFlowsByCasId($casId)
    {
        $flow = $this->retrieveBean('pmse_BpmFlow');
        $q = $this->retrieveSugarQuery();
        $fields = array(
            'id',
            'deleted',
            'assigned_user_id',
            'cas_id',
            'cas_index',
            'pro_id',
            'pcas_previous',
            'cas_reassign_level',
            'bpmn_id',
            'bpmn_type',
            'cas_user_id',
            'cas_thread',
            'cas_flow_status',
            'cas_sugar_module',
            'cas_sugar_object_id',
            'cas_sugar_action',
            'cas_adhoc_type',
            'cas_task_start_date',
            'cas_delegate_date',
            'cas_start_date',
            'cas_finish_date',
            'cas_due_date',
            'cas_queue_duration',
            'cas_duration',
            'cas_delay_duration',
            'cas_started',
            'cas_finished',
            'cas_delayed'
        );
        $q->select($fields);
        $q->from($flow);
        $q->where()->queryAnd()->addRaw("pmse_bpm_flow.cas_id=$casId AND pmse_bpm_flow.cas_flow_status='ERROR'");
        $query = $q->compileSql();
        $start = microtime(true);
        $result = $q->execute();
        $time = (microtime(true) - $start) * 1000;
        $this->logger->debug('Query in order to retrieve all valid start and receive message events: ' . $query . ' \n in ' . $time . ' milliseconds');
        return $result;
    }

    /**
     *
     * @param PMSERequest $request
     * @return type
     */
    public function getFlowDataList(PMSERequest $request)
    {
        $args = $request->getArguments();
        $flows = array();
        switch ($request->getType()) {
            case 'direct':
                switch (true) {
                    case isset($args['idFlow']):
                        $flows = $this->getFlowById($args['idFlow']);
                        break;
                    case isset($args['flow_id']):
                        $flows = $this->getFlowById($args['flow_id']);
                        break;
                    case (isset($args['cas_id'])&&isset($args['cas_index'])):
                        $flows = $this->getFlowByCasIdCasIndex($args);
                        $args['idFlow'] = $flows[0]['id'];
                        $request->setArguments($args);
                        break;
                }
                
                break;
            case 'hook':
                $flows = $this->getAllEvents($request->getBean());
                break;
            case 'queue':
                $flows = $this->getFlowById($args['id']);
                break;
            case 'engine':
                $flows = $this->getFlowsByCasId($args['cas_id']);
                break;
        }

//      Sort flows
        usort($flows, function ($a, $b) {
            $valueA = $a["evn_params"] == 'new' ? 1 : ($a["evn_params"] == 'updated' ? 2 : 3);
            $valueB = $b["evn_params"] == 'new' ? 1 : ($b["evn_params"] == 'updated' ? 2 : 3);
            if ($valueA == $valueB) {
                if (!empty($a["date_entered"]) && !empty($b["date_entered"])) {
                    $timedate = TimeDate::getInstance();
                    $date_a = $timedate->fromString($a["date_entered"]);
                    $date_b = $timedate->fromString($b["date_entered"]);
                    if ($date_a < $date_b) {
                        return -1;
                    } else if ($date_a > $date_b) {
                        return 1;
                    }
                }
                return 0;
            }
            if ($valueA < $valueB) {
                return -1;
            } else {
                return 1;
            }
        });

        return $flows;
    }

    public function getFlowByCasIdCasIndex($arguments)
    {
        $tmpBean = BeanFactory::getBean('pmse_BpmFlow');
        $q = new SugarQuery();
        $q->select(array('cas_sugar_module', 'cas_sugar_object_id', 'id'));
        $q->from($tmpBean);
        $q->where()->equals('cas_id', $arguments['cas_id']);
        $q->where()->equals('cas_index', $arguments['cas_index']);
        $result = $q->execute();
        $element = array_pop($result);
        $bean = BeanFactory::retrieveBean('pmse_BpmFlow', $element['id']);
        return array($bean->toArray());
    }
    
    /**
     *
     * @param type $flowData
     * @return type
     * @codeCoverageIgnore
     */
    public function processFlowData($flowData)
    {
        //TODO: Find a better and more generalistic approach
        $flowData['bpmn_id'] = (!isset($flowData['bpmn_id'])) ? $flowData['evn_id'] : $flowData['bpmn_id'];
        $flowData['bpmn_type'] = (!isset($flowData['bpmn_type'])) ? 'bpmnEvent' : $flowData['bpmn_type'];
        return $flowData;
    }

    /**
     *
     * @param type $bean
     * @param type $flowData
     * @return type
     * @codeCoverageIgnore
     */
    public function processBean($bean, $flowData)
    {
        if (is_null($bean)) {
            if (isset($flowData['cas_sugar_module']) && isset($flowData['cas_sugar_object_id'])) {
                $bean = BeanFactory::getBean($flowData['cas_sugar_module'], $flowData['cas_sugar_object_id']);
            }
            if (isset($flowData['cas_id']) && isset($flowData['cas_index'])) {
                
            }
        }
        return $bean;
    }

}
