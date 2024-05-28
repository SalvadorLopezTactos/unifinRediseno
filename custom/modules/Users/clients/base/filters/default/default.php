<?php
// created: 2024-05-21 12:56:21
$viewdefs['Users']['base']['filter']['default'] = array (
  'default_filter' => 'all_records',
  'fields' => 
  array (
    'search_name' => 
    array (
      'dbFields' => 
      array (
        0 => 'first_name',
        1 => 'last_name',
      ),
      'vname' => 'LBL_NAME',
    ),
    'first_name' => 
    array (
    ),
    'last_name' => 
    array (
    ),
    'user_name' => 
    array (
    ),
    'status' => 
    array (
    ),
    'is_admin' => 
    array (
    ),
    'puestousuario_c' => 
    array (
      'type' => 'enum',
      'default' => true,
      'width' => '10',
      'name' => 'puestousuario_c',
      'vname' => 'LBL_PUESTOUSUARIO',
    ),
    'subpuesto_c' => 
    array (
      'type' => 'enum',
      'default' => true,
      'width' => '10',
      'name' => 'subpuesto_c',
      'vname' => 'LBL_SUBPUESTO',
    ),
    'title' => 
    array (
    ),
    'is_group' => 
    array (
    ),
    'department' => 
    array (
    ),
    'address_street' => 
    array (
    ),
    'address_city' => 
    array (
    ),
    'address_state' => 
    array (
    ),
    'address_postalcode' => 
    array (
    ),
    'address_country' => 
    array (
    ),
    'cac_c' => 
    array (
      'readonly' => false,
      'type' => 'bool',
      'default' => true,
      'width' => 10,
      'name' => 'cac_c',
      'vname' => 'LBL_CAC',
    ),
    'posicion_operativa_c' => 
    array (
      'readonly' => false,
      'type' => 'multienum',
      'default' => true,
      'width' => 10,
      'name' => 'posicion_operativa_c',
      'vname' => 'LBL_POSICION_OPERATIVA',
    ),
    '$owner' => 
    array (
      'predefined_filter' => true,
      'vname' => 'LBL_CURRENT_USER_FILTER',
    ),
    '$favorite' => 
    array (
      'predefined_filter' => true,
      'vname' => 'LBL_FAVORITES_FILTER',
    ),
  ),
);