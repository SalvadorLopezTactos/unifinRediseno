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
$dictionary['Bug'] = [
    'table' => 'bugs',
    'audited' => true,
    'escalatable' => true,
    'color' => 'red',
    'icon' => 'sicon-bug',
    'activity_enabled' => true,
    'comment' => 'Bugs are defects in products and services',
    'duplicate_merge' => true,
    'unified_search' => true,
    'full_text_search' => true,
    'unified_search_default_enabled' => true,
    'fields' => [
        'found_in_release' => [
            'name' => 'found_in_release',
            'type' => 'enum',
            'function' => 'getReleaseDropDown',
            'vname' => 'LBL_FOUND_IN_RELEASE',
            'reportable' => false,
            'comment' => 'The software or service release that manifested the bug',
            'duplicate_merge' => 'disabled',
            'audited' => true,
            'studio' => [
                'fields' => 'false',
                'listview' => false,
                // Bug 54507 - Add wireless and portal to exclude list
                'wirelesslistview' => false,
                'portalrecordview' => false,
                'portallistview' => false,
            ],
            'massupdate' => true,
        ],
        'release_name' => [
            'name' => 'release_name',
            'rname' => 'name',
            'vname' => 'LBL_FOUND_IN_RELEASE',
            'type' => 'relate',
            'dbType' => 'varchar',
            'group' => 'found_in_release',
            'reportable' => false,
            'source' => 'non-db',
            'table' => 'releases',
            // bug 22994, we should use the release name to search, I have write codes to operate the cross table query
            'merge_filter' => 'enabled',
            'id_name' => 'found_in_release',
            'module' => 'Releases',
            'link' => 'release_link',
            'massupdate' => false,
            'studio' => [
                'editview' => false,
                'detailview' => false,
                'recordview' => false,
                'quickcreate' => false,
                'basic_search' => false,
                'advanced_search' => false,
                'wirelesseditview' => false,
                'wirelessdetailview' => false,
                'wirelesslistview' => 'visible',
                'wireless_basic_search' => false,
                'wireless_advanced_search' => false,
                // Bug 54507 - Add portal to exclude from layout list
                'portalrecordview' => false,
                'portallistview' => false,
                'portalsearchview' => false,
            ],
            'exportable' => true,
        ],
        'fixed_in_release' => [
            'name' => 'fixed_in_release',
            'type' => 'enum',
            'function' => 'getReleaseDropDown',
            'vname' => 'LBL_FIXED_IN_RELEASE',
            'reportable' => false,
            'comment' => 'The software or service release that corrected the bug',
            'duplicate_merge' => 'disabled',
            'audited' => true,
            'studio' => [
                'fields' => 'false',
                'listview' => false,
                // Bug 54507 - Add wireless and portal to exclude list
                'wirelesslistview' => false,
                'portalrecordview' => false,
                'portallistview' => false,
            ],
            'massupdate' => true,
        ],
        'fixed_in_release_name' => [
            'name' => 'fixed_in_release_name',
            'rname' => 'name',
            'group' => 'fixed_in_release',
            'id_name' => 'fixed_in_release',
            'vname' => 'LBL_FIXED_IN_RELEASE',
            'type' => 'relate',
            'table' => 'releases',
            'isnull' => 'false',
            'massupdate' => false,
            'module' => 'Releases',
            'dbType' => 'varchar',
            'len' => 36,
            'source' => 'non-db',
            'link' => 'fixed_in_release_link',
            'studio' => [
                'editview' => false,
                'detailview' => false,
                'recordview' => false,
                'quickcreate' => false,
                'basic_search' => false,
                'advanced_search' => false,
                'wirelesseditview' => false,
                'wirelessdetailview' => false,
                'wirelesslistview' => 'visible',
                'wireless_basic_search' => false,
                'wireless_advanced_search' => false,
                // Bug 54507 - Add portal to exclude from layout list
                'portalrecordview' => false,
                'portallistview' => false,
                'portalsearchview' => false,
            ],
            'exportable' => true,
        ],
        'source' => [
            'name' => 'source',
            'vname' => 'LBL_SOURCE',
            'type' => 'enum',
            'options' => 'source_dom',
            'len' => 255,
            'comment' => 'An indicator of how the bug was entered (ex: via web, email, etc.)',
        ],
        'product_category' => [
            'name' => 'product_category',
            'vname' => 'LBL_PRODUCT_CATEGORY',
            'type' => 'enum',
            'options' => 'product_category_dom',
            'len' => 255,
            'comment' => 'Where the bug was discovered (ex: Accounts, Contacts, Leads)',
            'sortable' => true,
        ],
        'portal_viewable' => [
            'name' => 'portal_viewable',
            'vname' => 'LBL_SHOW_IN_PORTAL',
            'type' => 'bool',
            'default' => 1,
            'reportable' => false,
        ],
        'messages' => [
            'name' => 'messages',
            'type' => 'link',
            'relationship' => 'bug_messages',
            'source' => 'non-db',
            'vname' => 'LBL_MESSAGES',
        ],
        'escalations' => [
            'name' => 'escalations',
            'type' => 'link',
            'relationship' => 'bug_escalations',
            'module' => 'Escalations',
            'bean_name' => 'Escalation',
            'source' => 'non-db',
            'vname' => 'LBL_ESCALATIONS',
        ],
        'external_users' => [
            'name' => 'external_users',
            'type' => 'link',
            'relationship' => 'external_users_bugs',
            'module' => 'ExternalUsers',
            'bean_name' => 'ExternalUser',
            'source' => 'non-db',
            'vname' => 'LBL_EXTERNAL_USERS',
        ],
        'tasks' => [
            'name' => 'tasks',
            'type' => 'link',
            'relationship' => 'bug_tasks',
            'source' => 'non-db',
            'vname' => 'LBL_TASKS',
        ],
        'notes' => [
            'name' => 'notes',
            'type' => 'link',
            'relationship' => 'bug_notes',
            'source' => 'non-db',
            'vname' => 'LBL_NOTES',
        ],
        'meetings' => [
            'name' => 'meetings',
            'type' => 'link',
            'relationship' => 'bug_meetings',
            'source' => 'non-db',
            'vname' => 'LBL_MEETINGS',
            'module' => 'Meetings',
        ],
        'calls' => [
            'name' => 'calls',
            'type' => 'link',
            'relationship' => 'bug_calls',
            'source' => 'non-db',
            'vname' => 'LBL_CALLS',
            'module' => 'Calls',
        ],
        'emails' => [
            'name' => 'emails',
            'type' => 'link',
            'relationship' => 'emails_bugs_rel',
            'source' => 'non-db',
            'vname' => 'LBL_EMAILS',
        ],
        'documents' => [
            'name' => 'documents',
            'type' => 'link',
            'relationship' => 'documents_bugs',
            'source' => 'non-db',
            'vname' => 'LBL_DOCUMENTS_SUBPANEL_TITLE',
        ],
        'contacts' => [
            'name' => 'contacts',
            'type' => 'link',
            'relationship' => 'contacts_bugs',
            'source' => 'non-db',
            'vname' => 'LBL_CONTACTS',
        ],
        'accounts' => [
            'name' => 'accounts',
            'type' => 'link',
            'relationship' => 'accounts_bugs',
            'source' => 'non-db',
            'vname' => 'LBL_ACCOUNTS',
        ],
        'cases' => [
            'name' => 'cases',
            'type' => 'link',
            'relationship' => 'cases_bugs',
            'source' => 'non-db',
            'vname' => 'LBL_CASES',
        ],
        'project' => [
            'name' => 'project',
            'type' => 'link',
            'relationship' => 'projects_bugs',
            'source' => 'non-db',
            'vname' => 'LBL_PROJECTS',
        ],
        'release_link' => [
            'name' => 'release_link',
            'type' => 'link',
            'relationship' => 'bugs_release',
            'vname' => 'LBL_FOUND_IN_RELEASE',
            'link_type' => 'one',
            'module' => 'Releases',
            'bean_name' => 'Release',
            'source' => 'non-db',
        ],
        'fixed_in_release_link' => [
            'name' => 'fixed_in_release_link',
            'type' => 'link',
            'relationship' => 'bugs_fixed_in_release',
            'vname' => 'LBL_FIXED_IN_RELEASE',
            'link_type' => 'one',
            'module' => 'Releases',
            'bean_name' => 'Release',
            'source' => 'non-db',
        ],
    ],
    'indices' => [

    ],
    'relationships' => [
        'bug_tasks' => [
            'lhs_module' => 'Bugs',
            'lhs_table' => 'bugs',
            'lhs_key' => 'id',
            'rhs_module' => 'Tasks',
            'rhs_table' => 'tasks',
            'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many',
            'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Bugs',
        ],
        'bug_meetings' => [
            'lhs_module' => 'Bugs',
            'lhs_table' => 'bugs',
            'lhs_key' => 'id',
            'rhs_module' => 'Meetings',
            'rhs_table' => 'meetings',
            'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many',
            'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Bugs',
        ],
        'bug_calls' => [
            'lhs_module' => 'Bugs',
            'lhs_table' => 'bugs',
            'lhs_key' => 'id',
            'rhs_module' => 'Calls',
            'rhs_table' => 'calls',
            'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many',
            'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Bugs',
        ],
        'bug_emails' => [
            'lhs_module' => 'Bugs',
            'lhs_table' => 'bugs',
            'lhs_key' => 'id',
            'rhs_module' => 'Emails',
            'rhs_table' => 'emails',
            'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many',
            'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Bugs',
        ],
        'bug_notes' => [
            'lhs_module' => 'Bugs',
            'lhs_table' => 'bugs',
            'lhs_key' => 'id',
            'rhs_module' => 'Notes',
            'rhs_table' => 'notes',
            'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many',
            'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Bugs',
        ],
        'bug_messages' => [
            'lhs_module' => 'Bugs',
            'lhs_table' => 'bugs',
            'lhs_key' => 'id',
            'rhs_module' => 'Messages',
            'rhs_table' => 'messages',
            'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many',
            'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Bugs',
        ],
        'bug_escalations' => [
            'lhs_module' => 'Bugs',
            'lhs_table' => 'bugs',
            'lhs_key' => 'id',
            'rhs_module' => 'Escalations',
            'rhs_table' => 'escalations',
            'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many',
            'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Bugs',
        ],
        'bugs_assigned_user' => [
            'lhs_module' => 'Users',
            'lhs_table' => 'users',
            'lhs_key' => 'id',
            'rhs_module' => 'Bugs',
            'rhs_table' => 'bugs',
            'rhs_key' => 'assigned_user_id',
            'relationship_type' => 'one-to-many',
        ],
        'bugs_modified_user' => [
            'lhs_module' => 'Users',
            'lhs_table' => 'users',
            'lhs_key' => 'id',
            'rhs_module' => 'Bugs',
            'rhs_table' => 'bugs',
            'rhs_key' => 'modified_user_id',
            'relationship_type' => 'one-to-many',
        ],
        'bugs_created_by' => [
            'lhs_module' => 'Users',
            'lhs_table' => 'users',
            'lhs_key' => 'id',
            'rhs_module' => 'Bugs',
            'rhs_table' => 'bugs',
            'rhs_key' => 'created_by',
            'relationship_type' => 'one-to-many',
        ],
        'bugs_release' => [
            'lhs_module' => 'Releases',
            'lhs_table' => 'releases',
            'lhs_key' => 'id',
            'rhs_module' => 'Bugs',
            'rhs_table' => 'bugs',
            'rhs_key' => 'found_in_release',
            'relationship_type' => 'one-to-many',
        ],
        'bugs_fixed_in_release' => [
            'lhs_module' => 'Releases',
            'lhs_table' => 'releases',
            'lhs_key' => 'id',
            'rhs_module' => 'Bugs',
            'rhs_table' => 'bugs',
            'rhs_key' => 'fixed_in_release',
            'relationship_type' => 'one-to-many',
        ],
    ],
    'duplicate_check' => [
        'enabled' => true,
        'FilterDuplicateCheck' => [
            'filter_template' => [
                [
                    '$and' => [
                        [
                            'name' => [
                                '$starts' => '$name',
                            ],
                        ],
                        [
                            'status' => [
                                '$not_equals' => 'Closed',
                            ],
                        ],
                    ],
                ],
            ],
            'ranking_fields' => [
                [
                    'in_field_name' => 'name',
                    'dupe_field_name' => 'name',
                ],
            ],
        ],
    ],

    // This enables optimistic locking for Saves From EditView
    'optimistic_locking' => true,
    'portal_visibility' => [
        'class' => 'Bugs',
        'links' => [
            'Accounts' => 'accounts',
            'Contacts' => 'contacts',
        ],
    ],
];

VardefManager::createVardef('Bugs', 'Bug', [
    'default',
    'assignable',
    'team_security',
    'issue',
    'external_source',
    'escalatable',
    'audit',
]);

//jc - adding for refactor for import to not use the required_fields array
//defined in the field_arrays.php file
$dictionary['Bug']['fields']['name']['importable'] = 'required';

//boost value for full text search
$dictionary['Bug']['fields']['name']['full_text_search']['boost'] = 1.51;
$dictionary['Bug']['fields']['bug_number']['full_text_search']['boost'] = 1.27;
$dictionary['Bug']['fields']['description']['full_text_search']['boost'] = 0.68;
$dictionary['Bug']['fields']['work_log']['full_text_search']['boost'] = 0.67;
