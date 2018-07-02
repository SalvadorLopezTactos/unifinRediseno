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
$dictionary['quotes_opportunities'] = array ( 'table' => 'quotes_opportunities'
                                  , 'fields' => array (
       array('name' =>'id', 'type' =>'varchar', 'len'=>'36')
      , array('name' =>'opportunity_id', 'type' =>'varchar', 'len'=>'36',)
      , array('name' =>'quote_id', 'type' =>'varchar', 'len'=>'36', )
      , array ('name' => 'date_modified','type' => 'datetime')
      , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required'=>false)
                                                      )                                  , 'indices' => array (
       array('name' =>'quotes_opportunitiespk', 'type' =>'primary', 'fields'=>array('id'))
      , array('name' =>'idx_opp_qte_opp', 'type' =>'index', 'fields'=>array('opportunity_id'))
      , array('name' => 'idx_quote_oportunities', 'type'=>'alternate_key', 'fields'=>array('quote_id'))
      
                                                      )
  	  , 'relationships' => array ('quotes_opportunities' => array('lhs_module'=> 'Quotes', 'lhs_table'=> 'quotes', 'lhs_key' => 'id',
							  'rhs_module'=> 'Opportunities', 'rhs_table'=> 'opportunities', 'rhs_key' => 'id',
							  'relationship_type'=>'many-to-many',
							  'join_table'=> 'quotes_opportunities', 'join_key_lhs'=>'quote_id', 'join_key_rhs'=>'opportunity_id',
							  ))
                                                      
)
?>
