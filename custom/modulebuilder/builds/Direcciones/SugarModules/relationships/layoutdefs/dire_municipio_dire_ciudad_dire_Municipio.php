<?php
 // created: 2015-06-08 16:18:03
$layout_defs["dire_Municipio"]["subpanel_setup"]['dire_municipio_dire_ciudad'] = array (
  'order' => 100,
  'module' => 'dire_Ciudad',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_DIRE_MUNICIPIO_DIRE_CIUDAD_FROM_DIRE_CIUDAD_TITLE',
  'get_subpanel_data' => 'dire_municipio_dire_ciudad',
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
