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
$dictionary['users_password_link'] = array(
    'table' => 'users_password_link',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'id',
            'required' => true,
        ) ,
        'bean_id' => [
            'name' => 'bean_id',
            'type' => 'id',
        ],
        'bean_type' => [
            'name' => 'bean_type',
            'type' => 'varchar',
            'len' =>'36',
            'default' => 'User',
        ],
        'username' => array(
            'name' => 'username',
            'vname' => 'LBL_USERNAME',
            'type' => 'varchar',
            'len' => 36,
        ) ,
        'date_generated' => array(
            'name' => 'date_generated',
            'vname' => 'LBL_DATE_ENTERED',
            'type' => 'datetime',
        ) ,
        'deleted' => array(
            'name' => 'deleted',
            'vname' => 'LBL_DELETED',
            'type' => 'bool',
            'required' => false,
            'reportable' => false,
        ) ,
        'platform' => [
            'name' => 'platform',
            'type' => 'varchar',
            'len' => 36,
            'default' => 'base',
        ],
    ) ,
    'indices' => array(
        array(
            'name' => 'users_password_link_pk',
            'type' => 'primary',
            'fields' => array(
                'id'
            )
        ) ,
        [
            'name' => 'idx_bean_id_users_password_link',
            'type' => 'index',
            'fields' => [
                'bean_id',
            ],
        ],
        array(
            'name' => 'idx_username',
            'type' => 'index',
            'fields' => array(
                'username'
            )
        ),
        [
            'name' => 'idx_id_deleted_platform',
            'type' => 'index',
            'fields' => [
                'id',
                'deleted',
                'platform',
            ],
        ],
    ) ,
);
