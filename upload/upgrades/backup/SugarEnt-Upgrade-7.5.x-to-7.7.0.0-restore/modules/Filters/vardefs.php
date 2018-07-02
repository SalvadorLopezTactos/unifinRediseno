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

$dictionary['Filters'] = array(
    'table' => 'filters',
    'duplicate_merge' => true,
    'fields' => array(
        'filter_definition' => array(
            'required' => true,
            'name' => 'filter_definition',
            'vname' => 'LBL_FILTER_DEFINITION',
            'dbType' => 'longtext',
            'type' => 'json',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'calculated' => false,
            'studio' => 'visible',
        ),
        'filter_template' => array(
            'required' => true,
            'name' => 'filter_template',
            'vname' => 'LBL_FILTER_TEMPLATE',
            'dbType' => 'longtext',
            'type' => 'json',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'calculated' => false,
            'studio' => 'visible',
        ),
        'module_name' => array(
            'required' => true,
            'name' => 'module_name',
            'vname' => 'LBL_MODULE_NAME',
            'dbType' => 'varchar',
            'len' => 100,
            'type' => 'text',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'calculated' => false,
        ),
    ),
    'relationships' => array(),
    'acls' => array('SugarACLFilters' => true, 'SugarACLStatic' => false),
    'optimistic_locking' => true,
);

if (!class_exists('VardefManager')) {
    require_once 'include/SugarObjects/VardefManager.php';
}

VardefManager::createVardef(
    'Filters',
    'Filters',
    array('basic', 'team_security', 'assignable')
);
