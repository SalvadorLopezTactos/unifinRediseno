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

require_once('include/MVC/View/views/view.list.php');
require_once('include/connectors/sources/SourceFactory.php');

class ViewDisplayProperties extends ViewList
{
 	/**
	 * @see SugarView::process()
	 */
	public function process()
	{
 		$this->options['show_all'] = false;
 		$this->options['show_javascript'] = true;
 		$this->options['show_footer'] = false;
 		$this->options['show_header'] = false;
 	    parent::process();
 	}

    /**
	 * @see SugarView::display()
	 */
	public function display()
	{
    	require_once('include/connectors/utils/ConnectorUtils.php');
    	$source = $_REQUEST['source_id'];
        $sources = ConnectorUtils::getConnectors();
        $modules_sources = ConnectorUtils::getDisplayConfig();

    	$enabled_modules = array();
    	$disabled_modules = array();

    	//Find all modules this source has been enabled for
    	foreach($modules_sources as $module=>$mapping) {
    		foreach($modules_sources[$module] as $entry) {
    			if($entry == $source) {
    			   $enabled_modules[$module] = isset($GLOBALS['app_list_strings']['moduleList'][$module]) ? $GLOBALS['app_list_strings']['moduleList'][$module] : $module;
    			}
    		}
   		}


    	global $moduleList, $beanList;
    	//Do filtering here?
    	$count = 0;
   		global $current_user;
		$access = $current_user->getDeveloperModules();
		foreach(SugarAutoLoader::getDirFiles("modules", true) as $e) {
            //Strip the 'modules/' portion out from beginning of $e
            $e = substr($e, 8);
		    if(empty($enabled_modules[$e]) && SugarAutoLoader::fileExists('modules/' . $e . '/metadata/studio.php')
		        && SugarAutoLoader::fileExists('modules/' . $e . '/metadata/detailviewdefs.php')
		        && isset($GLOBALS['beanList'][$e]) && (in_array($e, $access) || is_admin($current_user))) // installed modules must also exist in the beanList
		    {
		    	$disabled_modules[$e] = isset($GLOBALS['app_list_strings']['moduleList'][$e]) ? $GLOBALS['app_list_strings']['moduleList'][$e] : $e;
		    }
		}
        $s = SourceFactory::getSource($source);

        // Not all sources can be connected to all modules
        $enabled_modules = $s->filterAllowedModules($enabled_modules);
        $disabled_modules = $s->filterAllowedModules($disabled_modules);

		asort($enabled_modules);
    	asort($disabled_modules);

    	//$enabled = $json->encode($enabled_modules);
    	//$disabled = $json->encode($disabled_modules);
    	//$script = "addTable('{$module}', '{$enabled}', '{$disabled}', '{$source}', '{$GLOBALS['theme']}');\n";
    	//$this->ss->assign('new_modules_sources', $modules_sources);
    	//$this->ss->assign('dynamic_script', $script);

    	$this->ss->assign('enabled_modules', $enabled_modules);
    	$this->ss->assign('disabled_modules', $disabled_modules);
    	$this->ss->assign('source_id', $source);
    	$this->ss->assign('mod', $GLOBALS['mod_strings']);
    	$this->ss->assign('APP', $GLOBALS['app_strings']);
    	$this->ss->assign('theme', $GLOBALS['theme']);
   	    $this->ss->assign('external', !empty($sources[$source]['eapm']));
   	    $this->ss->assign('externalOnly', !empty($sources[$source]['eapm']['only']));

        // We don't want to tell the user to set the properties of the connector if there aren't any
        $fields = $s->getRequiredConfigFields();
   	    $this->ss->assign('externalHasProperties', !empty($fields));

   	    $this->ss->assign('externalChecked', !empty($sources[$source]['eapm']['enabled'])?" checked":"");
   	    echo $this->ss->fetch($this->getCustomFilePathIfExists('modules/Connectors/tpls/display_properties.tpl'));
    }
}
