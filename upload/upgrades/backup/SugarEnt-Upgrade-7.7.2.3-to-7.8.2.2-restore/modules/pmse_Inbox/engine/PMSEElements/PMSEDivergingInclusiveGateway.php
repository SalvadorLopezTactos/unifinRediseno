<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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

require_once 'modules/pmse_Inbox/engine/PMSEElements/PMSEDivergingGateway.php';

class PMSEDivergingInclusiveGateway extends PMSEDivergingGateway
{
    /**
     *
     * @param type $flowData
     * @param type $bean
     * @param type $externalAction
     * @return type
     */
    public function run($flowData, $bean = null, $externalAction = '', $arguments = array())
    {
        $flowAction = 'CREATE';
        $filters = $this->filterFlows(
            'ALL',
            $this->retrieveFollowingFlows($flowData),
            $bean,
            $flowData
        );

        $routeAction = empty($filters) ? 'WAIT' : 'ROUTE';

        return $this->prepareResponse($flowData, $routeAction, $flowAction, $filters);
    }
}
