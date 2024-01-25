<?php
 // created: 2024-01-24 12:47:17
$layout_defs["TCTBL_Backlog_Seguros"]["subpanel_setup"]['tctbl_backlog_seguros_s_seguros_1'] = array (
  'order' => 100,
  'module' => 'S_seguros',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TCTBL_BACKLOG_SEGUROS_S_SEGUROS_1_FROM_S_SEGUROS_TITLE',
  'get_subpanel_data' => 'tctbl_backlog_seguros_s_seguros_1',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
