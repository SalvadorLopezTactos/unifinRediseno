<?php
// created: 2015-06-08 16:18:03
$dictionary["dire_municipio_dire_ciudad"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'dire_municipio_dire_ciudad' => 
    array (
      'lhs_module' => 'dire_Municipio',
      'lhs_table' => 'dire_municipio',
      'lhs_key' => 'id',
      'rhs_module' => 'dire_Ciudad',
      'rhs_table' => 'dire_ciudad',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'dire_municipio_dire_ciudad_c',
      'join_key_lhs' => 'dire_municipio_dire_ciudaddire_municipio_ida',
      'join_key_rhs' => 'dire_municipio_dire_ciudaddire_ciudad_idb',
    ),
  ),
  'table' => 'dire_municipio_dire_ciudad_c',
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
      'name' => 'dire_municipio_dire_ciudaddire_municipio_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'dire_municipio_dire_ciudaddire_ciudad_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'dire_municipio_dire_ciudadspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'dire_municipio_dire_ciudad_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'dire_municipio_dire_ciudaddire_municipio_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'dire_municipio_dire_ciudad_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'dire_municipio_dire_ciudaddire_ciudad_idb',
      ),
    ),
  ),
);