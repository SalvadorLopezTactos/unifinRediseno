<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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

require_once 'modules/pmse_Inbox/engine/PMSELogger.php';

use Sugarcrm\Sugarcrm\ProcessManager;
use Sugarcrm\Sugarcrm\ProcessManager\Registry;

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
        $this->executer = ProcessManager\Factory::getPMSEObject('PMSEExecuter');
        $this->validator = ProcessManager\Factory::getPMSEObject('PMSEValidator');
        $this->caseFlowHandler = ProcessManager\Factory::getPMSEObject('PMSECaseFlowHandler');
        $this->logger = PMSELogger::getInstance();
    }

    /**
     *
     * @return PMSEPreProcessor
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
     * @param string $module
     * @param string $id
     * @codeCoverageIgnore
     * @return null|SugarBean
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
        return ProcessManager\Factory::getPMSEObject('PMSERequest');
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
     * Processes a request
     * @param PMSERequest $request
     * @return boolean
     */
    public function processRequest(PMSERequest $request)
    {
        // Default the return
        $result = true;

        // Handle terminations first
        if ($request->getExternalAction() == 'TERMINATE_CASE') {
            $result = $this->terminateCaseByBeanAndProcess($request->getBean());
        } else {
            // Now handle actual processing of the request
            $flowDataList = $this->getFlowDataList($request);

            // Set the start time, outside of the loop since that is where it belongs
            Registry\Registry::getInstance()->set('pmse_start_time', microtime(true));

            // Loop the flowdata list and handle the actions necessary
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

                        // Set the engine runner arguments
                        $exFlowData = $validatedRequest->getFlowData();
                        $exCreateThread = $validatedRequest->getCreateThread();
                        $exBean = $validatedRequest->getBean();
                        $exExternalAction = $validatedRequest->getExternalAction();
                        $exArguments = $validatedRequest->getArguments();

                        // Run the executer and capture the result
                        $res = $this->executer->runEngine(
                            $exFlowData,
                            $exCreateThread,
                            $exBean,
                            $exExternalAction,
                            $exArguments
                        );

                        // Stack the results for use later
                        $result = $result && $res;
                    }
                } else {
                    // We need this for the log message
                    $data = $request->getFlowData();

                    // Parse a log message
                    $msg = sprintf(
                        'Request not validated for element %s with id %s',
                        $data['bpmn_type'],
                        $data['bpmn_id']
                    );

                    // Log it
                    $this->logger->info($msg);

                    // Set the return value
                    $result = false;
                }

                if ($request->getResult() == 'TERMINATE_CASE') {
                    $result = $this->terminateCaseByBeanAndProcess($request->getBean(), $data);
                }
            }
        }

        return $result;
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

    /**
     * Terminates a case by bean and process id
     * @param SugarBean $bean
     * @param array $data Flow data
     * @return boolean
     */
    public function terminateCaseByBeanAndProcess(SugarBean $bean, array $data = array())
    {
        // Gets the target module bean or the its parent
        $processBean = $this->retrieveProcessBean($bean, $data);

        // Gets flow data for a given record
        $flows = $this->retrieveCasesByBean($processBean);

        // Needed for checking inside the loop, but doesn't need to be check for
        // each iteration
        $isEmpty = empty($data);

        // Stack holder for what has been terminated already
        $needsTerm = array();

        // Loop and check
        foreach ($flows as $flow) {
            if ($isEmpty || $flow['pro_id'] == $data['pro_id']) {
                // If we haven't terminated this one yet, mark it as needed
                if (!isset($needsTerm[$flow['cas_id']])) {
                    $needsTerm[$flow['cas_id']] = true;
                }

                // If this case id needs to be terminated, terminate it
                if ($needsTerm[$flow['cas_id']]) {
                    $this->caseFlowHandler->terminateCase($flow, $processBean, 'TERMINATED');

                    // Then mark it as not needing check
                    $needsTerm[$flow['cas_id']] = false;
                }
            }
        }

        // This isn't exactly accurate, but its better than returning nothing.
        return true;
    }

    /**
     * Optimized version of get all events method.
     * @param SugarBean $bean
     * @return array
     */
    public function getAllEvents(SugarBean $bean)
    {
        $db = DBManagerFactory::getInstance();
        $dependencies = $this->getModuleRelatedDependencies($bean->getModuleName());

        $relElementIds = array_reduce($dependencies, function ($carry, $item) use ($db) {
            $carry[] = $db->quoted($item['rel_element_id']);
            return $carry;
        }, []);

        $flowFields = ['id', 'cas_id', 'cas_index', 'bpmn_id', 'bpmn_type', 'cas_user_id',
            'cas_thread', 'cas_sugar_module', 'cas_sugar_object_id', 'cas_flow_status'];

        $flows = [];
        if ($relElementIds) {
            $result = $db->query("SELECT " . implode(',', $flowFields) . "
                FROM pmse_bpm_flow
                WHERE bpmn_id IN (" . implode(',', $relElementIds) . ")
                    AND (cas_flow_status IS NULL OR cas_flow_status='WAITING')");

            while ($row = $db->fetchByAssoc($result)) {
                $flows[] = $row;
            }
        }

        $events = [];
        foreach ($dependencies as $dependency) {
            $relatedFlows = array_filter($flows, function ($flow) use ($dependency) {
                return $flow['bpmn_id'] == $dependency['rel_element_id'];
            });

            if (!$relatedFlows) {
                $relatedFlows = [array_combine($flowFields, array_pad([], count($flowFields), null))];
            }

            foreach ($relatedFlows as $relatedFlow) {
                if ($dependency['evn_type'] == 'START'
                    || $dependency['evn_type'] == 'GLOBAL_TERMINATE' && !$relatedFlow['cas_flow_status']
                    || $dependency['evn_type'] == 'INTERMEDIATE' && $relatedFlow['cas_flow_status'] == 'WAITING'
                ) {
                    $events[] = array_merge($dependency, $relatedFlow);
                }
            }
        }

        return $events;
    }

    /**
     * Get module related dependencies
     *
     * @param $module
     * @return array
     */
    protected function getModuleRelatedDependencies($module)
    {
        $key = BeanFactory::getBean('pmse_BpmRelatedDependency')->getModuleRelatedDependenciesCacheKey($module);
        if (!isset(SugarCache::instance()->$key)) {
            $db = DBManagerFactory::getInstance();
            $result = $db->query("SELECT *
                FROM pmse_bpm_related_dependency
                WHERE deleted = 0
                    AND pro_status != 'INACTIVE'
                    AND(
                        evn_type = 'START' AND evn_module = '$module'
                        OR evn_type = 'GLOBAL_TERMINATE' AND rel_element_module = '$module'
                        OR evn_type = 'INTERMEDIATE'
                            AND evn_marker = 'MESSAGE'
                            AND evn_behavior = 'CATCH'
                            AND rel_element_module = '$module'
                    )
            ");

            $dependencies = array();
            while ($row = $db->fetchByAssoc($result)) {
                $dependencies[] = $row;
            }

            SugarCache::instance()->$key = $dependencies;
        }

        return SugarCache::instance()->$key;
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
     * @return array
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
