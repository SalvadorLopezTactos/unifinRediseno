<?php
 // created: 2022-05-03 01:27:21
$layout_defs["Prospects"]["subpanel_setup"]['prospects_tel_telefonos_1'] = array (
  'order' => 100,
  'module' => 'Tel_Telefonos',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_PROSPECTS_TEL_TELEFONOS_1_FROM_TEL_TELEFONOS_TITLE',
  'get_subpanel_data' => 'prospects_tel_telefonos_1',
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
