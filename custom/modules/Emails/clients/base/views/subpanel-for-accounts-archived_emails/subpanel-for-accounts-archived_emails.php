<?php
// created: 2019-07-24 00:39:21
$viewdefs['Emails']['base']['view']['subpanel-for-accounts-archived_emails'] = array (
  'type' => 'subpanel-list',
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
          'name' => 'from_collection',
          'type' => 'from',
          'label' => 'LBL_LIST_FROM_ADDR',
          'enabled' => true,
          'default' => true,
          'readonly' => true,
          'sortable' => false,
          'fields' =>
          array (
            0 => 'email_address_id',
            1 => 'email_address',
            2 => 'parent_type',
            3 => 'parent_id',
            4 => 'parent_name',
            5 => 'invalid_email',
            6 => 'opt_out',
          ),
        ),
        1 =>
        array (
          'name' => 'name',
          'enabled' => true,
          'default' => true,
          'link' => 'true',
          'readonly' => true,
          'width' => 'xlarge',
          'related_fields' =>
          array (
            0 => 'total_attachments',
            1 => 'state',
          ),
        ),
        2 =>
        array (
          'name' => 'state',
          'label' => 'LBL_LIST_STATUS',
          'enabled' => true,
          'default' => true,
          'readonly' => true,
        ),
        3 =>
        array (
          'name' => 'date_sent',
          'label' => 'LBL_LIST_DATE_COLUMN',
          'enabled' => true,
          'default' => true,
          'readonly' => true,
        ),
        4 =>
        array (
          'name' => 'parent_name',
          'link' => true,
          'enabled' => true,
          'default' => true,
          'sortable' => false,
        ),
        5 =>
        array (
          'name' => 'assigned_user_name',
          'target_record_key' => 'assigned_user_id',
          'target_module' => 'Employees',
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
    ),
  ),
);
