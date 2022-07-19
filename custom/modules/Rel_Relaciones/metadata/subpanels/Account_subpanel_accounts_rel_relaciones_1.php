<?php
// created: 2022-07-18 19:12:01
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'relaciones_activas' => 
  array (
    'type' => 'multienum',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_RELACIONES_ACTIVAS',
    'width' => 10,
  ),
  'relacion_c' => 
  array (
    'readonly_formula' => '',
    'readonly' => false,
    'type' => 'relate',
    'studio' => 'visible',
    'vname' => 'LBL_RELACION',
    'id' => 'ACCOUNT_ID1_C',
    'link' => true,
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Accounts',
    'target_record_key' => 'account_id1_c',
  ),
  'date_modified' => 
  array (
    'vname' => 'LBL_DATE_MODIFIED',
    'width' => 10,
    'default' => true,
  ),
);