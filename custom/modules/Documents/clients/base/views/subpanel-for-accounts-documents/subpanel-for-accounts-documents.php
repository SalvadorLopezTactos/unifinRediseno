<?php
// created: 2019-07-17 11:05:29
$viewdefs['Documents']['base']['view']['subpanel-for-accounts-documents'] = array (
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
          'name' => 'document_name',
          'label' => 'LBL_LIST_DOCUMENT_NAME',
          'enabled' => true,
          'default' => true,
          'link' => true,
        ),
        1 => 
        array (
          'name' => 'filename',
          'label' => 'LBL_LIST_FILENAME',
          'enabled' => true,
          'default' => true,
          'readonly' => true,
        ),
        2 => 
        array (
          'name' => 'category_id',
          'label' => 'LBL_LIST_CATEGORY',
          'enabled' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'doc_type',
          'label' => 'LBL_LIST_DOC_TYPE',
          'enabled' => true,
          'default' => true,
          'readonly' => true,
        ),
        4 => 
        array (
          'name' => 'status_id',
          'label' => 'LBL_LIST_STATUS',
          'enabled' => true,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'active_date',
          'label' => 'LBL_LIST_ACTIVE_DATE',
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