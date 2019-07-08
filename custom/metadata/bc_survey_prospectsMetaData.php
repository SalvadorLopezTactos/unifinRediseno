<?php

/**
 * The file used to handle relationship for survey 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$dictionary["bc_survey_prospects"] = array(
    'true_relationship_type' => 'many-to-many',
    'relationships' =>
    array(
        'bc_survey_prospects' =>
        array(
            'lhs_module' => 'bc_survey',
            'lhs_table' => 'bc_survey',
            'lhs_key' => 'id',
            'rhs_module' => 'Prospects',
            'rhs_table' => 'prospects',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'bc_survey_prospects_c',
            'join_key_lhs' => 'bc_survey_prospectsbc_survey_ida',
            'join_key_rhs' => 'bc_survey_prospectsprospects_idb',
        ),
    ),
    'table' => 'bc_survey_prospects_c',
    'fields' =>
    array(
        'id' =>
        array(
            'name' => 'id',
            'type' => 'varchar',
            'len' => 36,
        ),
        'date_modified' =>
        array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),
        'deleted' =>
        array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => true,
        ),
        'bc_survey_prospectsbc_survey_ida' =>
        array(
            'name' => 'bc_survey_prospectsbc_survey_ida',
            'type' => 'varchar',
            'len' => 36,
        ),
        'bc_survey_prospectsprospects_idb' =>
        array(
            'name' => 'bc_survey_prospectsprospects_idb',
            'type' => 'varchar',
            'len' => 36,
        ),
    ),
    'indices' =>
    array(
        
        array(
            'name' => 'bc_survey_prospectsspk',
            'type' => 'primary',
            'fields' =>
            array(
                0 => 'id',
            ),
        ),
        
        array(
            'name' => 'bc_survey_prospects_alt',
            'type' => 'alternate_key',
            'fields' =>
            array(
                0 => 'bc_survey_prospectsbc_survey_ida',
                1 => 'bc_survey_prospectsprospects_idb',
            ),
        ),
    ),
);
