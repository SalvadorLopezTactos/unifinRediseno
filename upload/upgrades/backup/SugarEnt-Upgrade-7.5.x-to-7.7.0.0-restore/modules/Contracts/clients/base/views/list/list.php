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
$viewdefs['Contracts']['base']['view']['list'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name' => 'name',
                    'width' => '40',
                    'label' => 'LBL_LIST_CONTRACT_NAME',
                    'link' => true,
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'account_name',
                    'width' => '20',
                    'label' => 'LBL_LIST_ACCOUNT_NAME',
                    'link' => true,
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'status',
                    'width' => '10',
                    'label' => 'LBL_STATUS',
                    'link' => false,
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'start_date',
                    'width' => '15',
                    'label' => 'LBL_LIST_START_DATE',
                    'link' => false,
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'end_date',
                    'width' => '15',
                    'label' => 'LBL_LIST_END_DATE',
                    'link' => false,
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'team_name',
                    'width' => '2',
                    'label' => 'LBL_LIST_TEAM',
                    'default' => false,
                    'enabled' => true,
                ),
                array(
                    'name' => 'assigned_user_name',
                    'width' => '2',
                    'label' => 'LBL_LIST_ASSIGNED_TO_USER',
                    'default' => true,
                    'enabled' => true,
                ),
            ),
        ),
    ),
);
