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

return [
    'metadata' => [
        'components' => [
            [
                'rows' => [
                    // row 1
                    [
                        [
                            'view' => [
                                'type' => 'dashablerecord',
                                'module' => 'Accounts',
                                'tabs' => [
                                    [
                                        'active' => true,
                                        'label' => 'LBL_MODULE_NAME_SINGULAR',
                                        'link' => '',
                                        'module' => 'Accounts',
                                    ],
                                    [
                                        'active' => false,
                                        'link' => 'contacts',
                                        'module' => 'Contacts',
                                        'order_by' => [
                                            'field' => 'name',
                                            'direction' => 'desc',
                                        ],
                                        'limit' => 5,
                                        'fields' => [
                                            'name',
                                            'title',
                                            'email',
                                            'phone_work',
                                        ],
                                    ],
                                    [
                                        'active' => false,
                                        'link' => 'opportunities',
                                        'module' => 'Opportunities',
                                        'order_by' => [
                                            'field' => 'date_closed',
                                            'direction' => 'desc',
                                        ],
                                        'limit' => 5,
                                        'fields' => [
                                            'name',
                                            'sales_status',
                                            'amount',
                                            'date_closed',
                                        ],
                                    ],
                                    [
                                        'active' => false,
                                        'link' => 'quotes',
                                        'module' => 'Quotes',
                                        'order_by' => [
                                            'field' => 'date_quote_expected_closed',
                                            'direction' => 'desc',
                                        ],
                                        'limit' => 5,
                                        'fields' => [
                                            'name',
                                            'quote_stage',
                                            'date_quote_expected_closed',
                                            'total',
                                        ],
                                    ],
                                ],
                                'tab_list' => [
                                    'Accounts',
                                    'contacts',
                                    'opportunities',
                                    'quotes',
                                ],
                            ],
                            'context' => [
                                'module' => 'Accounts',
                             ],
                            'width' => 6,
                        ],
                        [
                            'view' => [
                                'type' => 'commentlog-dashlet',
                                'label' => 'LBL_DASHLET_COMMENTLOG_NAME',
                            ],
                            'width' => 6,
                        ],
                    ],
                    // row 2
                    [
                        [
                            'view' => [
                                'type' => 'active-subscriptions',
                                'label' => 'LBL_ACTIVE_SUBSCRIPTIONS_DASHLET',
                            ],
                            'width' => 6,
                        ],
                        [
                            'view' => [
                                'type' => 'activity-timeline',
                                'label' => 'TPL_ACTIVITY_TIMELINE_DASHLET',
                                'module' => 'Accounts',
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
                            ],
                            'context' => [
                                'module' => 'Accounts',
                            ],
                            'width' => 6,
                        ],
                    ],
                ],
                'width' => 12,
            ],
        ],
    ],
    'name' => 'LBL_ACCOUNTS_MULTI_LINE_DASHBOARD',
    'id' => 'd8f610a0-e950-11e9-81b4-2a2ae2dbcce4',
];
