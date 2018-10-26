<?php
// created: 2018-10-24 23:16:26
$dictionary["minut_minutas_meetings_1"] = array (
  'true_relationship_type' => 'one-to-one',
  'from_studio' => true,
  'relationships' => 
  array (
    'minut_minutas_meetings_1' => 
    array (
      'lhs_module' => 'minut_Minutas',
      'lhs_table' => 'minut_minutas',
      'lhs_key' => 'id',
      'rhs_module' => 'Meetings',
      'rhs_table' => 'meetings',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'minut_minutas_meetings_1_c',
      'join_key_lhs' => 'minut_minutas_meetings_1minut_minutas_ida',
      'join_key_rhs' => 'minut_minutas_meetings_1meetings_idb',
    ),
  ),
  'table' => 'minut_minutas_meetings_1_c',
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
    'minut_minutas_meetings_1minut_minutas_ida' => 
    array (
      'name' => 'minut_minutas_meetings_1minut_minutas_ida',
      'type' => 'id',
    ),
    'minut_minutas_meetings_1meetings_idb' => 
    array (
      'name' => 'minut_minutas_meetings_1meetings_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_minut_minutas_meetings_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_minut_minutas_meetings_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'minut_minutas_meetings_1minut_minutas_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_minut_minutas_meetings_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'minut_minutas_meetings_1meetings_idb',
        1 => 'deleted',
      ),
    ),
  ),
);