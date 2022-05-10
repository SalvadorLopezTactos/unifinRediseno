<?php
// created: 2018-02-16 20:35:05
$dictionary['val_validaciones_val_validaciones'] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'val_validaciones_val_validaciones' => 
    array (
      'lhs_module' => 'Val_Validaciones',
      'lhs_table' => 'val_validaciones',
      'lhs_key' => 'id',
      'rhs_module' => 'Val_Validaciones',
      'rhs_table' => 'val_validaciones',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'val_validaciones_val_validaciones_c',
      'join_key_lhs' => 'val_validaciones_val_validacionesval_validaciones_ida',
      'join_key_rhs' => 'val_validaciones_val_validacionesval_validaciones_idb',
    ),
  ),
  'table' => 'val_validaciones_val_validaciones_c',
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
    'val_validaciones_val_validacionesval_validaciones_ida' => 
    array (
      'name' => 'val_validaciones_val_validacionesval_validaciones_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    'val_validaciones_val_validacionesval_validaciones_idb' => 
    array (
      'name' => 'val_validaciones_val_validacionesval_validaciones_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'val_validaciones_val_validacionesspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'val_validaciones_val_validaciones_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'val_validaciones_val_validacionesval_validaciones_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'val_validaciones_val_validaciones_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'val_validaciones_val_validacionesval_validaciones_idb',
      ),
    ),
  ),
);