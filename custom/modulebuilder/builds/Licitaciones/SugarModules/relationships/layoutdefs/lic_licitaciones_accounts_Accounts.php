<?php
 // created: 2020-12-03 15:29:17
$layout_defs["Accounts"]["subpanel_setup"]['lic_licitaciones_accounts'] = array (
  'order' => 100,
  'module' => 'Lic_Licitaciones',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_LIC_LICITACIONES_ACCOUNTS_FROM_LIC_LICITACIONES_TITLE',
  'get_subpanel_data' => 'lic_licitaciones_accounts',
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
