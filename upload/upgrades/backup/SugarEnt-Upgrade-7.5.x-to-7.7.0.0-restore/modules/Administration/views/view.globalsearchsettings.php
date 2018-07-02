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
require_once('include/SugarSearchEngine/SugarSearchEngineFullIndexer.php');
require_once('include/SugarSearchEngine/SugarSearchEngineMetadataHelper.php');
require_once('include/SugarSearchEngine/SugarSearchEngineFactory.php');
require_once('include/SugarSearchEngine/SugarSearchEngineAbstractBase.php');
require_once('modules/Administration/Administration.php');

class AdministrationViewGlobalsearchsettings extends SugarView
{
 	/**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
	    global $mod_strings;

    	return array(
    	   "<a href='index.php?module=Administration&action=index'>".translate('LBL_MODULE_NAME','Administration')."</a>",
    	   $mod_strings['LBL_GLOBAL_SEARCH_SETTINGS']
    	   );
    }

    /**
	 * @see SugarView::_getModuleTab()
	 */
	protected function _getModuleTab()
    {
        return 'Administration';
    }

    /**
	 * @see SugarView::display()
	 */
	public function display()
    {
    	require_once('modules/Home/UnifiedSearchAdvanced.php');
		$usa = new UnifiedSearchAdvanced();
        global $mod_strings, $app_strings, $app_list_strings, $current_user;

        $sugar_smarty = new Sugar_Smarty();
        $sugar_smarty->assign('APP', $app_strings);
        $sugar_smarty->assign('MOD', $mod_strings);
        $sugar_smarty->assign('moduleTitle', $this->getModuleTitle(false));

        $modules = $usa->retrieveEnabledAndDisabledModules();

        $sugar_smarty->assign('enabled_modules', json_encode($modules['enabled']));
        $sugar_smarty->assign('disabled_modules', json_encode($modules['disabled']));

        $defaultEngine = SugarSearchEngineFactory::getFTSEngineNameFromConfig();
        $config = $GLOBALS['sugar_config']['full_text_engine'][$defaultEngine];
        $justRequestedAScheduledIndex = !empty($_REQUEST['sched']) ? true : false;
        $hide_fts_config = isset( $GLOBALS['sugar_config']['hide_full_text_engine_config'] ) ? $GLOBALS['sugar_config']['hide_full_text_engine_config'] : false;
        $showSchedButton = ($defaultEngine != '' && $this->isFTSConnectionValid()) ? true : false;

        $sugar_smarty->assign("showSchedButton", $showSchedButton);
        $sugar_smarty->assign("hide_fts_config", $hide_fts_config);
        $sugar_smarty->assign("fts_type", get_select_options_with_id($app_list_strings['fts_type'], $defaultEngine));
        $sugar_smarty->assign("fts_host", $config['host']);
        $sugar_smarty->assign("fts_port", $config['port']);
        $sugar_smarty->assign("fts_scheduled", !empty($schedulerID) && !$schedulerCompleted);
        $sugar_smarty->assign('justRequestedAScheduledIndex', $justRequestedAScheduledIndex);
        //End FTS
        if (is_admin($current_user))
        {
            if (!empty($GLOBALS['sugar_config']['fts_disable_notification']))
            {
                displayAdminError(translate('LBL_FTS_DISABLED', 'Administration'));
            }

            // if fts indexing is done, show the notification to admin
            $admin = Administration::getSettings();
            if (!empty($admin->settings['info_fts_index_done'])) {
                displayAdminError(translate('LBL_FTS_INDEXING_DONE', 'Administration'));
                // reset flag
                $admin->saveSetting('info', 'fts_index_done', 0);
            }
        }

        echo $sugar_smarty->fetch(SugarAutoLoader::existingCustomOne('modules/Administration/templates/GlobalSearchSettings.tpl'));

    }

    protected function isFTSConnectionValid()
    {
        $searchEngine = SugarSearchEngineFactory::getInstance();
        $result = $searchEngine->getServerStatus();
        if($result['valid']) {
            $this->setFTSUp();
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    /**
     * This method sets the full text search to available when a scheduled FTS Index occurs.  
     * An indexing can only occur with a valid connection
     * 
     * TODO: XXX Fix this to use admin settings not config options
     * @return bool
     */
    protected function setFTSUp() {
        $cfg = new Configurator();
        $cfg->config['fts_disable_notification'] = false;
        $cfg->handleOverride();
        // set it up
        SugarSearchEngineAbstractBase::markSearchEngineStatus(false);
        $admin = BeanFactory::newBean('Administration');
        $admin->retrieveSettings(FALSE, TRUE);
        return TRUE;
    }
}
