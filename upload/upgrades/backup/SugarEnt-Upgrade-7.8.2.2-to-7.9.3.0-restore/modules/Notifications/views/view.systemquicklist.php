<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

use Sugarcrm\Sugarcrm\Security\InputValidation\Request;

require_once('modules/Notifications/views/view.quicklist.php');

class ViewSystemQuicklist extends ViewQuickList{

    /**
     * @deprecated Use __construct() instead
     */
    public function ViewSystemQuicklist($bean = null, $view_object_map = array(), Request $request = null)
    {
        self::__construct($bean, $view_object_map, $request);
    }

    public function __construct($bean = null, $view_object_map = array(), Request $request = null)
    {
        parent::__construct($bean, $view_object_map, $request);
    }

	function display()
	{
		$GLOBALS['system_notification_buffer'] = array();
		$GLOBALS['buffer_system_notifications'] = true;
		$GLOBALS['system_notification_count'] = 0;
		$sv = new SugarView();
		$sv->includeClassicFile('modules/Administration/DisplayWarnings.php');
	    
		echo $this->_formatNotificationsForQuickDisplay($GLOBALS['system_notification_buffer'], "modules/Notifications/tpls/systemQuickView.tpl");

        $this->clearFTSFlags();
	}
    /**
     * After the notification is displayed, clear the fts flags
     * @return null
     */
    protected function clearFTSFlags() {
        if (is_admin($GLOBALS['current_user']))
        {
            $admin = Administration::getSettings();
            if (!empty($settings->settings['info_fts_index_done']))
            {
                $admin->saveSetting('info', 'fts_index_done', 0);
            }
            // remove notification disabled notification
            $cfg = new Configurator();
            $cfg->config['fts_disable_notification'] = false;
            $cfg->handleOverride();
        }        
    }
}
