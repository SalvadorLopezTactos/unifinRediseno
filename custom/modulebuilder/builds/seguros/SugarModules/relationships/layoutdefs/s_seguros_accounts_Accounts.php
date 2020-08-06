<?php
 // created: 2020-06-30 20:33:48
$layout_defs["Accounts"]["subpanel_setup"]['s_seguros_accounts'] = array (
  'order' => 100,
  'module' => 'S_seguros',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_S_SEGUROS_ACCOUNTS_FROM_S_SEGUROS_TITLE',
  'get_subpanel_data' => 's_seguros_accounts',
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
