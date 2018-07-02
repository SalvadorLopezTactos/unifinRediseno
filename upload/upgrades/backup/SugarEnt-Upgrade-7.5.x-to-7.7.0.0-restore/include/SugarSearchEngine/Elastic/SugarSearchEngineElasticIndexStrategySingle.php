<?php
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

/**
 * Single index for reading and writing in Elastic
 */
class SugarSearchEngineElasticIndexStrategySingle extends SugarSearchEngineElasticIndexStrategyBase
{
    /**
     * Name of the index
     * @var string
     */
    protected $indexName;

    /**
     * Sets the configuration settings for the strategy
     *
     * @param $config
     * use_single => boolean
     * index => 'index_name'
     */
    public function setConfig($config = array())
    {
        // @see $sugar_config['full_text_engine']['Elastic']['index_strategy']['config']['index_name']
        // to override the default name which is by default the unique instance id
        $this->indexName = empty($config['index_name']) ?
            $this->getUniqueIndexName() : strtolower($config['index_name']);
        parent::setConfig($config);
    }

    /**
     * Creates an elastic index
     *
     * @param \Elastica\Client $client
     * @param array $modules OPTIONAL list of modules to create an index for
     * @param boolean $recreate OPTIONAL Deletes index first if already exists (default = false)
     * @param $params OPTIONAL
     */
    public function createIndex(
        \Elastica\Client $client,
        $modules,
        SugarSearchEngineElasticMapping $mapper,
        $params = array(),
        $recreate = false
    ) {
        $this->createSingleIndex($client, $this->indexName, $params, $recreate);
        $this->setMapping($mapper);
    }

    /**
     * Retrieves the index name for reading
     *
     * @param $params
     * @return string
     */
    public function getReadIndexName($params = array())
    {
        return $this->indexName;
    }

    /**
     * Retrieves the index name for writing
     *
     * @param $params
     * @return string
     */
    public function getWriteIndexName($params = array())
    {
        return $this->indexName;
    }

    /**
     * Returns all indexes for a module
     * @param string $moduleName
     * @return array list of indexes (only one element)
     */
    public function getAllIndexes($moduleName = '')
    {
        return array($this->indexName);
    }

    /**
     * Returns all index objects for given modules
     *
     * @param \Elastica\Client $client
     * @param array            $moduleNames
     *
     * @return array|Elastica_Index[]
     */
    public function getReadIndices(\Elastica\Client $client, $moduleNames = array())
    {
        $index = new \Elastica\Index($client, array_shift($this->getAllIndexes($moduleNames)));
        return array($index);
    }
}
