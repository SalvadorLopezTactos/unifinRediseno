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

namespace Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch;

use Sugarcrm\Sugarcrm\Elasticsearch\Query\QueryBuilder;

/**
 *
 * SearchFields builder
 *
 */
class SearchFields
{
    /**
     * @var Booster
     */
    protected $booster;

    /**
     * List of search fields
     * @var array
     */
    protected $searchFields = array();

    /**
     * Ctor
     * @param Booster $booster
     */
    public function __construct(Booster $booster = null)
    {
        $this->booster = $booster;
    }

    /**
     * Return search fields
     * @return array
     */
    public function getSearchFields()
    {
        return $this->searchFields;
    }

    /**
     * Add search field to the stack
     * @param string $module Module name
     * @param array $path Field path
     * @param array $defs Field definitions
     * @param string $weightId Identifier to apply weighted boost
     * @return string
     */
    public function addSearchField($module, array $path, array $defs, $weightId)
    {
        $searchField = implode(QueryBuilder::FIELD_SEP, $path);
        if ($this->booster) {
            $searchField = $this->booster->getBoostedField($searchField, $defs, $weightId);
        }
        $this->searchFields[] = $searchField;
        return $searchField;
    }
}
