<?php
// created: 2022-04-27 14:56:18
$dictionary["dir_sepomex_dire_direccion"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'dir_sepomex_dire_direccion' => 
    array (
      'lhs_module' => 'dir_Sepomex',
      'lhs_table' => 'dir_sepomex',
      'lhs_key' => 'id',
      'rhs_module' => 'dire_Direccion',
      'rhs_table' => 'dire_direccion',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'dir_sepomex_dire_direccion_c',
      'join_key_lhs' => 'dir_sepomex_dire_direcciondir_sepomex_ida',
      'join_key_rhs' => 'dir_sepomex_dire_direcciondire_direccion_idb',
    ),
  ),
  'table' => 'dir_sepomex_dire_direccion_c',
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
    'dir_sepomex_dire_direcciondir_sepomex_ida' => 
    array (
      'name' => 'dir_sepomex_dire_direcciondir_sepomex_ida',
      'type' => 'id',
    ),
    'dir_sepomex_dire_direcciondire_direccion_idb' => 
    array (
      'name' => 'dir_sepomex_dire_direcciondire_direccion_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_dir_sepomex_dire_direccion_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_dir_sepomex_dire_direccion_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'dir_sepomex_dire_direcciondir_sepomex_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_dir_sepomex_dire_direccion_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'dir_sepomex_dire_direcciondire_direccion_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'dir_sepomex_dire_direccion_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'dir_sepomex_dire_direcciondire_direccion_idb',
      ),
    ),
  ),
);