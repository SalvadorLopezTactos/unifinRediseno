<?php
 // created: 2017-12-22 09:54:57
$layout_defs["Accounts"]["subpanel_setup"]['tct1_p_fideicomiso_accounts'] = array (
  'order' => 100,
  'module' => 'TCT1_P_Fideicomiso',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TCT1_P_FIDEICOMISO_ACCOUNTS_FROM_TCT1_P_FIDEICOMISO_TITLE',
  'get_subpanel_data' => 'tct1_p_fideicomiso_accounts',
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
