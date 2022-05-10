<?php
// created: 2021-09-21 12:10:36
$dictionary["tasks_opportunities_1"] = array (
  'true_relationship_type' => 'one-to-one',
  'from_studio' => true,
  'relationships' => 
  array (
    'tasks_opportunities_1' => 
    array (
      'lhs_module' => 'Tasks',
      'lhs_table' => 'tasks',
      'lhs_key' => 'id',
      'rhs_module' => 'Opportunities',
      'rhs_table' => 'opportunities',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'tasks_opportunities_1_c',
      'join_key_lhs' => 'tasks_opportunities_1tasks_ida',
      'join_key_rhs' => 'tasks_opportunities_1opportunities_idb',
    ),
  ),
  'table' => 'tasks_opportunities_1_c',
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
    'tasks_opportunities_1tasks_ida' => 
    array (
      'name' => 'tasks_opportunities_1tasks_ida',
      'type' => 'id',
    ),
    'tasks_opportunities_1opportunities_idb' => 
    array (
      'name' => 'tasks_opportunities_1opportunities_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_tasks_opportunities_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_tasks_opportunities_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'tasks_opportunities_1tasks_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_tasks_opportunities_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'tasks_opportunities_1opportunities_idb',
        1 => 'deleted',
      ),
    ),
  ),
);