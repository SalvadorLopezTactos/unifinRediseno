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

$viewdefs['base']['layout']['help-dashboard'] = array(
    'name' => 'LBL_DEFAULT_HELP_DASHBOARD_TITLE',
    'type' => 'help-dashboard',
    'dashboard_type' => 'help-dashboard',
    'metadata' => array(
        'components' => array(
            array(
                'rows' => array(
                    array(
                        array(
                            'view' => array(
                                'type' => 'help-dashlet',
                                'label' => 'LBL_DEFAULT_HELP_DASHLET_TITLE',
                            ),
                            'width' => 12,
                        ),
                        array(
                            'view' => array(
                                'type' => 'learning-resources',
                                'label' => 'LBL_LEARNING_RESOURCES_NAME',
                            ),
                            'width' => 12,
                        ),
                    ),
                ),
                'width' => 12,
            ),
        ),
    ),
);
