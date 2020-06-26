<?php
$popupMeta = array (
    'moduleMain' => 'User',
    'varName' => 'USER',
    'orderBy' => 'user_name',
    'whereClauses' => array (
  'first_name' => 'users.first_name',
  'last_name' => 'users.last_name',
  'user_name' => 'users.user_name',
  'is_group' => 'users.is_group',
  'status' => 'users.status',
  'is_admin' => 'users.is_admin',
  'puestousuario_c' => 'users_cstm.puestousuario_c',
  'subpuesto_c' => 'users_cstm.subpuesto_c',
  'title' => 'users.title',
  'department' => 'users.department',
  'phone' => 'users.phone',
  'address_street' => 'users.address_street',
  'email' => 'users.email',
  'address_city' => 'users.address_city',
  'address_state' => 'users.address_state',
  'address_postalcode' => 'users.address_postalcode',
  'address_country' => 'users.address_country',
),
    'searchInputs' => array (
  0 => 'first_name',
  1 => 'last_name',
  2 => 'user_name',
  3 => 'is_group',
  4 => 'status',
  5 => 'is_admin',
  6 => 'puestousuario_c',
  7 => 'subpuesto_c',
  8 => 'title',
  9 => 'department',
  10 => 'phone',
  11 => 'address_street',
  12 => 'email',
  13 => 'address_city',
  14 => 'address_state',
  15 => 'address_postalcode',
  16 => 'address_country',
),
    'searchdefs' => array (
  'first_name' => 
  array (
    'name' => 'first_name',
    'width' => '10',
  ),
  'last_name' => 
  array (
    'name' => 'last_name',
    'width' => '10',
  ),
  'user_name' => 
  array (
    'name' => 'user_name',
    'width' => '10',
  ),
  'status' => 
  array (
    'name' => 'status',
    'width' => '10',
  ),
  'is_admin' => 
  array (
    'name' => 'is_admin',
    'width' => '10',
  ),
  'puestousuario_c' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_PUESTOUSUARIO',
    'width' => '10',
    'name' => 'puestousuario_c',
  ),
  'subpuesto_c' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_SUBPUESTO',
    'width' => 10,
    'name' => 'subpuesto_c',
  ),
  'title' => 
  array (
    'name' => 'title',
    'width' => '10',
  ),
  'is_group' => 
  array (
    'name' => 'is_group',
    'width' => '10',
  ),
  'department' => 
  array (
    'name' => 'department',
    'width' => '10',
  ),
  'phone' => 
  array (
    'name' => 'phone',
    'label' => 'LBL_ANY_PHONE',
    'type' => 'name',
    'width' => '10',
  ),
  'address_street' => 
  array (
    'name' => 'address_street',
    'label' => 'LBL_ANY_ADDRESS',
    'type' => 'name',
    'width' => '10',
  ),
  'email' => 
  array (
    'name' => 'email',
    'label' => 'LBL_ANY_EMAIL',
    'type' => 'name',
    'width' => '10',
  ),
  'address_city' => 
  array (
    'name' => 'address_city',
    'label' => 'LBL_CITY',
    'type' => 'name',
    'width' => '10',
  ),
  'address_state' => 
  array (
    'name' => 'address_state',
    'label' => 'LBL_STATE',
    'type' => 'name',
    'width' => '10',
  ),
  'address_postalcode' => 
  array (
    'name' => 'address_postalcode',
    'label' => 'LBL_POSTAL_CODE',
    'type' => 'name',
    'width' => '10',
  ),
  'address_country' => 
  array (
    'name' => 'address_country',
    'label' => 'LBL_COUNTRY',
    'type' => 'name',
    'width' => '10',
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'related_fields' => 
    array (
      0 => 'last_name',
      1 => 'first_name',
    ),
    'orderBy' => 'last_name',
    'default' => true,
    'name' => 'name',
  ),
  'USER_NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_USER_NAME',
    'link' => true,
    'default' => true,
    'name' => 'user_name',
  ),
  'TITLE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_TITLE',
    'width' => 10,
    'default' => true,
    'name' => 'title',
  ),
  'DEPARTMENT' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_DEPARTMENT',
    'width' => 10,
    'default' => true,
    'name' => 'department',
  ),
  'STATUS' => 
  array (
    'width' => 10,
    'label' => 'LBL_STATUS',
    'link' => false,
    'default' => true,
    'name' => 'status',
  ),
),
);
