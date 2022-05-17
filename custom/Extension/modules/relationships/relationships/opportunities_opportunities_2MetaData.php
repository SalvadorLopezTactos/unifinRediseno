<?php
// created: 2019-11-27 12:43:01
$dictionary["opportunities_opportunities_2"] = array (
  'true_relationship_type' => 'one-to-one',
  'from_studio' => true,
  'relationships' => 
  array (
    'opportunities_opportunities_2' => 
    array (
      'lhs_module' => 'Opportunities',
      'lhs_table' => 'opportunities',
      'lhs_key' => 'id',
      'rhs_module' => 'Opportunities',
      'rhs_table' => 'opportunities',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'opportunities_opportunities_2_c',
      'join_key_lhs' => 'opportunities_opportunities_2opportunities_ida',
      'join_key_rhs' => 'opportunities_opportunities_2opportunities_idb',
    ),
  ),
  'table' => 'opportunities_opportunities_2_c',
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
    'opportunities_opportunities_2opportunities_ida' => 
    array (
      'name' => 'opportunities_opportunities_2opportunities_ida',
      'type' => 'id',
    ),
    'opportunities_opportunities_2opportunities_idb' => 
    array (
      'name' => 'opportunities_opportunities_2opportunities_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_opportunities_opportunities_2_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_opportunities_opportunities_2_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'opportunities_opportunities_2opportunities_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_opportunities_opportunities_2_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'opportunities_opportunities_2opportunities_idb',
        1 => 'deleted',
      ),
    ),
  ),
);