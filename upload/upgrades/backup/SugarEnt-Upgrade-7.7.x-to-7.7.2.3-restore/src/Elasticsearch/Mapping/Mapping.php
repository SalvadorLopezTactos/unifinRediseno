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

namespace Sugarcrm\Sugarcrm\Elasticsearch\Mapping;

use Sugarcrm\Sugarcrm\Elasticsearch\Provider\ProviderCollection;
use Sugarcrm\Sugarcrm\Elasticsearch\Exception\MappingException;
use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\Property\MultiFieldProperty;
use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\Property\MultiFieldBaseProperty;
use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\Property\RawProperty;
use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\Property\PropertyInterface;
use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\Property\ObjectProperty;

/**
 *
 * This class builds the mapping per module (type) based on the available
 * providers.
 *
 */
class Mapping
{
    /**
     * @var string Module name
     */
    protected $module;

    /**
     * @var \SugarBean
     */
    protected $bean;

    /**
     * @var array Elasticsearch mapping properties
     */
    protected $properties = array();

    /**
     * Base mapping used for all multi fields
     * @var array
     */
    protected $multiFieldBase = array(
        'type' => 'string',
        'index' => 'not_analyzed',
        'include_in_all' => false,
    );

    /**
     * Excluded fields from _source
     * @var array
     */
    protected $sourceExcludes = array();

    /**
     * @param string $module
     */
    public function __construct($module)
    {
        $this->module = $module;
    }

    /**
     * Add field to be excluded from _source
     * @param string $fieldDef
     */
    public function excludeFromSource($fieldDef)
    {
        $this->sourceExcludes[] = $fieldDef;
    }

    /**
     * Get excluded fields from _source
     * @return multitype:
     */
    public function getSourceExcludes()
    {
        return $this->sourceExcludes;
    }

    /**
     * Build mapping
     * @param ProviderCollection $providers
     */
    public function buildMapping(ProviderCollection $providers)
    {
        foreach ($providers as $provider) {
            $provider->buildMapping($this);
        }
    }

    /**
     * Get module
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Get seed bean
     * @return \SugarBean
     */
    public function getBean()
    {
        // lazy load bean
        if ($this->bean === null) {
            $this->bean = \BeanFactory::getBean($this->module);
        }
        return $this->bean;
    }

    /**
     * Compile mapping properties
     *
     * @return array
     */
    public function compile()
    {
        $compiled = array();
        foreach ($this->properties as $field => $property) {
            $compiled[$field] = $property->getMapping();
        }
        return $compiled;
    }

    /**
     * Add a not_analyzed string field to the mapping. As every multi field
     * has a not_analyzed base definition we can just add this as is. Other
     * providers can still register additional multi fields on top of this
     * not analyzed field.
     *
     * @param string $field Field name
     * @param array $copyTo Optional copy_to definition
     */
    public function addNotAnalyzedField($field, array $copyTo = array())
    {
        $this->createMultiFieldBase($field, $copyTo);
    }

    /**
     * Add multi field mapping. This should be the primary method to be used
     * to build the mapping as most fields are string based. Multi fields
     * have the ability to define different analyzers for every sub field.
     * During indexing the value for each multi field only has to be send once
     * instead of being duplicated.
     *
     * @param string $baseField Base field name
     * @param string $field Name of the multi field
     * @param MultiFieldProperty $property
     * @param array $copyTo Optional copy_to definition
     */
    public function addMultiField($baseField, $field, MultiFieldProperty $property, array $copyTo = array())
    {
        $this->createMultiFieldBase($baseField, $copyTo)->addField($field, $property);
    }

    /**
     * Add object (or nested) property mapping.
     *
     * @param string $field
     * @param ObjectProperty $property
     */
    public function addObjectProperty($field, ObjectProperty $property)
    {
        $this->addProperty($field, $property);
    }

    /**
     * Add raw property mapping. It is encouraged to use higher level property
     * objects instead and the respective methods on this class to configure
     * them instead of using a raw property. Use this method with caution.
     *
     * @param string $field
     * @param RawProperty $property
     */
    public function addRawProperty($field, RawProperty $property)
    {
        $this->addProperty($field, $property);
    }

    /**
     * Create base multi field object for given field.
     *
     * @param string $field
     * @param array $copyTo Optional copy_to definition
     * @return MultiFieldBaseProperty
     * @throws MappingException
     */
    protected function createMultiFieldBase($field, array $copyTo = array())
    {
        // create multi field base if not set yet
        if (!isset($this->properties[$field])) {
            $property = new MultiFieldBaseProperty();
            $property->setMapping($this->multiFieldBase);
            $this->addProperty($field, $property);
        }

        // make sure we have a base multi field
        $property = $this->properties[$field];
        if (!$property instanceof MultiFieldBaseProperty) {
            throw new MappingException("Field '{$field}' is not a multi field");
        }

        // append copy_to definitions
        foreach ($copyTo as $copyToField) {
            $property->addCopyTo($copyToField);
        }

        return $property;
    }

    /**
     * Low level wrapper to add mapping properties
     *
     * @param string $field
     * @param PropertyInterface $property
     * @throws MappingException
     */
    protected function addProperty($field, PropertyInterface $property)
    {
        if (isset($this->properties[$field])) {
            throw new MappingException("Cannot redeclare field '{$field}' for module '{$this->module}'");
        }
        $this->properties[$field] = $property;
    }
}
