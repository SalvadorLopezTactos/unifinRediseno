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

class SugarUpgradeOpportunityFixVardefs extends UpgradeScript
{
    public $order = 2200;
    public $type = self::UPGRADE_CUSTOM;

    public function run()
    {
        // Only applies to 9.3.x and 10.1.x. Fixed in 10.2.0+
        if ($this->toFlavor('ent') &&
            version_compare($this->from_version, '9.3.0', '>=') &&
            version_compare($this->from_version, '10.2.0', '<')
        ) {
            $getConverter = Opportunity::usingRevenueLineItems() ? 'getConverterWith' : 'getConverterWithout';
            $converter = $this->{$getConverter}();
            $converter->fixOpportunityModule();
        }
    }

    protected function getConverterWith()
    {
        $converter = new OpportunityWithRevenueLineItem();
        $converter->processFields();
        return $converter;
    }

    protected function getConverterWithout()
    {
        return new OpportunityWithOutRevenueLineItem();
    }
}
