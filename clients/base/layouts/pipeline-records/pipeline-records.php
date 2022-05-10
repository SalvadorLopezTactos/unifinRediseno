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

$viewdefs['base']['layout']['pipeline-records'] = array(
    'components' => array(
        array(
            'layout' => array(
                'components' => array(
                    array(
                        'layout' => array(
                            'components' => array(
                                array(
                                    'view' => 'pipeline-headerpane',
                                ),
                                array(
                                    'layout' => array(
                                        'type' => 'filterpanel',
                                        'span' => 12,
                                        'last_state' => array(
                                            'id' => 'list-filterpanel',
                                            'defaults' => array(
                                                'toggle-view' => 'list',
                                            ),
                                        ),
                                        'refresh_button' => true,
                                        'css_class' => 'pipeline-refresh-btn',
                                        'components' => array(
                                            array(
                                                'layout' => array(
                                                    'components' =>
                                                        array(
                                                            array(
                                                                'view' => 'filter-module-dropdown',
                                                            ),
                                                            array(
                                                                'view' => 'filter-filter-dropdown',
                                                            ),
                                                            array(
                                                                'view' => 'filter-quicksearch',
                                                            ),
                                                        ),
                                                    'type' => 'pipeline-filter',
                                                    'name' =>'filter',
                                                    'last_state' => array(
                                                        'id' => 'filter',
                                                    ),
                                                ),
                                            ),
                                            array(
                                                'view' => 'filter-rows',
                                            ),
                                            array(
                                                'view' => 'filter-actions',
                                            ),
                                            array(
                                                'view' => 'pipeline-recordlist-content',
                                                'primary'=>true,
                                            ),
                                            array(
                                                'layout' => array(
                                                    'name' => 'side-drawer',
                                                    'type' => 'side-drawer',
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'type' => 'simple',
                            'name' => 'main-pane',
                            'css_class' => 'main-pane span12',
                            'span' => 6,
                        ),
                    ),
                ),
            ),
        ),
    ),
    'type' => 'pipeline-records',
    'name' => 'base',
    'span' => 12,
);
