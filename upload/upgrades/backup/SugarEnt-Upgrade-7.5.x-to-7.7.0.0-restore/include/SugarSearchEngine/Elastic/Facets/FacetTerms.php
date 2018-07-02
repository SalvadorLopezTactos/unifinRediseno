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

require_once 'include/SugarSearchEngine/Elastic/Facets/FacetAbstract.php';

/**
 *
 * Facet Terms implementation class
 *
 */
class FacetTerms extends FacetAbstract
{
    /**
     *
     * Ctor
     */
    public function __construct()
    {
        $defaultOpts = array(
            'raw_field' => 'raw',
            'size' => 20,
        );
        parent::__construct($defaultOpts);
    }

    /**
     *
     * @see FacetInterface::getFacet
     */
    public function getFacet($fieldName, \Elastica\Filter\AbstractFilter $mainFilter)
    {
        $rawFieldName = $this->getRawFieldName($fieldName);
        $mainFilter = $this->prepareMainFilter($mainFilter, $rawFieldName);

        $facet = new \Elastica\Facet\Terms($fieldName);
        $facet->setField($rawFieldName);
        $facet->setSize($this->options['size']);
        $facet->setFilter($mainFilter);
        return $facet;
    }

    /**
     *
     * @see FacetInterface::getFilter
     */
    public function getFilter($fieldName, array $values)
    {
        // we use the raw field for the filter
        $rawFieldName = $this->getRawFieldName($fieldName);

        // correct underscores to spaces
        $fixup = function ($value) {
            return str_replace("_", " ", $value);
        };
        $filter = new \Elastica\Filter\Terms($rawFieldName, array_map($fixup, $values));
        return $filter;
    }

    /**
     *
     * @see FacetInterface::parseData()
     */
    public function parseData($facetId, array $facetDefs, array $facetData)
    {
        // only return if there actual results available
        if ($facetData['total'] > 0) {
            $parsed = array(
                'list' => $this->getFacetTermList($facetData['terms']),
            );
            return $this->addBaseFields($facetId, $facetDefs, $parsed);
        }
        return false;
    }

    /**
     *
     * Return facet term details
     * @param array $terms
     * @return array
     */
    protected function getFacetTermList($terms)
    {
        $list = array();
        foreach ($terms as $entry) {
            $list[] = array(
                'filter_id' => str_replace(" ", "_", $entry['term']),
                'label' => $entry['term'],
                'count' => $entry['count'],
            );
        }
        return $list;
    }

    /**
     *
     * Prepare main filter
     * @param \Elastica\Filter\Bool $mainFilter
     * @param string $field
     * @see FacetAbstract::getMainFilters
     */
    protected function prepareMainFilter(\Elastica\Filter\Bool $mainFilter, $field)
    {
        // dont mangle the reference
        $mainFilter = clone($mainFilter);

        $filters = $this->getMainFilters($mainFilter);
        foreach ($filters as $key => $filter) {
            if (!empty($filter['terms'][$field])) {
                $this->log->debug("Removing filter for facet $field -> ".var_export($filter, true));
                unset($filters[$key]);
            }
        }

        return $this->setMainFilters($mainFilter, $filters);
    }

    /**
     *
     * Return raw field name which points to a non-analyzed field
     * @param string $fieldName
     * @return string
     */
    protected function getRawFieldName($fieldName)
    {
        if (empty($this->options['raw_field'])) {
            $rawField = $fieldName;
        } else {
            $rawField = "{$fieldName}.{$this->options['raw_field']}";
        }
        return $rawField;
    }
}
