<?php
/**
 * The file used to handle relationship for survey automizer condition
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$dictionary["bc_automizer_condition_bc_survey_automizer"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'bc_automizer_condition_bc_survey_automizer' => 
    array (
      'lhs_module' => 'bc_survey_automizer',
      'lhs_table' => 'bc_survey_automizer',
      'lhs_key' => 'id',
      'rhs_module' => 'bc_automizer_condition',
      'rhs_table' => 'bc_automizer_condition',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'bc_automizer_condition_bc_survey_automizer_c',
      'join_key_lhs' => 'bc_automizc5cctomizer_ida',
      'join_key_rhs' => 'bc_automizbd1dndition_idb',
    ),
  ),
  'table' => 'bc_automizer_condition_bc_survey_automizer_c',
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
    'bc_automizc5cctomizer_ida' => 
    array (
      'name' => 'bc_automizc5cctomizer_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    'bc_automizbd1dndition_idb' => 
    array (
      'name' => 'bc_automizbd1dndition_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
   
    array (
      'name' => 'bc_automizer_condition_bc_survey_automizerspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
   
    array (
      'name' => 'bc_automizer_condition_bc_survey_automizer_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'bc_automizc5cctomizer_ida',
      ),
    ),
 
    array (
      'name' => 'bc_automizer_condition_bc_survey_automizer_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'bc_automizbd1dndition_idb',
      ),
    ),
  ),
);
