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

 * Description: TODO:  To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
global $app_strings;
echo "<br><br>";

if(isset($_REQUEST['ie_error']) && $_REQUEST['ie_error'] == 'true') {
	echo '<a href="index.php?module=Users&action=EditView&record='.$_REQUEST['id'].'">'.$mod_strings['ERR_IE_FAILURE1'].'</a><br>';
	echo $mod_strings['ERR_IE_FAILURE2'];
} else {
?>
<span class='error'><?php if (isset($_REQUEST['error_string'])) echo $_REQUEST['error_string']; ?>
<br><br>
<?php echo $app_strings['NTC_CLICK_BACK']; }?>
</span>
