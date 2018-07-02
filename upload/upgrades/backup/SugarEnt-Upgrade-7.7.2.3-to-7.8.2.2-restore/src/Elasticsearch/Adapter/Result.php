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

namespace Sugarcrm\Sugarcrm\Elasticsearch\Adapter;

use Sugarcrm\Sugarcrm\SearchEngine\Capability\Aggregation\ResultInterface;
use Sugarcrm\Sugarcrm\Elasticsearch\Query\Highlighter\HighlighterInterface;

/**
 *
 * Adapter class for \Elastica\Result
 *
 */
class Result implements ResultInterface
{
    /**
     * @var \Elastica\Result
     */
    protected $result;

    /**
     * @var HighlighterInterface
     */
    protected $highlighter;

    /**
     * Ctor
     * @param \Elastica\Result $result
     */
    public function __construct(\Elastica\Result $result)
    {
        $this->result = $result;
    }

    /**
     * Set highlighter
     * @param HighlighterInterface $highlighter
     */
    public function setHighlighter(HighlighterInterface $highlighter)
    {
        $this->highlighter = $highlighter;
    }

    /**
     * Overload \Elastica\Result
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, array $args = array())
    {
        return call_user_func_array(array($this->result, $method), $args);
    }

    /**
     * Set highlight remap fields
     * @param array $remap
     */
    public function setHighlightRemap(array $remap)
    {
        $this->highlightRemap = $remap;
    }

    //// ResultInterface ////

    /**
     * {@inheritdoc}
     */
    public function getModule()
    {
        return $this->result->getType();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->result->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->result->getSource();
    }

   /**
     * {@inheritdoc}
     */
    public function getDataFields()
    {
        return array_keys($this->result->getSource());
    }

    /**
     * {@inheritdoc}
     */
    public function getScore()
    {
        return $this->result->getScore();
    }

    /**
     * {@inheritdoc}
     */
    public function getHighlights()
    {
        if (!$this->highlighter) {
            return array();
        }

        return $this->highlighter->parseResults($this->result->getHighlights());
    }

    /**
     * {@inheritdoc}
     */
    public function getBean($retrieve = false)
    {
        // TODO: move this logic into central bean handling for Elasticsearch

        if ($retrieve) {
            $bean = \BeanFactory::getBean($this->getModule(), $this->getId());
        } else {
            $bean = \BeanFactory::getBean($this->getModule());
            $bean->populateFromRow($this->getData(), true);
            $bean->id = $this->getId();
        }

        // Dispatch event for logic hook framework
        $this->dispatchEvent($bean, 'after_retrieve_elastic', array('data' => $this->getData()));

        return $bean;
    }

    /**
     * Dispatch logic hook event on given SugarBean
     * @param \SugarBean $bean
     * @param string $event Logic hook event
     * @param array $args Optional arguments
     */
    protected function dispatchEvent(\SugarBean $bean, $event, array $args = array())
    {
        $bean->call_custom_logic($event, $args);
    }
}
