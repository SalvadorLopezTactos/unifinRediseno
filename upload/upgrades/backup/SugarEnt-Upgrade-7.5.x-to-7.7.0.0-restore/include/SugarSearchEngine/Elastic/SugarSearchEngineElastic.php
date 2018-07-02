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
require_once('include/SugarSearchEngine/SugarSearchEngineAbstractBase.php');
require_once('include/SugarSearchEngine/Elastic/SugarSearchEngineElasticResultSet.php');
require_once('include/SugarSearchEngine/SugarSearchEngineMetadataHelper.php');
require_once('include/SugarSearchEngine/SugarSearchEngineHighlighter.php');
require_once('include/SugarSearchEngine/Elastic/Facets/FacetHandler.php');
require_once('include/SugarSearchEngine/Elastic/SugarSearchEngineElasticIndexStrategyFactory.php');
SugarAutoLoader::requireWithCustom('include/SugarSearchEngine/Elastic/SugarSearchEngineElasticMapping.php');

/**
 * Engine implementation for ElasticSearch
 */
class SugarSearchEngineElastic extends SugarSearchEngineAbstractBase
{
    private $_config = array();
    private $_client = null;

    const DEFAULT_INDEX_TYPE = 'SugarBean';
    const WILDCARD_CHAR = '*';

    private $_indexType = 'SugarBean';

    /**
     *
     * Force asynchronous indexing using fts_queue
     * Defaults to false unless configured
     *
     * @see $sugar_config['search_engine']['force_async_index']
     * @var boolean
     */
    protected $forceAsyncIndex = false;

    /**
     *
     * Ignored elastic field types which are incompatible
     * with current elastic query construction
     * @var array
     */
    protected $ignoreSearchTypes = array(
        'date',
        'integer',
    );

    /**
     *
     * Elastic Mapping object
     * @var SugarSearchEngineElasticMapping
     */
    protected $mapper;

    /**
     *
     * Facet handler
     * @var FacetHandler
     */
    protected $facetHandler;

    /**
     *
     * Index strategy object
     *
     * @var SugarSearchEngineIndexStrategy
     */
    protected $indexStrategy;

    public function __construct($params = array())
    {
        // Setup Elastica Client object
        $this->_config = $params;

        // this timeout can be overriden at $sugar_config['full_text_engine']['Elastic']['timeout']
        if (empty($this->_config['timeout'])) {
            $this->_config['timeout'] = 15;
        }
        $this->setClient(new \Elastica\Client($this->_config));

        // Setup index strategy
        $this->indexStrategy = SugarSearchEngineElasticIndexStrategyFactory::getinstance();

        // Asynchronous indexing through fts_queue table
        $this->forceAsyncIndex = SugarConfig::getInstance()->get('search_engine.force_async_index', false);

        // Elastic mapping
        $mappingClass = SugarAutoLoader::customClass('SugarSearchEngineElasticMapping');
        $this->mapper = new $mappingClass($this);

        // Facet handler
        $this->facetHandler = new FacetHandler();

        parent::__construct();
    }

    /**
     * Setter forceAsyncIndex
     * @param boolean $value
     */
    public function setForceAsyncIndex($value)
    {
        $this->forceAsyncIndex = $value;
    }

    /**
     * setter connection timeout
     * @param integer $value CURLOPT_TIMEOUT for http elastica backend
     */
    public function setTimeout($value)
    {
        $this->_config['timeout'] = $value;
        $this->_client->setConfigValue('timeout', $value);
        foreach ($this->_client->getConnections() as $connection) {
            $connection->setTimeout($value);
        }
    }

    /**
     * Check if this is an Elastic client exception, disable FTS if it is
     * @param $e Exception
     * @return boolean tru if it's an Elastic client exception, false otherwise
     */
    protected function checkException($e)
    {
        if ($e instanceof \Elastica\Exception\Connection\HttpException) {
            $error = $e->getError();
            switch ($error) {
                case CURLE_UNSUPPORTED_PROTOCOL:
                case CURLE_FAILED_INIT:
                case CURLE_URL_MALFORMAT:
                case CURLE_COULDNT_RESOLVE_PROXY:
                case CURLE_COULDNT_RESOLVE_HOST:
                case CURLE_COULDNT_CONNECT:
                case CURLE_OPERATION_TIMEOUTED:
                    $this->disableFTS();
                    return true;
            }
        }
        return false;
    }

