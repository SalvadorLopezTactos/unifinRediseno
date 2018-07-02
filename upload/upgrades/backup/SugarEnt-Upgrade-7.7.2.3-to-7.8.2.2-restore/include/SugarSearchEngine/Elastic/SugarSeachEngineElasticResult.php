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

require_once 'include/SugarSearchEngine/SugarSearchEngineAbstractResult.php';
require_once 'include/SugarSearchEngine/SugarSearchEngineHighlighter.php';

use Sugarcrm\Sugarcrm\Elasticsearch\Adapter\Result;
use Sugarcrm\Sugarcrm\Elasticsearch\Query\Highlighter\HighlighterInterface;

/**
 * Adapter class to Elastica Result
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
class SugarSeachEngineElasticResult extends SugarSearchEngineAbstractResult
{
    /**
     * @var \Elastica\Result
     */
    protected $elasticaResult;

    /**
     * @var HighlighterInterface
     */
    protected $highlighter;

    /**
     * @param \Elastica\Result $result
     */
    public function __construct(\Elastica\Result $result)
    {
        $this->elasticaResult = $result;
    }

    /**
     * Get bean
     * @return SugarBean
     */
    public function getBean()
    {
        if (empty($this->bean)) {
            $this->bean = BeanFactory::getBean($this->getModule(), $this->getId());
            if (empty($this->bean)) {
                $msg = sprintf(
                    "Unable to load bean '%s' for module '%s' for FTS result set",
                    $this->getId(),
                    $this->getModule()
                );
                $GLOBALS['log']->fatal($msg);
            }
        }
        return $this->bean;
    }

    /**
     * Return the id of the
     *
     * @return string
     */
    public function getId()
    {
        return $this->elasticaResult->getId();
    }

    /**
     *
     * @return array
     */
    public function getModule()
    {
        return $this->elasticaResult->getType();
    }

    /**
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->elasticaResult->getScore();
    }

    /**
     * This function returns an array of highlighted key-value pairs.
     *
     * @param maxFields - the number of highlighted fields to return, 0 = all
     *
     * @return array of key value pairs
     */
    public function getHighlightedHitText($maxFields = 0)
    {
        $ret = array();

        if (isset($this->highlighter)) {
            $parsedResult = new Result($this->elasticaResult);
            $parsedResult->setHighlighter($this->highlighter);
            $highlights = $parsedResult->getHighlights();
        } else {
            $highlights = $this->elasticaResult->getHighlights();
        }

        if (!empty($highlights) && is_array($highlights)) {
            $highlighter = new SugarSearchEngineHighlighter();
            $highlighter->setModule($this->getModule());
            $ret = $highlighter->processHighlightText($highlights);
            if ($maxFields > 0) {
                $ret = array_slice($ret, 0, $maxFields);
            }
        }

        return $ret;
    }

    /**
     * Return _source
     * @return array
     */
    public function getSource()
    {
        return $this->elasticaResult->getSource();
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
