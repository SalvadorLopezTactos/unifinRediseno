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

require_once('vendor/nusoap//nusoap.php');

/**
 * Plugin management
 * @api
 */
class SugarPlugins
{
    /**
     * @const URL of the Sugar plugin server
     */
    const SUGAR_PLUGIN_SERVER = 'https://www.sugarcrm.com/crm/plugin_service.php?wsdl';

    /**
     * Constructor
     *
     * Initializes the SOAP session
     */
	public function __construct()
	{
		$this->server = new nusoapclient(self::SUGAR_PLUGIN_SERVER, TRUE);
		if ($this->server->getError())
			$this->server=false;
		else
			$this->proxy = $this->server->getProxy();
	}

	/**
     * Returns an array of available plugins to download for this instance
     *
     * @return array
     */
	public function getPluginList()
	{
		$plugins = array();
		if(!$this->server)return $plugins;
		$result = $this->proxy->get_plugin_list($GLOBALS['license']->settings['license_key'], $GLOBALS['sugar_version']);
		if(!empty($result[0]['item'])){
			$plugins = $result[0]['item'];
		}
		return $plugins;
	}

	/**
     * Returns the download token for the given plugin
     *
     * @param  string $plugin_id
     * @return string token
     */
    protected function _getPluginDownloadToken(
	    $plugin_id
	    )
	{
		$plugins = array();
		if(!$this->server)return $plugins;
		$result = $this->proxy->get_plugin_token($GLOBALS['license']->settings['license_key'], $GLOBALS['current_user']->id, $plugin_id);
		return $result['token'];
	}

	/**
     * Downloads the plugin from Sugar using an HTTP redirect
     *
     * @param  string $plugin_id
     */
    public function downloadPlugin(
	    $plugin_id
	    )
	{
		$token = $this->_getPluginDownloadToken($plugin_id);
		ob_clean();
		SugarApplication::redirect('https://www.sugarcrm.com/crm/plugin_service.php?token=' . $token );
	}
}
