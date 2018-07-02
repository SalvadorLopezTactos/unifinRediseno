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

namespace Sugarcrm\Sugarcrm\Elasticsearch\Query;

/**
 *
 * The match all query without search terms
 *
 */
class MatchAllQuery implements QueryInterface
{
    /**
     * Create a match all query
     * @return \Elastica\Query\MatchAll
     */
    public function build()
    {
        return new \Elastica\Query\MatchAll();
    }
}
