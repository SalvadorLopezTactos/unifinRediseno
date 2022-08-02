<?php
 // created: 2015-10-28 18:23:48
$layout_defs["Accounts"]["subpanel_setup"]['ag_agencias_accounts'] = array (
  'order' => 100,
  'module' => 'AG_Agencias',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_AG_AGENCIAS_ACCOUNTS_FROM_AG_AGENCIAS_TITLE',
  'get_subpanel_data' => 'ag_agencias_accounts',
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
