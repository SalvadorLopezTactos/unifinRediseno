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




global $app_list_strings, $modInvisList;

$sugar_smarty = new Sugar_Smarty();

$sugar_smarty->assign('MOD', $mod_strings);
$sugar_smarty->assign('APP', $app_strings);
//mass localization
/*foreach($modInvisList as $modinvisname){
    $app_list_strings['moduleList'][$modinvisname] = $modinvisname;
}*/
$sugar_smarty->assign('APP_LIST', $app_list_strings);
/*foreach($modInvisList as $modinvisname){
    unset($app_list_strings['moduleList'][$modinvisname]);
}*/
$role = BeanFactory::getBean('ACLRoles');
$role_name = '';
$return= array('module'=>'ACLRoles', 'action'=>'index', 'record'=>'');
if(!empty($_REQUEST['record'])){
	$role->retrieve($_REQUEST['record']);
	$categories = ACLRole::getRoleActions($_REQUEST['record']);
	
	$role_name =  $role->name;
	if(!empty($_REQUEST['isDuplicate'])){
		//role id is stripped here in duplicate so anything using role id after this will not have it
		$role->id = '';
	}else{
		$return['record']= $role->id;
		$return['action']='DetailView';
	}
	
}else{
	$categories = ACLRole::getRoleActions('');
}

// Skipping modules that have 'hidden_to_role_assignment' property
foreach ($categories as $name => $category) {
	if (isset($dictionary[$name]) &&
		isset($dictionary[$name]['hidden_to_role_assignment']) &&
		$dictionary[$name]['hidden_to_role_assignment']
	) {
		unset($categories[$name]);
	}
}

if (in_array('Project', $modInvisList)) {
    unset($categories['Project']);
    unset($categories['ProjectTask']);
}
$sugar_smarty->assign('ROLE', $role->toArray());
$tdwidth = 10;

if(isset($_REQUEST['return_module'])){
	$return['module']=$_REQUEST['return_module'];
	if(isset($_REQUEST['return_action']))$return['action']=$_REQUEST['return_action'];
	if(isset($_REQUEST['return_record']))$return['record']=$_REQUEST['return_record'];
}

$sugar_smarty->assign('RETURN', $return);
$names = ACLAction::setupCategoriesMatrix($categories);
if(!empty($names))$tdwidth = 100 / sizeof($names);
$sugar_smarty->assign('CATEGORIES', $categories);
$sugar_smarty->assign('CATEGORY_NAME', $_REQUEST['category_name']);
$sugar_smarty->assign('TDWIDTH', $tdwidth);
$sugar_smarty->assign('ACTION_NAMES', $names);

$actions = null;
if (isset($categories[$_REQUEST['category_name']]['module']))
{
    $actions = $categories[$_REQUEST['category_name']]['module'];
}

$sugar_smarty->assign('ACTIONS', $actions);
ob_clean();

if($_REQUEST['category_name'] == 'All'){
	echo $sugar_smarty->fetch('modules/ACLRoles/EditAllBody.tpl');	
}else{
//WDong Bug 23195: Strings not localized in Role Management.
echo getClassicModuleTitle($_REQUEST['category_name'],array($app_list_strings['moduleList'][$_REQUEST['category_name']]), false);
echo $sugar_smarty->fetch('modules/ACLRoles/EditRole.tpl');
require_once('modules/ACLFields/EditView.php');
echo ACLFieldsEditView::getView($_REQUEST['category_name'],  $role->id);
echo '</form>';
}
sugar_cleanup(true);