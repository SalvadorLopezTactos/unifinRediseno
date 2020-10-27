<?php
// created: 2020-10-26 18:58:30
$viewdefs['S_seguros']['base']['view']['subpanel-for-accounts-s_seguros_accounts'] = array (
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
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'ejecutivo_c',
          'label' => 'LBL_EJECUTIVO',
          'enabled' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'prima_obj_c',
          'label' => 'LBL_PRIMA_OBJ_C',
          'enabled' => true,
          'type' => 'currency',
          'currency_format' => true,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'prima_neta_ganada_c',
          'label' => 'LBL_PRIMA_NETA_GANADA',
          'type' => 'currency',
          'enabled' => true,
          'default' => true,
        ),
        6 => 
        array (
          'name' => 'fecha_ini_c',
          'label' => 'LBL_FECHA_INI_C',
          'enabled' => true,
          'default' => true,
        ),
        7 => 
        array (
          'label' => 'LBL_DATE_MODIFIED',
          'enabled' => true,
          'default' => true,
          'name' => 'date_modified',
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
  'rowactions' => 
  array (
    'actions' => 
    array (
      0 => 
      array (
        'type' => 'rowaction',
        'css_class' => 'btn',
        'tooltip' => 'LBL_PREVIEW',
        'event' => 'list:preview:fire',
        'icon' => 'fa-eye',
        'acl_action' => 'view',
        'allow_bwc' => false,
      ),
    ),
  ),
);