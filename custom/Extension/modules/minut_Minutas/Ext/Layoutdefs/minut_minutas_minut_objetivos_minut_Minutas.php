<?php
 // created: 2018-10-12 11:29:33
$layout_defs["minut_Minutas"]["subpanel_setup"]['minut_minutas_minut_objetivos'] = array (
  'order' => 100,
  'module' => 'minut_Objetivos',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_MINUT_MINUTAS_MINUT_OBJETIVOS_FROM_MINUT_OBJETIVOS_TITLE',
  'get_subpanel_data' => 'minut_minutas_minut_objetivos',
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
