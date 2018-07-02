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
 *
 * Facet interface
 *
 */
interface FacetInterface
{
    /**
     *
     * Returns an Elastica Facet object
     * @param  string                          $fieldName
     * @param  \Elastica\Filter\AbstractFilter $mainFilter
     * @return \Elastica\Facet\AbstractFacet
     */
    public function getFacet($fieldName, \Elastica\Filter\AbstractFilter $mainFilter);

    /**
     *
     * Returns an Elastica Filter object
     * @param  string $fieldName
     * @param  array  $values
     * @return \Elastica\Filter\AbstractFilter
     */
    public function getFilter($fieldName, array $values);

    /**
     *
     * Parse facet results
     * @param  string $id
     * @param  array  $defs
     * @param  array  $data
     * @return array
     */
    public function parseData($facetId, array $facetDefs, array $facetData);
}
