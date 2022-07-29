<?php
// created: 2018-02-16 20:35:05
$dictionary['rel_relaciones_accounts_1'] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'rel_relaciones_accounts_1' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'Rel_Relaciones',
      'rhs_table' => 'rel_relaciones',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'rel_relaciones_accounts_1_c',
      'join_key_lhs' => 'rel_relaciones_accounts_1accounts_ida',
      'join_key_rhs' => 'rel_relaciones_accounts_1rel_relaciones_idb',
    ),
  ),
  'table' => 'rel_relaciones_accounts_1_c',
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
    'rel_relaciones_accounts_1accounts_ida' => 
    array (
      'name' => 'rel_relaciones_accounts_1accounts_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    'rel_relaciones_accounts_1rel_relaciones_idb' => 
    array (
      'name' => 'rel_relaciones_accounts_1rel_relaciones_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'rel_relaciones_accounts_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'rel_relaciones_accounts_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'rel_relaciones_accounts_1accounts_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'rel_relaciones_accounts_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'rel_relaciones_accounts_1rel_relaciones_idb',
      ),
    ),
  ),
);