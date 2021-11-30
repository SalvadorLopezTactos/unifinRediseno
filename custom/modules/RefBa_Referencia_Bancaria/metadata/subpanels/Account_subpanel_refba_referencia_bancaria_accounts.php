<?php
// created: 2015-07-21 23:01:00
$subpanel_layout['list_fields'] = array (
  'saldo_promedio' => 
  array (
    'type' => 'currency',
    'default' => true,
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'vname' => 'LBL_SALDO_PROMEDIO',
    'currency_format' => true,
    'width' => '10%',
  ),
  'linea_credito' => 
  array (
    'type' => 'currency',
    'default' => true,
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'vname' => 'LBL_LINEA_CREDITO',
    'currency_format' => true,
    'width' => '10%',
  ),
);