<?php

/**
 * The file used to manage vardefs for Automizer conditions
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */

$dictionary['bc_automizer_condition'] = array(
    'table' => 'bc_automizer_condition',
    'audited' => true,
    'activity_enabled' => false,
    'duplicate_merge' => true,
    'fields' => array(
        'condition_module' =>
        array(
            'required' => false,
            'name' => 'condition_module',
            'vname' => 'LBL_CONDITION_MODULE',
            'type' => 'enum',
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
            'len' => 255,
            'dependency' => false,
        ),
        'filter_by' =>
        array(
            'required' => false,
            'name' => 'filter_by',
            'vname' => 'LBL_FILTER_BY',
            'type' => 'enum',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'default' => 'any_related',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => 255,
            'options' => 'filter_by',
            'dependency' => false,
        ),
        'condition_field' =>
        array(
            'required' => false,
            'name' => 'condition_field',
            'vname' => 'LBL_FIELD',
            'type' => 'enum',
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
            'len' => 255,
            'dependency' => false,
        ),
        'condition_operator' =>
        array(
            'required' => false,
            'name' => 'condition_operator',
            'vname' => 'LBL_OPERATOR',
            'type' => 'enum',
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
            'options' => 'operator_list',
            'len' => 255,
            'dependency' => false,
        ),
        'value_type' =>
        array(
            'required' => false,
            'name' => 'value_type',
            'vname' => 'LBL_VALUE_TYPE',
            'type' => 'enum',
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
            'options' => 'value_type_list',
            'len' => 255,
            'dependency' => false,
        ),
        'compare_value' =>
        array(
            'required' => false,
            'name' => 'compare_value',
            'vname' => 'LBL_VALUE',
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
            'dbType' => 'text',
            'dependency' => false,
        ),
        'condition_order' =>
        array(
            'name' => 'condition_order',
            'vname' => 'LBL_CONDITION_ORDER',
            'type' => 'int',
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
            'len' => 255,
            'dependency' => false,
        ),
    ),
    'relationships' => array(
    ),
    'optimistic_locking' => true,
    'unified_search' => true,
);

if (!class_exists('VardefManager')) {
    require_once 'include/SugarObjects/VardefManager.php';
}
VardefManager::createVardef('bc_automizer_condition', 'bc_automizer_condition', array('basic', 'team_security', 'assignable'));
