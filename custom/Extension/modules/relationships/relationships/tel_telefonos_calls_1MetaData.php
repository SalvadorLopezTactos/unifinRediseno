<?php
// created: 2018-03-09 10:42:17
$dictionary["tel_telefonos_calls_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'tel_telefonos_calls_1' => 
    array (
      'lhs_module' => 'Tel_Telefonos',
      'lhs_table' => 'tel_telefonos',
      'lhs_key' => 'id',
      'rhs_module' => 'Calls',
      'rhs_table' => 'calls',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'tel_telefonos_calls_1_c',
      'join_key_lhs' => 'tel_telefonos_calls_1tel_telefonos_ida',
      'join_key_rhs' => 'tel_telefonos_calls_1calls_idb',
    ),
  ),
  'table' => 'tel_telefonos_calls_1_c',
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
    'tel_telefonos_calls_1tel_telefonos_ida' => 
    array (
      'name' => 'tel_telefonos_calls_1tel_telefonos_ida',
      'type' => 'id',
    ),
    'tel_telefonos_calls_1calls_idb' => 
    array (
      'name' => 'tel_telefonos_calls_1calls_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_tel_telefonos_calls_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_tel_telefonos_calls_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'tel_telefonos_calls_1tel_telefonos_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_tel_telefonos_calls_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'tel_telefonos_calls_1calls_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'tel_telefonos_calls_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'tel_telefonos_calls_1calls_idb',
      ),
    ),
  ),
);