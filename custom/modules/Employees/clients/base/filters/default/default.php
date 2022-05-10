<?php
// created: 2020-06-18 11:10:00
$viewdefs['Employees']['base']['filter']['default'] = array (
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
    'open_only_active_users' => 
    array (
      'dbFields' => 
      array (
        0 => 'employee_status',
      ),
      'type' => 'bool',
      'vname' => 'LBL_ONLY_ACTIVE',
    ),
    'puestousuario_c' => 
    array (
      'type' => 'enum',
      'default' => true,
      'width' => '10',
      'name' => 'puestousuario_c',
      'vname' => 'LBL_PUESTOUSUARIO',
    ),
    'first_name' => 
    array (
    ),
    'last_name' => 
    array (
    ),
    'employee_status' => 
    array (
    ),
    'title' => 
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