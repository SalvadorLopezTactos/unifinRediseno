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

namespace Sugarcrm\Sugarcrm\Elasticsearch\Index;

use Sugarcrm\Sugarcrm\Elasticsearch\Container;
use Sugarcrm\Sugarcrm\Elasticsearch\Analysis\AnalysisBuilder;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\ProviderCollection;
use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\Mapping;
use Sugarcrm\Sugarcrm\Elasticsearch\Adapter\Index;
use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\MappingCollection;

/**
 *
 * Index manager is responsible for the index settings and mappings. The
 * information for both is registered through the MappingManager and
 * AnalyzerManager for every enabled Provider. The index manager uses
 * the Index Pool to push changes to the Elasticsearch backend.
 *
 */
class IndexManager
{
    /**
     * Key for `$this->config` containing the default configuration settings
     * which apply to all indices.
     */
    const DEFAULT_INDEX_SETTINGS_KEY = 'default';

    /**
     * @var \Sugarcrm\Sugarcrm\Elasticsearch\Container
     */
    protected $container;

    /**
     * @var array Configuration index_settings
     */
    protected $config = array();

    /**
     * @var array Default index settings
     */
    protected $defaultSettings = array(
        // Ignore malformed fields when index a document
        'index.mapping.ignore_malformed' => true,
        // Coerce numeric values
        'index.mapping.coerce' => true,
    );

    /**
     * @var array Default type mapping
     */
    protected $defaultMapping = array(
        // Avoid wasting space on _all field which we don't need
        '_all' => array('enabled' => false),
        // Disable inclusion of fields by default for _all
        'include_in_all' => false,
        // Ignore new fields for which no mapping exists
        'dynamic' => false,
    );

