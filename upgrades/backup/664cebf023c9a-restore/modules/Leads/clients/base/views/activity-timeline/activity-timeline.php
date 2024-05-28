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

$viewdefs['Leads']['base']['view']['activity-timeline'] = [
    'activity_modules' => [
        [
            'module' => 'Calls',
            'record_date' => 'date_start',
            'fields' => [
                'name',
                'status',
                'duration',
                'direction',
                'description',
                'invitees',
                'date_entered_by',
                'date_modified_by',
                'assigned_user_name',
                'sentiment_score_customer',
            ],
            'card_menu' => [
                [
                    'type' => 'focuscab',
                    'css_class' => 'dashboard-icon',
                    'icon' => 'sicon-focus-drawer',
                    'tooltip' => 'LBL_FOCUS_DRAWER_DASHBOARD',
                ],
                [
                    'type' => 'cab_actiondropdown',
                    'buttons' => [
                        [
                            'type' => 'unlinkcab',
                            'icon' => 'sicon-unlink',
                            'label' => 'LBL_UNLINK_BUTTON',
                        ],
                    ],
                ],
            ],
        ],
        [
            'module' => 'Emails',
            'record_date' => 'date_sent',
            'fields' => [
                'name',
                'date_sent',
                'date_entered_by',
                'from_collection',
                'to_collection',
                'cc_collection',
                'bcc_collection',
                'description_html',
                'attachments_collection',
                'assigned_user_name',
                'state',
            ],
            'card_menu' => [
                [
                    'name' => 'reply_icon',
                    'type' => 'reply-action',
                    'tplName' => 'activity-card-emailaction',
                    'icon' => 'sicon-arrow-left',
                    'tooltip' => 'LBL_EMAIL_REPLY',
                ],
                [
                    'name' => 'reply_all_icon',
                    'type' => 'reply-all-action',
                    'tplName' => 'activity-card-emailaction',
                    'icon' => 'sicon-reply-all',
                    'tooltip' => 'LBL_EMAIL_REPLY_ALL',
                ],
                [
                    'name' => 'forward_icon',
                    'type' => 'forward-action',
                    'tplName' => 'activity-card-emailaction',
                    'icon' => 'sicon-arrow-right',
                    'tooltip' => 'LBL_EMAIL_FORWARD',
                ],
                [
                    'type' => 'focuscab',
                    'css_class' => 'dashboard-icon',
                    'icon' => 'sicon-focus-drawer',
                    'tooltip' => 'LBL_FOCUS_DRAWER_DASHBOARD',
                ],
            ],
        ],
        [
            'module' => 'Meetings',
            'record_date' => 'date_start',
            'fields' => [
                'name',
                'status',
                'duration',
                'type',
                'description',
                'invitees',
                'data_entered_by',
                'date_modified_by',
                'assigned_user_name',
            ],
            'card_menu' => [
                [
                    'type' => 'focuscab',
                    'css_class' => 'dashboard-icon',
                    'icon' => 'sicon-focus-drawer',
                    'tooltip' => 'LBL_FOCUS_DRAWER_DASHBOARD',
                ],
                [
                    'type' => 'cab_actiondropdown',
                    'buttons' => [
                        [
                            'type' => 'unlinkcab',
                            'icon' => 'sicon-unlink',
                            'label' => 'LBL_UNLINK_BUTTON',
                        ],
                    ],
                ],
            ],
        ],
        [
            'module' => 'Notes',
            'record_date' => 'date_entered',
            'fields' => [
                'name',
                'contact_name',
                'description',
                'filename',
                'date_entered_by',
                'date_modified_by',
                'assigned_user_name',
                'modified_by_name',
                'attachment_list',
                'portal_flag',
            ],
            'card_menu' => [
                [
                    'type' => 'focuscab',
                    'css_class' => 'dashboard-icon',
                    'icon' => 'sicon-focus-drawer',
                    'tooltip' => 'LBL_FOCUS_DRAWER_DASHBOARD',
                ],
                [
                    'type' => 'cab_actiondropdown',
                    'buttons' => [
                        [
                            'type' => 'unlinkcab',
                            'icon' => 'sicon-unlink',
                            'label' => 'LBL_UNLINK_BUTTON',
                        ],
                    ],
                ],
            ],
        ],
        [
            'module' => 'Tasks',
            'record_date' => 'date_due',
            'fields' => [
                'name',
                'description',
                'date_due',
                'date_entered_by',
                'created_by_name',
                'assigned_user_name',
                'status',
                'priority',
            ],
            'card_menu' => [
                [
                    'type' => 'focuscab',
                    'css_class' => 'dashboard-icon',
                    'icon' => 'sicon-focus-drawer',
                    'tooltip' => 'LBL_FOCUS_DRAWER_DASHBOARD',
                ],
                [
                    'type' => 'cab_actiondropdown',
                    'buttons' => [
                        [
                            'type' => 'unlinkcab',
                            'icon' => 'sicon-unlink',
                            'label' => 'LBL_UNLINK_BUTTON',
                        ],
                    ],
                ],
            ],
        ],
        [
            'module' => 'Audit',
            'record_date' => 'date_created',
            'fields' => [
                'assigned_user_id',
                'status',
            ],
        ],
    ],
    'custom_toolbar' => [
        'buttons' => [
            [
                'type' => 'actiondropdown',
                'no_default_action' => true,
                'icon' => 'sicon-plus',
                'buttons' => [
                    [
                        'type' => 'dashletaction',
                        'action' => 'composeEmail',
                        'params' => [
                            'link' => 'emails',
                            'module' => 'Emails',
                        ],
                        'label' => 'LBL_COMPOSE_EMAIL_BUTTON_LABEL2',
                        'acl_action' => 'create',
                        'acl_module' => 'Emails',
                    ],
                    [
                        'type' => 'dashletaction',
                        'action' => 'createRecord',
                        'params' => [
                            'link' => 'calls',
                            'module' => 'Calls',
                        ],
                        'label' => 'LBL_SCHEDULE_CALL2',
                        'acl_action' => 'create',
                        'acl_module' => 'Calls',
                    ],
                    [
                        'type' => 'dashletaction',
                        'action' => 'createRecord',
                        'params' => [
                            'link' => 'meetings',
                            'module' => 'Meetings',
                        ],
                        'label' => 'LBL_SCHEDULE_MEETING2',
                        'acl_action' => 'create',
                        'acl_module' => 'Meetings',
                    ],
                    [
                        'type' => 'dashletaction',
                        'action' => 'createRecord',
                        'params' => [
                            'link' => 'notes',
                            'module' => 'Notes',
                        ],
                        'label' => 'LBL_CREATE_NOTE_OR_ATTACHMENT2',
                        'acl_action' => 'create',
                        'acl_module' => 'Notes',
                    ],
                    [
                        'type' => 'dashletaction',
                        'action' => 'createRecord',
                        'params' => [
                            'link' => 'tasks',
                            'module' => 'Tasks',
                        ],
                        'label' => 'LBL_CREATE_TASK2',
                        'acl_action' => 'create',
                        'acl_module' => 'Tasks',
                    ],
                ],
            ],
            [
                'type' => 'dashletaction',
                'css_class' => 'dashlet-toggle btn btn-invisible minify',
                'icon' => 'sicon-chevron-up',
                'action' => 'toggleMinify',
                'tooltip' => 'LBL_DASHLET_MINIMIZE',
            ],
            [
                'dropdown_buttons' => [
                    [
                        'type' => 'dashletaction',
                        'action' => 'editClicked',
                        'label' => 'LBL_DASHLET_CONFIG_EDIT_LABEL',
                    ],
                    [
                        'type' => 'dashletaction',
                        'action' => 'reloadData',
                        'label' => 'LBL_DASHLET_REFRESH_LABEL',
                    ],
                    [
                        'type' => 'dashletaction',
                        'action' => 'removeClicked',
                        'label' => 'LBL_DASHLET_REMOVE_LABEL',
                        'name' => 'remove_button',
                    ],
                ],
            ],
        ],
    ],
];
