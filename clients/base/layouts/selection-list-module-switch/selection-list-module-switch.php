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

$viewdefs['base']['layout']['selection-list-module-switch'] = array(
    'css_class'=> 'flex-list-layout flex flex-column h-full',
    'components' => array(
        array(
            'layout' => array(
                'type' => 'default',
                'name' => 'sidebar',
                'css_class' => 'h-full',
                'components' => array(
                    array(
                        'layout' => array(
                            'type' => 'base',
                            'name' => 'main-pane',
                            'css_class' => 'main-pane span8 flex flex-column',
                            'components' => array(
                                array(
                                    'view' => 'selection-headerpane',
                                ),
                                array(
                                    'layout' => array(
                                        'css_class' => 'flex flex-column h-full',
                                        'type' => 'filterpanel',
                                        'availableToggles' => array(),
                                        'filter_options' => array(
                                            'stickiness' => false,
                                        ),
                                        'components' => array(
                                            array(
                                                'layout' => 'filter',
                                                'loadModule' => 'Filters',
                                                'xmeta' => array(
                                                    'components' => array(
                                                        array(
                                                            'view' => 'filter-module-dropdown-selection-list',
                                                        ),
                                                        array(
                                                            'view' => 'filter-filter-dropdown',
                                                        ),
                                                        array(
                                                            'view' => 'filter-quicksearch',
                                                        ),
                                                    ),
                                                ),
                                            ),
                                            array(
                                                'view' => 'filter-rows',
                                            ),
                                            array(
                                                'view' => 'filter-actions',
                                            ),
                                            [
                                                'layout' => [
                                                    'css_class' => 'paginated-flex-list',
                                                    'components' => [
                                                        [
                                                            'view' => 'selection-list',
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
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    array(
                        'layout' => array(
                            'type' => 'base',
                            'name' => 'preview-pane',
                            'css_class' => 'preview-pane',
                            'components' => array(
                                array(
                                    'layout' => 'preview',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