    /**
     * Either index single bean or add the record to be indexed into _documents for later batch indexing,
     * depending on the $batch parameter
     *
     * @param $bean SugarBean object to be indexed
     * @param $batch boolean whether to do batch index
     */
    public function indexBean($bean, $batch = true)
    {
        if (!$this->isModuleFtsEnabled($bean->module_dir)) {
            return;
        }

        if (!$batch) {
            if (self::isSearchEngineDown() || $this->forceAsyncIndex) {
                $this->addRecordsToQueue(
                    array(
                        array(
                            'bean_id' => $bean->id,
                            'bean_module' => $bean->module_dir,
                        )
                    )
                );
                return;
            }
            $this->indexSingleBean($bean);
        } else {
            $this->logger->info("Adding bean to doc list with id: {$bean->id}");

            //Create and store our document index which will be bulk inserted later, do not store beans as they are heavy.
            $this->_documents[] = $this->createIndexDocument($bean);
        }
    }

    /**
     *
     * Return the 'type' for the index.  By using the bean type we can specify mappings on a per bean basis if we need
     * to in the future.
     *
     * @param $bean
     * @return string
     */
    protected function getIndexType($bean)
    {
        if (!empty($bean->module_dir)) {
            return $bean->module_dir;
        } else {
            return self::DEFAULT_INDEX_TYPE;
        }
    }

    /**
     *
     * @param SugarBean $bean
     * @param $searchFields
     * @return mixed(\Elastica\Document|null)
     */
    public function createIndexDocument($bean, $searchFields = null)
    {
        if ($searchFields == null) {
            $searchFields = SugarSearchEngineMetadataHelper::retrieveFtsEnabledFieldsPerModule($bean);
        }

        if (!empty($searchFields['email1']) && empty($bean->email1)) {
            $emailAddress = BeanFactory::getBean('EmailAddresses');
            $bean->email1 = $emailAddress->getPrimaryAddress($bean);
        }

        $bean->beforeSseIndexing();

        $keyValues = array();
        foreach ($searchFields as $fieldName => $fieldDef) {
            // when creating a new bean, the auto_increment field can be null, even after save
            if (!isset($bean->$fieldName) && !empty($fieldDef['auto_increment'])) {
                $bean->$fieldName = $this->getFieldValue($fieldName, $bean);
            }

            //All fields have already been formatted to db values at this point so no further processing necessary
            if (!empty($bean->$fieldName)) {
                // 1. elasticsearch does not handle multiple types in a query very well
                // so let's use only strings so it won't be indexed as other types
                // 2. for some reason, bean fields are encoded, decode them first
                // We are handling date range search for Meetings which is type datetimecombo
                if (!isset($fieldDef['type']) || $fieldDef['type'] != 'datetimecombo') {
                    //$keyValues[$fieldName] = strval(html_entity_decode($bean->$fieldName,ENT_QUOTES));
                    // NOTE Bug 53394 resulted in the decoding scheme above. This needs to be reevaluated in the context of using the right analyzers.
                    $keyValues[$fieldName] = $bean->$fieldName;
                } elseif (isset($fieldDef['type']) && $fieldDef['type'] == 'datetimecombo') {
                    // dates have to be in ISO-8601 without the : in the TZ
                    global $timedate;

                    $date = $timedate->fromUser($bean->$fieldName);
                    if (empty($date)) {
                        $date = $timedate->fromDb($bean->$fieldName);
                    }

                    if ($date instanceof SugarDateTime) {
                        $keyValues[$fieldName] = $timedate->asIso($date, null, array('stripTZColon' => true));
                    } else {
                        $GLOBALS['log']->error("TimeDate Conversion Failed for " . get_class($bean) . "->{$fieldName}");
                    }
                } else {
                    $keyValues[$fieldName] = $bean->$fieldName;
                }
            }
        }

        //Always add our module
        $keyValues['module'] = $bean->module_dir;

        if( empty($keyValues) ) {
            return null;
        } else {
            //base document
            $document = new \Elastica\Document($bean->id, $keyValues, $this->getIndexType($bean));
            return $document;
        }
    }

