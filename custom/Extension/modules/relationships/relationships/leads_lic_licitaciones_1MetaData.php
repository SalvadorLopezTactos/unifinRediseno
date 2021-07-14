<?php
// created: 2021-06-28 15:55:34
$dictionary["leads_lic_licitaciones_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'leads_lic_licitaciones_1' => 
    array (
      'lhs_module' => 'Leads',
      'lhs_table' => 'leads',
      'lhs_key' => 'id',
      'rhs_module' => 'Lic_Licitaciones',
      'rhs_table' => 'lic_licitaciones',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'leads_lic_licitaciones_1_c',
      'join_key_lhs' => 'leads_lic_licitaciones_1leads_ida',
      'join_key_rhs' => 'leads_lic_licitaciones_1lic_licitaciones_idb',
    ),
  ),
  'table' => 'leads_lic_licitaciones_1_c',
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
    'leads_lic_licitaciones_1leads_ida' => 
    array (
      'name' => 'leads_lic_licitaciones_1leads_ida',
      'type' => 'id',
    ),
    'leads_lic_licitaciones_1lic_licitaciones_idb' => 
    array (
      'name' => 'leads_lic_licitaciones_1lic_licitaciones_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_leads_lic_licitaciones_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_leads_lic_licitaciones_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'leads_lic_licitaciones_1leads_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_leads_lic_licitaciones_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'leads_lic_licitaciones_1lic_licitaciones_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'leads_lic_licitaciones_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'leads_lic_licitaciones_1lic_licitaciones_idb',
      ),
    ),
  ),
);