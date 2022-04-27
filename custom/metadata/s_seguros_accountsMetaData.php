<?php
// created: 2020-06-30 20:33:48
$dictionary["s_seguros_accounts"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    's_seguros_accounts' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'S_seguros',
      'rhs_table' => 's_seguros',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 's_seguros_accounts_c',
      'join_key_lhs' => 's_seguros_accountsaccounts_ida',
      'join_key_rhs' => 's_seguros_accountss_seguros_idb',
    ),
  ),
  'table' => 's_seguros_accounts_c',
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
    's_seguros_accountsaccounts_ida' => 
    array (
      'name' => 's_seguros_accountsaccounts_ida',
      'type' => 'id',
    ),
    's_seguros_accountss_seguros_idb' => 
    array (
      'name' => 's_seguros_accountss_seguros_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_s_seguros_accounts_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_s_seguros_accounts_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 's_seguros_accountsaccounts_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_s_seguros_accounts_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 's_seguros_accountss_seguros_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 's_seguros_accounts_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 's_seguros_accountss_seguros_idb',
      ),
    ),
  ),
);