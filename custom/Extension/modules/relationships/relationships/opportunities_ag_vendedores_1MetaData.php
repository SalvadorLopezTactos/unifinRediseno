<?php
// created: 2018-02-16 20:35:05
$dictionary['opportunities_ag_vendedores_1'] = array (
  'true_relationship_type' => 'one-to-one',
  'from_studio' => true,
  'relationships' => 
  array (
    'opportunities_ag_vendedores_1' => 
    array (
      'lhs_module' => 'Opportunities',
      'lhs_table' => 'opportunities',
      'lhs_key' => 'id',
      'rhs_module' => 'AG_Vendedores',
      'rhs_table' => 'ag_vendedores',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'opportunities_ag_vendedores_1_c',
      'join_key_lhs' => 'opportunities_ag_vendedores_1opportunities_ida',
      'join_key_rhs' => 'opportunities_ag_vendedores_1ag_vendedores_idb',
    ),
  ),
  'table' => 'opportunities_ag_vendedores_1_c',
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
    'opportunities_ag_vendedores_1opportunities_ida' => 
    array (
      'name' => 'opportunities_ag_vendedores_1opportunities_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    'opportunities_ag_vendedores_1ag_vendedores_idb' => 
    array (
      'name' => 'opportunities_ag_vendedores_1ag_vendedores_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'opportunities_ag_vendedores_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'opportunities_ag_vendedores_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'opportunities_ag_vendedores_1opportunities_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'opportunities_ag_vendedores_1_idb2',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'opportunities_ag_vendedores_1ag_vendedores_idb',
      ),
    ),
  ),
);