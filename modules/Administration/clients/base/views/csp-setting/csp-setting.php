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
$viewdefs['Administration']['base']['view']['csp-setting'] = [
    'template' => 'record',
    'label' => 'LBL_CSP_TITLE',
    'panels' => [
        [
            'name' => 'panel_body',
            'label' => 'LBL_PANEL_1',
            'columns' => 1,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => [
                [
                    'name' => 'csp_default_src',
                    'type' => 'text',
                    'label' => 'LBL_CSP_TRUSTED_DOMAINS',
                    'span' => 6,
                    'labelSpan' => 4,
                ],
            ],
            'helpLabels' => [
                [
                    'text' => 'LBL_CSP_SETTING_HELP_TEXT_CONTENT',
                ],
            ],
        ],
    ],
];
