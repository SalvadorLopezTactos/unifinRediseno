<?php
// created: 2020-05-27 14:08:29
$dictionary["cta_cuentas_bancarias_accounts"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'cta_cuentas_bancarias_accounts' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'cta_cuentas_bancarias',
      'rhs_table' => 'cta_cuentas_bancarias',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'cta_cuentas_bancarias_accounts_c',
      'join_key_lhs' => 'cta_cuentas_bancarias_accountsaccounts_ida',
      'join_key_rhs' => 'cta_cuentas_bancarias_accountscta_cuentas_bancarias_idb',
    ),
  ),
  'table' => 'cta_cuentas_bancarias_accounts_c',
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
    'cta_cuentas_bancarias_accountsaccounts_ida' => 
    array (
      'name' => 'cta_cuentas_bancarias_accountsaccounts_ida',
      'type' => 'id',
    ),
    'cta_cuentas_bancarias_accountscta_cuentas_bancarias_idb' => 
    array (
      'name' => 'cta_cuentas_bancarias_accountscta_cuentas_bancarias_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_cta_cuentas_bancarias_accounts_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_cta_cuentas_bancarias_accounts_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'cta_cuentas_bancarias_accountsaccounts_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_cta_cuentas_bancarias_accounts_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'cta_cuentas_bancarias_accountscta_cuentas_bancarias_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'cta_cuentas_bancarias_accounts_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'cta_cuentas_bancarias_accountscta_cuentas_bancarias_idb',
      ),
    ),
  ),
);