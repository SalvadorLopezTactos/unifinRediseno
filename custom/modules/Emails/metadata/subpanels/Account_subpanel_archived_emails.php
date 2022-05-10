<?php
// created: 2019-07-24 00:39:21
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'name' => 'name',
    'vname' => 'LBL_LIST_SUBJECT',
    'width' => 10,
    'default' => true,
  ),
  'state' => 
  array (
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_EMAIL_STATE',
    'width' => 10,
  ),
  'date_sent' => 
  array (
    'type' => 'datetime',
    'vname' => 'LBL_DATE_SENT',
    'width' => 10,
    'default' => true,
  ),
  'parent_name' => 
  array (
    'type' => 'parent',
    'vname' => 'LBL_LIST_RELATED_TO',
    'sortable' => false,
    'link' => true,
    'ACLTag' => 'PARENT',
    'dynamic_module' => 'PARENT_TYPE',
    'id' => 'PARENT_ID',
    'related_fields' => 
    array (
      0 => 'parent_id',
      1 => 'parent_type',
    ),
    'width' => 10,
    'default' => true,
  ),
  'assigned_user_name' => 
  array (
    'name' => 'assigned_user_name',
    'vname' => 'LBL_ASSIGNED_USER',
    'widget_class' => 'SubPanelDetailViewLink',
    'target_record_key' => 'assigned_user_id',
    'target_module' => 'Employees',
    'width' => 10,
    'default' => true,
  ),
);