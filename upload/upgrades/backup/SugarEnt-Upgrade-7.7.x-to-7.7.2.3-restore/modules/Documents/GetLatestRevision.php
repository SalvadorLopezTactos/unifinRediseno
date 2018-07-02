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
//updates the link between contract and document with latest revision of
//the document and sends the control back to calling page.

require_once('modules/Documents/Document.php');
require_once('include/formbase.php');
if (!empty($_REQUEST['record'])) {

	$document = BeanFactory::getBean('Documents', $_REQUEST['record']);
	if (!empty($document->document_revision_id) && !empty($_REQUEST['get_latest_for_id']))  {
		$query="update linked_documents set document_revision_id='{$document->document_revision_id}', date_modified='".TimeDate::getInstance()->nowDb()."' where id ='{$_REQUEST['get_latest_for_id']}' ";
		$document->db->query($query);
	}	
}
handleRedirect();
?>
