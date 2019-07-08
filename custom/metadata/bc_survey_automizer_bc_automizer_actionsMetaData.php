<?php
/**
 * The file used to manage relationship  for Automizer and actions
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$dictionary["bc_survey_automizer_bc_automizer_actions"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'bc_survey_automizer_bc_automizer_actions' => 
    array (
      'lhs_module' => 'bc_survey_automizer',
      'lhs_table' => 'bc_survey_automizer',
      'lhs_key' => 'id',
      'rhs_module' => 'bc_automizer_actions',
      'rhs_table' => 'bc_automizer_actions',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'bc_survey_automizer_bc_automizer_actions_c',
      'join_key_lhs' => 'bc_survey_automizer_ida',
      'join_key_rhs' => 'bc_survey_actions_idb',
    ),
  ),
  'table' => 'bc_survey_automizer_bc_automizer_actions_c',
  'fields' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    'date_modified' => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    'deleted' => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    'bc_survey_automizer_ida' => 
    array (
      'name' => 'bc_survey_automizer_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    'bc_survey_actions_idb' => 
    array (
      'name' => 'bc_survey_actions_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    
    array (
      'name' => 'bc_survey_automizer_bc_automizer_actionsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
     
    array (
      'name' => 'bc_survey_automizer_bc_automizer_actions_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'bc_survey_automizer_ida',
      ),
    ),
    
    array (
      'name' => 'bc_survey_automizer_bc_automizer_actions_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'bc_survey_actions_idb',
      ),
    ),
  ),
);
