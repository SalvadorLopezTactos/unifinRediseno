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
  'accounts_tel_telefonos_1' => 
  array (
    'name' => 'accounts_tel_telefonos_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'accounts_tel_telefonos_1' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'Tel_Telefonos',
        'rhs_table' => 'tel_telefonos',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'accounts_tel_telefonos_1_c',
        'join_key_lhs' => 'accounts_tel_telefonos_1accounts_ida',
        'join_key_rhs' => 'accounts_tel_telefonos_1tel_telefonos_idb',
      ),
    ),
    'table' => 'accounts_tel_telefonos_1_c',
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
      'accounts_tel_telefonos_1accounts_ida' => 
      array (
        'name' => 'accounts_tel_telefonos_1accounts_ida',
        'type' => 'varchar',
        'len' => 36,
      ),
      'accounts_tel_telefonos_1tel_telefonos_idb' => 
      array (
        'name' => 'accounts_tel_telefonos_1tel_telefonos_idb',
        'type' => 'varchar',
        'len' => 36,
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'accounts_tel_telefonos_1spk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'accounts_tel_telefonos_1_ida1',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'accounts_tel_telefonos_1accounts_ida',
        ),
      ),
      2 => 
      array (
        'name' => 'accounts_tel_telefonos_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'accounts_tel_telefonos_1tel_telefonos_idb',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Tel_Telefonos',
    'rhs_table' => 'tel_telefonos',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'accounts_tel_telefonos_1_c',
    'join_key_lhs' => 'accounts_tel_telefonos_1accounts_ida',
    'join_key_rhs' => 'accounts_tel_telefonos_1tel_telefonos_idb',
    'readonly' => true,
    'relationship_name' => 'accounts_tel_telefonos_1',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'tel_telefonos_modified_user' => 
  array (
    'name' => 'tel_telefonos_modified_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Tel_Telefonos',
    'rhs_table' => 'tel_telefonos',
    'rhs_key' => 'modified_user_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'tel_telefonos_modified_user',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'tel_telefonos_created_by' => 
  array (
    'name' => 'tel_telefonos_created_by',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Tel_Telefonos',
    'rhs_table' => 'tel_telefonos',
    'rhs_key' => 'created_by',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'tel_telefonos_created_by',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'tel_telefonos_activities' => 
  array (
    'name' => 'tel_telefonos_activities',
    'lhs_module' => 'Tel_Telefonos',
    'lhs_table' => 'tel_telefonos',
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
    'relationship_role_column_value' => 'Tel_Telefonos',
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
    'relationship_name' => 'tel_telefonos_activities',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'tel_telefonos_following' => 
  array (
    'name' => 'tel_telefonos_following',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Tel_Telefonos',
    'rhs_table' => 'tel_telefonos',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'subscriptions',
    'join_key_lhs' => 'created_by',
    'join_key_rhs' => 'parent_id',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Tel_Telefonos',
    'user_field' => 'created_by',
    'readonly' => true,
    'relationship_name' => 'tel_telefonos_following',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'tel_telefonos_favorite' => 
  array (
    'name' => 'tel_telefonos_favorite',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Tel_Telefonos',
    'rhs_table' => 'tel_telefonos',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'sugarfavorites',
    'join_key_lhs' => 'modified_user_id',
    'join_key_rhs' => 'record_id',
    'relationship_role_column' => 'module',
    'relationship_role_column_value' => 'Tel_Telefonos',
    'user_field' => 'created_by',
    'readonly' => true,
    'relationship_name' => 'tel_telefonos_favorite',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'tel_telefonos_assigned_user' => 
  array (
    'name' => 'tel_telefonos_assigned_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Tel_Telefonos',
    'rhs_table' => 'tel_telefonos',
    'rhs_key' => 'assigned_user_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'tel_telefonos_assigned_user',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'tel_telefonos_calls_1' => 
  array (
    'rhs_label' => 'Llamadas',
    'lhs_label' => 'Telefonos',
    'rhs_subpanel' => 'default',
    'lhs_module' => 'Tel_Telefonos',
    'rhs_module' => 'Calls',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => true,
    'relationship_name' => 'tel_telefonos_calls_1',
  ),
);