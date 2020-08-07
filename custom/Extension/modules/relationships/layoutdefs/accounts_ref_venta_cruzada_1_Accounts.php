<?php
 // created: 2020-07-23 13:01:15
$layout_defs["Accounts"]["subpanel_setup"]['accounts_ref_venta_cruzada_1'] = array (
  'order' => 100,
  'module' => 'Ref_Venta_Cruzada',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ACCOUNTS_REF_VENTA_CRUZADA_1_FROM_REF_VENTA_CRUZADA_TITLE',
  'get_subpanel_data' => 'accounts_ref_venta_cruzada_1',
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
