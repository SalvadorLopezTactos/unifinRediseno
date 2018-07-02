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

$dictionary['Dashboard'] = array(
    'table' => 'dashboards',
    'fields' => array(
        'dashboard_module' => array(
            'required' => false,
            'name' => 'dashboard_module',
            'vname' => 'LBL_DASHBOARD_MODULE',
            'type' => 'varchar',
            'dbType' => 'varchar',
            'len' => 100,
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => true,
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'calculated' => false,
        ),
        'view_name' => array(
            'required' => false,
            'name' => 'view_name',
            'vname' => 'LBL_VIEW',
            'type' => 'varchar',
            'dbType' => 'varchar',
            'len' => 100,
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => true,
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'calculated' => false,
        ),
        'metadata' => array(
            'required' => false,
            'name' => 'metadata',
            'vname' => 'LBL_METADATA',
            'type' => 'json',
            'dbType' => 'text',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => true,
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'calculated' => false,
        ),
        'dashboard_type' => array(
            'name' => 'dashboard_type',
            'vname' => 'LBL_DASHBOARD_TYPE',
            'type' => 'varchar',
            'len' => '100',
            'comment' => 'The type of dashboard: dashboard, help-dashboard, etc',
            'default' => 'dashboard'
        ),
    ),
    'indices' => array(
        array(
            'name' => 'user_module_view',
            'type' => 'index',
            'fields' => array('assigned_user_id', 'dashboard_module', 'view_name')
        ),
    ),
    'relationships' =>
        array(),
);

if (!class_exists('VardefManager')) {
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('Dashboards', 'Dashboard', array('basic', 'assignable'));
