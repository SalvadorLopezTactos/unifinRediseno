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
$module_name = '<module_name>';
$_module_name = '<_module_name>';
$viewdefs[$module_name]['base']['view']['record'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_RECORD_HEADER',
            'header' => true,
            'fields' => array(
                array(
                    'name'          => 'picture',
                    'type'          => 'avatar',
                    'width'         => 42,
                    'height'        => 42,
                    'dismiss_label' => true,
                    'readonly'      => true,
                ),
                'name',
                array(
                    'name' => 'favorite',
                    'label' => 'LBL_FAVORITE',
                    'type' => 'favorite',
                    'readonly' => true,
                    'dismiss_label' => true,
                ),
                array(
                    'name' => 'follow',
                    'label'=> 'LBL_FOLLOW',
                    'type' => 'follow',
                    'readonly' => true,
                    'dismiss_label' => true,
                ),
            )
        ),
        array(
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                'website',
                'phone_office',
                'employees',
                'phone_alternate',
                'email',
                'phone_fax',
                array(
                    'name' => 'billing_address',
                    'type' => 'fieldset',
                    'css_class' => 'address',
                    'label' => 'LBL_BILLING_ADDRESS',
                    'fields' => array(
                        array(
                            'name' => 'billing_address_street',
                            'css_class' => 'address_street',
                            'placeholder' => 'LBL_BILLING_ADDRESS_STREET',
                        ),
                        array(
                            'name' => 'billing_address_city',
                            'css_class' => 'address_city',
                            'placeholder' => 'LBL_BILLING_ADDRESS_CITY',
                        ),
                        array(
                            'name' => 'billing_address_state',
                            'css_class' => 'address_state',
                            'placeholder' => 'LBL_BILLING_ADDRESS_STATE',
                        ),
                        array(
                            'name' => 'billing_address_postalcode',
                            'css_class' => 'address_zip',
                            'placeholder' => 'LBL_BILLING_ADDRESS_POSTALCODE',
                        ),
                        array(
                            'name' => 'billing_address_country',
                            'css_class' => 'address_country',
                            'placeholder' => 'LBL_BILLING_ADDRESS_COUNTRY',
                        ),
                    ),
                ),
                array(
                    'name' => 'shipping_address',
                    'type' => 'fieldset',
                    'css_class' => 'address',
                    'label' => 'LBL_SHIPPING_ADDRESS',
                    'fields' => array(
                        array(
                            'name' => 'shipping_address_street',
                            'css_class' => 'address_street',
                            'placeholder' => 'LBL_SHIPPING_ADDRESS_STREET',
                        ),
                        array(
                            'name' => 'shipping_address_city',
                            'css_class' => 'address_city',
                            'placeholder' => 'LBL_SHIPPING_ADDRESS_CITY',
                        ),
                        array(
                            'name' => 'shipping_address_state',
                            'css_class' => 'address_state',
                            'placeholder' => 'LBL_SHIPPING_ADDRESS_STATE',
                        ),
                        array(
                            'name' => 'shipping_address_postalcode',
                            'css_class' => 'address_zip',
                            'placeholder' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
                        ),
                        array(
                            'name' => 'shipping_address_country',
                            'css_class' => 'address_country',
                            'placeholder' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
                        ),
                        array(
                            'name' => 'copy',
                            'label' => 'NTC_COPY_BILLING_ADDRESS',
                            'type' => 'copy',
                            'mapping' => array(
                                'billing_address_street' => 'shipping_address_street',
                                'billing_address_city' => 'shipping_address_city',
                                'billing_address_state' => 'shipping_address_state',
                                'billing_address_postalcode' => 'shipping_address_postalcode',
                                'billing_address_country' => 'shipping_address_country',
                            ),
                        ),
                    ),
                ),
            ),
        ),
        array(
            'name' => 'panel_hidden',
            'label' => 'LBL_SHOW_MORE',
            'hide' => true,
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                'twitter',
                array(
                    'name' => 'description',
                    'span' => 12,
                ),
                $_module_name . '_type',
                'industry',
                'annual_revenue',
                'ticker_symbol',
                'ownership',
                'rating',
                'assigned_user_name',
                array(
                    'name' => 'date_modified_by',
                    'readonly' => true,
                    'type' => 'fieldset',
                    'label' => 'LBL_DATE_MODIFIED',
                    'fields' => array(
                        array(
                            'name' => 'date_modified',
                        ),
                        array(
                            'type' => 'label',
                            'default_value' => 'LBL_BY',
                        ),
                        array(
                            'name' => 'modified_by_name',
                        ),
                    ),
                ),
                'team_name',
                array(
                    'name' => 'date_entered_by',
                    'readonly' => true,
                    'type' => 'fieldset',
                    'label' => 'LBL_DATE_ENTERED',
                    'fields' => array(
                        array(
                            'name' => 'date_entered',
                        ),
                        array(
                            'type' => 'label',
                            'default_value' => 'LBL_BY',
                        ),
                        array(
                            'name' => 'created_by_name',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
