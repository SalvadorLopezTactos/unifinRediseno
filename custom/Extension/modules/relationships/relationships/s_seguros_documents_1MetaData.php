<?php
// created: 2020-07-22 13:07:09
$dictionary["s_seguros_documents_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    's_seguros_documents_1' => 
    array (
      'lhs_module' => 'S_seguros',
      'lhs_table' => 's_seguros',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 's_seguros_documents_1_c',
      'join_key_lhs' => 's_seguros_documents_1s_seguros_ida',
      'join_key_rhs' => 's_seguros_documents_1documents_idb',
    ),
  ),
  'table' => 's_seguros_documents_1_c',
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
    's_seguros_documents_1s_seguros_ida' => 
    array (
      'name' => 's_seguros_documents_1s_seguros_ida',
      'type' => 'id',
    ),
    's_seguros_documents_1documents_idb' => 
    array (
      'name' => 's_seguros_documents_1documents_idb',
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
    0 => 
    array (
      'name' => 'idx_s_seguros_documents_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_s_seguros_documents_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 's_seguros_documents_1s_seguros_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_s_seguros_documents_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 's_seguros_documents_1documents_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 's_seguros_documents_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 's_seguros_documents_1documents_idb',
      ),
    ),
  ),
);