    /**
     * This indexes one single bean to Elastic Search engine
     * @param SugarBean $bean
     */
    public function indexSingleBean($bean)
    {
        $this->logger->info("Preforming single bean index");
        try {
            $indexName = $this->getWriteIndexForBean($bean);
            $this->logger->debug("Writing bean {$bean->id} to index $indexName");

            $index = new \Elastica\Index($this->_client, $indexName);
            $type = new \Elastica\Type($index, $this->getIndexType($bean));
            $doc = $this->createIndexDocument($bean);
            if ($doc != null) {
                $type->addDocument($doc);
            }
        } catch (Exception $e) {
            $this->reportException("Unable to index bean", $e);
            if ($this->checkException($e)) {
                $recordsToBeQueued = $this->getRecordsFromDocs(array($doc));
                $this->addRecordsToQueue($recordsToBeQueued);
            }
        }

    }

    /**
     * (non-PHPdoc)
     * @see SugarSearchEngineInterface::delete()
     */
    public function delete(SugarBean $bean)
    {
        if (self::isSearchEngineDown()) {
            return;
        }
        if (empty($bean->id)) {
            return;
        }

        try {
            $indexName = $this->getWriteIndexForBean($bean);
            $this->logger->debug("Going to delete {$bean->id} on index $indexName");

            $index = new \Elastica\Index($this->_client, $indexName);
            $type = new \Elastica\Type($index, $this->getIndexType($bean));
            $type->deleteById($bean->id);
        } catch (Exception $e) {
            $this->reportException("Unable to delete index", $e);
            $this->checkException($e);
        }
    }

    /**
     * (non-PHPdoc)
     * @see SugarSearchEngineInterface::bulkInsert()
     */
    public function bulkInsert(array $docs)
    {
        if (self::isSearchEngineDown()) {
            $recordsToBeQueued = $this->getRecordsFromDocs($docs);
            $this->addRecordsToQueue($recordsToBeQueued);
            return false;
        }

        try {
            $batchedDocs = array();
            $x = 0;

            $bulk = $this->newElasticaBulk();

            /* If we use a single index we can put it directly in the url
             * of our request. This will make the bulk request smaller and
             * allows the usage of the ES security parameters
             * "rest.action.multi.allow_explicit_index: false" to be able
             * to perform URL based access control.
             */
            if ($this->useSingleIndex()) {
                $bulk->setIndex($this->getWriteIndexName());
                $singleIndex = true;
            }

            foreach ($docs as $singleDoc) {

                // Only put the index name on the document directly if we
                // are not using a single index (see above)
                if (empty($singleIndex)) {
                    $indexName = $this->getWriteIndexForElasticaDocument($singleDoc);
                    $singleDoc->setIndex($indexName);
                }

                if ($x != 0 && $x % $this->max_bulk_doc_threshold == 0) {
                    $bulk->addDocuments($batchedDocs);
                    $bulk->send();
                    $batchedDocs = array();
                }
                $batchedDocs[] = $singleDoc;
                $x++;
            }

            //Commit the stragglers
            if (count($batchedDocs) > 0) {
                $bulk->addDocuments($batchedDocs);
                $bulk->send();
            }
        } catch (Exception $e) {
            $this->reportException("Error performing bulk update operation", $e);
            if ($this->checkException($e)) {
                $recordsToBeQueued = $this->getRecordsFromDocs($batchedDocs);
                $this->addRecordsToQueue($recordsToBeQueued);
            }
            return false;
        }

        return true;
    }

    /**
     * Get new Elastica Bulk object
     * @param \Elastica\Client $client
     * @return \Elastica\Bulk
     */
    protected function newElasticaBulk(\Elastica\Client $client = null)
    {
        $client = $client ?: $this->_client;
        return new \Elastica\Bulk($client);
    }

    /**
     * Check if we are using a single index
     * @return boolean
     */
    protected function useSingleIndex()
    {
        return ($this->indexStrategy instanceof SugarSearchEngineElasticIndexStrategySingle);
    }

    /**
     * Given an array of documents, this constructs an array of records that can be saved to FTS queue.
     * @param SugarBean $bean
     * @return array
     */
    protected function getRecordsFromDocs($docs)
    {
        $records = array();
        $i = 0;
        foreach ($docs as $doc) {
            $records[$i]['bean_id'] = $doc->getId();
            $records[$i]['bean_module'] = BeanFactory::getBeanName($doc->getType());
            $i++;
        }
        return $records;
    }

