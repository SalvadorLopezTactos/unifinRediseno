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

require_once('include/externalAPI/Base/OAuthPluginBase.php');
require_once('include/externalAPI/Base/WebFeed.php');
require_once 'include/SugarQuery/SugarQuery.php';
require_once('include/SugarCache/SugarCache.php');
require_once('include/externalAPI/Dnb/DnbCurlWrapper.php');

class ExtAPIDnb extends ExternalAPIBase
{
    public $connector = "ext_rest_dnb";
    private $dnbBaseURL = array(
        'stg' => 'http://services-ext-stg.dnb.com/',
        'prod' => 'https://maxcvservices.dnb.com/'
    );
    private $dnbAuthURL = "rest/Authentication";
    //OrderReasonCode is a parameter required to fetch Firmographic info for all companies
    //if this is not set, API calls for companies in Germany will fail
    private $dnbFirmographicURL = "V3.2/organizations/%s/products/%s?OrderReasonCode=6332";
    private $dnbFirmoLiteURL = "V3.2/organizations/%s/products/DCP_BAS?OrderReasonCode=6332";
    private $dnbCompetitorsURL = "V4.0/organizations/%s/competitors";
    private $dnbIndustryURL = "V3.0/industries/industrycode-%s/IND_STD";
    private $dnbFinancialURL = "V3.0/organizations/%s/products/FIN_HGLT";
    private $dnbFamilyTreeURL = "V3.1/organizations/%s/products/%s";
    private $dnbCleanseMatchURL = "V3.0/organizations";
    private $dnbBALURL = "V6.0/organizations?SearchModeDescription=Advanced&findcompany=true&";
    private $dnbBALContactURL = "V6.0/organizations?SearchModeDescription=Advanced&findcontact=true&";
    private $dnbFindIndustryURL = "V4.0/industries?KeywordText=%s&findindustry=true";
    private $dnbFindContactsURL = "V4.0/organizations?findcontact=true&DUNSNumber-1=%s&SearchModeDescription=Advanced";
    private $dnbContactDetPremURL = "V3.0/organizations/%s/products/CNTCT_PLUS?PrincipalIdentificationNumber=%s&OrderReasonCode=6332";
    private $dnbContactDetStdURL = "V3.0/organizations/%s/products/CNTCT?PrincipalIdentificationNumber=%s&OrderReasonCode=6332";
    private $dnbNewsURL = "V3.0/organizations/%s/products/NEWS_MDA";
    private $dnbIndustryConversionURL = "V4.0/industries?IndustryCode-1=%s&ReturnOnlyPremiumIndustryIndicator=true&IndustryCodeTypeCode-1=%s&findindustry=true";
    private $dnbRefreshCheckURL = "V4.0/organizations?refresh=refresh&DunsNumber-1=%s";
    private $dnbContactsBALURL = "V6.0/organizations?CandidateMaximumQuantity=1000&findcontact=true&SearchModeDescription=Advanced";
    private $dnbMeterURL = "V3.0/meterinformation";
    private $dnbApplicationId;
    private $dnbUsername;
    private $dnbPassword;
    private $dnbEnv;
    //cache time to live in seconds
    private $cacheTTL = 8640000;
    public $supportedModules = array();
    /**
     * @var resource curl wrapper
     */
    private $curlWrapper;

    //commonly used json paths
    private $familyTreePaths = array(
        'nestedDuns' => 'SubjectHeader.DUNSNumber',
        'nestedTree' => 'Linkage.FamilyTreeMemberOrganization',
        'familyTree' => 'OrderProductResponse.OrderProductResponseDetail.Product.Organization.Linkage.FamilyTreeMemberOrganization',
        'duns' => 'OrderProductResponse.OrderProductResponseDetail.Product.Organization.SubjectHeader.DUNSNumber',
        'inquiryDet' => 'OrderProductResponse.OrderProductResponseDetail.InquiryDetail.DUNSNumber'
    );

    private $commonJsonPaths = array(
        'findcompany' => 'FindCompanyResponse.FindCompanyResponseDetail.FindCandidate',
        'competitors' => 'FindCompetitorResponse.FindCompetitorResponseDetail.Competitor',
        'cleansematch' => 'GetCleanseMatchResponse.GetCleanseMatchResponseDetail.MatchResponseDetail.MatchCandidate',
        'contacts' => 'FindContactResponse.FindContactResponseDetail.FindCandidate',
        'principalIdPath' => 'PrincipalIdentificationNumberDetail.0.PrincipalIdentificationNumber',
        'industryResponseCode' => 'FindIndustryResponse.TransactionResult.ResultID',
        'industryResponseMsg' => 'FindIndustryResponse.TransactionResult.ResultText',
        'findindustry' => 'FindIndustryResponse.FindIndustryResponseDetail.IndustryCode'
    );

    function __construct()
    {
        $this->contactModules = array('Contacts','Leads','Prospects');
        $this->logger = LoggerManager::getLogger();
        $this->setCurlWrapper(new DnbCurlWrapper());
        $this->loadConnectionCredentials();
    }

    private function loadConnectionCredentials()
    {
        $this->dnbUsername = trim($this->getConnectorParam('dnb_username'));
        $this->dnbPassword = trim($this->getConnectorParam('dnb_password'));
        $this->dnbEnv = trim($this->getConnectorParam('dnb_env'));
    }

    /**
     * Set the curlWrapper property
     * @param DnbCurlWrapper $dnbCurlWrapper
     */
    public function setCurlWrapper(DnbCurlWrapper $dnbCurlWrapper)
    {
        $this->curlWrapper = $dnbCurlWrapper;
    }


