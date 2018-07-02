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

$viewdefs['base']['layout']['asdashlet-filter'] = array(
    'components' => array(
        array(
            'layout' => array(
                'type' => 'filterpanel',
                'meta' => array(
                    'availableToggles' => array(
                        array(
                            'name' => 'activitystream',
                            'icon' => 'fa-clock-o',
                            'label' => 'LBL_ACTIVITY_STREAM',
                        ),
                    ),
                    'components' => array(
                        array(
                            'layout' => array(
                                'meta' => array(
                                    'components' => array(
                                        array(
                                            'view' => 'filter-filter-dropdown'
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
                            'position' => 'prepend'
                        ),
                        array(
                            'view' => 'filter-rows',
                            'targetEl' => '.filter-options',
                        ),
                        array(
                            'view' => 'filter-actions',
                            'targetEl' => '.filter-options',
                        ),
                    ),
                ),
            ),
            'context' => array(
                'module' => 'Activities',
            ),
        ),
    ),
    'name' => 'asdashlet-filter',
    'span' => 12,
);
