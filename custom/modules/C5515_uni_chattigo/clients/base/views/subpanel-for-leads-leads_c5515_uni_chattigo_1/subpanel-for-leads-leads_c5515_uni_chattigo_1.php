<?php
// created: 2020-06-19 10:48:59
$viewdefs['C5515_uni_chattigo']['base']['view']['subpanel-for-leads-leads_c5515_uni_chattigo_1'] = array (
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
          'label' => 'LBL_NAME',
          'enabled' => true,
          'default' => true,
          'name' => 'name',
          'link' => true,
        ),
        1 => 
        array (
          'label' => 'LBL_DATE_MODIFIED',
          'enabled' => true,
          'default' => true,
          'name' => 'date_modified',
        ),
        2 => 
        array (
          'name' => 'inicio_conversacion',
          'label' => 'LBL_INICIO_CONVERSACION',
          'enabled' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'leads_c5515_uni_chattigo_1_name',
          'label' => 'LBL_LEADS_C5515_UNI_CHATTIGO_1_FROM_LEADS_TITLE',
          'enabled' => true,
          'id' => 'LEADS_C5515_UNI_CHATTIGO_1LEADS_IDA',
          'link' => true,
          'sortable' => false,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'description',
          'label' => 'LBL_DESCRIPTION',
          'enabled' => true,
          'sortable' => false,
          'default' => true,
        ),
      ),
    ),
  ),
  'orderBy' => 
  array (
    'field' => 'date_modified',
    'direction' => 'desc',
  ),
  'rowactions' => 
  array (
    'actions' => 
    array (
      0 => 
      array (
        'type' => 'rowaction',
        'css_class' => 'btn',
        'tooltip' => 'LBL_PREVIEW',
        'event' => 'list:preview:fire',
        'icon' => 'fa-eye',
        'acl_action' => 'view',
        'allow_bwc' => false,
      ),
    ),
  ),
  'type' => 'subpanel-list',
);