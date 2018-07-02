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
 * ContactsViewContactAddressPopup
 * 
 * */
 
require_once('include/MVC/View/SugarView.php');
require_once('modules/Contacts/Popup_picker.php');

class ContactsViewMailMergePopup extends SugarView {
	
 	function ContactAddressPopup(){
 		parent::SugarView();
 	}
 	
 	function process() {
		$this->display();
 	}

 	function display() {
 		
		$popup = new Popup_Picker();
		echo $popup->process_page_for_merge();
 	}	
}
?>