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
require_once('modules/ModuleBuilder/Module/StudioModule.php');
require_once('modules/ModuleBuilder/Module/StudioBrowser.php') ;
require_once('vendor/ytree/ExtNode.php') ;

class ViewHistory extends SugarView 
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

	//STUDIO LABELS ONLY//
 	//TODO Bundle Studio and ModuleBuilder label handling to increase maintainability.
 	function display()
 	{
		$root = new ExtNode('root', 'root', true);
		$sb = new StudioBrowser();
		$sb->loadModules();
		foreach($sb->modules as $name => $studioMod) {
			$root->add_node($this->buildStudioNode($studioMod));
		}
		$json = getJSONobj();
		echo($json->encode($root));
 	}
	
	/**
	 * 
	 * @return ExtNode built from the passed StudioModule
	 * @param $module StudioModule
	 */
	function buildStudioNode($module) {
		
	}

}
