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
$viewdefs['Forecasts']['base']['view']['config-forecast-by'] = [
    'label' => 'LBL_FORECASTS_CONFIG_BREADCRUMB_WORKSHEET_LAYOUT',
    'panels' => [
        [
            'fields' => [
                [
                    'name' => 'forecast_by',
                    'type' => 'radioenum',
                    'label' => '',
                    'view' => 'edit',
                    'options' => 'forecasts_config_worksheet_layout_forecast_by_options_dom',
                    'default' => false,
                    'enabled' => true,
                ],
            ],
        ],
    ],
];
