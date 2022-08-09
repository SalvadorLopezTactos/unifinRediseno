<?php
// created: 2022-07-21 11:18:24
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'relaciones_activas' => 
  array (
    'type' => 'multienum',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_RELACIONES_ACTIVAS',
    'width' => 10,
  ),
  'rel_relaciones_accounts_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_REL_RELACIONES_ACCOUNTS_1_FROM_ACCOUNTS_TITLE',
    'id' => 'REL_RELACIONES_ACCOUNTS_1ACCOUNTS_IDA',
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Accounts',
    'target_record_key' => 'rel_relaciones_accounts_1accounts_ida',
  ),
  'date_modified' => 
  array (
    'vname' => 'LBL_DATE_MODIFIED',
    'width' => 10,
    'default' => true,
  ),
);