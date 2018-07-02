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

$dictionary['fts_queue'] = array('table' => 'fts_queue',
    'fields' => array(
        array(
            'name'      => 'id',
            'type'      => 'id',
        ),
        array(
            'name'      => 'bean_id',
            'dbType'    => 'id',
            'type'      => 'varchar',
            'len'       => '36',
            'comment'   => 'FK to various beans\'s tables',
        ),
        array(
            'name'      => 'bean_module',
            'type'      => 'varchar',
            'len'       => '100',
            'comment'   => 'bean\'s Module',
        ),
        array(
            'name'      => 'date_modified',
            'type'      => 'datetime',
        ),
        array(
            'name'      => 'date_created',
            'type'      => 'datetime',
        ),
        array(
            'name'      => 'processed',
            'type'      => 'bool',
            'len'       => '1',
            'default'   => '0',
            'required'  => false,
        )
    ),
    'indices' => array(
        array(
            'name'      => 'idx_fts_queue_pk',
            'type'      => 'primary',
            'fields'    => array('id'),
        ),
        array(
            'name'      => 'idx_beans_bean_id',
            'type'      => 'index',
            'fields'    => array('bean_module','bean_id'),
        ),
    ),
    'relationships' => array(),
);
