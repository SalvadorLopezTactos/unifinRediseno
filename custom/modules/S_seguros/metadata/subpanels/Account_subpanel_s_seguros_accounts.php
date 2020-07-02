<?php
// created: 2020-07-01 17:02:05
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'etapa' => 
  array (
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_ETAPA',
    'width' => 10,
  ),
  'prima_obj' => 
  array (
    'type' => 'currency',
    'default' => true,
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'vname' => 'LBL_PRIMA_OBJ',
    'currency_format' => true,
    'width' => 10,
  ),
  'prima_neta' => 
  array (
    'type' => 'currency',
    'default' => true,
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'vname' => 'LBL_PRIMA_NETA',
    'currency_format' => true,
    'width' => 10,
  ),
  'fecha_ini' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_FECHA_INI',
    'width' => 10,
    'default' => true,
  ),
  'date_modified' => 
  array (
    'vname' => 'LBL_DATE_MODIFIED',
    'width' => 10,
    'default' => true,
  ),
);