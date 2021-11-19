<?php
 // created: 2016-04-03 12:50:00
$layout_defs["Opportunities"]["subpanel_setup"]['lev_condicionesfinancieras_opportunities'] = array (
  'order' => 100,
  'module' => 'lev_CondicionesFinancieras',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_LEV_CONDICIONESFINANCIERAS_OPPORTUNITIES_FROM_LEV_CONDICIONESFINANCIERAS_TITLE',
  'get_subpanel_data' => 'lev_condicionesfinancieras_opportunities',
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
