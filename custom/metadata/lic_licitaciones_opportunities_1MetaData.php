<?php
// created: 2021-02-08 14:34:06
$dictionary["lic_licitaciones_opportunities_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'lic_licitaciones_opportunities_1' => 
    array (
      'lhs_module' => 'Lic_Licitaciones',
      'lhs_table' => 'lic_licitaciones',
      'lhs_key' => 'id',
      'rhs_module' => 'Opportunities',
      'rhs_table' => 'opportunities',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'lic_licitaciones_opportunities_1_c',
      'join_key_lhs' => 'lic_licitaciones_opportunities_1lic_licitaciones_ida',
      'join_key_rhs' => 'lic_licitaciones_opportunities_1opportunities_idb',
    ),
  ),
  'table' => 'lic_licitaciones_opportunities_1_c',
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
    'lic_licitaciones_opportunities_1lic_licitaciones_ida' => 
    array (
      'name' => 'lic_licitaciones_opportunities_1lic_licitaciones_ida',
      'type' => 'id',
    ),
    'lic_licitaciones_opportunities_1opportunities_idb' => 
    array (
      'name' => 'lic_licitaciones_opportunities_1opportunities_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_lic_licitaciones_opportunities_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_lic_licitaciones_opportunities_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'lic_licitaciones_opportunities_1lic_licitaciones_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_lic_licitaciones_opportunities_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'lic_licitaciones_opportunities_1opportunities_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'lic_licitaciones_opportunities_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'lic_licitaciones_opportunities_1opportunities_idb',
      ),
    ),
  ),
);