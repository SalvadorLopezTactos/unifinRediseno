<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
$viewdefs['Styleguide']['base']['view']['list'] = array(
    'panels' =>
    array(
        0 =>
        array(
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name' => 'full_name',
                    'type' => 'fullname',
                    'fields' => array(
                        'salutation',
                        'first_name',
                        'last_name',
                    ),
                    'link' => true,
                    'label' => 'fullname',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'title',
                    'label' => 'base',
                ),
                array(
                    'name' => 'do_not_call',
                    'label' => 'bool',
                ),
                array(
                    'name' => 'parent_name',
                    'label' => 'parent',
                    'sortable' => false,
                ),
                array(
                    'name' => 'email',
                    'label' => 'email',
                    'sortable' => false,
                ),
                array (
                    'name' => 'assigned_user_name',
                    'label' => 'relate',
                    'id' => 'ASSIGNED_USER_ID',
                    'default' => true,
                    'sortable' => false,
                ),
                array(
                    'name' => 'filename',
                    'label' => 'file',
                ),
                array(
                    'name' => 'list_price',
                    'label' => 'currency',
                ),
                array(
                    'name' => 'date_entered',
                    'label' => 'datetimecombo',
                    'sortable' => false,
                ),
            ),
        ),
    ),
);

