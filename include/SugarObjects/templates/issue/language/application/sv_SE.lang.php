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
$object_name = strtolower($object_name);
$app_list_strings = [

    $object_name . '_type_dom' => [
        'Administration' => 'Administration',
        'Product' => 'Produkt',
        'User' => 'Användare',
    ],
    $object_name . '_status_dom' => [
        'New' => 'Ny',
        'Assigned' => 'Tilldelad',
        'Closed' => 'Stängd',
        'Pending Input' => 'I väntan på inmatning',
        'Rejected' => 'Avvisad',
        'Duplicate' => 'Duplicerad',
    ],
    $object_name . '_priority_dom' => [
        'P1' => 'Hög',
        'P2' => 'Medel',
        'P3' => 'Låg',
    ],
    $object_name . '_resolution_dom' => [
        '' => '',
        'Accepted' => 'Accepterat',
        'Duplicate' => 'Duplicerad',
        'Closed' => 'Stängd',
        'Out of Date' => 'Utgånget datum',
        'Invalid' => 'Ogiltig',
    ],
];
