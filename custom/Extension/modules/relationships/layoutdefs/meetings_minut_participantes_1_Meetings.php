<?php
 // created: 2022-05-31 13:02:50
$layout_defs["Meetings"]["subpanel_setup"]['meetings_minut_participantes_1'] = array (
  'order' => 100,
  'module' => 'minut_Participantes',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_MEETINGS_MINUT_PARTICIPANTES_1_FROM_MINUT_PARTICIPANTES_TITLE',
  'get_subpanel_data' => 'meetings_minut_participantes_1',
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
