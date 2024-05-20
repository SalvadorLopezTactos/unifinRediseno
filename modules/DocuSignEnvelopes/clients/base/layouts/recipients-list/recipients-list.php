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

$viewdefs['DocuSignEnvelopes']['base']['layout']['recipients-list'] = [
    'css_class'=> 'flex-list-layout flex flex-column h-full',
    'components' => [
        [
            'layout' => [
                'type' => 'default',
                'name' => 'sidebar',
                'css_class' => 'h-full',
                'components' => [
                    [
                        'layout' => [
                            'type' => 'base',
                            'name' => 'main-pane',
                            'css_class' => 'main-pane span8 flex flex-column',
                            'components' => [
                                [
                                    'view' => 'recipient-selection-headerpane',
                                ],
                                [
                                    'layout' => [
                                        'css_class' => 'flex flex-column h-full',
                                        'type' => 'filterpanel',
                                        'availableToggles' => [],
                                        'filter_options' => [
                                            'stickiness' => false,
                                        ],
                                        'components' => [
                                            [
                                                'view' => 'selection-list-context',
                                            ],
                                            [
                                                'layout' => [
                                                    'css_class' => 'paginated-flex-list',
                                                    'components' => [
                                                        [
                                                            'view' => 'recipients-list',
                                                            'primary' => true,
                                                        ],
                                                        [
                                                            'view' => [
                                                                'name' => 'list-pagination',
                                                                'css_class' => 'flex-table-pagination',
                                                            ],
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
