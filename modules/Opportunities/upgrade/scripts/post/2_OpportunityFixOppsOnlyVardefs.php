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

class SugarUpgradeOpportunityFixOppsOnlyVardefs extends UpgradeScript
{
    public $order = 2200;
    public $type = self::UPGRADE_CUSTOM;

    public function run()
    {
        // In the 10_0 backport, we want this upgrader to run for any versions
        // between 9.3 when the bug was introduced and 10.0.2 when this upgrade
        // script is introduced
        if ($this->toFlavor('ent') &&
            version_compare($this->from_version, '9.3.0', '>=') &&
            version_compare($this->from_version, '10.0.2', '<=')) {
            $settings = Opportunity::getSettings();
            // If we're in Opps Only mode, run the fixed converter to fix vardefs
            if (isset($settings['opps_view_by']) &&
                $settings['opps_view_by'] !== 'RevenueLineItems') {
                SugarAutoLoader::load('modules/Opportunities/include/OpportunityWithOutRevenueLineItem.php');
                $converter = new OpportunityWithOutRevenueLineItem();
                $converter->fixOpportunityModule();
            }
        }
    }
}
