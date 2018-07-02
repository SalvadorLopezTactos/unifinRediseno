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

class SugarUpgradeEnableLegacyDashboard extends UpgradeScript
{
    public $order = 8999;
    public $type = self::UPGRADE_CUSTOM;

    /**
     * Add settings of enabling legacy dashboard to the file "config_override.php".
     *
     * @throws Exception if the file "config_override.php" is not writable or the writing fails.
     */
    public function run()
    {
        // If the from_version is less than 7, we need to enable the legacy dashboards
        if (version_compare($this->from_version, '7.0.0', '<')) {

            // Append the new settings.
            $newSettings = array(
                'enable_legacy_dashboards' => true,
                'lock_homepage' => true,
            );

            if ($this->appendOverrideConfig($newSettings) === true) {
                $this->log('Legacy Dashboards Enabled!');
            }
        }
    }

    /**
     * Append a array of new settings to the file "config_override.php".
     * @param $settings Array of settings
     * @return bool
     * @throws Exception
     */
    public function appendOverrideConfig($settings)
    {
        $file = 'config_override.php';
        $sugar_config = array();

        if (file_exists($file)) {
            $this->upgrader->backupFile($file);
            include $file;
        }

        foreach ($settings as $key => $val) {
            $sugar_config[$key] = $val;
        }

        $out = "<?php\n // created: " . date('Y-m-d H:i:s') . "\n";
        foreach (array_keys($sugar_config) as $key) {
            $out .= override_value_to_string_recursive2('sugar_config', $key, $sugar_config[$key]);
        }

        if (!sugar_file_put_contents_atomic($file, $out)) {
            throw new Exception("Failed writing to the $file file.");
        }

        return true;
    }
}
