<?php
 // created: 2017-04-07 05:09:27
$layout_defs["bc_survey_submission"]["subpanel_setup"]['bc_survey_submission_documents'] = array (
  'order' => 100,
  'module' => 'Documents',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_BC_SURVEY_SUBMISSION_DOCUMENTS_FROM_DOCUMENTS_TITLE',
  'get_subpanel_data' => 'bc_survey_submission_documents',
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
