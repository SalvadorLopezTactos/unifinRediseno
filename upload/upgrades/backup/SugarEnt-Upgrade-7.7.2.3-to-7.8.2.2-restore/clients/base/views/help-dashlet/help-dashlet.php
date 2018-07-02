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

$viewdefs['base']['view']['help-dashlet'] = array(
    'dashlets' => array(
        array(
            'label' => 'LBL_DEFAULT_HELP_DASHLET_TITLE',
            'description' => 'LBL_DEFAULT_HELP_DASHLET_DESC',
            'config' => array(
            ),
            'preview' => array(
            ),
            'filter' => array(
                'dashboard' => array(
                    'help-dashboard',
                ),
            ),
        ),
    ),
    'custom_toolbar' => array(
        'buttons' => array(
            array(
                'type' => 'dashletaction',
                'css_class' => 'dashlet-toggle btn btn-invisible minify',
                'icon' => 'fa-chevron-up',
                'action' => 'toggleMinify',
                'tooltip' => 'LBL_DASHLET_TOGGLE',
            )
        )
    )
);
