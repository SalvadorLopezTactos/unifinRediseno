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

class SugarUpgradeOpportunityFixOppsOnlyMetadata extends UpgradeScript
{
    public $order = 7030;
    public $type = self::UPGRADE_CUSTOM;

    public function run()
    {
        if ($this->toFlavor('ent') && !Opportunity::usingRevenueLineItems()) {
            $fieldMap = [
                'service_start_date' => false,
                'sales_status' => false,
            ];
            SugarAutoLoader::load('modules/Opportunities/include/OpportunityViews.php');
            $view = new OpportunityViews();
            $view->processBaseRecordLayout($fieldMap);
            $view->processMobileRecordLayout($fieldMap);
            $view->processPreviewLayout($fieldMap);
            $view->processListViews($fieldMap);
        }
    }
}
