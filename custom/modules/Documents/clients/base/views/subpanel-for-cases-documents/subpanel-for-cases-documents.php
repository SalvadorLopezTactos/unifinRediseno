<?php
// created: 2022-09-21 12:41:35
$viewdefs['Documents']['base']['view']['subpanel-for-cases-documents'] = array (
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
          'name' => 'tipo_documento_c',
          'label' => 'LBL_TIPO_DOCUMENTO',
          'enabled' => true,
          'readonly' => false,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'filename',
          'label' => 'LBL_LIST_FILENAME',
          'enabled' => true,
          'default' => true,
          'readonly' => true,
        ),
        3 => 
        array (
          'name' => 'category_id',
          'label' => 'LBL_LIST_CATEGORY',
          'enabled' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'doc_type',
          'label' => 'LBL_LIST_DOC_TYPE',
          'enabled' => true,
          'default' => true,
          'readonly' => true,
        ),
        5 => 
        array (
          'name' => 'status_id',
          'label' => 'LBL_LIST_STATUS',
          'enabled' => true,
          'default' => true,
        ),
        6 => 
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
      1 => 
      array (
        'type' => 'unlink-action',
        'name' => 'unlink_button',
        'icon' => 'fa-chain-broken',
        'label' => 'LBL_UNLINK_BUTTON',
      ),
    ),
  ),
  'type' => 'subpanel-list',
);