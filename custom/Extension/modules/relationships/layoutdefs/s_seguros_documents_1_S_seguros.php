<?php
 // created: 2020-07-22 13:07:09
$layout_defs["S_seguros"]["subpanel_setup"]['s_seguros_documents_1'] = array (
  'order' => 100,
  'module' => 'Documents',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_S_SEGUROS_DOCUMENTS_1_FROM_DOCUMENTS_TITLE',
  'get_subpanel_data' => 's_seguros_documents_1',
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
