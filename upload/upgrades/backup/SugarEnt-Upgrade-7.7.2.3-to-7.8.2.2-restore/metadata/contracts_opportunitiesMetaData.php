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

// $Id: contracts_opportunitiesMetaData.php 55782 2010-04-02 21:07:20Z clee $


$dictionary['contracts_opportunities'] = array (
	'table' => 'contracts_opportunities',
	'fields' => array (
		array('name' => 'id', 'type' => 'varchar', 'len' => '36'),
		array('name' => 'opportunity_id', 'type' => 'varchar', 'len' => '36'),
		array('name' => 'contract_id', 'type' => 'varchar', 'len' => '36'),
		array('name' => 'date_modified', 'type' => 'datetime'),
		array('name' => 'deleted', 'type' => 'bool', 'len' => '1', 'default' => '0', 'required' => false),
	),
	'indices' => array (
		array('name' => 'contracts_opp_pk', 'type' =>'primary', 'fields'=>array('id')),
		array('name' => 'contracts_opp_alt', 'type'=>'alternate_key', 'fields'=>array('contract_id')),
	),
	'relationships' => array (
		'contracts_opportunities' => array(
            'lhs_module' => 'Opportunities',
            'lhs_table' => 'opportunities',
            'lhs_key' => 'id',
            'rhs_module' => 'Contracts',
            'rhs_table' => 'contracts',
            'rhs_key' => 'id',
            'relationship_type' => 'one-to-many',
            'join_table' => 'contracts_opportunities',
            'join_key_lhs' => 'opportunity_id',
            'join_key_rhs' => 'contract_id',
            'true_relationship_type' => 'one-to-many',
        ),
    ),
);
