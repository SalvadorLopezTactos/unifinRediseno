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

require_once 'include/SugarQuery/SugarQuery.php';
require_once 'modules/pmse_Inbox/engine/PMSEPreProcessor/PMSEPreProcessor.php';
require_once 'modules/pmse_Inbox/engine/PMSEPreProcessor/PMSERequest.php';
require_once 'modules/pmse_Inbox/engine/PMSELogger.php';

class PMSEHookHandler
{
    /**
     *
     * @var type
     */
    protected $request;

    /**
     *
     * @var type
     */
    protected $preProcessor;

    /**
     *
     * @var PMSELogger
     */
    protected $logger;

    /**
     *
     * @var type
     */
    protected $dbHandler;

    /**
     *
     */
    public function __construct()
    {
        global $db;
        $this->request = new PMSERequest();
        $this->request->setType('hook');
        $this->preProcessor = PMSEPreProcessor::getInstance();
        $this->logger = PMSELogger::getInstance();
        $this->dbHandler = $db;
    }

    /**
     *
     * @param type $element
     * @param type $createThread
     * @param type $bean
     * @param type $externalAction
     * @param type $args
     * @return type
     */
    public function executeRequest($args = array(), $createThread = false, $bean = null, $externalAction = '')
    {
        $this->logger->info('Processing a hook request.');
        $this->logger->debug('Hook request params: ' . print_r($args, true));
        $this->request->setCreateThread($createThread);
        $this->request->setExternalAction($externalAction);
        $this->request->setBean($bean);
        $this->request->setArguments($args);

        $preProcessor = $this->preProcessor->getInstance();
        $response = $preProcessor->processRequest($this->request);
        return $response;
    }

    /**
     * @param $bean
     * @param bool|true $isNewRecord
     * @return bool
     */
    public function runStartEventBeforeSave($bean, $event, $arguments, $startEvents, $isNewRecord = true)
    {
        if (isset($bean->isPASaveRequest) && $bean->isPASaveRequest === true) {
            $this->logger->info('Skipping locked fields checking because it\'s a PA Request');
        } else if ($isNewRecord) {
            $this->logger->info('Skipping locked fields checking because it\'s a new record');
        } else {
            $this->logger->info("Executing locked fields checking for bean module {$bean->module_name}");
            $originalValues = $bean->fetched_row;
            //Check if the record's module have active PD's
            $q = new SugarQuery();
            $q->select(array('id', 'pro_locked_variables'));
            $q->from(BeanFactory::newBean('pmse_BpmProcessDefinition'), array('add_deleted' => true));
            $q->where()
                ->equals('pro_module', $bean->module_dir)
                ->equals('pro_status', 'ACTIVE')
                ->isNotEmpty('pro_locked_variables');
            $proDefs = $q->execute();
            if (!empty($proDefs)) {
                //Check if module have locked fields defined
                foreach($proDefs as $processDefinition) {
                    $locked_fields = array();
                    if (trim($processDefinition['pro_locked_variables']) !== '') {
                        $locked_fields = json_decode(trim(htmlspecialchars_decode($processDefinition['pro_locked_variables'])));
                    }
                    if (!empty($locked_fields)) {
                        // Verify if the record is involved on a process
                        $q = new SugarQuery();
                        $q->select(array('cas_index'));
                        $q->from(BeanFactory::newBean('pmse_BpmFlow'));
                        $q->where()
                            ->equals('cas_sugar_object_id',$bean->id)
                            ->equals('cas_sugar_module',$bean->module_dir)
                            ->equals('cas_index',1)
                            ->equals('pro_id', $processDefinition['id']);
                        $flows = $q->execute();
                        if (!empty($flows)) { // Record associated with one or more processes
                            $blocked_fields = array();
                            foreach ($locked_fields as $field) {
                                //Check if field is part of the current module
                                if (isset($bean->{$field}) && array_key_exists($field, $originalValues)) {
                                    if ($bean->{$field} != $originalValues[$field]) {
                                        $blocked_fields[] = $field;
                                        // Returning to original value before to save
                                        $bean->{$field} = $originalValues[$field];
                                        $this->logger->debug("Cannot update Field '$field' with value '{$bean->{$field}}' because is locked for a PD");
                                    }
                                } else {
                                    $this->logger->warning("Cannot evaluate field '$field' because is not part of the current module: ". $bean->module_name);
                                }
                            }
                            if (!empty($blocked_fields)) {
                                // TODO: Here should be implemented a way to push to UI that some fields ($blocked_fields) there was not updated
                            }
                        } else {
                            $this->logger->info('Record skipped because is not related to any process');
                        }
                    } else {
                        $this->logger->info('Record skipped because there\'s not locked fields defined for this module');
                    }
                }
            } else {
                $this->logger->info('Record skipped because there\'s not active PD\'s for record\'s module: '. $bean->module);
            }
        }
        return true;
    }

    /**
     *
     * @global type $db
     * @global type $redirectBeforeSave
     * @param type $bean
     * @param type $event
     * @param type $arguments
     * @param type $startEvents
     * @param type $isNewRecord
     * @return boolean
     */
    public function runStartEventAfterSave($bean, $event, $arguments)
    {
        $this->logger->info("Executing Before save for bean module {$bean->module_name}, with id {$bean->id}");
        $this->executeRequest($arguments, false, $bean, '');
    }


    public function terminateCaseAfterDelete($bean, $event, $arguments)
    {
        $this->logger->info("Executing Terminate Case for a deleted bean module {$bean->module_name}, with id {$bean->id}");
        $this->executeRequest($arguments, false, $bean, 'TERMINATE_CASE');
    }

    /**
     * Execute the cron tasks.
     */
    public function executeCron()
    {
        $this->logger->info("Executing PMSE scheduled tasks");
        $this->wakeUpSleepingFlows();
    }

    /**
     * Execute all the flows marked as SLEEPING
     */
    private function wakeUpSleepingFlows()
    {
        $this->logger->info("Checking flows with status sleeping");
        $today = TimeDate::getInstance()->nowDb();

        //get all records with status = sleeping
        $flowBean = BeanFactory::getBean('pmse_BpmFlow');//new BpmFlow();

        //$flows = $flowBean->getSelectRows('', "bpmn_type = 'bpmnEvent' and cas_flow_status = 'SLEEPING' and cas_due_date <= '$today' ");
        $flows = $flowBean->get_full_list(
            '',
            "bpmn_type = 'bpmnEvent' and cas_flow_status = 'SLEEPING' and cas_due_date <= '$today' "
        );
        $n = 0;
        foreach ($flows as $flow) {
            $this->newFollowFlow($flow->fetched_row, false, null, 'WAKE_UP');
            $n++;
        }
        if ($n == 0) {
            $this->logger->info("No flows processed with status sleeping");
        } else {
            $this->logger->info("Processed $n flows with status sleeping");
        }
    }

    public function newFollowFlow($flowData, $createThread = false, $bean = null, $externalAction = '')
    {
        require_once 'modules/pmse_Inbox/engine/PMSEExecuter.php';
        $fr = new PMSEExecuter();
        return $fr->runEngine($flowData, $createThread, $bean, $externalAction);
    }
}
