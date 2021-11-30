<?php
 // created: 2015-07-21 23:08:07
$layout_defs["Accounts"]["subpanel_setup"]['refba_referencia_bancaria_accounts'] = array (
  'order' => 100,
  'module' => 'RefBa_Referencia_Bancaria',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_REFBA_REFERENCIA_BANCARIA_ACCOUNTS_FROM_REFBA_REFERENCIA_BANCARIA_TITLE',
  'get_subpanel_data' => 'refba_referencia_bancaria_accounts',
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
