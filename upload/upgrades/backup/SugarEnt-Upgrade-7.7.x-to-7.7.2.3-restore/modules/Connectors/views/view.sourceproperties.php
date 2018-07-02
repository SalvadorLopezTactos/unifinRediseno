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

class ViewSourceProperties extends ViewList {
   
 	function ViewSourceProperties(){
 		parent::ViewList();
 	}

    public function display()
    {
        global $sugar_config;

		require_once('include/connectors/sources/SourceFactory.php');
		require_once('include/connectors/utils/ConnectorUtils.php');
		
		$source_id = $_REQUEST['source_id'];
		$connector_language = ConnectorUtils::getConnectorStrings($source_id);
    	$source = SourceFactory::getSource($source_id);
    	$properties = $source->getProperties();
        
    	$required_fields = array();
    	$config_fields = $source->getRequiredConfigFields();
	    $fields = $source->getRequiredConfigFields();
	    foreach($fields as $field_id) {
	    	$label = isset($connector_language[$field_id]) ? $connector_language[$field_id] : $field_id;
	        $required_fields[$field_id]=$label;
	    }

        // treat string as a template (the string resource plugin is unavailable in the current Smarty version)
        if (isset($connector_language['LBL_LICENSING_INFO'])) {
            $siteUrl = rtrim($sugar_config['site_url'], '/');
            $connector_language['LBL_LICENSING_INFO'] = str_replace(
                '{$SITE_URL}',
                $siteUrl,
                $connector_language['LBL_LICENSING_INFO']
            );
        }

    	$this->ss->assign('required_properties', $required_fields);
    	$this->ss->assign('source_id', $source_id);
    	$this->ss->assign('properties', $properties);
    	$this->ss->assign('mod', $GLOBALS['mod_strings']);
    	$this->ss->assign('app', $GLOBALS['app_strings']);
    	$this->ss->assign('connector_language', $connector_language);
    	$this->ss->assign('hasTestingEnabled', $source->hasTestingEnabled());

        echo $this->ss->fetch($this->getCustomFilePathIfExists('modules/Connectors/tpls/source_properties.tpl'));
    }
}