    /**
     * Check the server status
     */
    public function getServerStatus()
    {
        global $app_strings, $sugar_config;
        $isValid = false;
        $displayText = "";
        try {
            $response = $this->_client->request('', \Elastica\Request::GET);
            if ($response->isOk()) {
                $isValid = true;
                if (!empty($GLOBALS['app_strings'])) {
                    $displayText = $app_strings['LBL_EMAIL_SUCCESS'];
                } else {
                    //Fix a notice error during install when we verify the Elastic Search settings
                    $displayText = 'Success';
                }
            } else {
                $displayText = $app_strings['ERR_ELASTIC_TEST_FAILED'];
            }
        } catch (Exception $e) {
            $this->reportException("Unable to get server status", $e);
            $displayText = $e->getMessage();
        }
        return array('valid' => $isValid, 'status' => $displayText);
    }

    /**
     * This function returns an array of fields that can be passed to search engine.
     * @param Array $options
     * @param boolean $prefixed Add module name prefix (i.e. Contacts.first_name)
     * @return Array array of fields
     */
    protected function getSearchFields($options, $prefixed = true)
    {
        $fields = array();

        // determine list of modules/fields
        $allFieldDefs = array();
        if (!empty($options['moduleFilter'])) {
            foreach ($options['moduleFilter'] as $module) {
                $allFieldDefs[$module] = SugarSearchEngineMetadataHelper::retrieveFtsEnabledFieldsPerModule($module);
            }
        } else {
            $allFieldDefs = SugarSearchEngineMetadataHelper::retrieveFtsEnabledFieldsForAllModules();
        }

        // build list of fields with optional boost values (i.e. Accouns.name^3)
        foreach ($allFieldDefs as $module => $fieldDefs) {
            foreach ($fieldDefs as $fieldName => $fieldDef) {

                // skip non-supported field types
                $ftsType = $this->mapper->getFtsTypeFromDef($fieldDef);
                if (!$ftsType || in_array($ftsType['type'], $this->ignoreSearchTypes)) {
                    $this->logger->debug("Elastic: Ignoring unsupported type in query for $module/$fieldName");
                    continue;
                }

                // base field name
                if ($prefixed) {
                    $fieldName = $module . '.' . $fieldName;
                }

                // To enable a field for user search we require a boost value. There may be other fields
                // we index into Elastic but which should not be user searchable. We use the boost value
                // being set or not to distinguish between both scenarios. For example for extended facets
                // and related fields we can store additional fields or non analyzed data. While we need
                // those fields being indexed, we do not want the user to be able to hit those when
                // performing a search.
                if (empty($fieldDef['full_text_search']['boost'])) {
                    $this->logger->debug("Elastic: skipping $module/$fieldName for search field (no boost set)");
                    continue;
                } else {
                    if (!empty($options['addSearchBoosts'])) {
                        $fieldName .= '^' . $fieldDef['full_text_search']['boost'];
                    }
                    $fields[] = $fieldName;
                }
            }
        }

        return $fields;
    }

    /**
     * Given fields and options, this function constructs and returns a highlight array that can be passed to
     * search engine.
     * @param SugarBean $bean
     * @param $searchFields
     * @return mixed(\Elastica\Document|null)
     */
    protected function constructHighlightArray($fields, $options)
    {
        if (isset($options['preTags'])) {
            $preTags = $options['preTags'];
        } else {
            $preTags = SugarSearchEngineHighlighter::$preTag;
        }

        if (isset($options['postTags'])) {
            $postTags = $options['postTags'];
        } else {
            $postTags = SugarSearchEngineHighlighter::$postTag;
        }

        $fieldArray = array();
        $highlightProperties = new stdClass();
        if (isset($options['fragmentSize'])) {
            $highlightProperties->fragment_size = $options['fragmentSize'] + strlen($preTags) + strlen($postTags);
        } else {
            $highlightProperties->fragment_size = SugarSearchEngineHighlighter::$fragmentSize + strlen($preTags) + strlen($postTags);
        }

        if (isset($options['fragmentNumber'])) {
            $highlightProperties->number_of_fragments = $options['fragmentNumber'];
        } else {
            $highlightProperties->number_of_fragments = SugarSearchEngineHighlighter::$fragmentNumber;
        }

        foreach ($fields as $field) {
            $fieldArray[$field] = $highlightProperties;
        }

        $highlighArray = array('fields'=>$fieldArray,
            'order'=>'score',
            'pre_tags'=>array($preTags),
            'post_tags'=>array($postTags));

        return $highlighArray;
    }

