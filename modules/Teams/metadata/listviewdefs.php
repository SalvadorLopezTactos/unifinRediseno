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


$listViewDefs['Teams'] = [
    'NAME' => [
        'width' => '20',
        'label' => 'LBL_NAME',
        'link' => true,
        'default' => true,
        'related_fields' => ['name_2',],],
    'DESCRIPTION' => [
        'width' => '80',
        'label' => 'LBL_DESCRIPTION',
        'default' => true],
];
