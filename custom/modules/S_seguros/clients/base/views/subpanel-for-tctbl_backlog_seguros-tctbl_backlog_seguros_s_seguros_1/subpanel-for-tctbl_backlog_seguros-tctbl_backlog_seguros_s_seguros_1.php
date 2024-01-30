<?php
// created: 2024-01-29 14:14:12
$viewdefs['S_seguros']['base']['view']['subpanel-for-tctbl_backlog_seguros-tctbl_backlog_seguros_s_seguros_1'] = array (
  'panels' => 
  array (
    0 => 
    array (
      'name' => 'panel_header',
      'label' => 'LBL_PANEL_1',
      'fields' => 
      array (
        0 => 
        array (
          'label' => 'LBL_NAME',
          'enabled' => true,
          'default' => true,
          'name' => 'name',
          'link' => true,
        ),
        1 => 
        array (
          'name' => 'etapa',
          'label' => 'LBL_ETAPA',
          'enabled' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'tipo_registro_sf_c',
          'label' => 'LBL_TIPO_REGISTRO_SF',
          'enabled' => true,
          'readonly' => false,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'ejecutivo_c',
          'label' => 'LBL_EJECUTIVO',
          'enabled' => true,
          'readonly' => false,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'prima_obj_c',
          'label' => 'LBL_PRIMA_OBJ_C',
          'enabled' => true,
          'readonly' => false,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_ASSIGNED_TO',
          'enabled' => true,
          'related_fields' => 
          array (
            0 => 'assigned_user_id',
          ),
          'id' => 'ASSIGNED_USER_ID',
          'link' => true,
          'default' => true,
        ),
      ),
    ),
  ),
  'orderBy' => 
  array (
    'field' => 'date_modified',
    'direction' => 'desc',
  ),
  'type' => 'subpanel-list',
);