<?php
// created: 2018-11-06 18:55:31
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
  'category_id' => 
  array (
    'name' => 'category_id',
    'vname' => 'LBL_LIST_CATEGORY',
    'width' => 10,
    'default' => true,
  ),
  'doc_type' => 
  array (
    'name' => 'doc_type',
    'vname' => 'LBL_LIST_DOC_TYPE',
    'width' => 10,
    'default' => true,
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'vname' => 'LBL_DATE_ENTERED',
    'width' => 10,
    'default' => true,
  ),
  'status_id' => 
  array (
    'name' => 'status_id',
    'vname' => 'LBL_LIST_STATUS',
    'width' => 10,
    'default' => true,
  ),
  'document_revision_id' => 
  array (
    'name' => 'document_revision_id',
    'usage' => 'query_only',
  ),
);