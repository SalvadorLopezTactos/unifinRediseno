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
                    [
                        [
                            'view' => [
                                'type' => 'dashlet-nestedset-list',
                                'label' => 'LBL_DASHLET_CATEGORIES_NAME',
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
                            'width' => 12,
                        ],
                    ],
                    [
                        [
                            'view' => [
                                'type' => 'kbs-dashlet-most-useful',
                                'label' => 'LBL_DASHLET_MOST_USEFUL_NAME',
                            ],
                            'context' => [
                                'module' => 'KBContents',
                            ],
                            'width' => 12,
                        ],
                    ],
                ],
                'width' => 12,
            ],
        ],
    ],
    'name' => 'LBL_KBCONTENTS_LIST_DASHBOARD',
];
