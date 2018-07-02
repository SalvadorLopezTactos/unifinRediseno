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

require_once 'modules/pmse_Inbox/engine/PMSEPreProcessor/PMSEValidate.php';
require_once 'modules/pmse_Inbox/engine/PMSELogger.php';

/**
 * Description of PMSEElementValidator
 *
 */
class PMSEElementValidator implements PMSEValidate
{

    /**
     *
     * @var type
     */
    protected $dbHandler;

    /**
     * @var
     */
    protected $sugarQueryObject;

    /**
     * @var
     */
    protected $beanFlow;

    /**
     *
     * @var type
     */
    protected $logger;

    /**
     *
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->sugarQueryObject = new SugarQuery();
        $this->beanFlow = BeanFactory::getBean('pmse_BpmFlow');
        $this->logger = PMSELogger::getInstance();
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getDbHandler()
    {
        return $this->dbHandler;
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
     * @return SugarQuery
     */
    public function getSugarQueryObject()
    {
        return $this->sugarQueryObject;
    }

    /**
     * @return null|SugarBean
     */
    public function getBeanFlow()
    {
        return $this->beanFlow;
    }

    /**
     *
     * @param type $dbHandler
     * @codeCoverageIgnore
     */
    public function setDbHandler($dbHandler)
    {
        $this->dbHandler = $dbHandler;
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

    public function setBeanFlow($beanFlow)
    {
        $this->beanFlow = $beanFlow;
    }

    /**
     * @param $sugarQueryObject
     */
    public function setSugarQueryObject($sugarQueryObject)
    {
        $this->sugarQueryObject = $sugarQueryObject;
    }

    /**
     *
     * @param PMSERequest $request
     * @param type $flowData
     * @return PMSERequest
     */
    public function validateRequest(PMSERequest $request)
    {
        $this->logger->info("Validate Request " . get_class($this));
        $this->logger->debug(array("Request data:", $request));

        $flowData = $request->getFlowData();
        $bean = $request->getBean();
        $request->setExternalAction($this->processExternalAction($flowData));
        $request->setCreateThread($this->processCreateThread($flowData));

        //Evaluate parent bean
        if (!PMSEEngineUtils::isTargetModule($flowData, $bean)) {
            $parentBean = PMSEEngineUtils::getParentBean($flowData, $bean);
            if (empty($parentBean) || !is_object($parentBean)) {
                $request->invalidate();
                return $request;
            }
        }

        switch ($flowData['evn_type']) {
            case 'START':
                $this->logger->info("Validate Start Event.");
                $this->validateStartEvent($bean, $flowData, $request);
                break;
            case 'INTERMEDIATE':
                $this->logger->info("Validate Intermediate Event.");
                $this->validateIntermediateEvent($bean, $flowData, $request);
                break;
            default:
                break;
        }
        return $request;
    }

    /**
     *
     * @param type $flowData
     * @return string
     */
    public function identifyElementStatus($flowData)
    {
        $result = '';
        if (isset($flowData['cas_id']) && isset($flowData['cas_index'])) {
            $result = 'RUNNING';
        } else {
            $result = 'NEW';
        }
        return $result;
    }

    /**
     * @param $flowData
     * @return string
     */
    public function identifyEventAction($flowData)
    {
        $str = 'EVALUATE_%s_MODULE';
        $type = PMSEEngineUtils::isTargetModuleNotProcessModule($flowData) ? 'RELATED' : 'MAIN';
        return sprintf($str, $type);
    }

    /**
     *
     * @param type $flowData
     * @return boolean
     */
    public function processExternalAction($flowData)
    {
        if ($this->identifyElementStatus($flowData) == 'RUNNING' && $flowData['evn_type'] == 'INTERMEDIATE') {
            return $this->identifyEventAction($flowData);
        } else {
            return $this->identifyElementStatus($flowData);
        }
    }

    /**
     *
     * @param type $flowData
     * @return boolean
     */
    public function processCreateThread($flowData)
    {
        if ($this->identifyElementStatus($flowData) == 'NEW') {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @param type $bean
     * @return type
     * @codeCoverageIgnore
     */
    public function isNewRecord($bean)
    {
        return empty($bean->fetched_row['id']);
    }

    /**
     *
     * @param type $bean
     * @param type $flowData
     * @return boolean
     */
    public function isCaseDuplicated($bean, $flowData, $processFinished = false)
    {
        $beanFlow = $this->getBeanFlow();
        $fields = array(
            'pro_id',
        );
        $q = $this->getSugarQueryObject();
        $q->from($beanFlow, array('add_deleted' => true));
        $q->distinct(true);
        $q->where()
            ->equals('cas_sugar_object_id', $bean->id)
            ->equals('cas_sugar_module', $bean->module_name)
            ->equals('pro_id', $flowData['pro_id']);

        if ($processFinished) {
            $q->where()
                ->notIn('cas_flow_status', array('CLOSED', 'TERMINATED'));
        } else {
            $q->where()
                ->equals('cas_index', 1);
        }

        $q->select($fields);

        $rows = $q->execute();

        if (!empty($rows)) {
            if (!$processFinished) {
                $this->logger->debug("Start Event {$bean->id} already exists");
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if the user updated the bean from PMSE_Inbox
     *
     * @param type $bean
     * @return boolean
     */
    public function isPMSEEdit($bean)
    {
        if (isset($_REQUEST['moduleName']) && isModuleBWC($_REQUEST['moduleName'])) {
            $url = $_REQUEST['module'];
        } else {
            // In most cases __sugar_url will be set, but if it isn't, handle it
            $url = isset($_REQUEST['__sugar_url']) ? $_REQUEST['__sugar_url'] : '';
        }

        if (strpos($url, 'pmse') === false) {
            return false;
        } else {
            $this->logger->debug("Start Event {$bean->id} can not be triggered by PMSE modules.");
            return true;
        }
    }

    /**
     * @deprecated
     * @param type $bean
     * @return boolean
     */
    public function already_triggered($bean, $flowData)
    {
        //Validate if start event was already processed
        foreach ($_SESSION['triggeredFlows'] as $flow) {
            if ($flowData['pro_id'] == $flow['pro_id'] && $bean->id == $flow['bean']->id) {
                $this->logger->debug("Start Event {$bean->id} was already triggered in after save hook.");
                return true;
            }
        }
        $triggeredFlow = array();
        $triggeredFlow['pro_id'] = $flowData['pro_id'];
        $triggeredFlow['bean'] = $bean;
        $_SESSION['triggeredFlows'][] = $triggeredFlow;
        return false;
    }

    /**
     *
     * @param type $bean
     * @param type $flowData
     * @return boolean
     */
    public function validateStartEvent($bean, $flowData, $request)
    {
        if (!$this->isPMSEEdit($bean)) {
            $isNewRecord = $this->isNewRecord($bean);
            switch ($flowData['evn_params']) {
                case 'new':
                    if ($isNewRecord && !$this->isCaseDuplicated($bean, $flowData)) {
                        $request->validate();
                    } else {
                        $request->invalidate();
                    }
                    break;
                case 'updated':
                    if (!$isNewRecord && !$this->isCaseDuplicated($bean, $flowData)) {
                        $request->validate();
                    } else {
                        $request->invalidate();
                    }
                    break;
                case 'allupdates':
                    if (!$isNewRecord && !$this->isCaseDuplicated($bean, $flowData, true)) {
                        $request->validate();
                    } else {
                        $request->invalidate();
                    }
                    break;
                default:
                    $request->invalidate();
                    break;
            }
        } else {
            $request->invalidate();
        }
    }

    /**
     *
     * @param type $bean
     * @param type $flowData
     * @param type $request
     * @return type
     * @codeCoverageIgnore
     */
    public function validateIntermediateEvent($bean, $flowData, $request)
    {
        $request->validate();
        return $request;
    }

}
