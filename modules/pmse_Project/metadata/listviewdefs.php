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

$module_name = 'pmse_Project';
$listViewDefs[$module_name] =
    [
        'name' => [
            'width' => '32',
            'label' => 'LBL_NAME',
            'default' => true,
            'link' => true,
        ],
        'prj_module' => [
            'type' => 'enum',
            'default' => true,
            'studio' => 'visible',
            'label' => 'LBL_PRJ_MODULE',
            'width' => '10',
        ],
        'prj_status' => [
            'type' => 'varchar',
            'default' => true,
            'label' => 'LBL_PRJ_STATUS',
            'width' => '10',
        ],
        'assigned_user_name' => [
            'width' => '9',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            'module' => 'Employees',
            'id' => 'ASSIGNED_USER_ID',
            'default' => true,
        ],
        'team_name' => [
            'width' => '9',
            'label' => 'LBL_TEAM',
            'default' => false,
        ],
    ];
