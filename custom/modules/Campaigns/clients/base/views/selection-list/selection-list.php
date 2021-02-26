<?php
$viewdefs['Campaigns'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'selection-list' => 
      array (
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
              ),
              1 => 
              array (
                'name' => 'status',
                'label' => 'LBL_LIST_STATUS',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'campaign_type',
                'label' => 'LBL_LIST_TYPE',
                'enabled' => true,
                'default' => true,
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
              ),
              5 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'default' => false,
                'enabled' => true,
              ),
              6 => 
              array (
                'name' => 'assigned_user_name',
                'module' => 'Users',
                'label' => 'LBL_LIST_ASSIGNED_USER',
                'id' => 'ASSIGNED_USER_ID',
                'sortable' => false,
                'default' => false,
                'enabled' => true,
              ),
              7 => 
              array (
                'name' => 'date_entered',
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'default' => false,
                'readonly' => true,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
