<?php
// created: 2019-02-12 13:23:11
$dictionary["minut_minutas_meetings_2"] = array (
  'true_relationship_type' => 'one-to-one',
  'from_studio' => true,
  'relationships' => 
  array (
    'minut_minutas_meetings_2' => 
    array (
      'lhs_module' => 'minut_Minutas',
      'lhs_table' => 'minut_minutas',
      'lhs_key' => 'id',
      'rhs_module' => 'Meetings',
      'rhs_table' => 'meetings',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'minut_minutas_meetings_2_c',
      'join_key_lhs' => 'minut_minutas_meetings_2minut_minutas_ida',
      'join_key_rhs' => 'minut_minutas_meetings_2meetings_idb',
    ),
  ),
  'table' => 'minut_minutas_meetings_2_c',
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
    'minut_minutas_meetings_2minut_minutas_ida' => 
    array (
      'name' => 'minut_minutas_meetings_2minut_minutas_ida',
      'type' => 'id',
    ),
    'minut_minutas_meetings_2meetings_idb' => 
    array (
      'name' => 'minut_minutas_meetings_2meetings_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_minut_minutas_meetings_2_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_minut_minutas_meetings_2_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'minut_minutas_meetings_2minut_minutas_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_minut_minutas_meetings_2_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'minut_minutas_meetings_2meetings_idb',
        1 => 'deleted',
      ),
    ),
  ),
);