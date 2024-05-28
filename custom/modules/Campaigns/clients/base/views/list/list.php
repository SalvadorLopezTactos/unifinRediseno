<?php
// created: 2024-05-21 12:55:59
$viewdefs['Campaigns']['base']['view']['list'] = array (
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
          'link' => true,
          'label' => 'LBL_LIST_NAME',
          'enabled' => true,
          'default' => true,
          'width' => '20',
        ),
        1 => 
        array (
          'name' => 'status',
          'label' => 'LBL_LIST_STATUS',
          'enabled' => true,
          'default' => true,
          'width' => '10',
        ),
        2 => 
        array (
          'name' => 'campaign_type',
          'label' => 'LBL_LIST_TYPE',
          'enabled' => true,
          'default' => true,
          'width' => '10',
        ),
        3 => 
        array (
          'name' => 'start_date',
          'label' => 'LBL_START_DATE',
          'enabled' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'end_date',
          'label' => 'LBL_LIST_END_DATE',
          'default' => true,
          'enabled' => true,
          'width' => '10',
        ),
        5 => 
        array (
          'name' => 'assigned_user_name',
          'module' => 'Users',
          'label' => 'LBL_LIST_ASSIGNED_USER',
          'id' => 'ASSIGNED_USER_ID',
          'sortable' => false,
          'default' => true,
          'enabled' => true,
          'width' => '8',
        ),
        6 => 
        array (
          'name' => 'date_entered',
          'type' => 'datetime',
          'label' => 'LBL_DATE_ENTERED',
          'enabled' => true,
          'default' => true,
          'readonly' => true,
          'width' => '10',
        ),
        7 => 
        array (
          'name' => 'team_name',
          'label' => 'LBL_TEAM',
          'default' => false,
          'enabled' => true,
          'width' => '15',
        ),
      ),
    ),
  ),
);