<?php
// created: 2021-05-07 20:21:31
$dictionary["notes_leads_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'notes_leads_1' => 
    array (
      'lhs_module' => 'Notes',
      'lhs_table' => 'notes',
      'lhs_key' => 'id',
      'rhs_module' => 'Leads',
      'rhs_table' => 'leads',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'notes_leads_1_c',
      'join_key_lhs' => 'notes_leads_1notes_ida',
      'join_key_rhs' => 'notes_leads_1leads_idb',
    ),
  ),
  'table' => 'notes_leads_1_c',
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
    'notes_leads_1notes_ida' => 
    array (
      'name' => 'notes_leads_1notes_ida',
      'type' => 'id',
    ),
    'notes_leads_1leads_idb' => 
    array (
      'name' => 'notes_leads_1leads_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_notes_leads_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_notes_leads_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'notes_leads_1notes_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_notes_leads_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'notes_leads_1leads_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'notes_leads_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'notes_leads_1notes_ida',
        1 => 'notes_leads_1leads_idb',
      ),
    ),
  ),
);