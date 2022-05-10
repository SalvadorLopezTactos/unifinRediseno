<?php
/**
 * The file used to store vardef for Automizer
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$dictionary["bc_automizer_actions"]["fields"]["bc_survey_automizer_bc_automizer_actions"] = array (
  'name' => 'bc_survey_automizer_bc_automizer_actions',
  'type' => 'link',
  'relationship' => 'bc_survey_automizer_bc_automizer_actions',
  'source' => 'non-db',
  'module' => 'bc_survey_automizer',
  'bean_name' => 'bc_survey_automizer',
  'side' => 'right',
  'vname' => 'LBL_BC_SURVEY_AUTOMIZER_BC_AUTOMIZER_ACTIONS_FROM_BC_AUTOMIZER_ACTIONS_TITLE',
  'id_name' => 'bc_survey_automizer_ida',
  'link-type' => 'one',
);
$dictionary["bc_automizer_actions"]["fields"]["bc_survey_automizer_bc_automizer_actions_name"] = array (
  'name' => 'bc_survey_automizer_bc_automizer_actions_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_BC_SURVEY_AUTOMIZER_BC_AUTOMIZER_ACTIONS_FROM_BC_SURVEY_AUTOMIZER_TITLE',
  'save' => true,
  'id_name' => 'bc_survey_automizer_ida',
  'link' => 'bc_survey_automizer_bc_automizer_actions',
  'table' => 'bc_survey_automizer',
  'module' => 'bc_survey_automizer',
);
$dictionary["bc_automizer_actions"]["fields"]["bc_survey_automizer_ida"] = array (
  'name' => 'bc_survey_automizer_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_BC_SURVEY_AUTOMIZER_BC_AUTOMIZER_ACTIONS_FROM_BC_AUTOMIZER_ACTIONS_TITLE_ID',
  'id_name' => 'bc_survey_automizer_ida',
  'link' => 'bc_survey_automizer_bc_automizer_actions',
  'table' => 'bc_survey_automizer',
  'module' => 'bc_survey_automizer',
  'reportable' => false,
  'side' => 'right',
  'rname' => 'id',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
