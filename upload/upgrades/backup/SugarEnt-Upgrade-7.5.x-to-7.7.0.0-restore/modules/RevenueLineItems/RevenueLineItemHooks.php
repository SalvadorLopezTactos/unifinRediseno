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

class RevenueLineItemHooks
{
    /**
     * After the relationship is deleted, we need to resave the RLI.  This
     * will ensure that it will pick up an accout from the associated Opportunity.
     *
     * @param RevenueLineItem $bean
     * @param string $event
     * @param array $args
     */
    public static function afterRelationshipDelete($bean, $event, $args)
    {
        if ($event == 'after_relationship_delete') {
            if ($args['link'] == 'account_link') {
                $bean->save();
                return true;
            }
        }
        return false;
    }
}
