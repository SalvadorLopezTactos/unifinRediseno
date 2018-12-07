<?php
// created: 2018-12-06 16:16:13
$viewdefs['Opportunities']['base']['view']['subpanel-for-emails'] = array (
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
          'label' => 'LBL_SALES_STATUS',
          'enabled' => true,
          'name' => 'sales_status',
        ),
      ),
    ),
  ),
  'type' => 'subpanel-list',
);