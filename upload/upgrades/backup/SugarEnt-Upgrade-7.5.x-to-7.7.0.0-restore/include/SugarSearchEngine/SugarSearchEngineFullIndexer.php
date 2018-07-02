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
require_once('include/SugarSearchEngine/SugarSearchEngineIndexerBase.php');

/**
 * Indexer job for Search
 * @api
 */
class SugarSearchEngineFullIndexer extends SugarSearchEngineIndexerBase
{
    const ASYNC_TIMEOUT = 120;

    /**
     * Name of the scheduler to perform a full index
     * @var string
     */
    public static $schedulerName = "Full Text Search Indexer";

    /**
     * @param SugarSearchEngineAqbstractBase $engine
     */
    public function __construct(SugarSearchEngineAbstractBase $engine = null)
    {
        parent::__construct($engine);
        $this->results = array();

        // use a higher connection timeout then we do for inline calls
        $this->SSEngine->setTimeout(self::ASYNC_TIMEOUT);
    }

    /**
     * Remove all records that may be currently queued for FTS ingestion
     * @param array $modules
     */
    protected function clearFTSIndexQueue(array $modules)
    {
        $GLOBALS['log']->info("Clearing FTS Index Queue for: ".implode(', ', $modules));
        $db = DBManagerFactory::getInstance('fts');
        foreach ($modules as $module) {
            $q = sprintf(
                'DELETE FROM %s WHERE bean_module = %s',
                self::QUEUE_TABLE,
                $db->quoted(BeanFactory::getBeanName($module))
            );
            $db->query($q);
        }
    }

    /**
     * Initiate the FTS indexer.  Once initiated, all work will be done by the FTS consumers which will be invoked
     * by the job queue system.
     *
     * @param array $modules             Modules to index
     * @param bool  $deleteExistingData Remove existing index
     * @param bool  $runNow             Run indexing jobs immediately instead of placing them in job queue
     * @return SugarSearchEngineFullIndexer
     */
    public function initiateFTSIndexer(array $modules = array(), $deleteExistingData = true, $runNow = false)
    {
        $startTime = microtime(true);
        $GLOBALS['log']->info("Populating Full System Index Queue at $startTime");
        if(! $this->SSEngine instanceof SugarSearchEngineAbstractBase)
        {
            $GLOBALS['log']->info("No FTS engine enabled, not doing anything");
            return false;
        }

        $allModules = !empty($modules) ?
            $modules : array_keys(SugarSearchEngineMetadataHelper::retrieveFtsEnabledFieldsForAllModules());

        // Create the index on the server side
        $this->SSEngine->createIndex($deleteExistingData, $allModules);

        // Clear the existing queue
        $this->clearFTSIndexQueue($allModules);

        // clear flag
        $admin = Administration::getSettings();
        if (!empty($admin->settings['info_fts_index_done'])) {
            $admin->saveSetting('info', 'fts_index_done', 0);
        }

        $totalCount = 0;
        foreach($allModules as $module)
        {
            $totalCount += $this->populateIndexQueueForModule($module, $runNow);
        }

        $totalTime = number_format(round(microtime(true) - $startTime, 2), 2);
        $this->results['totalTime'] = $totalTime;
        $GLOBALS['log']->info("Total time to populate full system index queue: $totalTime (s)");
        $avgRecs = ($totalCount != 0 && $totalTime != 0) ? number_format(round(($totalCount / $totalTime), 2), 2) : 0;
        $GLOBALS['log']->info("Total number of modules queued: $totalCount , modules per sec. $avgRecs");

        return $this;
    }

    /**
     * Populate the index queue with all records from a particular module
     *
     * @param string $module
     * @param bool   $runNow Run job immediately instead of placing it in queue
     * @return bool
     */
    public function populateIndexQueueForModule($module, $runNow = false)
    {
        $GLOBALS['log']->info("Going to populate index queue for module {$module} ");

        // setup seed bean
        $db = DBManagerFactory::getInstance('fts');
        $seed = BeanFactory::getBean($module, null);
        if (!$seed instanceOf SugarBean) {
            $GLOBALS['log']->error("Full indexer: Failed to get bean for module: $module");
            return false;
        }

        // determine bean name
        $beanName = BeanFactory::getBeanName($module);
        if (empty($beanName)) {
            $GLOBALS['log']->error("Full indexer: Failed to get bean name for module: $module");
            return false;
        }

        $tableName = self::QUEUE_TABLE;
        $query = sprintf(
            'INSERT INTO %s (bean_id, bean_module, id, date_created)
            SELECT m.id bean_id, %s, %s, %s
            FROM %s m WHERE m.deleted = 0 ',
            $tableName,
            $db->quoted($beanName),
            $db->getGuidSQL(),
            $db->now(),
            $seed->table_name
        );
        $db->query($query, true, "Error populating index queue for fts - {$module}");

        // For each module we populate the fts queue with, create a consumer to digest the beans as well.
        $this->createJobQueueConsumerForModule($module, $runNow);
        return true;
    }

