<?php
// created: 2018-02-16 20:35:05
$dictionary['dire_ciudad_dire_estado'] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'dire_ciudad_dire_estado' => 
    array (
      'lhs_module' => 'dire_Estado',
      'lhs_table' => 'dire_estado',
      'lhs_key' => 'id',
      'rhs_module' => 'dire_Ciudad',
      'rhs_table' => 'dire_ciudad',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'dire_ciudad_dire_estado_c',
      'join_key_lhs' => 'dire_ciudad_dire_estadodire_estado_ida',
      'join_key_rhs' => 'dire_ciudad_dire_estadodire_ciudad_idb',
    ),
  ),
  'table' => 'dire_ciudad_dire_estado_c',
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
    'dire_ciudad_dire_estadodire_estado_ida' => 
    array (
      'name' => 'dire_ciudad_dire_estadodire_estado_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    'dire_ciudad_dire_estadodire_ciudad_idb' => 
    array (
      'name' => 'dire_ciudad_dire_estadodire_ciudad_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'dire_ciudad_dire_estadospk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'dire_ciudad_dire_estado_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'dire_ciudad_dire_estadodire_estado_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'dire_ciudad_dire_estado_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'dire_ciudad_dire_estadodire_ciudad_idb',
      ),
    ),
  ),
);