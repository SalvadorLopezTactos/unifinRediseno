<?php
// created: 2018-02-16 20:35:05
$dictionary['ag_agencias_accounts'] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'ag_agencias_accounts' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'AG_Agencias',
      'rhs_table' => 'ag_agencias',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'ag_agencias_accounts_c',
      'join_key_lhs' => 'ag_agencias_accountsaccounts_ida',
      'join_key_rhs' => 'ag_agencias_accountsag_agencias_idb',
    ),
  ),
  'table' => 'ag_agencias_accounts_c',
  'fields' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
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
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    'ag_agencias_accountsaccounts_ida' => 
    array (
      'name' => 'ag_agencias_accountsaccounts_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    'ag_agencias_accountsag_agencias_idb' => 
    array (
      'name' => 'ag_agencias_accountsag_agencias_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'ag_agencias_accountsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'ag_agencias_accounts_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'ag_agencias_accountsaccounts_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'ag_agencias_accounts_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'ag_agencias_accountsag_agencias_idb',
      ),
    ),
  ),
);