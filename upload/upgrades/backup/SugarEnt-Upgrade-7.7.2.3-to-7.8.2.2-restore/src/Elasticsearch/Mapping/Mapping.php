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
class Mapping implements MappingInterface
{
    /**
     * @var string Module name
     */
    private $module;

    /**
     * @var \SugarBean
     */
    private $bean;

    /**
     * Elasticsearch mapping properties
     * @var PropertyInterface[]
     */
    private $properties = array();

    /**
     * Base mapping used for all multi fields
     * @var array
     */
    private $multiFieldBase = array(
        'type' => 'string',
        'index' => 'not_analyzed',
        'include_in_all' => false,
    );

    /**
     * Base mapping for not indexed fields
     * @var array
     */
    private $notIndexedBase = array(
        'type' => 'string',
        'index' => 'no',
        'include_in_all' => false,
    );

    /**
     * Excluded fields from _source
     * @var array
     */
    private $sourceExcludes = array();

    /**
     * @param string $module
     */
    public function __construct($module)
    {
        $this->module = $module;
    }

    /**
     * {@inheritdoc}
     */
    public function excludeFromSource($field)
    {
        $this->sourceExcludes[$field] = $field;
    }

    /**
     * {@inheritdoc}
     */
    public function getSourceExcludes()
    {
        return array_values($this->sourceExcludes);
    }

    /**
     * {@inheritdoc}
     */
    public function buildMapping(ProviderCollection $providers)
    {
        foreach ($providers as $provider) {
            $provider->buildMapping($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function addNotIndexedField($field, array $copyTo = array())
    {
        $this->createMultiFieldBase($field, $this->notIndexedBase, $copyTo);
    }

    /**
     * {@inheritdoc}
     */
    public function addNotAnalyzedField($field, array $copyTo = array())
    {
        $this->createMultiFieldBase($field, $this->multiFieldBase, $copyTo);
    }

    /**
     * {@inheritdoc}
     */
    public function addMultiField($baseField, $field, MultiFieldProperty $property)
    {
        $this->createMultiFieldBase($baseField, $this->multiFieldBase, array())->addField($field, $property);
    }

    /**
     * {@inheritdoc}
     */
    public function addObjectProperty($field, ObjectProperty $property)
    {
        $this->addProperty($field, $property);
    }

    /**
     * {@inheritdoc}
     */
    public function addRawProperty($field, RawProperty $property)
    {
        $this->addProperty($field, $property);
    }

    /**
     * {@inheritdoc}
     */
    public function hasProperty($field)
    {
        return isset($this->properties[$field]);
    }

    /**
     * {@inheritdoc}
     */
    public function getProperty($field)
    {
        if ($this->hasProperty($field)) {
            return $this->properties[$field];
        }
        throw new MappingException("Trying to get non-existing property '{$field}' for '{$this->module}'");
    }

    /**
     * Create base multi field object for given field. If the field already
     * exists we use the one which is present and only apply the copyTo fields
     * on top of the already existing one.
     *
     * @param string $field
     * @param array $mapping Mapping to apply on base field
     * @param array $copyTo Optional copy_to definition
     * @throws MappingException
     * @return MultiFieldBaseProperty
     */
    private function createMultiFieldBase($field, array $mapping, array $copyTo = array())
    {
        // create multi field base if not set yet
        if (!$this->hasProperty($field)) {
            $property = new MultiFieldBaseProperty();
            $property->setMapping($mapping);
            $this->addRawProperty($field, $property);
        }

        // make sure we have a base multi field
        $property = $this->getProperty($field);
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
    private function addProperty($field, PropertyInterface $property)
    {
        if (isset($this->properties[$field])) {
            throw new MappingException("Cannot redeclare field '{$field}' for module '{$this->module}'");
        }
        $this->properties[$field] = $property;
    }
}
