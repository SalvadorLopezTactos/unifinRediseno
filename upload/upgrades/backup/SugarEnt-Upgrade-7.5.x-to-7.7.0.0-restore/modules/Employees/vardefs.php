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
global $dictionary;
if(empty($dictionary['User'])){
	include('modules/Users/vardefs.php');
}
$dictionary['Employee']=$dictionary['User'];
//users of employees modules are not allowed to change the employee/user status.
$dictionary['Employee']['fields']['status']['massupdate']=false;
$dictionary['Employee']['fields']['is_admin']['massupdate']=false;
//begin bug 48033
$dictionary['Employee']['fields']['UserType']['massupdate']=false;
$dictionary['Employee']['fields']['messenger_type']['massupdate']=false;
$dictionary['Employee']['fields']['email_link_type']['massupdate']=false;
//end bug 48033
$dictionary['Employee']['fields']['email']['required']=false;
$dictionary['Employee']['fields']['email_addresses']['required']=false;
$dictionary['Employee']['fields']['email_addresses_primary']['required']=false;
// bugs 47553 & 49716
$dictionary['Employee']['fields']['status']['studio']=false;
$dictionary['Employee']['fields']['status']['required']=false;
?>
