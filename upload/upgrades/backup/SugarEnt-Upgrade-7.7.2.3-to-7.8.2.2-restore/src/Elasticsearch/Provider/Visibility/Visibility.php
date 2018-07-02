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

namespace Sugarcrm\Sugarcrm\Elasticsearch\Provider\Visibility;

use Sugarcrm\Sugarcrm\Elasticsearch\Provider\AbstractProvider;
use Sugarcrm\Sugarcrm\Elasticsearch\ContainerAwareInterface;
use Sugarcrm\Sugarcrm\Elasticsearch\Analysis\AnalysisBuilder;
use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\Mapping;
use Sugarcrm\Sugarcrm\Elasticsearch\Adapter\Document;
use Sugarcrm\Sugarcrm\Elasticsearch\Container;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\Visibility\Filter\FilterInterface;
use Sugarcrm\Sugarcrm\Elasticsearch\Query\QueryBuilder;

/**
 *
 * Visibilty wrapper around data/visbility classes
 *
 */
class Visibility extends AbstractProvider implements ContainerAwareInterface
{
    // Awaiting PHP 5.4+ support
    //use ContainerAwareTrait;

    ///// Start trait

    /**
     * @var \Sugarcrm\Sugarcrm\Elasticsearch\Container
     */
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getContainer()
    {
        return $this->container;
    }

    //// End trait

    /**
     * List of strategy collection per module
     * @var StrategyCollection[]
     */
    protected $strategies = array();

    /**
     * List of loaded filter objects
     * @var FilterInterface[]
     */
    protected $filters = array();

    /**
     * {@inheritdoc}
     */
    public function buildAnalysis(AnalysisBuilder $analysisBuilder)
    {
        $modules = $this->container->metaDataHelper->getAllEnabledModules();
        foreach ($this->getStrategies($modules) as $strategy) {
            $strategy->elasticBuildAnalysis($analysisBuilder, $this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildMapping(Mapping $mapping)
    {
        foreach ($this->getModuleStrategies($mapping->getModule()) as $strategy) {
            $strategy->elasticBuildMapping($mapping, $this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function processDocumentPreIndex(Document $document, \SugarBean $bean)
    {
        foreach ($this->getModuleStrategies($document->getType()) as $strategy) {
            $strategy->elasticProcessDocumentPreIndex($document, $bean, $this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getBeanIndexFields($module, $fromQueue = false)
    {
        $fields = array();
        foreach ($this->getModuleStrategies($module) as $strategy) {
            $fields = array_merge(
                $fields,
                $strategy->elasticGetBeanIndexFields($module, $this)
            );
        }
        return $fields;
    }

    /**
     * Build visibility filters
     * @param array $modules
     */
    public function buildVisibilityFilters(QueryBuilder $builder, array $modules)
    {
        // main filter object
        $main = new \Elastica\Filter\Bool();

        foreach ($modules as $module) {

            // main module filter
            $modFilter = new \Elastica\Filter\Bool();
            $modFilter->addMust($this->createFilter('Type', array('module' => $module)));

            // now add filters from different strategies
            $this->addVisibilityFilters($builder->getUser(), $modFilter, $module);

            // stack module filter on top of main filter
            $main->addShould($modFilter);
        }

        // visibility filter collection
        $builder->addFilter($main);
    }

    /**
     * Create filter
     * @param string $name
     * @param array $options
     * @return \Elastica\Filter\AbstractFilter
     */
    public function createFilter($name, array $options = array())
    {
        $filter = $this->getFilter($name);
        return $filter->buildFilter($options);
    }

    /**
     * Factory method for filter classes
     * @param string $name
     * @return FilterInterface
     */
    public function getFilter($name)
    {
        if (!isset($this->filters[$name])) {
            $class = \SugarAutoLoader::customClass(sprintf(
                'Sugarcrm\Sugarcrm\Elasticsearch\Provider\Visibility\Filter\%sFilter',
                $name
            ));
            $this->filters[$name] = $filter = new $class();
            $filter->setProvider($this);
        }
        return $this->filters[$name];
    }

    /**
     * Add visibility filters on top of given filter
     * @param \User $user User context
     * @param \Elastica\Filter\Bool $filter
     * @param string $module
     */
    protected function addVisibilityFilters(\User $user, \Elastica\Filter\Bool $filter, $module)
    {
        foreach ($this->getModuleStrategies($module) as $strategy) {
            $strategy->elasticAddFilters($user, $filter, $this);
        }
    }

    /**
     * Get visibility strategies for given modules
     * @param array $modules
     * @return StrategyCollection
     */
    protected function getStrategies(array $modules)
    {
        $strategies = new StrategyCollection();
        $strategies->addModuleStrategies($modules);
        return $strategies;
    }

    /**
     * Get visibility strategies for given module
     * @param \SugarBean $bean
     * @return StrategyCollection
     */
    protected function getModuleStrategies($module)
    {
        // cache strategies per module
        if (!isset($this->strategies[$module])) {
            $this->strategies[$module] = $this->getStrategies(array($module));
        }
        return $this->strategies[$module];
    }
}