    /**
     * Checks cache for cached response else invoke api using makeRequest
     * @param $cacheKey String
     * @param $endPoint String
     * @param $requestType String possible values GET or POST
     * @return array
     */
    private function dnbServiceRequest($cacheKey,$endPoint,$requestType){
        $apiResponse = sugar_cache_retrieve($cacheKey);
        //obtain results from dnb service if cache does not contain result
        if (empty($apiResponse) || $apiResponse === SugarCache::EXTERNAL_CACHE_NULL_VALUE) {
            $this->logger->debug('Cache does not contain'.$cacheKey);
            $apiResponse = $this->makeRequest($requestType, $endPoint);
            if (!$apiResponse['success']) {
                $this->logger->error('D&B failed, reply said: ' . print_r($apiResponse, true));
                return $apiResponse;
            } else {
                //cache the result if the dnb service response was a success
                sugar_cache_put($cacheKey, $apiResponse, $this->cacheTTL);
                $this->logger->debug('Cached ' . $cacheKey);
            }
        } else {
            $this->logger->debug('Getting cached results for ' . $cacheKey);
        }
        return $apiResponse;
    }

    /**
     * Checks when the duns_num was last refreshed
     * @param $duns_num unique identifier for a company
     * @return jsonarray
     */
    public function dnbRefreshCheck($duns_num)
    {
        $dnbendpoint = $this->dnbBaseURL[$this->dnbEnv] . sprintf($this->dnbRefreshCheckURL, $duns_num);
        $reply = $this->makeRequest('GET', $dnbendpoint);
        if (!$reply['success']) {
            $this->logger->error('DNB failed, reply said: ' . print_r($reply, true));
            return $reply;
        }
        return $reply['responseJSON'];
    }

    /**
     * Gets News And Social Media Info for a D-U-N-S
     * @param $duns_num unique identifier for a company
     * @return jsonarray
     */
    public function dnbNews($duns_num)
    {
        $dnbendpoint = $this->dnbBaseURL[$this->dnbEnv] . sprintf($this->dnbNewsURL, $duns_num);
        $reply = $this->makeRequest('GET', $dnbendpoint);
        if (!$reply['success']) {
            $this->logger->error('DNB failed, reply said: ' . print_r($reply, true));
            return $reply;
        }
        return $reply['responseJSON'];
    }

    /**
     * Gets Competitors for a D-U-N-S number
     * @param string $duns_num
     * @return jsonarray
     */
    public function dnbCompetitors($duns_num)
    {
        //dnb competitors
        $cache_key = 'dnb.competitors.' . $duns_num;
        $dnbendpoint = $this->dnbBaseURL[$this->dnbEnv] . sprintf($this->dnbCompetitorsURL, $duns_num);
        //check if result exists in cache
        $reply = $this->dnbServiceRequest($cache_key, $dnbendpoint, 'GET');
        // get existing duns
        $path = $this->commonJsonPaths['competitors'];
        if ($this->arrayKeyExists($reply['responseJSON'], $path)) {
            //get the list of companies from dnb
            $modifiedCompaniesList = $this->checkAndMarkDuplicateDuns($reply['responseJSON'], $path);
            if (!empty($modifiedCompaniesList)) {
                $reply['responseJSON']['FindCompetitorResponse']['FindCompetitorResponseDetail']['Competitor'] = $modifiedCompaniesList;
            }
        }
        return $reply['responseJSON'];
    }

    /**
     * Gets Financials for a D-U-N-S number
     * @param $duns_num
     * @return jsonarray
     */
    public function dnbFinancialInfo($duns_num)
    {
        //dnb financials
        $cache_key = 'dnb.financials.' . $duns_num;
        $dnbendpoint = $this->dnbBaseURL[$this->dnbEnv] . sprintf($this->dnbFinancialURL, $duns_num);
        //check if result exists in cache
        $reply = $this->dnbServiceRequest($cache_key, $dnbendpoint, 'GET');
        return $reply['responseJSON'];
    }

    /**
     * Gets D&B API Usage
     * @return jsonarray
     */
    public function dnbMeterInfo()
    {
        $dnbendpoint = $this->dnbBaseURL[$this->dnbEnv] . $this->dnbMeterURL;
        $reply = $this->makeRequest('GET', $dnbendpoint);
        if (!$reply['success']) {
            $this->logger->error('DNB failed, reply said: ' . print_r($reply, true));
            return array('error' => 'ERROR_DNB_CONFIG');
        }
        return $reply['responseJSON'];
    }

    /**
     * Gets D&B Hoovers Industry Codes for a keyword
     * @param $industry_keyword
     * @return jsonarray
     */
    public function dnbIndustrySearch($industry_keyword)
    {
        //dnb industry search
        $cache_key = 'dnb.industrysearch.' . $industry_keyword;
        $dnbendpoint = $this->dnbBaseURL[$this->dnbEnv] . sprintf(
                $this->dnbFindIndustryURL,
                urlencode($industry_keyword)
            );
        //check if result exists in cache
        $reply = $this->dnbServiceRequest($cache_key, $dnbendpoint, 'GET');
        return $reply['responseJSON'];
    }

    /**
     * Gets Cleanse and Matched Data from DNB API for the cleanse and match parameters
     * @param $cmParams Array
     * cmParams array must be in the following format
     * {
     *   "IncludeCleansedAndStandardizedInformationIndicator":"true", //mandatory
     *   "CountryISOAlpha2Code":"US", //country code mandatory
     *   "cleansematch":"true",//mandatory
     *   "SubjectName":"ibm", //company name mandatory
     *   "PrimaryTownName":"town name", //optional
     *   "TerritoryName": "territory" //optional
     *  }
     * @return jsonarray
     */
    public function dnbCMRequest($cmParams)
    {
        //convert $cmParams to queryString
        //TO DO: validate the POST parameters
        $cmQueryString = '?' . http_build_query($cmParams);
        $dnbendpoint = $this->dnbBaseURL[$this->dnbEnv] . $this->dnbCleanseMatchURL . $cmQueryString;
        $reply = $this->makeRequest('GET', $dnbendpoint);
        if (!$reply['success']) {
            $this->logger->error('DNB failed, reply said: ' . print_r($reply, true));
            return array('error' => 'ERROR_DNB_CONFIG');
        }
        // get existing duns
        $path = $this->commonJsonPaths['cleansematch'];
        if ($this->arrayKeyExists($reply['responseJSON'], $path)) {
            //get the list of companies from dnb
            $modifiedCompaniesList = $this->checkAndMarkDuplicateDuns($reply['responseJSON'], $path);
            if (!empty($modifiedCompaniesList)) {
                $reply['responseJSON']['GetCleanseMatchResponse']['GetCleanseMatchResponseDetail']['MatchResponseDetail']['MatchCandidate'] = $modifiedCompaniesList;
            }
        }
        return $reply['responseJSON'];
    }

