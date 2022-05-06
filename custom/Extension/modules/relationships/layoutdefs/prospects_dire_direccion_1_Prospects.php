<?php
 // created: 2022-05-03 01:30:00
$layout_defs["Prospects"]["subpanel_setup"]['prospects_dire_direccion_1'] = array (
  'order' => 100,
  'module' => 'dire_Direccion',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_PROSPECTS_DIRE_DIRECCION_1_FROM_DIRE_DIRECCION_TITLE',
  'get_subpanel_data' => 'prospects_dire_direccion_1',
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
