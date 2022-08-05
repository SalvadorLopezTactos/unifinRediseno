<?php
// created: 2017-04-07 05:09:27
$dictionary["Document"]["fields"]["bc_survey_submission_documents"] = array (
  'name' => 'bc_survey_submission_documents',
  'type' => 'link',
  'relationship' => 'bc_survey_submission_documents',
  'source' => 'non-db',
  'module' => 'bc_survey_submission',
  'bean_name' => 'Lead',
  'side' => 'right',
  'vname' => 'LBL_BC_SURVEY_SUBMISSION_DOCUMENTS_FROM_DOCUMENTS_TITLE',
  'id_name' => 'bc_survey_submission_documentsbc_survey_submission_ida',
  'link-type' => 'one',
);
$dictionary["Document"]["fields"]["bc_survey_submission_documents_name"] = array (
  'name' => 'bc_survey_submission_documents_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_BC_SURVEY_SUBMISSION_DOCUMENTS_FROM_BC_SURVEY_SUBMISSION_TITLE',
  'save' => true,
  'id_name' => 'bc_survey_submission_documentsbc_survey_submission_ida',
  'link' => 'bc_survey_submission_documents',
  'table' => 'bc_survey_submission',
  'module' => 'bc_survey_submission',
  'rname' => 'full_name',
 /* 'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ), */
);
$dictionary["Document"]["fields"]["bc_survey_submission_documentsbc_survey_submission_ida"] = array (
  'name' => 'bc_survey_submission_documentsbc_survey_submission_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_BC_SURVEY_SUBMISSION_DOCUMENTS_FROM_DOCUMENTS_TITLE_ID',
  'id_name' => 'bc_survey_submission_documentsbc_survey_submission_ida',
  'link' => 'bc_survey_submission_documents',
  'table' => 'bc_survey_submission',
  'module' => 'bc_survey_submission',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
