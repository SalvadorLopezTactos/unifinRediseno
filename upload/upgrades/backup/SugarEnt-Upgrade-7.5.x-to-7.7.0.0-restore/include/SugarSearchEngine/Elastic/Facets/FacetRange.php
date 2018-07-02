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
 * Range facet
 *
 * (see http://www.elasticsearch.org/guide/reference/api/search/facets/range-facet/)
 */
class FacetRange extends FacetAbstract
{
    /**
     *
     * List of supported range defintion in elastic
     * @var array
     */
    protected $elasticSupportedDefs = array(
        'to' => 'to',
        'from' => 'from',
    );

    /**
     * Facet Range constructor
     */
    public function __construct($options = array())
    {
        $defaultOpts = array(
            'ranges' => array()
        );
        parent::__construct(array_merge($defaultOpts, $options));
    }

    /**
     * @see FacetInterface::getFacet
     */
    public function getFacet($fieldName, \Elastica\Filter\AbstractFilter $mainFilter)
    {
        $mainFilter = $this->prepareMainFilter($mainFilter, $fieldName);
        $facet = new \Elastica\Facet\Range($fieldName);
        $facet->setField($fieldName)
            ->setRanges($this->getRangeDefinitions())
            ->setFilter($mainFilter);
        return $facet;
    }

    /**
     * @see FacetInterface::getFilter
     */
    public function getFilter($fieldName, array $values)
    {
        // combine selected filters in an or clause
        $filter = new \Elastica\Filter\Bool();
        $rangeDefs = $this->getRangeDefinitions();
        foreach ($values as $filterId) {
            if (isset($rangeDefs[$filterId])) {
                $rangeFilter = new \Elastica\Filter\Range();
                $rangeFilter->addField($fieldName, $rangeDefs[$filterId]);
                $filter->addShould($rangeFilter);
            }
        }
        return $filter;
    }

    /**
     *
     * @see FacetInterface::parseData()
     */
    public function parseData($facetId, array $facetDefs, array $facetData)
    {
        if (empty($facetData['ranges'])) {
            return false;
        }
        $list = array();
        foreach ($this->options['ranges'] as $id => $range) {
            // only surface facets with hits as selecting a facet with 0 hits will empty the UI
            if ($facetData['ranges'][$id]['count']) {
                $list[] = array(
                    'filter_id' => $id,
                    'label' => translate($range['label']),
                    'count' => $facetData['ranges'][$id]['count'],
                );
            }
        }
        return $this->addBaseFields($facetId, $facetDefs, array('list' => $list));
    }

    /**
     *
     * Filter elastic range definition from options. We need to do this for example
     * to get rid of additional vardefs like the label
     * @return array
     */
    protected function getRangeDefinitions()
    {
        $ranges = array();
        foreach ($this->options['ranges'] as $range) {
            $ranges[] = array_intersect_key($range, $this->elasticSupportedDefs);
        }
        return $ranges;
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
            if (!empty($filter['bool']['should'][0]['range'][$field])) {
                $this->log->debug("Removing filter for facet $field -> ".var_export($filter, true));
                unset($filters[$key]);
            }
        }

        return $this->setMainFilters($mainFilter, $filters);
    }
}
