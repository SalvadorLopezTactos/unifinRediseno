<?php
// created: 2017-07-28 12:05:16
$dictionary["bc_survey_submit_question"]["fields"]["bc_survey_submit_question_bc_survey_submission"] = array (
  'name' => 'bc_survey_submit_question_bc_survey_submission',
  'type' => 'link',
  'relationship' => 'bc_survey_submit_question_bc_survey_submission',
  'source' => 'non-db',
  'module' => 'bc_survey_submission',
  'bean_name' => 'bc_survey_submission',
  'side' => 'right',
  'vname' => 'LBL_BC_SURVEY_SUBMIT_QUESTION_BC_SURVEY_SUBMISSION_FROM_BC_SURVEY_SUBMIT_QUESTION_TITLE',
  'id_name' => 'bc_survey_9f7bmission_ida',
  'link-type' => 'one',
);
$dictionary["bc_survey_submit_question"]["fields"]["bc_survey_submit_question_bc_survey_submission_name"] = array (
  'name' => 'bc_survey_submit_question_bc_survey_submission_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_BC_SURVEY_SUBMIT_QUESTION_BC_SURVEY_SUBMISSION_FROM_BC_SURVEY_SUBMISSION_TITLE',
  'save' => true,
  'id_name' => 'bc_survey_9f7bmission_ida',
  'link' => 'bc_survey_submit_question_bc_survey_submission',
  'table' => 'bc_survey_submission',
  'module' => 'bc_survey_submission',
  'rname' => 'name',
);
$dictionary["bc_survey_submit_question"]["fields"]["bc_survey_9f7bmission_ida"] = array (
  'name' => 'bc_survey_9f7bmission_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_BC_SURVEY_SUBMIT_QUESTION_BC_SURVEY_SUBMISSION_FROM_BC_SURVEY_SUBMIT_QUESTION_TITLE_ID',
  'id_name' => 'bc_survey_9f7bmission_ida',
  'link' => 'bc_survey_submit_question_bc_survey_submission',
  'table' => 'bc_survey_submission',
  'module' => 'bc_survey_submission',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
