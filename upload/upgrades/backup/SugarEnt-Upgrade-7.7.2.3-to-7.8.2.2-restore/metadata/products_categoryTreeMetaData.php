<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
$dictionary['products_category_tree'] =
        array('table' => 'category_tree',
                'fields' => array(
                    array('name' => 'self_id',
                          'type' => 'id',
                          'len' => '36'
                    ),
                    array('name' => 'node_id',
                          'type' => 'int',
                          'auto_increment' => true,
                          'required' => true,
                          'isnull' => false         // Making sure it's not NULLABLE since it is the primary key.
                    ),
                    array('name' => 'parent_node_id',
                          'type' => 'int',
                          'default' => '0'
                    ),
                    array('name' => 'type',
                          'type' => 'varchar',
                          'len' => '36'
                    )
                ),
                'indices' => array(
                    array('name' => 'categorytreepk', 'type' => 'primary', 'fields' => array('node_id')),
                    array('name' => 'idx_categorytree', 'type' => 'index', 'fields' => array('self_id'))
                )
        );
