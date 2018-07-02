<?php
// created: 2015-06-23 20:29:49
$dictionary["dire_municipio_dire_estado"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'dire_municipio_dire_estado' => 
    array (
      'lhs_module' => 'dire_Estado',
      'lhs_table' => 'dire_estado',
      'lhs_key' => 'id',
      'rhs_module' => 'dire_Municipio',
      'rhs_table' => 'dire_municipio',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'dire_municipio_dire_estado_c',
      'join_key_lhs' => 'dire_municipio_dire_estadodire_estado_ida',
      'join_key_rhs' => 'dire_municipio_dire_estadodire_municipio_idb',
    ),
  ),
  'table' => 'dire_municipio_dire_estado_c',
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
      'name' => 'dire_municipio_dire_estadodire_estado_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'dire_municipio_dire_estadodire_municipio_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'dire_municipio_dire_estadospk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'dire_municipio_dire_estado_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'dire_municipio_dire_estadodire_estado_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'dire_municipio_dire_estado_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'dire_municipio_dire_estadodire_municipio_idb',
      ),
    ),
  ),
);