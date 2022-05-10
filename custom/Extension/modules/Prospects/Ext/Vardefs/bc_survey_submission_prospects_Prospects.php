<?php
/**
 * The file used to store Relationship Definition 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */

$dictionary["Prospect"]["fields"]["bc_survey_submission_prospects"] = array (
  'name' => 'bc_survey_submission_prospects',
  'type' => 'link',
  'relationship' => 'bc_survey_submission_prospects',
  'source' => 'non-db',
  'module' => 'bc_survey_submission',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_BC_SURVEY_SUBMISSION_PROSPECTS_FROM_BC_SURVEY_SUBMISSION_TITLE',
);
$dictionary["Prospect"]["relationships"]['bc_survey_submission_prospects'] = array(
    'lhs_module' => 'Prospects',
    'lhs_table' => 'prospects',
    'lhs_key' => 'id',
    'rhs_module' => 'bc_survey_submission',
    'rhs_table' => 'bc_survey_submission',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Prospects'
);
// Target Module Relationship and fields
$dictionary["Prospect"]["fields"]["bc_survey_submission_prospects_target"] = array (
  'name' => 'bc_survey_submission_prospects_target',
  'type' => 'link',
  'relationship' => 'bc_survey_submission_prospects_target',
  'source' => 'non-db',
  'module' => 'bc_survey_submission',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_BC_SURVEY_SUBMISSION_ACCOUNTS_TARGET_FROM_BC_SURVEY_SUBMISSION_TITLE',
);
$dictionary["Prospect"]["relationships"]['bc_survey_submission_prospects_target'] = array(
    'lhs_module' => 'Prospects',
    'lhs_table' => 'prospects',
    'lhs_key' => 'id',
    'rhs_module' => 'bc_survey_submission',
    'rhs_table' => 'bc_survey_submission',
    'rhs_key' => 'target_parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'target_parent_type',
    'relationship_role_column_value' => 'Prospects'
);