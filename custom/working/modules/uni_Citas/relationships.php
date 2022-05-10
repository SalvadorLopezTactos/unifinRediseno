<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
$relationships = array (
  'uni_citas_uni_brujula' => 
  array (
    'name' => 'uni_citas_uni_brujula',
    'true_relationship_type' => 'one-to-many',
    'relationships' => 
    array (
      'uni_citas_uni_brujula' => 
      array (
        'lhs_module' => 'uni_Brujula',
        'lhs_table' => 'uni_brujula',
        'lhs_key' => 'id',
        'rhs_module' => 'uni_Citas',
        'rhs_table' => 'uni_citas',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'uni_citas_uni_brujula_c',
        'join_key_lhs' => 'uni_citas_uni_brujulauni_brujula_ida',
        'join_key_rhs' => 'uni_citas_uni_brujulauni_citas_idb',
      ),
    ),
    'table' => 'uni_citas_uni_brujula_c',
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
      'uni_citas_uni_brujulauni_brujula_ida' => 
      array (
        'name' => 'uni_citas_uni_brujulauni_brujula_ida',
        'type' => 'varchar',
        'len' => 36,
      ),
      'uni_citas_uni_brujulauni_citas_idb' => 
      array (
        'name' => 'uni_citas_uni_brujulauni_citas_idb',
        'type' => 'varchar',
        'len' => 36,
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'uni_citas_uni_brujulaspk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'uni_citas_uni_brujula_ida1',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'uni_citas_uni_brujulauni_brujula_ida',
        ),
      ),
      2 => 
      array (
        'name' => 'uni_citas_uni_brujula_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'uni_citas_uni_brujulauni_citas_idb',
        ),
      ),
    ),
    'lhs_module' => 'uni_Brujula',
    'lhs_table' => 'uni_brujula',
    'lhs_key' => 'id',
    'rhs_module' => 'uni_Citas',
    'rhs_table' => 'uni_citas',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'uni_citas_uni_brujula_c',
    'join_key_lhs' => 'uni_citas_uni_brujulauni_brujula_ida',
    'join_key_rhs' => 'uni_citas_uni_brujulauni_citas_idb',
    'readonly' => true,
    'relationship_name' => 'uni_citas_uni_brujula',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  'uni_citas_modified_user' => 
  array (
    'name' => 'uni_citas_modified_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'uni_Citas',
    'rhs_table' => 'uni_citas',
    'rhs_key' => 'modified_user_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'uni_citas_modified_user',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'uni_citas_created_by' => 
  array (
    'name' => 'uni_citas_created_by',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'uni_Citas',
    'rhs_table' => 'uni_citas',
    'rhs_key' => 'created_by',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'uni_citas_created_by',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'uni_citas_activities' => 
  array (
    'name' => 'uni_citas_activities',
    'lhs_module' => 'uni_Citas',
    'lhs_table' => 'uni_citas',
    'lhs_key' => 'id',
    'rhs_module' => 'Activities',
    'rhs_table' => 'activities',
    'rhs_key' => 'id',
    'rhs_vname' => 'LBL_ACTIVITY_STREAM',
    'relationship_type' => 'many-to-many',
    'join_table' => 'activities_users',
    'join_key_lhs' => 'parent_id',
    'join_key_rhs' => 'activity_id',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'uni_Citas',
    'fields' => 
    array (
      'id' => 
      array (
        'name' => 'id',
        'type' => 'id',
        'len' => 36,
        'required' => true,
      ),
      'activity_id' => 
      array (
        'name' => 'activity_id',
        'type' => 'id',
        'len' => 36,
        'required' => true,
      ),
      'parent_type' => 
      array (
        'name' => 'parent_type',
        'type' => 'varchar',
        'len' => 100,
      ),
      'parent_id' => 
      array (
        'name' => 'parent_id',
        'type' => 'id',
        'len' => 36,
      ),
      'fields' => 
      array (
        'name' => 'fields',
        'type' => 'json',
        'dbType' => 'longtext',
        'required' => true,
      ),
      'date_modified' => 
      array (
        'name' => 'date_modified',
        'type' => 'datetime',
      ),
      'deleted' => 
      array (
        'name' => 'deleted',
        'vname' => 'LBL_DELETED',
        'type' => 'bool',
        'default' => '0',
      ),
    ),
    'readonly' => true,
    'relationship_name' => 'uni_citas_activities',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'uni_citas_following' => 
  array (
    'name' => 'uni_citas_following',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'uni_Citas',
    'rhs_table' => 'uni_citas',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'subscriptions',
    'join_key_lhs' => 'created_by',
    'join_key_rhs' => 'parent_id',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'uni_Citas',
    'user_field' => 'created_by',
    'readonly' => true,
    'relationship_name' => 'uni_citas_following',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'uni_citas_favorite' => 
  array (
    'name' => 'uni_citas_favorite',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'uni_Citas',
    'rhs_table' => 'uni_citas',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'sugarfavorites',
    'join_key_lhs' => 'modified_user_id',
    'join_key_rhs' => 'record_id',
    'relationship_role_column' => 'module',
    'relationship_role_column_value' => 'uni_Citas',
    'user_field' => 'created_by',
    'readonly' => true,
    'relationship_name' => 'uni_citas_favorite',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'uni_citas_assigned_user' => 
  array (
    'name' => 'uni_citas_assigned_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'uni_Citas',
    'rhs_table' => 'uni_citas',
    'rhs_key' => 'assigned_user_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'uni_citas_assigned_user',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'uni_citas_users_1' => 
  array (
    'rhs_label' => 'Usuarios',
    'lhs_label' => 'Citas',
    'rhs_subpanel' => 'default',
    'lhs_module' => 'uni_Citas',
    'rhs_module' => 'Users',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => true,
    'relationship_name' => 'uni_citas_users_1',
  ),
);