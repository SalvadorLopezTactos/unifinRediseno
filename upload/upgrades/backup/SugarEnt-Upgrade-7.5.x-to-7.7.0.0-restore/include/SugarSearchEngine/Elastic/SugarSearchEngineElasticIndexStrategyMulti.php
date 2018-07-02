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
 * Per module index support
 */
class SugarSearchEngineElasticIndexStrategyMulti extends SugarSearchEngineElasticIndexStrategyBase
{
    /**
     *
     * Index name prefix
     * @var string
     */
    protected $prefix;

    /**
     *
     * Alias name to use for read access
     * @var string
     */
    protected $readAlias;

    /**
     *
     * Default catch all index name for module which
     * do not have a specific index defined
     * @var string
     */
    protected $writeDefaultIndex;

    /**
     *
     * List of module specific indices
     * @var array
     */
    protected $moduleIndices = array();

    /**
     *
     * Flat list of all indices
     * @var array
     */
    protected $allIndices = array();

    /**
     *
     * Boolean to enable multi indices per module
     * with custom routing. If not configured only the
     * first configured index for every module will apply
     * @var boolean
     */
    protected $customRouting = false;

    /**
     * (non-PHPdoc)
     * @see SugarSearchEngineElasticIndexStrategyBase::setConfig()
     */
    public function setConfig($config = array())
    {
        parent::setConfig($config);

        // parse config settings
        // TODO: add cache wrappers ?
        $this->setPrefix();
        $this->setReadAlias();
        $this->setWriteDefaultIndex();
        $this->setModuleIndices();
    }

    /**
     *
     * Set index name prefix, default to using the unique instance id
     */
    protected function setPrefix()
    {
        if (isset($this->config['unique_prefix']) && $this->config['unique_prefix'] !== false) {
            if (is_string($this->config['unique_prefix'])) {
                $this->prefix = strtolower($this->config['unique_prefix']);
            } elseif ($this->config['unique_prefix'] === true) {
                $this->prefix = $this->getUniqueIndexName();
            }
        } elseif (!isset($this->config['unique_prefix'])) {
            $this->prefix = $this->getUniqueIndexName();
        }
    }

    /**
     *
     * Add configured prefix to index name
     * @param string $name
     * @return string
     */
    protected function addPrefix($name)
    {
        return ($this->prefix) ? $this->prefix . "_" . $name : $name;
    }

    /**
     *
     * Set alias name used for read access
     */
    protected function setReadAlias()
    {
        if (empty($this->config['read_alias'])) {
            $this->readAlias = $this->addPrefix('alias');
        } else {
            $this->readAlias = $this->addPrefix(strtolower($this->config['read_alias']));
        }
    }

    /**
     *
     * Set index name for module which do not have a specific one configured
     */
    protected function setWriteDefaultIndex()
    {
        if (empty($this->config['write_default_index'])) {
            $this->writeDefaultIndex = $this->getUniqueIndexName();
        } else {
            $this->writeDefaultIndex = $this->addPrefix(strtolower($this->config['write_default_index']));
        }
    }

    /**
     *
     * Set list of per module indices used for write operations
     */
    protected function setModuleIndices()
    {
        if (!empty($this->config['module_indices']) && is_array($this->config['module_indices'])) {
            foreach ($this->config['module_indices'] as $module => $moduleIndices) {
                if (is_array($moduleIndices)) {
                    foreach ($moduleIndices as $index) {
                        // skip to next module when more than one index per module is configured
                        // without custom routing enabled
                        if (!$this->customRouting && !empty($this->moduleIndices[$module])) {
                            continue 2;
                        }
                        $indexName = strtolower($this->addPrefix($index));
                        $this->moduleIndices[$module][$indexName] = $indexName;
                        $this->allIndices[$indexName] = $indexName;
                    }
                }
            }
        }

        // add default write too to full index list
        $this->allIndices[$this->writeDefaultIndex] = $this->writeDefaultIndex;
    }

