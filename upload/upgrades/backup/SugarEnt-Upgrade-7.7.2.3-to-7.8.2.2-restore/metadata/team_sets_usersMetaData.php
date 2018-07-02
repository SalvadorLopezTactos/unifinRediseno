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
$dictionary['team_sets_users'] = array('table' => 'team_sets_users'
                               ,'fields' => array (
	  'team_set_id' => 
	  array (
	    'name' => 'team_set_id',
	    'type' => 'id',
	    'required' => true,
	  ),
	   'user_id' => 
	  array (
	    'name' => 'user_id',
	    'type' => 'id',
	    'required' => true,
	  ),       
	), 'indices' => array (
		array(
            'name' => 'idx_tmst_user',
            'type' => 'index',
            'fields' => array(
                'team_set_id',
				'user_id'
            )
        ) ,
        array(
            'name' => 'idx_user_tmst',
            'type' => 'index',
            'fields' => array(
                'user_id',
				'team_set_id'
            )
        ),
         array(
            'name' => 'idx_user_id',
            'type' => 'index',
            'fields' => array(
                'user_id',
            )
        )
	)
);
?>
