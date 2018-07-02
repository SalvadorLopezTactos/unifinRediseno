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

 * Description:  TODO To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

global $mod_strings;
global $current_user;

if(ACLController::checkAccess('KBDocuments', 'edit', true))$module_menu[]=Array("index.php?module=KBDocuments&action=EditView&return_module=KBDocuments&return_action=DetailView", $mod_strings['LNK_NEW_ARTICLE'],"CreateKBArticle");
//if(ACLController::checkAccess('KBDocuments', 'list', true))$module_menu[]=Array("index.php?module=KBDocuments&action=index", $mod_strings['LNK_KBDOCUMENT_LIST'],"Documents");
if(ACLController::checkAccess('KBDocuments', 'edit', true)){
	
	$admin = Administration::getSettings();
	$user_merge = $current_user->getPreference('mailmerge_on');
	if ($user_merge == 'on' && isset($admin->settings['system_mailmerge_on']) && $admin->settings['system_mailmerge_on']){
		$module_menu[]=Array("index.php?module=MailMerge&action=index&reset=true", $mod_strings['LNK_NEW_MAIL_MERGE'],"Documents");
	}
}
if(ACLController::checkAccess('KBDocuments', 'list', true))$module_menu[]=Array("index.php?module=KBDocuments&action=SearchHome", $mod_strings['LBL_LIST_ARTICLES'],"KBArticle");
if($current_user->isAdminForModule('KBDocuments')){
	if(ACLController::checkAccess('KBDocuments', 'list', true))$module_menu[]=Array("index.php?module=KBDocuments&action=KBAdminView", $mod_strings['LBL_KNOWLEDGE_BASE_ADMIN_MENU'],"KB");
}
?>
