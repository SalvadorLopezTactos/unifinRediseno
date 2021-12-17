<?php
 // created: 2015-10-28 18:23:48
$layout_defs["AG_Agencias"]["subpanel_setup"]['ag_vendedores_ag_agencias'] = array (
  'order' => 100,
  'module' => 'AG_Vendedores',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_AG_VENDEDORES_AG_AGENCIAS_FROM_AG_VENDEDORES_TITLE',
  'get_subpanel_data' => 'ag_vendedores_ag_agencias',
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
