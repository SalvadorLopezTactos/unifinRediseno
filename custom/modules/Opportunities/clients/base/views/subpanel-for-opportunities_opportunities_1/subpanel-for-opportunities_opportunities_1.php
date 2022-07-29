<?php
// created: 2018-12-06 16:16:13
$viewdefs['Opportunities']['base']['view']['subpanel-for-opportunities_opportunities_1'] = array (
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
          'target_record_key' => 'account_id',
          'target_module' => 'Accounts',
          'default' => true,
          'label' => 'LBL_LIST_ACCOUNT_NAME',
          'enabled' => true,
          'name' => 'account_name',
          'link' => true,
          'type' => 'relate',
        ),
        2 => 
        array (
          'type' => 'enum',
          'default' => true,
          'label' => 'LBL_TCT_ETAPA_DDW_C',
          'enabled' => true,
          'name' => 'tct_etapa_ddw_c',
        ),
        3 => 
        array (
          'type' => 'enum',
          'default' => true,
          'label' => 'LBL_ESTATUS',
          'enabled' => true,
          'name' => 'estatus_c',
        ),
        4 => 
        array (
          'type' => 'currency',
          'default' => true,
          'label' => 'LBL_LIKELY',
          'enabled' => true,
          'name' => 'amount',
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
        6 => 
        array (
          'name' => 'date_closed',
          'default' => true,
          'label' => 'LBL_DATE_CLOSED',
          'enabled' => true,
          'type' => 'date',
        ),
      ),
    ),
  ),
  'type' => 'subpanel-list',
);