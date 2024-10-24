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

$popupMeta = [
    'moduleMain' => 'Manufacturer',
    'varName' => 'MANUFACTURER',
    'className' => 'Manufacturer',
    'orderBy' => 'manufacturers.name',
    'whereClauses' => ['name' => 'manufacturers.name'],
    'listviewdefs' => [
        'NAME' => [
            'width' => '50',
            'label' => 'LBL_NAME',
            'link' => true,
            'default' => true],
        'STATUS' => [
            'width' => '50',
            'label' => 'LBL_STATUS',
            'default' => true],
    ],
    'searchdefs' => [
        'name',
    ],
];
