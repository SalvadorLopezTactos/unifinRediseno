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

$viewdefs['Dashboards']['base']['view']['dashboard-fab'] = [
    'icon' => 'fab-icon',
    'buttons' => [
        [
            'name' => 'add_button',
            'type' => 'rowaction',
            'icon' => 'new-dashboard-icon',
            'label' => 'LBL_DASHBOARD_CREATE',
            'showOn' => 'view',
            'disallowed_layouts' => [
                [
                    'name' => 'dashboard', // omnichannel-console-config
                    'id' => '32bc5cd0-b1a0-11ea-ad16-f45c898a3ce7',
                ],
            ],
        ], [
            'name' => 'edit_module_tabs_button',
            'type' => 'rowaction',
            'icon' => 'edit-icon',
            'label' => 'LBL_EDIT_MODULE_TABS_BUTTON',
            'acl_action' => 'edit',
            'showOn' => 'view',
            'allowed_layouts' => [
                [
                    'name' => 'dashboard', // service console
                    'id' => 'c108bb4a-775a-11e9-b570-f218983a1c3e',
                ], [
                    'name' => 'dashboard', // renewals console
                    'type' => 'renewals_console',
                ],
            ],
        ], [
            'name' => 'duplicate_button',
            'type' => 'rowaction',
            'icon' => 'duplicate-dashboard-icon',
            'label' => 'LBL_DASHBOARD_DUPLICATE',
            'acl_module' => 'Dashboards',
            'acl_action' => 'create',
            'showOn' => 'view',
            'disallowed_layouts' => [
                [
                    'name' => 'dashboard', // service console
                    'id' => 'c108bb4a-775a-11e9-b570-f218983a1c3e',
                ], [
                    'name' => 'dashboard', // renewals console
                    'type' => 'renewals_console',
                ], [
                    'name' => 'dashboard', // omnichannel-console-config
                    'id' => '32bc5cd0-b1a0-11ea-ad16-f45c898a3ce7',
                ],
            ],
        ], [
            'name' => 'delete_button',
            'type' => 'rowaction',
            'icon' => 'delete-dashboard',
            'label' => 'LBL_DASHBOARD_DELETE',
            'acl_action' => 'delete',
            'showOn' => 'view',
            'disallowed_layouts' => [
                [
                    'name' => 'dashboard',
                    'id' => 'c108bb4a-775a-11e9-b570-f218983a1c3e',
                ], [
                    'name' => 'dashboard',
                    'type' => 'renewals_console',
                ], [
                    'name' => 'dashboard', // omnichannel-console-config
                    'id' => '32bc5cd0-b1a0-11ea-ad16-f45c898a3ce7',
                ],
            ],
        ], [
            'name' => 'collapse_button',
            'type' => 'rowaction',
            'icon' => 'collapse-dashlets',
            'label' => 'LBL_DASHLET_MINIMIZE_ALL',
            'showOn' => 'view',
            'disallowed_layouts' => [
                [
                    'name' => 'dashboard',
                    'id' => 'c108bb4a-775a-11e9-b570-f218983a1c3e',
                ], [
                    'name' => 'dashboard',
                    'type' => 'renewals_console',
                ], [
                    'name' => 'dashboard', // omnichannel-console-config
                    'id' => '32bc5cd0-b1a0-11ea-ad16-f45c898a3ce7',
                ],
            ],
        ], [
            'name' => 'expand_button',
            'type' => 'rowaction',
            'icon' => 'expand-dashlets',
            'label' => 'LBL_DASHLET_MAXIMIZE_ALL',
            'showOn' => 'view',
            'disallowed_layouts' => [
                [
                    'name' => 'dashboard',
                    'id' => 'c108bb4a-775a-11e9-b570-f218983a1c3e',
                ], [
                    'name' => 'dashboard',
                    'type' => 'renewals_console',
                ], [
                    'name' => 'dashboard', // omnichannel-console-config
                    'id' => '32bc5cd0-b1a0-11ea-ad16-f45c898a3ce7',
                ],
            ],
        ], [
            'name' => 'restore_tab_button',
            'type' => 'rowaction',
            'icon' => 'restore-icon',
            'label' => 'LBL_RESTORE_TAB_DEFAULT',
            'showOn' => 'view',
            'allowed_layouts' => [
                [
                    'name' => 'dashboard', // omnichannel-console-config
                    'id' => '32bc5cd0-b1a0-11ea-ad16-f45c898a3ce7',
                ],
            ],
        ], [
            'name' => 'configure_summary_button',
            'type' => 'rowaction',
            'icon' => 'edit-icon',
            'label' => 'LBL_CONFIGURE_SUMMARY_PANEL',
            'showOn' => 'view',
            'allowed_layouts' => [
                [
                    'name' => 'dashboard', // omnichannel-console-config
                    'id' => '32bc5cd0-b1a0-11ea-ad16-f45c898a3ce7',
                ],
            ],
        ], [
            'name' => 'add_dashlet_button',
            'type' => 'rowaction',
            'icon' => 'add-dashlet-icon',
            'label' => 'LBL_ADD_DASHLET_BUTTON',
            'events' => [
                'click' => 'button:add_dashlet_button:click',
            ],
            'acl_action' => 'edit',
            'showOn' => 'view',
        ],
    ],
];
