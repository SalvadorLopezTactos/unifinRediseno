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


$listViewDefs['Tasks'] = [
    'SET_COMPLETE' => [
        'width' => '1',
        'label' => 'LBL_LIST_CLOSE',
        'link' => true,
        'sortable' => false,
        'default' => true,
        'related_fields' => ['status']],
    'NAME' => [
        'width' => '40',
        'label' => 'LBL_LIST_SUBJECT',
        'link' => true,
        'default' => true],
    'CONTACT_NAME' => [
        'width' => '20',
        'label' => 'LBL_LIST_CONTACT',
        'link' => true,
        'id' => 'CONTACT_ID',
        'module' => 'Contacts',
        'default' => true,
        'ACLTag' => 'CONTACT',
        'related_fields' => ['contact_id']],
    'PARENT_NAME' => [
        'width' => '20',
        'label' => 'LBL_LIST_RELATED_TO',
        'dynamic_module' => 'PARENT_TYPE',
        'id' => 'PARENT_ID',
        'link' => true,
        'default' => true,
        'sortable' => false,
        'ACLTag' => 'PARENT',
        'related_fields' => ['parent_id', 'parent_type']],
    'DATE_DUE' => [
        'width' => '15',
        'label' => 'LBL_LIST_DUE_DATE',
        'link' => false,
        'default' => true],
    'TIME_DUE' => [
        'width' => '15',
        'label' => 'LBL_LIST_DUE_TIME',
        'sortable' => false,
        'link' => false,
        'default' => true],
    'TEAM_NAME' => [
        'width' => '2',
        'label' => 'LBL_LIST_TEAM',
        'default' => false],

    'ASSIGNED_USER_NAME' => [
        'width' => '2',
        'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true],
    'DATE_START' => [
        'width' => '5',
        'label' => 'LBL_LIST_START_DATE',
        'link' => false,
        'default' => false],
    'STATUS' => [
        'width' => '10',
        'label' => 'LBL_LIST_STATUS',
        'link' => false,
        'default' => false],
    'DATE_ENTERED' => [
        'width' => '10',
        'label' => 'LBL_DATE_ENTERED',
        'default' => true],
];
