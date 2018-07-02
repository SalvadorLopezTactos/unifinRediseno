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
require_once 'clients/base/api/UnifiedSearchApi.php';

class UnifiedSearchPortalApi extends UnifiedSearchApi {
    /**
     * This function is used to determine the search engine to use
     * @param $api ServiceBase The API class of the request
     * @param $args array The arguments array passed in from the API
     * @param $options array An array of options to pass through to the search engine, they get translated to the $searchOptions array so you can see exactly what gets passed through
     * @return string name of the Search Engine
     */
    protected function determineSugarSearchEngine(ServiceBase $api, array $args, array $options)
    {
        return 'SugarSearchEngine';
    }
}