    /**
     * Create a job queue FTS consumer for a specific module
     *
     * @param string $module
     * @param bool   $runNow Run job immediately instead of placing in job queue
     * @return string Id of newly created job
     */
    public function createJobQueueConsumerForModule($module, $runNow = false)
    {
        $jobBean = BeanFactory::getBean('SchedulersJobs');
        $q = sprintf(
            "SELECT name FROM %s
             WHERE name = 'FTSConsumer %s' AND deleted = 0 AND status != '%s'",
            $jobBean->table_name,
            $module,
            SchedulersJob::JOB_STATUS_DONE
        );
        $res = $jobBean->db->query($q);

        if ($row = $GLOBALS['db']->fetchByAssoc($res)) {
            $GLOBALS['log']->info("Job queue already exists for: FTSConsumer {$module}");
            return;
        }

        $GLOBALS['log']->info("Creating FTS Job queue consumer for: {$module} ");
        $job = new SchedulersJob();
        $job->data = $module;
        $job->name = "FTSConsumer {$module}";
        $job->target = "class::SugarSearchEngineFullIndexer";
        $job->assigned_user_id = 1;
        if ($runNow) {
            $job->runJob();
        } else {
            $queue = new SugarJobQueue();
            $queue->submitJob($job);
        }
        return $job->id;
    }

    /**
     * Index the entire system. This should only be called from a worker process as this is a time intensive process
     * and does not take advantage of the job queue system.  Currently this call is only used when populating demo
     * data and should be used sparingly.
     *
     * @param array $modules           List of modules to index
     * @param bool  $clearExistingData Purge existing index data
     * @return bool
     */
    public function performFullSystemIndex(array $modules = array(), $clearExistingData = true)
    {
        //Do nothing if no FTS has been setup.
        if (!$this->SSEngine instanceof SugarSearchEngineAbstractBase) {
            $GLOBALS['log']->info("No FTS engine enabled, not doing anything");
            return false;
        }
        if (!$this->initiateFTSIndexer($modules, $clearExistingData, true)) {
            $GLOBALS['log']->info("FTS index was not initiated");
            return false;
        }
        return true;
    }

    /**
     * Index records into search engine
     *
     * @param string $module
     * @param array  $fieldDefinitions
     * @return integer number of indexed records, -1 if fails
     */
    public function indexRecords($module, array $fieldDefinitions)
    {
        $beanName = BeanFactory::getBeanName($module);
        $bean = BeanFactory::newBean($module);
        $queuTableName = self::QUEUE_TABLE;
        $processedFtsIds = array();
        $count = 0;
        $docs = array();
        if ($this->shouldIndexViaBean($module)) {
            $GLOBALS['log']->debug("SugarFullIndexer will use bean to index records");
            $selectAllQuery = "SELECT id, bean_id FROM {$queuTableName} WHERE bean_module='{$beanName}' AND processed = 0";
            $result = $this->db->limitQuery($selectAllQuery, 0, $this->max_bulk_threshold, true, "Unable to retrieve records from FTS queue");
        } else {
            $GLOBALS['log']->debug("SugarFullIndexer will use db to index records");
            $sql = $this->generateFTSQuery($module, $fieldDefinitions);
            $result = $this->db->limitQuery($sql, 0, $this->max_bulk_query_threshold, true, "Unable to retrieve records from FTS queue");
        }

        while ($row = $this->db->fetchByAssoc($result, false)) {

            $beanID = $row['id'];
            $ftsId = $row['fts_id'];
            $processed = $row['fts_processed'];

            if ($this->shouldIndexViaBean($module)) {
                $bean = BeanFactory::getBean($module, $beanID);
            } else {
                $row['module_dir'] = $module;
                $row = $bean->convertRow($row);
                $bean->fetched_row = $row;
                $bean->populateFromRow($row);
            }

            if ($bean !== false) {
                $GLOBALS['log']->debug("About to index bean: $beanID $module");
                $docs[] = $this->SSEngine->createIndexDocument($bean, $fieldDefinitions);
                // add related beans to queue (processed == 0)
                if ($processed == 0) {
                    $this->postProcessing($bean);
                }
                $processedFtsIds[] = $ftsId;
                $count++;
            }

            if ($count != 0 && $count % $this->max_bulk_threshold == 0) {
                $ok = $this->SSEngine->bulkInsert($docs);
                if ($ok) {
                    $this->delFtsProcessed($processedFtsIds);
                } else {
                    return -1;
                }
                $docs = $processedBeans = array();
                sugar_cache_reset();
                if (function_exists('gc_collect_cycles')) {
                    gc_collect_cycles();
                }

                $lastMemoryUsage = isset($lastMemoryUsage) ? $lastMemoryUsage : 0;
                $currentMemUsage = memory_get_usage();
                $totalMemUsage = $currentMemUsage - $lastMemoryUsage;
                $GLOBALS['log']->info("Flushing records, count: $count mem. usage:" .  memory_get_usage() . " , mem. delta: " . $totalMemUsage);
                $lastMemoryUsage = $currentMemUsage;
            }
        }

        if (count($docs) > 0) {
            $ok = $this->SSEngine->bulkInsert($docs);
            if (!$ok) {
                return -1;
            }
        }

        $this->delFtsProcessed($processedFtsIds);
        return $count;
    }

