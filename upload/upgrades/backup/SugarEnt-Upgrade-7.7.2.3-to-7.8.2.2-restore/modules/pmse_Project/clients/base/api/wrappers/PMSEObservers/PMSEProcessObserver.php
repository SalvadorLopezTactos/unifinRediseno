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

require_once 'modules/pmse_Project/clients/base/api/wrappers/PMSEObservers/PMSEObserver.php';
require_once 'include/SugarQuery/SugarQuery.php';
require_once 'modules/pmse_Inbox/engine/PMSELogger.php';
require_once 'modules/pmse_Project/clients/base/api/wrappers/PMSERelatedDependencyWrapper.php';

/**
 * Description of PMSEProcessObserver
 *
 */
class PMSEProcessObserver implements PMSEObserver
{

    /**
     *
     * @var type
     */
    protected $sugarQuery;

    /**
     *
     * @var PMSELogger
     */
    protected $logger;

    /**
     *
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->sugarQuery = new SugarQuery();
        $this->logger = PMSELogger::getInstance();
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getSugarQuery()
    {
        return $this->sugarQuery;
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
     * @param type $sugarQuery
     * @codeCoverageIgnore
     */
    public function setSugarQuery($sugarQuery)
    {
        $this->sugarQuery = $sugarQuery;
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
     * @param type $id
     * @return type
     * @codeCoverageIgnore
     */
    public function getRelatedDependencyBean($id = null)
    {
        return BeanFactory::getBean('pmse_BpmRelatedDependency', $id);
    }

    /**
     *
     * @param PMSEObservable $subject
     * @return type
     */
    public function update($subject)
    {
        if (method_exists($subject, 'getProcessDefinition')) {
            $this->logger->debug("Trigger update of a Related Relationship for a Process Definitions update");

            $processDefinition = $subject->getProcessDefinition();
            $processDefinitionData = $processDefinition->fetched_row;

            $fields = array(
                'id',
                'rel_element_type',
            );

            $relatedDependency = $this->getRelatedDependencyBean();

            $this->sugarQuery->select($fields);
            $this->sugarQuery->from($relatedDependency);
            $this->sugarQuery->where()->queryAnd()
                ->addRaw("pro_id='{$processDefinitionData['id']}' AND prj_id='{$processDefinitionData['prj_id']}' AND deleted=0");

            $result = $this->sugarQuery->compileSql();
            $this->logger->debug("Retrieve dependencies query: {$result}");

            $rows = $this->sugarQuery->execute();
            foreach ($rows as $row) {
                $bean = $this->getRelatedDependencyBean($row['id']);
                $bean->pro_status = $processDefinitionData['pro_status'];
                $bean->pro_locked_variables = $processDefinitionData['pro_locked_variables'];
                $bean->pro_terminate_variables = $processDefinitionData['pro_terminate_variables'];
                if ($bean->pro_module !== $processDefinitionData['pro_module'] && $row['rel_element_type'] == 'TERMINATE') {
                    $bean->deleted = true;
                }
                $bean->save();
            }

            $this->processRelatedDependencies($processDefinitionData);
            $depNumber = count($rows);
            $this->logger->debug("Updating {$depNumber} dependencies");
        }
        return $result;
    }
    
    /**
     * 
     * @param type $processDefinitionData
     */
    public function processRelatedDependencies($processDefinitionData)
    {
        $fakeEventData = array(
            'id' => 'TERMINATE',
            'evn_type' => 'GLOBAL_TERMINATE',
            'evn_criteria' => $processDefinitionData['pro_terminate_variables'],
            'evn_behavior' => 'CATCH',
            'pro_id' => $processDefinitionData['id']
        );
        $depWrapper = new PMSERelatedDependencyWrapper();
        $depWrapper->processRelatedDependencies($fakeEventData);
    }
}
