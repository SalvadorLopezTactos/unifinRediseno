<?php
// created: 2017-07-28 12:05:16
$dictionary["bc_survey_submit_question_bc_survey_answers"] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'bc_survey_submit_question_bc_survey_answers' => 
    array (
      'lhs_module' => 'bc_survey_submit_question',
      'lhs_table' => 'bc_survey_submit_question',
      'lhs_key' => 'id',
      'rhs_module' => 'bc_survey_answers',
      'rhs_table' => 'bc_survey_answers',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'bc_survey_submit_question_bc_survey_answers_c',
      'join_key_lhs' => 'bc_survey_c9f6uestion_ida',
      'join_key_rhs' => 'bc_survey_submit_question_bc_survey_answersbc_survey_answers_idb',
    ),
  ),
  'table' => 'bc_survey_submit_question_bc_survey_answers_c',
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
    'bc_survey_c9f6uestion_ida' => 
    array (
      'name' => 'bc_survey_c9f6uestion_ida',
      'type' => 'id',
    ),
    'bc_survey_submit_question_bc_survey_answersbc_survey_answers_idb' => 
    array (
      'name' => 'bc_survey_submit_question_bc_survey_answersbc_survey_answers_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_bc_survey_submit_question_bc_survey_answers_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_bc_survey_submit_question_bc_survey_answers_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'bc_survey_c9f6uestion_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_bc_survey_submit_question_bc_survey_answers_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'bc_survey_submit_question_bc_survey_answersbc_survey_answers_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'bc_survey_submit_question_bc_survey_answers_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'bc_survey_c9f6uestion_ida',
        1 => 'bc_survey_submit_question_bc_survey_answersbc_survey_answers_idb',
      ),
    ),
  ),
);