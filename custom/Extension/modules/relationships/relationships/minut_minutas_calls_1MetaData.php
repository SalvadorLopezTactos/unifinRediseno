<?php
// created: 2019-02-12 14:01:34
$dictionary["minut_minutas_calls_1"] = array (
  'true_relationship_type' => 'one-to-one',
  'from_studio' => true,
  'relationships' => 
  array (
    'minut_minutas_calls_1' => 
    array (
      'lhs_module' => 'minut_Minutas',
      'lhs_table' => 'minut_minutas',
      'lhs_key' => 'id',
      'rhs_module' => 'Calls',
      'rhs_table' => 'calls',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'minut_minutas_calls_1_c',
      'join_key_lhs' => 'minut_minutas_calls_1minut_minutas_ida',
      'join_key_rhs' => 'minut_minutas_calls_1calls_idb',
    ),
  ),
  'table' => 'minut_minutas_calls_1_c',
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
    'minut_minutas_calls_1minut_minutas_ida' => 
    array (
      'name' => 'minut_minutas_calls_1minut_minutas_ida',
      'type' => 'id',
    ),
    'minut_minutas_calls_1calls_idb' => 
    array (
      'name' => 'minut_minutas_calls_1calls_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_minut_minutas_calls_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_minut_minutas_calls_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'minut_minutas_calls_1minut_minutas_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_minut_minutas_calls_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'minut_minutas_calls_1calls_idb',
        1 => 'deleted',
      ),
    ),
  ),
);