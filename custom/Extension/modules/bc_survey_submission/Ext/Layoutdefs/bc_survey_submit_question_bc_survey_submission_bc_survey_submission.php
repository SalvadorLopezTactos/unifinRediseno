<?php
 // created: 2017-07-28 12:05:16
$layout_defs["bc_survey_submission"]["subpanel_setup"]['bc_survey_submit_question_bc_survey_submission'] = array (
  'order' => 100,
  'module' => 'bc_survey_submit_question',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_BC_SURVEY_SUBMIT_QUESTION_BC_SURVEY_SUBMISSION_FROM_BC_SURVEY_SUBMIT_QUESTION_TITLE',
  'get_subpanel_data' => 'bc_survey_submit_question_bc_survey_submission',
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
