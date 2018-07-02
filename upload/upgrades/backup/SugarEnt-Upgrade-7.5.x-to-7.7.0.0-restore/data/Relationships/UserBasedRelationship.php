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
 * Represents a relationship where part of the data is substituted by the current_user_id
 * @api
 */
class UserBasedRelationship extends M2MRelationship
{
    public $type = "user-based";
    
    public function __construct($def)
    {
        $this->userField = $def['user_field'];
        
        parent::__construct($def);
    }

    protected function buildSugarQueryRoleWhere($sugar_query, $table = "", $ignore_role_filter = false)
    {
        $sugar_query = parent::buildSugarQueryRoleWhere($sugar_query, $table, $ignore_role_filter);
        
        $sugar_query->join[$table]->on()->equals($table.'.'.$this->userField,$GLOBALS['current_user']->id);

        return $sugar_query;
    }
}

