<?php
// created: 2018-02-16 20:35:05
$dictionary['tct1_p_fideicomiso_accounts'] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'tct1_p_fideicomiso_accounts' => 
    array (
      'lhs_module' => 'TCT1_P_Fideicomiso',
      'lhs_table' => 'tct1_p_fideicomiso',
      'lhs_key' => 'id',
      'rhs_module' => 'Accounts',
      'rhs_table' => 'accounts',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'tct1_p_fideicomiso_accounts_c',
      'join_key_lhs' => 'tct1_p_fideicomiso_accountstct1_p_fideicomiso_ida',
      'join_key_rhs' => 'tct1_p_fideicomiso_accountsaccounts_idb',
    ),
  ),
  'table' => 'tct1_p_fideicomiso_accounts_c',
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
    'tct1_p_fideicomiso_accountstct1_p_fideicomiso_ida' => 
    array (
      'name' => 'tct1_p_fideicomiso_accountstct1_p_fideicomiso_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    'tct1_p_fideicomiso_accountsaccounts_idb' => 
    array (
      'name' => 'tct1_p_fideicomiso_accountsaccounts_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'tct1_p_fideicomiso_accountsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'tct1_p_fideicomiso_accounts_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'tct1_p_fideicomiso_accountstct1_p_fideicomiso_ida',
        1 => 'tct1_p_fideicomiso_accountsaccounts_idb',
      ),
    ),
  ),
);