<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

$viewdefs['Forecasts']['base']['view']['forecastsConfigVariables'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_FORECASTS_CONFIG_BREADCRUMB_VARIABLES',
            'fields' => array(
                array(
                    'name' => 'sales_stage_lost',
                    'label' => 'LBL_FORECASTS_CONFIG_VARIABLES_CLOSED_LOST_STAGE',
                    'type' => 'enum',
                    'multi' => true,
                    'options' => 'sales_stage_dom',
                    'default' => false,
                    'enabled' => true,
                    'view' => 'forecastsFilter',
                ),
                array(
                    'name' => 'sales_stage_won',
                    'label' => 'LBL_FORECASTS_CONFIG_VARIABLES_CLOSED_WON_STAGE',
                    'type' => 'enum',
                    'multi' => true,
                    'options' => 'sales_stage_dom',
                    'default' => false,
                    'enabled' => true,
                    'view' => 'forecastsFilter',
                ),
            ),
        ),
    ),
);
