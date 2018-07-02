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
/**
 * Update config.php settings
 */
class SugarUpgradeFixPMSESettings extends UpgradeScript
{
    public $order = 9000;
    public $type = self::UPGRADE_CUSTOM;

    /**
     * PMSE Default config values
     *
     * @var array
     */
    public $pmseDefaults = array(
        'logger_level' => 'critical',
        'error_number_of_cycles' => '10',
        'error_timeout' => '40',
    );

    public function run()
    {
        // Originally the only supported upgrade for this was 7.6.0.0RC4 to 7.6.0.0
        // but this has been adapted to include all upgrades from 7.6RC4 up
        if (version_compare($this->from_version, '7.6.0.0RC4', '==') && version_compare($this->to_version, '7.6.0.0', '>=')) {
            // Get the known PMSE settings from the database
            $current = $this->getCurrentSettings();

            // Get the new default values
            $pmse = $this->getDefaultSettings();

            // Loop over current settings in the database, replacing default
            // settings with custom ones
            foreach ($current as $key => $val) {
                $pmse[$key] = $val;
            }

            $this->upgrader->config['pmse_settings_default'] = $pmse;

            // delete PMSESettings.php
            $this->fileToDelete('modules/pmse_Inbox/engine/PMSESettings.php');
        }
    }

    /**
     * Gets the currently stored pmse settings
     *
     * @return array
     */
    protected function getCurrentSettings()
    {
        $ret = array();
        $result = $GLOBALS['db']->query("select name, cfg_value from pmse_bpm_config");
        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $ret[$row['name']] = $row['cfg_value'];
        }
        return $ret;
    }

    /**
     * Gets the default settings for PMSE
     *
     * @return array
     */
    protected function getDefaultSettings()
    {
        return $this->pmseDefaults;
    }
}
