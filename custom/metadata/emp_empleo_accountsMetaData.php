<?php
// created: 2018-02-16 20:35:05
$dictionary['emp_empleo_accounts'] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'emp_empleo_accounts' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'emp_empleo',
      'rhs_table' => 'emp_empleo',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'emp_empleo_accounts_c',
      'join_key_lhs' => 'emp_empleo_accountsaccounts_ida',
      'join_key_rhs' => 'emp_empleo_accountsemp_empleo_idb',
    ),
  ),
  'table' => 'emp_empleo_accounts_c',
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
    'emp_empleo_accountsaccounts_ida' => 
    array (
      'name' => 'emp_empleo_accountsaccounts_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    'emp_empleo_accountsemp_empleo_idb' => 
    array (
      'name' => 'emp_empleo_accountsemp_empleo_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'emp_empleo_accountsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'emp_empleo_accounts_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'emp_empleo_accountsaccounts_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'emp_empleo_accounts_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'emp_empleo_accountsemp_empleo_idb',
      ),
    ),
  ),
);