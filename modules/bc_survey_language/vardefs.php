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

$dictionary['bc_survey_language'] = array(
    'table' => 'bc_survey_language',
    'audited' => true,
    'activity_enabled' => false,
    'duplicate_merge' => true,
    'fields' => array(
        'text_direction' =>
        array(
            'required' => false,
            'name' => 'text_direction',
            'vname' => 'LBL_TEXT_DIRECTION',
            'type' => 'enum',
            'massupdate' => true,
            'default' => 'left_to_right',
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'enabled',
            'duplicate_merge_dom_value' => '1',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'calculated' => false,
            'len' => 100,
            'size' => '20',
            'options' => 'text_direction_list',
            'dependency' => false,
        ),
        'bc_survey_id_c' =>
        array(
            'required' => false,
            'name' => 'bc_survey_id_c',
            'vname' => 'LBL_SURVEY_BC_SURVEY_ID',
            'type' => 'id',
            'massupdate' => false,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'enabled',
            'duplicate_merge_dom_value' => 1,
            'audited' => false,
            'reportable' => false,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'calculated' => false,
            'len' => 36,
            'size' => '20',
        ),
        'survey' =>
        array(
            'required' => false,
            'source' => 'non-db',
            'name' => 'survey',
            'vname' => 'LBL_SURVEY',
            'type' => 'relate',
            'massupdate' => false,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'enabled',
            'duplicate_merge_dom_value' => '1',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'full_text_search' =>
            array(
                'boost' => '0',
                'enabled' => false,
            ),
            'calculated' => false,
            'len' => '255',
            'size' => '20',
            'id_name' => 'bc_survey_id_c',
            'ext2' => 'bc_survey',
            'module' => 'bc_survey',
            'rname' => 'name',
            'quicksearch' => 'enabled',
            'studio' => 'visible',
        ),
        'survey_lang' =>
        array(
            'required' => false,
            'name' => 'survey_lang',
            'vname' => 'LBL_SURVEY_LANG',
            'type' => 'varchar',
            'massupdate' => false,
            'default' => '',
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'enabled',
            'duplicate_merge_dom_value' => '1',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'full_text_search' =>
            array(
                'boost' => '0',
                'enabled' => false,
            ),
            'calculated' => false,
            'len' => '255',
            'size' => '20',
        ),
        'status' =>
        array(
            'required' => false,
            'name' => 'status',
            'vname' => 'LBL_STATUS',
            'type' => 'enum',
            'massupdate' => true,
            'default' => 'enabled',
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'enabled',
            'duplicate_merge_dom_value' => '1',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'calculated' => false,
            'len' => 100,
            'size' => '20',
            'options' => 'availability_status_list',
            'dependency' => false,
        ),
        'translated' =>
        array(
            'required' => false,
            'name' => 'translated',
            'vname' => 'LBL_TRANSLATED',
            'type' => 'bool',
            'massupdate' => 0,
            'default' => '0',
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'studio' => 'visible',
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
VardefManager::createVardef('bc_survey_language', 'bc_survey_language', array('basic', 'team_security', 'assignable'));
