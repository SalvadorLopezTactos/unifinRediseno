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

$dictionary['Contact'] = array(
    'table' => 'contacts',
    'audited' => true,
    'activity_enabled' => true,
    'unified_search' => true,
    'full_text_search' => true,
    'unified_search_default_enabled' => true,
    'duplicate_merge' => true,
    'fields' => array(
        'email_and_name1' => array(
            'name' => 'email_and_name1',
            'vname' => 'LBL_NAME',
            'type' => 'varchar',
            'source' => 'non-db',
            'len' => '510',
            'importable' => 'false',
            'massupdate' => false,
            'studio' => array('formula' => false),
        ),
        'lead_source' => array(
            'name' => 'lead_source',
            'vname' => 'LBL_LEAD_SOURCE',
            'type' => 'enum',
            'options' => 'lead_source_dom',
            'len' => '255',
            'comment' => 'How did the contact come about',
            'merge_filter' => 'enabled',
        ),
        'account_name' => array(
            'name' => 'account_name',
            'rname' => 'name',
            'id_name' => 'account_id',
            'vname' => 'LBL_ACCOUNT_NAME',
            'join_name' => 'accounts',
            'type' => 'relate',
            'link' => 'accounts',
            'table' => 'accounts',
            'isnull' => 'true',
            'module' => 'Accounts',
            'dbType' => 'varchar',
            'len' => '255',
            'source' => 'non-db',
            'unified_search' => true,
            'populate_list' => array(
                'billing_address_street' => 'primary_address_street',
                'billing_address_city' => 'primary_address_city',
                'billing_address_state' => 'primary_address_state',
                'billing_address_postalcode' => 'primary_address_postalcode',
                'billing_address_country' => 'primary_address_country',
                'phone_office' => 'phone_work',
            ),
            'populate_confirm_label' => 'TPL_OVERWRITE_POPULATED_DATA_CONFIRM_WITH_MODULE_SINGULAR',
            'importable' => 'true',
            'exportable'=>true,
            'export_link_type' => 'one',//relationship type to be used during export
        ),
        'account_id' => array(
            'name' => 'account_id',
            'rname' => 'id',
            'id_name' => 'account_id',
            'vname' => 'LBL_ACCOUNT_ID',
            'type' => 'relate',
            'table' => 'accounts',
            'isnull' => 'true',
            'module' => 'Accounts',
            'dbType' => 'id',
            'reportable' => false,
            'source' => 'non-db',
            'massupdate' => false,
            'duplicate_merge' => 'disabled',
            'hideacl' => true,
            'link' => 'accounts',
        ),
        //d&b principal id, a unique id assigned to a contact by D&B API
        //this contact is used for dupe check
        'dnb_principal_id' =>
          array (
            'name' => 'dnb_principal_id',
            'vname' => 'LBL_DNB_PRINCIPAL_ID',
            'type' => 'varchar',
            'len' => 30,
            'comment' => 'Unique Id For D&B Contact',
        ),
        // Deprecated, use rname_link instead
        'opportunity_role_fields' => array(
            'name' => 'opportunity_role_fields',
            'rname' => 'id',
            'relationship_fields' => array(
                'id' => 'opportunity_role_id',
                'contact_role' => 'opportunity_role'
            ),
            'vname' => 'LBL_ACCOUNT_NAME',
            'type' => 'relate',
            'link' => 'opportunities',
            'link_type' => 'relationship_info',
            'join_link_name' => 'opportunities_contacts',
            'source' => 'non-db',
            'importable' => 'false',
            'duplicate_merge' => 'disabled',
            'studio' => false,
        ),
        // Deprecated, use rname_link instead
        'opportunity_role_id' => array(
            'name' => 'opportunity_role_id',
            'type' => 'varchar',
            'source' => 'non-db',
            'vname' => 'LBL_OPPORTUNITY_ROLE_ID',
            'studio' => array('listview' => false),
        ),
        'opportunity_role' => array(
            'name' => 'opportunity_role',
            'type' => 'enum',
            'source' => 'non-db',
            'vname' => 'LBL_OPPORTUNITY_ROLE',
            'options' => 'opportunity_relationship_type_dom',
            'link' => 'opportunities',
            'rname_link' => 'contact_role',
            'massupdate' => false
        ),
        'reports_to_id' => array(
            'name' => 'reports_to_id',
            'vname' => 'LBL_REPORTS_TO_ID',
            'type' => 'id',
            'required' => false,
            'reportable' => false,
            'comment' => 'The contact this contact reports to'
        ),
        'report_to_name' => array(
            'name' => 'report_to_name',
            'rname' => 'name',
            'id_name' => 'reports_to_id',
            'vname' => 'LBL_REPORTS_TO',
            'type' => 'relate',
            'link' => 'reports_to_link',
            'table' => 'contacts',
            'isnull' => 'true',
            'module' => 'Contacts',
            'dbType' => 'varchar',
            'len' => 'id',
            'reportable' => false,
            'source' => 'non-db',
            'populate_list' => array(
                'account_id' => 'account_id',
                'account_name' => 'account_name',
            ),
        ),
        'birthdate' => array(
            'name' => 'birthdate',
            'vname' => 'LBL_BIRTHDATE',
            'massupdate' => false,
            'type' => 'date',
            'comment' => 'The birthdate of the contact',
            'audited' => true,
            'pii' => true,
        ),
        'portal_name' => array(
            'name' => 'portal_name',
            'vname' => 'LBL_PORTAL_NAME',
            'type' => 'username',
            'dbType' => 'varchar',
            'len' => '255',
            'group' => 'portal',
            'group_label' => 'LBL_PORTAL',
            'comment' => 'Name as it appears in the portal',
            'studio' => array(
                'portalrecordview' => false,
                'portallistview' => false,
            ),
            'duplicate_on_record_copy' => 'no',
            'full_text_search' => array(
                'enabled' => true,
                'searchable' => true,
                'boost' => 1.93,
                'type' => 'exact',
            ),
        ),
        'portal_active' => array(
            'name' => 'portal_active',
            'vname' => 'LBL_PORTAL_ACTIVE',
            'type' => 'bool',
            'default' => '0',
            'group' => 'portal',
            'comment' => 'Indicator whether this contact is a portal user',
            'duplicate_on_record_copy' => 'no',
        ),
        'portal_password' => array(
            'name' => 'portal_password',
            'vname' => 'LBL_USER_PASSWORD',
            'type' => 'password',
            'dbType' => 'varchar',
            'len' => '255',
            'group' => 'portal',
            'reportable' => false,
            'studio' => array(
                'listview' => false,
                'portalrecordview' => false,
                'portallistview' => false,
            ),
            'duplicate_on_record_copy' => 'no',
        ),
        'portal_password1' => array(
            'name' => 'portal_password1',
            'vname' => 'LBL_USER_PASSWORD',
            'type' => 'password',
            'source' => 'non-db',
            'len' => '255',
            'group' => 'portal',
            'reportable' => false,
            'importable' => 'false',
            'studio' => array(
                'listview' => false,
                'portalrecordview' => false,
                'portallistview' => false,
            ),
        ),
        'portal_app' => array(
            'name' => 'portal_app',
            'vname' => 'LBL_PORTAL_APP',
            'type' => 'varchar',
            'group' => 'portal',
            'len' => '255',
            'comment' => 'Reference to the portal',
            'duplicate_on_record_copy' => 'no',
        ),
        'portal_user_company_name' => [
            'name' => 'portal_user_company_name',
            'vname' => 'LBL_PORTAL_USER_COMPANY_NAME',
            'type' => 'varchar',
            'len' => '255',
            'group' => 'portal',
            'comment' => 'User company name in the portal',
            'studio' => [
                'portalrecordview' => false,
                'portallistview' => false,
            ],
            'duplicate_on_record_copy' => 'no',
        ],
        'preferred_language' => array(
            'name' => 'preferred_language',
            'type' => 'enum',
            'vname' => 'LBL_PREFERRED_LANGUAGE',
            'options' => 'available_language_dom',
            'popupHelp' => 'LBL_LANG_PREF_TOOLTIP',
        ),
        'cookie_consent' => [
            'name' => 'cookie_consent',
            'vname' => 'LBL_COOKIE_CONSENT',
            'type' => 'bool',
            'default' => '0',
            'audited' => true,
            'comment' => 'Indicator whether this portal user accepts cookies',
            'duplicate_on_record_copy' => 'no',
        ],
        'cookie_consent_received_on' => [
            'name' => 'cookie_consent_received_on',
            'vname' => 'LBL_COOKIE_CONSENT_RECEIVED_ON',
            'type' => 'datetime',
            'audited' => true,
            'enable_range_search' => true,
            'options' => 'date_range_search_dom',
            'comment' => 'Date cookie consent received on',
            'duplicate_on_record_copy' => 'no',
        ],
        'business_center_name' => array(
            'name' => 'business_center_name',
            'rname' => 'name',
            'id_name' => 'business_center_id',
            'vname' => 'LBL_BUSINESS_CENTER_NAME',
            'type' => 'relate',
            'link' => 'business_centers',
            'table' => 'business_centers',
            'join_name' => 'business_centers',
            'isnull' => 'true',
            'module' => 'BusinessCenters',
            'dbType' => 'varchar',
            'len' => 255,
            'source' => 'non-db',
            'unified_search' => true,
            'comment' => 'The name of the business center represented by the business_center_id field',
            'required' => false,
        ),
        'business_center_id' => array(
            'name' => 'business_center_id',
            'type' => 'relate',
            'dbType' => 'id',
            'rname' => 'id',
            'module' => 'BusinessCenters',
            'id_name' => 'business_center_id',
            'reportable' => false,
            'vname' => 'LBL_BUSINESS_CENTER_ID',
            'audited' => true,
            'massupdate' => false,
            'comment' => 'The business center to which the case is associated',
        ),
        'business_centers' => array(
            'name' => 'business_centers',
            'type' => 'link',
            'relationship' => 'business_center_contacts',
            'link_type' => 'one',
            'side' => 'right',
            'source' => 'non-db',
            'vname' => 'LBL_BUSINESS_CENTER',
        ),
        'purchases' => [
            'name' => 'purchases',
            'type' => 'link',
            'relationship' => 'contacts_purchases',
            'source' => 'non-db',
            'vname' => 'LBL_PURCHASES_SUBPANEL_TITLE',
        ],
        'accounts' => array(
            'name' => 'accounts',
            'type' => 'link',
            'relationship' => 'accounts_contacts',
            'link_type' => 'one',
            'source' => 'non-db',
            'vname' => 'LBL_ACCOUNT',
            'duplicate_merge' => 'disabled',
            'primary_only' => true,
        ),
        'reports_to_link' => array(
            'name' => 'reports_to_link',
            'type' => 'link',
            'relationship' => 'contact_direct_reports',
            'link_type' => 'one',
            'side' => 'right',
            'source' => 'non-db',
            'vname' => 'LBL_REPORTS_TO',
        ),
        'opportunities' => array(
            'name' => 'opportunities',
            'type' => 'link',
            'relationship' => 'opportunities_contacts',
            'source' => 'non-db',
            'module' => 'Opportunities',
            'bean_name' => 'Opportunity',
            'vname' => 'LBL_OPPORTUNITIES',
            'populate_list' => array(
                'account_id' => 'account_id',
                'account_name' => 'account_name',
            )
        ),
        'bugs' => array(
            'name' => 'bugs',
            'type' => 'link',
            'relationship' => 'contacts_bugs',
            'source' => 'non-db',
            'vname' => 'LBL_BUGS',
        ),
        'calls' => array(
            'name' => 'calls',
            'type' => 'link',
            'relationship' => 'calls_contacts',
            'source' => 'non-db',
            'vname' => 'LBL_CALLS',
        ),
        'cases' => array(
            'name' => 'cases',
            'type' => 'link',
            'relationship' => 'contacts_cases',
            'source' => 'non-db',
            'vname' => 'LBL_CASES',
            'populate_list' => array(
                'account_id',
                'account_name'
            )
        ),
        'case_contact' => [
            'name' => 'case_contact',
            'type' => 'link',
            'relationship' => 'contact_cases',
            'source' => 'non-db',
            'side' => 'right',
            'vname' => 'LBL_CONTACT',
            'module' => 'Cases',
            'bean_name' => 'aCase',
            'id_name' => 'primary_contact_id',
            'link_type' => 'one',
            'populate_list' => [
                'account_id',
                'account_name',
            ],
        ],
        'dataprivacy' => array(
            'name' => 'dataprivacy',
            'type' => 'link',
            'relationship' => 'contacts_dataprivacy',
            'source' => 'non-db',
            'vname' => 'LBL_DATAPRIVACY',
        ),
        'dp_business_purpose' => array (
            'name' => 'dp_business_purpose',
            'vname' => 'LBL_DATAPRIVACY_BUSINESS_PURPOSE',
            'type' => 'multienum',
            'isMultiSelect' => true,
            'audited' => true,
            'options' => 'dataprivacy_business_purpose_dom',
            'default' => '',
            'len' => 255,
            'comment' => 'Business purposes consented for',
        ),
        'dp_consent_last_updated' => array(
            'name' => 'dp_consent_last_updated',
            'vname' => 'LBL_DATAPRIVACY_CONSENT_LAST_UPDATED',
            'type' => 'date',
            'display_default' => 'now',
            'audited' => true,
            'enable_range_search' => true,
            'options' => 'date_range_search_dom',
            'comment' => 'Date consent last updated',
        ),
        'direct_reports' => array(
            'name' => 'direct_reports',
            'type' => 'link',
            'relationship' => 'contact_direct_reports',
            'source' => 'non-db',
            'vname' => 'LBL_DIRECT_REPORTS',
        ),
        'emails' => array(
            'name' => 'emails',
            'type' => 'link',
            'relationship' => 'emails_contacts_rel',
            'source' => 'non-db',
            'vname' => 'LBL_EMAILS',
        ),
        'archived_emails' => array(
            'name' => 'archived_emails',
            'type' => 'link',
            'link_class' => 'ArchivedEmailsLink',
            'source' => 'non-db',
            'vname' => 'LBL_EMAILS',
            'module' => 'Emails',
            'link_type' => 'many',
            'relationship' => '',
            'readonly' => true,
        ),
        'documents' => array(
            'name' => 'documents',
            'type' => 'link',
            'relationship' => 'documents_contacts',
            'source' => 'non-db',
            'vname' => 'LBL_DOCUMENTS_SUBPANEL_TITLE',
        ),
        'leads' => array(
            'name' => 'leads',
            'type' => 'link',
            'relationship' => 'contact_leads',
            'source' => 'non-db',
            'vname' => 'LBL_LEADS',
            'populate_list' => array(
                'first_name' => 'first_name',
                'last_name' => 'last_name',
                'account_name' => 'account_name',
                'phone_work' => 'phone_work',
                'id' => 'contact_id',
                'account_id' => 'account_id',
            ),
        ),
        'products' => array(
            'name' => 'products',
            'type' => 'link',
            'rname' => array('first_name', 'last_name'),
            'relationship' => 'contact_products',
            'source' => 'non-db',
            'vname' => 'LBL_PRODUCTS_TITLE',
            'populate_list' => array(
                'account_id',
                'account_name'
            )
        ),
        'contracts' => array(
            'name' => 'contracts',
            'type' => 'link',
            'vname' => 'LBL_CONTRACTS',
            'relationship' => 'contracts_contacts',
            'source' => 'non-db',
        ),
        'meetings' => array(
            'name' => 'meetings',
            'type' => 'link',
            'relationship' => 'meetings_contacts',
            'source' => 'non-db',
            'vname' => 'LBL_MEETINGS',
        ),
        'notes' => array(
            'name' => 'notes',
            'type' => 'link',
            'relationship' => 'contact_notes',
            'source' => 'non-db',
            'vname' => 'LBL_NOTES',
        ),
        'messages' => [
            'name' => 'messages',
            'type' => 'link',
            'relationship' => 'contact_messages',
            'source' => 'non-db',
            'vname' => 'LBL_MESSAGES',
        ],
        'project' => array(
            'name' => 'project',
            'type' => 'link',
            'relationship' => 'projects_contacts',
            'source' => 'non-db',
            'vname' => 'LBL_PROJECTS',
        ),
        'project_resource' => array(
            'name' => 'project_resource',
            'type' => 'link',
            'relationship' => 'projects_contacts_resources',
            'source' => 'non-db',
            'vname' => 'LBL_PROJECTS_RESOURCES',
        ),
        'quotes' => array(
            'name' => 'quotes',
            'type' => 'link',
            'relationship' => 'quotes_contacts_shipto',
            'source' => 'non-db',
            'ignore_role' => 'true',
            'module' => 'Quotes',
            'bean_name' => 'Quote',
            'vname' => 'LBL_QUOTES_SHIP_TO',
        ),
        'billing_quotes' => array(
            'name' => 'billing_quotes',
            'type' => 'link',
            'relationship' => 'quotes_contacts_billto',
            'source' => 'non-db',
            'ignore_role' => 'true',
            'module' => 'Quotes',
            'bean_name' => 'Quote',
            'vname' => 'LBL_QUOTES_BILL_TO',
        ),
        'tasks' => array(
            'name' => 'tasks',
            'type' => 'link',
            'relationship' => 'contact_tasks',
            'source' => 'non-db',
            'vname' => 'LBL_TASKS',
        ),
        'tasks_parent' => array(
            'name' => 'tasks_parent',
            'type' => 'link',
            'relationship' => 'contact_tasks_parent',
            'source' => 'non-db',
            'vname' => 'LBL_TASKS',
            'reportable' => false,
        ),
        'notes_parent' => array(
            'name' => 'notes_parent',
            'type' => 'link',
            'relationship' => 'contact_notes_parent',
            'source' => 'non-db',
            'vname' => 'LBL_NOTES',
            'reportable' => false,
        ),
        'calls_parent' => array(
            'name' => 'calls_parent',
            'type' => 'link',
            'relationship' => 'contact_calls_parent',
            'source' => 'non-db',
            'vname' => 'LBL_CALLS',
            'reportable' => false,
        ),
        'meetings_parent' => array(
            'name' => 'meetings_parent',
            'type' => 'link',
            'relationship' => 'contact_meetings_parent',
            'source' => 'non-db',
            'vname' => 'LBL_MEETINGS',
            'reportable' => false,
        ),
        'all_tasks' => array(
            'name' => 'all_tasks',
            'type' => 'link',
            'link_class' => 'FlexRelateChildrenLink',
            'relationship' => 'contact_tasks',
            'source' => 'non-db',
            'vname' => 'LBL_TASKS',
        ),
        'user_sync' => array(
            'name' => 'user_sync',
            'type' => 'link',
            'relationship' => 'contacts_users',
            'source' => 'non-db',
            'vname' => 'LBL_USER_SYNC',
        ),
        'created_by_link' => array(
            'name' => 'created_by_link',
            'type' => 'link',
            'relationship' => 'contacts_created_by',
            'vname' => 'LBL_CREATED_BY_USER',
            'link_type' => 'one',
            'module' => 'Users',
            'bean_name' => 'User',
            'source' => 'non-db',
        ),
        'modified_user_link' => array(
            'name' => 'modified_user_link',
            'type' => 'link',
            'relationship' => 'contacts_modified_user',
            'vname' => 'LBL_MODIFIED_BY_USER',
            'link_type' => 'one',
            'module' => 'Users',
            'bean_name' => 'User',
            'source' => 'non-db',
        ),
        'assigned_user_link' => array(
            'name' => 'assigned_user_link',
            'type' => 'link',
            'relationship' => 'contacts_assigned_user',
            'vname' => 'LBL_ASSIGNED_TO_USER',
            'link_type' => 'one',
            'module' => 'Users',
            'bean_name' => 'User',
            'source' => 'non-db',
            'id_name' => 'assigned_user_id',
            'table' => 'users',
            'duplicate_merge' => 'enabled',
        ),
        'campaign_id' => array(
            'name' => 'campaign_id',
            'comment' => 'Campaign that generated lead',
            'vname' => 'LBL_CAMPAIGN_ID',
            'rname' => 'id',
            'id_name' => 'campaign_id',
            'type' => 'id',
            'isnull' => 'true',
            'module' => 'Campaigns',
            'massupdate' => false,
            'duplicate_merge' => 'disabled',
        ),
        'campaign_name' => array(
            'name' => 'campaign_name',
            'rname' => 'name',
            'vname' => 'LBL_CAMPAIGN',
            'type' => 'relate',
            'link' => 'campaign_contacts',
            'isnull' => 'true',
            'reportable' => false,
            'source' => 'non-db',
            'table' => 'campaigns',
            'id_name' => 'campaign_id',
            'module' => 'Campaigns',
            'duplicate_merge' => 'disabled',
            'comment' => 'The first campaign name for Contact (Meta-data only)',
            'studio' => array(
                'mobile' => false,
            ),
        ),
        'campaigns' => array(
            'name' => 'campaigns',
            'type' => 'link',
            'relationship' => 'contact_campaign_log',
            'module' => 'CampaignLog',
            'bean_name' => 'CampaignLog',
            'source' => 'non-db',
            'vname' => 'LBL_CAMPAIGNLOG',
        ),
        'campaign_contacts' => array(
            'name' => 'campaign_contacts',
            'type' => 'link',
            'vname' => 'LBL_CAMPAIGN_CONTACT',
            'relationship' => 'campaign_contacts',
            'source' => 'non-db',
        ),
        // Deprecated: Use rname_link instead
        'c_accept_status_fields' => array(
            'name' => 'c_accept_status_fields',
            'rname' => 'id',
            'relationship_fields' => array(
                'id' => 'accept_status_id',
                'accept_status' => 'accept_status_name'
            ),
            'vname' => 'LBL_LIST_ACCEPT_STATUS',
            'type' => 'relate',
            'link' => 'calls',
            'link_type' => 'relationship_info',
            'source' => 'non-db',
            'importable' => 'false',
            'duplicate_merge' => 'disabled',
            'studio' => false,
        ),
        // Deprecated: Use rname_link instead
        'm_accept_status_fields' => array(
            'name' => 'm_accept_status_fields',
            'rname' => 'id',
            'relationship_fields' => array(
                'id' => 'accept_status_id',
                'accept_status' => 'accept_status_name',
            ),
            'vname' => 'LBL_LIST_ACCEPT_STATUS',
            'type' => 'relate',
            'link' => 'meetings',
            'link_type' => 'relationship_info',
            'source' => 'non-db',
            'importable' => 'false',
            'hideacl' => true,
            'duplicate_merge' => 'disabled',
            'studio' => false,
        ),
        // Deprecated: Use rname_link instead
        'accept_status_id' => array(
            'name' => 'accept_status_id',
            'type' => 'varchar',
            'source' => 'non-db',
            'vname' => 'LBL_LIST_ACCEPT_STATUS',
            'studio' => array('listview' => false),
        ),
        // Deprecated: Use rname_link instead
        'accept_status_name' => array(
            'massupdate' => false,
            'name' => 'accept_status_name',
            'type' => 'enum',
            'studio' => 'false',
            'source' => 'non-db',
            'vname' => 'LBL_LIST_ACCEPT_STATUS',
            'options' => 'dom_meeting_accept_status',
            'importable' => 'false',
        ),
        'accept_status_calls' => array(
            'massupdate' => false,
            'name' => 'accept_status_calls',
            'type' => 'enum',
            'studio' => 'false',
            'source' => 'non-db',
            'vname' => 'LBL_LIST_ACCEPT_STATUS',
            'options' => 'dom_meeting_accept_status',
            'importable' => 'false',
            'link' => 'calls',
            'rname_link' => 'accept_status',
        ),
        'accept_status_meetings' => array(
            'massupdate' => false,
            'name' => 'accept_status_meetings',
            'type' => 'enum',
            'studio' => 'false',
            'source' => 'non-db',
            'vname' => 'LBL_LIST_ACCEPT_STATUS',
            'options' => 'dom_meeting_accept_status',
            'importable' => 'false',
            'link' => 'meetings',
            'rname_link' => 'accept_status',
        ),
        'prospect_lists' => array(
            'name' => 'prospect_lists',
            'type' => 'link',
            'relationship' => 'prospect_list_contacts',
            'module' => 'ProspectLists',
            'source' => 'non-db',
            'vname' => 'LBL_PROSPECT_LIST',
        ),
        'sync_contact' => array(
            'massupdate' => false,
            'name' => 'sync_contact',
            'vname' => 'LBL_SYNC_CONTACT',
            'type' => 'bool',
            'source' => 'non-db',
            'comment' => 'Synch to outlook?  (Meta-Data only)',
            'studio' => 'true',
            'link' => 'user_sync',
            'rname' => 'id',
            'rname_exists' => true,
        ),

        // Marketo Fields
        'mkto_sync' =>
            array(
                'name' => 'mkto_sync',
                'vname' => 'LBL_MKTO_SYNC',
                'type' => 'bool',
                'default' => '0',
                'comment' => 'Should the Lead be synced to Marketo',
                'massupdate' => true,
                'audited' => true,
                'duplicate_merge' => true,
                'reportable' => true,
                'importable' => 'true',
            ),
        'mkto_id' =>
            array(
                'name' => 'mkto_id',
                'vname' => 'LBL_MKTO_ID',
                'comment' => 'Associated Marketo Lead ID',
                'type' => 'int',
                'default' => null,
                'audited' => true,
                'mass_update' => false,
                'duplicate_merge' => true,
                'reportable' => true,
                'importable' => 'false',
            ),
        'mkto_lead_score' =>
            array(
                'name' => 'mkto_lead_score',
                'vname' => 'LBL_MKTO_LEAD_SCORE',
                'comment' => null,
                'type' => 'int',
                'default_value' => null,
                'audited' => true,
                'mass_update' => false,
                'duplicate_merge' => true,
                'reportable' => true,
                'importable' => 'true',
            ),
        'entry_source' => [
            'name' => 'entry_source',
            'vname' => 'LBL_ENTRY_SOURCE',
            'type' => 'enum',
            'function' => 'getSourceTypes',
            'function_bean' => 'Contacts',
            'len' => '255',
            'default' => 'internal',
            'comment' => 'Determines if a record was created internal to the system or external to the system',
            'readonly' => true,
            'studio' => false,
            'processes' => true,
            'reportable' => true,
        ],
        // site_user_id is used as an analytics id
        'site_user_id' => [
            'name' => 'site_user_id',
            'vname' => 'LBL_SITE_USER_ID',
            'type' => 'varchar',
            'len' => '64',
            'reportable' => false,
            'importable' => false,
            'studio' => false,
            'readonly' => true,
        ],
    ),
    'indices' => array(
        array(
            'name' => 'idx_contacts_del_last',
            'type' => 'index',
            'fields' => array('deleted', 'last_name'),
        ),
        array(
            'name' => 'idx_cont_del_last_dm',
            'type' => 'index',
            'fields' => array('deleted', 'last_name', 'date_modified'),
        ),
        array(
            'name' => 'idx_cont_del_reports',
            'type' => 'index',
            'fields' => array('deleted', 'reports_to_id', 'last_name'),
        ),
        array(
            'name' => 'idx_reports_to_id',
            'type' => 'index',
            'fields' => array(
                'deleted',
                'reports_to_id',
                'id',
            ),
        ),
        array(
            'name' => 'idx_del_id_user',
            'type' => 'index',
            'fields' => array('deleted', 'id', 'assigned_user_id'),
        ),
        array(
            'name' => 'idx_cont_assigned',
            'type' => 'index',
            'fields' => array('assigned_user_id'),
        ),
        array('name' => 'idx_contact_title', 'type' => 'index', 'fields' => array('title')),
        array(
            'name' => 'idx_contact_mkto_id',
            'type' => 'index',
            'fields' => array('mkto_id')
        ),
        [
            'name' => 'idx_cont_portal_active',
            'type' => 'index',
            'fields' => ['portal_name', 'portal_active', 'deleted'],
        ],
    ),
    'relationships' => array(
        'contact_direct_reports' => array(
            'lhs_module' => 'Contacts',
            'lhs_table' => 'contacts',
            'lhs_key' => 'id',
            'rhs_module' => 'Contacts',
            'rhs_table' => 'contacts',
            'rhs_key' => 'reports_to_id',
            'relationship_type' => 'one-to-many',
        ),
        'contact_leads' => array(
            'lhs_module' => 'Contacts',
            'lhs_table' => 'contacts',
            'lhs_key' => 'id',
            'rhs_module' => 'Leads',
            'rhs_table' => 'leads',
            'rhs_key' => 'contact_id',
            'relationship_type' => 'one-to-many',
        ),
        'contact_notes' => array(
            'lhs_module' => 'Contacts',
            'lhs_table' => 'contacts',
            'lhs_key' => 'id',
            'rhs_module' => 'Notes',
            'rhs_table' => 'notes',
            'rhs_key' => 'contact_id',
            'relationship_type' => 'one-to-many',
        ),
        'contact_messages' => [
            'lhs_module' => 'Contacts',
            'lhs_table' => 'contacts',
            'lhs_key' => 'id',
            'rhs_module' => 'Messages',
            'rhs_table' => 'messages',
            'rhs_key' => 'contact_id',
            'relationship_type' => 'one-to-many',
        ],
        'contact_notes_parent' => array(
            'lhs_module' => 'Contacts',
            'lhs_table' => 'contacts',
            'lhs_key' => 'id',
            'rhs_module' => 'Notes',
            'rhs_table' => 'notes',
            'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many',
            'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Contacts',
        ),
        'contact_calls_parent' => array(
            'lhs_module' => 'Contacts',
            'lhs_table' => 'contacts',
            'lhs_key' => 'id',
            'rhs_module' => 'Calls',
            'rhs_table' => 'calls',
            'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many',
            'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Contacts',
        ),
        'contact_meetings_parent' => array(
            'lhs_module' => 'Contacts',
            'lhs_table' => 'contacts',
            'lhs_key' => 'id',
            'rhs_module' => 'Meetings',
            'rhs_table' => 'meetings',
            'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many',
            'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Contacts',
        ),
        'contact_tasks' => array(
            'lhs_module' => 'Contacts',
            'lhs_table' => 'contacts',
            'lhs_key' => 'id',
            'rhs_module' => 'Tasks',
            'rhs_table' => 'tasks',
            'rhs_key' => 'contact_id',
            'relationship_type' => 'one-to-many',
        ),
        'contact_tasks_parent' => array(
            'lhs_module' => 'Contacts',
            'lhs_table' => 'contacts',
            'lhs_key' => 'id',
            'rhs_module' => 'Tasks',
            'rhs_table' => 'tasks',
            'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many',
            'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Contacts',
        ),
        'contacts_assigned_user' => array(
            'lhs_module' => 'Users',
            'lhs_table' => 'users',
            'lhs_key' => 'id',
            'rhs_module' => 'Contacts',
            'rhs_table' => 'contacts',
            'rhs_key' => 'assigned_user_id',
            'relationship_type' => 'one-to-many',
        ),
        'contacts_modified_user' => array(
            'lhs_module' => 'Users',
            'lhs_table' => 'users',
            'lhs_key' => 'id',
            'rhs_module' => 'Contacts',
            'rhs_table' => 'contacts',
            'rhs_key' => 'modified_user_id',
            'relationship_type' => 'one-to-many',
        ),
        'contacts_created_by' => array(
            'lhs_module' => 'Users',
            'lhs_table' => 'users',
            'lhs_key' => 'id',
            'rhs_module' => 'Contacts',
            'rhs_table' => 'contacts',
            'rhs_key' => 'created_by',
            'relationship_type' => 'one-to-many',
        ),
        'contact_products' => array(
            'lhs_module' => 'Contacts',
            'lhs_table' => 'contacts',
            'lhs_key' => 'id',
            'rhs_module' => 'Products',
            'rhs_table' => 'products',
            'rhs_key' => 'contact_id',
            'relationship_type' => 'one-to-many',
        ),
        'contact_campaign_log' => array(
            'lhs_module' => 'Contacts',
            'lhs_table' => 'contacts',
            'lhs_key' => 'id',
            'rhs_module' => 'CampaignLog',
            'rhs_table' => 'campaign_log',
            'rhs_key' => 'target_id',
            'relationship_type' => 'one-to-many',
        ),
    ),
    'duplicate_check' => array(
        'enabled' => true,
        'FilterDuplicateCheck' => array(
            'filter_template' => array(
                array(
                    '$and' => array(
                        array('first_name' => array('$starts' => '$first_name')),
                        array('last_name' => array('$starts' => '$last_name')),
                        array('accounts.id' => array('$equals' => '$account_id')),
                        array('dnb_principal_id' => array('$equals' => '$dnb_principal_id')),
                    )
                ),
            ),
            'ranking_fields' => array(
                array(
                    'in_field_name' => 'account_id',
                    'dupe_field_name' => 'account_id',
                ),
                array(
                    'in_field_name' => 'last_name',
                    'dupe_field_name' => 'last_name',
                ),
                array(
                    'in_field_name' => 'first_name',
                    'dupe_field_name' => 'first_name',
                ),
            ),
        ),
    ),
    // This enables optimistic locking for Saves From EditView
    'optimistic_locking' => true,
    'uses' => array(
        'default',
        'assignable',
        'team_security',
        'person',
    ),
    'portal_visibility' => [
        'class' => 'Contacts',
        'links' => [
            'Accounts' => 'accounts',
        ],
    ],
);

