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

$viewdefs['base']['layout']['row-model-data'] = array(
    'components' => array(
        array(
            'layout' => array(
                'type' => 'base',
                'name' => 'row-model-data',
                'css_class' => 'row-model-data dashboard-pane',
                'components' => array(
                    array(
                        'layout' => 'dashboard',
                        'loadModule' => 'Dashboards',
                    ),
                ),
            ),
        ),
    ),
);