    /**
     * Builds A List Of Companies from DNB API for the build a list parameters
     * @param $balParams Array
     * $balParams must look like the following
     * not all keys are mandatory but atleast one of them
     * {
     *   "SalesLowRangeAmount": , <decimal> //optionsl
     *   "SalesHighRangeAmount": , <decimal> //optionsl
     *  }
     * @return jsonarray
     */
    public function dnbBALAccounts($balParams)
    {
        //convert $balParams to queryString
        $balQueryString =  http_build_query($balParams);
        $dnbendpoint = $this->dnbBaseURL[$this->dnbEnv] . $this->dnbBALURL . $balQueryString;
        $reply = $this->makeRequest('GET', $dnbendpoint);
        if (!$reply['success']) {
            $this->logger->error('DNB failed, reply said: ' . print_r($reply, true));
            return array('error' => 'ERROR_DNB_CONFIG');
        }
        $path = $this->commonJsonPaths['findcompany'];
        if ($this->arrayKeyExists($reply['responseJSON'], $path)) {
            $modifiedCompaniesList = $this->checkAndMarkDuplicateDuns($reply['responseJSON'],$path);
            if (!empty($modifiedCompaniesList)) {
                $reply['responseJSON']['FindCompanyResponse']['FindCompanyResponseDetail']['FindCandidate'] = $modifiedCompaniesList;
            }
        }
        return $reply['responseJSON'];
    }

    /**
     * Builds A List Of Contacts from DNB API for the build a list parameters
     * @param $balParams Array
     * $balParams must look like the following
     * not all keys are mandatory but atleast one of them
     * {
     *   "SalesLowRangeAmount": , <decimal> //optionsl
     *   "SalesHighRangeAmount": , <decimal> //optionsl
     *  }
     * @return jsonarray
     */
    public function dnbBALContacts($balParams)
    {
        //contactType is required for duplicate check
        $contactType = $balParams['contactType'];
        //delete the contactType key as the rest of the array is being used to build a query string
        unset($balParams['contactType']);
        //convert $balParams to queryString
        $balQueryString = http_build_query($balParams);
        $dnbendpoint = $this->dnbBaseURL[$this->dnbEnv] . $this->dnbBALContactURL . $balQueryString;
        $reply = $this->makeRequest('GET', $dnbendpoint);
        if (!$reply['success']) {
            $this->logger->error('DNB failed, reply said: ' . print_r($reply, true));
            return array('error' => 'ERROR_DNB_CONFIG');
        }
        if (in_array($contactType, $this->contactModules)) {
            $path = $this->commonJsonPaths['contacts'];
            if ($this->arrayKeyExists($reply['responseJSON'], $path)) {
                $reply['responseJSON'] = $this->checkAndMarkDuplicateContacts($reply['responseJSON'], $path, $contactType);
            }
        }
        return $reply['responseJSON'];
    }


    /**
     * Gets Contacts Details For Principal Identification Number and Duns Number
     * @param $contactParams
     * @return jsonarray
     */
    public function dnbContactDetails($contactParams)
    {
        $duns_num = $contactParams['duns_num'];
        $contact_id = $contactParams['contact_id'];
        $contact_type = $contactParams['contact_type'];
        $cache_key = null;
        //dnb contact
        if ($contact_type === 'dnb-cnt-prem') {
            $cache_key = 'dnb.cntprem.' . $duns_num . '.' . $contact_id;
            $dnbendpoint = $this->dnbBaseURL[$this->dnbEnv] . sprintf(
                    $this->dnbContactDetPremURL,
                    $duns_num,
                    $contact_id
                );
        } else if ($contact_type === 'dnb-cnt-std'){
            $cache_key = 'dnb.cntstd.' . $duns_num . '.' . $contact_id;
            $dnbendpoint = $this->dnbBaseURL[$this->dnbEnv] . sprintf(
                    $this->dnbContactDetStdURL,
                    $duns_num,
                    $contact_id
                );
        }
        //check if result exists in cache
        $reply = $this->dnbServiceRequest($cache_key, $dnbendpoint, 'GET');
        return $reply['responseJSON'];
    }


    /**
     * Get the Linkage / Family Tree For a Given DUNS Number
     * @param $ftParams
     * @return array
     */
    public function dnbFamilyTree($ftParams)
    {
        $ftQueryString = http_build_query($ftParams);
        //dnb family tree cache key
        $cache_key = 'dnb.ft.'.$ftQueryString;
        $dnbendpoint = $this->dnbBaseURL[$this->dnbEnv].sprintf($this->dnbFamilyTreeURL,$ftParams['duns_num'],$ftParams['prod_code']);
        //check if result exists in cache
        $reply = $this->dnbServiceRequest($cache_key, $dnbendpoint, 'GET');
        //family tree duplicate check
        if ($this->arrayKeyExists($reply['responseJSON'], $this->familyTreePaths['familyTree'])) {
            $reply['responseJSON'] = $this->checkAndMarkFTDuplicateDuns($reply['responseJSON']);
        }
        return $reply['responseJSON'];
    }

