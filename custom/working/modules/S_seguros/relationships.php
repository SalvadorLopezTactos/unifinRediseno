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
  's_seguros_accounts' => 
  array (
    'name' => 's_seguros_accounts',
    'true_relationship_type' => 'one-to-many',
    'relationships' => 
    array (
      's_seguros_accounts' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'S_seguros',
        'rhs_table' => 's_seguros',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 's_seguros_accounts_c',
        'join_key_lhs' => 's_seguros_accountsaccounts_ida',
        'join_key_rhs' => 's_seguros_accountss_seguros_idb',
      ),
    ),
    'table' => 's_seguros_accounts_c',
    'fields' => 
    array (
      'id' => 
      array (
        'name' => 'id',
        'type' => 'id',
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
        'default' => 0,
      ),
      's_seguros_accountsaccounts_ida' => 
      array (
        'name' => 's_seguros_accountsaccounts_ida',
        'type' => 'id',
      ),
      's_seguros_accountss_seguros_idb' => 
      array (
        'name' => 's_seguros_accountss_seguros_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_s_seguros_accounts_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_s_seguros_accounts_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 's_seguros_accountsaccounts_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_s_seguros_accounts_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 's_seguros_accountss_seguros_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 's_seguros_accounts_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 's_seguros_accountss_seguros_idb',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'S_seguros',
    'rhs_table' => 's_seguros',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 's_seguros_accounts_c',
    'join_key_lhs' => 's_seguros_accountsaccounts_ida',
    'join_key_rhs' => 's_seguros_accountss_seguros_idb',
    'readonly' => true,
    'relationship_name' => 's_seguros_accounts',
    'rhs_subpanel' => 'ForAccountsS_seguros_accounts',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  's_seguros_modified_user' => 
  array (
    'name' => 's_seguros_modified_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'S_seguros',
    'rhs_table' => 's_seguros',
    'rhs_key' => 'modified_user_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 's_seguros_modified_user',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  's_seguros_created_by' => 
  array (
    'name' => 's_seguros_created_by',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'S_seguros',
    'rhs_table' => 's_seguros',
    'rhs_key' => 'created_by',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 's_seguros_created_by',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  's_seguros_activities' => 
  array (
    'name' => 's_seguros_activities',
    'lhs_module' => 'S_seguros',
    'lhs_table' => 's_seguros',
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
    'relationship_role_column_value' => 'S_seguros',
    'fields' => 
    array (
      'id' => 
      array (
        'name' => 'id',
        'type' => 'id',
        'required' => true,
      ),
      'activity_id' => 
      array (
        'name' => 'activity_id',
        'type' => 'id',
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
    'relationship_name' => 's_seguros_activities',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  's_seguros_following' => 
  array (
    'name' => 's_seguros_following',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'S_seguros',
    'rhs_table' => 's_seguros',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'subscriptions',
    'join_key_lhs' => 'created_by',
    'join_key_rhs' => 'parent_id',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'S_seguros',
    'user_field' => 'created_by',
    'readonly' => true,
    'relationship_name' => 's_seguros_following',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  's_seguros_favorite' => 
  array (
    'name' => 's_seguros_favorite',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'S_seguros',
    'rhs_table' => 's_seguros',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'sugarfavorites',
    'join_key_lhs' => 'modified_user_id',
    'join_key_rhs' => 'record_id',
    'relationship_role_column' => 'module',
    'relationship_role_column_value' => 'S_seguros',
    'user_field' => 'created_by',
    'readonly' => true,
    'relationship_name' => 's_seguros_favorite',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  's_seguros_assigned_user' => 
  array (
    'name' => 's_seguros_assigned_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'S_seguros',
    'rhs_table' => 's_seguros',
    'rhs_key' => 'assigned_user_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 's_seguros_assigned_user',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  's_seguros_documents_1' => 
  array (
    'rhs_label' => 'Documentos',
    'lhs_label' => 'Seguros',
    'rhs_subpanel' => 'default',
    'lhs_module' => 'S_seguros',
    'rhs_module' => 'Documents',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => true,
    'relationship_name' => 's_seguros_documents_1',
  ),
);