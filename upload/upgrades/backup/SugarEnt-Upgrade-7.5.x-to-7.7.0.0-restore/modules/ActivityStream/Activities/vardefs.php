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

$dictionary['Activity'] = array(
    'table' => 'activities',
    'fields' => array(
        // Set unnecessary fields from Basic to non-required/non-db.
        'name' => array(
            'name' => 'name',
            'type' => 'varchar',
            'required' => false,
            'source' => 'non-db',
        ),

        'description' => array(
            'name' => 'description',
            'type' => 'varchar',
            'required' => false,
            'source' => 'non-db',
        ),

        // Add relationship fields.
        'comments' => array(
            'name' => 'comments',
            'type' => 'link',
            'relationship' => 'comments',
            'link_type' => 'many',
            'module' => 'Comments',
            'bean_name' => 'Comment',
            'source' => 'non-db',
        ),

        'activities_users' => array(
            'name' => 'activities_users',
            'type' => 'link',
            'relationship' => 'activities_users',
            'link_type' => 'many',
            'module' => 'Users',
            'bean_name' => 'User',
            'source' => 'non-db',
        ),

        'activities_teams' => array(
            'name' => 'activities_teams',
            'type' => 'link',
            'relationship' => 'activities_teams',
            'link_type' => 'many',
            'module' => 'Users',
            'bean_name' => 'User',
            'source' => 'non-db',
        ),

        // Relationships for M2M related beans.
        'contacts' => array(
            'name' => 'contacts',
            'type' => 'link',
            'relationship' => 'contact_activities',
            'vname' => 'LBL_LIST_CONTACT_NAME',
            'source' => 'non-db',
        ),
        'cases' => array(
            'name' => 'cases',
            'type' => 'link',
            'relationship' => 'case_activities',
            'vname' => 'LBL_CASES',
            'source' => 'non-db',
        ),
        'accounts' => array(
            'name' => 'accounts',
            'type' => 'link',
            'relationship' => 'account_activities',
            'source' => 'non-db',
            'vname' => 'LBL_ACCOUNTS',
        ),
        'opportunities' => array(
            'name' => 'opportunities',
            'type' => 'link',
            'relationship' => 'opportunity_activities',
            'source' => 'non-db',
            'vname' => 'LBL_OPPORTUNITIES',
        ),
        'leads' => array(
            'name' => 'leads',
            'type' => 'link',
            'relationship' => 'lead_activities',
            'source' => 'non-db',
            'vname' => 'LBL_LEADS',
        ),
        'products' => array(
            'name' => 'products',
            'type' => 'link',
            'relationship' => 'product_activities',
            'source' => 'non-db',
            'vname' => 'LBL_PRODUCTS',
        ),
        'revenuelineitems' => array(
            'name' => 'revenuelineitems',
            'type' => 'link',
            'relationship' => 'revenuelineitem_activities',
            'source' => 'non-db',
            'vname' => 'LBL_REVENUELINEITEMS',
        ),
        'quotes' => array(
            'name' => 'quotes',
            'type' => 'link',
            'relationship' => 'quote_activities',
            'vname' => 'LBL_QUOTES',
            'source' => 'non-db',
        ),
        'contracts' => array(
            'name' => 'contracts',
            'type' => 'link',
            'relationship' => 'contract_activities',
            'source' => 'non-db',
            'vname' => 'LBL_CONTRACTS',
        ),
        'bugs' => array(
            'name' => 'bugs',
            'type' => 'link',
            'relationship' => 'bug_activities',
            'source' => 'non-db',
            'vname' => 'LBL_BUGS',
        ),
        'meetings' => array(
            'name' => 'meetings',
            'type' => 'link',
            'relationship' => 'meeting_activities',
            'source' => 'non-db',
            'vname' => 'LBL_MEETINGS',
        ),
        'calls' => array(
            'name' => 'calls',
            'type' => 'link',
            'relationship' => 'call_activities',
            'source' => 'non-db',
            'vname' => 'LBL_CALLS',
        ),
        'tasks' => array(
            'name' => 'tasks',
            'type' => 'link',
            'relationship' => 'task_activities',
            'source' => 'non-db',
            'vname' => 'LBL_TASKS',
        ),
        'notes' => array(
            'name'         => 'notes',
            'type'         => 'link',
            'relationship' => 'note_activities',
            'source'       => 'non-db',
            'vname'        => 'LBL_NOTES',
        ),

        // Add table columns.
        'parent_id' => array(
            'name'     => 'parent_id',
            'type'     => 'id',
            'len'      => 36,
        ),

        'parent_type' => array(
            'name' => 'parent_type',
            'type' => 'varchar',
            'len'  => 100,
        ),

        'activity_type' => array(
            'name' => 'activity_type',
            'type' => 'varchar',
            'len'  => 100,
            'required' => true,
        ),

        'data' => array(
            'name' => 'data',
            'type' => 'json',
            'dbType' => 'longtext',
            'required' => true,
        ),

        'comment_count' => array(
            'name' => 'comment_count',
            'type' => 'int',
            'required' => true,
            'default' => 0,
        ),

        'last_comment' => array(
            'name' => 'last_comment',
            'type' => 'json',
            'dbType' => 'longtext',
            'required' => true,
        ),
    ),
    'indices' => array(
        array(
            'name' => 'activity_records',
            'type' => 'index',
            'fields' => array('parent_type', 'parent_id'),
        ),
    ),
    'relationships' => array(
        'comments' => array(
            'lhs_module' => 'Activities',
            'lhs_table' => 'activities',
            'lhs_key' => 'id',
            'rhs_module' => 'Comments',
            'rhs_table' => 'comments',
            'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many',
        ),
    ),
);

VardefManager::createVardef('ActivityStream/Activities', 'Activity', array('basic'));

//Need to override the relationship because lhs_module is populed with ActivityStream/Activities instead of module name Activities
$dictionary['Activity']['relationships']['activity_activities']['lhs_module'] = 'Activities';
