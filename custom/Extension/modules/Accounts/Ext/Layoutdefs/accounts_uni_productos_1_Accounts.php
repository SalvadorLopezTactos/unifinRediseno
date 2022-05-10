<?php
 // created: 2020-03-12 15:55:02
$layout_defs["Accounts"]["subpanel_setup"]['accounts_uni_productos_1'] = array (
  'order' => 100,
  'module' => 'uni_Productos',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ACCOUNTS_UNI_PRODUCTOS_1_FROM_UNI_PRODUCTOS_TITLE',
  'get_subpanel_data' => 'accounts_uni_productos_1',
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
