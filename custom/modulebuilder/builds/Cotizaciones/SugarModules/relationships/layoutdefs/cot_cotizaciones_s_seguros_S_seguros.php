<?php
 // created: 2022-06-15 20:25:16
$layout_defs["S_seguros"]["subpanel_setup"]['cot_cotizaciones_s_seguros'] = array (
  'order' => 100,
  'module' => 'Cot_Cotizaciones',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_COT_COTIZACIONES_S_SEGUROS_FROM_COT_COTIZACIONES_TITLE',
  'get_subpanel_data' => 'cot_cotizaciones_s_seguros',
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
