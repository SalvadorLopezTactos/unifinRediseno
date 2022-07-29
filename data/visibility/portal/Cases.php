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

namespace Sugarcrm\Sugarcrm\Visibility\Portal;

use Sugarcrm\Sugarcrm\Portal\Factory as PortalFactory;

/**
 * IMPORTANT NOTE: If the below logic is customised/changed, it will need to be updated also for the related object Notes on the Notes.php portal visibility rules
 * IMPORTANT NOTE: Notes have to be filtered based on the visible parent objects
 */
class Cases extends Portal
{
    public function addVisibilityQuery(\SugarQuery $query, array $options = [])
    {
        $accountsOfContact = PortalFactory::getInstance('Session')->getAccountIds();

        if (!empty($accountsOfContact)) {
            // Contact with Accounts
            $this->addVisibilityQueryForContactWithAccounts($query, $options);
        } else {
            // Contact without Accounts
            $this->addVisibilityQueryForContactWithoutAccount($query, $options);
        }

        $query->where()->equals($options['table_alias'] . '.portal_viewable', 1);
    }

    protected function addVisibilityQueryForContactWithAccounts(\SugarQuery $query, array $options = [])
    {
        $query->join($this->context->getAccountsRelationshipLink(), ['alias' => 'case_acct_portal'])->on()->in('case_acct_portal.id', PortalFactory::getInstance('Session')->getAccountIds());
    }

    protected function addVisibilityQueryForContactWithoutAccount(\SugarQuery $query, array $options = [])
    {
        $query->join($this->context->getContactsRelationshipLink(), ['alias' => 'case_cont_portal'])->on()->equals('case_cont_portal.id', PortalFactory::getInstance('Session')->getContactId());
    }
}
