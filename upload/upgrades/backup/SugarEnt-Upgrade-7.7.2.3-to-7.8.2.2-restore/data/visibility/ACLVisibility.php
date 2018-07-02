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

use Sugarcrm\Sugarcrm\Elasticsearch\Provider\Visibility\StrategyInterface;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\Visibility\Visibility;
use Sugarcrm\Sugarcrm\Elasticsearch\Analysis\AnalysisBuilder;
use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\Mapping;
use Sugarcrm\Sugarcrm\Elasticsearch\Adapter\Document;

/**
 * ACL-driven visibility
 * @api
 */
class ACLVisibility extends SugarVisibility implements StrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function addVisibilityWhere(&$query)
    {
        $action = $this->getOption('action', 'list');
        if ($this->bean->bean_implements('ACL') &&
            !empty($GLOBALS['current_user']->id) &&
            ACLController::requireOwner($this->bean->module_dir, $action))
        {
            $parts = array(
                $query,
                $this->bean->getOwnerWhere($GLOBALS['current_user']->id, $this->getOption('table_alias')),
            );
            $parts = array_filter($parts);
            $query = implode(' AND ', $parts);
        }
        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function addVisibilityWhereQuery(SugarQuery $sugarQuery, $options = array()) {
        $where = null;
        $this->addVisibilityWhere($where, $options);
        if (!empty($where)) {
            $sugarQuery->where()->addRaw($where);
        }

        return $sugarQuery;
    }

    /**
     * {@inheritdoc}
     */
    public function elasticBuildAnalysis(AnalysisBuilder $analysisBuilder, Visibility $provider)
    {
        // no special analyzers needed
    }

    /**
     * {@inheritdoc}
     */
    public function elasticBuildMapping(Mapping $mapping, Visibility $provider)
    {
        $ownerField = $provider->getFilter('Owner')->getOwnerField($this->bean);
        $mapping->addNotAnalyzedField($ownerField);
    }

    /**
     * {@inheritdoc}
     */
    public function elasticProcessDocumentPreIndex(Document $document, SugarBean $bean, Visibility $provider)
    {
        // no special processing needed
    }

    /**
     * {@inheritdoc}
     */
    public function elasticGetBeanIndexFields($module, Visibility $provider)
    {
        // retrieve the owner field directly from the bean
        $ownerField = $provider->getFilter('Owner')->getOwnerField($this->bean);
        return array($ownerField => 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function elasticAddFilters(\User $user, \Elastica\Filter\Bool $filter, Visibility $provider)
    {
        if ($this->bean->bean_implements('ACL') && ACLController::requireOwner($this->bean->module_dir, 'list')) {
            $options = array(
                'bean' => $this->bean,
                'user' => $user,
            );
            $filter->addMust($provider->createFilter('Owner', $options));
        }
    }
}
