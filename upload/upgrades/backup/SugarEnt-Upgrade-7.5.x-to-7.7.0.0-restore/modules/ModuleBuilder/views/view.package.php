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
require_once('modules/ModuleBuilder/MB/AjaxCompose.php');
require_once('modules/ModuleBuilder/MB/ModuleBuilder.php');
class Viewpackage extends SugarView
{
 	/**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
	    global $mod_strings;
	    
    	return array(
    	   translate('LBL_MODULE_NAME','Administration'),
    	   ModuleBuilderController::getModuleTitle(),
    	   );
    }

	function display()
	{
 		global $mod_strings;
 		$smarty = new Sugar_Smarty();
 		$mb = new ModuleBuilder();
 		//if (!empty($_REQUEST['package'])) {
 		if (empty($_REQUEST['package']) && empty($_REQUEST['new'])) {
 			$this->generatePackageButtons($mb->getPackageList());

 			$smarty->assign('buttons', $this->buttons);
 			$smarty->assign('title', $GLOBALS['mod_strings']['LBL_MODULEBUILDER']);
 			$smarty->assign("question", $GLOBALS['mod_strings']['LBL_QUESTION_PACKAGE']);
 			$smarty->assign("defaultHelp", "mbHelp");

 			$ajax = new AjaxCompose();
 			$ajax->addCrumb($GLOBALS['mod_strings']['LBL_MODULEBUILDER'], 'ModuleBuilder.getContent("module=ModuleBuilder&action=package")');
			$ajax->addCrumb($GLOBALS['mod_strings']['LBL_PACKAGE_LIST'],'');
 			$ajax->addSection('center', $GLOBALS['mod_strings']['LBL_PACKAGE_LIST'], $smarty->fetch('modules/ModuleBuilder/tpls/wizard.tpl'));
			echo $ajax->getJavascript();
 		}
 		else {
 			
 			$name = (!empty($_REQUEST['package']))?$_REQUEST['package']:'';
			$mb->getPackage($name);
			
            require_once ('modules/ModuleBuilder/MB/MBPackageTree.php') ;
            $mbt = new MBPackageTree();
            $nodes = $mbt->fetchNodes();
            
			$package_labels = array();
			if(!empty($nodes['tree_data']['nodes']))
			{
				foreach($nodes['tree_data']['nodes'] as $entry) 
				{
					if(!empty($entry['data']['label']) && $name != $entry['data']['label'])
					{
						$package_labels[] = strtoupper($entry['data']['label']);
					}
				}
			}
			
			$json = getJSONobj();
			$smarty->assign('package_labels', $json->encode($package_labels));            	
			
	 		$this->package =& $mb->packages[$name];
	 		$this->loadModuleTypes();
	 		$this->loadPackageHelp($name);
	 		$this->package->date_modified = $GLOBALS['timedate']->to_display_date_time($this->package->date_modified);
	 		$smarty->assign('package', $this->package);
			$smarty->assign('mod_strings',$mod_strings);
	 		$smarty->assign('package_already_deployed', 'false');
            foreach($this->package->modules as $a_module){
                if(in_array($a_module->key_name, $GLOBALS['moduleList'])){
	 		        $smarty->assign('package_already_deployed', 'true');
                    break;
                }
            }

	 		$ajax = new AjaxCompose();
	 		$ajax->addCrumb($GLOBALS['mod_strings']['LBL_MODULEBUILDER'], 'ModuleBuilder.getContent("module=ModuleBuilder&action=package")');
			if(empty($name))$name = $mod_strings['LBL_NEW_PACKAGE'];
	 		$ajax->addCrumb($name,'');
	 		$html=$smarty->fetch('modules/ModuleBuilder/tpls/MBPackage/package.tpl');
	 		if(!empty($_REQUEST['action']) && $_REQUEST['action']=='SavePackage')
	 			$html.="<script>ModuleBuilder.treeRefresh('ModuleBuilder')</script>";
	 		$ajax->addSection('center', translate('LBL_SECTION_PACKAGE', 'ModuleBuilder'), $html);
			echo $ajax->getJavascript();
 		}
 	}

 	function loadModuleTypes()
 	{
 		$this->package->moduleTypes = array();
 		$this->package->loadModules();
 		foreach(array_keys($this->package->modules) as $name){
 			foreach($this->package->modules[$name]->config['templates'] as $template=>$var){

 					$this->package->moduleTypes[$name] = $template;

 			}
 		}
 	}
 	function loadPackageHelp(
 	    $name
 	    )
 	{
 			$this->package->help['default'] = (empty($name))?'create':'modify';
 			$this->package->help['group'] = 'package';
 	}

 	function generatePackageButtons(
 	    $packages
 	    )
 	{
 		global $mod_strings;
 		$this->buttons[$mod_strings['LBL_NEW_PACKAGE']] = array(
 										'action' => "module=ModuleBuilder&action=package&new=1",
 										'imageTitle' => 'package_create',
 										'size' => '64',
										'help' => 'newPackage',
                                        'linkId' => 'newPackageLink'
 										);
 		foreach($packages as $package) {
 			$this->buttons[$package] = array(
 										'action' =>"module=ModuleBuilder&action=package&package={$package}",
										'imageTitle' => 'package',
										'size' => '64',
 										);
 		}
 	}
}