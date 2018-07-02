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
 * Abstract Facet Filter implementation class for custom filter types
 * based on filter facets. Do not confuse the usage of this filter facet
 * implementation with facet filters !
 *
 * (see http://www.elasticsearch.org/guide/reference/api/search/facets/filter-facet/)
 */
abstract class FacetFilter extends FacetAbstract
{
    /**
     *
     * Ctor
     */
    public function __construct($options = array())
    {
        $defaultOpts = array();
        parent::__construct(array_merge($defaultOpts, $options));
    }

    /**
     *
     * @see FacetInterface::getFacet
     */
    public function getFacet($fieldName, \Elastica\Filter\AbstractFilter $mainFilter)
    {
        // encapsulate mainFilter and the facet filter
        $master = new \Elastica\Filter\Bool();
        $master->addMust($mainFilter);
        $master->addMust($this->getBoolFilter());

        // attach master filter to facet
        $facet = new \Elastica\Facet\Filter($fieldName);
        $facet->setFilter($master);
        return $facet;
    }

    /**
     *
     * @see FacetInterface::getFilter
     */
    public function getFilter($fieldName, array $values)
    {
        return $this->getBoolFilter();
    }

    /**
     *
     * @see FacetInterface::parseData()
     */
    public function parseData($facetId, array $facetDefs, array $facetData)
    {
        if (isset($facetData['count'])) {
            $parsed = array(
                'count' => $facetData['count'],
            );
            return $this->addBaseFields($facetId, $facetDefs, $parsed);
        }
        return false;
    }

    /**
     * To be defined by extension class
     * @return \Elastica\Filter\Bool
     */
    abstract protected function getBoolFilter();
}
