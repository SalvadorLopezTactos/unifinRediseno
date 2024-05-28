<?php
// created: 2024-05-21 12:49:42
$searchdefs['Employees'] = array (
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
  'layout' => 
  array (
    'basic_search' => 
    array (
      0 => 
      array (
        'name' => 'search_name',
        'label' => 'LBL_NAME',
        'type' => 'name',
        'default' => true,
        'width' => 10,
      ),
      1 => 
      array (
        'name' => 'open_only_active_users',
        'label' => 'LBL_ONLY_ACTIVE',
        'type' => 'bool',
        'default' => true,
        'width' => 10,
      ),
      2 => 
      array (
        'type' => 'enum',
        'default' => true,
        'label' => 'LBL_PUESTOUSUARIO',
        'width' => 10,
        'name' => 'puestousuario_c',
      ),
    ),
    'advanced_search' => 
    array (
      0 => 
      array (
        'name' => 'first_name',
        'default' => true,
        'width' => 10,
      ),
      1 => 
      array (
        'name' => 'last_name',
        'default' => true,
        'width' => 10,
      ),
      2 => 
      array (
        'name' => 'employee_status',
        'default' => true,
        'width' => 10,
      ),
      3 => 
      array (
        'name' => 'title',
        'default' => true,
        'width' => 10,
      ),
      4 => 
      array (
        'name' => 'phone',
        'label' => 'LBL_ANY_PHONE',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      5 => 
      array (
        'name' => 'department',
        'default' => true,
        'width' => 10,
      ),
      6 => 
      array (
        'type' => 'enum',
        'default' => true,
        'label' => 'LBL_PUESTOUSUARIO',
        'width' => '10',
        'name' => 'puestousuario_c',
      ),
      7 => 
      array (
        'name' => 'email',
        'label' => 'LBL_ANY_EMAIL',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      8 => 
      array (
        'name' => 'address_street',
        'label' => 'LBL_ANY_ADDRESS',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      9 => 
      array (
        'name' => 'address_city',
        'label' => 'LBL_CITY',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      10 => 
      array (
        'name' => 'address_state',
        'label' => 'LBL_STATE',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      11 => 
      array (
        'name' => 'address_postalcode',
        'label' => 'LBL_POSTAL_CODE',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      12 => 
      array (
        'name' => 'address_country',
        'label' => 'LBL_COUNTRY',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
    ),
  ),
);