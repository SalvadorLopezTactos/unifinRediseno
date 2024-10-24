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
// Needed by VarDef manager when running the load_fields directive
SugarAutoLoader::load('modules/Tags/TagsRelatedModulesUtilities.php');
$dictionary['Tag'] = [
    'comment' => 'Tagging module',
    'table' => 'tags',
    'color' => 'pink',
    'icon' => 'sicon-tag-lg',
    'audited' => true,
    'activity_enabled' => false,
    'favorites' => true,
    'optimistic_locking' => false,
    'unified_search' => true,
    'full_text_search' => true,
    'unified_search_default_enabled' => true,
    'required_import_indexes' => ['idx_tag_name::name'],
    'fields' => [
        'name_lower' => [
            'name' => 'name_lower',
            'vname' => 'LBL_NAME_LOWER',
            'type' => 'varchar',
            'len' => 255,
            'unified_search' => true,
            'required' => true,
            'reportable' => false,
            'studio' => false,
            'exportable' => false,
        ],
        'hint_accountsets_link' => [
            'name' => 'hint_accountsets_link',
            'vname' => 'LBL_HINT_ACCOUNTSETS',
            'type' => 'link',
            'relationship' => 'hintaccountsets_tags',
            'source' => 'non-db',
        ],
    ],
    'relationships' => [],
    'indices' => [
        'name' => [
            'name' => 'idx_tag_name',
            'type' => 'index',
            'fields' => ['name'],
        ],
        'name_lower' => [
            'name' => 'idx_tag_name_lower',
            'type' => 'index',
            'fields' => ['name_lower'],
        ],
    ],
    'uses' => [
        'basic',
        'external_source',
        'assignable',
    ],
    // This can also be a string that maps to a global function. If it's an array
    // it should be static
    'load_fields' => [
        'class' => 'TagsRelatedModulesUtilities',
        'method' => 'getRelatedFields',
    ],
    // Tags should not implement taggable, but since there is no distinction
    // between basic and default for sugar objects templates yet, we need to
    // forecefully remove the taggable implementation fields. Once there is a
    // separation of default and basic templates we can safely remove these as
    // this module will implement default instead of basic.
    'ignore_templates' => [
        'taggable',
        'commentlog',
    ],
    // These ACLs prevent regular users from taking administrative actions on
    // Tag records. This allows view, list and export only.
    'acls' => [
        'SugarACLDeveloperOrAdmin' => [
            'aclModule' => 'Tags',
            'allowUserRead' => true,
        ],
    ],
    'duplicate_check' => [
        'enabled' => true,
        // Use a Tags specific dupe check to enforce cases
        'TagsFilterDuplicateCheck' => [
            'filter_template' => [
                ['name' => ['$equals' => '$name']],
            ],
            'ranking_fields' => [
                ['in_field_name' => 'name', 'dupe_field_name' => 'name'],
            ],
        ],
    ],
];
VardefManager::createVardef(
    'Tags',
    'Tag'
);

// disable full text search on template fields
$dictionary['Tag']['fields']['assigned_user_id']['full_text_search'] = [];
$dictionary['Tag']['fields']['created_by']['full_text_search'] = [];
$dictionary['Tag']['fields']['date_entered']['full_text_search'] = [];
// don't disable date_modified which will be used as default sorting
//$dictionary['Tag']['fields']['date_modified']['full_text_search'] = array();
$dictionary['Tag']['fields']['description']['full_text_search'] = [];
$dictionary['Tag']['fields']['modified_user_id']['full_text_search'] = [];
