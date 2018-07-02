<?php
// created: 2018-02-16 20:35:05
$dictionary['lev_condicionesfinancieras_opportunities'] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'lev_condicionesfinancieras_opportunities' => 
    array (
      'lhs_module' => 'Opportunities',
      'lhs_table' => 'opportunities',
      'lhs_key' => 'id',
      'rhs_module' => 'lev_CondicionesFinancieras',
      'rhs_table' => 'lev_condicionesfinancieras',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'lev_condicionesfinancieras_opportunities_c',
      'join_key_lhs' => 'lev_condicionesfinancieras_opportunitiesopportunities_ida',
      'join_key_rhs' => 'lev_condic7ff1ncieras_idb',
    ),
  ),
  'table' => 'lev_condicionesfinancieras_opportunities_c',
  'fields' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
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
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    'lev_condicionesfinancieras_opportunitiesopportunities_ida' => 
    array (
      'name' => 'lev_condicionesfinancieras_opportunitiesopportunities_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    'lev_condic7ff1ncieras_idb' => 
    array (
      'name' => 'lev_condic7ff1ncieras_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'lev_condicionesfinancieras_opportunitiesspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'lev_condicionesfinancieras_opportunities_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'lev_condicionesfinancieras_opportunitiesopportunities_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'lev_condicionesfinancieras_opportunities_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'lev_condic7ff1ncieras_idb',
      ),
    ),
  ),
);