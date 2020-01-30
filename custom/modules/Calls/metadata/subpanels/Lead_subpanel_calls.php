<?php
// created: 2020-01-30 12:06:14
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_LIST_SUBJECT',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'status' => 
  array (
    'widget_class' => 'SubPanelActivitiesStatusField',
    'vname' => 'LBL_STATUS',
    'width' => 10,
    'default' => true,
  ),
  'tct_resultado_llamada_ddw_c' => 
  array (
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_TCT_RESULTADO_LLAMADA_DDW',
    'width' => 10,
  ),
  'date_start' => 
  array (
    'vname' => 'LBL_DATE_TIME',
    'width' => 10,
    'default' => true,
  ),
  'date_end' => 
  array (
    'type' => 'datetimecombo',
    'studio' => 
    array (
      'recordview' => false,
      'wirelesseditview' => false,
    ),
    'readonly' => true,
    'vname' => 'LBL_CALENDAR_END_DATE',
    'width' => 10,
    'default' => true,
  ),
  'assigned_user_name' => 
  array (
    'name' => 'assigned_user_name',
    'vname' => 'LBL_LIST_ASSIGNED_TO_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'target_record_key' => 'assigned_user_id',
    'target_module' => 'Employees',
    'width' => 10,
    'default' => true,
  ),
  'time_start' => 
  array (
    'usage' => 'query_only',
  ),
  'recurring_source' => 
  array (
    'usage' => 'query_only',
  ),
);