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
class ViewCfTest extends SugarView
{
	function ViewCfTest(){
		$this->options['show_footer'] = true;
		$this->options['show_header'] = true;
 		parent::SugarView();
 	}
 	
 	function display() {
 		require_once("include/Expressions/Dependency.php");
 		require_once("include/TemplateHandler/TemplateHandler.php");
 		$th = new TemplateHandler();
 		$depScript = $th->createDependencyJavascript(array(
 			'phone_office' => array(
 				'calculated' => true, 
 				"formula" => 'add(strlen($name), $employees)',
 				"enforced" => true,
 		)),array(), "EditView");
 		$smarty = new Sugar_Smarty();
 		$smarty->assign("dependencies", $depScript);
 		$smarty->display('modules/ExpressionEngine/tpls/cfTest.tpl');
 	}
}