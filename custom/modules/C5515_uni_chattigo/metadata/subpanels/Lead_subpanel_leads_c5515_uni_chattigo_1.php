<?php
// created: 2020-07-15 20:21:49
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
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
  'date_modified' => 
  array (
    'vname' => 'LBL_DATE_MODIFIED',
    'width' => 10,
    'default' => true,
  ),
  'leads_c5515_uni_chattigo_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_LEADS_C5515_UNI_CHATTIGO_1_FROM_LEADS_TITLE',
    'id' => 'LEADS_C5515_UNI_CHATTIGO_1LEADS_IDA',
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Leads',
    'target_record_key' => 'leads_c5515_uni_chattigo_1leads_ida',
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