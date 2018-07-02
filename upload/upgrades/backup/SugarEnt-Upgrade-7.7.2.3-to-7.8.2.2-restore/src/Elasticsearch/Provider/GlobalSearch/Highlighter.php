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

namespace Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch;

use Sugarcrm\Sugarcrm\Elasticsearch\Query\Highlighter\AbstractHighlighter;
use Sugarcrm\Sugarcrm\Elasticsearch\Query\QueryBuilder;

/**
 *
 * GlobalSearch Highlighter
 *
 */
class Highlighter extends AbstractHighlighter
{
    /**
     * Ctor
     */
    public function __construct()
    {
        // always require a field match by default
        $this->setRequiredFieldMatch(true);

        // default fragments
        $this->setNumberOfFrags(3);
        $this->setFragSize(255);

        // use _source and plain highlighter
        $this->setDefaultFieldArgs(array(
            'type' => 'plain',
            'force_source' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function normalizeFieldName($field)
    {
        // Strip of the module name and keep the main field only. If no match
        // is found we continue with the field value as is.
        if (preg_match('/^.*' . QueryBuilder::PREFIX_SEP . '([^.]*).*$/', $field, $matches)) {
            $field = $matches[1];
        }
        return parent::normalizeFieldName($field);
    }

    /**
     * {@inheritdoc}
     */
    protected function wrapValueWithTags($value)
    {
        // Sometimes the Elastic search response does not include highlight tags in value.
        // To amend this issue, this function adds the tags to the front and the back of the value,
        // so that the whole field will be highlighted, instead of only the matching part.

        if (isset($this->preTags[0]) && isset($this->postTags[0])) {
            $newValue = array();
            // 1. remove the tags in the value if Elastic search's response contains them
            // 2. add the tags in the front and the back to highlight the whole value
            foreach ($value as $v) {
                $newValue[] = $this->preTags[0] . strip_tags($v) . $this->postTags[0];
            }
            $value = $newValue;
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubFieldName($field)
    {
        // Example field name with sub-field:
        // input: Accounts__email_search.secondary.gs_email_wildcard
        // output: secondary

        // Example field name without sub-field:
        // input: Contacts__first_name.gs_string_wildcard
        // output: empty string

        $subField = '';
        $sep = '\\' . QueryBuilder::FIELD_SEP;
        if (preg_match('/^.*' . $sep . '(.*)' . $sep . '.*$/', $field, $matches)) {
            $subField = $matches[1];
        }
        return $subField;
    }
}
