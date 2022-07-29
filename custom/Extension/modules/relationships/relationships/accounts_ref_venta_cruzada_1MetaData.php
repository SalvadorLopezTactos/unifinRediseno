<?php
// created: 2020-07-23 13:01:15
$dictionary["accounts_ref_venta_cruzada_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'accounts_ref_venta_cruzada_1' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'Ref_Venta_Cruzada',
      'rhs_table' => 'ref_venta_cruzada',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'accounts_ref_venta_cruzada_1_c',
      'join_key_lhs' => 'accounts_ref_venta_cruzada_1accounts_ida',
      'join_key_rhs' => 'accounts_ref_venta_cruzada_1ref_venta_cruzada_idb',
    ),
  ),
  'table' => 'accounts_ref_venta_cruzada_1_c',
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
    'accounts_ref_venta_cruzada_1accounts_ida' => 
    array (
      'name' => 'accounts_ref_venta_cruzada_1accounts_ida',
      'type' => 'id',
    ),
    'accounts_ref_venta_cruzada_1ref_venta_cruzada_idb' => 
    array (
      'name' => 'accounts_ref_venta_cruzada_1ref_venta_cruzada_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_accounts_ref_venta_cruzada_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_accounts_ref_venta_cruzada_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'accounts_ref_venta_cruzada_1accounts_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_accounts_ref_venta_cruzada_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'accounts_ref_venta_cruzada_1ref_venta_cruzada_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'accounts_ref_venta_cruzada_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'accounts_ref_venta_cruzada_1ref_venta_cruzada_idb',
      ),
    ),
  ),
);