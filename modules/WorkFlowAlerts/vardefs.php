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
$dictionary['WorkFlowAlert'] = ['table' => 'workflow_alerts'
    , 'fields' => [
        'id' => [
            'name' => 'id',
            'vname' => 'LBL_NAME',
            'type' => 'id',
            'required' => true,
            'reportable' => false,
        ],
        'deleted' => [
            'name' => 'deleted',
            'vname' => 'LBL_DELETED',
            'type' => 'bool',
            'required' => false,
            'default' => '0',
            'reportable' => false,
        ],
        'date_entered' => [
            'name' => 'date_entered',
            'vname' => 'LBL_DATE_ENTERED',
            'type' => 'datetime',
            'required' => true,
        ],
        'date_modified' => [
            'name' => 'date_modified',
            'vname' => 'LBL_DATE_MODIFIED',
            'type' => 'datetime',
            'required' => true,
        ],
        'modified_user_id' => [
            'name' => 'modified_user_id',
            'rname' => 'user_name',
            'id_name' => 'modified_user_id',
            'vname' => 'LBL_ASSIGNED_TO',
            'type' => 'assigned_user_name',
            'table' => 'users',
            'isnull' => 'false',
            'dbType' => 'id',
            'reportable' => true,
        ],
        'created_by' => [
            'name' => 'created_by',
            'rname' => 'user_name',
            'id_name' => 'modified_user_id',
            'vname' => 'LBL_ASSIGNED_TO',
            'type' => 'assigned_user_name',
            'table' => 'users',
            'isnull' => 'false',
            'dbType' => 'id',
        ],
        'field_value' => [
            'name' => 'field_value',
            'vname' => 'LBL_FIELD_VALUE',
            'type' => 'varchar',
            'len' => '50',
        ],
        'rel_email_value' => [
            'name' => 'rel_email_value',
            'vname' => 'LBL_REL_EMAIL_VALUE',
            'type' => 'varchar',
            'len' => '50',
        ],
        'rel_module1' => [
            'name' => 'rel_module1',
            'vname' => 'LBL_REL_MODULE1',
            'type' => 'varchar',
            'len' => '255',
            'required' => false,
        ],
        'rel_module2' => [
            'name' => 'rel_module2',
            'vname' => 'LBL_REL_MODULE2',
            'type' => 'varchar',
            'len' => '255',
            'required' => false,
        ],
        'rel_module1_type' => [
            'name' => 'rel_module1_type',
            'vname' => 'LBL_RELATED_TYPE',
            'type' => 'enum',
            'options' => 'wflow_rel_type_dom',
            'len' => 10,
        ],
        'rel_module2_type' => [
            'name' => 'rel_module2_type',
            'vname' => 'LBL_RELATED_TYPE',
            'type' => 'enum',
            'options' => 'wflow_rel_type_dom',
            'len' => 10,
        ],
        'where_filter' => [
            'name' => 'where_filter',
            'vname' => 'LBL_WHERE_FILTER',
            'type' => 'bool',
            'default' => '0',
        ],
        'user_type' => [
            'name' => 'user_type',
            'vname' => 'LBL_USER_TYPE',
            'type' => 'enum',
            'required' => true,
            'options' => 'wflow_user_type_dom',
            'len' => 100,
        ],
        'array_type' => [
            'name' => 'array_type',
            'vname' => 'LBL_ARRAY_TYPE',
            'type' => 'enum',
            'required' => false,
            'options' => 'wflow_array_type_dom',
            'len' => 100,
        ],
        'relate_type' => [
            'name' => 'relate_type',
            'vname' => 'LBL_RELATE_TYPE',
            'type' => 'enum',
            'required' => false,
            'options' => 'wflow_relate_type_dom',
            'len' => 100,
        ],
        'address_type' => [
            'name' => 'address_type',
            'vname' => 'LBL_ADDRESS_TYPE',
            'type' => 'enum',
            'required' => false,
            'options' => 'wflow_address_type_dom',
            'len' => 100,
        ],
        'expressions' => [
            'name' => 'expressions',
            'type' => 'link',
            'relationship' => 'expressions',
            'module' => 'Expressions',
            'bean_name' => 'Expression',
            'source' => 'non-db',
        ],
        'parent_id' => [
            'name' => 'parent_id',
            'type' => 'id',
            'required' => true,
            'reportable' => false,
        ],
        'user_display_type' => [
            'name' => 'user_display_type',
            'vname' => 'LBL_USER_DISPLAY_TYPE',
            'type' => 'enum',
            'required' => false,
            'options' => 'wflow_user_display_type_dom',
            'len' => 100,
        ],
        'rel1_alert_fil' => [
            'name' => 'rel1_alert_fil',
            'type' => 'link',
            'relationship' => 'rel1_alert_fil',
            'module' => 'Expressions',
            'bean_name' => 'Expression',
            'source' => 'non-db',
        ],
        'rel2_alert_fil' => [
            'name' => 'rel2_alert_fil',
            'type' => 'link',
            'relationship' => 'rel2_alert_fil',
            'module' => 'Expressions',
            'bean_name' => 'Expression',
            'source' => 'non-db',
        ],
    ],
    'acls' => ['SugarACLDeveloperOrAdmin' => true],
    'indices' => [
        ['name' => 'workflowalerts_k', 'type' => 'primary', 'fields' => ['id']],
    ]

    , 'relationships' => [
        'expressions' => ['lhs_module' => 'WorkFlowAlerts', 'lhs_table' => 'workflow_alerts', 'lhs_key' => 'id',
            'rhs_module' => 'Expressions', 'rhs_table' => 'expressions', 'rhs_key' => 'parent_id',
            'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'filter', 'relationship_type' => 'one-to-many']

        , 'rel1_alert_fil' => ['lhs_module' => 'WorkFlowAlerts', 'lhs_table' => 'workflow_alerts', 'lhs_key' => 'id',
            'rhs_module' => 'Expressions', 'rhs_table' => 'expressions', 'rhs_key' => 'parent_id',
            'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'rel1_alert_fil', 'relationship_type' => 'one-to-many']

        , 'rel2_alert_fil' => ['lhs_module' => 'WorkFlowAlerts', 'lhs_table' => 'workflow_alerts', 'lhs_key' => 'id',
            'rhs_module' => 'Expressions', 'rhs_table' => 'expressions', 'rhs_key' => 'parent_id',
            'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'rel2_alert_fil', 'relationship_type' => 'one-to-many'],
    ],

];