    /**
     * (non-PHPdoc)
     * @see SugarSearchEngineElasticIndexStrategyInterface::createIndex()
     */
    public function createIndex(
        \Elastica\Client $client,
        $modules,
        SugarSearchEngineElasticMapping $mapper,
        $params = array(),
        $recreate = false
    ) {

        // construct list of indices first to be created to avoid dups
        $indexList = array();
        if (empty($modules)) {
            $indexList = $this->getAllIndexes();
        } else {
            foreach ($modules as $module) {
                $indexList = array_merge($indexList, $this->getAllIndexes($module));
            }
        }

        foreach ($indexList as $indexName) {
            // create index
            $esIndex = $this->createSingleIndex($client, $indexName, $params, $recreate);
            // add read alias on the index
            $esIndex->addAlias($this->readAlias, false);
        }

        // mapper will cycle each index again based on enabled modules and its available indices
        $this->setMapping($mapper);
    }

    /**
     * (non-PHPdoc)
     * @see SugarSearchEngineElasticIndexStrategyInterface::getAllIndexes()
     */
    public function getAllIndexes($moduleName = '')
    {
        // module specific index list
        if (!empty($moduleName)) {
            if (isset($this->moduleIndices[$moduleName])) {
                return $this->moduleIndices[$moduleName];
            } else {
                return array($this->writeDefaultIndex => $this->writeDefaultIndex);
            }
        }

        // full list
        return $this->allIndices;
    }

    /**
     * Returns all index objects for given modules
     *
     * @param \Elastica\Client $client
     * @param array            $moduleNames
     *
     * @return array|\Elastica\Index[]
     */
    public function getReadIndices(\Elastica\Client $client, $moduleNames = array())
    {
        $indices = array();
        foreach ($moduleNames as $module) {
            foreach ($this->getAllIndexes($module) as $index) {
                $indices[] = new \Elastica\Index($client, $index);
            }
        }

        return $indices;
    }

    /**
     * (non-PHPdoc)
     * @see SugarSearchEngineElasticIndexStrategyInterface::getReadIndexName()
     */
    public function getReadIndexName($params = array())
    {
        // when no or multiple modules are passed in - fallback to general readAlias
        if (empty($params) || count($params) > 1) {
            return $this->readAlias;
        }

        // otherwise get all available indices for this module and return comma separated list
        $module = array_shift($params);
        $indices = $this->getAllIndexes($module);
        return implode(',', $indices);
    }

    /**
     *
     * If multiple are available for one module, index routing handlers can be used to
     * decide which to return. For this $customRouting needs to be configured and
     * index routing handlers need to be created by extending this class.
     *
     * @see SugarSearchEngineElasticIndexStrategyInterface::getWriteIndexName()
     */
    public function getWriteIndexName($params = array())
    {
        // parse context
        if (isset($params['context'])) {
            if ($moduleName = $this->getModuleFromContext($params['context'])) {
                if ($indices = $this->getAllIndexes($moduleName)) {
                    return $this->indexRoutingHandler($moduleName, $indices, $params['context']);
                }
            }
        }

        // fallback to our default write index
        $GLOBALS['log']->fatal(
            "No index routing context defined to determine module, dumping params: ".var_export($params, true)
        );
        return $this->writeDefaultIndex;
    }

    /**
     *
     * Routinghandler to be overriden by extension class - default returns first and only entry
     * Note: set customRouting to parse multiple index configs per module !
     *
     * @param string $moduleName
     * @param array $indices
     * @param mixed(string|object) $context
     * @return string
     */
    protected function indexRoutingHandler($moduleName, $indices, $context)
    {
        return array_shift($indices);
    }

    /**
     *
     * Return module name for given context
     * @param mixed(string|object) $context
     * @return mixed(string|boolean)
     */
    protected function getModuleFromContext($context)
    {
        // Module name passed as string
        if (is_string($context)) {
            return $context;
        }

        // Sugar Bean context
        if ($context instanceof SugarBean) {
            return $context->module_name;
        }

        // Elastic Document context
        if ($context instanceof \Elastica\Document) {
            return $context->getType();
        }

        return false;
    }
}
