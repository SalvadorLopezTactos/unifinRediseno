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

namespace Sugarcrm\Sugarcrm\Elasticsearch\Query\Highlighter;

use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\Mapping;

/**
 *
 * Abstract Highlighter
 *
 */
abstract class AbstractHighlighter implements HighlighterInterface
{
    /**
     * Global highlighter properties not explicitly
     * available on this object.
     * @var array
     */
    protected $globalProps = array();

    /**
     * @var array List of fields and its highlighter settings
     */
    protected $fields = array();

    /**
     * @var array Field arguments applied to every field
     */
    protected $defaultFieldArgs = array();

    /**
     * @var array List of pre tags
     */
    protected $preTags = array('<strong>');

    /**
     * @var array List of post tags
     */
    protected $postTags = array('</strong>');

    /**
     * @var integer Number of fragments
     */
    protected $numberOfFrags = 5;

    /**
     * @var integer Fragment size
     */
    protected $fragSize = 100;

    /**
     * @var boolean Require field match
     */
    protected $requireFieldMatch = true;

    /**
     * @var string Field encoder, accepts html or default
     */
    protected $encoder = 'html';

    /**
     * @var string Order highlights, defaults to score
     */
    protected $order = 'score';

    /**
     * @var array Remapped fields
     */
    protected $fieldRemap = array();

    /**
     * @var array fields to wrap the value with tags or not
     */
    protected $wrapValueWithTags = array();

    /**
     * Set fields
     * @param array $fields
     * @return AbstractHighlighter
     */
    public function setFields(array $fields)
    {
        $this->fields = array_merge($this->fields, $fields);
        return $this;
    }

    /**
     * Set field arguments which are applied on every field
     * @param array $args
     * @return AbstractHighlighter
     */
    public function setDefaultFieldArgs(array $args)
    {
        $this->defaultFieldArgs = $args;
        return $this;
    }

    /**
     * Set list of pre tags
     * @param array $tags
     * @return AbstractHighlighter
     */
    public function setPreTags(array $tags)
    {
        $this->preTags = $tags;
        return $this;
    }

    /**
     * Set list of post tags
     * @param array $tags
     * @return \Sugarcrm\Sugarcrm\Elasticsearch\Component\Highlighter
     */
    public function setPostTags(array $tags)
    {
        $this->postTags = $tags;
        return $this;
    }

    /**
     * Enable/disable required field match
     * @param boolean $toggle
     * @return AbstractHighlighter
     */
    public function setRequiredFieldMatch($toggle)
    {
        $this->requireFieldMatch = $toggle;
        return $this;
    }

    /**
     * Set global number of fragments
     * @param integer $value
     * @return AbstractHighlighter
     */
    public function setNumberOfFrags($value)
    {
        $this->numberOfFrags = (int) $value;
        return $this;
    }

     /**
      * Set global fragment size
      * @param integer $value
      * @return AbstractHighlighter
      */
    public function setFragSize($value)
    {
        $this->fragSize = (int) $value;
        return $this;
    }

    /**
     * Set field remapping
     * @param array $remap
     * @return AbstractHighlighter
     */
    public function setFieldRemap(array $remap)
    {
        $this->fieldRemap = array_merge($this->fieldRemap, $remap);
        return $this;
    }

    /**
     * Set to enable/disable wrapping the value with tags.
     * @param array $setting the value of the setting
     * @return AbstractHighlighter
     */
    public function setWrapValueWithTags(array $setting)
    {
        $this->wrapValueWithTags = array_merge($this->wrapValueWithTags, $setting);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        // generate global properties
        $properties = array(
            'pre_tags' => $this->preTags,
            'post_tags' => $this->postTags,
            'require_field_match' => $this->requireFieldMatch,
            'number_of_fragments' => $this->numberOfFrags,
            'fragment_size' => $this->fragSize,
            'encoder' => $this->encoder,
            'order' => $this->order,
        );
        $properties = array_merge($this->globalProps, $properties);

        // generate fields
        $fields = array();
        foreach ($this->fields as $field => $args) {
            $fields[$field] = array_merge($this->defaultFieldArgs, $args);
        }

        $properties['fields'] = $fields;

        return $properties;
    }

    /**
     * {@inheritdoc}
     */
    public function parseResults(array $highlights)
    {
        $parsed = array();
        foreach ($highlights as $field => $value) {

            // Normalize the field name
            $normField = $this->normalizeFieldName($field);

            // Wrap the highlight value with tags if needed
            if (isset($this->wrapValueWithTags[$normField])) {
                $value = $this->wrapValueWithTags($value);
            }

            // Get the sub-field if exists
            $subField = $this->getSubFieldName($field);
            if (!empty($subField)) {
                // Compose the sub-field's name and value as an array
                $value = array($subField => $value);
            }

            // Multiple highlights can be returned for the same field, if so we
            // add them and filter out any duplicates.

            // If the field has sub-fields, it will return an array in the following format:
            // "field" => array("sub-field1" => value1, "sub-field2" => value2)

            // Otherwise, it will return an array in the following format:
            // "field" => array (value1, value2)

            if (isset($parsed[$normField])) {
                $parsed[$normField] = $parsed[$normField] + $value;
            } else {
                $parsed[$normField] = $value;
            }
        }
        return $parsed;
    }

    /**
     * Normalize field name applying remap if any defined
     * @param string $field
     * @return string
     */
    public function normalizeFieldName($field)
    {
        return isset($this->fieldRemap[$field]) ? $this->fieldRemap[$field] : $field;
    }

    /**
     * Wrap the value with tags so that the whole value will be highlighted.
     *
     * @param $value array the array of the highlighted values
     * @return array the array of the new highlighted values
     */
    protected function wrapValueWithTags($value)
    {
        return $value;
    }

    /**
     * Get the secondary field if available.
     * @param string $field the name of the field
     * @return string
     */
    public function getSubFieldName($field)
    {
        return '';
    }
}
