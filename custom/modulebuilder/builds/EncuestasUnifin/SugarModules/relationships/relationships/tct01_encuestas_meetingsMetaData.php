<?php
// created: 2018-09-27 12:54:00
$dictionary["tct01_encuestas_meetings"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'tct01_encuestas_meetings' => 
    array (
      'lhs_module' => 'Meetings',
      'lhs_table' => 'meetings',
      'lhs_key' => 'id',
      'rhs_module' => 'TCT01_Encuestas',
      'rhs_table' => 'tct01_encuestas',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'tct01_encuestas_meetings_c',
      'join_key_lhs' => 'tct01_encuestas_meetingsmeetings_ida',
      'join_key_rhs' => 'tct01_encuestas_meetingstct01_encuestas_idb',
    ),
  ),
  'table' => 'tct01_encuestas_meetings_c',
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
    'tct01_encuestas_meetingsmeetings_ida' => 
    array (
      'name' => 'tct01_encuestas_meetingsmeetings_ida',
      'type' => 'id',
    ),
    'tct01_encuestas_meetingstct01_encuestas_idb' => 
    array (
      'name' => 'tct01_encuestas_meetingstct01_encuestas_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_tct01_encuestas_meetings_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_tct01_encuestas_meetings_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'tct01_encuestas_meetingsmeetings_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_tct01_encuestas_meetings_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'tct01_encuestas_meetingstct01_encuestas_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'tct01_encuestas_meetings_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'tct01_encuestas_meetingstct01_encuestas_idb',
      ),
    ),
  ),
);