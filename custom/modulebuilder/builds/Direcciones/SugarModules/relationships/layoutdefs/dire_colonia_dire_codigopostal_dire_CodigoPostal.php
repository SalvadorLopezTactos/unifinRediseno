<?php
 // created: 2015-06-23 20:29:50
$layout_defs["dire_CodigoPostal"]["subpanel_setup"]['dire_colonia_dire_codigopostal'] = array (
  'order' => 100,
  'module' => 'dire_Colonia',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_DIRE_COLONIA_DIRE_CODIGOPOSTAL_FROM_DIRE_COLONIA_TITLE',
  'get_subpanel_data' => 'dire_colonia_dire_codigopostal',
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
