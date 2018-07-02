<?php
// created: 2017-10-28 12:44:08
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'name' => 'name',
    'vname' => 'LBL_LIST_OPPORTUNITY_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '10%',
    'default' => true,
  ),
  'estatus_c' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_ESTATUS',
    'width' => '10%',
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
    'width' => '10%',
  ),
  'amount' => 
  array (
    'type' => 'currency',
    'readonly' => false,
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'vname' => 'LBL_LIKELY',
    'currency_format' => true,
    'width' => '10%',
    'default' => true,
  ),
  'vigencialinea_c' => 
  array (
    'type' => 'date',
    'default' => true,
    'vname' => 'LBL_VIGENCIALINEA',
    'width' => '10%',
  ),
  'assigned_user_name' => 
  array (
    'name' => 'assigned_user_name',
    'vname' => 'LBL_LIST_ASSIGNED_TO_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'target_record_key' => 'assigned_user_id',
    'target_module' => 'Employees',
    'width' => '10%',
    'default' => true,
  ),
  'fecha_estimada_cierre_c' => 
  array (
    'type' => 'date',
    'default' => true,
    'vname' => 'LBL_FECHA_ESTIMADA_CIERRE',
    'width' => '10%',
  ),
  'currency_id' => 
  array (
    'usage' => 'query_only',
  ),
);