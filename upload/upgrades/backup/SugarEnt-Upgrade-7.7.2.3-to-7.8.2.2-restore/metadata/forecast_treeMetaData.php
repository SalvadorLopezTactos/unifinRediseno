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

$dictionary['forecast_tree'] = array(
	'table' => 'forecast_tree',
	'fields' => array(
		array(
			'name'			=> 'id',
			'type'			=> 'id',
			'required'		=> true,
		),
		array(
			'name'			=> 'name',
			'type'			=> 'varchar',
			'len'			=> 50,
			'required'		=> true,
		),
		array(
			'name'			=> 'hierarchy_type',
			'type'			=> 'varchar',
			'len'			=> 25,
			'required'      => true,
		),
		array(
			'name'			=> 'user_id',
			'type'			=> 'id',
            'default'       => NULL,
			'required'		=> false,
		),
        array(
      	    'name'			=> 'parent_id',
      		'type'			=> 'id',
            'default'       => NULL,
      		'required'		=> false,
      		),
	),
	'indices' => array(
		array(
			'name'			=> 'forecast_tree_pk',
			'type'			=> 'primary',
			'fields'		=> array('id')
		),
		array(
			'name'			=> 'forecast_tree_idx_user_id',
			'type'			=> 'index',
			'fields'		=> array('user_id')
		),
	),
);
