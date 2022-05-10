<?php
// created: 2017-07-18 15:19:31
$dictionary["bc_survey_questions_bc_survey_submit_question_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'bc_survey_questions_bc_survey_submit_question_1' => 
    array (
      'lhs_module' => 'bc_survey_questions',
      'lhs_table' => 'bc_survey_questions',
      'lhs_key' => 'id',
      'rhs_module' => 'bc_survey_submit_question',
      'rhs_table' => 'bc_survey_submit_question',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'bc_survey_questions_bc_survey_submit_question_1_c',
      'join_key_lhs' => 'bc_survey_6a25estions_ida',
      'join_key_rhs' => 'bc_survey_bb7auestion_idb',
    ),
  ),
  'table' => 'bc_survey_questions_bc_survey_submit_question_1_c',
  'fields' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'id',
    ),
    'date_modified' => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    'deleted' => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'default' => 0,
    ),
    'bc_survey_6a25estions_ida' => 
    array (
      'name' => 'bc_survey_6a25estions_ida',
      'type' => 'id',
    ),
    'bc_survey_bb7auestion_idb' => 
    array (
      'name' => 'bc_survey_bb7auestion_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_bc_survey_questions_bc_survey_submit_question_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_bc_survey_questions_bc_survey_submit_question_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'bc_survey_6a25estions_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_bc_survey_questions_bc_survey_submit_question_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'bc_survey_bb7auestion_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'bc_survey_questions_bc_survey_submit_question_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'bc_survey_bb7auestion_idb',
      ),
    ),
  ),
);