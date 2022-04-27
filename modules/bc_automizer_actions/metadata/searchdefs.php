<?php
/**
 * The file used to manage search for Automizer actions
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$module_name = 'bc_automizer_actions';
  $searchdefs[$module_name] = array(
					'templateMeta' => array(
							'maxColumns' => '3',
  							'maxColumnsBasic' => '4', 
                            'widths' => array('label' => '10', 'field' => '30'),                 
                           ),
                    'layout' => array(  					
						'basic_search' => array(
							'name', 
							array('name'=>'current_user_only', 'label'=>'LBL_CURRENT_USER_FILTER', 'type'=>'bool'),
							array ('name' => 'favorites_only','label' => 'LBL_FAVORITES_FILTER','type' => 'bool',),
							),
						'advanced_search' => array(
							'name', 
							array('name' => 'assigned_user_id', 'label' => 'LBL_ASSIGNED_TO', 'type' => 'enum', 'function' => array('name' => 'get_user_array', 'params' => array(false))),
							array ('name' => 'favorites_only','label' => 'LBL_FAVORITES_FILTER','type' => 'bool',),
						),
					),
 			   );
