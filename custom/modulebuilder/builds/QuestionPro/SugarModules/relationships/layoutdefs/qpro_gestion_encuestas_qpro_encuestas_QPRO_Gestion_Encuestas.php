<?php
 // created: 2022-04-22 12:44:59
$layout_defs["QPRO_Gestion_Encuestas"]["subpanel_setup"]['qpro_gestion_encuestas_qpro_encuestas'] = array (
  'order' => 100,
  'module' => 'QPRO_Encuestas',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_QPRO_GESTION_ENCUESTAS_QPRO_ENCUESTAS_FROM_QPRO_ENCUESTAS_TITLE',
  'get_subpanel_data' => 'qpro_gestion_encuestas_qpro_encuestas',
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
