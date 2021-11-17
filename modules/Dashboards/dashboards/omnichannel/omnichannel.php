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
        'buttons' => [
            [
                'name' => 'clear',
                'type' => 'button',
                'label' => 'LBL_CLOSE_BUTTON_LABEL',
                'css_class' => 'btn btn-primary clear-button hidden',
                'events' => [
                    'click' => 'button:clear_button:click',
                ],
            ],
        ],
        'tabs' => [
            // TAB 1
            [
                'icon' => [
                    'image' => '<i class="fa fa-search"></i>',
                ],
                'name' => 'LBL_SEARCH',
                'dashlets' => [
                    [
                        'view' => [
                            'type' => 'dashlet-console-list',
                            'module' => 'Contacts',
                        ],
                        'context' => [
                            'module' => 'Contacts',
                        ],
                        'width' => 12,
                        'height' => 8,
                        'x' => 0,
                        'y' => 0,
                        'autoPosition' => false,
                    ],
                    [
                        'view' => [
                            'type' => 'dashlet-console-list',
                            'module' => 'Cases',
                        ],
                        'context' => [
                            'module' => 'Cases',
                        ],
                        'width' => 12,
                        'height' => 8,
                        'x' => 0,
                        'y' => 8,
                        'autoPosition' => false,
                    ],
                ],
            ],
            // TAB 2
            [
                'icon' => [
                    'module' => 'Contacts',
                ],
                'name' => 'LBL_CONTACT',
                'dashlets' => [
                    [
                        'view' => [
                            'type' => 'dashablerecord',
                            'module' => 'Contacts',
                            'tabs' => [
                                [
                                    'active' => true,
                                    'label' => 'LBL_MODULE_NAME_SINGULAR',
                                    'link' => '',
                                    'module' => 'Contacts',
                                ],
                                [
                                    'active' => false,
                                    'label' => 'LBL_MODULE_NAME_SINGULAR',
                                    'link' => 'accounts',
                                    'module' => 'Accounts',
                                ],
                            ],
                            'tab_list' => [
                                'Contacts',
                                'accounts',
                            ],
                        ],
                        'context' => [
                            'module' => 'Contacts',
                        ],
                        'width' => 6,
                        'height' => 8,
                        'x' => 0,
                        'y' => 0,
                        'autoPosition' => false,
                    ],
                    [
                        'view' => [
                            'type' => 'dashlet-searchable-kb-list',
                            'label' => 'LBL_DASHLET_KB_SEARCH_NAME',
                            'data_provider' => 'Categories',
                            'config_provider' => 'KBContents',
                            'root_name' => 'category_root',
                            'extra_provider' => [
                                'module' => 'KBContents',
                                'field' => 'category_id',
                            ],
                        ],
                        'context' => [
                            'module' => 'KBContents',
                        ],
                        'width' => 6,
                        'height' => 8,
                        'x' => 6,
                        'y' => 0,
                        'autoPosition' => false,
                    ],
                    [
                        'view' => [
                            'type' => 'dashlet-console-list',
                            'module' => 'Cases',
                        ],
                        'context' => [
                            'module' => 'Cases',
                        ],
                        'width' => 6,
                        'height' => 8,
                        'x' => 0,
                        'y' => 8,
                        'autoPosition' => false,
                    ],
                    [
                        'view' => [
                            'type' => 'activity-timeline',
                            'label' => 'TPL_ACTIVITY_TIMELINE_DASHLET',
                            'module' => 'Contacts',
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
                                        'css_class' => 'btn btn-invisible dashlet-toggle minify',
                                        'icon' => 'fa-chevron-up',
                                        'action' => 'toggleMinify',
                                        'tooltip' => 'LBL_DASHLET_TOGGLE',
                                        'disallowed_layouts' => [
                                            [
                                                'name' => 'omnichannel-dashboard',
                                            ],
                                        ],
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
                                                'disallowed_layouts' => [
                                                    [
                                                        'name' => 'omnichannel-dashboard',
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'context' => [
                            'module' => 'Contacts',
                        ],
                        'width' => 6,
                        'height' => 8,
                        'x' => 6,
                        'y' => 8,
                        'autoPosition' => false,
                    ],
                ],
            ],
            // TAB 3
            [
                'icon' => [
                    'module' => 'Cases',
                ],
                'name' => 'LBL_CASE',
                'dashlets' => [
                    [
                        'view' => [
                            'type' => 'dashablerecord',
                            'module' => 'Cases',
                            'tabs' => [
                                [
                                    'active' => true,
                                    'label' => 'LBL_MODULE_NAME_SINGULAR',
                                    'link' => '',
                                    'module' => 'Cases',
                                ],
                                [
                                    'active' => false,
                                    'link' => 'tasks',
                                    'module' => 'Tasks',
                                    'order_by' => [
                                        'field' => 'date_entered',
                                        'direction' => 'desc',
                                    ],
                                    'limit' => 5,
                                    'fields' => [
                                        'name',
                                        'assigned_user_name',
                                        'date_entered',
                                    ],
                                ],
                                [
                                    'active' => false,
                                    'link' => 'contacts',
                                    'module' => 'Contacts',
                                    'order_by' => [
                                        'field' => 'date_entered',
                                        'direction' => 'desc',
                                    ],
                                    'limit' => 5,
                                    'fields' => [
                                        'name',
                                        'assigned_user_name',
                                        'date_entered',
                                    ],
                                ],
                                [
                                    'active' => false,
                                    'link' => 'documents',
                                    'module' => 'Documents',
                                    'order_by' => [
                                        'field' => 'active_date',
                                        'direction' => 'desc',
                                    ],
                                    'limit' => 5,
                                    'fields' => [
                                        'document_name',
                                        'active_date',
                                    ],
                                ],
                            ],
                            'tab_list' => [
                                'Cases',
                                'tasks',
                                'contacts',
                                'documents',
                            ],
                        ],
                        'context' => [
                            'module' => 'Cases',
                        ],
                        'width' => 6,
                        'height' => 8,
                        'x' => 0,
                        'y' => 0,
                        'autoPosition' => false,
                    ],
                    [
                        'view' => [
                            'type' => 'dashablerecord',
                            'module' => 'Accounts',
                            'tabs' => [
                                [
                                    'module' => 'Accounts',
                                    'link' => 'accounts',
                                ],
                            ],
                            'tab_list' => [
                                'accounts',
                            ],
                        ],
                        'context' => [
                            'module' => 'Cases',
                        ],
                        'width' => 6,
                        'height' => 8,
                        'x' => 0,
                        'y' => 8,
                        'autoPosition' => false,
                    ],
                    [
                        'view' => [
                            'type' => 'dashlet-searchable-kb-list',
                            'label' => 'LBL_DASHLET_KB_SEARCH_NAME',
                            'data_provider' => 'Categories',
                            'config_provider' => 'KBContents',
                            'root_name' => 'category_root',
                            'extra_provider' => [
                                'module' => 'KBContents',
                                'field' => 'category_id',
                            ],
                        ],
                        'context' => [
                            'module' => 'KBContents',
                        ],
                        'width' => 6,
                        'height' => 6,
                        'x' => 6,
                        'y' => 0,
                        'autoPosition' => false,
                    ],
                    [
                        'view' => [
                            'type' => 'commentlog-dashlet',
                            'label' => 'LBL_DASHLET_COMMENTLOG_NAME',
                        ],
                        'context' => [
                            'module' => 'Cases',
                        ],
                        'width' => 6,
                        'height' => 5,
                        'x' => 6,
                        'y' => 6,
                        'autoPosition' => false,
                    ],
                    [
                        'view' => [
                            'type' => 'activity-timeline',
                            'label' => 'TPL_ACTIVITY_TIMELINE_DASHLET',
                            'module' => 'Cases',
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
                                        'css_class' => 'btn btn-invisible dashlet-toggle minify',
                                        'icon' => 'fa-chevron-up',
                                        'action' => 'toggleMinify',
                                        'tooltip' => 'LBL_DASHLET_TOGGLE',
                                        'disallowed_layouts' => [
                                            [
                                                'name' => 'omnichannel-dashboard',
                                            ],
                                        ],
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
                                                'disallowed_layouts' => [
                                                    [
                                                        'name' => 'omnichannel-dashboard',
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'context' => [
                            'module' => 'Cases',
                        ],
                        'width' => 6,
                        'height' => 5,
                        'x' => 6,
                        'y' => 11,
                        'autoPosition' => false,
                    ],
                ],
            ],
        ],
    ],
    'name' => 'LBL_OMNICHANNEL_DASHBOARD',
    'id' => '32bc5cd0-b1a0-11ea-ad16-f45c898a3ce7',
];
