<?php
// created: 2020-08-20 10:38:27
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
          'name' => 'prima_obj_c',
          'label' => 'LBL_PRIMA_OBJ_C',
          'enabled' => true,
          'type' => 'currency',
          'currency_format' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'prima_neta_ganada_c',
          'label' => 'LBL_PRIMA_NETA_GANADA',
          'enabled' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'fecha_ini_c',
          'label' => 'LBL_FECHA_INI_C',
          'enabled' => true,
          'default' => true,
        ),
        5 => 
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
);