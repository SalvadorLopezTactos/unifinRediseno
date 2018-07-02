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

namespace Sugarcrm\Sugarcrm\Elasticsearch\Provider\Visibility\Filter;

use Sugarcrm\Sugarcrm\Elasticsearch\Provider\Visibility\Visibility;

/**
 *
 * Knowledge Base status filter
 *
 */
class KBStatusFilter implements FilterInterface
{
    // Awaiting PHP 5.4+ support
    //use FilterTrait;

    ///// Start trait

    /**
     * @var Visibility
     */
    protected $provider;

    /**
     * {@inheritdoc}
     */
    public function setProvider(Visibility $provider)
    {
        $this->provider = $provider;
    }

    ///// End trait

    /**
     * {@inheritdoc}
     */
    public function buildFilter(array $options = array())
    {
        return new \Elastica\Filter\Terms('status', $options['published_statuses']);
    }
}
