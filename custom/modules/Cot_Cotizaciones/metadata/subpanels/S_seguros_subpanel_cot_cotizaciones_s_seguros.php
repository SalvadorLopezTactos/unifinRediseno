<?php
// created: 2022-08-12 14:35:37
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'int_prima_neta' => 
  array (
    'readonly' => false,
    'type' => 'currency',
    'default' => true,
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'vname' => 'LBL_INT_PRIMA_NETA',
    'currency_format' => true,
    'width' => 10,
  ),
  'aseguradora_c' => 
  array (
    'readonly_formula' => '',
    'readonly' => false,
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_ASEGURADORA',
    'width' => 10,
  ),
  'int_comision' => 
  array (
    'readonly' => false,
    'type' => 'currency',
    'default' => true,
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'vname' => 'LBL_INT_COMISION',
    'currency_format' => true,
    'width' => 10,
  ),
  'cot_ganada_c' => 
  array (
    'readonly_formula' => '',
    'readonly' => false,
    'type' => 'bool',
    'default' => true,
    'vname' => 'LBL_COT_GANADA_C',
    'width' => 10,
  ),
  'date_modified' => 
  array (
    'vname' => 'LBL_DATE_MODIFIED',
    'width' => 10,
    'default' => true,
  ),
);