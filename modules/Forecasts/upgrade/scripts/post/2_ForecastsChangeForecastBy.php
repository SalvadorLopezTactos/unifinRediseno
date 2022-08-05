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
 
class SugarUpgradeForecastsChangeForecastBy extends UpgradeScript
{
    public $order = 2190;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        //Only run this on ent upgrades
        if (!$this->toFlavor("ent")) {
            return;
        }
        
        $this->log('Changing Forecast by from Opportunities to Revenue Line Items');
        $sql = "UPDATE config " .
               "SET value = 'RevenueLineItems' " .
               "WHERE category = 'Forecasts' " .
               "AND name = 'forecast_by'";
        $this->db->query($sql);

        $this->log('Done Changing Forecast by from Opportunities to Revenue Line Items');
    }
}
