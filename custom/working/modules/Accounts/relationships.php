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
  'accounts_bugs' => 
  array (
    'name' => 'accounts_bugs',
    'table' => 'accounts_bugs',
    'fields' => 
    array (
      'id' => 
      array (
        'name' => 'id',
        'type' => 'id',
      ),
      'account_id' => 
      array (
        'name' => 'account_id',
        'type' => 'id',
      ),
      'bug_id' => 
      array (
        'name' => 'bug_id',
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
        'required' => false,
        'default' => '0',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'accounts_bugspk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_acc_bug_acc',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'account_id',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_acc_bug_bug',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'bug_id',
        ),
      ),
      3 => 
      array (
        'name' => 'idx_account_bug',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'account_id',
          1 => 'bug_id',
        ),
      ),
    ),
    'relationships' => 
    array (
      'accounts_bugs' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'Bugs',
        'rhs_table' => 'bugs',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'accounts_bugs',
        'join_key_lhs' => 'account_id',
        'join_key_rhs' => 'bug_id',
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Bugs',
    'rhs_table' => 'bugs',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'accounts_bugs',
    'join_key_lhs' => 'account_id',
    'join_key_rhs' => 'bug_id',
    'readonly' => true,
    'relationship_name' => 'accounts_bugs',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => 'default',
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'accounts_contacts' => 
  array (
    'name' => 'accounts_contacts',
    'table' => 'accounts_contacts',
    'fields' => 
    array (
      'id' => 
      array (
        'name' => 'id',
        'type' => 'id',
      ),
      'contact_id' => 
      array (
        'name' => 'contact_id',
        'type' => 'id',
      ),
      'account_id' => 
      array (
        'name' => 'account_id',
        'type' => 'id',
      ),
      'date_modified' => 
      array (
        'name' => 'date_modified',
        'type' => 'datetime',
      ),
      'primary_account' => 
      array (
        'name' => 'primary_account',
        'type' => 'bool',
        'default' => '0',
      ),
      'deleted' => 
      array (
        'name' => 'deleted',
        'type' => 'bool',
        'len' => '1',
        'required' => false,
        'default' => '0',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'accounts_contactspk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_account_contact',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'account_id',
          1 => 'contact_id',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_contid_del_accid',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'contact_id',
          1 => 'deleted',
          2 => 'account_id',
        ),
      ),
    ),
    'relationships' => 
    array (
      'accounts_contacts' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'Contacts',
        'rhs_table' => 'contacts',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'accounts_contacts',
        'join_key_lhs' => 'account_id',
        'join_key_rhs' => 'contact_id',
        'primary_flag_column' => 'primary_account',
        'primary_flag_side' => 'rhs',
        'primary_flag_default' => true,
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Contacts',
    'rhs_table' => 'contacts',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'accounts_contacts',
    'join_key_lhs' => 'account_id',
    'join_key_rhs' => 'contact_id',
    'primary_flag_column' => 'primary_account',
    'primary_flag_side' => 'rhs',
    'primary_flag_default' => true,
    'readonly' => true,
    'relationship_name' => 'accounts_contacts',
    'rhs_subpanel' => 'ForAccounts',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'accounts_opportunities' => 
  array (
    'name' => 'accounts_opportunities',
    'table' => 'accounts_opportunities',
    'fields' => 
    array (
      'id' => 
      array (
        'name' => 'id',
        'type' => 'id',
      ),
      'opportunity_id' => 
      array (
        'name' => 'opportunity_id',
        'type' => 'id',
      ),
      'account_id' => 
      array (
        'name' => 'account_id',
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
        'name' => 'accounts_opportunitiespk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_account_opportunity',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'account_id',
          1 => 'opportunity_id',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_oppid_del_accid',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'opportunity_id',
          1 => 'deleted',
          2 => 'account_id',
        ),
      ),
    ),
    'relationships' => 
    array (
      'accounts_opportunities' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'Opportunities',
        'rhs_table' => 'opportunities',
        'rhs_key' => 'id',
        'relationship_type' => 'one-to-many',
        'join_table' => 'accounts_opportunities',
        'join_key_lhs' => 'account_id',
        'join_key_rhs' => 'opportunity_id',
        'true_relationship_type' => 'one-to-many',
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Opportunities',
    'rhs_table' => 'opportunities',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'accounts_opportunities',
    'join_key_lhs' => 'account_id',
    'join_key_rhs' => 'opportunity_id',
    'true_relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'accounts_opportunities',
    'rhs_subpanel' => 'ForAccountsOpportunities',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'projects_accounts' => 
  array (
    'name' => 'projects_accounts',
    'table' => 'projects_accounts',
    'fields' => 
    array (
      'id' => 
      array (
        'name' => 'id',
        'type' => 'id',
      ),
      'account_id' => 
      array (
        'name' => 'account_id',
        'type' => 'id',
      ),
      'project_id' => 
      array (
        'name' => 'project_id',
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
        'name' => 'projects_accounts_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_proj_acct_proj',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'project_id',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_proj_acct_acct',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'account_id',
        ),
      ),
      3 => 
      array (
        'name' => 'projects_accounts_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'project_id',
          1 => 'account_id',
        ),
      ),
    ),
    'relationships' => 
    array (
      'projects_accounts' => 
      array (
        'lhs_module' => 'Project',
        'lhs_table' => 'project',
        'lhs_key' => 'id',
        'rhs_module' => 'Accounts',
        'rhs_table' => 'accounts',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'projects_accounts',
        'join_key_lhs' => 'project_id',
        'join_key_rhs' => 'account_id',
      ),
    ),
    'lhs_module' => 'Project',
    'lhs_table' => 'project',
    'lhs_key' => 'id',
    'rhs_module' => 'Accounts',
    'rhs_table' => 'accounts',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'projects_accounts',
    'join_key_lhs' => 'project_id',
    'join_key_rhs' => 'account_id',
    'readonly' => true,
    'relationship_name' => 'projects_accounts',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => 'default',
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'quotes_billto_accounts' => 
  array (
    'name' => 'quotes_billto_accounts',
    'rhs_module' => 'Quotes',
    'rhs_table' => 'quotes',
    'rhs_key' => 'id',
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'true_relationship_type' => 'one-to-many',
    'join_table' => 'quotes_accounts',
    'join_key_rhs' => 'quote_id',
    'join_key_lhs' => 'account_id',
    'relationship_role_column' => 'account_role',
    'relationship_role_column_value' => 'Bill To',
    'fields' => 
    array (
      'id' => 
      array (
        'name' => 'id',
        'type' => 'id',
      ),
      'quote_id' => 
      array (
        'name' => 'quote_id',
        'type' => 'id',
      ),
      'account_id' => 
      array (
        'name' => 'account_id',
        'type' => 'id',
      ),
      'account_role' => 
      array (
        'name' => 'account_role',
        'type' => 'varchar',
        'len' => '20',
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
    'readonly' => true,
    'relationship_name' => 'quotes_billto_accounts',
    'rhs_subpanel' => 'ForAccounts',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'quotes_shipto_accounts' => 
  array (
    'name' => 'quotes_shipto_accounts',
    'rhs_module' => 'Quotes',
    'rhs_table' => 'quotes',
    'rhs_key' => 'id',
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'true_relationship_type' => 'one-to-many',
    'join_table' => 'quotes_accounts',
    'join_key_rhs' => 'quote_id',
    'join_key_lhs' => 'account_id',
    'relationship_role_column' => 'account_role',
    'relationship_role_column_value' => 'Ship To',
    'fields' => 
    array (
      'id' => 
      array (
        'name' => 'id',
        'type' => 'id',
      ),
      'quote_id' => 
      array (
        'name' => 'quote_id',
        'type' => 'id',
      ),
      'account_id' => 
      array (
        'name' => 'account_id',
        'type' => 'id',
      ),
      'account_role' => 
      array (
        'name' => 'account_role',
        'type' => 'varchar',
        'len' => '20',
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
    'readonly' => true,
    'relationship_name' => 'quotes_shipto_accounts',
    'rhs_subpanel' => 'ForAccounts',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'accounts_dataprivacy' => 
  array (
    'name' => 'accounts_dataprivacy',
    'table' => 'accounts_dataprivacy',
    'fields' => 
    array (
      'id' => 
      array (
        'name' => 'id',
        'type' => 'id',
      ),
      'account_id' => 
      array (
        'name' => 'account_id',
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
        'name' => 'accounts_dataprivacypk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_acc_dataprivacy_acc',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'account_id',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_acc_dataprivacy_dataprivacy',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'dataprivacy_id',
        ),
      ),
      3 => 
      array (
        'name' => 'idx_accounts_dataprivacy',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'account_id',
          1 => 'dataprivacy_id',
        ),
      ),
    ),
    'relationships' => 
    array (
      'accounts_dataprivacy' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'DataPrivacy',
        'rhs_table' => 'data_privacy',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'accounts_dataprivacy',
        'join_key_lhs' => 'account_id',
        'join_key_rhs' => 'dataprivacy_id',
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'DataPrivacy',
    'rhs_table' => 'data_privacy',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'accounts_dataprivacy',
    'join_key_lhs' => 'account_id',
    'join_key_rhs' => 'dataprivacy_id',
    'readonly' => true,
    'relationship_name' => 'accounts_dataprivacy',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => 'default',
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'documents_accounts' => 
  array (
    'name' => 'documents_accounts',
    'true_relationship_type' => 'many-to-many',
    'relationships' => 
    array (
      'documents_accounts' => 
      array (
        'lhs_module' => 'Documents',
        'lhs_table' => 'documents',
        'lhs_key' => 'id',
        'rhs_module' => 'Accounts',
        'rhs_table' => 'accounts',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'documents_accounts',
        'join_key_lhs' => 'document_id',
        'join_key_rhs' => 'account_id',
      ),
    ),
    'table' => 'documents_accounts',
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
        'len' => '1',
        'default' => '0',
        'required' => true,
      ),
      'document_id' => 
      array (
        'name' => 'document_id',
        'type' => 'id',
      ),
      'account_id' => 
      array (
        'name' => 'account_id',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'documents_accountsspk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'documents_accounts_account_id',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'account_id',
          1 => 'document_id',
        ),
      ),
      2 => 
      array (
        'name' => 'documents_accounts_document_id',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'document_id',
          1 => 'account_id',
        ),
      ),
    ),
    'lhs_module' => 'Documents',
    'lhs_table' => 'documents',
    'lhs_key' => 'id',
    'rhs_module' => 'Accounts',
    'rhs_table' => 'accounts',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'documents_accounts',
    'join_key_lhs' => 'document_id',
    'join_key_rhs' => 'account_id',
    'readonly' => true,
    'relationship_name' => 'documents_accounts',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => 'ForAccountsDocuments',
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'accounts_dire_direccion_1' => 
  array (
    'name' => 'accounts_dire_direccion_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'accounts_dire_direccion_1' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'dire_Direccion',
        'rhs_table' => 'dire_direccion',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'accounts_dire_direccion_1_c',
        'join_key_lhs' => 'accounts_dire_direccion_1accounts_ida',
        'join_key_rhs' => 'accounts_dire_direccion_1dire_direccion_idb',
      ),
    ),
    'table' => 'accounts_dire_direccion_1_c',
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
      'accounts_dire_direccion_1accounts_ida' => 
      array (
        'name' => 'accounts_dire_direccion_1accounts_ida',
        'type' => 'varchar',
        'len' => 36,
      ),
      'accounts_dire_direccion_1dire_direccion_idb' => 
      array (
        'name' => 'accounts_dire_direccion_1dire_direccion_idb',
        'type' => 'varchar',
        'len' => 36,
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'accounts_dire_direccion_1spk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'accounts_dire_direccion_1_ida1',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'accounts_dire_direccion_1accounts_ida',
        ),
      ),
      2 => 
      array (
        'name' => 'accounts_dire_direccion_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'accounts_dire_direccion_1dire_direccion_idb',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'dire_Direccion',
    'rhs_table' => 'dire_direccion',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'accounts_dire_direccion_1_c',
    'join_key_lhs' => 'accounts_dire_direccion_1accounts_ida',
    'join_key_rhs' => 'accounts_dire_direccion_1dire_direccion_idb',
    'readonly' => true,
    'relationship_name' => 'accounts_dire_direccion_1',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'accounts_opportunities_1' => 
  array (
    'name' => 'accounts_opportunities_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'accounts_opportunities_1' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'Opportunities',
        'rhs_table' => 'opportunities',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'accounts_opportunities_1_c',
        'join_key_lhs' => 'accounts_opportunities_1accounts_ida',
        'join_key_rhs' => 'accounts_opportunities_1opportunities_idb',
      ),
    ),
    'table' => 'accounts_opportunities_1_c',
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
      'accounts_opportunities_1accounts_ida' => 
      array (
        'name' => 'accounts_opportunities_1accounts_ida',
        'type' => 'varchar',
        'len' => 36,
      ),
      'accounts_opportunities_1opportunities_idb' => 
      array (
        'name' => 'accounts_opportunities_1opportunities_idb',
        'type' => 'varchar',
        'len' => 36,
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'accounts_opportunities_1spk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'accounts_opportunities_1_ida1',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'accounts_opportunities_1accounts_ida',
        ),
      ),
      2 => 
      array (
        'name' => 'accounts_opportunities_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'accounts_opportunities_1opportunities_idb',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Opportunities',
    'rhs_table' => 'opportunities',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'accounts_opportunities_1_c',
    'join_key_lhs' => 'accounts_opportunities_1accounts_ida',
    'join_key_rhs' => 'accounts_opportunities_1opportunities_idb',
    'readonly' => true,
    'relationship_name' => 'accounts_opportunities_1',
    'rhs_subpanel' => 'ForAccountsOpportunities',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
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
  'ag_agencias_accounts' => 
  array (
    'name' => 'ag_agencias_accounts',
    'true_relationship_type' => 'one-to-many',
    'relationships' => 
    array (
      'ag_agencias_accounts' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'AG_Agencias',
        'rhs_table' => 'ag_agencias',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'ag_agencias_accounts_c',
        'join_key_lhs' => 'ag_agencias_accountsaccounts_ida',
        'join_key_rhs' => 'ag_agencias_accountsag_agencias_idb',
      ),
    ),
    'table' => 'ag_agencias_accounts_c',
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
      'ag_agencias_accountsaccounts_ida' => 
      array (
        'name' => 'ag_agencias_accountsaccounts_ida',
        'type' => 'varchar',
        'len' => 36,
      ),
      'ag_agencias_accountsag_agencias_idb' => 
      array (
        'name' => 'ag_agencias_accountsag_agencias_idb',
        'type' => 'varchar',
        'len' => 36,
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'ag_agencias_accountsspk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'ag_agencias_accounts_ida1',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'ag_agencias_accountsaccounts_ida',
        ),
      ),
      2 => 
      array (
        'name' => 'ag_agencias_accounts_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'ag_agencias_accountsag_agencias_idb',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'AG_Agencias',
    'rhs_table' => 'ag_agencias',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'ag_agencias_accounts_c',
    'join_key_lhs' => 'ag_agencias_accountsaccounts_ida',
    'join_key_rhs' => 'ag_agencias_accountsag_agencias_idb',
    'readonly' => true,
    'relationship_name' => 'ag_agencias_accounts',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  'emp_empleo_accounts' => 
  array (
    'name' => 'emp_empleo_accounts',
    'true_relationship_type' => 'one-to-many',
    'relationships' => 
    array (
      'emp_empleo_accounts' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'emp_empleo',
        'rhs_table' => 'emp_empleo',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'emp_empleo_accounts_c',
        'join_key_lhs' => 'emp_empleo_accountsaccounts_ida',
        'join_key_rhs' => 'emp_empleo_accountsemp_empleo_idb',
      ),
    ),
    'table' => 'emp_empleo_accounts_c',
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
      'emp_empleo_accountsaccounts_ida' => 
      array (
        'name' => 'emp_empleo_accountsaccounts_ida',
        'type' => 'varchar',
        'len' => 36,
      ),
      'emp_empleo_accountsemp_empleo_idb' => 
      array (
        'name' => 'emp_empleo_accountsemp_empleo_idb',
        'type' => 'varchar',
        'len' => 36,
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'emp_empleo_accountsspk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'emp_empleo_accounts_ida1',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'emp_empleo_accountsaccounts_ida',
        ),
      ),
      2 => 
      array (
        'name' => 'emp_empleo_accounts_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'emp_empleo_accountsemp_empleo_idb',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'emp_empleo',
    'rhs_table' => 'emp_empleo',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'emp_empleo_accounts_c',
    'join_key_lhs' => 'emp_empleo_accountsaccounts_ida',
    'join_key_rhs' => 'emp_empleo_accountsemp_empleo_idb',
    'readonly' => true,
    'relationship_name' => 'emp_empleo_accounts',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  'refba_referencia_bancaria_accounts' => 
  array (
    'name' => 'refba_referencia_bancaria_accounts',
    'true_relationship_type' => 'one-to-many',
    'relationships' => 
    array (
      'refba_referencia_bancaria_accounts' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'RefBa_Referencia_Bancaria',
        'rhs_table' => 'refba_referencia_bancaria',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'refba_referencia_bancaria_accounts_c',
        'join_key_lhs' => 'refba_referencia_bancaria_accountsaccounts_ida',
        'join_key_rhs' => 'refba_referencia_bancaria_accountsrefba_referencia_bancaria_idb',
      ),
    ),
    'table' => 'refba_referencia_bancaria_accounts_c',
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
      'refba_referencia_bancaria_accountsaccounts_ida' => 
      array (
        'name' => 'refba_referencia_bancaria_accountsaccounts_ida',
        'type' => 'varchar',
        'len' => 36,
      ),
      'refba_referencia_bancaria_accountsrefba_referencia_bancaria_idb' => 
      array (
        'name' => 'refba_referencia_bancaria_accountsrefba_referencia_bancaria_idb',
        'type' => 'varchar',
        'len' => 36,
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'refba_referencia_bancaria_accountsspk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'refba_referencia_bancaria_accounts_ida1',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'refba_referencia_bancaria_accountsaccounts_ida',
        ),
      ),
      2 => 
      array (
        'name' => 'refba_referencia_bancaria_accounts_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'refba_referencia_bancaria_accountsrefba_referencia_bancaria_idb',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'RefBa_Referencia_Bancaria',
    'rhs_table' => 'refba_referencia_bancaria',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'refba_referencia_bancaria_accounts_c',
    'join_key_lhs' => 'refba_referencia_bancaria_accountsaccounts_ida',
    'join_key_rhs' => 'refba_referencia_bancaria_accountsrefba_referencia_bancaria_idb',
    'readonly' => true,
    'relationship_name' => 'refba_referencia_bancaria_accounts',
    'rhs_subpanel' => 'ForAccountsRefba_referencia_bancaria_accounts',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  'rel_relaciones_accounts' => 
  array (
    'name' => 'rel_relaciones_accounts',
    'true_relationship_type' => 'one-to-many',
    'relationships' => 
    array (
      'rel_relaciones_accounts' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'Rel_Relaciones',
        'rhs_table' => 'rel_relaciones',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'rel_relaciones_accounts_c',
        'join_key_lhs' => 'rel_relaciones_accountsaccounts_ida',
        'join_key_rhs' => 'rel_relaciones_accountsrel_relaciones_idb',
      ),
    ),
    'table' => 'rel_relaciones_accounts_c',
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
      'rel_relaciones_accountsaccounts_ida' => 
      array (
        'name' => 'rel_relaciones_accountsaccounts_ida',
        'type' => 'varchar',
        'len' => 36,
      ),
      'rel_relaciones_accountsrel_relaciones_idb' => 
      array (
        'name' => 'rel_relaciones_accountsrel_relaciones_idb',
        'type' => 'varchar',
        'len' => 36,
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'rel_relaciones_accountsspk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'rel_relaciones_accounts_ida1',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'rel_relaciones_accountsaccounts_ida',
        ),
      ),
      2 => 
      array (
        'name' => 'rel_relaciones_accounts_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'rel_relaciones_accountsrel_relaciones_idb',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Rel_Relaciones',
    'rhs_table' => 'rel_relaciones',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'rel_relaciones_accounts_c',
    'join_key_lhs' => 'rel_relaciones_accountsaccounts_ida',
    'join_key_rhs' => 'rel_relaciones_accountsrel_relaciones_idb',
    'readonly' => true,
    'relationship_name' => 'rel_relaciones_accounts',
    'rhs_subpanel' => 'ForAccountsRel_relaciones_accounts_1',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  'rel_relaciones_accounts_1' => 
  array (
    'name' => 'rel_relaciones_accounts_1',
    'true_relationship_type' => 'one-to-many',
    'relationships' => 
    array (
      'rel_relaciones_accounts_1' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'Rel_Relaciones',
        'rhs_table' => 'rel_relaciones',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'rel_relaciones_accounts_1_c',
        'join_key_lhs' => 'rel_relaciones_accounts_1accounts_ida',
        'join_key_rhs' => 'rel_relaciones_accounts_1rel_relaciones_idb',
      ),
    ),
    'table' => 'rel_relaciones_accounts_1_c',
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
      'rel_relaciones_accounts_1accounts_ida' => 
      array (
        'name' => 'rel_relaciones_accounts_1accounts_ida',
        'type' => 'varchar',
        'len' => 36,
      ),
      'rel_relaciones_accounts_1rel_relaciones_idb' => 
      array (
        'name' => 'rel_relaciones_accounts_1rel_relaciones_idb',
        'type' => 'varchar',
        'len' => 36,
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'rel_relaciones_accounts_1spk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'rel_relaciones_accounts_1_ida1',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'rel_relaciones_accounts_1accounts_ida',
        ),
      ),
      2 => 
      array (
        'name' => 'rel_relaciones_accounts_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'rel_relaciones_accounts_1rel_relaciones_idb',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Rel_Relaciones',
    'rhs_table' => 'rel_relaciones',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'rel_relaciones_accounts_1_c',
    'join_key_lhs' => 'rel_relaciones_accounts_1accounts_ida',
    'join_key_rhs' => 'rel_relaciones_accounts_1rel_relaciones_idb',
    'readonly' => true,
    'relationship_name' => 'rel_relaciones_accounts_1',
    'rhs_subpanel' => 'ForAccountsRel_relaciones_accounts_1',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  'tct1_p_fideicomiso_accounts' => 
  array (
    'name' => 'tct1_p_fideicomiso_accounts',
    'true_relationship_type' => 'many-to-many',
    'relationships' => 
    array (
      'tct1_p_fideicomiso_accounts' => 
      array (
        'lhs_module' => 'TCT1_P_Fideicomiso',
        'lhs_table' => 'tct1_p_fideicomiso',
        'lhs_key' => 'id',
        'rhs_module' => 'Accounts',
        'rhs_table' => 'accounts',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'tct1_p_fideicomiso_accounts_c',
        'join_key_lhs' => 'tct1_p_fideicomiso_accountstct1_p_fideicomiso_ida',
        'join_key_rhs' => 'tct1_p_fideicomiso_accountsaccounts_idb',
      ),
    ),
    'table' => 'tct1_p_fideicomiso_accounts_c',
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
      'tct1_p_fideicomiso_accountstct1_p_fideicomiso_ida' => 
      array (
        'name' => 'tct1_p_fideicomiso_accountstct1_p_fideicomiso_ida',
        'type' => 'varchar',
        'len' => 36,
      ),
      'tct1_p_fideicomiso_accountsaccounts_idb' => 
      array (
        'name' => 'tct1_p_fideicomiso_accountsaccounts_idb',
        'type' => 'varchar',
        'len' => 36,
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'tct1_p_fideicomiso_accountsspk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'tct1_p_fideicomiso_accounts_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'tct1_p_fideicomiso_accountstct1_p_fideicomiso_ida',
          1 => 'tct1_p_fideicomiso_accountsaccounts_idb',
        ),
      ),
    ),
    'lhs_module' => 'TCT1_P_Fideicomiso',
    'lhs_table' => 'tct1_p_fideicomiso',
    'lhs_key' => 'id',
    'rhs_module' => 'Accounts',
    'rhs_table' => 'accounts',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'tct1_p_fideicomiso_accounts_c',
    'join_key_lhs' => 'tct1_p_fideicomiso_accountstct1_p_fideicomiso_ida',
    'join_key_rhs' => 'tct1_p_fideicomiso_accountsaccounts_idb',
    'readonly' => true,
    'relationship_name' => 'tct1_p_fideicomiso_accounts',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => 'default',
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  'tct2_notificaciones_accounts' => 
  array (
    'name' => 'tct2_notificaciones_accounts',
    'true_relationship_type' => 'one-to-many',
    'relationships' => 
    array (
      'tct2_notificaciones_accounts' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'TCT2_Notificaciones',
        'rhs_table' => 'tct2_notificaciones',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'tct2_notificaciones_accounts_c',
        'join_key_lhs' => 'tct2_notificaciones_accountsaccounts_ida',
        'join_key_rhs' => 'tct2_notificaciones_accountstct2_notificaciones_idb',
      ),
    ),
    'table' => 'tct2_notificaciones_accounts_c',
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
      'tct2_notificaciones_accountsaccounts_ida' => 
      array (
        'name' => 'tct2_notificaciones_accountsaccounts_ida',
        'type' => 'id',
      ),
      'tct2_notificaciones_accountstct2_notificaciones_idb' => 
      array (
        'name' => 'tct2_notificaciones_accountstct2_notificaciones_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_tct2_notificaciones_accounts_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_tct2_notificaciones_accounts_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'tct2_notificaciones_accountsaccounts_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_tct2_notificaciones_accounts_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'tct2_notificaciones_accountstct2_notificaciones_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'tct2_notificaciones_accounts_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'tct2_notificaciones_accountstct2_notificaciones_idb',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'TCT2_Notificaciones',
    'rhs_table' => 'tct2_notificaciones',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'tct2_notificaciones_accounts_c',
    'join_key_lhs' => 'tct2_notificaciones_accountsaccounts_ida',
    'join_key_rhs' => 'tct2_notificaciones_accountstct2_notificaciones_idb',
    'readonly' => true,
    'relationship_name' => 'tct2_notificaciones_accounts',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  'users_accounts_1' => 
  array (
    'name' => 'users_accounts_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'users_accounts_1' => 
      array (
        'lhs_module' => 'Users',
        'lhs_table' => 'users',
        'lhs_key' => 'id',
        'rhs_module' => 'Accounts',
        'rhs_table' => 'accounts',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'users_accounts_1_c',
        'join_key_lhs' => 'users_accounts_1users_ida',
        'join_key_rhs' => 'users_accounts_1accounts_idb',
      ),
    ),
    'table' => 'users_accounts_1_c',
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
      'users_accounts_1users_ida' => 
      array (
        'name' => 'users_accounts_1users_ida',
        'type' => 'id',
      ),
      'users_accounts_1accounts_idb' => 
      array (
        'name' => 'users_accounts_1accounts_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_users_accounts_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_users_accounts_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'users_accounts_1users_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_users_accounts_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'users_accounts_1accounts_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'users_accounts_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'users_accounts_1accounts_idb',
        ),
      ),
    ),
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Accounts',
    'rhs_table' => 'accounts',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'users_accounts_1_c',
    'join_key_lhs' => 'users_accounts_1users_ida',
    'join_key_rhs' => 'users_accounts_1accounts_idb',
    'readonly' => true,
    'relationship_name' => 'users_accounts_1',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'accounts_c5515_uni_chattigo_1' => 
  array (
    'name' => 'accounts_c5515_uni_chattigo_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'accounts_c5515_uni_chattigo_1' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'C5515_uni_chattigo',
        'rhs_table' => 'c5515_uni_chattigo',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'accounts_c5515_uni_chattigo_1_c',
        'join_key_lhs' => 'accounts_c5515_uni_chattigo_1accounts_ida',
        'join_key_rhs' => 'accounts_c5515_uni_chattigo_1c5515_uni_chattigo_idb',
      ),
    ),
    'table' => 'accounts_c5515_uni_chattigo_1_c',
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
      'accounts_c5515_uni_chattigo_1accounts_ida' => 
      array (
        'name' => 'accounts_c5515_uni_chattigo_1accounts_ida',
        'type' => 'id',
      ),
      'accounts_c5515_uni_chattigo_1c5515_uni_chattigo_idb' => 
      array (
        'name' => 'accounts_c5515_uni_chattigo_1c5515_uni_chattigo_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_accounts_c5515_uni_chattigo_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_accounts_c5515_uni_chattigo_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'accounts_c5515_uni_chattigo_1accounts_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_accounts_c5515_uni_chattigo_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'accounts_c5515_uni_chattigo_1c5515_uni_chattigo_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'accounts_c5515_uni_chattigo_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'accounts_c5515_uni_chattigo_1c5515_uni_chattigo_idb',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'C5515_uni_chattigo',
    'rhs_table' => 'c5515_uni_chattigo',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'accounts_c5515_uni_chattigo_1_c',
    'join_key_lhs' => 'accounts_c5515_uni_chattigo_1accounts_ida',
    'join_key_rhs' => 'accounts_c5515_uni_chattigo_1c5515_uni_chattigo_idb',
    'readonly' => true,
    'relationship_name' => 'accounts_c5515_uni_chattigo_1',
    'rhs_subpanel' => 'ForAccountsAccounts_c5515_uni_chattigo_1',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'accounts_tct3_noviable_1' => 
  array (
    'name' => 'accounts_tct3_noviable_1',
    'true_relationship_type' => 'one-to-one',
    'from_studio' => true,
    'relationships' => 
    array (
      'accounts_tct3_noviable_1' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'tct3_noviable',
        'rhs_table' => 'tct3_noviable',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'accounts_tct3_noviable_1_c',
        'join_key_lhs' => 'accounts_tct3_noviable_1accounts_ida',
        'join_key_rhs' => 'accounts_tct3_noviable_1tct3_noviable_idb',
      ),
    ),
    'table' => 'accounts_tct3_noviable_1_c',
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
      'accounts_tct3_noviable_1accounts_ida' => 
      array (
        'name' => 'accounts_tct3_noviable_1accounts_ida',
        'type' => 'id',
      ),
      'accounts_tct3_noviable_1tct3_noviable_idb' => 
      array (
        'name' => 'accounts_tct3_noviable_1tct3_noviable_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_accounts_tct3_noviable_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_accounts_tct3_noviable_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'accounts_tct3_noviable_1accounts_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_accounts_tct3_noviable_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'accounts_tct3_noviable_1tct3_noviable_idb',
          1 => 'deleted',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'tct3_noviable',
    'rhs_table' => 'tct3_noviable',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-one',
    'join_table' => 'accounts_tct3_noviable_1_c',
    'join_key_lhs' => 'accounts_tct3_noviable_1accounts_ida',
    'join_key_rhs' => 'accounts_tct3_noviable_1tct3_noviable_idb',
    'readonly' => true,
    'relationship_name' => 'accounts_tct3_noviable_1',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'accounts_tct_pld_1' => 
  array (
    'name' => 'accounts_tct_pld_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'accounts_tct_pld_1' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'tct_PLD',
        'rhs_table' => 'tct_pld',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'accounts_tct_pld_1_c',
        'join_key_lhs' => 'accounts_tct_pld_1accounts_ida',
        'join_key_rhs' => 'accounts_tct_pld_1tct_pld_idb',
      ),
    ),
    'table' => 'accounts_tct_pld_1_c',
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
      'accounts_tct_pld_1accounts_ida' => 
      array (
        'name' => 'accounts_tct_pld_1accounts_ida',
        'type' => 'id',
      ),
      'accounts_tct_pld_1tct_pld_idb' => 
      array (
        'name' => 'accounts_tct_pld_1tct_pld_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_accounts_tct_pld_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_accounts_tct_pld_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'accounts_tct_pld_1accounts_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_accounts_tct_pld_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'accounts_tct_pld_1tct_pld_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'accounts_tct_pld_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'accounts_tct_pld_1tct_pld_idb',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'tct_PLD',
    'rhs_table' => 'tct_pld',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'accounts_tct_pld_1_c',
    'join_key_lhs' => 'accounts_tct_pld_1accounts_ida',
    'join_key_rhs' => 'accounts_tct_pld_1tct_pld_idb',
    'readonly' => true,
    'relationship_name' => 'accounts_tct_pld_1',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'accounts_uni_productos_1' => 
  array (
    'name' => 'accounts_uni_productos_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'accounts_uni_productos_1' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'uni_Productos',
        'rhs_table' => 'uni_productos',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'accounts_uni_productos_1_c',
        'join_key_lhs' => 'accounts_uni_productos_1accounts_ida',
        'join_key_rhs' => 'accounts_uni_productos_1uni_productos_idb',
      ),
    ),
    'table' => 'accounts_uni_productos_1_c',
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
      'accounts_uni_productos_1accounts_ida' => 
      array (
        'name' => 'accounts_uni_productos_1accounts_ida',
        'type' => 'id',
      ),
      'accounts_uni_productos_1uni_productos_idb' => 
      array (
        'name' => 'accounts_uni_productos_1uni_productos_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_accounts_uni_productos_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_accounts_uni_productos_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'accounts_uni_productos_1accounts_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_accounts_uni_productos_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'accounts_uni_productos_1uni_productos_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'accounts_uni_productos_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'accounts_uni_productos_1uni_productos_idb',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'uni_Productos',
    'rhs_table' => 'uni_productos',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'accounts_uni_productos_1_c',
    'join_key_lhs' => 'accounts_uni_productos_1accounts_ida',
    'join_key_rhs' => 'accounts_uni_productos_1uni_productos_idb',
    'readonly' => true,
    'relationship_name' => 'accounts_uni_productos_1',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'anlzt_analizate_accounts' => 
  array (
    'name' => 'anlzt_analizate_accounts',
    'true_relationship_type' => 'one-to-many',
    'relationships' => 
    array (
      'anlzt_analizate_accounts' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'ANLZT_analizate',
        'rhs_table' => 'anlzt_analizate',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'anlzt_analizate_accounts_c',
        'join_key_lhs' => 'anlzt_analizate_accountsaccounts_ida',
        'join_key_rhs' => 'anlzt_analizate_accountsanlzt_analizate_idb',
      ),
    ),
    'table' => 'anlzt_analizate_accounts_c',
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
      'anlzt_analizate_accountsaccounts_ida' => 
      array (
        'name' => 'anlzt_analizate_accountsaccounts_ida',
        'type' => 'id',
      ),
      'anlzt_analizate_accountsanlzt_analizate_idb' => 
      array (
        'name' => 'anlzt_analizate_accountsanlzt_analizate_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_anlzt_analizate_accounts_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_anlzt_analizate_accounts_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'anlzt_analizate_accountsaccounts_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_anlzt_analizate_accounts_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'anlzt_analizate_accountsanlzt_analizate_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'anlzt_analizate_accounts_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'anlzt_analizate_accountsanlzt_analizate_idb',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'ANLZT_analizate',
    'rhs_table' => 'anlzt_analizate',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'anlzt_analizate_accounts_c',
    'join_key_lhs' => 'anlzt_analizate_accountsaccounts_ida',
    'join_key_rhs' => 'anlzt_analizate_accountsanlzt_analizate_idb',
    'readonly' => true,
    'relationship_name' => 'anlzt_analizate_accounts',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  'bc_survey_accounts' => 
  array (
    'name' => 'bc_survey_accounts',
    'true_relationship_type' => 'many-to-many',
    'relationships' => 
    array (
      'bc_survey_accounts' => 
      array (
        'lhs_module' => 'bc_survey',
        'lhs_table' => 'bc_survey',
        'lhs_key' => 'id',
        'rhs_module' => 'Accounts',
        'rhs_table' => 'accounts',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'bc_survey_accounts_c',
        'join_key_lhs' => 'bc_survey_accountsbc_survey_ida',
        'join_key_rhs' => 'bc_survey_accountsaccounts_idb',
      ),
    ),
    'table' => 'bc_survey_accounts_c',
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
      'bc_survey_accountsbc_survey_ida' => 
      array (
        'name' => 'bc_survey_accountsbc_survey_ida',
        'type' => 'varchar',
        'len' => 36,
      ),
      'bc_survey_accountsaccounts_idb' => 
      array (
        'name' => 'bc_survey_accountsaccounts_idb',
        'type' => 'varchar',
        'len' => 36,
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'bc_survey_accountsspk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'bc_survey_accounts_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'bc_survey_accountsbc_survey_ida',
          1 => 'bc_survey_accountsaccounts_idb',
        ),
      ),
    ),
    'lhs_module' => 'bc_survey',
    'lhs_table' => 'bc_survey',
    'lhs_key' => 'id',
    'rhs_module' => 'Accounts',
    'rhs_table' => 'accounts',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'bc_survey_accounts_c',
    'join_key_lhs' => 'bc_survey_accountsbc_survey_ida',
    'join_key_rhs' => 'bc_survey_accountsaccounts_idb',
    'readonly' => true,
    'relationship_name' => 'bc_survey_accounts',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  'cta_cuentas_bancarias_accounts' => 
  array (
    'name' => 'cta_cuentas_bancarias_accounts',
    'true_relationship_type' => 'one-to-many',
    'relationships' => 
    array (
      'cta_cuentas_bancarias_accounts' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'cta_cuentas_bancarias',
        'rhs_table' => 'cta_cuentas_bancarias',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'cta_cuentas_bancarias_accounts_c',
        'join_key_lhs' => 'cta_cuentas_bancarias_accountsaccounts_ida',
        'join_key_rhs' => 'cta_cuentas_bancarias_accountscta_cuentas_bancarias_idb',
      ),
    ),
    'table' => 'cta_cuentas_bancarias_accounts_c',
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
      'cta_cuentas_bancarias_accountsaccounts_ida' => 
      array (
        'name' => 'cta_cuentas_bancarias_accountsaccounts_ida',
        'type' => 'id',
      ),
      'cta_cuentas_bancarias_accountscta_cuentas_bancarias_idb' => 
      array (
        'name' => 'cta_cuentas_bancarias_accountscta_cuentas_bancarias_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_cta_cuentas_bancarias_accounts_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_cta_cuentas_bancarias_accounts_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'cta_cuentas_bancarias_accountsaccounts_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_cta_cuentas_bancarias_accounts_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'cta_cuentas_bancarias_accountscta_cuentas_bancarias_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'cta_cuentas_bancarias_accounts_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'cta_cuentas_bancarias_accountscta_cuentas_bancarias_idb',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'cta_cuentas_bancarias',
    'rhs_table' => 'cta_cuentas_bancarias',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'cta_cuentas_bancarias_accounts_c',
    'join_key_lhs' => 'cta_cuentas_bancarias_accountsaccounts_ida',
    'join_key_rhs' => 'cta_cuentas_bancarias_accountscta_cuentas_bancarias_idb',
    'readonly' => true,
    'relationship_name' => 'cta_cuentas_bancarias_accounts',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'from_studio' => false,
  ),
  'accounts_modified_user' => 
  array (
    'name' => 'accounts_modified_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Accounts',
    'rhs_table' => 'accounts',
    'rhs_key' => 'modified_user_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'accounts_modified_user',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'accounts_created_by' => 
  array (
    'name' => 'accounts_created_by',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Accounts',
    'rhs_table' => 'accounts',
    'rhs_key' => 'created_by',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'accounts_created_by',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'account_activities' => 
  array (
    'name' => 'account_activities',
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
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
    'relationship_role_column_value' => 'Accounts',
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
    'relationship_name' => 'account_activities',
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'member_accounts' => 
  array (
    'name' => 'member_accounts',
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Accounts',
    'rhs_table' => 'accounts',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'member_accounts',
    'rhs_subpanel' => 'ForAccountsMembers',
    'lhs_subpanel' => 'ForAccountsMembers',
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'account_cases' => 
  array (
    'name' => 'account_cases',
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Cases',
    'rhs_table' => 'cases',
    'rhs_key' => 'account_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'account_cases',
    'rhs_subpanel' => 'ForAccounts',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'account_tasks' => 
  array (
    'name' => 'account_tasks',
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Tasks',
    'rhs_table' => 'tasks',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Accounts',
    'readonly' => true,
    'relationship_name' => 'account_tasks',
    'rhs_subpanel' => 'ForAccountsTasks',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'account_notes' => 
  array (
    'name' => 'account_notes',
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Notes',
    'rhs_table' => 'notes',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Accounts',
    'readonly' => true,
    'relationship_name' => 'account_notes',
    'rhs_subpanel' => 'ForAccountsNotes',
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
  'account_calls' => 
  array (
    'name' => 'account_calls',
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Calls',
    'rhs_table' => 'calls',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Accounts',
    'readonly' => true,
    'relationship_name' => 'account_calls',
    'rhs_subpanel' => 'ForAccountsCalls',
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
  'accounts_assigned_user' => 
  array (
    'name' => 'accounts_assigned_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Accounts',
    'rhs_table' => 'accounts',
    'rhs_key' => 'assigned_user_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'accounts_assigned_user',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'accounts_following' => 
  array (
    'name' => 'accounts_following',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Accounts',
    'rhs_table' => 'accounts',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'subscriptions',
    'join_key_lhs' => 'created_by',
    'join_key_rhs' => 'parent_id',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Accounts',
    'user_field' => 'created_by',
    'readonly' => true,
    'relationship_name' => 'accounts_following',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'accounts_favorite' => 
  array (
    'name' => 'accounts_favorite',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'Accounts',
    'rhs_table' => 'accounts',
    'rhs_key' => 'id',
    'relationship_type' => 'many-to-many',
    'join_table' => 'sugarfavorites',
    'join_key_lhs' => 'modified_user_id',
    'join_key_rhs' => 'record_id',
    'relationship_role_column' => 'module',
    'relationship_role_column_value' => 'Accounts',
    'user_field' => 'created_by',
    'readonly' => true,
    'relationship_name' => 'accounts_favorite',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'bc_survey_submission_accounts' => 
  array (
    'name' => 'bc_survey_submission_accounts',
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'bc_survey_submission',
    'rhs_table' => 'bc_survey_submission',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Accounts',
    'readonly' => true,
    'relationship_name' => 'bc_survey_submission_accounts',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'bc_survey_submission_accounts_target' => 
  array (
    'name' => 'bc_survey_submission_accounts_target',
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'bc_survey_submission',
    'rhs_table' => 'bc_survey_submission',
    'rhs_key' => 'target_parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'target_parent_type',
    'relationship_role_column_value' => 'Accounts',
    'readonly' => true,
    'relationship_name' => 'bc_survey_submission_accounts_target',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'campaign_accounts' => 
  array (
    'name' => 'campaign_accounts',
    'lhs_module' => 'Campaigns',
    'lhs_table' => 'campaigns',
    'lhs_key' => 'id',
    'rhs_module' => 'Accounts',
    'rhs_table' => 'accounts',
    'rhs_key' => 'campaign_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'campaign_accounts',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'products_accounts' => 
  array (
    'name' => 'products_accounts',
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Products',
    'rhs_table' => 'products',
    'rhs_key' => 'account_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'products_accounts',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'account_contracts' => 
  array (
    'name' => 'account_contracts',
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Contracts',
    'rhs_table' => 'contracts',
    'rhs_key' => 'account_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'account_contracts',
    'rhs_subpanel' => 'ForAccounts',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'revenuelineitems_accounts' => 
  array (
    'name' => 'revenuelineitems_accounts',
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'RevenueLineItems',
    'rhs_table' => 'revenue_line_items',
    'rhs_key' => 'account_id',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'relationship_name' => 'revenuelineitems_accounts',
    'rhs_subpanel' => 'ForAccounts',
    'lhs_subpanel' => NULL,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
  ),
  'accounts_ref_venta_cruzada_1' => 
  array (
    'name' => 'accounts_ref_venta_cruzada_1',
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => 
    array (
      'accounts_ref_venta_cruzada_1' => 
      array (
        'lhs_module' => 'Accounts',
        'lhs_table' => 'accounts',
        'lhs_key' => 'id',
        'rhs_module' => 'Ref_Venta_Cruzada',
        'rhs_table' => 'ref_venta_cruzada',
        'rhs_key' => 'id',
        'relationship_type' => 'many-to-many',
        'join_table' => 'accounts_ref_venta_cruzada_1_c',
        'join_key_lhs' => 'accounts_ref_venta_cruzada_1accounts_ida',
        'join_key_rhs' => 'accounts_ref_venta_cruzada_1ref_venta_cruzada_idb',
      ),
    ),
    'table' => 'accounts_ref_venta_cruzada_1_c',
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
      'accounts_ref_venta_cruzada_1accounts_ida' => 
      array (
        'name' => 'accounts_ref_venta_cruzada_1accounts_ida',
        'type' => 'id',
      ),
      'accounts_ref_venta_cruzada_1ref_venta_cruzada_idb' => 
      array (
        'name' => 'accounts_ref_venta_cruzada_1ref_venta_cruzada_idb',
        'type' => 'id',
      ),
    ),
    'indices' => 
    array (
      0 => 
      array (
        'name' => 'idx_accounts_ref_venta_cruzada_1_pk',
        'type' => 'primary',
        'fields' => 
        array (
          0 => 'id',
        ),
      ),
      1 => 
      array (
        'name' => 'idx_accounts_ref_venta_cruzada_1_ida1_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'accounts_ref_venta_cruzada_1accounts_ida',
          1 => 'deleted',
        ),
      ),
      2 => 
      array (
        'name' => 'idx_accounts_ref_venta_cruzada_1_idb2_deleted',
        'type' => 'index',
        'fields' => 
        array (
          0 => 'accounts_ref_venta_cruzada_1ref_venta_cruzada_idb',
          1 => 'deleted',
        ),
      ),
      3 => 
      array (
        'name' => 'accounts_ref_venta_cruzada_1_alt',
        'type' => 'alternate_key',
        'fields' => 
        array (
          0 => 'accounts_ref_venta_cruzada_1ref_venta_cruzada_idb',
        ),
      ),
    ),
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'Ref_Venta_Cruzada',
    'rhs_table' => 'ref_venta_cruzada',
    'rhs_key' => 'id',
    'relationship_type' => 'one-to-many',
    'join_table' => 'accounts_ref_venta_cruzada_1_c',
    'join_key_lhs' => 'accounts_ref_venta_cruzada_1accounts_ida',
    'join_key_rhs' => 'accounts_ref_venta_cruzada_1ref_venta_cruzada_idb',
    'readonly' => true,
    'relationship_name' => 'accounts_ref_venta_cruzada_1',
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'is_custom' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'accounts_ref_venta_cruzada_2' => 
  array (
    'rhs_label' => 'Referencias Vtas Cruzadas',
    'lhs_label' => 'Cuentas',
    'rhs_subpanel' => 'default',
    'lhs_module' => 'Accounts',
    'rhs_module' => 'Ref_Venta_Cruzada',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => true,
    'relationship_name' => 'accounts_ref_venta_cruzada_2',
  ),
);