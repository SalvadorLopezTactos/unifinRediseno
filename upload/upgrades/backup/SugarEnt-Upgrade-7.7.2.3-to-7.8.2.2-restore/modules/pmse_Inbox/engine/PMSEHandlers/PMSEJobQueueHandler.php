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

require_once 'modules/pmse_Inbox/engine/PMSEPreProcessor/PMSEPreProcessor.php';
require_once 'modules/pmse_Inbox/engine/PMSEPreProcessor/PMSERequest.php';
require_once 'modules/pmse_Inbox/engine/PMSELogger.php';

/**
 * Description of PMSEJobQueue
 * The PMSEJobQueue class creates and assign a queued job that executes a BPM
 * element such as a gateway, activity or event.
 *
 */
class PMSEJobQueueHandler
{

    /**
     * @var SchedulersJob this attribute stores an instance of the SchedulersJob class
     */
    protected $schedulersJob;

    /**
     * @var SugarJobQueue this attribute stores an instance of the SchedulersJob class
     */
    protected $sugarJobQueue;

    /**
     * @var User this attribute stores an instance of the User class,
     * especificcally the current logged user that executes the process
     */
    protected $currentUser;

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
     * @var type
     */
    protected $logger;

    /**
     * Class Constructor
     * @global type $current_user
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        global $current_user;
        $this->schedulersJob = new SchedulersJob();
        $this->sugarJobQueue = new SugarJobQueue();
        $this->logger = PMSELogger::getInstance();
        $this->currentUser = $current_user;
    }

    /**
     * Retrieve the Scheduler Job attribute
     * @return type
     * @codeCoverageIgnore
     */
    public function getSchedulersJob()
    {
        return $this->schedulersJob;
    }

    /**
     * Retrieve the Sugar Job Queue attribute
     * @return type
     * @codeCoverageIgnore
     */
    public function getSugarJobQueue()
    {
        return $this->sugarJobQueue;
    }

    /**
     * Set the Scheduler Job attribute
     * @param type $schedulersJob
     * @codeCoverageIgnore
     */
    public function setSchedulersJob($schedulersJob)
    {
        $this->schedulersJob = $schedulersJob;
    }

    /**
     * Set the Sugar Job Queue attribute.
     * @param type $sugarJobQueue
     * @codeCoverageIgnore
     */
    public function setSugarJobQueue($sugarJobQueue)
    {
        $this->sugarJobQueue = $sugarJobQueue;
    }

    /**
     * Get Current User attribute
     * @return type
     * @codeCoverageIgnore
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    /**
     * Set the current User attribute
     * @param type $currentUser
     * @codeCoverageIgnore
     */
    public function setCurrentUser($currentUser)
    {
        $this->currentUser = $currentUser;
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getPreProcessor()
    {
        return $this->preProcessor;
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
     * @param type $logger
     * @codeCoverageIgnore
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     *
     * @param type $request
     * @codeCoverageIgnore
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     *
     * @param type $preProcessor
     * @codeCoverageIgnore
     */
    public function setPreProcessor($preProcessor)
    {
        $this->preProcessor = $preProcessor;
    }


    /**
     * Prepare Pre-Processor
     * Cannot be tested since the PMSEPreProcessor uses an static method call
     * @codeCoverageIgnore
     */
    public function preparePreProcessor()
    {
        // preprocessor required initialization
        $this->request = new PMSERequest();
        $this->request->setType('queue');
        $this->preProcessor = PMSEPreProcessor::getInstance();
    }


    /**
     * Submit a Job top the Sugar job queue handler
     * @param type $params
     * @return type
     */
    public function submitPMSEJob($params)
    {
        // logger calls
        $this->logger->info('Submit PMSE job.');
        $this->logger->debug('PMSE Job parameters: ' . print_r($params, true));

        $this->schedulersJob->name = "PMSE Job - {$params->id}";
        //data we are passing to the job
        $this->schedulersJob->data = json_encode($this->filterData($params->data));
        //function to call
        $this->schedulersJob->target = "function::PMSEJobRun";
        $this->schedulersJob->message = "Executing a PMSE queued task.";
        //set the user the job runs as
        $this->schedulersJob->assigned_user_id = $this->currentUser->id;
        //push into the queue to run
        $jobId = $this->sugarJobQueue->submitJob($this->schedulersJob);
        //log the job id
        $this->logger->info('PMSE Job created with id: ' . $jobId);
        return $jobId;
    }

    public function executeRequest($args = array(), $createThread = false, $bean = null, $externalAction = '')
    {
        $this->logger->info('Processing a direct request.');
        $this->logger->debug('Direct request params: ' . print_r($args, true));

        $this->preparePreProcessor();
        $this->request->setCreateThread($createThread);
        $this->request->setExternalAction($externalAction);
        $this->request->setBean($bean);
        $this->request->setArguments($args);

        $response = $this->preProcessor->processRequest($this->request);
        return $response;
    }

    public function filterData($dataArray)
    {
        $this->logger->debug('Pre-Filtered Data: ' . print_r($dataArray, true));

        $validFields = array(
            'evn_criteria',
            'rel_element_module',
            'rel_element_relationship',
            'rel_process_module',
            'new_with_id',
            'cas_delayed',
            'cas_finished',
            'cas_started',
            'cas_delay_duration',
            'cas_duration',
            'cas_queue_duration',
            'cas_due_date',
            'cas_finish_date',
            'cas_start_date',
            'cas_delegate_date',
            'cas_sugar_action',
            'cas_sugar_object_id',
            'cas_sugar_module',
            'cas_flow_status',
            'cas_thread',
            'cas_user_id',
            'bpmn_type',
            'bpmn_id',
            'pro_id',
            'cas_id',
            'cas_index',
            'id'
        );

        foreach ($dataArray as $key => $value) {
            if (!in_array($key, $validFields)) {
                unset($dataArray[$key]);
            }
        }

        $this->logger->debug('Filtered Data: ' . print_r($dataArray, true));
        return $dataArray;
    }
}
