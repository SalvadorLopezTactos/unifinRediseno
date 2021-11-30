<?php
// created: 2015-06-23 20:29:50
$dictionary["dire_colonia_dire_codigopostal"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'dire_colonia_dire_codigopostal' => 
    array (
      'lhs_module' => 'dire_CodigoPostal',
      'lhs_table' => 'dire_codigopostal',
      'lhs_key' => 'id',
      'rhs_module' => 'dire_Colonia',
      'rhs_table' => 'dire_colonia',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'dire_colonia_dire_codigopostal_c',
      'join_key_lhs' => 'dire_colonia_dire_codigopostaldire_codigopostal_ida',
      'join_key_rhs' => 'dire_colonia_dire_codigopostaldire_colonia_idb',
    ),
  ),
  'table' => 'dire_colonia_dire_codigopostal_c',
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
      'name' => 'dire_colonia_dire_codigopostaldire_codigopostal_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'dire_colonia_dire_codigopostaldire_colonia_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'dire_colonia_dire_codigopostalspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'dire_colonia_dire_codigopostal_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'dire_colonia_dire_codigopostaldire_codigopostal_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'dire_colonia_dire_codigopostal_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'dire_colonia_dire_codigopostaldire_colonia_idb',
      ),
    ),
  ),
);