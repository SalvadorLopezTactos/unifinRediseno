<?php
// created: 2018-10-12 11:29:33
$dictionary["minut_minutas_meetings"] = array (
  'true_relationship_type' => 'one-to-one',
  'relationships' => 
  array (
    'minut_minutas_meetings' => 
    array (
      'lhs_module' => 'minut_Minutas',
      'lhs_table' => 'minut_minutas',
      'lhs_key' => 'id',
      'rhs_module' => 'Meetings',
      'rhs_table' => 'meetings',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'minut_minutas_meetings_c',
      'join_key_lhs' => 'minut_minutas_meetingsminut_minutas_ida',
      'join_key_rhs' => 'minut_minutas_meetingsmeetings_idb',
    ),
  ),
  'table' => 'minut_minutas_meetings_c',
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
    'minut_minutas_meetingsminut_minutas_ida' => 
    array (
      'name' => 'minut_minutas_meetingsminut_minutas_ida',
      'type' => 'id',
    ),
    'minut_minutas_meetingsmeetings_idb' => 
    array (
      'name' => 'minut_minutas_meetingsmeetings_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_minut_minutas_meetings_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_minut_minutas_meetings_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'minut_minutas_meetingsminut_minutas_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_minut_minutas_meetings_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'minut_minutas_meetingsmeetings_idb',
        1 => 'deleted',
      ),
    ),
  ),
);