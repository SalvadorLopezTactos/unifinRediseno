<?php
 // created: 2020-05-27 14:08:29
$layout_defs["Accounts"]["subpanel_setup"]['cta_cuentas_bancarias_accounts'] = array (
  'order' => 100,
  'module' => 'cta_cuentas_bancarias',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CTA_CUENTAS_BANCARIAS_ACCOUNTS_FROM_CTA_CUENTAS_BANCARIAS_TITLE',
  'get_subpanel_data' => 'cta_cuentas_bancarias_accounts',
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
