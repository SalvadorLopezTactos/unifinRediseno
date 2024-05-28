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

$popupMeta = array(
    'moduleMain' => 'BusinessCenter',
    'varName' => 'BUSINESS_CENTER',
    'orderBy' => 'business_centers.name',
    'whereClauses' => array(
        'name' => 'business_centers.name',
        'address_city' => 'business_centers.address_city',
        'address_country' => 'business_centers.address_country',
    ),
    'searchInputs' => array(
        0 => 'name',
        1 => 'address_city',
        2 => 'address_country',
    ),
    'listviewdefs' => array(
        'name' => array(
            'type' => 'name',
            'label' => 'LBL_NAME',
            'width' => 10,
            'default' => true,
        ),
        'address_city' => array(
            'type' => 'varchar',
            'label' => 'LBL_ADDRESS_CITY',
            'width' => 10,
            'default' => true,
        ),
        'address_country' => array(
            'type' => 'varchar',
            'label' => 'LBL_ADDRESS_COUNTRY',
            'width' => 10,
            'default' => true,
        ),
        'timezone' => array(
            'type' => 'enum',
            'label' => 'LBL_TIMEZONE',
            'width' => 10,
            'default' => true,
        ),
    ),
);
