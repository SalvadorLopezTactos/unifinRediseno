<?php
 if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
$module_name = '<module_name>';
$_module_name = '<_module_name>';
$viewdefs[$module_name]['mobile']['view']['list'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => array(
                array(
                    'name' => 'name',
                    'width'   => '30',
                    'label'   => 'LBL_LIST_SALE_NAME',
                    'link'    => true,
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'sales_stage',
                    'width'   => '10',
		            'label'   => 'LBL_LIST_SALE_STAGE',
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'amount_usdollar',
                    'width'   => '10',
                    'label'   => 'LBL_LIST_AMOUNT',
                    'align'   => 'right',
                    'currency_format' => true,
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => $_module_name .'_type',
                    'width' => '15',
                    'label' => 'LBL_TYPE',
                ),
                array(
                    'name' => 'lead_source',
                    'width' => '15',
                    'label' => 'LBL_LEAD_SOURCE',
                ),
                array(
                    'name' => 'next_step',
                    'width' => '10',
                    'label' => 'LBL_NEXT_STEP',
                ),
                array(
                    'name' => 'probability',
                    'width' => '10',
                    'label' => 'LBL_PROBABILITY',
                ),
                array(
                    'name' => 'date_closed',
                    'width' => '10',
		            'label' => 'LBL_LIST_DATE_CLOSED',
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'date_entered',
                    'width' => '10',
                    'label' => 'LBL_DATE_ENTERED',
                    'readonly' => true,
                ),
                array(
                    'name' => 'created_by_name',
                    'width' => '10',
                    'label' => 'LBL_CREATED',
                    'readonly' => true,
                ),
                array(
                    'name' => 'team_name',
                    'width' => '5',
		            'label' => 'LBL_LIST_TEAM',
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'assigned_user_name',
                    'width' => '5',
		            'label' => 'LBL_LIST_ASSIGNED_USER',
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'modified_by_name',
                    'width' => '5',
                    'label' => 'LBL_MODIFIED',
                    'readonly' => true,
                ),
            ),
        ),
    ),
);