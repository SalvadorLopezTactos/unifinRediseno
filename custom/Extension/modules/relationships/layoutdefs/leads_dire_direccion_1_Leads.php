<?php
 // created: 2021-07-07 16:58:57
$layout_defs["Leads"]["subpanel_setup"]['leads_dire_direccion_1'] = array (
  'order' => 100,
  'module' => 'dire_Direccion',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_LEADS_DIRE_DIRECCION_1_FROM_DIRE_DIRECCION_TITLE',
  'get_subpanel_data' => 'leads_dire_direccion_1',
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
