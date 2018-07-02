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
                    'name' => 'chart_type',
                    'label' => 'LBL_CHART_CONFIG_CHART_TYPE',
                    'type' => 'enum',
                    'sort_alpha' => true,
                    'ordered' => true,
                    'searchBarThreshold' => -1,
                    'options' => 'd3_chart_types',
                ),

                array(
                    'name' => 'editReport',
                    'label' => 'LBL_REPORT_EDIT',
                    'type' => 'button',
                    'css_class' => 'btn-invisible btn-link btn-inline',
                    'dismiss_label' => true,
                ),

                array(
                    'name' => 'show_title',
                    'label' => 'LBL_CHART_CONFIG_SHOW_TOTAL',
                    'type' => 'bool',
                    'default' => 0,
                ),

                array(
                    'name' => 'show_legend',
                    'label' => 'LBL_CHART_LEGEND_OPEN',
                    'type' => 'bool',
                    'default' => 1,
                ),

                array(
                    'name' => 'x_label_options',
                    'type' => 'fieldset',
                    'inline' => true,
                    'show_child_labels' => false,
                    'label' => 'LBL_CHART_CONFIG_SHOW_XAXIS_LABEL',
                    'toggle' => 'show_x_label',
                    'dependent' => 'x_axis_label',
                    'fields' => array(
                        array(
                            'name' => 'show_x_label',
                            'type' => 'bool',
                            'default' => 0,
                        ),
                        array(
                            'name' => 'x_axis_label',
                        ),
                    ),
                ),

                array(
                    'name' => 'tickDisplayMethods',
                    'type' => 'fieldset',
                    'inline' => true,
                    'show_child_labels' => true,
                    'label' => 'LBL_CHART_CONFIG_TICK_DISPLAY',
                    'css_class' => 'fieldset-wrap',
                    'fields' => array(
                        array(
                            'name' => 'wrapTicks',
                            'text' => 'LBL_CHART_CONFIG_TICK_WRAP',
                            'type' => 'bool',
                            'default' => true,
                        ),
                        array(
                            'name' => 'staggerTicks',
                            'text' => 'LBL_CHART_CONFIG_TICK_STAGGER',
                            'type' => 'bool',
                            'default' => true,
                        ),
                        array(
                            'name' => 'rotateTicks',
                            'text' => 'LBL_CHART_CONFIG_TICK_ROTATE',
                            'type' => 'bool',
                            'css_class' => 'disabled',
                            'default' => true,
                        ),
                    ),
                ),

                array(
                    'name' => 'y_label_options',
                    'type' => 'fieldset',
                    'inline' => true,
                    'show_child_labels' => false,
                    'label' => 'LBL_CHART_CONFIG_SHOW_YAXIS_LABEL',
                    'toggle' => 'show_y_label',
                    'dependent' => 'y_axis_label',
                    'fields' => array(
                        array(
                            'name' => 'show_y_label',
                            'type' => 'bool',
                            'default' => 0,
                        ),
                        array(
                            'name' => 'y_axis_label',
                        ),
                    ),
                ),

                array(
                ),

                array(
                    'name' => 'showValues',
                    'label' => 'LBL_CHART_CONFIG_VALUE_PLACEMENT',
                    'type' => 'enum',
                    'default' => false,
                    'options' => 'd3_value_placement',
                ),

                array(
                    'name' => 'groupDisplayOptions',
                    'type' => 'fieldset',
                    'inline' => true,
                    'show_child_labels' => false,
                    'label' => 'LBL_CHART_CONFIG_BAR_CHART_OPTIONS',
                    'css_class' => 'fieldset-wrap',
                    'fields' => array(
                        array(
                            'name' => 'allowScroll',
                            'text' => 'LBL_CHART_CONFIG_ALLOW_SCROLLING',
                            'type' => 'bool',
                            'default' => 1,
                        ),
                        array(
                            'name' => 'stacked',
                            'text' => 'LBL_CHART_CONFIG_STACK_DATA',
                            'type' => 'bool',
                            'default' => 1,
                        ),
                        array(
                            'name' => 'hideEmptyGroups',
                            'text' => 'LBL_CHART_CONFIG_HIDE_EMPTY_GROUPS',
                            'type' => 'bool',
                            'default' => 1,
                        ),
                    ),
                ),
            ),
        ),
    ),
    'chart' => array(
        'name' => 'chart',
        'label' => 'LBL_CHART',
        'type' => 'chart',
        'view' => 'detail'
    ),
);
