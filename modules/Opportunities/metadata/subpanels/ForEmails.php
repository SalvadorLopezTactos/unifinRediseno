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
        ['widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'Opportunities'],
    ],

    'where' => '',


    'list_fields' => [
        'name' => [
            'name' => 'name',
            'vname' => 'LBL_LIST_OPPORTUNITY_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '50%',
        ],
        'account_name' => [
            'vname' => 'LBL_LIST_ACCOUNT_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'module' => 'Accounts',
            'width' => '31%',
            'target_record_key' => 'account_id',
            'target_module' => 'Accounts',
        ],
        'sales_stage' => [
            'name' => 'sales_stage',
            'vname' => 'LBL_LIST_SALES_STAGE',
            'width' => '15%',
        ],
        'edit_button' => [
            'vname' => 'LBL_EDIT_BUTTON',
            'widget_class' => 'SubPanelEditButton',
            'module' => 'Opportunities',
            'width' => '4%',
        ],
        'remove_button' => [
            'vname' => 'LBL_REMOVE',
            'widget_class' => 'SubPanelRemoveButton',
            'width' => '4%',
        ],
        'currency_id' => [
            'usage' => 'query_only',
        ],
    ],
];
