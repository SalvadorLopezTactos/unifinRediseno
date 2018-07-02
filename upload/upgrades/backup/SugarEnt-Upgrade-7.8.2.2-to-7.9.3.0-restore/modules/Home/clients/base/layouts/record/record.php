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

$viewdefs['Home']['base']['layout']['record'] = array(
    'type' => 'dashboard',
    'name' => 'dashboard',
    'components' => array(
        array(
            'layout' => array(
                'type' => 'base',
                'name' => 'list',
                'components' => array(
                    array(
                        'view' => 'dashboard-headerpane',
                    ),
                    array(
                        'layout' => 'dashlet-main',
                    ),
                ),
            ),
        ),
    ),
    'method' => 'record',
    'last_state' => array(
        'id' => 'last-visit',
    )
);

