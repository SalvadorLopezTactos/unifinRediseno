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

class OwnedByMe
{
    protected  $bean;
    public function __construct($bean)
    {
        $this->bean = $bean;
        $this->module_dir = $this->bean->module_dir;
    }

    public function addVisibilityClause(&$query)
    {
        global $current_user;
        $query .= " INNER JOIN (SELECT id FROM {$this->bean->table_name} WHERE {$this->bean->table_name}.assigned_user_id='{$current_user->id}') mememe ON mememe.id={$this->bean->table_name}.id";
    }

    public function addSseVisibilityFilter($engine, $filter)
    {
        if($engine instanceof SugarSearchEngineElastic) {
            $filter->addMust($engine->getOwnerTermFilter());
        }
        return $filter;
    }

}
