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

require_once 'clients/base/api/FilterApi.php';

class NotificationsApi extends FilterApi
{
    public function registerApiRest()
    {
        return array(
            'list' => array(
                'reqType' => 'GET',
                'path' => array('Notifications', 'pull', 'filter'),
                'pathVars' => array('module'),
                'method' => 'filterList',
                'ignoreMetaHash' => true,
            ),
        );
    }
}
