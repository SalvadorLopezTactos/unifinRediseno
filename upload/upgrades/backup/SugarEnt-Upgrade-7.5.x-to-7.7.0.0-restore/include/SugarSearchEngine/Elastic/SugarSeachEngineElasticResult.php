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

require_once("include/SugarSearchEngine/SugarSearchEngineAbstractResult.php");
require_once("include/SugarSearchEngine/SugarSearchEngineHighlighter.php");

/**
 * Adapter class to Elastica Result
 */
class SugarSeachEngineElasticResult extends SugarSearchEngineAbstractResult
{
    /**
     * @var \Elastica\Result
     */
    private $elasticaResult;

    /**
     * @param \Elastica\Result $result
     */
    public function __construct(\Elastica\Result $result)
    {
        $this->elasticaResult = $result;
        //No need to lazy load, will always want to load the bean to fill in the details
        $this->bean = BeanFactory::getBean($this->getModule(), $this->getId());
        if($this->bean === FALSE)
        {
            $GLOBALS['log']->fatal("Unable to load bean with id for FTS result set: {$this->getId()}");
        }
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
        return $this->elasticaResult->module;
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

        $highlights = $this->elasticaResult->getHighlights();

        if (!empty($highlights) && is_array($highlights))
        {
            $highlighter = new SugarSearchEngineHighlighter();
            $highlighter->setModule($this->getModule());
            $ret = $highlighter->processHighlightText($highlights);
            if($maxFields > 0) {
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
}
