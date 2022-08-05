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
  'accounts_lic_licitaciones_1' => 
  array (
    'name' => 'accounts_lic_licitaciones_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'accounts_lic_licitaciones_1' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'Lic_Licitaciones',
        'rhs_table' => 'lic_licitaciones',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'accounts_lic_licitaciones_1_c',
        'join_key_lhs' => 'accounts_lic_licitaciones_1accounts_ida',
        'join_key_rhs' => 'accounts_lic_licitaciones_1lic_licitaciones_idb',
      ),
    ),
    'table' => 'accounts_lic_licitaciones_1_c',
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
      'accounts_lic_licitaciones_1accounts_ida' => 
      array (
        'name' => 'accounts_lic_licitaciones_1accounts_ida',
        'type' => 'id',
      ),
      'accounts_lic_licitaciones_1lic_licitaciones_idb' => 
      array (
        'name' => 'accounts_lic_licitaciones_1lic_licitaciones_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_accounts_lic_licitaciones_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_accounts_lic_licitaciones_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'accounts_lic_licitaciones_1accounts_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_accounts_lic_licitaciones_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'accounts_lic_licitaciones_1lic_licitaciones_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'accounts_lic_licitaciones_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'accounts_lic_licitaciones_1lic_licitaciones_idb',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Lic_Licitaciones',
    'rhs_table' => 'lic_licitaciones',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'accounts_lic_licitaciones_1_c',
    'join_key_lhs' => 'accounts_lic_licitaciones_1accounts_ida',
    'join_key_rhs' => 'accounts_lic_licitaciones_1lic_licitaciones_idb',
    'readonly' => true,
    'relationship_name' => 'accounts_lic_licitaciones_1',
    'rhs_subpanel' => 'ForAccountsLic_licitaciones_accounts',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'lic_licitaciones_accounts' => 
  array (
    'name' => 'lic_licitaciones_accounts',
    'true_relationship_type' => 'one-to-many',
    'relationships' => 
    array (
      'lic_licitaciones_accounts' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'Lic_Licitaciones',
        'rhs_table' => 'lic_licitaciones',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'lic_licitaciones_accounts_c',
        'join_key_lhs' => 'lic_licitaciones_accountsaccounts_ida',
        'join_key_rhs' => 'lic_licitaciones_accountslic_licitaciones_idb',
      ),
    ),
    'table' => 'lic_licitaciones_accounts_c',
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
      'lic_licitaciones_accountsaccounts_ida' => 
      array (
        'name' => 'lic_licitaciones_accountsaccounts_ida',
        'type' => 'id',
      ),
      'lic_licitaciones_accountslic_licitaciones_idb' => 
      array (
        'name' => 'lic_licitaciones_accountslic_licitaciones_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_lic_licitaciones_accounts_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_lic_licitaciones_accounts_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'lic_licitaciones_accountsaccounts_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_lic_licitaciones_accounts_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'lic_licitaciones_accountslic_licitaciones_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'lic_licitaciones_accounts_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'lic_licitaciones_accountslic_licitaciones_idb',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Lic_Licitaciones',
    'rhs_table' => 'lic_licitaciones',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'lic_licitaciones_accounts_c',
    'join_key_lhs' => 'lic_licitaciones_accountsaccounts_ida',
    'join_key_rhs' => 'lic_licitaciones_accountslic_licitaciones_idb',
    'readonly' => true,
    'relationship_name' => 'lic_licitaciones_accounts',
    'rhs_subpanel' => 'ForAccountsLic_licitaciones_accounts',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  'lic_licitaciones_modified_user' => 
  array (
    'name' => 'lic_licitaciones_modified_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Lic_Licitaciones',
    'rhs_table' => 'lic_licitaciones',
    'rhs_key' => 'modified_user_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'lic_licitaciones_modified_user',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'lic_licitaciones_created_by' => 
  array (
    'name' => 'lic_licitaciones_created_by',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Lic_Licitaciones',
    'rhs_table' => 'lic_licitaciones',
    'rhs_key' => 'created_by',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'lic_licitaciones_created_by',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'lic_licitaciones_activities' => 
  array (
    'name' => 'lic_licitaciones_activities',
    'lhs_module' => 'Lic_Licitaciones',
    'lhs_table' => 'lic_licitaciones',
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
    'relationship_role_column_value' => 'Lic_Licitaciones',
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
    'relationship_name' => 'lic_licitaciones_activities',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'lic_licitaciones_following' => 
  array (
    'name' => 'lic_licitaciones_following',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Lic_Licitaciones',
    'rhs_table' => 'lic_licitaciones',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'subscriptions',
    'join_key_lhs' => 'created_by',
    'join_key_rhs' => 'parent_id',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Lic_Licitaciones',
    'user_field' => 'created_by',
    'readonly' => true,
    'relationship_name' => 'lic_licitaciones_following',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'lic_licitaciones_favorite' => 
  array (
    'name' => 'lic_licitaciones_favorite',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Lic_Licitaciones',
    'rhs_table' => 'lic_licitaciones',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'sugarfavorites',
    'join_key_lhs' => 'modified_user_id',
    'join_key_rhs' => 'record_id',
    'relationship_role_column' => 'module',
    'relationship_role_column_value' => 'Lic_Licitaciones',
    'user_field' => 'created_by',
    'readonly' => true,
    'relationship_name' => 'lic_licitaciones_favorite',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'lic_licitaciones_assigned_user' => 
  array (
    'name' => 'lic_licitaciones_assigned_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Lic_Licitaciones',
    'rhs_table' => 'lic_licitaciones',
    'rhs_key' => 'assigned_user_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'lic_licitaciones_assigned_user',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'lic_licitaciones_calls_1' => 
  array (
    'name' => 'lic_licitaciones_calls_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'lic_licitaciones_calls_1' => 
      array (
        'lhs_module' => 'Lic_Licitaciones',
        'lhs_table' => 'lic_licitaciones',
        'lhs_key' => 'id',
        'rhs_module' => 'Calls',
        'rhs_table' => 'calls',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'lic_licitaciones_calls_1_c',
        'join_key_lhs' => 'lic_licitaciones_calls_1lic_licitaciones_ida',
        'join_key_rhs' => 'lic_licitaciones_calls_1calls_idb',
      ),
    ),
    'table' => 'lic_licitaciones_calls_1_c',
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
      'lic_licitaciones_calls_1lic_licitaciones_ida' => 
      array (
        'name' => 'lic_licitaciones_calls_1lic_licitaciones_ida',
        'type' => 'id',
      ),
      'lic_licitaciones_calls_1calls_idb' => 
      array (
        'name' => 'lic_licitaciones_calls_1calls_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_lic_licitaciones_calls_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_lic_licitaciones_calls_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'lic_licitaciones_calls_1lic_licitaciones_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_lic_licitaciones_calls_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'lic_licitaciones_calls_1calls_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'lic_licitaciones_calls_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'lic_licitaciones_calls_1calls_idb',
        ),
      ),
    ),
    'lhs_module' => 'Lic_Licitaciones',
    'lhs_table' => 'lic_licitaciones',
    'lhs_key' => 'id',
    'rhs_module' => 'Calls',
    'rhs_table' => 'calls',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'lic_licitaciones_calls_1_c',
    'join_key_lhs' => 'lic_licitaciones_calls_1lic_licitaciones_ida',
    'join_key_rhs' => 'lic_licitaciones_calls_1calls_idb',
    'readonly' => true,
    'relationship_name' => 'lic_licitaciones_calls_1',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'lic_licitaciones_meetings_1' => 
  array (
    'name' => 'lic_licitaciones_meetings_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'lic_licitaciones_meetings_1' => 
      array (
        'lhs_module' => 'Lic_Licitaciones',
        'lhs_table' => 'lic_licitaciones',
        'lhs_key' => 'id',
        'rhs_module' => 'Meetings',
        'rhs_table' => 'meetings',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'lic_licitaciones_meetings_1_c',
        'join_key_lhs' => 'lic_licitaciones_meetings_1lic_licitaciones_ida',
        'join_key_rhs' => 'lic_licitaciones_meetings_1meetings_idb',
      ),
    ),
    'table' => 'lic_licitaciones_meetings_1_c',
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
      'lic_licitaciones_meetings_1lic_licitaciones_ida' => 
      array (
        'name' => 'lic_licitaciones_meetings_1lic_licitaciones_ida',
        'type' => 'id',
      ),
      'lic_licitaciones_meetings_1meetings_idb' => 
      array (
        'name' => 'lic_licitaciones_meetings_1meetings_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_lic_licitaciones_meetings_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_lic_licitaciones_meetings_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'lic_licitaciones_meetings_1lic_licitaciones_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_lic_licitaciones_meetings_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'lic_licitaciones_meetings_1meetings_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'lic_licitaciones_meetings_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'lic_licitaciones_meetings_1meetings_idb',
        ),
      ),
    ),
    'lhs_module' => 'Lic_Licitaciones',
    'lhs_table' => 'lic_licitaciones',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'lic_licitaciones_meetings_1_c',
    'join_key_lhs' => 'lic_licitaciones_meetings_1lic_licitaciones_ida',
    'join_key_rhs' => 'lic_licitaciones_meetings_1meetings_idb',
    'readonly' => true,
    'relationship_name' => 'lic_licitaciones_meetings_1',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'lic_licitaciones_opportunities_1' => 
  array (
    'rhs_label' => 'Solicitudes y Líneas',
    'lhs_label' => 'Licitaciones',
    'rhs_subpanel' => 'default',
    'lhs_module' => 'Lic_Licitaciones',
    'rhs_module' => 'Opportunities',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => true,
    'relationship_name' => 'lic_licitaciones_opportunities_1',
  ),
);