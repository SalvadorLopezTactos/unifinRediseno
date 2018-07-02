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
/*********************************************************************************
 * $Id$
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('modules/Trackers/store/Store.php');

/**
 * Database
 * This is an implementation of the Store interface where the storage uses
 * the configured database instance as defined in DBManagerFactory::getInstance() method
 *
 */
class DatabaseStore implements Store {

    public function flush($monitor) {

       $metrics = $monitor->getMetrics();
       $columns = array();
       $values = array();
       $db = DBManagerFactory::getInstance();
       foreach($metrics as $name=>$metric) {
       	  if(!empty($monitor->$name)) {
       	  	 $columns[] = $name;
       	  	 if($metrics[$name]->_type == 'int') {
       	  	    $values[] = intval($monitor->$name);
       	  	 } else if($metrics[$name]->_type == 'double') {
                $values[] = floatval($monitor->$name);
             } else if ($metrics[$name]->_type == 'datetime') {
             	$values[] = $db->convert($GLOBALS['db']->quoted($monitor->$name), "datetime");
       	  	 } else {
                $values[] = $db->quoted($monitor->$name);
             }
       	  }
       } //foreach

       if(empty($values)) {
       	  return;
       }

       $id = $db->getAutoIncrementSQL($monitor->table_name,'id');
       if(!empty($id)) {
       	  $columns[] = 'id';
       	  $values[] = $id;
       }

       $query = "INSERT INTO $monitor->table_name (" .implode("," , $columns). " ) VALUES ( ". implode("," , $values). ')';
	   $db->query($query);
    }
}

?>
