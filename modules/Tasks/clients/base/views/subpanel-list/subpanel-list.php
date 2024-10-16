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
$viewdefs['Tasks']['base']['view']['subpanel-list'] = [
    'panels' => [
        [
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => [
                [
                    'label' => 'LBL_LIST_SUBJECT',
                    'enabled' => true,
                    'default' => true,
                    'link' => true,
                    'name' => 'name',
                ],
                [
                    'label' => 'LBL_LIST_STATUS',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'status',
                ],
                [
                    'target_record_key' => 'contact_id',
                    'target_module' => 'Contacts',
                    'label' => 'LBL_LIST_CONTACT',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'contact_name',
                ],
                [
                    'name' => 'date_start',
                    'label' => 'LBL_LIST_START_DATE',
                    'css_class' => 'overflow-visible',
                    'enabled' => true,
                    'default' => true,
                ],
                [
                    'name' => 'date_due',
                    'label' => 'LBL_LIST_DUE_DATE',
                    'type' => 'datetimecombo-colorcoded',
                    'completed_status_value' => 'Completed',
                    'link' => false,
                    'css_class' => 'overflow-visible',
                    'enabled' => true,
                    'default' => true,
                ],
                [
                    'name' => 'assigned_user_name',
                    'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
                    'id' => 'ASSIGNED_USER_ID',
                    'enabled' => true,
                    'default' => true,
                ],
            ],
        ],
    ],
    'rowactions' => [
        'actions' => [
            [
                'type' => 'rowaction',
                'css_class' => 'btn',
                'tooltip' => 'LBL_PREVIEW',
                'event' => 'list:preview:fire',
                'icon' => 'sicon-preview',
                'acl_action' => 'view',
            ],
            [
                'type' => 'rowaction',
                'name' => 'edit_button',
                'icon' => 'sicon-pencil',
                'label' => 'LBL_EDIT_BUTTON',
                'event' => 'list:editrow:fire',
                'acl_action' => 'edit',
            ],
            [
                'type' => 'unlink-action',
                'name' => 'unlink_button',
                'icon' => 'sicon-unlink',
                'label' => 'LBL_UNLINK_BUTTON',
            ],
            [
                'type' => 'closebutton',
                'name' => 'record-close',
                'label' => 'LBL_CLOSE_BUTTON_TITLE',
                'closed_status' => 'Completed',
                'acl_action' => 'edit',
            ],
        ],
    ],
];
