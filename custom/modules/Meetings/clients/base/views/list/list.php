<?php
// created: 2024-05-21 12:55:59
$viewdefs['Meetings']['base']['view']['list'] = array (
  'panels' => 
  array (
    0 => 
    array (
      'label' => 'LBL_PANEL_1',
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'name',
          'label' => 'LBL_LIST_SUBJECT',
          'link' => true,
          'default' => true,
          'enabled' => true,
          'related_fields' => 
          array (
            0 => 'repeat_type',
          ),
        ),
        1 => 
        array (
          'name' => 'parent_name',
          'label' => 'LBL_LIST_RELATED_TO',
          'id' => 'PARENT_ID',
          'link' => true,
          'default' => true,
          'enabled' => true,
          'sortable' => false,
        ),
        2 => 
        array (
          'name' => 'date_start',
          'label' => 'LBL_LIST_DATE',
          'type' => 'datetimecombo-colorcoded',
          'css_class' => 'overflow-visible',
          'completed_status_value' => 'Held',
          'link' => false,
          'default' => true,
          'enabled' => true,
          'readonly' => true,
          'related_fields' => 
          array (
            0 => 'status',
          ),
        ),
        3 => 
        array (
          'name' => 'status',
          'type' => 'event-status',
          'label' => 'LBL_LIST_STATUS',
          'link' => false,
          'default' => true,
          'enabled' => true,
          'readonly' => true,
          'css_class' => 'full-width',
        ),
        4 => 
        array (
          'name' => 'date_end',
          'link' => false,
          'default' => false,
          'enabled' => true,
        ),
        5 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_LIST_ASSIGNED_USER',
          'id' => 'ASSIGNED_USER_ID',
          'default' => true,
          'enabled' => true,
        ),
        6 => 
        array (
          'name' => 'date_entered',
          'label' => 'LBL_DATE_ENTERED',
          'default' => true,
          'enabled' => true,
          'readonly' => true,
        ),
        7 => 
        array (
          'name' => 'team_name',
          'label' => 'LBL_LIST_TEAM',
          'default' => false,
          'enabled' => true,
        ),
      ),
    ),
  ),
);