    /**
     * Determine if a particular module should be indexed via its bean or if we can build a direct query.
     * Indexing a module by going through SugarBean can introduce performance problems
     *
     * @param string $module
     * @return bool
     * @deprecated
     */
    protected function shouldIndexViaBean($module)
    {
        return false;
    }

    /**
     * Main function that handles the indexing of a bean and is called by the job queue system.
     *
     * @param $data
     */
    public function run($module)
    {
        $serverOK = $this->updateFTSServerStatus();
        if ($serverOK != true) {
            $GLOBALS['log']->fatal('FTS Server is down, postponing the job for full index.');
            $this->schedulerJob->postponeJob(null, $this->postpone_job_time);
            return true;
        }

        $this->db->commit();

        $GLOBALS['log']->info("Going to index all records in module {$module} ");
        $startTime = microtime(true);
        $fieldDefinitions = SugarSearchEngineMetadataHelper::retrieveFtsEnabledFieldsPerModule($module);

        if (!empty($fieldDefinitions)) {
            $count = $this->indexRecords($module, $fieldDefinitions);
        } else {
            $GLOBALS['log']->fatal(sprintf('Fields of %s are not enabled for Full Text Search', $module));
            $this->schedulerJob->resolveJob(SchedulersJob::JOB_STATUS_DONE);
            return true;
        }
        if ($count == -1) {
            $GLOBALS['log']->fatal('FTS failed to index records, postponing job for next cron');
            $this->schedulerJob->postponeJob(null, $this->postpone_job_time);
            return true;
        }

        // stats logging
        $totalTime = number_format(round(microtime(true) - $startTime, 2), 2);
        $avgRecs = ($count != 0 && $totalTime != 0) ? number_format(round(($count / $totalTime), 2), 2) : 0;
        $GLOBALS['log']->info(
            sprintf(
                "FTS Consumer %s processed %s record(s) in %s secs, records per sec: %s",
                $this->schedulerJob->name,
                $count,
                $totalTime,
                $avgRecs
            )
        );

        // Mark the job that as pending so we can be invoked later again - this is considered to be a persistent job
        $this->schedulerJob->postponeJob(null, $this->postpone_job_time);
        return true;
    }

    /**
     * Check FTS server status and update cache file and notification.
     *
     * @return boolean
     */
    protected function updateFTSServerStatus()
    {
        $GLOBALS['log']->debug('Going to check and update FTS Server status.');
        // check FTS server status
        $result = $this->SSEngine->getServerStatus();
        if ($result['valid']) {
            $GLOBALS['log']->debug('FTS Server is OK.');
            // server is ok
            if (SugarSearchEngineAbstractBase::isSearchEngineDown()) {
                $GLOBALS['log']->debug('Restoring FTS Server status.');

                // mark fts server as up
                SugarSearchEngineAbstractBase::markSearchEngineStatus(false);

                // remove notification
                $cfg = new Configurator();
                $cfg->config['fts_disable_notification'] = false;
                $cfg->handleOverride();
            }

            return true;
        } else {
            $GLOBALS['log']->info('FTS Server is down?');
            // server is down
            if (!SugarSearchEngineAbstractBase::isSearchEngineDown()) {
                $GLOBALS['log']->fatal('Marking FTS Server as down.');
                // fts is not marked as down, so mark it as down
                SugarSearchEngineAbstractBase::markSearchEngineStatus(true);
            }

            return false;
        }
    }

    /**
     * Post processing hook for further customization
     * @param SugarBean $bean
     */
    protected function postProcessing(SugarBean $bean)
    {
        $GLOBALS['log']->debug("FTS full indexer post processing");
    }
}
