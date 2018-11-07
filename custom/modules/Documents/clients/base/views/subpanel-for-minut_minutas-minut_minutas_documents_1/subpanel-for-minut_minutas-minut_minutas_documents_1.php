
<?php
// created: 2018-11-06 18:55:34
$viewdefs['Documents']['base']['view']['subpanel-for-minut_minutas-minut_minutas_documents_1'] = array (
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
          'label' => 'LBL_NAME',
          'enabled' => true,
          'default' => true,
        ),
        1 =>
        array (
          'name' => 'document_name',
          'label' => 'LBL_LIST_DOCUMENT_NAME',
          'enabled' => true,
          'default' => true,
          'link' => true,
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
          'name' => 'status_id',
          'label' => 'LBL_LIST_STATUS',
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
      // 1 =>
      // array (
      //   'type' => 'unlink-action',
      //   'icon' => 'fa-chain-broken',
      //   'label' => 'LBL_UNLINK_BUTTON',
      // ),
    ),
  ),
  'type' => 'subpanel-list',
);
