<?php
// created: 2024-01-24 12:47:17
$dictionary["tctbl_backlog_seguros_s_seguros_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'tctbl_backlog_seguros_s_seguros_1' => 
    array (
      'lhs_module' => 'TCTBL_Backlog_Seguros',
      'lhs_table' => 'tctbl_backlog_seguros',
      'lhs_key' => 'id',
      'rhs_module' => 'S_seguros',
      'rhs_table' => 's_seguros',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'tctbl_backlog_seguros_s_seguros_1_c',
      'join_key_lhs' => 'tctbl_backlog_seguros_s_seguros_1tctbl_backlog_seguros_ida',
      'join_key_rhs' => 'tctbl_backlog_seguros_s_seguros_1s_seguros_idb',
    ),
  ),
  'table' => 'tctbl_backlog_seguros_s_seguros_1_c',
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
    'tctbl_backlog_seguros_s_seguros_1tctbl_backlog_seguros_ida' => 
    array (
      'name' => 'tctbl_backlog_seguros_s_seguros_1tctbl_backlog_seguros_ida',
      'type' => 'id',
    ),
    'tctbl_backlog_seguros_s_seguros_1s_seguros_idb' => 
    array (
      'name' => 'tctbl_backlog_seguros_s_seguros_1s_seguros_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_tctbl_backlog_seguros_s_seguros_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_tctbl_backlog_seguros_s_seguros_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'tctbl_backlog_seguros_s_seguros_1tctbl_backlog_seguros_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_tctbl_backlog_seguros_s_seguros_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'tctbl_backlog_seguros_s_seguros_1s_seguros_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'tctbl_backlog_seguros_s_seguros_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'tctbl_backlog_seguros_s_seguros_1s_seguros_idb',
      ),
    ),
  ),
);