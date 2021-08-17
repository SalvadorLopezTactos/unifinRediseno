<?php
 // created: 2021-06-28 15:55:34
$layout_defs["Leads"]["subpanel_setup"]['leads_lic_licitaciones_1'] = array (
  'order' => 100,
  'module' => 'Lic_Licitaciones',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_LEADS_LIC_LICITACIONES_1_FROM_LIC_LICITACIONES_TITLE',
  'get_subpanel_data' => 'leads_lic_licitaciones_1',
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
