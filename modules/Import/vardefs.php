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
$dictionary['ImportMap'] = [
    'table' => 'import_maps',
    'archive' => false,
    'comment' => 'Import mapping control table',
    'fields' => [
        'id' => [
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'id',
            'required' => true,
            'reportable' => false,
            'comment' => 'Unique identifier',
        ],
        'name' => [
            'name' => 'name',
            'vname' => 'LBL_NAME',
            'type' => 'varchar',
            'len' => '254',
            'required' => true,
            'comment' => 'Name of import map',
        ],
        'source' => [
            'name' => 'source',
            'vname' => 'LBL_SOURCE',
            'type' => 'varchar',
            'len' => '36',
            'required' => true,
            'comment' => '',
        ],
        'enclosure' => [
            'name' => 'enclosure',
            'vname' => 'LBL_CUSTOM_ENCLOSURE',
            'type' => 'varchar',
            'len' => '1',
            'required' => true,
            'comment' => '',
            'default' => ' ',
        ],
        'delimiter' => [
            'name' => 'delimiter',
            'vname' => 'LBL_CUSTOM_DELIMITER',
            'type' => 'varchar',
            'len' => '1',
            'required' => true,
            'comment' => '',
            'default' => ',',
        ],
        'module' => [
            'name' => 'module',
            'vname' => 'LBL_MODULE',
            'type' => 'varchar',
            'len' => '36',
            'required' => true,
            'comment' => 'Module used for import',
        ],
        'content' => [
            'name' => 'content',
            'vname' => 'LBL_CONTENT',
            'type' => 'text',
            'comment' => 'Mappings for all columns',
        ],
        'default_values' => [
            'name' => 'default_values',
            'vname' => 'LBL_CONTENT',
            'type' => 'text',
            'comment' => 'Default Values for all columns',
        ],
        'has_header' => [
            'name' => 'has_header',
            'vname' => 'LBL_HAS_HEADER',
            'type' => 'bool',
            'default' => '1',
            'required' => true,
            'comment' => 'Indicator if source file contains a header row',
        ],
        'deleted' => [
            'name' => 'deleted',
            'vname' => 'LBL_DELETED',
            'type' => 'bool',
            'required' => false,
            'reportable' => false,
            'comment' => 'Record deletion indicator',
        ],
        'date_entered' => [
            'name' => 'date_entered',
            'vname' => 'LBL_DATE_ENTERED',
            'type' => 'datetime',
            'required' => true,
            'comment' => 'Date record created',
        ],
        'date_modified' => [
            'name' => 'date_modified',
            'vname' => 'LBL_DATE_MODIFIED',
            'type' => 'datetime',
            'required' => true,
            'comment' => 'Date record last modified',
        ],
        'assigned_user_id' => [
            'name' => 'assigned_user_id',
            'vname' => 'LBL_ASSIGNED_TO',
            'type' => 'id',
            'isnull' => 'false',
            'reportable' => false,
            'comment' => 'Assigned-to user',
        ],
        'is_published' => [
            'name' => 'is_published',
            'vname' => 'LBL_IS_PUBLISHED',
            'type' => 'varchar',
            'len' => '3',
            'required' => true,
            'default' => 'no',
            'comment' => 'Indicator if mapping is published',
        ],
    ],
    'indices' => [
        [
            'name' => 'import_mapspk',
            'type' => 'primary',
            'fields' => ['id'],
        ],
        [
            'name' => 'idx_owner_module_name',
            'type' => 'index',
            'fields' => ['assigned_user_id', 'module', 'name', 'deleted'],
        ],
    ],
];

$dictionary['UsersLastImport'] = [
    'table' => 'users_last_import',
    'comment' => 'Maintains rows last imported by user',
    'fields' => [
        'id' => [
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'id',
            'required' => true,
            'reportable' => false,
            'comment' => 'Unique identifier',
        ],
        'assigned_user_id' => [
            'name' => 'assigned_user_id',
            'rname' => 'user_name',
            'id_name' => 'assigned_user_id',
            'vname' => 'LBL_ASSIGNED_TO',
            'type' => 'assigned_user_name',
            'table' => 'users',
            'isnull' => 'false',
            'dbType' => 'id',
            'reportable' => false,
            'comment' => 'User assigned to this record',
        ],
        'import_module' => [
            'name' => 'import_module',
            'vname' => 'LBL_BEAN_TYPE',
            'type' => 'varchar',
            'len' => '36',
            'comment' => 'Module for which import occurs',
        ],
        'bean_type' => [
            'name' => 'bean_type',
            'vname' => 'LBL_BEAN_TYPE',
            'type' => 'varchar',
            'len' => '36',
            'comment' => 'Bean type for which import occurs',
        ],
        'bean_id' => [
            'name' => 'bean_id',
            'vname' => 'LBL_BEAN_ID',
            'type' => 'id',
            'reportable' => false,
            'comment' => 'ID of item identified by bean_type',
        ],
        'deleted' => [
            'name' => 'deleted',
            'vname' => 'LBL_DELETED',
            'type' => 'bool',
            'reportable' => false,
            'required' => false,
            'comment' => 'Record deletion indicator',
        ],
    ],
    'indices' => [
        [
            'name' => 'users_last_importpk',
            'type' => 'primary',
            'fields' => ['id'],
        ],
        [
            'name' => 'idx_user_id',
            'type' => 'index',
            'fields' => ['assigned_user_id'],
        ],
    ],
];
