<?php
// created: 2019-12-23 17:23:02
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