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



global $app_list_strings;// $modInvisList;

$sugar_smarty = new Sugar_Smarty();

$sugar_smarty->assign('MOD', $mod_strings);
$sugar_smarty->assign('APP', $app_strings);
$sugar_smarty->assign('ISDUPLICATE', '');
$duplicateString='';
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
		$sugar_smarty->assign('ISDUPLICATE', $_REQUEST['record']);
		$duplicateString=translate('LBL_DUPLICATE_OF', 'ACLRoles');
	}else{
		$return['record']= $role->id;
		$return['action']='DetailView';
	}

}else{
	$categories = ACLRole::getRoleActions('');
}
$sugar_smarty->assign('ROLE', $role->toArray());
$tdwidth = 10;

if(isset($_REQUEST['return_module'])){
	$return['module']=$_REQUEST['return_module'];
	if(isset($_REQUEST['return_id']))$return['record']=$_REQUEST['return_id'];
	if(isset($_REQUEST['return_record'])){$return['record']=$_REQUEST['return_record'];}
    if(isset($_REQUEST['return_action'])){$return['action']=$_REQUEST['return_action'];}
    if ( !empty($return['record']) ) {
        $return['action'] = 'DetailView';
    }
}

$sugar_smarty->assign('RETURN', $return);
$names = ACLAction::setupCategoriesMatrix($categories);

$sugar_smarty->assign('CATEGORIES', $categories);
$sugar_smarty->assign('TDWIDTH', $tdwidth);
$sugar_smarty->assign('ACTION_NAMES', $names);

$params = array();
$params[] = "<a href='index.php?module=ACLRoles&action=index'>{$mod_strings['LBL_MODULE_NAME']}</a>";
if(empty($role->id)){
	$params[] = $GLOBALS['app_strings']['LBL_CREATE_BUTTON_LABEL'];
}else{
	$params[] = $role->get_summary_text();
}
echo getClassicModuleTitle("ACLRoles", $params, true);

$buttons = array(
	"<input title=".$app_strings['LBL_SAVE_BUTTON_TITLE']." id='save_button'
		accessKey=".$app_strings['LBL_SAVE_BUTTON_KEY']." class='button primary'
		onclick=\"this.form.action.value='Save';return check_form('EditView');\"
		type='submit' name='button' value=".$app_strings['LBL_SAVE_BUTTON_LABEL']." >",
	"<input title=".$app_strings['LBL_CANCEL_BUTTON_TITLE']."
		class='button cancel_button' accessKey=".$app_strings['LBL_CANCEL_BUTTON_KEY']."
		type='submit' name='save' value=".$app_strings['LBL_CANCEL_BUTTON_LABEL']."
		onclick=\"document.EditView.action.value='".$return['action']."';document.EditView.module.value='".$return['module']."';document.EditView.record.value='".$return['record']."';document.EditView.submit();\">",
);

$action_buttons = $buttons;
$sugar_smarty->assign('ACTION_MENU', $action_buttons);
echo $sugar_smarty->fetch('modules/ACLRoles/EditView.tpl');

?>