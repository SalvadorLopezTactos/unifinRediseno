<?php
// created: 2020-02-07 12:25:05
$viewdefs['Tasks']['base']['view']['subpanel-for-accounts-tasks'] = array (
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
          'label' => 'LBL_LIST_SUBJECT',
          'enabled' => true,
          'default' => true,
          'link' => true,
          'name' => 'name',
        ),
        1 => 
        array (
          'label' => 'LBL_LIST_STATUS',
          'enabled' => true,
          'default' => true,
          'name' => 'status',
        ),
        2 => 
        array (
          'name' => 'date_start',
          'label' => 'LBL_LIST_START_DATE',
          'css_class' => 'overflow-visible',
          'enabled' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'date_due',
          'label' => 'LBL_LIST_DUE_DATE',
          'type' => 'datetimecombo-colorcoded',
          'completed_status_value' => 'Completed',
          'link' => false,
          'css_class' => 'overflow-visible',
          'enabled' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
          'id' => 'ASSIGNED_USER_ID',
          'enabled' => true,
          'default' => true,
        ),
      ),
    ),
  ),
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
      ),
      1 => 
      array (
        'type' => 'rowaction',
        'name' => 'edit_button',
        'icon' => 'fa-pencil',
        'label' => 'LBL_EDIT_BUTTON',
        'event' => 'list:editrow:fire',
        'acl_action' => 'edit',
      ),
    ),
  ),
  'type' => 'subpanel-list',
);