<?php
 // created: 2015-06-23 20:29:49
$layout_defs["dire_Estado"]["subpanel_setup"]['dire_municipio_dire_estado'] = array (
  'order' => 100,
  'module' => 'dire_Municipio',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_DIRE_MUNICIPIO_DIRE_ESTADO_FROM_DIRE_MUNICIPIO_TITLE',
  'get_subpanel_data' => 'dire_municipio_dire_estado',
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
