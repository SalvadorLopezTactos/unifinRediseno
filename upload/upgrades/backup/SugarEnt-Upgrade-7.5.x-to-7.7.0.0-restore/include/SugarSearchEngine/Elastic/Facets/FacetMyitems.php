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

require_once 'include/SugarSearchEngine/Elastic/Facets/FacetFilter.php';

/**
 *
 * Basic Sugar "my_items" facet ("assigned to me" docs)
 */
class FacetMyitems extends FacetFilter
{
    /**
     * @var string
     */
    protected $userId;

    /**
     *
     * Ctor
     */
    public function __construct($options = array())
    {
        $this->userId = $GLOBALS['current_user']->id;
        $defaultOpts = array();
        parent::__construct(array_merge($defaultOpts, $options));
    }

    /**
     *
     * MyItems filter
     * @see FacetFilter
     */
    protected function getBoolFilter()
    {
        $docOwner = new \Elastica\Filter\Term(array('doc_owner' => $this->userId));
        $filter = new \Elastica\Filter\Bool();
        $filter->addShould($docOwner);
        return $filter;
    }
}
