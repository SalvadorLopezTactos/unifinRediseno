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

if (isset($_REQUEST['uid'])) {
	$merge_ids = explode(',',$_REQUEST['uid']);
	// Bug 18852 - Check to make sure we have ACL Edit privledges on both records involved in the merge before proceeding
	if ( ($bean1 = BeanFactory::getBean($_REQUEST['action_module'])) != null
    	    && ($bean2 = BeanFactory::getBean($_REQUEST['action_module'])) != null ) {
        $bean1->retrieve($merge_ids[0]);
        $bean2->retrieve($merge_ids[1]);
        if ( !$bean1->ACLAccess('edit') || !$bean2->ACLAccess('edit') ) {
            ACLController::displayNoAccess();
            sugar_die('');
        }
    }

	 //redirect to step3.
	$_REQUEST['record']=$merge_ids[0];
	$_REQUEST['merge_module']=$_REQUEST['action_module'];
	unset($merge_ids[0]);
	$_REQUEST['mass']=$merge_ids;
}
else {
	$merge_ids = array();
	$focus = BeanFactory::getBean($_REQUEST['return_module']);

	if(isset($_SESSION['export_where']) && !empty($_SESSION['export_where'])) { // bug 4679
		$where = $_SESSION['export_where'];
		$whereArr = explode (" ", trim($where));
		if ($whereArr[0] == trim('where')) {
			$whereClean = array_shift($whereArr);
		}
		$where = implode(" ", $whereArr);
	}
	else {
		$where = '';
	}
	if(empty($order_by))$order_by = '';
	$query = $focus->create_export_query($order_by,$where);
	$result = $focus->db->query($query,true);

	$row = $focus->db->fetchByAssoc($result);

	while ($row != null) {
	    array_push($merge_ids, $row['id']);
	    $row = $focus->db->fetchByAssoc($result);
	}
	$_REQUEST['record']=$merge_ids[0];
	$_REQUEST['action']='index.php';
	$_REQUEST['merge_module']=$_REQUEST['return_module'];
	unset($merge_ids[0]);
	$_REQUEST['mass']=$merge_ids;
}
require('modules/MergeRecords/Step3.php');

?>
