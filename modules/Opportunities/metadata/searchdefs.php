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
$searchdefs['Opportunities'] = [
    'templateMeta' => [
        'maxColumns' => '3',
        'maxColumnsBasic' => '4',
        'widths' => [
            'label' => '10',
            'field' => '30',
        ],
    ],
    'layout' => [
        'basic_search' => [
            'name' => [
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ],
            'current_user_only' => [
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ],

            ['name' => 'favorites_only', 'label' => 'LBL_FAVORITES_FILTER', 'type' => 'bool',],
            ['name' => 'open_only', 'label' => 'LBL_OPEN_ITEMS', 'type' => 'bool', 'default' => false, 'width' => '10%'],
        ],
        'advanced_search' => [
            'name' => [
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ],
            'account_name' => [
                'name' => 'account_name',
                'default' => true,
                'width' => '10%',
            ],
            'amount' => [
                'name' => 'amount',
                'default' => true,
                'width' => '10%',
            ],
            'assigned_user_id' => [
                'name' => 'assigned_user_id',
                'type' => 'enum',
                'label' => 'LBL_ASSIGNED_TO',
                'function' => [
                    'name' => 'get_user_array',
                    'params' => [
                        0 => false,
                    ],
                ],
                'default' => true,
                'width' => '10%',
            ],
            'sales_stage' => [
                'name' => 'sales_stage',
                'default' => true,
                'width' => '10%',
            ],
            'lead_source' => [
                'name' => 'lead_source',
                'default' => true,
                'width' => '10%',
            ],
            'date_closed' => [
                'name' => 'date_closed',
                'default' => true,
                'width' => '10%',
            ],
            'next_step' => [
                'type' => 'varchar',
                'label' => 'LBL_NEXT_STEP',
                'width' => '10%',
                'default' => true,
                'name' => 'next_step',
            ],

            [
                'width' => '10%',
                'label' => 'LBL_TEAMS',
                'default' => true,
                'name' => 'team_name',
            ],

            ['name' => 'favorites_only', 'label' => 'LBL_FAVORITES_FILTER', 'type' => 'bool',],
        ],
    ],

];
