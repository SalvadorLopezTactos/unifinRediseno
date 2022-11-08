<?php
// created: 2022-11-08 16:19:13
$dictionary["leads_cases_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'leads_cases_1' => 
    array (
      'lhs_module' => 'Leads',
      'lhs_table' => 'leads',
      'lhs_key' => 'id',
      'rhs_module' => 'Cases',
      'rhs_table' => 'cases',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'leads_cases_1_c',
      'join_key_lhs' => 'leads_cases_1leads_ida',
      'join_key_rhs' => 'leads_cases_1cases_idb',
    ),
  ),
  'table' => 'leads_cases_1_c',
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
    'leads_cases_1leads_ida' => 
    array (
      'name' => 'leads_cases_1leads_ida',
      'type' => 'id',
    ),
    'leads_cases_1cases_idb' => 
    array (
      'name' => 'leads_cases_1cases_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_leads_cases_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_leads_cases_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'leads_cases_1leads_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_leads_cases_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'leads_cases_1cases_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'leads_cases_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'leads_cases_1cases_idb',
      ),
    ),
  ),
);