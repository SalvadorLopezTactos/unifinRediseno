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

/**
 * Class ProductConsoleHelper
 *
 * Helper methods for Product Console manipulation and retrieval.
 */
class ProductConsoleHelper
{
    public static $renewalsConsoleId = 'da438c86-df5e-11e9-9801-3c15c2c53980';

    /**
     * Check if RLI is enabled.
     *
     * @return bool
     */
    public function useRevenueLineItems(): bool
    {
        // get the OpportunitySettings
        $settings = Opportunity::getSettings();
        return (isset($settings['opps_view_by']) && $settings['opps_view_by'] === 'RevenueLineItems');
    }

    /**
     * Remove renewals console for ops only.
     * @param SugarBean $bean
     * @param string $event
     * @param array $args
     */
    public function removeRenewalsConsole(SugarBean $bean, string $event, array $args)
    {
        if (!$this->useRevenueLineItems() && isset($args[0]) && $args[0] instanceof SugarQuery) {
            $args[0]->where()->notEquals('id', self::$renewalsConsoleId);
        }
    }

    /**
     * Checks if it's a renewals console for ops only.
     * @param SugarBean $bean
     * @param string $event
     * @param array $args
     * @throws SugarApiExceptionNotAuthorized
     */
    public function checkRenewalsConsole(SugarBean $bean, string $event, array $args)
    {
        if (!$this->useRevenueLineItems() && !empty($args['id']) && $args['id'] ===  self::$renewalsConsoleId) {
            throw new SugarApiExceptionNotAuthorized('SUGAR_API_EXCEPTION_RECORD_NOT_AUTHORIZED', ['view']);
        }
    }
}
