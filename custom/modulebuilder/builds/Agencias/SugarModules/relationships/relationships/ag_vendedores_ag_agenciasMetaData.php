<?php
// created: 2015-10-28 18:23:48
$dictionary["ag_vendedores_ag_agencias"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'ag_vendedores_ag_agencias' => 
    array (
      'lhs_module' => 'AG_Agencias',
      'lhs_table' => 'ag_agencias',
      'lhs_key' => 'id',
      'rhs_module' => 'AG_Vendedores',
      'rhs_table' => 'ag_vendedores',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'ag_vendedores_ag_agencias_c',
      'join_key_lhs' => 'ag_vendedores_ag_agenciasag_agencias_ida',
      'join_key_rhs' => 'ag_vendedores_ag_agenciasag_vendedores_idb',
    ),
  ),
  'table' => 'ag_vendedores_ag_agencias_c',
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
      'name' => 'ag_vendedores_ag_agenciasag_agencias_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'ag_vendedores_ag_agenciasag_vendedores_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'ag_vendedores_ag_agenciasspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'ag_vendedores_ag_agencias_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'ag_vendedores_ag_agenciasag_agencias_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'ag_vendedores_ag_agencias_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'ag_vendedores_ag_agenciasag_vendedores_idb',
      ),
    ),
  ),
);