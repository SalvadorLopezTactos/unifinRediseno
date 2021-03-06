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

$dictionary['Subscription'] = array(
    'table' => 'subscriptions',
    'fields' => array(
        // Set unnecessary fields from Basic to non-required/non-db.
        'name' => array (
            'name' => 'name',
            'type' => 'varchar',
            'required' => false,
            'source' => 'non-db',
        ),

        'description' => array (
            'name' => 'description',
            'type' => 'varchar',
            'required' => false,
            'source' => 'non-db',
        ),

        // Add table columns.
        'parent_type' => array(
            'name'     => 'parent_type',
            'type'     => 'varchar',
            'len'      => 100,
            'required' => true,
        ),

        'parent_id' => array(
            'name'     => 'parent_id',
            'type'     => 'id',
            'len'      => 36,
            'required' => true,
        ),
    ),
    'indices' => array(
        array(
            'name' => 'subscription_parent',
            'type' => 'index',
            'fields' => array('parent_id'),
        ),
    ),
);

VardefManager::createVardef('ActivityStream/Subscriptions', 'Subscription', array('basic'));
