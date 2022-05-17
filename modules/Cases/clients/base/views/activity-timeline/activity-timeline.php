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

$viewdefs['Cases']['base']['view']['activity-timeline'] = [
    'dashlets' => [
        [
            'label' => 'TPL_ACTIVITY_TIMELINE_DASHLET',
            'description' => 'LBL_ACTIVITY_TIMELINE_DASHLET_DESCRIPTION',
            'config' => ['module' => 'Cases'],
            'preview' => ['module' => 'Cases'],
            'filter' => [
                'view' => 'record',
                'module' => [
                    'Cases',
                ],
            ],
        ],
    ],
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
            ],
        ],
        [
            'module' => 'Emails',
            'record_date' => 'date_sent',
            'fields' => [
                'name',
                'date_sent',
                'from_collection',
                'to_collection',
                'cc_collection',
                'bcc_collection',
                'description_html',
                'attachments_collection',
                'assigned_user_name',
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
        ],
        [
            'module' => 'Messages',
            'record_date' => 'date_start',
            'fields' => [
                'name',
                'contact_name',
                'description',
                'direction',
                'date_start',
                'date_end',
                'conversation',
                'conversation_link',
                'assigned_user_name',
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
            ],
        ],
    ],
    'custom_toolbar' => [
        'buttons' => [
            [
                'type' => 'actiondropdown',
                'no_default_action' => true,
                'icon' => 'fa-plus',
                'buttons' => [
                    [
                        'type' => 'dashletaction',
                        'action' => 'composeEmail',
                        'params' => [
                            'link' => 'emails',
                            'module' => 'Emails',
                        ],
                        'label' => 'LBL_COMPOSE_EMAIL_BUTTON_LABEL',
                        'icon' => 'fa-plus',
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
                        'label' => 'LBL_SCHEDULE_CALL',
                        'icon' => 'fa-phone',
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
                        'label' => 'LBL_SCHEDULE_MEETING',
                        'icon' => 'fa-calendar',
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
                        'label' => 'LBL_CREATE_NOTE_OR_ATTACHMENT',
                        'icon' => 'fa-plus',
                        'acl_action' => 'create',
                        'acl_module' => 'Notes',
                    ],
                    [
                        'type' => 'dashletaction',
                        'action' => 'createRecord',
                        'params' => [
                            'link' => 'messages',
                            'module' => 'Messages',
                        ],
                        'label' => 'LBL_CREATE_MESSAGE',
                        'icon' => 'fa-comment',
                        'acl_action' => 'create',
                        'acl_module' => 'Messages',
                    ],
                ],
            ],
            [
                'type' => 'dashletaction',
                'css_class' => 'dashlet-toggle btn btn-invisible minify',
                'icon' => 'fa-chevron-up',
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
