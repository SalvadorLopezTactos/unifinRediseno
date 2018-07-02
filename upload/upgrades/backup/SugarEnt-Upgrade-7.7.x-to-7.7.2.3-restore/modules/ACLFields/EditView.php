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

class ACLFieldsEditView{
	function getView($module, $role_id){
		$fields = ACLField::getFields( $module, '', $role_id);
		$sugar_smarty = new Sugar_Smarty();
        $sugar_smarty->assign('LBL_MODULE', $module);

        $GLOBALS['mod_strings'] = return_module_language($GLOBALS['current_language'], 'ACLFields');
		$sugar_smarty->assign('MOD', $GLOBALS['mod_strings']);
		$sugar_smarty->assign('APP', $GLOBALS['app_strings']);
		$sugar_smarty->assign('FLC_MODULE', $module);
		$sugar_smarty->assign('APP_LIST', $GLOBALS['app_list_strings']);
		$sugar_smarty->assign('FIELDS', $fields);
		foreach($GLOBALS['aclFieldOptions'] as $key=>$option){
			$GLOBALS['aclFieldOptions'][$key] = translate($option, 'ACLFields');
		}
		$sugar_smarty->assign('OPTIONS',  $GLOBALS['aclFieldOptions']);
		$req_options = $GLOBALS['aclFieldOptions'];
		unset($req_options[-99]);
		$sugar_smarty->assign('OPTIONS_REQUIRED',  $req_options);
		return  $sugar_smarty->fetch('modules/ACLFields/EditView.tpl');
	}
}
?>