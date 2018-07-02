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

/**
 * ContactsViewRetrieveEmailUsername.php
 * 
 * This class overrides SugarView and provides an implementation for the RetrieveEmailUsername
 * method used for returning the information about an email address
 * 
 * @author Collin Lee
 * */
 
require_once('include/MVC/View/SugarView.php');
require_once("include/JSON.php");

class ContactsViewRetrieveEmail extends SugarView {
	
 	function ContactsViewRetrieveEmail(){
 		parent::SugarView();
 	}
 	
 	function process() {
		$this->display();
 	}

 	function display(){
	    $data = array();
	    $data['target'] = $_REQUEST['target'];
        if(!empty($_REQUEST['email'])) {
	        $db = DBManagerFactory::getInstance();
	        $email = $GLOBALS['db']->quote(strtoupper(trim($_REQUEST['email'])));
	        $result = $db->query("SELECT * FROM email_addresses WHERE email_address_caps = '$email' AND deleted = 0");
			if($row = $db->fetchByAssoc($result)) {
		        $data['email'] = $row;
			} else {
				$data['email'] = '';
			}
        }
		$json = new JSON(JSON_LOOSE_TYPE);
		echo $json->encode($data); 
 	}	
}
?>