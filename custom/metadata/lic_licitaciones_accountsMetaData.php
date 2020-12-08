<?php
// created: 2020-12-03 15:29:17
$dictionary["lic_licitaciones_accounts"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'lic_licitaciones_accounts' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'Lic_Licitaciones',
      'rhs_table' => 'lic_licitaciones',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'lic_licitaciones_accounts_c',
      'join_key_lhs' => 'lic_licitaciones_accountsaccounts_ida',
      'join_key_rhs' => 'lic_licitaciones_accountslic_licitaciones_idb',
    ),
  ),
  'table' => 'lic_licitaciones_accounts_c',
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
    'lic_licitaciones_accountsaccounts_ida' => 
    array (
      'name' => 'lic_licitaciones_accountsaccounts_ida',
      'type' => 'id',
    ),
    'lic_licitaciones_accountslic_licitaciones_idb' => 
    array (
      'name' => 'lic_licitaciones_accountslic_licitaciones_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_lic_licitaciones_accounts_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_lic_licitaciones_accounts_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'lic_licitaciones_accountsaccounts_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_lic_licitaciones_accounts_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'lic_licitaciones_accountslic_licitaciones_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'lic_licitaciones_accounts_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'lic_licitaciones_accountslic_licitaciones_idb',
      ),
    ),
  ),
);