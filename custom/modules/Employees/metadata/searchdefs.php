<?php
$searchdefs['Employees'] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'search_name' => 
      array (
        'name' => 'search_name',
        'label' => 'LBL_NAME',
        'type' => 'name',
        'default' => true,
        'width' => 10,
      ),
      'open_only_active_users' => 
      array (
        'name' => 'open_only_active_users',
        'label' => 'LBL_ONLY_ACTIVE',
        'type' => 'bool',
        'default' => true,
        'width' => 10,
      ),
      'puestousuario_c' => 
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
      'first_name' => 
      array (
        'name' => 'first_name',
        'default' => true,
        'width' => 10,
      ),
      'last_name' => 
      array (
        'name' => 'last_name',
        'default' => true,
        'width' => 10,
      ),
      'employee_status' => 
      array (
        'name' => 'employee_status',
        'default' => true,
        'width' => 10,
      ),
      'title' => 
      array (
        'name' => 'title',
        'default' => true,
        'width' => 10,
      ),
      'phone' => 
      array (
        'name' => 'phone',
        'label' => 'LBL_ANY_PHONE',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      'department' => 
      array (
        'name' => 'department',
        'default' => true,
        'width' => 10,
      ),
      'puestousuario_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'label' => 'LBL_PUESTOUSUARIO',
        'width' => '10',
        'name' => 'puestousuario_c',
      ),
      'email' => 
      array (
        'name' => 'email',
        'label' => 'LBL_ANY_EMAIL',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      'address_street' => 
      array (
        'name' => 'address_street',
        'label' => 'LBL_ANY_ADDRESS',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      'address_city' => 
      array (
        'name' => 'address_city',
        'label' => 'LBL_CITY',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      'address_state' => 
      array (
        'name' => 'address_state',
        'label' => 'LBL_STATE',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      'address_postalcode' => 
      array (
        'name' => 'address_postalcode',
        'label' => 'LBL_POSTAL_CODE',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      'address_country' => 
      array (
        'name' => 'address_country',
        'label' => 'LBL_COUNTRY',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
    ),
  ),
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
);