    /**
     * Given a family tree return an array of duns
     * if a duns has a nested family tree recursively traverse it
     * to bring in the array of duns
     * @param $familyTree
     * @return array
     */
    private function getFamilyTreeDuns($familyTree)
    {
        $dunsArray = array();
        foreach ($familyTree as &$dnbRecordObj) {
            //add the duns to the dunsArray
            $dunsArray[] = $this->getObjectValue($dnbRecordObj, $this->familyTreePaths['nestedDuns']);
            //check if the duns has a nestedFamilyTree
            $nestedFamilyTree = $this->getObjectValue($dnbRecordObj, $this->familyTreePaths['nestedTree']);
            if (!empty($nestedFamilyTree)) {
                //if the duns has nested family tree
                //then recursively get the duns
                $nestedDunsArray = $this->getFamilyTreeDuns($nestedFamilyTree);
                $dunsArray = array_merge($dunsArray, $nestedDunsArray);
            }
        }
        return $dunsArray;
    }

    /**
     * Given a family tree and an array of duns in sugar db
     * traverse through the family tree and mark the common duns as duplicates
     * @param $familyTree
     * @param $dunsArray
     * @return array
     */
    private function markFamilyTreeDuplicates($familyTree, $dunsArray)
    {
        $dnbModifiedRecordsCollection = array();
        foreach ($familyTree as &$dnbRecordObj) {
            $duns = $this->getObjectValue($dnbRecordObj, $this->familyTreePaths['nestedDuns']);
            $duns = str_pad($duns, 9, "0", STR_PAD_LEFT);
            //check if the duns has a nestedFamilyTree
            $nestedFamilyTree = $this->getObjectValue($dnbRecordObj, $this->familyTreePaths['nestedTree']);
            if (!empty($nestedFamilyTree)) {
                //if the duns has nested family tree
                //then recursively mark duplicates
                $nestedModifiedRecords = $this->markFamilyTreeDuplicates($nestedFamilyTree, $dunsArray);
                $dnbRecordObj['Linkage']['FamilyTreeMemberOrganization'] = $nestedModifiedRecords;
            }
            //if duns is there then mark it as duplicate
            if (in_array($duns, $dunsArray)) {
                $dnbRecordObj['isDupe'] = true;
            }
            $dnbModifiedRecordsCollection[] = $dnbRecordObj;
        }
        return $dnbModifiedRecordsCollection;
    }

    /**
     * Gets Converts the given Industry Code and Industry Type Code to Hoovers Industry Code (HIC)
     * @param $indMapParams object
     * $indMapParams must contain two keys
     * industryCode
     * industryType -- possible values are 3599(SIC),700(NAICS),19295(SIC UK),25838(HIC)
     * @return jsonarray
     */
    public function dnbIndustryConversion($indMapParams)
    {
        $industryType = $indMapParams['industryType'];
        $industryCode = $indMapParams['industryCode'];
        //dnb contact
        $cache_key = 'dnb.indMap.' . $industryType . '.' . $industryCode;
        $dnbendpoint = $this->dnbBaseURL[$this->dnbEnv] . sprintf(
                $this->dnbIndustryConversionURL,
                $industryCode,
                $industryType
            );
        //check if result exists in cache
        $reply = $this->dnbServiceRequest($cache_key, $dnbendpoint, 'GET');
        return $reply['responseJSON'];
    }

    /**
     * Gets company information for the gives duns for the given product_code
     * @param $firmoParams object
     * $firmoParams must contain two keys
     * duns_num
     * prod_code -- possible values are CST_PRD_1,DCP_STD,DCP_PREM
     * @return jsonarray
     */
    public function dnbFirmographic($firmoParams)
    {
        $duns_num = $firmoParams['duns_num'];
        $prod_code = $firmoParams['prod_code'];
        //dnb firmographic
        $cache_key = 'dnb.' . $duns_num . '.' . $prod_code;
        if ($prod_code === 'DCP_BAS') {
            $dnbendpoint = $this->dnbBaseURL[$this->dnbEnv] . sprintf($this->dnbFirmoLiteURL, $duns_num);
        } else {
            $dnbendpoint = $this->dnbBaseURL[$this->dnbEnv] . sprintf(
                    $this->dnbFirmographicURL,
                    $duns_num,
                    $prod_code
                );
        }
        //check if result exists in cache
        $reply = $this->dnbServiceRequest($cache_key, $dnbendpoint, 'GET');
        return $reply['responseJSON'];
    }


    /**
     * Gets Converts the given Industry Code and Industry Type Code to Hoovers Industry Code (HIC)
     * Uses the HIC to get the Industry Information
     * @param $indMapParams object
     * $indMapParams must contain two keys
     * industryCode
     * industryType -- possible values are 3599(SIC),700(NAICS),19295(SIC UK),25838(HIC)
     * @return jsonarray
     */
    public function dnbIndustryInfoPost($indMapParams)
    {
        //converting the SIC code to HIC
        $reply = $this->dnbIndustryConversion($indMapParams);
        $responseCode = $this->getObjectValue($reply, $this->commonJsonPaths['industryResponseCode']);
        if (empty($responseCode) || $responseCode !== 'CM000') {
            $responseMessage = $this->getObjectValue($reply, $this->commonJsonPaths['industryResponseMsg']);
            if (empty($responseMessage)) {
                $responseMessage = 'ERROR_DNB_SVC_ERR';
            }
            return array('error' => $responseMessage);
        } else {
            //get the HIC from the result of the industry conversion call
            $industryCodePath = $this->commonJsonPaths['findindustry'];
            if ($this->arrayKeyExists($reply, $industryCodePath)) {
                $industryArray = $reply['FindIndustryResponse']['FindIndustryResponseDetail']['IndustryCode'];
                //get the primary hic
                $primaryHIC = $this->underscoreFind(
                    $industryArray,
                    function ($industryObj) {
                        return $industryObj['DisplaySequence'] === 1;
                    }
                );
                if (!empty($primaryHIC)) {
                    $indCodeParam = $primaryHIC['IndustryCode'] . '-' . $primaryHIC['@DNBCodeValue'];
                    return $this->dnbIndustryInfo($indCodeParam);
                } else {
                    return array('success' => false, 'errorMessage' => 'Error Converting Industry Code');
                }
            } else {
                return array('success' => false, 'errorMessage' => 'Error Converting Industry Code');
            }
        }
    }

