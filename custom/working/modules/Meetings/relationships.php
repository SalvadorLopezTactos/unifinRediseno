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
  'meetings_contacts' => 
  array (
    'name' => 'meetings_contacts',
    'table' => 'meetings_contacts',
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
      'contact_id' => 
      array (
        'name' => 'contact_id',
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
        'name' => 'meetings_contactspk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_con_mtg_mtg',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'meeting_id',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_con_mtg_con',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'contact_id',
        ),
      ),
      3 => 
      array (
        'name' => 'idx_meeting_contact',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'meeting_id',
          1 => 'contact_id',
        ),
      ),
    ),
    'relationships' => 
    array (
      'meetings_contacts' => 
      array (
        'lhs_module' => 'Meetings',
        'lhs_table' => 'meetings',
        'lhs_key' => 'id',
        'rhs_module' => 'Contacts',
        'rhs_table' => 'contacts',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'meetings_contacts',
        'join_key_lhs' => 'meeting_id',
        'join_key_rhs' => 'contact_id',
      ),
    ),
    'lhs_module' => 'Meetings',
    'lhs_table' => 'meetings',
    'lhs_key' => 'id',
    'rhs_module' => 'Contacts',
    'rhs_table' => 'contacts',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'meetings_contacts',
    'join_key_lhs' => 'meeting_id',
    'join_key_rhs' => 'contact_id',
    'readonly' => true,
    'relationship_name' => 'meetings_contacts',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => 'default',
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'meetings_users' => 
  array (
    'name' => 'meetings_users',
    'table' => 'meetings_users',
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
      'user_id' => 
      array (
        'name' => 'user_id',
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
        'name' => 'meetings_userspk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_usr_mtg_mtg',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'meeting_id',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_usr_mtg_usr',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'user_id',
        ),
      ),
      3 => 
      array (
        'name' => 'idx_meeting_users',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'meeting_id',
          1 => 'user_id',
        ),
      ),
      4 => 
      array (
        'name' => 'idx_meeting_users_del',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'meeting_id',
          1 => 'user_id',
          2 => 'deleted',
        ),
      ),
    ),
    'relationships' => 
    array (
      'meetings_users' => 
      array (
        'lhs_module' => 'Meetings',
        'lhs_table' => 'meetings',
        'lhs_key' => 'id',
        'rhs_module' => 'Users',
        'rhs_table' => 'users',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'meetings_users',
        'join_key_lhs' => 'meeting_id',
        'join_key_rhs' => 'user_id',
      ),
    ),
    'lhs_module' => 'Meetings',
    'lhs_table' => 'meetings',
    'lhs_key' => 'id',
    'rhs_module' => 'Users',
    'rhs_table' => 'users',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'meetings_users',
    'join_key_lhs' => 'meeting_id',
    'join_key_rhs' => 'user_id',
    'readonly' => true,
    'relationship_name' => 'meetings_users',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
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
  'meetings_minut_objetivos_1' => 
  array (
    'name' => 'meetings_minut_objetivos_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'meetings_minut_objetivos_1' => 
      array (
        'lhs_module' => 'Meetings',
        'lhs_table' => 'meetings',
        'lhs_key' => 'id',
        'rhs_module' => 'minut_Objetivos',
        'rhs_table' => 'minut_objetivos',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'meetings_minut_objetivos_1_c',
        'join_key_lhs' => 'meetings_minut_objetivos_1meetings_ida',
        'join_key_rhs' => 'meetings_minut_objetivos_1minut_objetivos_idb',
      ),
    ),
    'table' => 'meetings_minut_objetivos_1_c',
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
      'meetings_minut_objetivos_1meetings_ida' => 
      array (
        'name' => 'meetings_minut_objetivos_1meetings_ida',
        'type' => 'id',
      ),
      'meetings_minut_objetivos_1minut_objetivos_idb' => 
      array (
        'name' => 'meetings_minut_objetivos_1minut_objetivos_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_meetings_minut_objetivos_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_meetings_minut_objetivos_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'meetings_minut_objetivos_1meetings_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_meetings_minut_objetivos_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'meetings_minut_objetivos_1minut_objetivos_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'meetings_minut_objetivos_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'meetings_minut_objetivos_1minut_objetivos_idb',
        ),
      ),
    ),
    'lhs_module' => 'Meetings',
    'lhs_table' => 'meetings',
    'lhs_key' => 'id',
    'rhs_module' => 'minut_Objetivos',
    'rhs_table' => 'minut_objetivos',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'meetings_minut_objetivos_1_c',
    'join_key_lhs' => 'meetings_minut_objetivos_1meetings_ida',
    'join_key_rhs' => 'meetings_minut_objetivos_1minut_objetivos_idb',
    'readonly' => true,
    'relationship_name' => 'meetings_minut_objetivos_1',
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
  'minut_minutas_meetings_2' => 
  array (
    'name' => 'minut_minutas_meetings_2',
    'true_relationship_type' => 'one-to-one',
    'from_studio' => true,
    'relationships' => 
    array (
      'minut_minutas_meetings_2' => 
      array (
        'lhs_module' => 'minut_Minutas',
        'lhs_table' => 'minut_minutas',
        'lhs_key' => 'id',
        'rhs_module' => 'Meetings',
        'rhs_table' => 'meetings',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'minut_minutas_meetings_2_c',
        'join_key_lhs' => 'minut_minutas_meetings_2minut_minutas_ida',
        'join_key_rhs' => 'minut_minutas_meetings_2meetings_idb',
      ),
    ),
    'table' => 'minut_minutas_meetings_2_c',
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
      'minut_minutas_meetings_2minut_minutas_ida' => 
      array (
        'name' => 'minut_minutas_meetings_2minut_minutas_ida',
        'type' => 'id',
      ),
      'minut_minutas_meetings_2meetings_idb' => 
      array (
        'name' => 'minut_minutas_meetings_2meetings_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_minut_minutas_meetings_2_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_minut_minutas_meetings_2_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'minut_minutas_meetings_2minut_minutas_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_minut_minutas_meetings_2_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'minut_minutas_meetings_2meetings_idb',
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
    'join_table' => 'minut_minutas_meetings_2_c',
    'join_key_lhs' => 'minut_minutas_meetings_2minut_minutas_ida',
    'join_key_rhs' => 'minut_minutas_meetings_2meetings_idb',
    'readonly' => true,
    'relationship_name' => 'minut_minutas_meetings_2',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'minut_minutas_meetings_1' => 
  array (
    'name' => 'minut_minutas_meetings_1',
    'true_relationship_type' => 'one-to-one',
    'from_studio' => true,
    'relationships' => 
    array (
      'minut_minutas_meetings_1' => 
      array (
        'lhs_module' => 'minut_Minutas',
        'lhs_table' => 'minut_minutas',
        'lhs_key' => 'id',
        'rhs_module' => 'Meetings',
        'rhs_table' => 'meetings',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'minut_minutas_meetings_1_c',
        'join_key_lhs' => 'minut_minutas_meetings_1minut_minutas_ida',
        'join_key_rhs' => 'minut_minutas_meetings_1meetings_idb',
      ),
    ),
    'table' => 'minut_minutas_meetings_1_c',
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
      'minut_minutas_meetings_1minut_minutas_ida' => 
      array (
        'name' => 'minut_minutas_meetings_1minut_minutas_ida',
        'type' => 'id',
      ),
      'minut_minutas_meetings_1meetings_idb' => 
      array (
        'name' => 'minut_minutas_meetings_1meetings_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_minut_minutas_meetings_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_minut_minutas_meetings_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'minut_minutas_meetings_1minut_minutas_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_minut_minutas_meetings_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'minut_minutas_meetings_1meetings_idb',
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
    'join_table' => 'minut_minutas_meetings_1_c',
    'join_key_lhs' => 'minut_minutas_meetings_1minut_minutas_ida',
    'join_key_rhs' => 'minut_minutas_meetings_1meetings_idb',
    'readonly' => true,
    'relationship_name' => 'minut_minutas_meetings_1',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
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
  'tct01_encuestas_meetings' => 
  array (
    'name' => 'tct01_encuestas_meetings',
    'true_relationship_type' => 'one-to-many',
    'relationships' => 
    array (
      'tct01_encuestas_meetings' => 
      array (
        'lhs_module' => 'Meetings',
        'lhs_table' => 'meetings',
        'lhs_key' => 'id',
        'rhs_module' => 'TCT01_Encuestas',
        'rhs_table' => 'tct01_encuestas',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'tct01_encuestas_meetings_c',
        'join_key_lhs' => 'tct01_encuestas_meetingsmeetings_ida',
        'join_key_rhs' => 'tct01_encuestas_meetingstct01_encuestas_idb',
      ),
    ),
    'table' => 'tct01_encuestas_meetings_c',
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
      'tct01_encuestas_meetingsmeetings_ida' => 
      array (
        'name' => 'tct01_encuestas_meetingsmeetings_ida',
        'type' => 'id',
      ),
      'tct01_encuestas_meetingstct01_encuestas_idb' => 
      array (
        'name' => 'tct01_encuestas_meetingstct01_encuestas_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_tct01_encuestas_meetings_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_tct01_encuestas_meetings_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'tct01_encuestas_meetingsmeetings_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_tct01_encuestas_meetings_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'tct01_encuestas_meetingstct01_encuestas_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'tct01_encuestas_meetings_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'tct01_encuestas_meetingstct01_encuestas_idb',
        ),
      ),
    ),
    'lhs_module' => 'Meetings',
    'lhs_table' => 'meetings',
    'lhs_key' => 'id',
    'rhs_module' => 'TCT01_Encuestas',
    'rhs_table' => 'tct01_encuestas',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'tct01_encuestas_meetings_c',
    'join_key_lhs' => 'tct01_encuestas_meetingsmeetings_ida',
    'join_key_rhs' => 'tct01_encuestas_meetingstct01_encuestas_idb',
    'readonly' => true,
    'relationship_name' => 'tct01_encuestas_meetings',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  'meetings_modified_user' => 
  array (
    'name' => 'meetings_modified_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'modified_user_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'meetings_modified_user',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'meetings_created_by' => 
  array (
    'name' => 'meetings_created_by',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'created_by',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'meetings_created_by',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'meeting_activities' => 
  array (
    'name' => 'meeting_activities',
    'lhs_module' => 'Meetings',
    'lhs_table' => 'meetings',
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
    'relationship_role_column_value' => 'Meetings',
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
    'relationship_name' => 'meeting_activities',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'meetings_assigned_user' => 
  array (
    'name' => 'meetings_assigned_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'assigned_user_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'meetings_assigned_user',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'meetings_notes' => 
  array (
    'name' => 'meetings_notes',
    'lhs_module' => 'Meetings',
    'lhs_table' => 'meetings',
    'lhs_key' => 'id',
    'rhs_module' => 'Notes',
    'rhs_table' => 'notes',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Meetings',
    'readonly' => true,
    'relationship_name' => 'meetings_notes',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'meetings_messages' => 
  array (
    'name' => 'meetings_messages',
    'lhs_module' => 'Meetings',
    'lhs_table' => 'meetings',
    'lhs_key' => 'id',
    'rhs_module' => 'Messages',
    'rhs_table' => 'messages',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Meetings',
    'readonly' => true,
    'relationship_name' => 'meetings_messages',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'meetings_following' => 
  array (
    'name' => 'meetings_following',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'subscriptions',
    'join_key_lhs' => 'created_by',
    'join_key_rhs' => 'parent_id',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Meetings',
    'user_field' => 'created_by',
    'readonly' => true,
    'relationship_name' => 'meetings_following',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'meetings_favorite' => 
  array (
    'name' => 'meetings_favorite',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'sugarfavorites',
    'join_key_lhs' => 'modified_user_id',
    'join_key_rhs' => 'record_id',
    'relationship_role_column' => 'module',
    'relationship_role_column_value' => 'Meetings',
    'user_field' => 'created_by',
    'readonly' => true,
    'relationship_name' => 'meetings_favorite',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'task_meetings_parent' => 
  array (
    'name' => 'task_meetings_parent',
    'lhs_module' => 'Tasks',
    'lhs_table' => 'tasks',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Tasks',
    'readonly' => true,
    'relationship_name' => 'task_meetings_parent',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
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
  'contact_meetings_parent' => 
  array (
    'name' => 'contact_meetings_parent',
    'lhs_module' => 'Contacts',
    'lhs_table' => 'contacts',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Contacts',
    'readonly' => true,
    'relationship_name' => 'contact_meetings_parent',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'account_meetings' => 
  array (
    'name' => 'account_meetings',
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Accounts',
    'readonly' => true,
    'relationship_name' => 'account_meetings',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'opportunity_meetings' => 
  array (
    'name' => 'opportunity_meetings',
    'lhs_module' => 'Opportunities',
    'lhs_table' => 'opportunities',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Opportunities',
    'readonly' => true,
    'relationship_name' => 'opportunity_meetings',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'prospect_meetings' => 
  array (
    'name' => 'prospect_meetings',
    'lhs_module' => 'Prospects',
    'lhs_table' => 'prospects',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Prospects',
    'readonly' => true,
    'relationship_name' => 'prospect_meetings',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'quote_meetings' => 
  array (
    'name' => 'quote_meetings',
    'lhs_module' => 'Quotes',
    'lhs_table' => 'quotes',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Quotes',
    'readonly' => true,
    'relationship_name' => 'quote_meetings',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'product_meetings' => 
  array (
    'name' => 'product_meetings',
    'lhs_module' => 'Products',
    'lhs_table' => 'products',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Products',
    'readonly' => true,
    'relationship_name' => 'product_meetings',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'purchase_meetings' => 
  array (
    'name' => 'purchase_meetings',
    'lhs_module' => 'Purchases',
    'lhs_table' => 'purchases',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Purchases',
    'readonly' => true,
    'relationship_name' => 'purchase_meetings',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'purchasedlineitem_meetings' => 
  array (
    'name' => 'purchasedlineitem_meetings',
    'lhs_module' => 'PurchasedLineItems',
    'lhs_table' => 'purchased_line_items',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'PurchasedLineItems',
    'readonly' => true,
    'relationship_name' => 'purchasedlineitem_meetings',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'case_meetings' => 
  array (
    'name' => 'case_meetings',
    'lhs_module' => 'Cases',
    'lhs_table' => 'cases',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Cases',
    'readonly' => true,
    'relationship_name' => 'case_meetings',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'projects_meetings' => 
  array (
    'name' => 'projects_meetings',
    'lhs_module' => 'Project',
    'lhs_table' => 'project',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Project',
    'readonly' => true,
    'relationship_name' => 'projects_meetings',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'bug_meetings' => 
  array (
    'name' => 'bug_meetings',
    'lhs_module' => 'Bugs',
    'lhs_table' => 'bugs',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Bugs',
    'readonly' => true,
    'relationship_name' => 'bug_meetings',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'kbcontent_meetings' => 
  array (
    'name' => 'kbcontent_meetings',
    'lhs_module' => 'KBContents',
    'lhs_table' => 'kbcontents',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'KBContents',
    'readonly' => true,
    'relationship_name' => 'kbcontent_meetings',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'revenuelineitem_meetings' => 
  array (
    'name' => 'revenuelineitem_meetings',
    'lhs_module' => 'RevenueLineItems',
    'lhs_table' => 'revenue_line_items',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'RevenueLineItems',
    'readonly' => true,
    'relationship_name' => 'revenuelineitem_meetings',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'project_tasks_meetings' => 
  array (
    'name' => 'project_tasks_meetings',
    'lhs_module' => 'ProjectTask',
    'lhs_table' => 'project_task',
    'lhs_key' => 'id',
    'rhs_module' => 'Meetings',
    'rhs_table' => 'meetings',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'ProjectTask',
    'readonly' => true,
    'relationship_name' => 'project_tasks_meetings',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'meetings_minut_participantes_1' => 
  array (
    'rhs_label' => 'Participantes',
    'lhs_label' => 'Reuniones',
    'rhs_subpanel' => 'default',
    'lhs_module' => 'Meetings',
    'rhs_module' => 'minut_Participantes',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => true,
    'relationship_name' => 'meetings_minut_participantes_1',
  ),
);