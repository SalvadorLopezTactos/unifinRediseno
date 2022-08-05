<?php
 // created: 2020-02-19 17:16:59
$layout_defs["Accounts"]["subpanel_setup"]['anlzt_analizate_accounts'] = array (
  'order' => 100,
  'module' => 'ANLZT_analizate',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ANLZT_ANALIZATE_ACCOUNTS_FROM_ANLZT_ANALIZATE_TITLE',
  'get_subpanel_data' => 'anlzt_analizate_accounts',
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