    /**
     * Gets Industry information for a industry code
     * @param $ind_code industry code
     * @return jsonarray
     */
    public function dnbIndustryInfo($ind_code)
    {
        //dnb industry
        $cache_key = 'dnb.industry.' . $ind_code;
        $dnbendpoint = $this->dnbBaseURL[$this->dnbEnv] . sprintf($this->dnbIndustryURL, $ind_code);
        //check if result exists in cache
        $reply = $this->dnbServiceRequest($cache_key, $dnbendpoint, 'GET');
        return $reply['responseJSON'];
    }

    /**
     * Lists Records already present in sugar db using the $columnName & $moduleName parameters
     * @param $columnName
     * @param $moduleName
     * @param $recordIds array (array of id to be used in the in clause of the query)
     * @return array
     */
    private function getExistingRecords($columnName, $moduleName, $recordIds = null)
    {
        $seed = BeanFactory::newBean($moduleName);
        //if duns_num, format all duns to be 0 padded
        // for 9 digits
        if ($columnName == 'duns_num') {
            foreach ($recordIds as &$duns) {
                $duns = str_pad($duns, 9, "0", STR_PAD_LEFT);;
            }
        }
        $options = array();
        $options['offset'] = 0;
        $options['order_by'] = array(array('date_modified', 'DESC'));
        $options['add_deleted'] = true;
        $options['offset'] = 'end';
        $options['module'] = $seed->module_name;
        $options['team_security'] = false;
        $q = new SugarQuery();
        $q->from($seed, $options);
        $fields = array($columnName);
        $q->select($fields);
        $where = $q->where();
        $where->in($columnName, $recordIds);
        $where = $where->queryAnd();
        $where->equals('deleted', 0);
        $q->compileSql();
        $queryResults = $q->execute('json');
        return $queryResults;
    }

    /**
     * Gets Records that are present in the database and in the DNB service reponse
     * These Records are flagged as duplicates using the array key 'isDupe'
     * @param $dnbRecords array (dnb records to be compared with sugar db records)
     * @param $sugarRecords array (array of ids in sugar database)
     * @param $dnbPath string (path to traverse in each of the dnb records to get the recordId)
     * @param $sugarColumnName string (name of column in sugar db to check against)
     * @return array (modified dnb records with duplicates flagged)
     */
    private function getCommonRecords($dnbRecords, $sugarRecords, $dnbPath, $sugarColumnName)
    {
        $sugarRecordIds = $this->underscorePluck($sugarRecords, $sugarColumnName);
        $dnbModifiedRecordsCollection = array();
        foreach ($dnbRecords as &$dnbRecordObj) {
            $recordId = $this->getObjectValue($dnbRecordObj, $dnbPath);
            if (in_array($recordId, $sugarRecordIds)) {
                $dnbRecordObj['isDupe'] = true;
            } else if (!empty($dnbRecordObj['isDupe'])) {
                unset($dnbRecordObj['isDupe']);
            }
            $dnbModifiedRecordsCollection[] = $dnbRecordObj;
        }
        return $dnbModifiedRecordsCollection;
    }

    /**
     * Mimics the pluck function in underscore.js
     * @param $collection array
     * @param $key string
     * @return array
     */
    private function underscorePluck($collection, $key)
    {
        $return = array();
        foreach ($collection as $item) {
            foreach ($item as $k => $v) {
                if ($k === $key) {
                    $return[] = $v;
                }
            }
        }
        return $return;
    }

    /**
     * Mimics the each function in underscore.js
     * @param $collection array
     * @param $iterator function
     * @return null
     */
    private function underscoreEach($collection = null, $iterator = null)
    {
        if (is_null($collection) || count($collection) === 0) {
            return null;
        }
        foreach ($collection as $k => $v) {
            call_user_func($iterator, $v, $k, $collection);
        }
        return null;
    }

    /**
     * Mimics the find function in underscore.js
     * @param $collection array
     * @param $iterator function
     * @return object
     */
    private function underscoreFind($collection = null, $iterator = null)
    {
        if (is_null($collection) || count($collection) === 0) {
            return null;
        }
        foreach ($collection as $val) {
            if (call_user_func($iterator, $val)) {
                return $val;
            }
        }
    }

    /**
     * Gets the value from an object using the path
     * @param $object array
     * @param $path string
     * @return value mixed Return value if it exists else return null
     */
    private function getObjectValue($object, $path)
    {
        $pathParts = explode(".", $path);
        for ($i = 0; $i < count($pathParts) ; $i++) {
            if (isset($object[$pathParts[$i]])) {
                $object = $object[$pathParts[$i]];
            } else {
                return null;
            }
        }
        return $object;
    }

    /**
     * Sets the value to an object using the path
     * @param array $object
     * @param string $path
     * @param mixed $value
     * @return array
     */
    private function setObjectValue(&$object, $path, $value)
    {
        $tempObj = & $object;
        foreach (explode('.', $path) as $key) {
            if (isset($tempObj[$key])) {
                $tempObj = & $tempObj[$key];
            }
        }
        $tempObj = $value;
    }

