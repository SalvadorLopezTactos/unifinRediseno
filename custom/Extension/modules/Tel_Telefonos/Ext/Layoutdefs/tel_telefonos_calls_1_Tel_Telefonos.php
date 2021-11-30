<?php
 // created: 2018-03-09 10:42:17
$layout_defs["Tel_Telefonos"]["subpanel_setup"]['tel_telefonos_calls_1'] = array (
  'order' => 100,
  'module' => 'Calls',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TEL_TELEFONOS_CALLS_1_FROM_CALLS_TITLE',
  'get_subpanel_data' => 'tel_telefonos_calls_1',
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
