<?php

/**
 * The file used to handle fields definition for survey automizer
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$dictionary['bc_survey_automizer'] = array(
    'table' => 'bc_survey_automizer',
    'audited' => true,
    'activity_enabled' => false,
    'duplicate_merge' => true,
    'fields' => array(
        'execution_occurs' =>
        array(
            'required' => false,
            'name' => 'execution_occurs',
            'vname' => 'LBL_EXECUTION_OCCURS',
            'type' => 'enum',
            'massupdate' => 0,
            'default' => 'when_record_saved',
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
            'options' => 'execution_occurs_list',
            'dependency' => false,
        ),
        'target_module' =>
        array(
            'required' => true,
            'name' => 'target_module',
            'vname' => 'LBL_TARGET_MODULE',
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
            'function' => array('name' => 'target_module_list', 'returns' => '', 'include' => 'custom/biz/function/get_survey_automizer_fields.php'),
            'dependency' => false,
        ),
        'status' =>
        array(
            'required' => false,
            'name' => 'status',
            'vname' => 'LBL_STATUS',
            'type' => 'enum',
            'massupdate' => 0,
            'default' => 'active',
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
            'options' => 'automation_status_list',
            'dependency' => false,
        ),
        'applied_to' =>
        array(
            'required' => false,
            'name' => 'applied_to',
            'vname' => 'LBL_APPLIED_TO',
            'type' => 'enum',
            'massupdate' => 0,
            'default' => 'new_and_updated_records',
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
            'options' => 'applied_to_list',
            'dependency' => false,
        ),
    ),
    'acls' => array(
        'SugarACLDeveloperForTarget' => array(
            'targetModuleField' => 'rst_module',
            'allowUserRead' => false,
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
VardefManager::createVardef('bc_survey_automizer', 'bc_survey_automizer', array('basic', 'team_security', 'assignable'));
