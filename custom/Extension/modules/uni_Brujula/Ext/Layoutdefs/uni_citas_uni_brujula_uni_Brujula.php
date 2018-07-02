<?php
 // created: 2016-09-27 16:05:52
$layout_defs["uni_Brujula"]["subpanel_setup"]['uni_citas_uni_brujula'] = array (
  'order' => 100,
  'module' => 'uni_Citas',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_UNI_CITAS_UNI_BRUJULA_FROM_UNI_CITAS_TITLE',
  'get_subpanel_data' => 'uni_citas_uni_brujula',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
  ),
);
