<?php
// created: 2018-12-06 16:16:13
$viewdefs['Opportunities']['base']['view']['subpanel-for-accounts'] = array (
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
          'name' => 'name',
          'default' => true,
          'label' => 'LBL_LIST_OPPORTUNITY_NAME',
          'enabled' => true,
          'link' => true,
          'type' => 'name',
        ),
        1 => 
        array (
          'type' => 'varchar',
          'default' => true,
          'label' => 'LBL_TCT_ESTAPA_SUBETAPA_TXF',
          'enabled' => true,
          'name' => 'tct_estapa_subetapa_txf_c',
        ),
        2 => 
        array (
          'type' => 'currency',
          'default' => true,
          'label' => 'LBL_MONTO',
          'enabled' => true,
          'name' => 'monto_c',
        ),
        3 => 
        array (
          'type' => 'currency',
          'default' => true,
          'label' => 'LBL_LIKELY',
          'enabled' => true,
          'name' => 'amount',
        ),
        4 => 
        array (
          'type' => 'date',
          'default' => true,
          'label' => 'LBL_VIGENCIALINEA',
          'enabled' => true,
          'name' => 'vigencialinea_c',
        ),
        5 => 
        array (
          'name' => 'assigned_user_name',
          'target_record_key' => 'assigned_user_id',
          'target_module' => 'Employees',
          'default' => true,
          'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
          'enabled' => true,
          'link' => true,
          'type' => 'relate',
        ),
      ),
    ),
  ),
  'type' => 'subpanel-list',
);