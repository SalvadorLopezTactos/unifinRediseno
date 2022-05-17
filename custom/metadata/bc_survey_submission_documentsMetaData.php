<?php
// created: 2017-04-07 05:09:27
$dictionary["bc_survey_submission_documents"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'bc_survey_submission_documents' => 
    array (
      'lhs_module' => 'bc_survey_submission',
      'lhs_table' => 'bc_survey_submission',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'bc_survey_submission_documents_c',
      'join_key_lhs' => 'bc_survey_submission_documentsbc_survey_submission_ida',
      'join_key_rhs' => 'bc_survey_submission_documentsdocuments_idb',
    ),
  ),
  'table' => 'bc_survey_submission_documents_c',
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
    'bc_survey_submission_documentsbc_survey_submission_ida' => 
    array (
      'name' => 'bc_survey_submission_documentsbc_survey_submission_ida',
      'type' => 'id',
    ),
    'bc_survey_submission_documentsdocuments_idb' => 
    array (
      'name' => 'bc_survey_submission_documentsdocuments_idb',
      'type' => 'id',
    ),
    'document_revision_id' => 
    array (
      'name' => 'document_revision_id',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    
    array (
      'name' => 'idx_bc_survey_submission_documents_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
     
    array (
      'name' => 'idx_bc_survey_submission_documents_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'bc_survey_submission_documentsbc_survey_submission_ida',
        1 => 'deleted',
      ),
    ),
    
    array (
      'name' => 'idx_bc_survey_submission_documents_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'bc_survey_submission_documentsdocuments_idb',
        1 => 'deleted',
      ),
    ),
    
    array (
      'name' => 'bc_survey_submission_documents_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'bc_survey_submission_documentsdocuments_idb',
      ),
    ),
  ),
);