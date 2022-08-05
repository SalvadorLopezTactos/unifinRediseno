<?php
 // created: 2015-06-23 20:29:51
$layout_defs["dire_Ciudad"]["subpanel_setup"]['dire_direccion_dire_ciudad'] = array (
  'order' => 100,
  'module' => 'dire_Direccion',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_DIRE_DIRECCION_DIRE_CIUDAD_FROM_DIRE_DIRECCION_TITLE',
  'get_subpanel_data' => 'dire_direccion_dire_ciudad',
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
