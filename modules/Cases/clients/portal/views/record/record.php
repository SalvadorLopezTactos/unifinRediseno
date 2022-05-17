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

$viewdefs['Cases']['portal']['view']['record'] = array(
    'buttons' => array(
        array(
            'type' => 'button',
            'name' => 'request_close_button',
            'label' => 'LBL_REQUEST_CLOSE_LABEL',
            'css_class' => 'btn btn-primary hidden',
            'tooltip' => 'LBL_REQUEST_CLOSE_TOOLTIP',
        ),
        array(
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
        ),
    ),
    'panels' => array(
        array(
            'name' => 'panel_header',
            'header' => true,
            'fields' => array(
                array(
                    'name'          => 'picture',
                    'type'          => 'avatar',
                    'size'          => 'large',
                    'dismiss_label' => true,
                    'readonly'      => true,
                ),
                'name',
            ),
        ),
        array(
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'placeholders' => true,
            'fields' =>
            array(
                array(
                    'name' => 'case_number',
                    'span' => 12,
                ),
                array(
                    'name' => 'description',
                    'span' => 12,
                ),
                'status',
                'priority',
                array(
                    'name' => 'type',
                    'span' => 12,
                ),
                array(
                    'name' => 'date_entered_by',
                    'readonly' => true,
                    'type' => 'fieldset',
                    'label' => 'LBL_DATE_ENTERED',
                    'fields' => array(
                        array(
                            'name' => 'date_entered',
                        ),
                    ),
                ),
                array(
                    'name' => 'date_modified_by',
                    'readonly' => true,
                    'type' => 'fieldset',
                    'label' => 'LBL_DATE_MODIFIED',
                    'fields' => array(
                        array(
                            'name' => 'date_modified',
                        ),
                    ),
                ),
                array(
                    'name' => 'request_close',
                    'readonly' => true,
                    'label' => 'LBL_REQUEST_CLOSE',
                ),
                array(
                    'name' => 'request_close_date',
                    'readonly' => true,
                    'label' => 'LBL_REQUEST_CLOSE_DATE',
                ),
            ),
        ),
    ),
    'dependencies' => array(
        array(
            'hooks' => array('all'),
            'trigger' => 'true',
            'triggerFields' => array('request_close', 'request_close_date'),
            'onload' => true,
            'actions' => array(
                array(
                    'action' => 'SetVisibility',
                    'params' => array(
                        'target' => 'request_close',
                        'value' => 'equal($request_close, "1")',
                    ),
                ),
                array(
                    'action' => 'SetVisibility',
                    'params' => array(
                        'target' => 'request_close_date',
                        'value' => 'equal($request_close, "1")',
                    ),
                ),
            ),
        ),
    ),
);
