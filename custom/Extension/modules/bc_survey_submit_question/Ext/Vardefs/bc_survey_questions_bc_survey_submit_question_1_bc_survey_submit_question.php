<?php
// created: 2017-07-18 15:19:31
$dictionary["bc_survey_submit_question"]["fields"]["bc_survey_questions_bc_survey_submit_question_1"] = array (
  'name' => 'bc_survey_questions_bc_survey_submit_question_1',
  'type' => 'link',
  'relationship' => 'bc_survey_questions_bc_survey_submit_question_1',
  'source' => 'non-db',
  'module' => 'bc_survey_questions',
  'bean_name' => 'bc_survey_questions',
  'side' => 'right',
  'vname' => 'LBL_BC_SURVEY_QUESTIONS_BC_SURVEY_SUBMIT_QUESTION_1_FROM_BC_SURVEY_SUBMIT_QUESTION_TITLE',
  'id_name' => 'bc_survey_6a25estions_ida',
  'link-type' => 'one',
);
$dictionary["bc_survey_submit_question"]["fields"]["bc_survey_questions_bc_survey_submit_question_1_name"] = array (
  'name' => 'bc_survey_questions_bc_survey_submit_question_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_BC_SURVEY_QUESTIONS_BC_SURVEY_SUBMIT_QUESTION_1_FROM_BC_SURVEY_QUESTIONS_TITLE',
  'save' => true,
  'id_name' => 'bc_survey_6a25estions_ida',
  'link' => 'bc_survey_questions_bc_survey_submit_question_1',
  'table' => 'bc_survey_questions',
  'module' => 'bc_survey_questions',
  'rname' => 'name',
);
$dictionary["bc_survey_submit_question"]["fields"]["bc_survey_6a25estions_ida"] = array (
  'name' => 'bc_survey_6a25estions_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_BC_SURVEY_QUESTIONS_BC_SURVEY_SUBMIT_QUESTION_1_FROM_BC_SURVEY_SUBMIT_QUESTION_TITLE_ID',
  'id_name' => 'bc_survey_6a25estions_ida',
  'link' => 'bc_survey_questions_bc_survey_submit_question_1',
  'table' => 'bc_survey_questions',
  'module' => 'bc_survey_questions',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
