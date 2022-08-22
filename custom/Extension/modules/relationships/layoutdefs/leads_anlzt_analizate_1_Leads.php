<?php
 // created: 2022-08-20 14:06:26
$layout_defs["Leads"]["subpanel_setup"]['leads_anlzt_analizate_1'] = array (
  'order' => 100,
  'module' => 'ANLZT_analizate',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_LEADS_ANLZT_ANALIZATE_1_FROM_ANLZT_ANALIZATE_TITLE',
  'get_subpanel_data' => 'leads_anlzt_analizate_1',
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
