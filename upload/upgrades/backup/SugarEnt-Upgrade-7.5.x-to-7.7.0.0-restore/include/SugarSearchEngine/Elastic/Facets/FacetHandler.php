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

require_once 'include/SugarSearchEngine/Elastic/Facets/FacetFactory.php';

/**
 *
 * Facet Handler to interface with the facet framework
 *
 */
class FacetHandler
{
    /**
     *
     * Facet definitions
     * @var array
     */
    protected $facetDefs = array();

    /**
     *
     * Logger instance
     * @var SugarLogger
     */
    protected $log;

    /**
     *
     * Ctor
     */
    public function __construct()
    {
        $this->log = LoggerManager::getLogger();
    }

    /**
     *
     * Add facets on top of Elastica query
     * @param \Elastica\Query $query
     * @param array $options
     * @param \Elastica\Filter\Bool $mainFilter
     */
    public function addFacets(\Elastica\Query $query, $options, \Elastica\Filter\Bool $mainFilter)
    {
        // only add additional facets if a specific module is selected
        if (!$this->isOptionsModuleFilterValid($options)) {
            return;
        }

        $module = array_shift($options['moduleFilter']);
        $facetDefs = $this->loadFacetDefs($module);
        foreach ($facetDefs as $field => $facetDef) {
            if ($facet = FacetFactory::get($facetDef['type'])) {

                // set options from facet definition
                $facet->setOptions($facetDef['options']);

                // get Elastica facet object and assign it to the query
                if ($eFacet = $facet->getFacet($field, $mainFilter)) {
                    $query->addFacet($eFacet);
                }
            }
        }
    }

    /**
     *
     * Apply additional filters based on facet selection
     * @param string $module
     * @param array $options
     * @param \Elastica\Filter\AbstractFilter $moduleFilter
     */
    public function addFilters($module, Array $options, \Elastica\Filter\AbstractFilter $moduleFilter)
    {
        // secFilters will only be set when a module has been selected
        if (empty($options['secFilters'])) {
            return;
        }

        $filterDefs = $options['secFilters'];
        $facetDefs = $this->loadFacetDefs($module);
        foreach ($filterDefs as $field => $values) {

            // check that we have a facet def available
            if (empty($facetDefs[$field])) {
                continue;
            }

            if ($facet = FacetFactory::get($facetDefs[$field]['type'])) {

                // set options from facet definition
                $facet->setOptions($facetDefs[$field]['options']);

                // get Elastica filter object and add it to the module filter
                if ($eFilter = $facet->getFilter($field, $values)) {
                    $moduleFilter->addMust($eFilter);
                }
            }
        }
    }

    /**
     *
     * Parse facet result list
     *
     * For now we are handling this directly here, but depending
     * on the additional facet types we will add may may have to
     * move this into the facet implementation classes if
     * different handling is needed
     *
     * @param SugarSeachEngineElasticResultSet $resultSet
     * @param array $options
     * @return array
     */
    public function parseFacets(SugarSeachEngineElasticResultSet $resultSet, $options = array())
    {
        $result = array(
            'module_facet' => array(),
            'secondary_facets' => array(),
        );

        // we can only process secondary facet results if a module filter is present
        if ($this->isOptionsModuleFilterValid($options)) {
            $module = array_shift($options['moduleFilter']);
            $defs = $this->loadFacetDefs($module);
        } else {
            $defs = false;
        }

        foreach ($resultSet->getFacets() as $facetId => $facetData) {

            // module facet is hard coded for now and uses "_type" as its name (core code)
            if ($facetId == '_type') {
                // simulate facet defs
                $modFacetDefs = array(
                    'label' => 'LBL_MODULE_FACET',
                    'type' => 'terms',
                    'ui_type' => 'select',
                );
                $facet = FacetFactory::get('terms');
                if ($parsed = $facet->parseData($facetId, $modFacetDefs, $facetData)) {
                    $result['module_facet'] = $parsed;
                }
                continue;
            }

            // process secondary facets if defs are available
            if (!empty($defs[$facetId])) {
                $facet = FacetFactory::get($defs[$facetId]['type']);
                $facet->setOptions($defs[$facetId]['options']);
                if ($parsed = $facet->parseData($facetId, $defs[$facetId], $facetData)) {
                    $result['secondary_facets'][$facetId] = $parsed;
                }
            }
        }
        return $result;
    }

    /**
     *
     * Parse filter facet result
     * @param array $defs
     * @param array $facet
     * @return array
     */
    protected function parseFacetFilter($defs, $facetData)
    {
        $parsed = array(
            'count' => $facetData['count'],
        );
        return $parsed;
    }

    /**
     *
     * Load facet definitions from enabled FTS module fieldDefs
     * @param string $module
     * @return array
     */
    protected function loadFacetDefs($module)
    {
        if (isset($this->facetDefs[$module])) {
            return $this->facetDefs[$module];
        }
        $this->facetDefs[$module] = array();
        $fieldDefs = SugarSearchEngineMetadataHelper::retrieveFtsEnabledFieldsPerModule($module);
        foreach ($fieldDefs as $fieldName => $fieldDef) {

            // skip non-facet defs
            if (empty($fieldDef['full_text_search']['facet'])) {
                continue;
            }
            $facet = $fieldDef['full_text_search']['facet'];

            // the type needs to be defined to be valid
            if (is_array($facet) && !empty($facet['type'])) {

                // set empty options array if nothing specified
                if (empty($facet['options']) || !is_array($facet['options'])) {
                    $facet['options'] = array();
                }

                // set defaults for ui_type and label
                $facet['ui_type'] = empty($facet['ui_type']) ? 'checkbox' : $facet['ui_type'];
                $facet['label'] = empty($facet['label']) ? 'LBL_FACET_NOT_SET' : $facet['label'];

                $this->facetDefs[$module][$fieldName] = $facet;
            }
        }
        return $this->facetDefs[$module];
    }

    /**
     *
     * Validate moduleFilter in options
     * @param array $options
     * @return boolean
     */
    protected function isOptionsModuleFilterValid($options)
    {
        return (!empty($options['moduleFilter']) && count($options['moduleFilter']) == 1);
    }
}