    /**
     * Returns a recent valid token if possible
     * @return string An authenticated token or null if authenticated token was unattainable
     */
    private function getRecentToken() {
        global $current_user;

        // Get the token information from the EAPM bean
        $eapm =  $this->getEAPMForUser($current_user);
        $dnbToken = $eapm->tokenValue;
        $dnbTokenIssueTime = $eapm->tokenIssueTime;

        //check if token has expired
        $dnbToken = $this->checkToken($dnbToken, $dnbTokenIssueTime);
        return $dnbToken;
    }

    /**
     * Check if a valid token was procurable
     *
     * @param boolean $save Flag that tells the connector whether to save the token
     * @return boolean True if token was procurable, false if not
     */
    public function checkTokenValidity($save = true)
    {
        $dnbToken = $this->getAuthenticationToken($save);
        return !empty($dnbToken);
    }

    /**
     * Invokes REST API
     * @param $requestMethod Method type GET|POST
     * @param $url Service End Point
     * @return array
     */
    private function makeRequest($requestMethod, $url)
    {
        //check if connector is configured
        if (!$this->isConnectorConfigured()) {
            return array('error' => 'ERROR_DNB_CONFIG');
        }
        //if the request is not to obtain D&B authorization token then check for authorization token in session
        $dnbToken = $this->getRecentToken();
        if (empty($dnbToken)) {
            return array('success' => false, 'errorMessage' => 'Error Obtaining Authorization Token');
        }
        $curl_headers = array(
            "Authorization: $dnbToken",
            "Accept: application/json"
        );
        $apiResponse = $this->curlRequest($url, $curl_headers, $requestMethod);
        if (array_key_exists('error',$apiResponse)) {
            //if the request is not for D&B authorization token send the response to client
            //client handles the error handling
            return $apiResponse;
        } else {
            $response = $apiResponse['curlResponse'];
            $response = json_decode($response, true);
            if (empty($response)) {
                return array('success' => false, 'errorMessage' => 'Error in JSON Decoding');
            }
            return array('success' => true, 'responseJSON' => $response);
        }
    }

    /**
     * @param String $url D&B Endpoint
     * @param bool   $headerOutputRequired if header is required in the output
     * @param Array  $requestHeaders request Headers
     * @param String $requestMethod GET / POST ect
     */
    private function curlRequest ($url, $requestHeaders, $requestMethod, $headerOutputRequired=false) {
        // setting curl options
        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => $headerOutputRequired,
            CURLOPT_HTTPHEADER => $requestHeaders,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLINFO_HEADER_OUT => false,
            CURLOPT_CUSTOMREQUEST => $requestMethod
        );

