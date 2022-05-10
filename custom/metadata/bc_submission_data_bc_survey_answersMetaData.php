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
$dictionary["bc_submission_data_bc_survey_answers"] = array(
    'true_relationship_type' => 'one-to-many',
    'relationships' =>
    array(
        'bc_submission_data_bc_survey_answers' =>
        array(
            'lhs_module' => 'bc_survey_answers',
            'lhs_table' => 'bc_survey_answers',
            'lhs_key' => 'id',
            'rhs_module' => 'bc_submission_data',
            'rhs_table' => 'bc_submission_data',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'bc_submission_data_bc_survey_answers_c',
            'join_key_lhs' => 'bc_submission_data_bc_survey_answersbc_survey_answers_ida',
            'join_key_rhs' => 'bc_submission_data_bc_survey_answersbc_submission_data_idb',
        ),
    ),
    'table' => 'bc_submission_data_bc_survey_answers_c',
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
        'bc_submission_data_bc_survey_answersbc_survey_answers_ida' =>
        array(
            'name' => 'bc_submission_data_bc_survey_answersbc_survey_answers_ida',
            'type' => 'varchar',
            'len' => 36,
        ),
        'bc_submission_data_bc_survey_answersbc_submission_data_idb' =>
        array(
            'name' => 'bc_submission_data_bc_survey_answersbc_submission_data_idb',
            'type' => 'varchar',
            'len' => 36,
        ),
    ),
    'indices' =>
    array(
        
        array(
            'name' => 'bc_submission_data_bc_survey_answersspk',
            'type' => 'primary',
            'fields' =>
            array(
                0 => 'id',
            ),
        ),
        
        array(
            'name' => 'bc_submission_data_bc_survey_answers_ida1',
            'type' => 'index',
            'fields' =>
            array(
                0 => 'bc_submission_data_bc_survey_answersbc_survey_answers_ida',
            ),
        ),
        
        array(
            'name' => 'bc_submission_data_bc_survey_answers_alt',
            'type' => 'alternate_key',
            'fields' =>
            array(
                0 => 'bc_submission_data_bc_survey_answersbc_submission_data_idb',
            ),
        ),
    ),
);
