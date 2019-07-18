<?php
// created: 2019-07-17 11:11:29
$viewdefs['Accounts']['base']['view']['subpanel-for-accounts-members'] = array (
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
          'default' => true,
          'label' => 'LBL_LIST_ACCOUNT_NAME',
          'enabled' => true,
          'name' => 'name',
          'link' => true,
        ),
        1 => 
        array (
          'default' => true,
          'label' => 'LBL_LIST_CITY',
          'enabled' => true,
          'name' => 'billing_address_city',
        ),
        2 => 
        array (
          'type' => 'varchar',
          'default' => true,
          'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
          'enabled' => true,
          'name' => 'billing_address_country',
        ),
        3 => 
        array (
          'default' => true,
          'label' => 'LBL_LIST_PHONE',
          'enabled' => true,
          'name' => 'phone_office',
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