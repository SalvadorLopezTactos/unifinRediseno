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
$viewdefs['Forecasts']['base']['view']['config-ranges'] = [
    'label' => 'LBL_FORECASTS_CONFIG_BREADCRUMB_RANGES',
    'panels' => [
        [
            'fields' => [
                [
                    'name' => 'forecast_ranges',
                    'type' => 'radioenum',
                    'label' => 'LBL_FORECASTS_CONFIG_RANGES_OPTIONS',
                    'view' => 'edit',
                    'options' => 'forecasts_config_ranges_options_dom',
                    'default' => false,
                    'enabled' => true,
                ],
                [
                    'name' => 'category_ranges',
                    'include' => [
                        'name' => 'include',
                        'type' => 'range',
                        'view' => 'edit',
                        'sliderType' => 'connected',
                        'minRange' => 0,
                        'maxRange' => 100,
                        'default' => true,
                        'enabled' => true,
                    ],
                    'upside' => [
                        'name' => 'upside',
                        'type' => 'range',
                        'view' => 'edit',
                        'sliderType' => 'connected',
                        'minRange' => 0,
                        'maxRange' => 100,
                        'default' => true,
                        'enabled' => true,
                    ],
                    'custom_default' => [
                        'name' => 'custom_default',
                        'type' => 'range',
                        'view' => 'edit',
                        'sliderType' => 'connected',
                        'minRange' => 0,
                        'maxRange' => 100,
                        'default' => true,
                        'enabled' => true,
                    ],
                    'custom' => [
                        'name' => 'custom',
                        'type' => 'range',
                        'view' => 'edit',
                        'sliderType' => 'connected',
                        'minRange' => 0,
                        'maxRange' => 100,
                        'default' => true,
                        'enabled' => true,
                    ],
                    'custom_without_probability' => [
                        'name' => 'custom_without_probability',
                        'type' => 'range',
                        'view' => 'edit',
                        'sliderType' => 'connected',
                        'minRange' => 0,
                        'maxRange' => 100,
                        'default' => true,
                        'enabled' => true,
                    ],
                ],
                [
                    'name' => 'buckets_dom',
                    'options' => [
                        'show_binary' => 'commit_stage_binary_dom',
                        'show_buckets' => 'commit_stage_dom',
                        'show_custom_buckets' => 'commit_stage_custom_dom',
                    ],
                ],
            ],
        ],
    ],
];
