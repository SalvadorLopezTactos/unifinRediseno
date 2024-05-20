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

$dictionary['ExternalUser'] = [
    'table' => 'external_users',
    'fields' => [
        'user_name' => [
            'name' => 'user_name',
            'vname' => 'LBL_USER_NAME',
            'type' => 'varchar',
            'len' => '255',
            'comment' => 'Username of the external user',
        ],
        'status' => [
            'name' => 'status',
            'vname' => 'LBL_STATUS',
            'type' => 'enum',
            'options' => 'external_user_status_dom',
            'len' => 100,
            'comment' => 'Status of the external user',
        ],
        'external_app' => [
            'name' => 'external_app',
            'type' => 'varchar',
            'len' => 255,
            'vname' => 'LBL_EXTERNAL_APPLICATION',
            'comment' => 'External application which creates the external user',
        ],
        'external_id' => [
            'name' => 'external_id',
            'type' => 'varchar',
            'len' => 255,
            'vname' => 'LBL_EXTERNAL_ID',
            'comment' => 'External id of the external user',
        ],
        'contact_name' => [
            'name' => 'contact_name',
            'rname' => 'name',
            'id_name' => 'contact_id',
            'vname' => 'LBL_CONTACT_NAME',
            'table' => 'contacts',
            'type' => 'relate',
            'link' => 'contact',
            'join_name' => 'contacts',
            'db_concat_fields' => [
                'first_name',
                'last_name',
            ],
            'isnull' => 'true',
            'module' => 'Contacts',
            'source' => 'non-db',
        ],
        'contact_id' => [
            'name' => 'contact_id',
            'vname' => 'LBL_CONTACT_ID',
            'type' => 'id',
            'required' => false,
            'reportable' => false,
            'comment' => 'Contact ID the external user is associated with',
        ],
        'contact' => [
            'name' => 'contact',
            'type' => 'link',
            'relationship' => 'external_user_contact',
            'vname' => 'LBL_LIST_CONTACT_NAME',
            'source' => 'non-db',
        ],
        'accounts' => [
            'name' => 'accounts',
            'type' => 'link',
            'relationship' => 'external_users_accounts',
            'module' => 'Accounts',
            'bean_name' => 'Account',
            'source' => 'non-db',
            'vname' => 'LBL_ACCOUNTS',
        ],
        'cases' => [
            'name' => 'cases',
            'type' => 'link',
            'relationship' => 'external_users_cases',
            'module' => 'Cases',
            'bean_name' => 'aCase',
            'source' => 'non-db',
            'vname' => 'LBL_CASES',
        ],
        'bugs' => [
            'name' => 'bugs',
            'type' => 'link',
            'relationship' => 'external_users_bugs',
            'module' => 'Bugs',
            'bean_name' => 'Bug',
            'source' => 'non-db',
            'vname' => 'LBL_BUGS',
        ],
        'opportunities' => [
            'name' => 'opportunities',
            'type' => 'link',
            'relationship' => 'external_users_opportunities',
            'module' => 'Opportunities',
            'bean_name' => 'Opportunity',
            'source' => 'non-db',
            'vname' => 'LBL_OPPORTUNITIES',
        ],
        'quotes' => [
            'name' => 'quotes',
            'type' => 'link',
            'relationship' => 'external_users_quotes',
            'module' => 'Quotes',
            'bean_name' => 'Quote',
            'source' => 'non-db',
            'vname' => 'LBL_QUOTES',
        ],
        'notes' => [
            'name' => 'notes',
            'type' => 'link',
            'relationship' => 'external_user_notes',
            'source' => 'non-db',
            'vname' => 'LBL_NOTES',
        ],
    ],
    'uses' => [
        'person',
        'external_source',
        'assignable',
        'team_security',
        'taggble',
    ],
    'acls' => [
        'SugarACLAdminOnly' => [
            'allowUserRead' => true,
        ],
    ],
    'indices' => [
        [
            'name' => 'idx_external_users_user_name',
            'type' => 'index',
            'fields' => ['user_name'],
        ],
        [
            'name' => 'idx_external_users_external_id',
            'type' => 'index',
            'fields' => ['external_id'],
        ],
    ],
    'relationships' => [
        'external_user_contact' => [
            'lhs_module' => 'ExternalUsers',
            'lhs_table' => 'external_users',
            'lhs_key' => 'contact_id',
            'rhs_module' => 'Contacts',
            'rhs_table' => 'contacts',
            'rhs_key' => 'id',
            'relationship_type' => 'one-to-one',
        ],
        'external_user_notes' => [
            'lhs_module' => 'ExternalUsers',
            'lhs_table' => 'external_users',
            'lhs_key' => 'id',
            'rhs_module' => 'Notes',
            'rhs_table' => 'notes',
            'rhs_key' => 'external_id',
            'relationship_type' => 'one-to-many',
        ],
    ],
    'duplicate_check' => [
        'enabled' => true,
        'FilterDuplicateCheck' => [
            'filter_template' => [
                ['external_id' => ['$equals' => '$external_id']],
            ],
            'ranking_fields' => [
                ['in_field_name' => 'external_id', 'dupe_field_name' => 'external_id'],
            ],
        ],
    ],
];

VardefManager::createVardef('ExternalUsers', 'ExternalUser');
