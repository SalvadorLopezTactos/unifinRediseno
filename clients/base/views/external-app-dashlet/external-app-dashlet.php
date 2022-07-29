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

$viewdefs['base']['view']['external-app-dashlet'] = array(
    'dashlets' => array(
        array(
            'label' => 'LBL_SUGAR_APPS_DASHLET_LABEL',
            'description' => 'LBL_SUGAR_APPS_DASHLET_DESC',
            'config' => array(
                'src' => '',
            ),
            'preview' => array(),
            'filter' => array(),
        ),
    ),
    'panels' => array(
        array(
            'name' => 'panel_body',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'src',
                    'label' => 'LBL_SUGAR_APPS_DASHLET_APP_SELECT_LABEL',
                    'type' => 'enum',
                    'span' => 12,
                ),
            ),
        ),
    ),
);
