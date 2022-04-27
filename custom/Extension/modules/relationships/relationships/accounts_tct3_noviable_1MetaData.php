<?php
// created: 2019-03-28 18:50:43
$dictionary["accounts_tct3_noviable_1"] = array (
  'true_relationship_type' => 'one-to-one',
  'from_studio' => true,
  'relationships' => 
  array (
    'accounts_tct3_noviable_1' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'tct3_noviable',
      'rhs_table' => 'tct3_noviable',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'accounts_tct3_noviable_1_c',
      'join_key_lhs' => 'accounts_tct3_noviable_1accounts_ida',
      'join_key_rhs' => 'accounts_tct3_noviable_1tct3_noviable_idb',
    ),
  ),
  'table' => 'accounts_tct3_noviable_1_c',
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
    'accounts_tct3_noviable_1accounts_ida' => 
    array (
      'name' => 'accounts_tct3_noviable_1accounts_ida',
      'type' => 'id',
    ),
    'accounts_tct3_noviable_1tct3_noviable_idb' => 
    array (
      'name' => 'accounts_tct3_noviable_1tct3_noviable_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_accounts_tct3_noviable_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_accounts_tct3_noviable_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'accounts_tct3_noviable_1accounts_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_accounts_tct3_noviable_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'accounts_tct3_noviable_1tct3_noviable_idb',
        1 => 'deleted',
      ),
    ),
  ),
);