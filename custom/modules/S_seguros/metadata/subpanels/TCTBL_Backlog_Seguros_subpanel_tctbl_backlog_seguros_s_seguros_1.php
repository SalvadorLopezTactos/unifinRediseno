<?php
// created: 2024-01-29 14:14:12
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
  'tipo_registro_sf_c' => 
  array (
    'readonly_formula' => '',
    'readonly' => false,
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_TIPO_REGISTRO_SF',
    'width' => 10,
  ),
  'ejecutivo_c' => 
  array (
    'readonly_formula' => '',
    'readonly' => false,
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_EJECUTIVO',
    'width' => 10,
  ),
  'prima_obj_c' => 
  array (
    'readonly' => false,
    'type' => 'decimal',
    'default' => true,
    'vname' => 'LBL_PRIMA_OBJ_C',
    'width' => 10,
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
);