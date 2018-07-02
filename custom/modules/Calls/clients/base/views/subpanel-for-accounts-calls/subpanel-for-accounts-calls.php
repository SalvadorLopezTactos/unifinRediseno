<?php
// created: 2018-03-14 09:30:05
$viewdefs['Calls']['base']['view']['subpanel-for-accounts-calls'] = array (
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
          'label' => 'LBL_STATUS',
          'enabled' => true,
          'default' => true,
          'name' => 'status',
          'type' => 'event-status',
          'css_class' => 'full-width',
        ),
        2 => 
        array (
          'name' => 'date_start',
          'label' => 'LBL_LIST_DATE',
          'type' => 'datetimecombo-colorcoded',
          'completed_status_value' => 'Held',
          'enabled' => true,
          'default' => true,
          'css_class' => 'overflow-visible',
          'readonly' => true,
          'related_fields' => 
          array (
            0 => 'status',
          ),
        ),
        3 => 
        array (
          'label' => 'LBL_DATE_END',
          'enabled' => true,
          'default' => true,
          'name' => 'date_end',
          'css_class' => 'overflow-visible',
        ),
        4 => 
        array (
          'name' => 'parent_type',
          'label' => 'LBL_PARENT_TYPE',
          'enabled' => true,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'parent_name',
          'label' => 'LBL_LIST_RELATED_TO',
          'enabled' => true,
          'id' => 'PARENT_ID',
          'link' => true,
          'sortable' => false,
          'default' => true,
        ),
        6 => 
        array (
          'name' => 'assigned_user_name',
          'target_record_key' => 'assigned_user_id',
          'target_module' => 'Employees',
          'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
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
      2 => 
      array (
        'type' => 'unlink-action',
        'icon' => 'fa-chain-broken',
        'label' => 'LBL_UNLINK_BUTTON',
      ),
      3 => 
      array (
        'type' => 'closebutton',
        'icon' => 'fa-times-circle',
        'name' => 'record-close',
        'label' => 'LBL_CLOSE_BUTTON_TITLE',
        'closed_status' => 'Held',
        'acl_action' => 'edit',
      ),
    ),
  ),
  'type' => 'subpanel-list',
);