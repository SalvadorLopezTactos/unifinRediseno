<?php
/**
 * The file used to store def for Automizer
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$layout_defs["bc_survey_automizer"]["subpanel_setup"]['bc_survey_automizer_bc_automizer_actions'] = array (
  'order' => 100,
  'module' => 'bc_automizer_actions',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_BC_SURVEY_AUTOMIZER_BC_AUTOMIZER_ACTIONS_FROM_BC_AUTOMIZER_ACTIONS_TITLE',
  'get_subpanel_data' => 'bc_survey_automizer_bc_automizer_actions',
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
