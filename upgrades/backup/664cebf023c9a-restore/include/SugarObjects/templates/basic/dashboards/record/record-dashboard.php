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
        'dashlets' => [
            [
                'view' => [
                    'type' => 'dashablelist',
                    'label' => 'LBL_HOMEPAGE_TITLE',
                    'filter_id' => 'assigned_to_me',
                ],
                'context' => [
                    'module' => '<module_name>',
                ],
                'width' => 12,
                'x' => 0,
                'y' => 0,
            ],
            [
                'view' => [
                    'type' => 'commentlog-dashlet',
                    'label' => 'LBL_DASHLET_COMMENTLOG_NAME',
                ],
                'width' => 12,
                'x' => 0,
                'y' => 6,
            ],
        ],
    ],
    'name' => 'LBL_<MODULE_NAME>_RECORD_DASHBOARD',
];
