<?php
 // created: 2021-02-08 14:33:11
$layout_defs["Lic_Licitaciones"]["subpanel_setup"]['lic_licitaciones_meetings_1'] = array (
  'order' => 100,
  'module' => 'Meetings',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_LIC_LICITACIONES_MEETINGS_1_FROM_MEETINGS_TITLE',
  'get_subpanel_data' => 'lic_licitaciones_meetings_1',
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
