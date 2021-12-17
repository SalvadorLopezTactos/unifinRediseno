<?php
// created: 2015-06-10 17:46:42
$dictionary["dire_direccion_accounts"] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'dire_direccion_accounts' => 
    array (
      'lhs_module' => 'dire_Direccion',
      'lhs_table' => 'dire_direccion',
      'lhs_key' => 'id',
      'rhs_module' => 'Accounts',
      'rhs_table' => 'accounts',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'dire_direccion_accounts_c',
      'join_key_lhs' => 'dire_direccion_accountsdire_direccion_ida',
      'join_key_rhs' => 'dire_direccion_accountsaccounts_idb',
    ),
  ),
  'table' => 'dire_direccion_accounts_c',
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
      'name' => 'dire_direccion_accountsdire_direccion_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'dire_direccion_accountsaccounts_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'dire_direccion_accountsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'dire_direccion_accounts_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'dire_direccion_accountsdire_direccion_ida',
        1 => 'dire_direccion_accountsaccounts_idb',
      ),
    ),
  ),
);