    /**
     * Ctor
     */
    public function __construct(array $config, Container $container)
    {
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * Verify if the system is ready to create/change indices.
     * @return boolean
     */
    protected function readyForIndexChanges()
    {
        // force connectivity check
        if (!$this->container->client->isAvailable(true)) {
            return false;
        }
        return $this->container->queueManager->pauseQueue();
    }

    /**
     * Schedule reindex:
     * 1. Create indices (drop existing one's on $recreateIndices)
     * 2. Queue all records for given modules
     * 3. Ensure scheduler job exists to process the queue
     *
     * @param array $modules List of modules
     * @param boolean $recreateIndices
     * @return boolean False on failure, true on success
     */
    public function scheduleIndexing(array $modules = array(), $recreateIndices = false)
    {
        if (!$this->readyForIndexChanges()) {
            $this->container->logger->critical('System not ready for full reindex, cancelling');
            return false;
        }

        if ($recreateIndices) {
            $this->syncIndices($modules, $recreateIndices);
        }

        $this->container->queueManager->reindexModules($modules);

        return true;
    }

    /**
     * Create the mappings for given module without re-creating the index.
     * @param array $modules
     * @return bool
     */
    public function addMappings(array $modules = array())
    {
        if (!$this->readyForIndexChanges()) {
            $this->container->logger->critical('System not ready for full reindex, cancelling');
            return false;
        }

        //add the mapping without re-creating the index
        $this->syncIndices($modules, false);

        return true;
    }


    /**
     * *** Zero downtime reindexing with analyzer/mapping changes ***
     *
     * Smart reindex generates the full mapping and compares the difference
     * with the already present settings and mapping for every active index.
     * Based on this difference the Index Nanager will determine what needs
     * to happen to get everything back in sync.
     *
     * The following preliminary approaches can be used:
     *
     * Analyzer differences (same for ALL indices):
     * 1. New analyzer
     *      - Close index, add analyzer, open index
     * 2. Removed analyzer
     *      - Can be ignored, no further action
     * 3. Update existing analyzer
     *      - Not possible, highly discouraged
     *      - Needs full reindex
     *
     * Field mapping changes:
     * 1. New field and new sugarbean field
     *      - Can be added dynamically
     *      - No further action as need as no data exists yet for this field
     * 2. New field for existing sugarbean field
     *      - Can be added dynamically
     *      - Reindex of the module is required, needs database as source
     * 3. New mapping for existing field
     *      - Can be added dynamically, no need to remove the old one (*)
     *      - Reindex of the module required, can use elastic as source
     *
     * Different sync strategies may be implemented when an index is in need
     * of a "full" reindex.
     *
     * OPTION 1 when NO new data needs to be pulled from the database:
     * 1. Create new index with correct settings and mappings
     * 2. Redirect updates to the new index
     * 3. Scrolled search to funnel docs from the old into the new index
     * 4. When done delete the old index
     *
     * OPTION 2 when NEW data needs to be pulled from the database:
     * 1. Use procedure from above
     * 2. But before sending the docs back to ES pull specific field(s) in
     *    a cheap/fast way from the database
     *
     * TBD: The Index Pool/Strategy can be extended to support aliases. This
     * might come in hand but is not absolutely required as sugar should
     * already know when to use which indices. Nevertheless by adding smart
     * reindex support Index Pool does need to know about index versions
     * regardless if aliases are implemnted or not.
     *
     */

    /**
     * Sync new index settings to Elasticsearch backend
     * @param array $modules List of modules to sync
     * @param boolean $dropExist
     */
    protected function syncIndices(array $modules, $dropExist = false)
    {
        // Get registered providers
        $providerCollection = new ProviderCollection($this->container, $this->getRegisteredProviders());

        // build analysis settings
        $analysisBuilder = new AnalysisBuilder();
        $this->buildAnalysis($analysisBuilder, $providerCollection);

        // build mapping
        $mappingCollection = $this->buildMapping($providerCollection, $modules);

        // build index list
        $indexCollection = $this->getIndexCollection($mappingCollection);

        /*
         * Currently we only support full rebuilds of the indices. This will
         * change in the future by adding logic in IndexManager to diff the
         * new analyzer and mapping settings against the already deployed
         * indices if any. This will allow for an incremental update when
         * possible.
         */
        $this->createIndices($indexCollection, $analysisBuilder, $mappingCollection, $dropExist);
    }

    /**
     * Build analysis settings
     * @param AnalysisBuilder $analysisBuilder
     * @param ProviderCollection $providers
     */
    protected function buildAnalysis(AnalysisBuilder $analysisBuilder, ProviderCollection $providerCollection)
    {
        foreach ($providerCollection as $provider) {
            $provider->buildAnalysis($analysisBuilder);
        }
    }

    /**
     * Build mapping for available providers
     * @param ProviderCollection $providerCollection
     * @param array $modules the list of enabled modules
     * @return MappingCollection
     */
    protected function buildMapping(ProviderCollection $providerCollection, array $modules = array())
    {
        if (empty($modules)) {
            $modules = $this->getAllEnabledModules();
        }
        return $this->container->mappingManager->buildMapping($providerCollection, $modules);
    }

    /**
     * Build index settings for given index
     * @param string $index Index name
     * @param AnalysisBuilder $analysisBuilder
     * @return array
     */
    protected function buildIndexSettings($index, AnalysisBuilder $analysisBuilder)
    {
        $config = $this->getIndexSettingsFromConfig($index);
        return array_merge($this->defaultSettings, $config, $analysisBuilder->compile());
    }

    /**
     * Get index settings from $sugar_config
     * @param string $index Index name
     * @return array
     */
    protected function getIndexSettingsFromConfig($index)
    {
        $settings = array();
        if (isset($this->config[$index])) {
            $settings = $this->config[$index];
        } elseif (isset($this->config[self::DEFAULT_INDEX_SETTINGS_KEY])) {
            $settings = $this->config[self::DEFAULT_INDEX_SETTINGS_KEY];
        }

        // We do NOT accept analysis settings anymore in `$sugar_config`
        if (isset($settings[AnalysisBuilder::ANALYSIS])) {
            unset($settings[AnalysisBuilder::ANALYSIS]);
        }

        return $settings;
    }

    /**
     * Create list of indices
     * @param IndexCollection $indexCollection
     * @param AnalysisBuilder $analysisBuilder
     * @param MappingCollection $mappingCollection
     * @param boolean $dropExist Drop indices if already they already exist
     */
    public function createIndices(
        IndexCollection $indexCollection,
        AnalysisBuilder $analysisBuilder,
        MappingCollection $mappingCollection,
        $dropExist = false
    ) {
        foreach ($indexCollection as $index) {

            if ($dropExist === true) {
                $this->createIndex($index, $analysisBuilder, $dropExist);
            }

            // Set mapping for all available types on this index
            $types = $index->getTypes();
            foreach ($types as $module => $type) {

                /* @var $fieldMappings Mapping */
                $fieldMappings = $mappingCollection->$module;
                $properties = $fieldMappings->compile();

                // Prepare mapping object
                $mapping = new \Elastica\Type\Mapping();
                $mapping->setType($type);
                $mapping->setProperties($properties);

                // Configure _source
                $mapping->setParam('_source', $this->getSourceSettings($fieldMappings));

                // Send mapping
                $this->sendMapping($mapping);
            }
        }
    }

    /**
     * Get _source field settings
     * @param Mapping $mapping
     * @return array
     */
    protected function getSourceSettings(Mapping $mapping)
    {
        // base settings
        $source = array(
            'enabled' => true,
        );

        // add excludes
        if ($excludes = $mapping->getSourceExcludes()) {
            $source['excludes'] = $excludes;
        }

        return $source;
    }

    /**
     * Create index
     * @param Index $index
     * @param AnalysisBuilder $analysisBuilder
     * @param boolean $dropExist Drop index if already exists
     * @return \Sugarcrm\Sugarcrm\Elasticsearch\Adapter\Index
     */
    public function createIndex(Index $index, AnalysisBuilder $analysisBuilder, $dropExist = false)
    {
        // TODO: add error handling
        $settings = $this->buildIndexSettings($index->getBaseName(), $analysisBuilder);
        $result = $index->create($settings, $dropExist);
        return $index;
    }

    /**
     * Send type mapping to backend applying default mapping
     * @param \Elastica\Type\Mapping $mapping
     */
    protected function sendMapping(\Elastica\Type\Mapping $mapping)
    {
        // Apply default mapping settings
        foreach ($this->defaultMapping as $key => $value) {
            $mapping->setParam($key, $value);
        }
        $mapping->send();
    }

    /**
     * Get list of all enabled modules
     * @return array
     */
    protected function getAllEnabledModules()
    {
        return $this->container->metaDataHelper->getAllEnabledModules();
    }

    /**
     * Wrapper listing all registered providers
     * @return array
     */
    protected function getRegisteredProviders()
    {
        return $this->container->getRegisteredProviders();
    }

    /**
     * Get index collection for given mapping
     * @param MappingCollection $mappingCollection
     * @return IndexCollection
     */
    protected function getIndexCollection(MappingCollection $mappingCollection)
    {
        return $this->container->indexPool->buildIndexCollection($mappingCollection);
    }
}
