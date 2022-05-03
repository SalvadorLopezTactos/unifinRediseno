<?php
 // created: 2022-04-27 23:16:21
$layout_defs["Prospects"]["subpanel_setup"]['prospects_prospects_1'] = array (
  'order' => 100,
  'module' => 'Prospects',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_PROSPECTS_PROSPECTS_1_FROM_PROSPECTS_R_TITLE',
  'get_subpanel_data' => 'prospects_prospects_1',
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
