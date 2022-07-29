<?php
// created: 2018-12-06 16:05:35
$listViewDefs['Documents'] = array (
  'document_name' => 
  array (
    'width' => '20',
    'label' => 'LBL_DOCUMENT_NAME',
    'link' => true,
    'default' => true,
    'bold' => true,
  ),
  'filename' => 
  array (
    'width' => '20',
    'label' => 'LBL_FILENAME',
    'link' => true,
    'default' => true,
    'bold' => false,
    'displayParams' => 
    array (
      'module' => 'Documents',
    ),
    'sortable' => false,
    'related_fields' => 
    array (
      0 => 'document_revision_id',
      1 => 'doc_id',
      2 => 'doc_type',
      3 => 'doc_url',
    ),
  ),
  'assigned_user_name' => 
  array (
    'width' => '10',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'team_name' => 
  array (
    'width' => '2',
    'label' => 'LBL_LIST_TEAM',
    'default' => false,
    'sortable' => false,
  ),
  'date_entered' => 
  array (
    'width' => '10',
    'label' => 'LBL_DATE_ENTERED',
    'default' => false,
  ),
  'modified_by_name' => 
  array (
    'width' => '10',
    'label' => 'LBL_MODIFIED_USER',
    'module' => 'Users',
    'id' => 'USERS_ID',
    'default' => false,
    'sortable' => false,
    'related_fields' => 
    array (
      0 => 'modified_user_id',
    ),
  ),
);