<?php
// created: 2018-10-12 11:29:33
$dictionary["minut_minutas_minut_compromisos"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'minut_minutas_minut_compromisos' => 
    array (
      'lhs_module' => 'minut_Minutas',
      'lhs_table' => 'minut_minutas',
      'lhs_key' => 'id',
      'rhs_module' => 'minut_Compromisos',
      'rhs_table' => 'minut_compromisos',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'minut_minutas_minut_compromisos_c',
      'join_key_lhs' => 'minut_minutas_minut_compromisosminut_minutas_ida',
      'join_key_rhs' => 'minut_minutas_minut_compromisosminut_compromisos_idb',
    ),
  ),
  'table' => 'minut_minutas_minut_compromisos_c',
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
    'minut_minutas_minut_compromisosminut_minutas_ida' => 
    array (
      'name' => 'minut_minutas_minut_compromisosminut_minutas_ida',
      'type' => 'id',
    ),
    'minut_minutas_minut_compromisosminut_compromisos_idb' => 
    array (
      'name' => 'minut_minutas_minut_compromisosminut_compromisos_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_minut_minutas_minut_compromisos_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_minut_minutas_minut_compromisos_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'minut_minutas_minut_compromisosminut_minutas_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_minut_minutas_minut_compromisos_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'minut_minutas_minut_compromisosminut_compromisos_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'minut_minutas_minut_compromisos_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'minut_minutas_minut_compromisosminut_compromisos_idb',
      ),
    ),
  ),
);