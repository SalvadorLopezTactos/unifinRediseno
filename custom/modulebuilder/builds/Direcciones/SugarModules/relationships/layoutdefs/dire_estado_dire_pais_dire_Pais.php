<?php
 // created: 2015-06-23 20:29:48
$layout_defs["dire_Pais"]["subpanel_setup"]['dire_estado_dire_pais'] = array (
  'order' => 100,
  'module' => 'dire_Estado',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_DIRE_ESTADO_DIRE_PAIS_FROM_DIRE_ESTADO_TITLE',
  'get_subpanel_data' => 'dire_estado_dire_pais',
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
