<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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

$module_name = 'pmse_Inbox';
$viewdefs[$module_name]['base']['layout']['reassignCases'] = array(
    'components' => array(
        array(
            'layout' => array(
                'components' => array(
                    array(
                        'layout' => array(
                            'components' => array(
                                array(
                                    'view' => 'reassignCases-headerpane',
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
                                        'availableToggles' => array(
//                                            array(
//                                                'name' => 'list',
//                                                'icon' => 'fa-table',
//                                                'label' => 'LBL_LISTVIEW',
//                                            ),
//                                            array(
//                                                'name' => 'activitystream',
//                                                'icon' => 'fa-clock-o',
//                                                'label' => 'LBL_ACTIVITY_STREAM',
//                                            ),
                                        ),
                                        'components' => array(
                                            array(
                                                'view' => 'casesList-filter',
                                                'targetEl' => '.filter',
                                                'position' => 'prepend'
                                            ),
//                                            array(
//                                                'layout' => 'filter',
//                                                'targetEl' => '.filter',
//                                                'position' => 'prepend'
//                                            ),
//                                            array(
//                                                'view' => 'filter-rows',
//                                                "targetEl" => '.filter-options'
//                                            ),
//                                            array(
//                                                'view' => 'filter-actions',
//                                                "targetEl" => '.filter-options'
//                                            ),
//                                            array(
//                                                'layout' => 'activitystream',
//                                                'context' => array(
//                                                    'module' => 'Activities',
//                                                ),
//                                            ),
                                            array(
                                                'layout' => 'reassignCases-list',
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
    'type' => 'reassignCases',
    'name' => 'base',
    'span' => 12,
);
