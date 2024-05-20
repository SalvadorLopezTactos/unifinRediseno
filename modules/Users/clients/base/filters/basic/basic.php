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

$viewdefs['Users']['base']['filter']['basic'] = [
    'filters' => [
        [
            'id' => 'all_records',
            'name' => 'LBL_LISTVIEW_FILTER_ALL',
            'filter_definition' => [],
            'editable' => false,
        ],
        [
            'id' => 'missing_customer_journey_access',
            'name' => 'LBL_FILTER_MISSING_CUSTOMER_JOURNEY_ACCESS',
            'filter_definition' => [
                '$and' => [
                    [
                        '$or' => [
                            ['customer_journey_access' => 0],
                            ['customer_journey_access' => ['$is_null' => 1]],
                        ],
                    ],
                    [
                        '$or' => [
                            ['is_group' => 0],
                            ['is_group' => ['$is_null' => 1]],
                        ],
                    ],
                    [
                        '$or' => [
                            ['portal_only' => 0],
                            ['portal_only' => ['$is_null' => 1]],
                        ],
                    ],
                ],
                'status' => 'Active',
            ],
            'editable' => false,
            'is_template' => true,
        ],
    ],
];
