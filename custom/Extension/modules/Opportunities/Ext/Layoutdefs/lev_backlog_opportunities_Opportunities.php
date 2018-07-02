<?php
 // created: 2016-04-12 16:30:51
$layout_defs["Opportunities"]["subpanel_setup"]['lev_backlog_opportunities'] = array (
  'order' => 100,
  'module' => 'lev_Backlog',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_LEV_BACKLOG_OPPORTUNITIES_FROM_LEV_BACKLOG_TITLE',
  'get_subpanel_data' => 'lev_backlog_opportunities',
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
