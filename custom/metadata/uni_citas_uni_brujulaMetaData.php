<?php
// created: 2018-02-16 20:35:05
$dictionary['uni_citas_uni_brujula'] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'uni_citas_uni_brujula' => 
    array (
      'lhs_module' => 'uni_Brujula',
      'lhs_table' => 'uni_brujula',
      'lhs_key' => 'id',
      'rhs_module' => 'uni_Citas',
      'rhs_table' => 'uni_citas',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'uni_citas_uni_brujula_c',
      'join_key_lhs' => 'uni_citas_uni_brujulauni_brujula_ida',
      'join_key_rhs' => 'uni_citas_uni_brujulauni_citas_idb',
    ),
  ),
  'table' => 'uni_citas_uni_brujula_c',
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
    'uni_citas_uni_brujulauni_brujula_ida' => 
    array (
      'name' => 'uni_citas_uni_brujulauni_brujula_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    'uni_citas_uni_brujulauni_citas_idb' => 
    array (
      'name' => 'uni_citas_uni_brujulauni_citas_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'uni_citas_uni_brujulaspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'uni_citas_uni_brujula_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'uni_citas_uni_brujulauni_brujula_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'uni_citas_uni_brujula_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'uni_citas_uni_brujulauni_citas_idb',
      ),
    ),
  ),
);