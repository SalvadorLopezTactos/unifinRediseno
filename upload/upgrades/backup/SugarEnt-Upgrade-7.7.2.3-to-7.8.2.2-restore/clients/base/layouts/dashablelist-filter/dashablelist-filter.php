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

$viewdefs['base']['layout']['dashablelist-filter'] = array(
    'components' => array(
        array(
            'layout' => array(
                'type' =>'filterpanel',
                'meta' => array(
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
                            'targetEl' => '.filter-options'
                        ),
                        array(
                            'view' => 'filter-actions',
                            'targetEl' => '.filter-options'
                        ),
                    ),
                    'filter_options' => array(
                        'auto_apply' => false,
                        'stickiness' => false,
                        'show_actions' => false,
                    ),
                ),
            ),
        ),
    ),
    'name' => 'dashablelist-filter',
    'span' => 12,
);
