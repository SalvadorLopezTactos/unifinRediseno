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

require_once("include/SugarSearchEngine/Interface.php");
require_once('include/SugarSearchEngine/Elastic/SugarSeachEngineElasticResult.php');

use Sugarcrm\Sugarcrm\Elasticsearch\Query\Highlighter\HighlighterInterface;

/**
 * Adapter class to Elastica Result Set
 *
 *                      !!! DEPRECATION WARNING !!!
 *
 * All code in include/SugarSearchEngine is going to be deprecated in a future
 * release. Do not use any of its APIs for code customizations as there will be
 * no guarantee of support and/or functionality for it. Use the new framework
 * located in the directories src/SearchEngine and src/Elasticsearch.
 *
 * @deprecated
 */
class SugarSeachEngineElasticResultSet implements SugarSearchEngineResultSet
{

    /**
     * @var \Elastica\ResultSet
     */
    private $elasticaResultSet;

    /**
     * @var HighlighterInterface
     */
    protected $highlighter;

    /**
     * @param \Elastica\ResultSet $rs
     */
    public function __construct(\Elastica\ResultSet $rs)
    {
        $this->elasticaResultSet = $rs;
    }

    /**
     * Return the total number of hits found from our search
     *
     * @return int
     */
    public function getTotalHits()
    {
        return $this->elasticaResultSet->getTotalHits();
    }

    /**
     * Return facets associated with this search.
     *
     * @return array
     */
    public function getFacets()
    {
        return $this->elasticaResultSet->getFacets();
    }

    /**
     * Return the facet results for the modules used in the search.
     *
     * @return array|bool
     */
    public function getModuleFacet()
    {
        $rs = $this->elasticaResultSet->getFacets();
        $results = array();
        if( !isset($rs['_type'] ) || !isset($rs['_type']['terms']) )
        {
            return FALSE;
        }
        else
        {
            foreach( $rs['_type']['terms'] as $entry)
            {
                $results[$entry['term']] = $entry['count'];
            }

            return $results;
        }
    }
    /**
     * Get the total amount of time the search took to complete.
     *
     * @return int
     */
    public function getTotalTime()
    {
        return $this->elasticaResultSet->getTotalTime();
    }

    public function current()
    {
        $res = new SugarSeachEngineElasticResult($this->elasticaResultSet->current());
        if (isset($this->highlighter)) {
            $res->setHighlighter($this->highlighter);
        }
        return $res;
    }

    public function key()
    {
        return $this->elasticaResultSet->key();
    }

    public function next()
    {
        $this->elasticaResultSet->next();
    }

    public function rewind()
    {
        $this->elasticaResultSet->rewind();
    }

    public function valid()
    {
        return $this->elasticaResultSet->valid();
    }

    /**
     * Return the count of hits returned, may not necessarily equal total hits.
     *
     * @return int
     */
    public function count()
    {
        return $this->elasticaResultSet->count();
    }

    /**
     * Set highlighter
     * @param HighlighterInterface $highlighter
     */
    public function setHighlighter(HighlighterInterface $highlighter)
    {
        $this->highlighter = $highlighter;
    }
}
