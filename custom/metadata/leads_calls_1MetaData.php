<?php
// created: 2021-07-27 16:53:07
$dictionary["leads_calls_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'leads_calls_1' => 
    array (
      'lhs_module' => 'Leads',
      'lhs_table' => 'leads',
      'lhs_key' => 'id',
      'rhs_module' => 'Calls',
      'rhs_table' => 'calls',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'leads_calls_1_c',
      'join_key_lhs' => 'leads_calls_1leads_ida',
      'join_key_rhs' => 'leads_calls_1calls_idb',
    ),
  ),
  'table' => 'leads_calls_1_c',
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
    'leads_calls_1leads_ida' => 
    array (
      'name' => 'leads_calls_1leads_ida',
      'type' => 'id',
    ),
    'leads_calls_1calls_idb' => 
    array (
      'name' => 'leads_calls_1calls_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_leads_calls_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_leads_calls_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'leads_calls_1leads_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_leads_calls_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'leads_calls_1calls_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'leads_calls_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'leads_calls_1calls_idb',
      ),
    ),
  ),
);