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

require_once('include/SugarSearchEngine/SugarSearchEngineFactory.php');
require_once('include/SugarQueue/SugarJobQueue.php');
require_once('modules/SchedulersJobs/SchedulersJob.php');

/**
 * Base class of full text search Indexer
 * @api
 */
abstract class SugarSearchEngineIndexerBase implements RunnableSchedulerJob
{
    /**
     * The name of the queue table
     */
    const QUEUE_TABLE = 'fts_queue';

    /**
     * @var SchedulersJob
     */
    protected $schedulerJob;

    /**
     * @var \SugarSearchEngineAbstractBase
     */
    protected $SSEngine;

    /**
     * @var The max number of beans we process before starting to bulk insert so we dont hit memory issues.
     */
    protected $max_bulk_threshold = 5000;

    /**
     * @var The max number of beans we process before starting to bulk insert so we dont hit memory issues.
     */
    protected $max_bulk_query_threshold = 15000;

    /**
     * @var The max number of beans we delete at a time
     */
    protected $max_bulk_delete_threshold = 3000;

    /**
     * @var Number of time to postpone a job by so it's not executed twice during the same request.
     */
    protected $postpone_job_time = 60;

    /**
     * @var DBManager
     */
    protected $db;

    /**
     * @var table_name
     */
    protected $table_name;

    /**
     * @param SugarSearchEngineAqbstractBase $engine
     */
    public function __construct(SugarSearchEngineAbstractBase $engine = null)
    {
        if ($engine != null) {
            $this->SSEngine = $engine;
        } else {
            $this->SSEngine = SugarSearchEngineFactory::getInstance();
        }

        $this->db = DBManagerFactory::getInstance('fts');
        $this->table_name = self::QUEUE_TABLE;

        $config = SugarConfig::getInstance();
        $this->max_bulk_threshold = $config->get('search_engine.max_bulk_threshold', $this->max_bulk_threshold);
        $this->max_bulk_query_threshold = $config->get('search_engine.max_bulk_query_threshold', $this->max_bulk_query_threshold);
        $this->max_bulk_delete_threshold = $config->get('search_engine.max_bulk_delete_threshold', $this->max_bulk_delete_threshold);
        $this->postpone_job_time = $config->get('search_engine.postpone_job_time', $this->postpone_job_time);
    }

    /**
     * Set the scheduler job that initiated the run call.
     *
     * @param SchedulersJob $job
     */
    public function setJob(SchedulersJob $job)
    {
        $this->schedulerJob = $job;
    }

    protected function generateFTSQuery($module, $fieldDefs)
    {
        $queueTableName = self::QUEUE_TABLE;
        $bean = BeanFactory::getBean($module);
        $ftsQuery = new SugarQuery();
        $ftsQuery->from($bean);

        // add fts enabled fields to the filter
        $fieldsFilter = array('id');
        foreach ($fieldDefs as $value) {
            // skip nondb fields
            if (!empty($value['source']) && $value['source'] == 'non-db') {
                continue;
            }
            // filter email1 field and add the join.
            if ($value['name'] == 'email1') {
                $ftsQuery->join('email_addresses_primary', array('alias' => 'email1'));
                $fieldsFilter[] = 'email1.email_address';
            } else {
                $fieldsFilter[] = $value['name'];
            }
        }
        // need to get the doc owner to be indexed
        if (isset($bean->field_defs['assigned_user_id'])) {
            $docOwnerField = 'assigned_user_id';
        } else if (isset($bean->field_defs['created_by'])) {
            $docOwnerField = 'created_by';
        }
        if (!empty($docOwnerField)) {
            $fieldsFilter[] = $docOwnerField;
        }
        $ftsQuery->select($fieldsFilter);

        // join fts_queue table
        $ftsQuery->joinTable($queueTableName)->on()
            ->equalsField($queueTableName . '.bean_id', 'id');

        // additional fts_queue fields
        $ftsQueueFields = array(
            array($queueTableName . '.id', 'fts_id'),
            array($queueTableName . '.processed', 'fts_processed'),
        );
        $ftsQuery->select($ftsQueueFields);

        return $ftsQuery->compileSql();
    }

    /**
     * Main function that handles the indexing of a bean and is called by the job queue system.
     * Subclasses should implement their own logic.
     *
     * @param $data
     * @return bool
     */
    public function run($data)
    {
        return true;
    }

    /**
     * Handle removal of processed queue entries
     * @param array $ftsIDs
     */
    protected function delFtsProcessed(array $ftsIDs)
    {
        $count = 0;
        $deleteIDs = array();
        foreach ($ftsIDs as $ftsID) {
            $deleteIDs[] = $ftsID;
            $count++;
            if ($count != 0 && $count % $this->max_bulk_delete_threshold == 0) {
                $this->delFtsIDs($deleteIDs);
                $deleteIDs = array();
            }
        }

        if (count($deleteIDs) > 0) {
            $this->delFtsIDs($deleteIDs);
        }
    }

    /**
     * Remove list of ids from fts_queue table
     * @param array $deleteIDs
     */
    private function delFtsIDs($deleteIDs)
    {
        $tableName = self::QUEUE_TABLE;
        $inClause = implode("','", $deleteIDs);
        $query = "DELETE FROM $tableName WHERE id in ('{$inClause}')";
        $GLOBALS['log']->debug("DELETE BEAN QUERY IS: $query");
        $this->db->query($query);
    }
}
