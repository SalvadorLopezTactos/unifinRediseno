<?php
// created: 2018-11-13 15:41:50
$subpanel_layout['list_fields'] = array (
  'document_name' => 
  array (
    'name' => 'document_name',
    'vname' => 'LBL_LIST_DOCUMENT_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'filename' => 
  array (
    'name' => 'filename',
    'vname' => 'LBL_LIST_FILENAME',
    'width' => 10,
    'module' => 'Documents',
    'sortable' => false,
    'displayParams' => 
    array (
      'module' => 'Documents',
    ),
    'default' => true,
  ),
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'vname' => 'LBL_ASSIGNED_TO',
    'id' => 'ASSIGNED_USER_ID',
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Users',
    'target_record_key' => 'assigned_user_id',
  ),
  'document_revision_id' => 
  array (
    'name' => 'document_revision_id',
    'usage' => 'query_only',
  ),
);