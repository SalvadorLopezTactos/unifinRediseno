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
require_once('include/SugarSearchEngine/Interface.php');
require_once('include/SugarSearchEngine/SugarSearchEngineMetadataHelper.php');

/**
 * Base class for search engine drivers
 * @api
 */
abstract class SugarSearchEngineAbstractBase implements SugarSearchEngineInterface
{
    /**
     * @var array
     */
    protected $_documents = array();

    /**
     * @var The max number of documents to bulk insert at a time
     */
    protected $max_bulk_doc_threshold = 100;

    /**
     * Logger to use to report problems
     * @var LoggerManager
     */
    public $logger;

    /**
     *
     * Ctor
     */
    public function __construct()
    {
        $this->max_bulk_doc_threshold = SugarConfig::getInstance()
            ->get('search_engine.max_bulk_doc_threshold', $this->max_bulk_doc_threshold);
        $this->logger = $GLOBALS['log'];
    }

    /**
     * Determine if a module is FTS enabled.
     *
     * @param $module
     * @return bool
     */
    protected function isModuleFtsEnabled($module)
    {
        return SugarSearchEngineMetadataHelper::isModuleFtsEnabled($module);
    }

    /**
     * This is needed to prevent unserialize vulnerability
     */
    public function __wakeup()
    {
        // clean all properties
        foreach(get_object_vars($this) as $k => $v) {
            $this->$k = null;
        }
        throw new Exception("Not a serializable object");
    }

    /**
     * Bulk insert any documents that have been marked for bulk insertion.
     */
    public function __destruct()
    {
        if (count($this->_documents) > 0 )
        {
            $this->bulkInsert($this->_documents);
        }

    }

    /**
     * Disable FTS and write to config.
     *
     */
    protected function disableFTS()
    {
        $this->logger->fatal('Full Text Search has been disabled because the system is not able to connect to the search engine.');
        self::markSearchEngineStatus(true);

        // notification
        if(empty($GLOBALS['sugar_config']['fts_disable_notification'])) {
            $cfg = new Configurator();
            $cfg->config['fts_disable_notification'] = true;
            $cfg->handleOverride();
        }
    }

    /**
     * This function adds records to FTS queue.
     *
     * @param $records array of records
     */
    protected function addRecordsToQueue($records)
    {
        $this->logger->info('addRecordsToQueue');
        $db = DBManagerFactory::getInstance('fts');
        $db->resetQueryCount();

        foreach ($records as $rec) {
            if (!is_array($rec) || empty($rec['bean_id']) || empty($rec['bean_module'])) {
                $this->logger->error('Error populating fts_queue. Empty bean_id or bean_module.');
                continue;
            }

            // support multiple values for 'processed'
            $rec['processed'] = empty($rec['processed']) ? 0 : $rec['processed'];

            $query = sprintf(
                "SELECT id, processed FROM fts_queue WHERE bean_id = %s AND bean_module = %s",
                $db->quoted($rec['bean_id']),
                $db->quoted(BeanFactory::getBeanName($rec['bean_module']))
            );

            $res = $db->query($query, true, "Error get records from queue for fts");
            if ($item = $db->fetchRow($res)) {
                if ($item['processed'] != $rec['processed'] && $item['processed'] != 0) {
                    $query = sprintf(
                        "UPDATE fts_queue SET processed = %s, date_modified = current_timestamp WHERE id = %s",
                        $db->quoted($rec['processed']),
                        $db->quoted($item['id'])
                    );
                    $db->query($query, true, "Error update record in queue for fts");
                }
            } else {
                $beanName = BeanFactory::getBeanName($rec['bean_module']);
                if (empty($beanName)) {
                    $GLOBALS['log']->error("Full indexer: Failed to get bean name for module: {$rec['bean_module']}");
                    continue;
                }
                $query = sprintf(
                    "INSERT INTO fts_queue (id, bean_id, bean_module, processed, date_created)
                        values (%s, %s, %s, %s, %s)",
                    $db->quoted(create_guid()),
                    $db->quoted($rec['bean_id']),
                    $db->quoted($beanName),
                    $db->quoted($rec['processed']),
                    $db->now()
                );
                $db->query($query, true, "Error populating index queue for fts");
            }
        }

        /*
         * The full indexer jobs should already be present when a full reindex
         * has been scheduled earler on. Those are presistent jobs and will
         * remain in the job queue to process new reocrds from the fts_queue.
         *
         * If a full indexer job is manually removed, scheduling again a full
         * reindex will trigger restoration of the full indexer jobs where needed.
         */
    }

    /**
     * This function checks config to see if search engine is down.
     *
     * @return Boolean
     */
    public static function isSearchEngineDown()
    {
        $settings = Administration::getSettings();
        if (!empty($settings->settings['info_fts_down'])) {
            return true;
        }
        return false;
    }

    /**
     * This function marks config to indicate that search engine is up or down.
     *
     * @param Boolean $isDown
     */
    public static function markSearchEngineStatus($isDown = true)
    {
        $admin = BeanFactory::getBean('Administration');
        $admin->saveSetting('info', 'fts_down', $isDown? 1: 0);
    }

    protected function reportException($message, $e)
    {
        $this->logger->fatal("$message: ".get_class($e));
        if($this->logger->wouldLog('error')) {
            $this->logger->error($e->getMessage());
        }
    }

    /**
     * This function queries db to get the value of a field.
     * @param String $fieldName field name
     * @param String $bean SugarBean
     * @return Mix field value
     */
    protected function getFieldValue($fieldName, $bean)
    {
        $value = null;

        if (!empty($bean->table_name) && !empty($fieldName) && !empty($bean->id)) {
            $db = DBManagerFactory::getInstance('fts');
            $sql = "SELECT {$fieldName} from {$bean->table_name} where id = " . $db->quoted($bean->id);
            $value = $db->getOne($sql, false, 'Error getting field value in fts');
        }

        return $value;
    }

    /**
     * @param SugarBean $bean
     */
    public function delete(SugarBean $bean)
    {
        $this->deleteFromQueue($bean);
    }

    /**
     * Delete record from fts_queue table
     *
     * @param SugarBean $bean
     */
    protected function deleteFromQueue($bean)
    {
        $query = sprintf(
            "DELETE FROM fts_queue WHERE bean_id = %s AND bean_module = %s",
            $bean->db->quoted($bean->id),
            $bean->db->quoted($bean->object_name)
        );
        $bean->db->query($query);
    }
}
