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
 * Interface for strategies to index data into elastic
 */
interface SugarSearchEngineElasticIndexStrategyInterface
{
    /**
     * Returns all indexes used
     *
     * @abstract
     * @param array $modules OPTIONAL module name to get indexes
     * @return array list of indexes
     */
    public function getAllIndexes($moduleName = '');

    /**
     * Returns index objects for all given module names
     *
     * @param \Elastica\Client $client
     * @param array            $moduleNames
     *
     * @return Elastica_Index[]
     */
    public function getReadIndices(\Elastica\Client $client, $moduleNames = array());

    /**
     * Creates an elastic index
     *
     * @abstract
     * @param \Elastica\Client $client
     * @param array $modules OPTIONAL list of modules to create an index for
     * @param boolean $recreate OPTIONAL Deletes index first if already exists (default = false)
     * @param $params
     */
    public function createIndex(
        \Elastica\Client $client,
        $modules,
        SugarSearchEngineElasticMapping $mapper,
        $params = array(),
        $recreate = false
    );

    /**
     * Retrieves the index name for reading
     *
     * @abstract
     * @param $params
     * @return string
     */
    public function getReadIndexName($params = array());

    /**
     * Retrieves the index name for writing
     *
     * @abstract
     * @param $params
     * @return string
     */
    public function getWriteIndexName($params = array());
}
