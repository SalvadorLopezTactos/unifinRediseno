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

$viewdefs['base']['view']['active-subscriptions'] = [
    'dashlets' => [
        [
            'label' => 'LBL_ACTIVE_SUBSCRIPTIONS_DASHLET',
            'description' => 'LBL_ACTIVE_SUBSCRIPTIONS_DASHLET_DESCRIPTION',
            'config' => [],
            'preview' => [],
            'filter' => [
                'view' => 'record',
                'module' => [
                    'Accounts',
                ],
            ],
        ],
    ],
    'fields' => [
        'name',
        'quantity',
        'total_amount',
        'currency_id',
        'base_rate',
        'service_start_date',
        'service_end_date',
        'service_duration_value',
        'service_duration_unit',
    ],
];