    /**
     * This function determines whether we should append wildcard to search string.
     *
     * @param String $queryString
     * @return Boolean
     */
    protected function canAppendWildcard($queryString)
    {
        $queryString = trim(html_entity_decode($queryString, ENT_QUOTES));
        if (substr($queryString, -1) ===  self::WILDCARD_CHAR) {
            return false;
        }

        // for fuzzy search, do not append wildcard
        if (strpos($queryString, '~') !==  false) {
            return false;
        }

        // for range searches, do not append wildcard
        if (preg_match('/\[.*TO.*\]/', $queryString) || preg_match('/{.*TO.*}/', $queryString)) {
            return false;
        }

        // for group searches, do not append wildcard
        if (preg_match('/\(.*\)/', $queryString)) {
            return false;
        }

        // when using double quotes, do not append wildcard
        if (strpos($queryString, '"') !==  false) {
            return false;
        }

        return true;
    }

    /*
     * A sample team filter looks like this:
       {"or": [
         {"term":{"team_set_id":"1"}},
         {"term":{"team_set_id":"46ca01386366bc910d074fb2f8200f03"}},
         {"term":{"team_set_id":"East"}},
         {"term":{"team_set_id":"West"}}]
       }
    */
    /**
     * This function constructs and returns team filter for elasticsearch query.
     *
     * @return \Elastica\Filter\Terms
     */
    public function getTeamTermFilter()
    {
        global $current_user;
        if(empty($current_user)) {
            // This condition should never happen, but just to be consistent with the SQl side of the house, we are adding a filter that is false for this module
            $termFilter = new \Elastica\Filter\Terms('team_set_id', array('Non existing team_set_id to fake search term that is always false'));
        } else {
            $teamIDS = TeamSet::getTeamSetIdsForUser($current_user->id);
            $termFilter = new \Elastica\Filter\Terms('team_set_id', $teamIDS);
        }

        return $termFilter;
    }

    /**
     * This function constructs and returns type term filter for elasticsearch query.
     *
     * @return \Elastica\Filter\Term
     */
    protected function getTypeTermFilter($module)
    {
        $typeTermFilter = new \Elastica\Filter\Term();
        $typeTermFilter->setTerm('_type', $module);

        return $typeTermFilter;
    }

    /**
     * This function constructs and returns owner term filter for elasticsearch query.
     *
     * @return \Elastica\Filter\Term
     */
    public function getOwnerTermFilter()
    {
        $ownerTermFilter = new \Elastica\Filter\Term();
        $ownerTermFilter->setTerm('doc_owner', $GLOBALS['current_user']->id);

        return $ownerTermFilter;
    }

    /**
     * This function constructs and returns module level filter for elasticsearch query.
     *
     * @return \Elastica\Filter\BoolAnd
     */
    protected function constructModuleLevelFilter($module, $options = array())
    {
        $moduleFilter = new \Elastica\Filter\Bool();
        $typeTermFilter = $this->getTypeTermFilter($module);
        $moduleFilter->addMust($typeTermFilter);

        $seed = BeanFactory::newBean($module);
        $moduleFilter = $seed->addSseVisibilityFilter($this, $moduleFilter);

        return $moduleFilter;
    }

    /**
     * This function constructs and returns main filter for elasticsearch query.
     *
     * @return \Elastica\Filter\BoolOr
     */
    protected function constructMainFilter($finalTypes, $options = array())
    {
        $mainFilter = new \Elastica\Filter\Bool();
        foreach ($finalTypes as $module) {
            $moduleFilter = $this->constructModuleLevelFilter($module, $options);
            // if we want myitems add more to the module filter
            if(isset($options['my_items']) && $options['my_items'] !== false) {
                $moduleFilter = $this->constructMyItemsFilter($moduleFilter);
            }
            if (isset($options['filter']) && $options['filter']['type'] == 'range') {
                $moduleFilter = $this->constructRangeFilter($moduleFilter, $options['filter']);
            }

            // we only want JUST favorites if the option is 2
            // if the option is 1 that means we want all including favorites,
            // which in FTS is a normal search parameter
            if (isset($options['favorites']) && $options['favorites'] == 2) {
                $moduleFilter = $this->constructMyFavoritesFilter($moduleFilter);
            }

            $mainFilter->addShould($moduleFilter);

        }

        return $mainFilter;
    }



