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


$listViewDefs['SavedSearch'] = [
    'NAME' => [
        'width' => '40',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'customCode' => '<a  href="index.php?action=index&module=SavedSearch&saved_search_select={$ID}">{$NAME}</a>'],
    'SEARCH_MODULE' => [
        'width' => '35',
        'label' => 'LBL_LIST_MODULE'],
    'TEAM_NAME' => [
        'width' => '15',
        'label' => 'LBL_LIST_TEAM',
        'default' => false],
    'ASSIGNED_USER_NAME' => [
        'width' => '10',
        'label' => 'LBL_LIST_ASSIGNED_USER'],
];
