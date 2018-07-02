<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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

require_once('include/externalAPI/Dnb/ExtAPIDnb.php');

class DnbApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'dnbDirectGet' => array(
                'reqType' => 'GET',
                'path' => array('connector','dnb','?','?'),
                'pathVars' => array('connector','dnb','qtype','qparam'),
                'method' => 'dnbDirectGet',
                'shortHelp' => 'Invoke DNB API using GET',
                'longHelp' => 'include/api/help/dnb_get_help.html',
            ),
            'dnbDirectPost' => array(
                'reqType' => 'POST',
                'path' => array('connector','dnb','?'),
                'pathVars' => array('connector','dnb','qtype'),
                'method' => 'dnbDirectPost',
                'shortHelp' => 'Invoke DNB API using POST',
                'longHelp' => 'include/api/help/dnb_post_help.html',
            ),
            'dnbAccountsBAL' => array(
                'reqType' => 'POST',
                'path' => array('connector', 'dnb', 'Accounts', 'bal'),
                'pathVars' => array('connector', 'dnb', 'Accounts', 'bal'),
                'method' => 'dnbAccountsBAL',
                'shortHelp' => 'Invoke BAL For Accounts',
                'longHelp' => 'include/api/help/dnb_post_help.html',
            ),
            'dnbContactsBAL' => array(
                'reqType' => 'POST',
                'path' => array('connector', 'dnb', 'Contacts', 'bal'),
                'pathVars' => array('connector', 'dnb', 'Contacts', 'bal'),
                'method' => 'dnbContactsBAL',
                'shortHelp' => 'Invoke BAL For Contacts',
                'longHelp' => 'include/api/help/dnb_post_help.html',
            ),
            'dnbBulkImport' => array(
                'reqType' => 'POST',
                'path' => array('connector', 'dnb', '?', 'bulkimport'),
                'pathVars' => array('connector', 'dnb', 'module', 'bulkimport'),
                'method' => 'dnbBulkImport',
                'shortHelp' => 'Bulk Import D&B Objects',
                'longHelp' => 'include/api/help/dnb_bulkimport_help.html',
            ),
            'dnbMeter' => array(
                'reqType' => 'GET',
                'path' => array('connector','dnb','meter'),
                'pathVars' => array('connector','dnb','meter'),
                'method' => 'dnbMeter',
                'shortHelp' => 'Invoke DNB API using GET',
                'longHelp' => 'include/api/help/dnb_get_help.html',
                'keepSession' => true,
            ),
        );
    }

    /**
     * gets dnb EAPM
     * @return array|bool|ExternalAPIBase
     */
    public function getEAPM()
    {
        $dnbEAPM = ExternalAPIFactory::loadAPI('Dnb',true);
        $dnbEAPM->getConnector();
        if(!$dnbEAPM->getConnectorParam('dnb_username') || 
           !$dnbEAPM->getConnectorParam('dnb_password') || 
           !$dnbEAPM->getConnectorParam('dnb_env')){
             return array('error' =>'ERROR_DNB_CONFIG');
        }
        return $dnbEAPM;
    }

    /**
     * Invokes D&B API using GET
     * @param $api
     * @param $args
     * @return mixed
     * @throws SugarApiExceptionRequestMethodFailure
     * @throws SugarApiExceptionMissingParameter
     */
    public function dnbDirectGet($api,$args)
    {
        //invoke dnb api based on query type and query parameter
        $extDnbApi = $this->getEAPM();
        if (is_array($extDnbApi) && isset($extDnbApi['error'])) {
            throw new SugarApiExceptionRequestMethodFailure(null, array(), null, 424, $extDnbApi['error']);
        }
        if ($extDnbApi === false) {
           throw new SugarApiExceptionRequestMethodFailure($GLOBALS['app_strings']['ERROR_UNABLE_TO_RETRIEVE_DATA'], $args);
        }
        $queryType = $args['qtype'];
        $queryParam = $args['qparam'];
        if (!$extDnbApi->isConnectorConfigured()) {
            return array('error' =>'ERROR_DNB_CONFIG');
        }
        $result = '';
        if ($queryType ==='competitors') {
            $result = $extDnbApi->dnbCompetitors($queryParam);
        } else if ($queryType ==='industry') {
            $result = $extDnbApi->dnbIndustryInfo($queryParam);
        } else if ($queryType ==='financial') {
            $result = $extDnbApi->dnbFinancialInfo($queryParam);
        } else if ($queryType ==='findIndustry') {
            $result = $extDnbApi->dnbIndustrySearch($queryParam);
        } else if ($queryType === 'findContacts') {
            $result = $extDnbApi->dnbFindContacts($queryParam);
        } else if ($queryType === 'refreshcheck') {
            $result = $extDnbApi->dnbRefreshCheck($queryParam);
        } else if ($queryType === 'news') {
            $result = $extDnbApi->dnbNews($queryParam);
        }
        if (is_array($result) && isset($result['error'])) {
            throw new SugarApiExceptionRequestMethodFailure(null, array(), null, 424, $result['error']);
        }
        return $result;
    }

    /**
     * Invokes DNB Api using POST calls
     * @param $api
     * @param $args
     * @return mixed
     * @throws SugarApiExceptionRequestMethodFailure
     * @throws SugarApiExceptionMissingParameter
     */
    public function dnbDirectPost($api,$args)
    {
        //invoke dnb api based on query type and query data
        $extDnbApi = $this->getEAPM();
        if (is_array($extDnbApi) && isset($extDnbApi['error'])) {
            throw new SugarApiExceptionRequestMethodFailure(null, array(), null, 424, $extDnbApi['error']);
        }
        $queryType = $args['qtype'];
        $queryData = $args['qdata']; //data posted 
        $result = '';
        if ($queryType === 'cmRequest') {
            $result = $extDnbApi->dnbCMRequest($queryData);
        } else if ($queryType === 'contacts') {
            $result = $extDnbApi->dnbContactDetails($queryData);
        } else if ($queryType === 'indMap') {
            $result = $extDnbApi->dnbIndustryConversion($queryData);
        } else if ($queryType === 'industry') {
            $result = $extDnbApi->dnbIndustryInfoPost($queryData);
        } else if ($queryType === 'firmographic') {
            $result = $extDnbApi->dnbFirmographic($queryData);
        } else if ($queryType ==='findcontacts') {
            $result = $extDnbApi->dnbFindContactsPost($queryData);
        } else if ($queryType === 'familytree') {
            $result = $extDnbApi->dnbFamilyTree($queryData);
        } else if ($queryType === 'dupecheck') {
            $result = $extDnbApi->dupeCheck($queryData);
        }
        if (is_array($result) && isset($result['error'])) {
            throw new SugarApiExceptionRequestMethodFailure(null, array(), null, 424, $result['error']);
        }
        return $result;
    }

    /**
     * Invokes BAL for accounts
     * @param $api
     * @param $args
     * @return mixed
     * @throws SugarApiExceptionRequestMethodFailure
     * @throws SugarApiExceptionMissingParameter
     */
    public function dnbAccountsBAL($api,$args) {
        //invoke dnb api based on query type and query data
        $extDnbApi = $this->getEAPM();
        if (is_array($extDnbApi) && isset($extDnbApi['error'])) {
            throw new SugarApiExceptionRequestMethodFailure(null, array(), null, 424, $extDnbApi['error']);
        }
        $queryData = $args['qdata']; //data posted
        $result = $extDnbApi->dnbBALAccounts($queryData);
        if (is_array($result) && isset($result['error'])) {
            throw new SugarApiExceptionRequestMethodFailure(null, array(), null, 424, $result['error']);
        }
        return $result;
    }

    /**
     * Invokes BAL for contacts, leads and prospects
     * @param $api
     * @param $args
     * @return mixed
     * @throws SugarApiExceptionRequestMethodFailure
     * @throws SugarApiExceptionMissingParameter
     */
    public function dnbContactsBAL($api,$args) {
        //invoke dnb api based on query type and query data
        $extDnbApi = $this->getEAPM();
        if (is_array($extDnbApi) && isset($extDnbApi['error'])) {
            throw new SugarApiExceptionRequestMethodFailure(null, array(), null, 424, $extDnbApi['error']);
        }
        $queryData = $args['qdata']; //data posted
        $result = $extDnbApi->dnbBALContacts($queryData);
        if (is_array($result) && isset($result['error'])) {
            throw new SugarApiExceptionRequestMethodFailure(null, array(), null, 424, $result['error']);
        }
        return $result;
    }

    /**
     * Bulk Imports D&B Objects
     * @param $api
     * @param $args
     * @return mixed
     * @throws SugarApiExceptionRequestMethodFailure
     * @throws SugarApiExceptionMissingParameter
     */
    public function dnbBulkImport($api,$args) {
        $extDnbApi = $this->getEAPM();
        if (is_array($extDnbApi) && isset($extDnbApi['error'])) {
            throw new SugarApiExceptionRequestMethodFailure(null, array(), null, 424, $extDnbApi['error']);
        }
        $bulkImportData = $args['bulkdata']; //data posted
        $module = $args['module'];
        $result = $extDnbApi->dnbBulkImport($module, $bulkImportData);
        if (is_array($result) && isset($result['error'])) {
            throw new SugarApiExceptionRequestMethodFailure(null, array(), null, 424, $result['error']);
        }
        return $result;
    }

    /**
     * Get D&B API Usage data
     * @param $api
     * @param $args
     * @return mixed
     * @throws SugarApiExceptionRequestMethodFailure
     * @throws SugarApiExceptionMissingParameter
     */
    public function dnbMeter($api,$args) {
        //invoke dnb api based on query type and query data
        $extDnbApi = $this->getEAPM();
        if (is_array($extDnbApi) && isset($extDnbApi['error'])) {
            throw new SugarApiExceptionRequestMethodFailure(null, array(), null, 424, $extDnbApi['error']);
        }
        $result = $extDnbApi->dnbMeterInfo();
        if (is_array($result) && isset($result['error'])) {
            throw new SugarApiExceptionRequestMethodFailure(null, array(), null, 424, $result['error']);
        }
        return $result;
    }
}
