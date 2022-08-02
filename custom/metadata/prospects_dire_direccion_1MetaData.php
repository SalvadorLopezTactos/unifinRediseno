<?php
// created: 2022-05-03 01:30:00
$dictionary["prospects_dire_direccion_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'prospects_dire_direccion_1' => 
    array (
      'lhs_module' => 'Prospects',
      'lhs_table' => 'prospects',
      'lhs_key' => 'id',
      'rhs_module' => 'dire_Direccion',
      'rhs_table' => 'dire_direccion',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'prospects_dire_direccion_1_c',
      'join_key_lhs' => 'prospects_dire_direccion_1prospects_ida',
      'join_key_rhs' => 'prospects_dire_direccion_1dire_direccion_idb',
    ),
  ),
  'table' => 'prospects_dire_direccion_1_c',
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
    'prospects_dire_direccion_1prospects_ida' => 
    array (
      'name' => 'prospects_dire_direccion_1prospects_ida',
      'type' => 'id',
    ),
    'prospects_dire_direccion_1dire_direccion_idb' => 
    array (
      'name' => 'prospects_dire_direccion_1dire_direccion_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_prospects_dire_direccion_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_prospects_dire_direccion_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'prospects_dire_direccion_1prospects_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_prospects_dire_direccion_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'prospects_dire_direccion_1dire_direccion_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'prospects_dire_direccion_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'prospects_dire_direccion_1dire_direccion_idb',
      ),
    ),
  ),
);