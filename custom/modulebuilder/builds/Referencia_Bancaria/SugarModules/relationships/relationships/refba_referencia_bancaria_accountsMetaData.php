<?php
// created: 2015-07-21 23:08:07
$dictionary["refba_referencia_bancaria_accounts"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'refba_referencia_bancaria_accounts' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'RefBa_Referencia_Bancaria',
      'rhs_table' => 'refba_referencia_bancaria',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'refba_referencia_bancaria_accounts_c',
      'join_key_lhs' => 'refba_referencia_bancaria_accountsaccounts_ida',
      'join_key_rhs' => 'refba_referencia_bancaria_accountsrefba_referencia_bancaria_idb',
    ),
  ),
  'table' => 'refba_referencia_bancaria_accounts_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'refba_referencia_bancaria_accountsaccounts_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'refba_referencia_bancaria_accountsrefba_referencia_bancaria_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'refba_referencia_bancaria_accountsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'refba_referencia_bancaria_accounts_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'refba_referencia_bancaria_accountsaccounts_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'refba_referencia_bancaria_accounts_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'refba_referencia_bancaria_accountsrefba_referencia_bancaria_idb',
      ),
    ),
  ),
);