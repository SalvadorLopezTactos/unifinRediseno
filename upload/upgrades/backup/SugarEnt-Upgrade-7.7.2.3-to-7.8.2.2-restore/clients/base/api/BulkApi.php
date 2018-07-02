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
require_once 'include/api/BulkRestService.php';
require_once 'include/api/BulkRestRequest.php';
require_once 'include/api/BulkRestResponse.php';

/**
 * Bulk API calls
 *
 */
class BulkApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'bulkCall' => array(
                'reqType' => 'POST',
                'path' => array('bulk'),
                'pathVars' => array(''),
                'method' => 'bulkCall',
                'shortHelp' => 'Run several API call in a sequence',
                'longHelp' => 'include/api/help/bulk_post_help.html',
            ),
        );
    }

    /**
     * Bulk API call
     * @param ServiceBase $api
     * @param array $args
     * @throws SugarApiExceptionMissingParameter
     * @return array
     */
    public function bulkCall($api, $args)
    {
        $this->requireArgs($args,array('requests'));
        $restResp = new BulkRestResponse($_SERVER);
        // reset vars so they won't confuse the child service
        $_GET = array(); $_POST = array();
        foreach($args['requests'] as $name => $request) {
            if(empty($request['url'])) {
                $GLOBALS['log']->fatal("Bulk Api: URL missing for request $name");
                throw new SugarApiExceptionMissingParameter("Invalid request - URL is missing");
            }
        }
        // check all reqs first so that we don't execute any reqs if one of them is broken
        foreach($args['requests'] as $name => $request) {
            $restReq = new BulkRestRequest($request);
            $restResp->setRequest($name);
            /**
             * @var $rest RestService
             */
            $rest = new BulkRestService($api);
            $rest->setRequest($restReq);
            $rest->setResponse($restResp);
            $rest->execute();

        }
        return $restResp->getResponses();
    }
}
