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
 * Generic strategy for indexing data into elastic
 */
abstract class SugarSearchEngineElasticIndexStrategyBase implements SugarSearchEngineElasticIndexStrategyInterface
{
    /**
     * Strategy config settings
     * @var array
     */
    protected $config;

    /**
     * Sets the configuration settings for the strategy
     *
     * @param $config
     */
    public function setConfig($config = array())
    {
        $this->config = $config;
    }

    /**
     * Returns the configuration settings for the strategy
     *
     * @returns array config settings
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Returns a unique index name for the sugar instance
     * @see $sugar_config['unique_key']
     * @return string
     */
    protected function getUniqueIndexName()
    {
        return strtolower(SugarConfig::getInstance()->get('unique_key', 'nouniquekey'));
    }

    /**
     *
     * Create single index
     * @param \Elastica\Client $client
     * @param string $indexName
     * @param array $params
     * @param boolean $recreate
     * @throws Exception
     */
    protected function createSingleIndex(\Elastica\Client $client, $indexName, $params = array(), $recreate = false)
    {
        try {
            // create an elastic index
            $settings = $this->getIndexSetting($indexName, $params);
            $index = new \Elastica\Index($client, $indexName);
            $index->create($settings, $recreate);
        } catch (Exception $e) {
            // ignore the IndexAlreadyExistsException exception
            if (strpos($e->getMessage(), 'IndexAlreadyExistsException') === false) {
                throw $e;
            }
        }
        return $index;
    }

    /**
     *
     * Create index mapping
     * @param SugarSearchEngineElasticMapping $mapper
     */
    protected function setMapping(SugarSearchEngineElasticMapping $mapper)
    {
        $mapper->setFullMapping();
    }

    /**
     *
     * Read default and specific index settings from config
     * @param string  $indexName
     * @param array   $params
     * @param boolean $addDefaults
     * @return array
     */
    protected function getIndexSetting($indexName, $params = array(), $addDefaults = true)
    {
        $indexSettings = array(
            'index' => array(
                'analysis' => array(
                    'analyzer' => array(
                        'core_email_lowercase' => array(
                            'type' => 'custom',
                            'tokenizer' => 'uax_url_email',
                            'filter' => array(
                                'lowercase',
                            ),
                        ),
                    ),
                ),
            ),
        );

        if (empty($params['index_settings']) || !is_array($params['index_settings'])) {
            return $indexSettings;
        }

        $settings = $params['index_settings'];
        if ($addDefaults && isset($settings['default']) && is_array($settings['default'])) {
            $indexSettings = sugarArrayMergeRecursive($indexSettings, $settings['default']);
        }

        if (isset($settings[$indexName]) && is_array($settings[$indexName])) {
            $indexSettings = sugarArrayMergeRecursive($indexSettings, $settings[$indexName]);
        }

        $GLOBALS['log']->info("Index settings for $indexName -> ".var_export($indexSettings, true));
        return $indexSettings;
    }
}
