<?php
$listViewDefs['Employees'] = 
array (
  'name' => 
  array (
    'width' => '20',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'related_fields' => 
    array (
      0 => 'last_name',
      1 => 'first_name',
    ),
    'orderBy' => 'last_name',
    'default' => true,
  ),
  'employee_status' => 
  array (
    'width' => '10',
    'label' => 'LBL_LIST_EMPLOYEE_STATUS',
    'link' => false,
    'default' => true,
  ),
  'region_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_REGION',
    'width' => '10',
  ),
  'equipo_c' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_EQUIPO',
    'width' => '10',
  ),
  'puestousuario_c' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_PUESTOUSUARIO',
    'width' => '10',
  ),
  'subpuesto_c' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_SUBPUESTO',
    'width' => 10,
  ),
  'reports_to_name' => 
  array (
    'width' => '15',
    'label' => 'LBL_LIST_REPORTS_TO_NAME',
    'link' => true,
    'sortable' => false,
    'default' => true,
  ),
  'email' => 
  array (
    'width' => '15',
    'label' => 'LBL_LIST_EMAIL',
    'link' => true,
    'customCode' => '{$EMAIL_LINK}{$EMAIL}</a>',
    'default' => true,
    'sortable' => false,
  ),
  'phone_work' => 
  array (
    'width' => '10',
    'label' => 'LBL_LIST_PHONE',
    'link' => true,
    'default' => true,
  ),
  'ext_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_EXT',
    'width' => '10',
  ),
  'date_entered' => 
  array (
    'width' => '10',
    'label' => 'LBL_DATE_ENTERED',
    'default' => true,
  ),
);
