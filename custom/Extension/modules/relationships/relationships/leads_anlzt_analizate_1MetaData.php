<?php
// created: 2022-08-20 14:06:26
$dictionary["leads_anlzt_analizate_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'leads_anlzt_analizate_1' => 
    array (
      'lhs_module' => 'Leads',
      'lhs_table' => 'leads',
      'lhs_key' => 'id',
      'rhs_module' => 'ANLZT_analizate',
      'rhs_table' => 'anlzt_analizate',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'leads_anlzt_analizate_1_c',
      'join_key_lhs' => 'leads_anlzt_analizate_1leads_ida',
      'join_key_rhs' => 'leads_anlzt_analizate_1anlzt_analizate_idb',
    ),
  ),
  'table' => 'leads_anlzt_analizate_1_c',
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
    'leads_anlzt_analizate_1leads_ida' => 
    array (
      'name' => 'leads_anlzt_analizate_1leads_ida',
      'type' => 'id',
    ),
    'leads_anlzt_analizate_1anlzt_analizate_idb' => 
    array (
      'name' => 'leads_anlzt_analizate_1anlzt_analizate_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_leads_anlzt_analizate_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_leads_anlzt_analizate_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'leads_anlzt_analizate_1leads_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_leads_anlzt_analizate_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'leads_anlzt_analizate_1anlzt_analizate_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'leads_anlzt_analizate_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'leads_anlzt_analizate_1anlzt_analizate_idb',
      ),
    ),
  ),
);