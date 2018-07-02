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

$viewdefs['Home']['base']['layout']['record'] = array(
    'components' =>
    array(
        array(
            'layout' =>
            array(
                'components' =>
                array(
                    array(
                        'view' => 'dashboard-headerpane',
                    ),
                    array(
                        'layout' => 'dashlet-main',
                    ),
                ),
                'type' => 'simple',
                'name' => 'list',
                'span' => 12,
            ),
        ),
    ),
    'type' => 'dashboard',
    'span' => 12,
    'method' => 'record',
    'last_state' => array(
        'id' => 'last-visit',
    )
);

