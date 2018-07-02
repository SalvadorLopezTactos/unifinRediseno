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

require_once 'modules/pmse_Inbox/engine/PMSEElements/PMSEFlow.php';

class PMSESequenceFlow extends PMSEFlow
{
    /**
     * Run implementation for a bpm flow element
     * @param array $flowData
     * @param type $bean
     * @param type $externalAction
     * @return type
     * @codeCoverageIgnore
     */
    /*
        public function run($flowData, $bean = null, $externalAction = '', $arguments = array())
        {
            $accessManager = new PMSEAccessManagement();
            $activeLicense = $accessManager->expirationKey();
    //        $activeLicense=lookLicenced::look();
            $routeStatus = $activeLicense ? 'ROUTE' : 'FREEZE';
            $flowData['cas_flow_status'] = $routeStatus;
            return $this->prepareResponse($flowData, $routeStatus, 'CREATE');
        }
    */
}
