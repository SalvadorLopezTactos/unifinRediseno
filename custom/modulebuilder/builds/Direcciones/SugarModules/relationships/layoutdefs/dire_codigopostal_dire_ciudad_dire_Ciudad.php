<?php
 // created: 2015-06-18 15:29:11
$layout_defs["dire_Ciudad"]["subpanel_setup"]['dire_codigopostal_dire_ciudad'] = array (
  'order' => 100,
  'module' => 'dire_CodigoPostal',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_DIRE_CODIGOPOSTAL_DIRE_CIUDAD_FROM_DIRE_CODIGOPOSTAL_TITLE',
  'get_subpanel_data' => 'dire_codigopostal_dire_ciudad',
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