VardefManager::createVardef(
    'Contacts',
    'Contact'
);

//boost value for full text search
$dictionary['Contact']['fields']['first_name']['full_text_search']['boost'] = 1.99;
$dictionary['Contact']['fields']['last_name']['full_text_search']['boost'] = 1.97;
$dictionary['Contact']['fields']['email']['full_text_search']['boost'] = 1.95;
$dictionary['Contact']['fields']['phone_home']['full_text_search']['boost'] = 1.10;
$dictionary['Contact']['fields']['phone_mobile']['full_text_search']['boost'] = 1.09;
$dictionary['Contact']['fields']['phone_work']['full_text_search']['boost'] = 1.08;
$dictionary['Contact']['fields']['phone_other']['full_text_search']['boost'] = 1.07;
$dictionary['Contact']['fields']['phone_fax']['full_text_search']['boost'] = 1.06;
$dictionary['Contact']['fields']['description']['full_text_search']['boost'] = 0.71;
$dictionary['Contact']['fields']['primary_address_street']['full_text_search']['boost'] = 0.33;
$dictionary['Contact']['fields']['alt_address_street']['full_text_search']['boost'] = 0.32;

// enable assistant_phone for full text search
$dictionary['Contact']['fields']['assistant_phone']['full_text_search'] = [
    'enabled' => true,
    'searchable' => true,
    'boost' => 1.05,
];
