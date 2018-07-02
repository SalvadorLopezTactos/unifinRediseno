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

class PMSEDirectRequestHandler
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
     * Class Constructor
     */
    public function __construct()
    {
        $this->request = new PMSERequest();
        $this->logger = PMSELogger::getInstance();
        $this->request->setType('direct');
        $this->preProcessor = PMSEPreProcessor::getInstance();
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
        $this->logger->info('Processing a direct request.');
        $this->logger->debug('Direct request params: ' . print_r($args));
        $this->request->setCreateThread($createThread);
        $this->request->setExternalAction($externalAction);
        $this->request->setBean($bean);
        $this->request->setArguments($args);
        $preProcessor = $this->preProcessor->getInstance();
        $response = $preProcessor->processRequest($this->request);
        return $response;
    }

}
