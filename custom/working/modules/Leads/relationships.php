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
  'calls_leads' => 
  array (
    'name' => 'calls_leads',
    'table' => 'calls_leads',
    'fields' => 
    array (
      'id' => 
      array (
        'name' => 'id',
        'type' => 'id',
      ),
      'call_id' => 
      array (
        'name' => 'call_id',
        'type' => 'id',
      ),
      'lead_id' => 
      array (
        'name' => 'lead_id',
        'type' => 'id',
      ),
      'required' => 
      array (
        'name' => 'required',
        'type' => 'varchar',
        'len' => '1',
        'default' => '1',
      ),
      'accept_status' => 
      array (
        'name' => 'accept_status',
        'type' => 'varchar',
        'len' => '25',
        'default' => 'none',
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
        'required' => false,
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'calls_leadspk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_lead_call_call',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'call_id',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_lead_call_lead',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'lead_id',
        ),
      ),
      3 => 
      array (
        'name' => 'idx_call_lead',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'call_id',
          1 => 'lead_id',
        ),
      ),
    ),
    'relationships' => 
    array (
      'calls_leads' => 
      array (
        'lhs_module' => 'Calls',
        'lhs_table' => 'calls',
        'lhs_key' => 'id',
        'rhs_module' => 'Leads',
        'rhs_table' => 'leads',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'calls_leads',
        'join_key_lhs' => 'call_id',
        'join_key_rhs' => 'lead_id',
      ),
    ),
    'lhs_module' => 'Calls',
    'lhs_table' => 'calls',
    'lhs_key' => 'id',
    'rhs_module' => 'Leads',
    'rhs_table' => 'leads',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'calls_leads',
    'join_key_lhs' => 'call_id',
    'join_key_rhs' => 'lead_id',
    'readonly' => true,
    'relationship_name' => 'calls_leads',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => 'ForLeadsCalls',
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'meetings_leads' => 
  array (
    'name' => 'meetings_leads',
    'table' => 'meetings_leads',
    'fields' => 
    array (
      'id' => 
      array (
        'name' => 'id',
        'type' => 'id',
      ),
      'meeting_id' => 
      array (
        'name' => 'meeting_id',
        'type' => 'id',
      ),
      'lead_id' => 
      array (
        'name' => 'lead_id',
        'type' => 'id',
      ),
      'required' => 
      array (
        'name' => 'required',
        'type' => 'varchar',
        'len' => '1',
        'default' => '1',
      ),
      'accept_status' => 
      array (
        'name' => 'accept_status',
        'type' => 'varchar',
        'len' => '25',
        'default' => 'none',
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
        'required' => false,
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'meetings_leadspk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_lead_meeting_meeting',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'meeting_id',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_lead_meeting_lead',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'lead_id',
        ),
      ),
      3 => 
      array (
        'name' => 'idx_meeting_lead',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'meeting_id',
          1 => 'lead_id',
        ),
      ),
    ),
    'relationships' => 
    array (
      'meetings_leads' => 
      array (
        'lhs_module' => 'Meetings',
        'lhs_table' => 'meetings',
        'lhs_key' => 'id',
        'rhs_module' => 'Leads',
        'rhs_table' => 'leads',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'meetings_leads',
        'join_key_lhs' => 'meeting_id',
        'join_key_rhs' => 'lead_id',
      ),
    ),
    'lhs_module' => 'Meetings',
    'lhs_table' => 'meetings',
    'lhs_key' => 'id',
    'rhs_module' => 'Leads',
    'rhs_table' => 'leads',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'meetings_leads',
    'join_key_lhs' => 'meeting_id',
    'join_key_rhs' => 'lead_id',
    'readonly' => true,
    'relationship_name' => 'meetings_leads',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => 'ForLeadsMeetings',
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'leads_dataprivacy' => 
  array (
    'name' => 'leads_dataprivacy',
    'table' => 'leads_dataprivacy',
    'fields' => 
    array (
      'id' => 
      array (
        'name' => 'id',
        'type' => 'id',
      ),
      'lead_id' => 
      array (
        'name' => 'lead_id',
        'type' => 'id',
      ),
      'dataprivacy_id' => 
      array (
        'name' => 'dataprivacy_id',
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
        'len' => '1',
        'default' => '0',
        'required' => false,
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'leads_dataprivacypk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_lead_dataprivacy_lead',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'lead_id',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_lead_dataprivacy_dataprivacy',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'dataprivacy_id',
        ),
      ),
      3 => 
      array (
        'name' => 'idx_leads_dataprivacy',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'lead_id',
          1 => 'dataprivacy_id',
        ),
      ),
    ),
    'relationships' => 
    array (
      'leads_dataprivacy' => 
      array (
        'lhs_module' => 'Leads',
        'lhs_table' => 'leads',
        'lhs_key' => 'id',
        'rhs_module' => 'DataPrivacy',
        'rhs_table' => 'data_privacy',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'leads_dataprivacy',
        'join_key_lhs' => 'lead_id',
        'join_key_rhs' => 'dataprivacy_id',
      ),
    ),
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',
    'rhs_module' => 'DataPrivacy',
    'rhs_table' => 'data_privacy',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'leads_dataprivacy',
    'join_key_lhs' => 'lead_id',
    'join_key_rhs' => 'dataprivacy_id',
    'readonly' => true,
    'relationship_name' => 'leads_dataprivacy',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => 'default',
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'leads_leads_1' => 
  array (
    'name' => 'leads_leads_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'leads_leads_1' => 
      array (
        'lhs_module' => 'Leads',
        'lhs_table' => 'leads',
        'lhs_key' => 'id',
        'rhs_module' => 'Leads',
        'rhs_table' => 'leads',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'leads_leads_1_c',
        'join_key_lhs' => 'leads_leads_1leads_ida',
        'join_key_rhs' => 'leads_leads_1leads_idb',
      ),
    ),
    'table' => 'leads_leads_1_c',
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
      'leads_leads_1leads_ida' => 
      array (
        'name' => 'leads_leads_1leads_ida',
        'type' => 'id',
      ),
      'leads_leads_1leads_idb' => 
      array (
        'name' => 'leads_leads_1leads_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_leads_leads_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_leads_leads_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'leads_leads_1leads_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_leads_leads_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'leads_leads_1leads_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'leads_leads_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'leads_leads_1leads_idb',
        ),
      ),
    ),
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',
    'rhs_module' => 'Leads',
    'rhs_table' => 'leads',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'leads_leads_1_c',
    'join_key_lhs' => 'leads_leads_1leads_ida',
    'join_key_rhs' => 'leads_leads_1leads_idb',
    'readonly' => true,
    'relationship_name' => 'leads_leads_1',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => 'default',
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'tasks_leads_1' => 
  array (
    'name' => 'tasks_leads_1',
    'true_relationship_type' => 'many-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'tasks_leads_1' => 
      array (
        'lhs_module' => 'Tasks',
        'lhs_table' => 'tasks',
        'lhs_key' => 'id',
        'rhs_module' => 'Leads',
        'rhs_table' => 'leads',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'tasks_leads_1_c',
        'join_key_lhs' => 'tasks_leads_1tasks_ida',
        'join_key_rhs' => 'tasks_leads_1leads_idb',
      ),
    ),
    'table' => 'tasks_leads_1_c',
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
      'tasks_leads_1tasks_ida' => 
      array (
        'name' => 'tasks_leads_1tasks_ida',
        'type' => 'id',
      ),
      'tasks_leads_1leads_idb' => 
      array (
        'name' => 'tasks_leads_1leads_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_tasks_leads_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_tasks_leads_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'tasks_leads_1tasks_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_tasks_leads_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'tasks_leads_1leads_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'tasks_leads_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'tasks_leads_1tasks_ida',
          1 => 'tasks_leads_1leads_idb',
        ),
      ),
    ),
    'lhs_module' => 'Tasks',
    'lhs_table' => 'tasks',
    'lhs_key' => 'id',
    'rhs_module' => 'Leads',
    'rhs_table' => 'leads',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'tasks_leads_1_c',
    'join_key_lhs' => 'tasks_leads_1tasks_ida',
    'join_key_rhs' => 'tasks_leads_1leads_idb',
    'readonly' => true,
    'relationship_name' => 'tasks_leads_1',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => 'ForLeadsTasks',
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'leads_calls_1' => 
  array (
    'name' => 'leads_calls_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'leads_calls_1' => 
      array (
        'lhs_module' => 'Leads',
        'lhs_table' => 'leads',
        'lhs_key' => 'id',
        'rhs_module' => 'Calls',
        'rhs_table' => 'calls',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'leads_calls_1_c',
        'join_key_lhs' => 'leads_calls_1leads_ida',
        'join_key_rhs' => 'leads_calls_1calls_idb',
      ),
    ),
    'table' => 'leads_calls_1_c',
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
      'leads_calls_1leads_ida' => 
      array (
        'name' => 'leads_calls_1leads_ida',
        'type' => 'id',
      ),
      'leads_calls_1calls_idb' => 
      array (
        'name' => 'leads_calls_1calls_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_leads_calls_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_leads_calls_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'leads_calls_1leads_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_leads_calls_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'leads_calls_1calls_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'leads_calls_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'leads_calls_1calls_idb',
        ),
      ),
    ),
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',
    'rhs_module' => 'Calls',
    'rhs_table' => 'calls',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'leads_calls_1_c',
    'join_key_lhs' => 'leads_calls_1leads_ida',
    'join_key_rhs' => 'leads_calls_1calls_idb',
    'readonly' => true,
    'relationship_name' => 'leads_calls_1',
    'rhs_subpanel' => 'ForLeadsCalls',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'leads_dire_direccion_1' => 
  array (
    'name' => 'leads_dire_direccion_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'leads_dire_direccion_1' => 
      array (
        'lhs_module' => 'Leads',
        'lhs_table' => 'leads',
        'lhs_key' => 'id',
        'rhs_module' => 'dire_Direccion',
        'rhs_table' => 'dire_direccion',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'leads_dire_direccion_1_c',
        'join_key_lhs' => 'leads_dire_direccion_1leads_ida',
        'join_key_rhs' => 'leads_dire_direccion_1dire_direccion_idb',
      ),
    ),
    'table' => 'leads_dire_direccion_1_c',
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
      'leads_dire_direccion_1leads_ida' => 
      array (
        'name' => 'leads_dire_direccion_1leads_ida',
        'type' => 'id',
      ),
      'leads_dire_direccion_1dire_direccion_idb' => 
      array (
        'name' => 'leads_dire_direccion_1dire_direccion_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_leads_dire_direccion_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_leads_dire_direccion_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'leads_dire_direccion_1leads_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_leads_dire_direccion_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'leads_dire_direccion_1dire_direccion_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'leads_dire_direccion_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'leads_dire_direccion_1dire_direccion_idb',
        ),
      ),
    ),
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',
    'rhs_module' => 'dire_Direccion',
    'rhs_table' => 'dire_direccion',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'leads_dire_direccion_1_c',
    'join_key_lhs' => 'leads_dire_direccion_1leads_ida',
    'join_key_rhs' => 'leads_dire_direccion_1dire_direccion_idb',
    'readonly' => true,
    'relationship_name' => 'leads_dire_direccion_1',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'notes_leads_1' => 
  array (
    'name' => 'notes_leads_1',
    'true_relationship_type' => 'many-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'notes_leads_1' => 
      array (
        'lhs_module' => 'Notes',
        'lhs_table' => 'notes',
        'lhs_key' => 'id',
        'rhs_module' => 'Leads',
        'rhs_table' => 'leads',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'notes_leads_1_c',
        'join_key_lhs' => 'notes_leads_1notes_ida',
        'join_key_rhs' => 'notes_leads_1leads_idb',
      ),
    ),
    'table' => 'notes_leads_1_c',
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
      'notes_leads_1notes_ida' => 
      array (
        'name' => 'notes_leads_1notes_ida',
        'type' => 'id',
      ),
      'notes_leads_1leads_idb' => 
      array (
        'name' => 'notes_leads_1leads_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_notes_leads_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_notes_leads_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'notes_leads_1notes_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_notes_leads_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'notes_leads_1leads_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'notes_leads_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'notes_leads_1notes_ida',
          1 => 'notes_leads_1leads_idb',
        ),
      ),
    ),
    'lhs_module' => 'Notes',
    'lhs_table' => 'notes',
    'lhs_key' => 'id',
    'rhs_module' => 'Leads',
    'rhs_table' => 'leads',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'notes_leads_1_c',
    'join_key_lhs' => 'notes_leads_1notes_ida',
    'join_key_rhs' => 'notes_leads_1leads_idb',
    'readonly' => true,
    'relationship_name' => 'notes_leads_1',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => 'default',
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'leads_c5515_uni_chattigo_1' => 
  array (
    'name' => 'leads_c5515_uni_chattigo_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'leads_c5515_uni_chattigo_1' => 
      array (
        'lhs_module' => 'Leads',
        'lhs_table' => 'leads',
        'lhs_key' => 'id',
        'rhs_module' => 'C5515_uni_chattigo',
        'rhs_table' => 'c5515_uni_chattigo',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'leads_c5515_uni_chattigo_1_c',
        'join_key_lhs' => 'leads_c5515_uni_chattigo_1leads_ida',
        'join_key_rhs' => 'leads_c5515_uni_chattigo_1c5515_uni_chattigo_idb',
      ),
    ),
    'table' => 'leads_c5515_uni_chattigo_1_c',
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
      'leads_c5515_uni_chattigo_1leads_ida' => 
      array (
        'name' => 'leads_c5515_uni_chattigo_1leads_ida',
        'type' => 'id',
      ),
      'leads_c5515_uni_chattigo_1c5515_uni_chattigo_idb' => 
      array (
        'name' => 'leads_c5515_uni_chattigo_1c5515_uni_chattigo_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_leads_c5515_uni_chattigo_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_leads_c5515_uni_chattigo_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'leads_c5515_uni_chattigo_1leads_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_leads_c5515_uni_chattigo_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'leads_c5515_uni_chattigo_1c5515_uni_chattigo_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'leads_c5515_uni_chattigo_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'leads_c5515_uni_chattigo_1c5515_uni_chattigo_idb',
        ),
      ),
    ),
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',
    'rhs_module' => 'C5515_uni_chattigo',
    'rhs_table' => 'c5515_uni_chattigo',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'leads_c5515_uni_chattigo_1_c',
    'join_key_lhs' => 'leads_c5515_uni_chattigo_1leads_ida',
    'join_key_rhs' => 'leads_c5515_uni_chattigo_1c5515_uni_chattigo_idb',
    'readonly' => true,
    'relationship_name' => 'leads_c5515_uni_chattigo_1',
    'rhs_subpanel' => 'ForLeadsLeads_c5515_uni_chattigo_1',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'bc_survey_leads' => 
  array (
    'name' => 'bc_survey_leads',
    'true_relationship_type' => 'many-to-many',
    'relationships' => 
    array (
      'bc_survey_leads' => 
      array (
        'lhs_module' => 'bc_survey',
        'lhs_table' => 'bc_survey',
        'lhs_key' => 'id',
        'rhs_module' => 'Leads',
        'rhs_table' => 'leads',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'bc_survey_leads_c',
        'join_key_lhs' => 'bc_survey_leadsbc_survey_ida',
        'join_key_rhs' => 'bc_survey_leadsleads_idb',
      ),
    ),
    'table' => 'bc_survey_leads_c',
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
      'bc_survey_leadsbc_survey_ida' => 
      array (
        'name' => 'bc_survey_leadsbc_survey_ida',
        'type' => 'varchar',
        'len' => 36,
      ),
      'bc_survey_leadsleads_idb' => 
      array (
        'name' => 'bc_survey_leadsleads_idb',
        'type' => 'varchar',
        'len' => 36,
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'bc_survey_leadsspk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'bc_survey_leads_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'bc_survey_leadsbc_survey_ida',
          1 => 'bc_survey_leadsleads_idb',
        ),
      ),
    ),
    'lhs_module' => 'bc_survey',
    'lhs_table' => 'bc_survey',
    'lhs_key' => 'id',
    'rhs_module' => 'Leads',
    'rhs_table' => 'leads',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'bc_survey_leads_c',
    'join_key_lhs' => 'bc_survey_leadsbc_survey_ida',
    'join_key_rhs' => 'bc_survey_leadsleads_idb',
    'readonly' => true,
    'relationship_name' => 'bc_survey_leads',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  'leads_lic_licitaciones_1' => 
  array (
    'name' => 'leads_lic_licitaciones_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'leads_lic_licitaciones_1' => 
      array (
        'lhs_module' => 'Leads',
        'lhs_table' => 'leads',
        'lhs_key' => 'id',
        'rhs_module' => 'Lic_Licitaciones',
        'rhs_table' => 'lic_licitaciones',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'leads_lic_licitaciones_1_c',
        'join_key_lhs' => 'leads_lic_licitaciones_1leads_ida',
        'join_key_rhs' => 'leads_lic_licitaciones_1lic_licitaciones_idb',
      ),
    ),
    'table' => 'leads_lic_licitaciones_1_c',
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
      'leads_lic_licitaciones_1leads_ida' => 
      array (
        'name' => 'leads_lic_licitaciones_1leads_ida',
        'type' => 'id',
      ),
      'leads_lic_licitaciones_1lic_licitaciones_idb' => 
      array (
        'name' => 'leads_lic_licitaciones_1lic_licitaciones_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_leads_lic_licitaciones_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_leads_lic_licitaciones_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'leads_lic_licitaciones_1leads_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_leads_lic_licitaciones_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'leads_lic_licitaciones_1lic_licitaciones_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'leads_lic_licitaciones_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'leads_lic_licitaciones_1lic_licitaciones_idb',
        ),
      ),
    ),
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',
    'rhs_module' => 'Lic_Licitaciones',
    'rhs_table' => 'lic_licitaciones',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'leads_lic_licitaciones_1_c',
    'join_key_lhs' => 'leads_lic_licitaciones_1leads_ida',
    'join_key_rhs' => 'leads_lic_licitaciones_1lic_licitaciones_idb',
    'readonly' => true,
    'relationship_name' => 'leads_lic_licitaciones_1',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'leads_anlzt_analizate_1' => 
  array (
    'name' => 'leads_anlzt_analizate_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'leads_anlzt_analizate_1' => 
      array (
        'lhs_module' => 'Leads',
        'lhs_table' => 'leads',
        'lhs_key' => 'id',
        'rhs_module' => 'ANLZT_analizate',
        'rhs_table' => 'anlzt_analizate',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'leads_anlzt_analizate_1_c',
        'join_key_lhs' => 'leads_anlzt_analizate_1leads_ida',
        'join_key_rhs' => 'leads_anlzt_analizate_1anlzt_analizate_idb',
      ),
    ),
    'table' => 'leads_anlzt_analizate_1_c',
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
      'leads_anlzt_analizate_1leads_ida' => 
      array (
        'name' => 'leads_anlzt_analizate_1leads_ida',
        'type' => 'id',
      ),
      'leads_anlzt_analizate_1anlzt_analizate_idb' => 
      array (
        'name' => 'leads_anlzt_analizate_1anlzt_analizate_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_leads_anlzt_analizate_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_leads_anlzt_analizate_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'leads_anlzt_analizate_1leads_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_leads_anlzt_analizate_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'leads_anlzt_analizate_1anlzt_analizate_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'leads_anlzt_analizate_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'leads_anlzt_analizate_1anlzt_analizate_idb',
        ),
      ),
    ),
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',
    'rhs_module' => 'ANLZT_analizate',
    'rhs_table' => 'anlzt_analizate',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'leads_anlzt_analizate_1_c',
    'join_key_lhs' => 'leads_anlzt_analizate_1leads_ida',
    'join_key_rhs' => 'leads_anlzt_analizate_1anlzt_analizate_idb',
    'readonly' => true,
    'relationship_name' => 'leads_anlzt_analizate_1',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'leads_modified_user' => 
  array (
    'name' => 'leads_modified_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Leads',
    'rhs_table' => 'leads',
    'rhs_key' => 'modified_user_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'leads_modified_user',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'leads_created_by' => 
  array (
    'name' => 'leads_created_by',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Leads',
    'rhs_table' => 'leads',
    'rhs_key' => 'created_by',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'leads_created_by',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'lead_activities' => 
  array (
    'name' => 'lead_activities',
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
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
    'relationship_role_column_value' => 'Leads',
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
    'relationship_name' => 'lead_activities',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'lead_prospect' => 
  array (
    'name' => 'lead_prospect',
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',
    'rhs_module' => 'Prospects',
    'rhs_table' => 'prospects',
    'rhs_key' => 'lead_id',
    'relationship_type' => 'one-to-one',
    'readonly' => true,
    'relationship_name' => 'lead_prospect',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'lead_direct_reports' => 
  array (
    'name' => 'lead_direct_reports',
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',
    'rhs_module' => 'Leads',
    'rhs_table' => 'leads',
    'rhs_key' => 'reports_to_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'lead_direct_reports',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => 'default',
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'lead_tasks' => 
  array (
    'name' => 'lead_tasks',
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',
    'rhs_module' => 'Tasks',
    'rhs_table' => 'tasks',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Leads',
    'readonly' => true,
    'relationship_name' => 'lead_tasks',
    'rhs_subpanel' => 'ForLeadsTasks',
    'lhs_subpanel' => 'default',
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'lead_notes' => 
  array (
    'name' => 'lead_notes',
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',
    'rhs_module' => 'Notes',
    'rhs_table' => 'notes',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Leads',
    'readonly' => true,
    'relationship_name' => 'lead_notes',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => 'default',
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'lead_meetings' => 
  array (
    'name' => 'lead_meetings',
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Leads',
    'readonly' => true,
    'relationship_name' => 'lead_meetings',
    'rhs_subpanel' => 'ForLeadsMeetings',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'lead_calls' => 
  array (
    'name' => 'lead_calls',
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',
    'rhs_module' => 'Calls',
    'rhs_table' => 'calls',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Leads',
    'readonly' => true,
    'relationship_name' => 'lead_calls',
    'rhs_subpanel' => 'ForLeadsCalls',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'leads_following' => 
  array (
    'name' => 'leads_following',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Leads',
    'rhs_table' => 'leads',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'subscriptions',
    'join_key_lhs' => 'created_by',
    'join_key_rhs' => 'parent_id',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Leads',
    'user_field' => 'created_by',
    'readonly' => true,
    'relationship_name' => 'leads_following',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'leads_favorite' => 
  array (
    'name' => 'leads_favorite',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Leads',
    'rhs_table' => 'leads',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'sugarfavorites',
    'join_key_lhs' => 'modified_user_id',
    'join_key_rhs' => 'record_id',
    'relationship_role_column' => 'module',
    'relationship_role_column_value' => 'Leads',
    'user_field' => 'created_by',
    'readonly' => true,
    'relationship_name' => 'leads_favorite',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'leads_assigned_user' => 
  array (
    'name' => 'leads_assigned_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Leads',
    'rhs_table' => 'leads',
    'rhs_key' => 'assigned_user_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'leads_assigned_user',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'bc_survey_submission_leads' => 
  array (
    'name' => 'bc_survey_submission_leads',
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',
    'rhs_module' => 'bc_survey_submission',
    'rhs_table' => 'bc_survey_submission',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Leads',
    'readonly' => true,
    'relationship_name' => 'bc_survey_submission_leads',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'bc_survey_submission_leads_target' => 
  array (
    'name' => 'bc_survey_submission_leads_target',
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',
    'rhs_module' => 'bc_survey_submission',
    'rhs_table' => 'bc_survey_submission',
    'rhs_key' => 'target_parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'target_parent_type',
    'relationship_role_column_value' => 'Leads',
    'readonly' => true,
    'relationship_name' => 'bc_survey_submission_leads_target',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'contact_leads' => 
  array (
    'name' => 'contact_leads',
    'lhs_module' => 'Contacts',
    'lhs_table' => 'contacts',
    'lhs_key' => 'id',
    'rhs_module' => 'Leads',
    'rhs_table' => 'leads',
    'rhs_key' => 'contact_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'contact_leads',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'account_leads' => 
  array (
    'name' => 'account_leads',
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Leads',
    'rhs_table' => 'leads',
    'rhs_key' => 'account_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'account_leads',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'opportunity_leads' => 
  array (
    'name' => 'opportunity_leads',
    'lhs_module' => 'Opportunities',
    'lhs_table' => 'opportunities',
    'lhs_key' => 'id',
    'rhs_module' => 'Leads',
    'rhs_table' => 'leads',
    'rhs_key' => 'opportunity_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'opportunity_leads',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'campaign_leads' => 
  array (
    'name' => 'campaign_leads',
    'lhs_module' => 'Campaigns',
    'lhs_table' => 'campaigns',
    'lhs_key' => 'id',
    'rhs_module' => 'Leads',
    'rhs_table' => 'leads',
    'rhs_key' => 'campaign_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'campaign_leads',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'leads_cases_1' => 
  array (
    'rhs_label' => 'Casos',
    'lhs_label' => 'Leads',
    'rhs_subpanel' => 'default',
    'lhs_module' => 'Leads',
    'rhs_module' => 'Cases',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => true,
    'relationship_name' => 'leads_cases_1',
  ),
);