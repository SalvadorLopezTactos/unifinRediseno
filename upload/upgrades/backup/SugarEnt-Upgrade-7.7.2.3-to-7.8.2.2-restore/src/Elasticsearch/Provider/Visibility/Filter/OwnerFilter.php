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
 * Owner filter
 *
 */
class OwnerFilter implements FilterInterface
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
        $ownerField = $this->getOwnerField($options['bean']);
        $filter = new \Elastica\Filter\Term();
        $filter->setTerm($ownerField, $options['user']->id);
        return $filter;
    }

    /**
     * Determine which field to use as owner field. By default assigned user
     * is being used with fallback to created_by if the first is not defined.
     *
     * @param \SugarBean $bean
     * @return string
     */
    public function getOwnerField(\SugarBean $bean)
    {
        if (isset($bean->field_defs['assigned_user_id'])) {
            return 'assigned_user_id';
        }
        return 'created_by';
    }
}
