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
$viewdefs['CJ_Forms']['mobile']['view']['list'] = [
    'panels' => [
        [
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => [
                [
                    'name' => 'name',
                    'label' => 'LBL_NAME',
                    'default' => true,
                    'enabled' => true,
                    'link' => true,
                ],
                [
                    'name' => 'main_trigger_type',
                    'label' => 'LBL_MAIN_TRIGGER_TYPE',
                    'default' => true,
                    'enabled' => true,
                ],
                [
                    'name' => 'date_modified',
                    'label' => 'LBL_DATE_MODIFIED',
                    'enabled' => true,
                    'default' => true,
                    'readonly' => true,
                ],
                [
                    'name' => 'date_entered',
                    'label' => 'LBL_DATE_ENTERED',
                    'enabled' => true,
                    'default' => true,
                    'readonly' => true,
                ],
                [
                    'name' => 'team_name',
                    'label' => 'LBL_TEAM',
                    'width' => 9,
                    'default' => true,
                    'enabled' => true,
                ],
            ],
        ],
    ],
];
