<?php
$popupMeta = array (
    'moduleMain' => 'Lead',
    'varName' => 'LEAD',
    'orderBy' => 'last_name, first_name',
    'whereClauses' => array (
  'lead_source' => 'leads.lead_source',
  'status' => 'leads.status',
  'account_name' => 'leads.account_name',
  'assigned_user_id' => 'leads.assigned_user_id',
  'name' => 'leads.name',
  'name_c' => 'leads_cstm.name_c',
  'email' => 'leads.email',
),
    'searchInputs' => array (
  2 => 'lead_source',
  3 => 'status',
  4 => 'account_name',
  5 => 'assigned_user_id',
  6 => 'name',
  7 => 'name_c',
  8 => 'email',
),
    'searchdefs' => array (
  'name' => 
  array (
    'type' => 'fullname',
    'label' => 'LBL_NAME',
    'width' => 10,
    'name' => 'name',
  ),
  'name_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_NAME',
    'width' => 10,
    'name' => 'name_c',
  ),
  'email' => 
  array (
    'name' => 'email',
    'width' => 10,
  ),
  'account_name' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ACCOUNT_NAME',
    'width' => '10',
    'name' => 'account_name',
  ),
  'lead_source' => 
  array (
    'name' => 'lead_source',
    'width' => '10',
  ),
  'status' => 
  array (
    'name' => 'status',
    'width' => '10',
  ),
  'assigned_user_id' => 
  array (
    'name' => 'assigned_user_id',
    'type' => 'enum',
    'label' => 'LBL_ASSIGNED_TO',
    'function' => 
    array (
      'name' => 'get_user_array',
      'params' => 
      array (
        0 => false,
      ),
    ),
    'width' => '10',
  ),
),
    'listviewdefs' => array (
  'NAME_C' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_NAME',
    'width' => 10,
    'default' => true,
    'name' => 'name_c',
  ),
  'STATUS' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_STATUS',
    'default' => true,
    'name' => 'status',
  ),
  'ACCOUNT_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ACCOUNT_NAME',
    'width' => 10,
    'default' => true,
    'name' => 'account_name',
  ),
  'PHONE_WORK' => 
  array (
    'type' => 'phone',
    'label' => 'LBL_OFFICE_PHONE',
    'width' => 10,
    'default' => true,
    'name' => 'phone_work',
  ),
),
);