    /**
     * Construct a favorites filter
     * @param object $moduleFilter
     * @return \Elastica\Filter\Term $moduleFilter
     */

    protected function constructMyFavoritesFilter($moduleFilter)
    {
        $ownerTermFilter = new \Elastica\Filter\Term();
        // same bug as team set id, looking into a fix in elastic search to allow -'s without tokenizing

        $ownerTermFilter->setTerm('user_favorites', $GLOBALS['current_user']->id);
        $moduleFilter->addMust($ownerTermFilter);

        return $moduleFilter;
    }

    /**
     * Construct a Range Filter to
     * @param object $moduleFilter
     * @param array $filter
     * @return object $moduleFilter
     */
    protected function constructRangeFilter($moduleFilter, $filter)
    {
        $filter = new \Elastica\Filter\Range($filter['fieldname'], $filter['range']);
        $moduleFilter->addMust($filter);
        return $moduleFilter;
    }

    /**
     * Add a Owner Filter For MyItems to the current module
     * @param object $moduleFilter
     * @return object
     */
    protected function constructMyItemsFilter($moduleFilter)
    {
        $ownerTermFilter = $this->getOwnerTermFilter();
        $moduleFilter->addMust($ownerTermFilter);
        return $moduleFilter;
    }

    /**
     * @param $queryString
     * @param int $offset
     * @param int $limit
     * @return null|SugarSeachEngineElasticResultSet
     */
    public function search($queryString, $offset = 0, $limit = 20, $options = array())
    {
        if (self::isSearchEngineDown()) {
            return null;
        }

        $appendWildcard = false;
        if (!empty($options['append_wildcard']) && $this->canAppendWildcard($queryString)) {
            $appendWildcard = true;
        }
        $queryString = DBManagerFactory::getInstance()->sqlLikeString(
            $queryString,
            self::WILDCARD_CHAR,
            $appendWildcard
        );

        $this->logger->info("Going to search with query $queryString");
        $results = null;
        try {
            // trying to match everything, make a MatchAll query
            if ($queryString == '*') {
                $queryObj = new \Elastica\Query\MatchAll();

            } else {
                $qString = html_entity_decode($queryString, ENT_QUOTES);

                // we need to escape slash for lucene query_string query
                $qString = str_replace('/', '\\/', $qString);

                $queryObj = new \Elastica\Query\QueryString($qString);
                $queryObj->setAnalyzeWildcard(true);
                $queryObj->setAutoGeneratePhraseQueries(false);

                // set query string fields
                $options['addSearchBoosts'] = true;
                $fields = $this->getSearchFields($options);
                $options['addSearchBoosts'] = false;
                if (!empty($options['searchFields'])) {
                    $queryObj->setFields($options['searchFields']);
                } else {
                    $queryObj->setFields($fields);
                }
            }
            $s = new \Elastica\Search($this->_client);

            $finalTypes = array();
            if (!empty($options['moduleFilter'])) {
                foreach ($options['moduleFilter'] as $moduleName) {
                    // only add the module to the list if it can be viewed
                    if ($this->checkAccess($moduleName)) {
                        $finalTypes[] = $moduleName;
                    }
                }
                if (!empty($finalTypes)) {
                    $s->addTypes($finalTypes);
                }
            }

            $s->addIndices($this->getReadIndices($finalTypes));

            // main filter
            $mainFilter = $this->constructMainFilter($finalTypes, $options);

            $query = new \Elastica\Query($queryObj);
            $query->setFilter($mainFilter);

            if (isset($options['sort']) && is_array($options['sort'])) {
                foreach ($options['sort'] as $sort) {
                    $query->addSort($sort);
                }
            }

            $query->setParam('from', $offset);

            // set query highlight
            $fields = $this->getSearchFields($options, false);
            $highlighArray = $this->constructHighlightArray($fields, $options);
            $query->setHighlight($highlighArray);

            // add facets
            $this->addFacets($query, $options, $mainFilter);

            $esResultSet = $s->search($query, $limit);
            $results = new SugarSeachEngineElasticResultSet($esResultSet);
        } catch (Exception $e) {
            $this->reportException("Unable to perform search", $e);
            $this->checkException($e);
            return null;
        }
        return $results;
    }

