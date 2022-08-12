<?php
// created: 2022-08-12 14:35:37
$viewdefs['Cot_Cotizaciones']['base']['view']['subpanel-for-s_seguros-cot_cotizaciones_s_seguros'] = array (
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
          'name' => 'int_prima_neta',
          'label' => 'LBL_INT_PRIMA_NETA',
          'enabled' => true,
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'readonly' => false,
          'currency_format' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'aseguradora_c',
          'label' => 'LBL_ASEGURADORA',
          'enabled' => true,
          'readonly' => false,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'int_comision',
          'label' => 'LBL_INT_COMISION',
          'enabled' => true,
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'readonly' => false,
          'currency_format' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'cot_ganada_c',
          'label' => 'LBL_COT_GANADA_C',
          'enabled' => true,
          'readonly' => false,
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