<?php
 // created: 2018-09-27 12:54:00
$layout_defs["Meetings"]["subpanel_setup"]['tct01_encuestas_meetings'] = array (
  'order' => 100,
  'module' => 'TCT01_Encuestas',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TCT01_ENCUESTAS_MEETINGS_FROM_TCT01_ENCUESTAS_TITLE',
  'get_subpanel_data' => 'tct01_encuestas_meetings',
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
