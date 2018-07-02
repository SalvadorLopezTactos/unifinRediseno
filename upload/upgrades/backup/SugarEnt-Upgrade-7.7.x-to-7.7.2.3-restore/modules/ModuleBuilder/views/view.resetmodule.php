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
require_once ('modules/ModuleBuilder/MB/AjaxCompose.php') ;
require_once ('modules/ModuleBuilder/MB/ModuleBuilder.php') ;
require_once ('modules/ModuleBuilder/Module/StudioModule.php') ;
require_once ('modules/ModuleBuilder/Module/StudioBrowser.php') ;
require_once ('modules/DynamicFields/DynamicField.php') ;
require_once 'modules/ModuleBuilder/Module/StudioModuleFactory.php' ;
require_once 'modules/ModuleBuilder/parsers/views/DeployedMetaDataImplementation.php';

class ViewResetmodule extends SugarView
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
        $moduleName = $this->module = $_REQUEST['view_module'];
        if (isset($_REQUEST['handle']) && $_REQUEST['handle'] == "execute") {
            return $this->handleSave();
        }

        $ajax = new AjaxCompose ( ) ;
        $ajax->addCrumb ( translate('LBL_STUDIO'), 'ModuleBuilder.main("studio")' ) ;
        $ajax->addCrumb ( translate($moduleName), 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard&view_module=' . $moduleName . '")' ) ;
        $ajax->addCrumb ( translate('LBL_RESET') . " " . translate($moduleName) , '') ;

        $smarty = new Sugar_Smarty ( ) ;
        $smarty->assign("module", $moduleName);
        $smarty->assign("actions", array(
            array("name" => "relationships", "label" => translate("LBL_CLEAR_RELATIONSHIPS")),
            array("name" => "fields", "label" => translate("LBL_REMOVE_FIELDS")),
            array("name" => "layouts", "label" => translate("LBL_RESET_LAYOUTS")),
            array("name" => "labels", "label" => translate("LBL_RESET_LABELS")),
			array("name" => "extensions", "label" => translate("LBL_CLEAR_EXTENSIONS")),
        ));

        $ajax->addSection (
            'center',
            "Reset ". translate($moduleName) ,
            $smarty->fetch('modules/ModuleBuilder/tpls/resetModule.tpl') //"This works now"
        ) ;

        echo $ajax->getJavascript () ;
    }

    function handleSave()
    {
        $out = "<script>ajaxStatus.flashStatus(SUGAR.language.get('app_strings', 'LBL_REQUEST_PROCESSED'), 2000);</script>";

        if (!empty($_REQUEST['relationships']))
            $out .= $this->removeCustomRelationships();

        if (!empty($_REQUEST['fields']))
            $out .= $this->removeCustomFields();

        if (!empty($_REQUEST['layouts']))
            $out .= $this->removeCustomLayouts();

		if (!empty($_REQUEST['labels']))
            $out .= $this->removeCustomLabels();

		if (!empty($_REQUEST['extensions']))
            $out .= $this->removeCustomExtensions();

        if($this->module === 'Opportunities') {
            $opp_settings = Opportunity::getSettings();
            if ($opp_settings['opps_view_by'] == 'RevenueLineItems') {
                require_once 'modules/Opportunities/include/OpportunityWithRevenueLineItem.php';
                $opp_setup = new OpportunityWithRevenueLineItem();
                $opp_setup->doMetadataConvert();
                $out .= 'Enabling Opportunities with RevenueLineItems<br />';
            }
        }


        $out .= "Complete!";

        $ajax = new AjaxCompose ( ) ;

        $ajax->addCrumb ( translate('LBL_STUDIO'), 'ModuleBuilder.main("studio")' ) ;
        $ajax->addCrumb ( translate($this->module), 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard&view_module=' . $this->module . '")' ) ;
        $ajax->addCrumb ( "Reset ". translate($this->module) , '') ;


        $ajax->addSection (
            'center',
            "Reset ". translate($this->module) ,
            $out
        ) ;

        echo $ajax->getJavascript () ;
    }

    /**
     * Removes all custom fields created in studio
     *
     * @return html output record of the field deleted
     */
    function removeCustomFields()
    {
        $moduleName = $this->module;
        $seed = BeanFactory::getBean($moduleName);
        $df = new DynamicField ( $moduleName ) ;
        $df->setup ( $seed ) ;


        $module = StudioModuleFactory::getStudioModule( $moduleName ) ;
        $customFields = array();
        foreach($seed->field_defs as $def) {
            if (isset($def['custom_module']) && $def['custom_module'] === $moduleName) {
               $field = $df->getFieldWidget($moduleName, $def['name']);
                // the field may have already been deleted
                if ($field) {
                    $field->delete($df);
                }

               $module->removeFieldFromLayouts( $def['name'] );
               $customFields[] = $def['name'];
            }
        }
        $out = "";
        foreach ($customFields as $field) {
            $out .= "Removed field $field<br/>";
        }
        return ($out);
    }

    /**
     * Removes the metadata files for all known studio layouts.
     *
     * @return html output record of the files deleted
     */
    function removeCustomLayouts()
    {
        $module = StudioModuleFactory::getStudioModule( $this->module ) ;
        $sources = $module->getViewMetadataSources();

        // Add in search/filters here rather than in the StudioModule object
        $sources[] = array('type'  => MB_FILTERVIEW);
        $sources[] = array('type'  => MB_BWCFILTERVIEW);

        $out = "";

        // list of existing platforms including BWC
        $platforms = MetaDataManager::getPlatformList();
        array_unshift($platforms, '');

        // Flag to tell the autoloader whether to save itself or not when done
        $saveMap = false;

        foreach($sources as $view)
        {
            foreach ($platforms as $platform) {
                $file = MetaDataFiles::getDeployedFileName(
                    $view['type'],
                    $this->module,
                    MB_CUSTOMMETADATALOCATION,
                    $platform
                );

                // Ensure we are working on files that the autoloader knows about
                if (SugarAutoLoader::fileExists($file)) {
                    // Since we are in a loop inside of a loop do NOT send the
                    // save flag as true to unlink() but be sure to save the file
                    // map after the process is finished so that all changes to
                    // the map are saved.
                    SugarAutoLoader::unlink($file);
                    $out .= "Removed layout {$view['type']}.php<br/>";

                    // Tell the autoloader to save itself
                    $saveMap = true;
                }
            }
        }

        // now clear the cache
        include_once ('include/TemplateHandler/TemplateHandler.php') ;
        TemplateHandler::clearCache ( $this->module ) ;

        // If the file map needs saving, handle that now
        if ($saveMap) {
            SugarAutoLoader::saveMap();
        }

        return $out;
    }

    /**
     * Removes all custom relationships containing this module
     *
     * @return html output record of the files deleted
     */
    function removeCustomRelationships()
    {
    	require_once 'modules/ModuleBuilder/parsers/relationships/DeployedRelationships.php' ;
        $out = "";
        $madeChanges = false;
        $relationships = new DeployedRelationships ( $this->module ) ;

        foreach ( $relationships->getRelationshipList () as $relationshipName )
        {
            $rel = $relationships->get ( $relationshipName )->getDefinition () ;
            if ($rel [ 'is_custom' ] || (isset($rel [ 'from_studio' ]) && $rel [ 'from_studio' ])) {
                $relationships->delete ($relationshipName);
                $out .= "Removed relationship $relationshipName<br/>";
            }
        }
        if ($madeChanges)
           $relationships->save () ;

        return $out;
    }

    function removeCustomLabels()
    {
        $out = "";
		$languageDir = "custom/modules/{$this->module}/language";
        if (is_dir($languageDir)) {
            $files = scandir($languageDir);
            foreach ($files as $langFile) {
                if (substr($langFile, 0 ,1) == '.') continue;
				$language = substr($langFile, 0, strlen($langFile) - 9);
                SugarAutoLoader::unlink($languageDir . "/" . $langFile, true);

				LanguageManager::clearLanguageCache ( $this->module, $language ) ;
				$out .= "Removed language file $langFile<br/>";
            }
        }

		return $out;
    }

	function removeCustomExtensions()
	{
        $out = "";
        $extDir = "custom/Extension/modules/{$this->module}";
        if (is_dir($extDir)) {
        	rmdir_recursive($extDir);
        	require_once ('modules/Administration/QuickRepairAndRebuild.php') ;
            $rac = new RepairAndClear ( ) ;
            $rac->repairAndClearAll ( array ( 'clearAll' ), array ( $this->module ), true, false ) ;
			$rac->rebuildExtensions();
            // This allows the rebuilding of module only metadata 
            $rac->repairMetadataAPICache(false);
        	$out .= "Cleared extensions for {$this->module}<br/>";
        }

        return $out;
    }
}