        $response = $this->curlWrapper->execute($curl_options);
        //logging information in debug mode
        if ($this->logger->wouldLog('debug')) {
            if (!empty($requestHeaders) && count($requestHeaders) > 0) {
                foreach($requestHeaders as $headerVal) {
                    $this->logger->debug("curl header : $headerVal");
                }
            }
            $this->logger->debug("url: $url");
            $this->logger->debug("HTTP client response: $response");
        }
        if ($response['curlResponse'] === false) {
            $curl_errno = $this->curlWrapper->getErrorNo();
            $curl_error = $this->curlWrapper->getError();
            if (isset($curl_errno) && isset($curl_error)) {
                $this->logger->error("HTTP client: cURL call failed: error $curl_errno: $curl_error");
                return array('error' => 'ERROR_CURL_' . $curl_errno);
            } else {
                $this->logger->error("HTTP client: cURL call failed: Unknown cURL error");
                return array('error' => 'ERROR_CURL_UNKNOWN');
            }
        }
        return $response;
    }

    /**
     * Check if Connector Framework Is Configured
     * @return bool
     */
    public function isConnectorConfigured()
    {
        return !(empty($this->dnbUsername) || empty($this->dnbPassword) || empty($this->dnbEnv));
    }

    /**
     * Checks if DNB Token is valid
     * DNB Token expires after 8 hours of idle time
     * @param $dnbToken
     * @param $dnbTokenIssueTime
     * @return string token if valid token found, null otherwise
     */
    private function checkToken($dnbToken, $dnbTokenIssueTime)
    {
        $isTokenSet = !empty($dnbToken);
        $isTokenExpired = ((time() - (!empty($dnbTokenIssueTime) ? $dnbTokenIssueTime : time(
                ))) > 28800) ? true : false;
        if (!$isTokenSet || ($isTokenSet && $isTokenExpired)) {
            return $this->getAuthenticationToken();
        } else {
            $this->logger->debug('Using Valid D&B Old Token');
            return $dnbToken;
        }
    }

    /**
     * Return new DNB Authentication to access DNB api. Return null if
     * authentication could not be verified
     *
     * @param boolean $save Flag that tells the connector whether to save the token
     * @return string token if valid token found, null otherwise
     */
    private function getAuthenticationToken($save = true)
    {
        global $current_user;

        // In test, these values will be set AFTER contruction, so load them now
        if ($this->inTest || empty($this->dnbUsername) || empty($this->dnbPassword)) {
            $this->loadConnectionCredentials();
        }

        $username = $this->dnbUsername;
        $password = $this->dnbPassword;
        $curl_headers = array(
            "x-dnb-user: $username",
            "x-dnb-pwd: $password"
        );
        $token = "";
        if (!array_key_exists($this->dnbEnv, $this->dnbBaseURL)) {
            return null;
        }
        $authUrl = $this->dnbBaseURL[$this->dnbEnv] . $this->dnbAuthURL;
        $apiResponse = $this->curlRequest($authUrl, $curl_headers, 'POST', true);
        if (array_key_exists('error',$apiResponse)) {
            //if the request is not for D&B authorization token send the response to client
            //client handles the error handling
            return null;
        } else {
            if (in_array($apiResponse['httpStatus'], array(200,204))) {
                //extracting D&B token from curl headers
                preg_match("/Authorization:\s(\S*)/", $apiResponse['curlResponse'], $tokenArray);
                if (count($tokenArray) > 0) {
                    $token = $tokenArray[1];
                } else {
                    return null;
                }
            }

            // Save the token information if we are supposed to
            if ($save === true) {
                $eapm = $this->getEAPMForUser($current_user);
                $eapm->api_data = base64_encode(json_encode(
                    array(
                        "tokenIssueTime" => time(),
                        "tokenValue" => $token,
                    )
                ));
                $eapm->save();
            }

            // Send it back
            return $token;
        }
    }

    /**
     * Gets the EAPM bean for the user and this connector
     *
     * @param User $user A User object
     * @return EAPM
     */
    protected function getEAPMForUser($user)
    {
        // In any case we will need the EAPM bean
        $seed = BeanFactory::getBean("EAPM");

        // Setup our query to get what we need from the EAPM bean
        $sq = new SugarQuery();
        $sq->from($seed)
           ->where()
           ->equals('assigned_user_id', $user->id)
           ->equals('application', $this->connector);

        // Run the query and get the first result
        $eapm = current($seed->fetchFromQuery($sq, array('api_data')));
        if ($eapm) {
            if (!empty($eapm->api_data)) {
                // Get the decoded EAPM data for this connector and load it on
                // the fetched bean as properties
                $data = json_decode(base64_decode($eapm->api_data));
                foreach($data as $key => $val) {
                    $eapm->$key = $val;
                }
            }

            // Send back this bean
            return $eapm;
        } else {
            // No EAPM... load the basics and send it back
            $seed->assigned_user_id = $user->id;
            $seed->application = $this->connector;
            return $seed;
        }
    }

    /**
     * Utility function to check if an array key exists in a nested associative array
     * @param $array
     * @param $path
     * @return bool
     */
    private function arrayKeyExists($array, $path)
    {
        $keyArray = explode('.', $path);
        if (count($keyArray) > 0) {
            for ($i = 0; $i < count($keyArray); $i++) {
                if (is_null($array) || !array_key_exists($keyArray[$i], $array)) {
                    return false;
                }
                $array = $array[$keyArray[$i]];
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks the D&B List of companies for duns_num already existing in SugarDB
     * @param array $dnbApiResponse
     * @param string $path
     * @return mixed
     */
    private function checkAndMarkDuplicateDuns($dnbApiResponse,$path)
    {
        $dnbCompaniesList = $this->getObjectValue($dnbApiResponse, $path);
        $dnbDunsArray = $this->underscorePluck($dnbCompaniesList, 'DUNSNumber');
        //get the list of duns existing in sugar that match with the above list of duns
        $existingDUNSArray = json_decode($this->getExistingRecords('duns_num', 'Accounts', $dnbDunsArray), true);
        if (count($existingDUNSArray) > 0) {
            //identify the duns common in the api response and in the sugar db and make the dupe
            $modifiedCompaniesList = $this->getCommonRecords($dnbCompaniesList, $existingDUNSArray, 'DUNSNumber', 'duns_num');
            return $modifiedCompaniesList;
        } else {
            return null;
        }
    }

    /**
     * Checks Family tree response for duns_num already existing in SugarDB
     * @param array $dnbFTApiResponse
     * @return mixed
     */
    private function checkAndMarkFTDuplicateDuns($dnbFTApiResponse)
    {
        $familyTree = $this->getObjectValue($dnbFTApiResponse, $this->familyTreePaths['familyTree']);
        //get a list of duns in the family tree response -- recursive function
        $dunsArray = $this->getFamilyTreeDuns($familyTree);
        //adding the duns of the first node in the family tree to the dunsArray
        $firstNodeDuns = $this->getObjectValue($dnbFTApiResponse, $this->familyTreePaths['duns']);
        $firstNodeDuns = str_pad($firstNodeDuns, 9, "0", STR_PAD_LEFT);
        $dunsArray[] = $firstNodeDuns;
        //omit the current DUNS from the dunsArray
        $currentDUNS = $this->getObjectValue($dnbFTApiResponse, $this->familyTreePaths['inquiryDet']);
        if (!empty($currentDUNS) && in_array($currentDUNS, $dunsArray)) {
            $dunsPos = array_search($currentDUNS, $dunsArray);
            // Remove from array
            unset($dunsArray[$dunsPos]);
        }
        //get the list of duns existing in sugar that match with the above list of duns
        $existingDUNSArray = json_decode($this->getExistingRecords('duns_num', 'Accounts', $dunsArray), true);
        if (count($existingDUNSArray) > 0) {
            $commonDuns = $this->underscorePluck($existingDUNSArray, 'duns_num');
            //identify the duns common in the api response and in the sugar db and make the dupe
            $modifiedFamilyTree = $this->markFamilyTreeDuplicates(
                $this->getObjectValue($dnbFTApiResponse, $this->familyTreePaths['familyTree']),
                $commonDuns
            );
            //marking the first node as duplicate if it is
            if (in_array($firstNodeDuns, $commonDuns)) {
                $dnbFTApiResponse['OrderProductResponse']['OrderProductResponseDetail']['Product']['Organization']['isDupe'] = true;
            }
            if ($modifiedFamilyTree) {
                $dnbFTApiResponse['OrderProductResponse']['OrderProductResponseDetail']['Product']['Organization']['Linkage']['FamilyTreeMemberOrganization'] = $modifiedFamilyTree;
            }
        }
        return $dnbFTApiResponse;
    }

    /**
     * Checks the D&B List of contacts for contacts already existing in SugarDB
     * @param array $dnbApiResponse
     * @param string $path
     * @param string $contactType
     * @return mixed
     */
    private function checkAndMarkDuplicateContacts($dnbApiResponse, $path, $contactType)
    {
        // get existing contacts
        $dnbPrincIdArray = array();
        $dnbContactsList = $this->getObjectValue($dnbApiResponse, $path);
        //get the list of dnb principal ids from the above list of contacts
        $this->underscoreEach(
            $dnbContactsList,
            function ($contactObj) use (&$dnbPrincIdArray) {
                $dnbPrincIdArray[] = $contactObj['PrincipalIdentificationNumberDetail'][0]['PrincipalIdentificationNumber'];
            }
        );
        //get the list of principal ids existing in sugar that match with the above list of principal ids
        $existingPrincIdArray = json_decode($this->getExistingRecords('dnb_principal_id', $contactType, $dnbPrincIdArray), true);
        if (count($existingPrincIdArray) > 0) {
            //identify the contacts common in the api response and in the sugar db and mark the dupe
            $modifiedContactsList = $this->getCommonRecords($dnbContactsList, $existingPrincIdArray, $this->commonJsonPaths['principalIdPath'], 'dnb_principal_id');
            if ($modifiedContactsList && count($modifiedContactsList) > 0) {
                $this->setObjectValue($dnbApiResponse, $path, $modifiedContactsList);
            }
        }
        return $dnbApiResponse;
    }

    /**
     * API used to check for duplicates in D&B API Response
     * This API is primarily being created to check the browser cached responses for duplicates
     * @param array $dupeCheckParams
     * $dupeCheckParams must have two keys
     * 1. type -- Currently four possible values (duns,contacts,leads,prospects)
     * 2. apiResponse -- The api response to be marked as duplicates
     * 3. module -- findcompany, competitors, cleansematch, familytree, contacts, contactsPage
     * @return array
     */
    public function dupeCheck($dupeCheckParams)
    {
        //validate parameters
        if (empty($dupeCheckParams['type']) || empty($dupeCheckParams['apiResponse']) || empty($dupeCheckParams['module'])) {
            return array('error' => 'ERROR_EMPTY_PARAM');
        }
        $type = $dupeCheckParams['type'];
        $apiResponse = $dupeCheckParams['apiResponse'];
        $module = $dupeCheckParams['module'];
        if ($type === 'duns') {
            if ($module === 'familytree') {
                $modifiedApiResponse = $this->checkAndMarkFTDuplicateDuns($apiResponse);
                return $modifiedApiResponse;
            } else if ($module === 'dunsPage') {
                $modifiedApiResponse = $this->checkAndMarkDuplicateLists($apiResponse, 'duns_num', 'Accounts', 'duns_num');
                return $modifiedApiResponse;
            } else {
                $path = $this->commonJsonPaths[$module];
                if (!empty($path)) {
                    $modifiedApiResponse = $this->checkAndMarkDuplicateDuns($apiResponse, $path);
                    if (!empty($modifiedApiResponse)) {
                        $this->setObjectValue($apiResponse, $path, $modifiedApiResponse);
                    }
                    return $apiResponse;
                } else {
                    return array('error' => 'ERROR_INVALID_MODULE_NAME');
                }
            }
        } else if (in_array($type, $this->contactModules)) {
            $path = !empty($this->commonJsonPaths[$module]) ? $this->commonJsonPaths[$module] : '';
            if ($module === 'contactsPage') {
                $modifiedApiResponse = $this->checkAndMarkDuplicateLists($apiResponse, 'principalId', $type, 'dnb_principal_id');
                return $modifiedApiResponse;
            } else if (!empty($path)) {
                //handle the dupe check for a contacts page
                $modifiedApiResponse = $this->checkAndMarkDuplicateContacts($apiResponse, $path, $type);
                if (!empty($modifiedApiResponse)) {
                    return $modifiedApiResponse;
                } else {
                    return $apiResponse;
                }
            } else {
                return array('error' => 'ERROR_INVALID_MODULE_NAME');
            }
        }
    }

    /**
     * Checks the D&B List of contacts / companies for duplicates SugarDB
     * @param array $list
     * @param string $listKey (to retrieve the key to duplicate check against)
     * @param string $module possible values are Accounts, Contacts, Leads, Prospects
     * @param string $moduleKey (refers to the key in the module against which the duplicate check is done)
     * @return array
     */
    protected function checkAndMarkDuplicateLists($list, $listKey, $module, $moduleKey)
    {
        //array to hold a list of ids
        $idArray = array();
        //get the list of ids to dupe check
        foreach ($list as $listItem) {
            $idArray[] = $listItem[$listKey];
        }
        //gets the list of records from sugardb that match the idArrsy
        $existingIdsArray = json_decode($this->getExistingRecords($moduleKey, $module, $idArray), true);
        if (count($existingIdsArray) > 0) {
            //mark the records in the sugardb as dupes
            $list = $this->getCommonRecords($list, $existingIdsArray, $listKey, $moduleKey);
        }
        return $list;
    }

    /**
     * Bulk imports D&B data
     * @param $module String (Accounts)
     * @param $bulkArray
     * @return array
     */
    public function dnbBulkImport($module, $bulkArray)
    {
        if($module !== 'Accounts') {
            return array('error' => 'ERROR_INVALID_MODULE_NAME');
        }
        $importSuccess = 0;
        $duplicates = 0;
        $results = null;
        //loop through the array of dnbObjects to be imported
        foreach($bulkArray as $dnbObj) {
            $bean = BeanFactory::getBean($module);
            //set bean data
            foreach($dnbObj as $key => $value) {
                $bean->{$key} = $dnbObj[$key];
            }
            //check for duplicates
            //retrieve possible duplicates
            $results = $bean->findDuplicates();
            $duplicateRecordCount = 0;
            if (!empty($results['records'])) {
                $duplicateRecordCount = count($results['records']);
            }
            if ($duplicateRecordCount === 0) {
                $bean->save();
                $importSuccess++;
            } else {
                //counter for duplicates
                $duplicates++;
            }
        }
        //importInforrmation contains info about count of records succesfully imported
        // and # of duplicates imported
        return array('importSuccess' => $importSuccess,
            'duplicates' => $duplicates
        );
    }
}
