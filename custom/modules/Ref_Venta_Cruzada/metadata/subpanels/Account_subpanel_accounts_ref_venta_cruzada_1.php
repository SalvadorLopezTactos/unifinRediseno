<?php
// created: 2020-07-23 17:50:51
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'vname' => 'LBL_DATE_ENTERED',
    'width' => 10,
    'default' => true,
  ),
  'estatus' => 
  array (
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_ESTATUS',
    'width' => 10,
  ),
  'numero_anexos' => 
  array (
    'type' => 'int',
    'default' => true,
    'vname' => 'LBL_NUMERO_ANEXOS',
    'width' => 10,
  ),
  'ultima_fecha_anexo' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_ULTIMA_FECHA_ANEXO',
    'width' => 10,
    'default' => true,
  ),
  'motivo_rechazo' => 
  array (
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_MOTIVO_RECHAZO',
    'width' => 10,
  ),
);