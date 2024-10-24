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

$subpanel_layout = [
    'top_buttons' => [
        ['widget_class' => 'SubPanelTopCreateButton'],
        ['widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'ProjectTask'],
    ],
    'where' => '',
    'list_fields' => [
        'name' => [
            'vname' => 'LBL_LIST_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '20%',
        ],
        'percent_complete' => [
            'vname' => 'LBL_LIST_PERCENT_COMPLETE',
            'width' => '20%',
        ],
        'status' => [
            'vname' => 'LBL_LIST_STATUS',
            'width' => '20%',
        ],
        'assigned_user_name' => [
            'vname' => 'LBL_ASSIGNED_TO_NAME',
            'module' => 'Users',
            'width' => '20%',
        ],
        'date_finish' => [
            'vname' => 'LBL_LIST_DATE_DUE',
            'width' => '20%',
        ],
    ],
];
