<?php
// created: 2020-03-12 15:55:02
$dictionary["accounts_uni_productos_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'accounts_uni_productos_1' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'uni_Productos',
      'rhs_table' => 'uni_productos',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'accounts_uni_productos_1_c',
      'join_key_lhs' => 'accounts_uni_productos_1accounts_ida',
      'join_key_rhs' => 'accounts_uni_productos_1uni_productos_idb',
    ),
  ),
  'table' => 'accounts_uni_productos_1_c',
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
    'accounts_uni_productos_1accounts_ida' => 
    array (
      'name' => 'accounts_uni_productos_1accounts_ida',
      'type' => 'id',
    ),
    'accounts_uni_productos_1uni_productos_idb' => 
    array (
      'name' => 'accounts_uni_productos_1uni_productos_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_accounts_uni_productos_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_accounts_uni_productos_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'accounts_uni_productos_1accounts_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_accounts_uni_productos_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'accounts_uni_productos_1uni_productos_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'accounts_uni_productos_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'accounts_uni_productos_1uni_productos_idb',
      ),
    ),
  ),
);