<?php
// created: 2020-07-01 17:02:06
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
          'name' => 'prima_obj',
          'label' => 'LBL_PRIMA_OBJ',
          'enabled' => true,
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'currency_format' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'prima_neta',
          'label' => 'LBL_PRIMA_NETA',
          'enabled' => true,
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'currency_format' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'fecha_ini',
          'label' => 'LBL_FECHA_INI',
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