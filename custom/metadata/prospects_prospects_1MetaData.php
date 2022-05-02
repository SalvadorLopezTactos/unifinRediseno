<?php
// created: 2022-04-27 23:16:21
$dictionary["prospects_prospects_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'prospects_prospects_1' => 
    array (
      'lhs_module' => 'Prospects',
      'lhs_table' => 'prospects',
      'lhs_key' => 'id',
      'rhs_module' => 'Prospects',
      'rhs_table' => 'prospects',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'prospects_prospects_1_c',
      'join_key_lhs' => 'prospects_prospects_1prospects_ida',
      'join_key_rhs' => 'prospects_prospects_1prospects_idb',
    ),
  ),
  'table' => 'prospects_prospects_1_c',
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
    'prospects_prospects_1prospects_ida' => 
    array (
      'name' => 'prospects_prospects_1prospects_ida',
      'type' => 'id',
    ),
    'prospects_prospects_1prospects_idb' => 
    array (
      'name' => 'prospects_prospects_1prospects_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_prospects_prospects_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_prospects_prospects_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'prospects_prospects_1prospects_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_prospects_prospects_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'prospects_prospects_1prospects_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'prospects_prospects_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'prospects_prospects_1prospects_idb',
      ),
    ),
  ),
);