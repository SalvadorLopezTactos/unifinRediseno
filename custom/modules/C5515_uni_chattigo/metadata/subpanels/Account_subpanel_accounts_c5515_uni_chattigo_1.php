<?php
// created: 2020-04-05 17:40:55
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'date_modified' => 
  array (
    'vname' => 'LBL_DATE_MODIFIED',
    'width' => 10,
    'default' => true,
  ),
  'inicio_conversacion' => 
  array (
    'type' => 'datetimecombo',
    'vname' => 'LBL_INICIO_CONVERSACION',
    'width' => 10,
    'default' => true,
  ),
  'accounts_c5515_uni_chattigo_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_ACCOUNTS_C5515_UNI_CHATTIGO_1_FROM_ACCOUNTS_TITLE',
    'id' => 'ACCOUNTS_C5515_UNI_CHATTIGO_1ACCOUNTS_IDA',
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Accounts',
    'target_record_key' => 'accounts_c5515_uni_chattigo_1accounts_ida',
  ),
  'description' => 
  array (
    'type' => 'text',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => 10,
  ),
);

$subpanel_layout['top_buttons'] = array (
  
 );

