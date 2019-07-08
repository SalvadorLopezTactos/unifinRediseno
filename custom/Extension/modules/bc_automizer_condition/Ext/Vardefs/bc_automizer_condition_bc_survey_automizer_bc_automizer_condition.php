<?php
/**
 * The file used to store vardef for Automizer Condition
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$dictionary["bc_automizer_condition"]["fields"]["bc_automizer_condition_bc_survey_automizer"] = array (
  'name' => 'bc_automizer_condition_bc_survey_automizer',
  'type' => 'link',
  'relationship' => 'bc_automizer_condition_bc_survey_automizer',
  'source' => 'non-db',
  'module' => 'bc_survey_automizer',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_BC_AUTOMIZER_CONDITION_BC_SURVEY_AUTOMIZER_FROM_BC_AUTOMIZER_CONDITION_TITLE',
  'id_name' => 'bc_automizc5cctomizer_ida',
  'link-type' => 'one',
);
$dictionary["bc_automizer_condition"]["fields"]["bc_automizer_condition_bc_survey_automizer_name"] = array (
  'name' => 'bc_automizer_condition_bc_survey_automizer_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_BC_AUTOMIZER_CONDITION_BC_SURVEY_AUTOMIZER_FROM_BC_SURVEY_AUTOMIZER_TITLE',
  'save' => true,
  'id_name' => 'bc_automizc5cctomizer_ida',
  'link' => 'bc_automizer_condition_bc_survey_automizer',
  'table' => 'bc_survey_automizer',
  'module' => 'bc_survey_automizer',
);
$dictionary["bc_automizer_condition"]["fields"]["bc_automizc5cctomizer_ida"] = array (
  'name' => 'bc_automizc5cctomizer_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_BC_AUTOMIZER_CONDITION_BC_SURVEY_AUTOMIZER_FROM_BC_AUTOMIZER_CONDITION_TITLE_ID',
  'id_name' => 'bc_automizc5cctomizer_ida',
  'link' => 'bc_automizer_condition_bc_survey_automizer',
  'table' => 'bc_survey_automizer',
  'module' => 'bc_survey_automizer',
  'reportable' => false,
  'side' => 'right',
  'rname' => 'id',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
