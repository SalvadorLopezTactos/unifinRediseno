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
$dictionary["Lead"]["fields"]["bc_survey_submission_leads"] = array(
    'name' => 'bc_survey_submission_leads',
    'type' => 'link',
    'relationship' => 'bc_survey_submission_leads',
    'source' => 'non-db',
    'module' => 'bc_survey_submission',
    'bean_name' => false,
    'side' => 'right',
    'vname' => 'LBL_BC_SURVEY_SUBMISSION_LEADS_FROM_BC_SURVEY_SUBMISSION_TITLE',
);
$dictionary["Lead"]["relationships"]['bc_survey_submission_leads'] = array(
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',
    'rhs_module' => 'bc_survey_submission',
    'rhs_table' => 'bc_survey_submission',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Leads'
);
// Target Module Relationship and fields
$dictionary["Lead"]["fields"]["bc_survey_submission_leads_target"] = array (
  'name' => 'bc_survey_submission_leads_target',
  'type' => 'link',
  'relationship' => 'bc_survey_submission_leads_target',
  'source' => 'non-db',
  'module' => 'bc_survey_submission',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_BC_SURVEY_SUBMISSION_ACCOUNTS_TARGET_FROM_BC_SURVEY_SUBMISSION_TITLE',
);
$dictionary["Lead"]["relationships"]['bc_survey_submission_leads_target'] = array(
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',
    'rhs_module' => 'bc_survey_submission',
    'rhs_table' => 'bc_survey_submission',
    'rhs_key' => 'target_parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'target_parent_type',
    'relationship_role_column_value' => 'Leads'
);