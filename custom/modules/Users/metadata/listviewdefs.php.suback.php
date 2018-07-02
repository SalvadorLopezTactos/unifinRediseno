<?php
// created: 2018-02-16 18:51:04
$listViewDefs['Users'] = array (
  'name' => 
  array (
    'width' => '20%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'related_fields' => 
    array (
      0 => 'last_name',
      1 => 'first_name',
    ),
    'orderBy' => 'last_name',
    'default' => true,
  ),
  'user_name' => 
  array (
    'width' => '15%',
    'label' => 'LBL_USER_NAME',
    'link' => true,
    'default' => true,
  ),
  'reports_to_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_REPORTS_TO_NAME',
    'id' => 'REPORTS_TO_ID',
    'sortable' => false,
    'width' => '20%',
    'default' => true,
  ),
  'email' => 
  array (
    'width' => '20%',
    'sortable' => false,
    'label' => 'LBL_LIST_EMAIL',
    'link' => true,
    'default' => true,
  ),
  'status' => 
  array (
    'width' => '10%',
    'label' => 'LBL_STATUS',
    'link' => false,
    'default' => true,
  ),
  'is_admin' => 
  array (
    'width' => '10%',
    'label' => 'LBL_ADMIN',
    'link' => false,
    'default' => true,
  ),
  'is_group' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_GROUP',
    'link' => true,
    'default' => false,
  ),
);