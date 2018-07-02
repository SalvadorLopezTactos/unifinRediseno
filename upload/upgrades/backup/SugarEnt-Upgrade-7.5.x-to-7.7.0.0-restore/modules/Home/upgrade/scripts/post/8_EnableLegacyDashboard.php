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

    public function run()
    {
        // If the from_version is less than 7, we need to enable the legacy dashboards
        if (version_compare($this->from_version, '7.0.0', '<')) {
            $config = new Configurator();
            $config->config['enable_legacy_dashboards'] = true;
            $config->config['lock_homepage'] = true;
            $config->handleOverride();
            $this->log('Legacy Dashboards Enabled!');
        }
    }
}