    /**
     *
     * Add facets on elastic query object
     * @param \Elastica\Query $query
     * @param array $options
     * @param \Elastica\Filter\AbstractFilter $mainFilter
     */
    protected function addFacets(
        \Elastica\Query $query,
        $options = array(),
        \Elastica\Filter\AbstractFilter $mainFilter = null
    ) {
        // module facet (note: would be less confusing to give another name instead of _type)
        if (!empty($options['apply_module_facet'])) {
            $typeFacet = new \Elastica\Facet\Terms('_type');
            $typeFacet->setField('_type');
            // need to add filter for facet too
            if (isset($mainFilter)) {
                $typeFacet->setFilter($mainFilter);
            }
            $query->addFacet($typeFacet);
        }

        // handle secondary facets
        $this->facetHandler->addFacets($query, $options, $mainFilter);
    }

    /**
     * Create the index and mapping.
     *
     * @param boolean $recreate OPTIONAL Deletes index first if already exists (default = false)
     * @param array   $modules  OPTIONAL list of modules to create an index for
     *
     */
    public function createIndex($recreate = false, $modules = array())
    {
        if (self::isSearchEngineDown()) {
            return;
        }

        try {
            $this->indexStrategy->createIndex($this->_client, $modules, $this->mapper, $this->_config, $recreate);
        } catch (Exception $e) {
            $this->reportException("Unable to create index", $e);
            $this->checkException($e);
        }
    }

    /**
     * Checks whether the user has access to view the module being searched.
     * @param  string $moduleName
     * @return bool
     */
    protected function checkAccess($moduleName)
    {
        $seed = BeanFactory::newBean($moduleName);
        return $seed->ACLAccess('ListView');
    }

    /**
     * Get Elastica client
     * @return \Elastica\Client
     */
    public function getClient()
    {
        return $this->_client;
    }

    /**
     * Set Elasttica client
     * @param \Elastica\Client $client
     */
    public function setClient(\Elastica\Client $client)
    {
        $this->_client = $client;
    }

    /**
     * this defines the field types that can be enabled for full text search
     * @var array
     */
    protected static $ftsEnabledFieldTypes = array('name', 'user_name', 'varchar', 'decimal', 'float', 'int', 'phone', 'text', 'url', 'relate');

    /**
     *
     * Given a field type, determine whether this type can be enabled for full text search.
     *
     * @param string $type Sugar field type
     *
     * @return boolean whether the field type can be enabled for full text search
     */
    public function isTypeFtsEnabled($type)
    {
        return in_array($type, self::$ftsEnabledFieldTypes);
    }

    /**
     * @param array $modules
     * @return mixed
     */
    protected function getReadIndices($modules = array())
    {
        return $this->indexStrategy->getReadIndices($this->_client, $modules);
    }

    /**
     * Get the name of the index for reading
     *
     * @param arary $module array of module names for reading (optional)
     * @return string
     */
    public function getReadIndexName($moduleNames = array())
    {
        return $this->indexStrategy->getReadIndexName($moduleNames);
    }

    /**
     * Get the name of the index for writing
     *
     * @param string $module name of the module for writing (optional)
     * @return string
     */
    public function getWriteIndexName($params = array())
    {
        return $this->indexStrategy->getWriteIndexName($params);
    }

    /**
     * Get the name of the index for writing
     *
     * @param string $module name of the module for writing (optional)
     * @return string
     */
    public function getAllIndexes($moduleName = '')
    {
        return $this->indexStrategy->getAllIndexes($moduleName);
    }

    /**
     * Returns the Elastic module index name for a bean
     * @param SugarBean $bean
     * @returns string module name
     */
    public function getWriteIndexForBean($bean)
    {
        return $this->indexStrategy->getWriteIndexName(array('context' => $bean));
    }

    /**
     * Returns the Elastic module index name for an elastic document ready to be indexed
     * @param Elastica_Document $doc
     * @returns string module name
     */
    public function getWriteIndexForElasticaDocument($doc)
    {
        return $this->indexStrategy->getWriteIndexName(array('context' => $doc));
    }
}
