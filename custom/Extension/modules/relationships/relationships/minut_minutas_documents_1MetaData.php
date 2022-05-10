<?php
// created: 2018-10-22 12:04:28
$dictionary["minut_minutas_documents_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'minut_minutas_documents_1' => 
    array (
      'lhs_module' => 'minut_Minutas',
      'lhs_table' => 'minut_minutas',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'minut_minutas_documents_1_c',
      'join_key_lhs' => 'minut_minutas_documents_1minut_minutas_ida',
      'join_key_rhs' => 'minut_minutas_documents_1documents_idb',
    ),
  ),
  'table' => 'minut_minutas_documents_1_c',
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
    'minut_minutas_documents_1minut_minutas_ida' => 
    array (
      'name' => 'minut_minutas_documents_1minut_minutas_ida',
      'type' => 'id',
    ),
    'minut_minutas_documents_1documents_idb' => 
    array (
      'name' => 'minut_minutas_documents_1documents_idb',
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
      'name' => 'idx_minut_minutas_documents_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_minut_minutas_documents_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'minut_minutas_documents_1minut_minutas_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_minut_minutas_documents_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'minut_minutas_documents_1documents_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'minut_minutas_documents_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'minut_minutas_documents_1documents_idb',
      ),
    ),
  ),
);