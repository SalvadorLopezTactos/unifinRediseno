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

class SugarUpgradeRevenueLineItemMakeVisible extends UpgradeScript
{
    public $order = 2190;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        //Only run this on ent upgrades
        if (!$this->toFlavor("ent")) {
            return;
        }

        // this should be ran when upgrading from 6.x to 7.x and
        // this should only be ran when upgrading from pro or corp
        if (!(version_compare($this->from_version, '7', '<') &&
                version_compare($this->to_version, '7', '>=')) &&
            !in_array(strtolower($this->from_flavor), array('pro', 'corp'))) {
            return;
        }
        
        $this->log('Adding Revenue Line Items to Tabs');
        $sql = "SELECT value FROM config " .
               "WHERE category = 'MySettings' " .
                    "AND name = 'Tab' " .
                    "AND (platform = 'base' OR platform IS NULL)";
        $results = $this->db->query($sql);
        
        while ($row = $this->db->fetchRow($results)) {
            $tabArray = unserialize(base64_decode($row["value"]));
            if (!isset($tabArray["RevenueLineItems"])) {
                $tabArray[] = "RevenueLineItems";
                $sql = "UPDATE config " .
                       "SET value = '" . base64_encode(serialize($tabArray)) . "' " .
                       "WHERE category = 'MySettings' " .
                            "AND name = 'Tab' " .
                            "AND (platform = 'base' OR platform IS NULL)";
                $this->db->query($sql);
            }
        }

        $this->log('Done Adding Revenue Line Items to Tabs');
    }
}
