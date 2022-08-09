<?php
 // created: 2022-04-27 14:56:18
$layout_defs["dir_Sepomex"]["subpanel_setup"]['dir_sepomex_dire_direccion'] = array (
  'order' => 100,
  'module' => 'dire_Direccion',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_DIR_SEPOMEX_DIRE_DIRECCION_FROM_DIRE_DIRECCION_TITLE',
  'get_subpanel_data' => 'dir_sepomex_dire_direccion',
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
