<?php
// created: 2020-02-19 17:16:59
$dictionary["anlzt_analizate_accounts"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'anlzt_analizate_accounts' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'ANLZT_analizate',
      'rhs_table' => 'anlzt_analizate',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'anlzt_analizate_accounts_c',
      'join_key_lhs' => 'anlzt_analizate_accountsaccounts_ida',
      'join_key_rhs' => 'anlzt_analizate_accountsanlzt_analizate_idb',
    ),
  ),
  'table' => 'anlzt_analizate_accounts_c',
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
    'anlzt_analizate_accountsaccounts_ida' => 
    array (
      'name' => 'anlzt_analizate_accountsaccounts_ida',
      'type' => 'id',
    ),
    'anlzt_analizate_accountsanlzt_analizate_idb' => 
    array (
      'name' => 'anlzt_analizate_accountsanlzt_analizate_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_anlzt_analizate_accounts_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_anlzt_analizate_accounts_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'anlzt_analizate_accountsaccounts_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_anlzt_analizate_accounts_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'anlzt_analizate_accountsanlzt_analizate_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'anlzt_analizate_accounts_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'anlzt_analizate_accountsanlzt_analizate_idb',
      ),
    ),
  ),
);