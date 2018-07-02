<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
 * ACL-driven visibility
 * @api
 */
class ACLVisibility extends SugarVisibility
{
    /**
     * (non-PHPdoc)
     * @see SugarVisibility::addVisibilityWhere()
     */
    public function addVisibilityWhere(&$query)
    {
        $action = $this->getOption('action', 'list');
        if($this->bean->bean_implements('ACL') && !empty($GLOBALS['current_user']->id) && ACLController::requireOwner($this->bean->module_dir, $action)) {
            $owner_where = $this->bean->getOwnerWhere($GLOBALS['current_user']->id, $this->getOption('table_alias'));
            if(!empty($query)) {
                $query .= " AND $owner_where";
            } else {
                $query = $owner_where;
            }
        }
        return $query;
    }

    public function addVisibilityWhereQuery(SugarQuery $sugarQuery, $options = array()) {
        $where = null;
        $this->addVisibilityWhere($where, $options);
        if(!empty($where)) {
            $sugarQuery->where()->addRaw($where);
        }
        
        return $sugarQuery;
    }

    public function addSseVisibilityFilter($engine, $filter)
    {
        if ($this->bean->bean_implements('ACL') && ACLController::requireOwner($this->bean->module_dir, 'list'))
        {
            if($engine instanceof SugarSearchEngineElastic) {
                $filter->addMust($engine->getOwnerTermFilter());
            }
        }
        return $filter;
    }
}
