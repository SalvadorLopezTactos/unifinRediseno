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
        ['widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'Quotes'],
    ],

    'where' => '',


    'list_fields' => [
        'name' => [
            'vname' => 'LBL_LIST_QUOTE_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '40%',
        ],
        'account_name' => [
            'vname' => 'LBL_LIST_ACCOUNT_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'module' => 'Accounts',
            'width' => '32%',
            'target_record_key' => 'account_id',
            'target_module' => 'Accounts',
            'sortable' => false,
        ],
        'total_usdollar' => [
            'vname' => 'LBL_LIST_AMOUNT_USDOLLAR',
            'width' => '10%',
        ],
        'date_quote_expected_closed' => [
            'name' => 'date_quote_expected_closed',
            'vname' => 'LBL_LIST_DATE_QUOTE_EXPECTED_CLOSED',
            'width' => '10%',
        ],
        'assigned_user_name' => [
            'name' => 'assigned_user_name',
            'vname' => 'LBL_LIST_ASSIGNED_TO_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'target_record_key' => 'assigned_user_id',
            'target_module' => 'Employees',
        ],

        'edit_button' => [
            'vname' => 'LBL_EDIT_BUTTON',
            'widget_class' => 'SubPanelEditButton',
            'module' => 'Quotes',
            'width' => '4%',
        ],
        'remove_button' => [
            'vname' => 'LBL_REMOVE',
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'Leads',
            'width' => '4%',
        ],
        'currency_id' => [
            'usage' => 'query_only',
        ],
    ],
];
