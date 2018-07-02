<?php
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

$viewdefs['base']['view']['saved-reports-chart'] = array(
    'dashlets' => array(
        array(
            'label' => 'LBL_DASHLET_SAVED_REPORTS_CHART',
            'description' => 'LBL_DASHLET_SAVED_REPORTS_CHART_DESC',
            'config' => array(

            ),
            'preview' => array(

            ),
        )
    ),
    'dashlet_config_panels' => array(
        array(
            'name' => 'panel_body',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'saved_report_id',
                    'label' => 'LBL_REPORT_SELECT',
                    'type' => 'enum',
                    'options' => array('' => ''),
                ),
                array(
                    'name' => 'auto_refresh',
                    'label' => 'LBL_REPORT_AUTO_REFRESH',
                    'type' => 'enum',
                    'options' => 'sugar7_dashlet_reports_auto_refresh_options'
                ),
                array(
                    'name' => 'editReport',
                    'label' => 'LBL_REPORT_EDIT',
                    'type' => 'button',
                    'css_class' => 'btn-invisible btn-link btn-inline',
                    'dismiss_label' => true,
                ),
            ),
        ),
    ),
    'chart' => array(
        'name' => 'chart',
        'label' => 'Chart',
        'type' => 'chart',
        'view' => 'detail'
    ),
);
