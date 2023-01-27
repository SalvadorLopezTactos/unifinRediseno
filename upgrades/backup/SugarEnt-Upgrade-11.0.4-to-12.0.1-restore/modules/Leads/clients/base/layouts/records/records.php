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

$viewdefs['Leads']['base']['layout']['records'] = array(
    'components' => array(
        array(
            'layout' => array(
                'type' => 'default',
                'name' => 'sidebar',
                'components' => array(
                    array(
                        'layout' => array(
                            'type' => 'base',
                            'name' => 'main-pane',
                            'css_class' => 'main-pane span8',
                            'components' => array(
                                array(
                                    'view' => 'list-headerpane',
                                ),
                                array(
                                    'layout' => array(
                                        'type' => 'filterpanel',
                                        'last_state' => array(
                                            'id' => 'list-filterpanel',
                                            'defaults' => array(
                                                'toggle-view' => 'list',
                                            ),
                                        ),
                                        'refresh_button' => true,
                                        'css_class' => 'pipeline-refresh-btn',
                                        'availableToggles' => array(
                                            array(
                                                'name' => 'pipeline',
                                                'icon' => 'fa-align-left',
                                                'label' => 'LBL_PIPELINE_VIEW_BTN',
                                                'css_class' => 'pipeline-view-button',
                                                'route' => 'pipeline',
                                            ),
                                            array(
                                                'name' => 'list',
                                                'icon' => 'fa-table',
                                                'label' => 'LBL_LISTVIEW',
                                            ),
                                            array(
                                                'name' => 'activitystream',
                                                'icon' => 'fa-clock-o',
                                                'label' => 'LBL_ACTIVITY_STREAM',
                                            ),
                                        ),
                                        'components' => array(
                                            array(
                                                'layout' => 'filter',
                                                'loadModule' => 'Filters',
                                            ),
                                            array(
                                                'view' => 'filter-rows',
                                            ),
                                            array(
                                                'view' => 'filter-actions',
                                            ),
                                            array(
                                                'layout' => 'activitystream',
                                                'context' => array(
                                                    'module' => 'Activities',
                                                ),
                                            ),
                                            array(
                                                'layout' => 'list',
                                            ),
                                            array(
                                                'layout' => 'pipeline',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    array(
                        'layout' => array(
                            'type' => 'tabbed-layout',
                            'name' => 'dashboard-pane',
                            'label' => 'LBL_DASHBOARD',
                            'css_class' => 'dashboard-pane',
                            'notabs' => true,
                            'components' => array(
                                array(
                                    'layout' => array(
                                        'type' => 'base',
                                        'label' => 'LBL_DASHBOARD',
                                        'css_class' => 'dashboard-pane',
                                        'components' => array(
                                            array(
                                                'layout' => array(
                                                    'label' => 'LBL_DASHBOARD',
                                                    'type' => 'dashboard',
                                                    'last_state' => array(
                                                        'id' => 'last-visit',
                                                    ),
                                                ),
                                                'context' => array(
                                                    'forceNew' => true,
                                                    'module' => 'Home',
                                                ),
                                                'loadModule' => 'Dashboards',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    array(
                        'layout' => array(
                            'type' => 'tabbed-layout',
                            'name' => 'preview-pane',
                            'label' => 'LBL_PREVIEW',
                            'css_class' => 'preview-pane',
                            'notabs' => true,
                            'components' => array(
                                array(
                                    'layout' => 'preview',
                                    'xmeta' => array(
                                        'editable' => true,
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
