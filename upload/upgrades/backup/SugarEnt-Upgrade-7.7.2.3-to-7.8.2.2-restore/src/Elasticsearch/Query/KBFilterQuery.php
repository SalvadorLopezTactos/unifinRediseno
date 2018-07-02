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

namespace Sugarcrm\Sugarcrm\Elasticsearch\Query;

/**
 *
 * The Knowledge Base specific filter query using More_Like_This this query.
 *
 * !!! This is a temporary solution!!!
 * This class contains custom logic about knowledge base and needs
 * more proper refactoring/cleanup further.
 */
class KBFilterQuery implements QueryInterface
{
    /**
     * the related bean
     * @var object
     */
    protected $bean;

    /**
     * the searchable fields
     * @var array
     */

    protected $fields;

    /**
     * the search term
     * @var array
     */
    protected $term;

    /**
     * Set the related bean.
     * @param object $bean the related bean.
     */
    public function setBean($bean)
    {
        $this->bean = $bean;
    }

    /**
     * Set the searchable fields.
     * @param array $fields the searchable fields
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * @param array $term
     */
    public function setTerm($term)
    {
        $this->term = $term;
    }

    /**
     * Create a multi-match query.
     * @return \Elastica\Query\Bool
     */
    public function build()
    {
        $boolQuery = new \Elastica\Query\Bool();
        if (isset($this->fields['kbdocument_body'])) {
            if (isset($this->term['$contains'])) {
                $mltBody =
                    $this->createQuery($this->fields['kbdocument_body'], implode(' ', $this->term['$contains']));
                $boolQuery->addShould($mltBody);
            }
            if (isset($this->term['$not_contains'])) {
                $mltBody =
                    $this->createQuery($this->fields['kbdocument_body'], implode(' ', $this->term['$not_contains']));
                $boolQuery->addMustNot($mltBody);
            }
        }
        return $boolQuery;
    }

    /**
     * Create the filter.
     * @param bool $addLangFilter a flag indicate if a lang filter is needed
     * @param bool $addIdFilter a flag indicate if a id filter is needed
     * @return \Elastica\Filter\Bool
     */
    public function createFilter()
    {
        $mainFilter = new \Elastica\Filter\Bool();

        $activeRevFilter = new \Elastica\Filter\Term();
        $activeRevFilter->setTerm('active_rev', 1);
        $mainFilter->addMust($activeRevFilter);

        return $mainFilter;
    }

    /**
     * Create a more_like_this query.
     * @param $fields array the searchable fields
     * @param $text string the like text
     * @return \Elastica\Query\MoreLikeThis
     */
    protected function createQuery(array $fields, $text)
    {
        $mlt = new \Elastica\Query\MoreLikeThis();
        $mlt->setFields($fields);
        $mlt->setLikeText($text);
        $mlt->setMinTermFrequency(1);
        $mlt->setMinDocFrequency(1);
        return $mlt;
    }

}
