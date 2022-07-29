<?php
// created: 2018-10-25 10:01:15
$dictionary["meetings_minut_objetivos_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'meetings_minut_objetivos_1' => 
    array (
      'lhs_module' => 'Meetings',
      'lhs_table' => 'meetings',
      'lhs_key' => 'id',
      'rhs_module' => 'minut_Objetivos',
      'rhs_table' => 'minut_objetivos',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'meetings_minut_objetivos_1_c',
      'join_key_lhs' => 'meetings_minut_objetivos_1meetings_ida',
      'join_key_rhs' => 'meetings_minut_objetivos_1minut_objetivos_idb',
    ),
  ),
  'table' => 'meetings_minut_objetivos_1_c',
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
    'meetings_minut_objetivos_1meetings_ida' => 
    array (
      'name' => 'meetings_minut_objetivos_1meetings_ida',
      'type' => 'id',
    ),
    'meetings_minut_objetivos_1minut_objetivos_idb' => 
    array (
      'name' => 'meetings_minut_objetivos_1minut_objetivos_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_meetings_minut_objetivos_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_meetings_minut_objetivos_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'meetings_minut_objetivos_1meetings_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_meetings_minut_objetivos_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'meetings_minut_objetivos_1minut_objetivos_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'meetings_minut_objetivos_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'meetings_minut_objetivos_1minut_objetivos_idb',
      ),
    ),
  ),
);