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
$dictionary["documents_revenuelineitems"] = array(
    'true_relationship_type' => 'many-to-many',
    'relationships' => array(
        'documents_revenuelineitems' => array(
            'lhs_module' => 'Documents',
            'lhs_table' => 'documents',
            'lhs_key' => 'id',
            'rhs_module' => 'RevenueLineItems',
            'rhs_table' => 'revenue_line_items',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'documents_revenuelineitems',
            'join_key_lhs' => 'document_id',
            'join_key_rhs' => 'rli_id',
        ),

    ),
    'table' => 'documents_revenuelineitems',
    'fields' => array(
        0 => array(
            'name' => 'id',
            'type' => 'varchar',
            'len' => 36,
        ),
        1 => array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),
        2 => array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => true,
        ),
        3 => array(
            'name' => 'document_id',
            'type' => 'varchar',
            'len' => 36,
        ),
        4 => array(
            'name' => 'rli_id',
            'type' => 'varchar',
            'len' => 36,
        ),
    ),
    'indices' => array(
        0 => array(
            'name' => 'documents_revenuelineitemssspk',
            'type' => 'primary',
            'fields' => array(
                0 => 'id',
            ),
        ),
        1 => array(
            'name' => 'documents_revenuelineitems_revenuelineitem_id',
            'type' => 'alternate_key',
            'fields' => array(
                0 => 'rli_id',
                1 => 'document_id',
            ),
        ),
        2 => array(
            'name' => 'documents_revenuelineitems_document_id',
            'type' => 'alternate_key',
            'fields' => array(
                0 => 'document_id',
                1 => 'rli_id',
            ),
        ),
    ),
);
