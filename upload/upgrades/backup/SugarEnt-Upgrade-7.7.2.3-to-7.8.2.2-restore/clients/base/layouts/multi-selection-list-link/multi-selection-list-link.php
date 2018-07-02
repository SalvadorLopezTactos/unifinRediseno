<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

$viewdefs['base']['layout']['multi-selection-list-link'] = array(
    'components' => array(
        array(
            'layout' => array(
                'components' => array(
                    array(
                        'layout' => array(
                            'components' => array(
                                array(
                                    'view' => 'selection-headerpane',
                                ),
                                array(
                                    'view' => 'selection-list-context',
                                ),
                                array(
                                    'layout' => array(
                                        'type' => 'filterpanel',
                                        'span' => 12,
                                        'availableToggles' => array(),
                                        'filter_options' => array(
                                            'stickiness' => false,
                                        ),
                                        'components' => array(
                                            array(
                                                'layout' => array(
                                                    'meta' => array(
                                                        'components' => array(
                                                            array(
                                                                'view' => 'filter-filter-dropdown'
                                                            ),
                                                            array(
                                                                'view' => 'filter-quicksearch'
                                                            ),
                                                        ),
                                                        'last_state' => array(
                                                            'id' => 'filter',
                                                        ),
                                                        'layoutType' => 'records',
                                                    ),
                                                    'span' => 12,
                                                    'type' =>'filter',
                                                ),
                                                'targetEl' => '.filter',
                                                'position' => 'prepend',
                                            ),
                                            array(
                                                'view' => 'filter-rows',
                                                'targetEl' => '.filter-options'
                                            ),
                                            array(
                                                'view' => 'filter-actions',
                                                'targetEl' => '.filter-options'
                                            ),
                                            array(
                                                'view' => 'mass-link',
                                            ),
                                            array(
                                                'view' => 'multi-selection-list-link',
                                            ),
                                            array(
                                                'view' => 'list-bottom',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'type' => 'simple',
                            'name' => 'main-pane',
                            'span' => 8,
                        ),
                    ),
                    array(
                        'layout' => array(
                            'components' => array(),
                            'type' => 'simple',
                            'name' => 'dashboard-pane',
                            'span' => 4,
                        ),
                    ),
                    array(
                        'layout' => array(
                            'components' => array(
                                array(
                                    'layout' => 'preview',
                                ),
                            ),
                            'type' => 'simple',
                            'name' => 'preview-pane',
                            'span' => 8,
                        ),
                    ),
                ),
                'type' => 'default',
                'name' => 'sidebar',
                'span' => 12,
            ),
        ),
    ),
    'type' => 'multi-selection-list-link',
    'name' => 'base',
    'span' => 12,
);
