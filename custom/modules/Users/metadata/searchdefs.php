<?php
// created: 2024-05-21 12:49:42
$searchdefs['Users'] = array (
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
      ),
    ),
    'advanced_search' => 
    array (
      0 => 
      array (
        'name' => 'first_name',
        'default' => true,
        'width' => '10',
      ),
      1 => 
      array (
        'name' => 'last_name',
        'default' => true,
        'width' => '10',
      ),
      2 => 
      array (
        'name' => 'user_name',
        'default' => true,
        'width' => '10',
      ),
      3 => 
      array (
        'name' => 'status',
        'default' => true,
        'width' => '10',
      ),
      4 => 
      array (
        'name' => 'is_admin',
        'default' => true,
        'width' => '10',
      ),
      5 => 
      array (
        'type' => 'enum',
        'default' => true,
        'label' => 'LBL_PUESTOUSUARIO',
        'width' => '10',
        'name' => 'puestousuario_c',
      ),
      6 => 
      array (
        'type' => 'enum',
        'default' => true,
        'label' => 'LBL_SUBPUESTO',
        'width' => '10',
        'name' => 'subpuesto_c',
      ),
      7 => 
      array (
        'name' => 'title',
        'default' => true,
        'width' => '10',
      ),
      8 => 
      array (
        'name' => 'is_group',
        'default' => true,
        'width' => '10',
      ),
      9 => 
      array (
        'name' => 'department',
        'default' => true,
        'width' => '10',
      ),
      10 => 
      array (
        'name' => 'phone',
        'label' => 'LBL_ANY_PHONE',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      11 => 
      array (
        'name' => 'address_street',
        'label' => 'LBL_ANY_ADDRESS',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      12 => 
      array (
        'name' => 'email',
        'label' => 'LBL_ANY_EMAIL',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      13 => 
      array (
        'name' => 'address_city',
        'label' => 'LBL_CITY',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      14 => 
      array (
        'name' => 'address_state',
        'label' => 'LBL_STATE',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      15 => 
      array (
        'name' => 'address_postalcode',
        'label' => 'LBL_POSTAL_CODE',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      16 => 
      array (
        'name' => 'address_country',
        'label' => 'LBL_COUNTRY',
        'type' => 'name',
        'default' => true,
        'width' => '10',
      ),
      17 => 
      array (
        'readonly' => false,
        'type' => 'bool',
        'default' => true,
        'label' => 'LBL_CAC',
        'width' => 10,
        'name' => 'cac_c',
      ),
      18 => 
      array (
        'readonly' => false,
        'type' => 'multienum',
        'default' => true,
        'label' => 'LBL_POSICION_OPERATIVA',
        'width' => 10,
        'name' => 'posicion_operativa_c',
      ),
    ),
  ),
);