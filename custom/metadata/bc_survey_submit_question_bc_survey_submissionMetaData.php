<?php
// created: 2017-07-28 12:05:16
$dictionary["bc_survey_submit_question_bc_survey_submission"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'bc_survey_submit_question_bc_survey_submission' => 
    array (
      'lhs_module' => 'bc_survey_submission',
      'lhs_table' => 'bc_survey_submission',
      'lhs_key' => 'id',
      'rhs_module' => 'bc_survey_submit_question',
      'rhs_table' => 'bc_survey_submit_question',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'bc_survey_submit_question_bc_survey_submission_c',
      'join_key_lhs' => 'bc_survey_9f7bmission_ida',
      'join_key_rhs' => 'bc_survey_8829uestion_idb',
    ),
  ),
  'table' => 'bc_survey_submit_question_bc_survey_submission_c',
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
    'bc_survey_9f7bmission_ida' => 
    array (
      'name' => 'bc_survey_9f7bmission_ida',
      'type' => 'id',
    ),
    'bc_survey_8829uestion_idb' => 
    array (
      'name' => 'bc_survey_8829uestion_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_bc_survey_submit_question_bc_survey_submission_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_bc_survey_submit_question_bc_survey_submission_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'bc_survey_9f7bmission_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_bc_survey_submit_question_bc_survey_submission_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'bc_survey_8829uestion_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'bc_survey_submit_question_bc_survey_submission_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'bc_survey_8829uestion_idb',
      ),
    ),
  ),
);