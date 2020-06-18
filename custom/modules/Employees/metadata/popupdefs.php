<?php
$popupMeta = array (
    'moduleMain' => 'Employees',
    'varName' => 'Employees',
    'orderBy' => 'employees.first_name, employees.last_name',
    'whereClauses' => array (
  'first_name' => 'employees.first_name',
  'last_name' => 'employees.last_name',
  'employee_status' => 'employees.employee_status',
  'title' => 'employees.title',
  'phone' => 'employees.phone',
  'department' => 'employees.department',
  'puestousuario_c' => 'employees_cstm.puestousuario_c',
  'email' => 'employees.email',
  'address_street' => 'employees.address_street',
  'address_city' => 'employees.address_city',
  'address_state' => 'employees.address_state',
  'address_postalcode' => 'employees.address_postalcode',
  'address_country' => 'employees.address_country',
),
    'searchInputs' => array (
  0 => 'first_name',
  1 => 'last_name',
  2 => 'employee_status',
  3 => 'title',
  4 => 'phone',
  5 => 'department',
  6 => 'puestousuario_c',
  7 => 'email',
  8 => 'address_street',
  9 => 'address_city',
  10 => 'address_state',
  11 => 'address_postalcode',
  12 => 'address_country',
),
    'searchdefs' => array (
  'first_name' => 
  array (
    'name' => 'first_name',
    'width' => 10,
  ),
  'last_name' => 
  array (
    'name' => 'last_name',
    'width' => 10,
  ),
  'employee_status' => 
  array (
    'name' => 'employee_status',
    'width' => 10,
  ),
  'title' => 
  array (
    'name' => 'title',
    'width' => 10,
  ),
  'phone' => 
  array (
    'name' => 'phone',
    'label' => 'LBL_ANY_PHONE',
    'type' => 'name',
    'width' => '10',
  ),
  'department' => 
  array (
    'name' => 'department',
    'width' => 10,
  ),
  'puestousuario_c' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_PUESTOUSUARIO',
    'width' => 10,
    'name' => 'puestousuario_c',
  ),
  'email' => 
  array (
    'name' => 'email',
    'label' => 'LBL_ANY_EMAIL',
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
  'DEPARTMENT' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_DEPARTMENT',
    'width' => 10,
    'default' => true,
    'name' => 'department',
  ),
  'PUESTOUSUARIO_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_PUESTOUSUARIO',
    'width' => 10,
    'name' => 'puestousuario_c',
  ),
  'TITLE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_TITLE',
    'width' => 10,
    'default' => true,
    'name' => 'title',
  ),
  'REPORTS_TO_NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_REPORTS_TO_NAME',
    'link' => true,
    'sortable' => false,
    'default' => true,
    'name' => 'reports_to_name',
  ),
  'EMAIL' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_EMAIL',
    'link' => true,
    'customCode' => '{$EMAIL_LINK}{$EMAIL}</a>',
    'default' => true,
    'sortable' => false,
    'name' => 'email',
  ),
  'PHONE_WORK' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_PHONE',
    'link' => true,
    'default' => true,
    'name' => 'phone_work',
  ),
  'EMPLOYEE_STATUS' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_EMPLOYEE_STATUS',
    'link' => false,
    'default' => true,
    'name' => 'employee_status',
  ),
  'DATE_ENTERED' => 
  array (
    'width' => 10,
    'label' => 'LBL_DATE_ENTERED',
    'default' => true,
    'name' => 'date_entered',
  ),
),
);
