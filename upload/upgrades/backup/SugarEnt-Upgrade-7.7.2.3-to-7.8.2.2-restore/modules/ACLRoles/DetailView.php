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


//global $modInvisList;
global $dictionary;

$sugar_smarty = new Sugar_Smarty();
$sugar_smarty->assign('MOD', $mod_strings);
$sugar_smarty->assign('APP', $app_strings);

//nsingh bug: 21669. Messes up localization
/*foreach($modInvisList as $modinvisname){
    if(empty($app_list_strings['moduleList'][$modinvisname])){
	   $app_list_strings['moduleList'][$modinvisname] = $modinvisname;
    }
}*/
$sugar_smarty->assign('APP_LIST', $app_list_strings);
/*foreach($modInvisList as $modinvisname){
	unset($app_list_strings['moduleList'][$modinvisname]);
}*/
$role = BeanFactory::getBean('ACLRoles', $_REQUEST['record']);
$categories = ACLRole::getRoleActions($_REQUEST['record']);
$names = ACLAction::setupCategoriesMatrix($categories);

// Skipping modules that have 'hidden_to_role_assignment' property
foreach ($categories as $name => $category) {
	if (isset($dictionary[$name]) &&
		isset($dictionary[$name]['hidden_to_role_assignment']) &&
		$dictionary[$name]['hidden_to_role_assignment']
	) {
		unset($categories[$name]);
	}
}

$categories2 = array();
$categories2=$categories;
$hidden_categories = array(
"Campaigns","Forecasts",
"Emails","EmailTemplates","EmailMarketing","Reports","PdfManager");
foreach($hidden_categories as $v){
	if (isset($categories2[$v])) {
	   unset($categories2[$v]);
	}
}
$sugar_smarty->assign('CATEGORIES2', $categories2);
if(!empty($names))$tdwidth = 100 / sizeof($names);
$sugar_smarty->assign('ROLE', $role->toArray());
$sugar_smarty->assign('CATEGORIES', $categories);
$sugar_smarty->assign('TDWIDTH', $tdwidth);
$sugar_smarty->assign('ACTION_NAMES', $names);

$return= array('module'=>'ACLRoles', 'action'=>'DetailView', 'record'=>$role->id);
$sugar_smarty->assign('RETURN', $return);
$params = array();
$params[] = "<a href='index.php?module=ACLRoles&action=index'>{$mod_strings['LBL_MODULE_NAME']}</a>";
$params[] = $role->get_summary_text();
echo getClassicModuleTitle("ACLRoles", $params, true);
//$sugar_smarty->assign('TITLE', $title);
$hide_hide_supanels = true;

echo $sugar_smarty->fetch('modules/ACLRoles/DetailView.tpl');
//for subpanels the variable must be named focus;
$focus =& $role;
$_REQUEST['module'] = 'ACLRoles';
require_once('include/SubPanel/SubPanelTiles.php');

$subpanel = new SubPanelTiles($role, 'ACLRoles');

echo $subpanel->display();



?>
