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
        ['widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'PdfManager'],
    ],

    'where' => '',

    'list_fields' => [
        'name' => [
            'vname' => 'LBL_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '45%',
        ],
        'date_modified' => [
            'vname' => 'LBL_DATE_MODIFIED',
            'width' => '45%',
        ],
        'edit_button' => [
            'widget_class' => 'SubPanelEditButton',
            'module' => 'PdfManager',
            'width' => '4%',
        ],
        'remove_button' => [
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'PdfManager',
            'width' => '5%',
        ],
    ],
];
