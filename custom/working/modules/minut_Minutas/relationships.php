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
  'minut_minutas_meetings' => 
  array (
    'name' => 'minut_minutas_meetings',
    'true_relationship_type' => 'one-to-one',
    'relationships' => 
    array (
      'minut_minutas_meetings' => 
      array (
        'lhs_module' => 'minut_Minutas',
        'lhs_table' => 'minut_minutas',
        'lhs_key' => 'id',
        'rhs_module' => 'Meetings',
        'rhs_table' => 'meetings',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'minut_minutas_meetings_c',
        'join_key_lhs' => 'minut_minutas_meetingsminut_minutas_ida',
        'join_key_rhs' => 'minut_minutas_meetingsmeetings_idb',
      ),
    ),
    'table' => 'minut_minutas_meetings_c',
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
      'minut_minutas_meetingsminut_minutas_ida' => 
      array (
        'name' => 'minut_minutas_meetingsminut_minutas_ida',
        'type' => 'id',
      ),
      'minut_minutas_meetingsmeetings_idb' => 
      array (
        'name' => 'minut_minutas_meetingsmeetings_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_minut_minutas_meetings_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_minut_minutas_meetings_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'minut_minutas_meetingsminut_minutas_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_minut_minutas_meetings_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'minut_minutas_meetingsmeetings_idb',
          1 => 'deleted',
        ),
      ),
    ),
    'lhs_module' => 'minut_Minutas',
    'lhs_table' => 'minut_minutas',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-one',
    'join_table' => 'minut_minutas_meetings_c',
    'join_key_lhs' => 'minut_minutas_meetingsminut_minutas_ida',
    'join_key_rhs' => 'minut_minutas_meetingsmeetings_idb',
    'readonly' => true,
    'relationship_name' => 'minut_minutas_meetings',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  'minut_minutas_minut_compromisos' => 
  array (
    'name' => 'minut_minutas_minut_compromisos',
    'true_relationship_type' => 'one-to-many',
    'relationships' => 
    array (
      'minut_minutas_minut_compromisos' => 
      array (
        'lhs_module' => 'minut_Minutas',
        'lhs_table' => 'minut_minutas',
        'lhs_key' => 'id',
        'rhs_module' => 'minut_Compromisos',
        'rhs_table' => 'minut_compromisos',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'minut_minutas_minut_compromisos_c',
        'join_key_lhs' => 'minut_minutas_minut_compromisosminut_minutas_ida',
        'join_key_rhs' => 'minut_minutas_minut_compromisosminut_compromisos_idb',
      ),
    ),
    'table' => 'minut_minutas_minut_compromisos_c',
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
      'minut_minutas_minut_compromisosminut_minutas_ida' => 
      array (
        'name' => 'minut_minutas_minut_compromisosminut_minutas_ida',
        'type' => 'id',
      ),
      'minut_minutas_minut_compromisosminut_compromisos_idb' => 
      array (
        'name' => 'minut_minutas_minut_compromisosminut_compromisos_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_minut_minutas_minut_compromisos_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_minut_minutas_minut_compromisos_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'minut_minutas_minut_compromisosminut_minutas_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_minut_minutas_minut_compromisos_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'minut_minutas_minut_compromisosminut_compromisos_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'minut_minutas_minut_compromisos_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'minut_minutas_minut_compromisosminut_compromisos_idb',
        ),
      ),
    ),
    'lhs_module' => 'minut_Minutas',
    'lhs_table' => 'minut_minutas',
    'lhs_key' => 'id',
    'rhs_module' => 'minut_Compromisos',
    'rhs_table' => 'minut_compromisos',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'minut_minutas_minut_compromisos_c',
    'join_key_lhs' => 'minut_minutas_minut_compromisosminut_minutas_ida',
    'join_key_rhs' => 'minut_minutas_minut_compromisosminut_compromisos_idb',
    'readonly' => true,
    'relationship_name' => 'minut_minutas_minut_compromisos',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  'minut_minutas_minut_objetivos' => 
  array (
    'name' => 'minut_minutas_minut_objetivos',
    'true_relationship_type' => 'one-to-many',
    'relationships' => 
    array (
      'minut_minutas_minut_objetivos' => 
      array (
        'lhs_module' => 'minut_Minutas',
        'lhs_table' => 'minut_minutas',
        'lhs_key' => 'id',
        'rhs_module' => 'minut_Objetivos',
        'rhs_table' => 'minut_objetivos',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'minut_minutas_minut_objetivos_c',
        'join_key_lhs' => 'minut_minutas_minut_objetivosminut_minutas_ida',
        'join_key_rhs' => 'minut_minutas_minut_objetivosminut_objetivos_idb',
      ),
    ),
    'table' => 'minut_minutas_minut_objetivos_c',
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
      'minut_minutas_minut_objetivosminut_minutas_ida' => 
      array (
        'name' => 'minut_minutas_minut_objetivosminut_minutas_ida',
        'type' => 'id',
      ),
      'minut_minutas_minut_objetivosminut_objetivos_idb' => 
      array (
        'name' => 'minut_minutas_minut_objetivosminut_objetivos_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_minut_minutas_minut_objetivos_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_minut_minutas_minut_objetivos_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'minut_minutas_minut_objetivosminut_minutas_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_minut_minutas_minut_objetivos_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'minut_minutas_minut_objetivosminut_objetivos_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'minut_minutas_minut_objetivos_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'minut_minutas_minut_objetivosminut_objetivos_idb',
        ),
      ),
    ),
    'lhs_module' => 'minut_Minutas',
    'lhs_table' => 'minut_minutas',
    'lhs_key' => 'id',
    'rhs_module' => 'minut_Objetivos',
    'rhs_table' => 'minut_objetivos',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'minut_minutas_minut_objetivos_c',
    'join_key_lhs' => 'minut_minutas_minut_objetivosminut_minutas_ida',
    'join_key_rhs' => 'minut_minutas_minut_objetivosminut_objetivos_idb',
    'readonly' => true,
    'relationship_name' => 'minut_minutas_minut_objetivos',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  'minut_minutas_minut_participantes' => 
  array (
    'name' => 'minut_minutas_minut_participantes',
    'true_relationship_type' => 'one-to-many',
    'relationships' => 
    array (
      'minut_minutas_minut_participantes' => 
      array (
        'lhs_module' => 'minut_Minutas',
        'lhs_table' => 'minut_minutas',
        'lhs_key' => 'id',
        'rhs_module' => 'minut_Participantes',
        'rhs_table' => 'minut_participantes',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'minut_minutas_minut_participantes_c',
        'join_key_lhs' => 'minut_minutas_minut_participantesminut_minutas_ida',
        'join_key_rhs' => 'minut_minutas_minut_participantesminut_participantes_idb',
      ),
    ),
    'table' => 'minut_minutas_minut_participantes_c',
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
      'minut_minutas_minut_participantesminut_minutas_ida' => 
      array (
        'name' => 'minut_minutas_minut_participantesminut_minutas_ida',
        'type' => 'id',
      ),
      'minut_minutas_minut_participantesminut_participantes_idb' => 
      array (
        'name' => 'minut_minutas_minut_participantesminut_participantes_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_minut_minutas_minut_participantes_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_minut_minutas_minut_participantes_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'minut_minutas_minut_participantesminut_minutas_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_minut_minutas_minut_participantes_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'minut_minutas_minut_participantesminut_participantes_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'minut_minutas_minut_participantes_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'minut_minutas_minut_participantesminut_participantes_idb',
        ),
      ),
    ),
    'lhs_module' => 'minut_Minutas',
    'lhs_table' => 'minut_minutas',
    'lhs_key' => 'id',
    'rhs_module' => 'minut_Participantes',
    'rhs_table' => 'minut_participantes',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'minut_minutas_minut_participantes_c',
    'join_key_lhs' => 'minut_minutas_minut_participantesminut_minutas_ida',
    'join_key_rhs' => 'minut_minutas_minut_participantesminut_participantes_idb',
    'readonly' => true,
    'relationship_name' => 'minut_minutas_minut_participantes',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  'minut_minutas_documents_1' => 
  array (
    'name' => 'minut_minutas_documents_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'minut_minutas_documents_1' => 
      array (
        'lhs_module' => 'minut_Minutas',
        'lhs_table' => 'minut_minutas',
        'lhs_key' => 'id',
        'rhs_module' => 'Documents',
        'rhs_table' => 'documents',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'minut_minutas_documents_1_c',
        'join_key_lhs' => 'minut_minutas_documents_1minut_minutas_ida',
        'join_key_rhs' => 'minut_minutas_documents_1documents_idb',
      ),
    ),
    'table' => 'minut_minutas_documents_1_c',
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
      'minut_minutas_documents_1minut_minutas_ida' => 
      array (
        'name' => 'minut_minutas_documents_1minut_minutas_ida',
        'type' => 'id',
      ),
      'minut_minutas_documents_1documents_idb' => 
      array (
        'name' => 'minut_minutas_documents_1documents_idb',
        'type' => 'id',
      ),
      'document_revision_id' => 
      array (
        'name' => 'document_revision_id',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_minut_minutas_documents_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_minut_minutas_documents_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'minut_minutas_documents_1minut_minutas_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_minut_minutas_documents_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'minut_minutas_documents_1documents_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'minut_minutas_documents_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'minut_minutas_documents_1documents_idb',
        ),
      ),
    ),
    'lhs_module' => 'minut_Minutas',
    'lhs_table' => 'minut_minutas',
    'lhs_key' => 'id',
    'rhs_module' => 'Documents',
    'rhs_table' => 'documents',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'minut_minutas_documents_1_c',
    'join_key_lhs' => 'minut_minutas_documents_1minut_minutas_ida',
    'join_key_rhs' => 'minut_minutas_documents_1documents_idb',
    'readonly' => true,
    'relationship_name' => 'minut_minutas_documents_1',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'minut_minutas_modified_user' => 
  array (
    'name' => 'minut_minutas_modified_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'minut_Minutas',
    'rhs_table' => 'minut_minutas',
    'rhs_key' => 'modified_user_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'minut_minutas_modified_user',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'minut_minutas_created_by' => 
  array (
    'name' => 'minut_minutas_created_by',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'minut_Minutas',
    'rhs_table' => 'minut_minutas',
    'rhs_key' => 'created_by',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'minut_minutas_created_by',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'minut_minutas_activities' => 
  array (
    'name' => 'minut_minutas_activities',
    'lhs_module' => 'minut_Minutas',
    'lhs_table' => 'minut_minutas',
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
    'relationship_role_column_value' => 'minut_Minutas',
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
    'relationship_name' => 'minut_minutas_activities',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'minut_minutas_following' => 
  array (
    'name' => 'minut_minutas_following',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'minut_Minutas',
    'rhs_table' => 'minut_minutas',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'subscriptions',
    'join_key_lhs' => 'created_by',
    'join_key_rhs' => 'parent_id',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'minut_Minutas',
    'user_field' => 'created_by',
    'readonly' => true,
    'relationship_name' => 'minut_minutas_following',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'minut_minutas_favorite' => 
  array (
    'name' => 'minut_minutas_favorite',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'minut_Minutas',
    'rhs_table' => 'minut_minutas',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'sugarfavorites',
    'join_key_lhs' => 'modified_user_id',
    'join_key_rhs' => 'record_id',
    'relationship_role_column' => 'module',
    'relationship_role_column_value' => 'minut_Minutas',
    'user_field' => 'created_by',
    'readonly' => true,
    'relationship_name' => 'minut_minutas_favorite',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'minut_minutas_assigned_user' => 
  array (
    'name' => 'minut_minutas_assigned_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'minut_Minutas',
    'rhs_table' => 'minut_minutas',
    'rhs_key' => 'assigned_user_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'minut_minutas_assigned_user',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
);