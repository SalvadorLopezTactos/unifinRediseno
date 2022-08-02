<?php
// created: 2022-06-15 20:25:16
$dictionary["cot_cotizaciones_s_seguros"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'cot_cotizaciones_s_seguros' => 
    array (
      'lhs_module' => 'S_seguros',
      'lhs_table' => 's_seguros',
      'lhs_key' => 'id',
      'rhs_module' => 'Cot_Cotizaciones',
      'rhs_table' => 'cot_cotizaciones',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'cot_cotizaciones_s_seguros_c',
      'join_key_lhs' => 'cot_cotizaciones_s_seguross_seguros_ida',
      'join_key_rhs' => 'cot_cotizaciones_s_seguroscot_cotizaciones_idb',
    ),
  ),
  'table' => 'cot_cotizaciones_s_seguros_c',
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
    'cot_cotizaciones_s_seguross_seguros_ida' => 
    array (
      'name' => 'cot_cotizaciones_s_seguross_seguros_ida',
      'type' => 'id',
    ),
    'cot_cotizaciones_s_seguroscot_cotizaciones_idb' => 
    array (
      'name' => 'cot_cotizaciones_s_seguroscot_cotizaciones_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_cot_cotizaciones_s_seguros_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_cot_cotizaciones_s_seguros_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'cot_cotizaciones_s_seguross_seguros_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_cot_cotizaciones_s_seguros_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'cot_cotizaciones_s_seguroscot_cotizaciones_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'cot_cotizaciones_s_seguros_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'cot_cotizaciones_s_seguroscot_cotizaciones_idb',
      ),
    ),
  ),
);