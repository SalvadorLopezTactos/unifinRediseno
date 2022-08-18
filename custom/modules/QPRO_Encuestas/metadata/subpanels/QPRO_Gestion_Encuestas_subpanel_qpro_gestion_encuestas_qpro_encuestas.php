<?php
// created: 2022-05-13 11:28:29
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'related_module' => 
  array (
    'readonly' => false,
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_RELATED_MODULE',
    'width' => 10,
  ),
  'cuenta' => 
  array (
    'readonly' => false,
    'type' => 'relate',
    'studio' => 'visible',
    'vname' => 'LBL_CUENTA',
    'id' => 'ACCOUNT_ID_C',
    'link' => true,
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Accounts',
    'target_record_key' => 'account_id_c',
  ),
  'lead' => 
  array (
    'readonly' => false,
    'type' => 'relate',
    'studio' => 'visible',
    'vname' => 'LBL_LEAD',
    'id' => 'LEAD_ID_C',
    'link' => true,
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Leads',
    'target_record_key' => 'lead_id_c',
  ),
  'usuario' => 
  array (
    'readonly' => false,
    'type' => 'relate',
    'studio' => 'visible',
    'vname' => 'LBL_USUARIO',
    'id' => 'USER_ID_C',
    'link' => true,
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Users',
    'target_record_key' => 'user_id_c',
  ),
  'fecha_envio' => 
  array (
    'readonly' => false,
    'type' => 'date',
    'vname' => 'LBL_FECHA_ENVIO',
    'width' => 10,
    'default' => true,
  ),
  'fecha_respuesta' => 
  array (
    'readonly' => false,
    'type' => 'date',
    'vname' => 'LBL_FECHA_RESPUESTA',
    'width' => 10,
    'default' => true,
  ),
);