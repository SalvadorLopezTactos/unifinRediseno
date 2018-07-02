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

$viewdefs['base']['layout']['dupecheck'] = array(
    'components' =>
    array(
        array(
            'layout' => array(
                'type' => 'filterpanel',
                'span' => 12,
                'components' => array(
                    array(
                        'layout' => 'dupecheck-filter',
                        'name' => 'filter',
                        'targetEl' => '.filter',
                        'position' => 'prepend',
                        'components' => array(
                            array(
                                'view' => 'filter-quicksearch'
                            ),
                        )
                    ),
                    array(
                        'view' => 'filter-rows',
                        'targetEl' => '.filter-options'
                    ),
                    array(
                        'view' => 'filter-actions',
                        'targetEl' => '.filter-options'
                    ),
                )
            ),
            'name' => 'filterpanel'
        ),
        array(
            'name' => 'dupecheck-list',
            'view' => 'dupecheck-list',
            'primary' => true,
        ),
        array(
            'view' => 'list-bottom',
        ),
    ),
    'type' => 'dupecheck',
    'span' => 12,
);
