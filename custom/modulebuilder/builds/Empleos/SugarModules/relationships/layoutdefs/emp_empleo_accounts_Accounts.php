<?php
 // created: 2015-06-08 19:39:07
$layout_defs["Accounts"]["subpanel_setup"]['emp_empleo_accounts'] = array (
  'order' => 100,
  'module' => 'emp_empleo',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_EMP_EMPLEO_ACCOUNTS_FROM_EMP_EMPLEO_TITLE',
  'get_subpanel_data' => 'emp_empleo_accounts',
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
