<?php
// created: 2018-07-11 13:58:08
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'name' => 'name',
    'vname' => 'LBL_LIST_OPPORTUNITY_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'estatus_c' => 
  array (
    'readonly' => true,
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_ESTATUS',
    'width' => 10,
  ),
  'monto_c' => 
  array (
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'type' => 'currency',
    'default' => true,
    'vname' => 'LBL_MONTO',
    'currency_format' => true,
    'width' => 10,
  ),
  'amount' => 
  array (
    'type' => 'currency',
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'readonly' => false,
    'vname' => 'LBL_LIKELY',
    'currency_format' => true,
    'width' => 10,
    'default' => true,
  ),
  'vigencialinea_c' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_VIGENCIALINEA',
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
  'fecha_estimada_cierre_c' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_FECHA_ESTIMADA_CIERRE',
    'width' => 10,
    'default' => true,
  ),
  'currency_id' => 
  array (
    'usage' => 'query_only',
  ),
);