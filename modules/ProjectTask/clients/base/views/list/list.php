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
$viewdefs['ProjectTask']['base']['view']['list'] = [
    'panels' => [
        [
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => [
                [
                    'label' => 'LBL_LIST_NAME',
                    'enabled' => true,
                    'default' => true,
                    'readonly' => true,
                    'name' => 'name',
                    'link' => true,
                ],
                [
                    'label' => 'LBL_PROJECT_NAME',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'project_name',
                    'id' => 'project_id',
                    'link' => true,
                ],
                [
                    'label' => 'LBL_DATE_START',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'date_start',
                ],
                [
                    'label' => 'LBL_DATE_FINISH',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'date_finish',
                ],
                [
                    'label' => 'LBL_LIST_PRIORITY',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'priority',
                ],
                [
                    'label' => 'LBL_LIST_PERCENT_COMPLETE',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'percent_complete',
                ],
                [
                    'name' => 'assigned_user_name',
                    'target_record_key' => 'assigned_user_id',
                    'target_module' => 'Employees',
                    'label' => 'LBL_ASSIGNED_TO_NAME',
                    'enabled' => true,
                    'default' => true,
                ],
            ],
        ],
    ],
];
