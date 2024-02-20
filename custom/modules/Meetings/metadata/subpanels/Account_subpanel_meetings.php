<?php
// created: 2024-02-19 20:42:59
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'name' => 'name',
    'vname' => 'LBL_LIST_SUBJECT',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'status' => 
  array (
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_STATUS',
    'width' => 10,
  ),
  'date_start' => 
  array (
    'name' => 'date_start',
    'vname' => 'LBL_LIST_DATE',
    'width' => 10,
    'default' => true,
  ),
  'date_end' => 
  array (
    'name' => 'date_end',
    'vname' => 'LBL_DATE_END',
    'width' => 10,
    'default' => true,
  ),
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'related_fields' => 
    array (
      0 => 'assigned_user_id',
    ),
    'vname' => 'LBL_ASSIGNED_TO',
    'id' => 'ASSIGNED_USER_ID',
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Users',
    'target_record_key' => 'assigned_user_id',
  ),
  'check_in_time_c' => 
  array (
    'readonly' => false,
    'type' => 'datetimecombo',
    'vname' => 'LBL_CHECK_IN_TIME',
    'width' => 10,
    'default' => true,
  ),
  'check_in_platform_c' => 
  array (
    'readonly' => false,
    'type' => 'varchar',
    'vname' => 'LBL_CHECK_IN_PLATFORM_C',
    'width' => 10,
    'default' => true,
  ),
  'check_in_latitude_c' => 
  array (
    'readonly' => false,
    'type' => 'float',
    'vname' => 'LBL_CHECK_IN_LATITUDE',
    'width' => 10,
    'default' => true,
  ),
  'check_in_longitude_c' => 
  array (
    'readonly' => false,
    'type' => 'float',
    'vname' => 'LBL_CHECK_IN_LONGITUDE',
    'width' => 10,
    'default' => true,
  ),
  'minuta_reunion_status_c' => 
  array (
    'readonly_formula' => '',
    'readonly' => false,
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_MINUTA_REUNION_STATUS',
    'width' => 10,
  ),
  'recurring_source' => 
  array (
    'usage' => 'query_only',
  ),
);