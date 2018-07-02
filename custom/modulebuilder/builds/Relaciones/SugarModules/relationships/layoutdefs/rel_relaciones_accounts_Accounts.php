<?php
 // created: 2015-06-10 15:13:34
$layout_defs["Accounts"]["subpanel_setup"]['rel_relaciones_accounts'] = array (
  'order' => 100,
  'module' => 'Rel_Relaciones',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_REL_RELACIONES_ACCOUNTS_FROM_REL_RELACIONES_TITLE',
  'get_subpanel_data' => 'rel_relaciones_accounts',
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
