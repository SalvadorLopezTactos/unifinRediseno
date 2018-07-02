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

require_once('include/SugarSearchEngine/SugarSearchEngineAbstractBase.php');

/**
 * Module mapping for Elastica
 */
class SugarSearchEngineElasticMapping
{
    /**
     * @var \SugarSearchEngineElastic
     */
    private $sse;

    public function __construct(SugarSearchEngineElastic $sse)
    {
        $this->sse = $sse;
    }

    /**
     * Map of Sugar types to FTS (Elastic) type structures.
     * The value side can be either an array with the Elastic Type specification
     * or a string with the sugar base mapping type. I.e. reference to other
     * element in the array which does contain the Elastic Type specification
     * @var array
     */
    protected $type_map = array(
        'id'        => array(
                            'type' => 'string',
                            'index' => 'not_analyzed',
                       ),
        'enum'      => 'id',
        'email'     => array(
                            'type' => 'string',
                            'analyzer' => 'core_email_lowercase',
                        ),
        'url'       => 'id',
        'date'      => array(
                            'type' => 'date',
                        ),
        'datetime'  => 'date',
        'datetimecombo' => 'date',
        'name'      => array(
                            'type' => 'string',
                            'analyzer' => 'standard',
                        ),
        'fullname'  => 'name',
        'phone'     => 'name',
        'varchar'   => 'name',
        'text'      => 'name',
        'double'    => array(
                            'type' => 'multi_field',
                            'fields' => array(
                                'default' => array(
                                    'type' => 'string',
                                    'index' => 'not_analyzed',
                                ),
                                'number' => array(
                                    'type' => 'double',
                                ),
                            ),
                        ),
        'currency'  => 'double',
        'float'     => 'double',
        'decimal'   => 'double',
        'int'       => array(
                            'type' => 'multi_field',
                            'fields' => array(
                                'default' => array(
                                    'type' => 'string',
                                    'index' => 'not_analyzed',
                                ),
                                'number' => array(
                                    'type' => 'integer',
                                ),
                            ),
                        ),
        'boolean'   => array(
                            'type' => 'boolean',
                        ),
        'bool'      => 'boolean',
        'relate'    => array(
                            'type' => 'multi_field',
                            'fields' => array(
                                'default' => array(
                                    'analyzer' => 'standard',
                                    'type' => 'string',
                                    ),
                                'raw' => array(
                                    'type' => 'string',
                                    'index' => 'not_analyzed',
                                    'include_in_all' => false,
                                    ),
                            ),
                        ),
    );

    /**
     * Gets the FTS type array for a given Sugar type
     * @param string $sgrType   Sugar type
     * @return bool | array     array if a FTS type mapping is found and false if it isn't
     */
    protected function getFtsType($sgrType)
    {
        if(!isset($this->type_map[$sgrType])) return false;

        if(is_string($this->type_map[$sgrType])) {
            // Map is referencing a base type so switching to base type
            // Note not making a recursive call to avoid having to check for endless loops
            $sgrType = $this->type_map[$sgrType];
        }
        if(isset($this->type_map[$sgrType])) {
            return $this->type_map[$sgrType];
        }
        return false;
    }

    /**
     * Gets the FTS type array for a given fieldDef
     * Note that the fieldDefs regular Sugar type is used unless the full_text_search
     * property contains a type override
     * @param $fieldDef
     * @return array|bool array if a FTS type mapping is found and false if it isn't
     */
    public function getFtsTypeFromDef($fieldDef)
    {
        if(isset($fieldDef['full_text_search']['type'])) {
            $sgrType = $fieldDef['full_text_search']['type'];
        } else {
            $sgrType = $fieldDef['type'];
        }
        $type = $this->getFtsType($sgrType);

        if($type['type'] == 'multi_field' && isset($type['fields']['default']))
        {
            // Elastic uses by default the analyzer with the same name as the field for multi-fields
            $type['fields'][$fieldDef['name']] = $type['fields']['default'];
            unset($type['fields']['default']);
        }
        return $type;
    }

    /**
     *
     * This function creates the mapping on particular type/module and field.
     * Ths can be used when user changes the field settings (like boost level) in Studio.
     * index must exist before calling this function.
     *
     * @param $module module name
     * @param $fieldDefs field name of the module
     *
     * @return boolean true if mapping successfully created, false otherwise
     */
    private function setFieldMapping($module, $fieldDefs)
    {
        $properties = $this->constructIndexMappingProperties($fieldDefs);

        // add module field which is automatically added in the indexed documents
        $properties['module'] = array(
            'index' => 'not_analyzed',
            'type' => 'string',
        );

        if (is_array($properties) && count($properties) > 0)
        {
            $indexList = $this->sse->getAllIndexes($module);
            foreach ($indexList as $indexName) {
                $index = new \Elastica\Index($this->sse->getClient(), $indexName);
                $GLOBALS['log']->debug("elastic field mapping module=$module, index=$indexName");
                $type = new \Elastica\Type($index, $module);
                $mapping = new \Elastica\Type\Mapping($type, $properties);
                $mapping->setProperties($properties);
                try {
                    $mapping->send();
                } catch (\Elastica\Exception\ResponseException $e) {
                    $GLOBALS['log']->fatal("Elastic exception when creating mapping, message= " . $e->getMessage());
                    return false;
                }
            }
        }

        return true;
    }

    /**
     *
     * This function returns an array of properties given a field definition array.
     *
     * @param $fieldDefs array of field definitions
     *
     * @return an array of properties
     */
    protected function constructIndexMappingProperties($fieldDefs) {
        $properties = array();

        foreach ($fieldDefs as $name => $fieldDef)
        {
            if (empty($fieldDef['name'])) continue;
            $fieldName = $fieldDef['name'];

            if (isset($fieldDef['full_text_search']) && !empty($fieldDef['full_text_search']['enabled']))
            {
                $tmpArray = $this->getFtsTypeFromDef($fieldDef);
                if(empty($tmpArray)) $tmpArray = array(); // Unknown type, we'll see if we can find a mapping in the vardefs
                foreach ($fieldDef['full_text_search'] as $sugarName => $val)
                {
                    if(in_array($sugarName, array(
                        'enabled',      // No need to deal with enable property
                        'boost',        // Because of severe limitations boost levels are not set on the index but used when querying
                    ))) continue;
                    if ($sugarName == 'elastic')
                    {
                        foreach($val as $name => $value)
                        {
                            $tmpArray[$name] = $value; // Override or add any specified mapping
                        }
                    }
                    // We currently only support ElasticSearch specific overrides
                    // When we implement a second search engine this section may be extended.
                }
                // field type is required when setting mapping
                if (!empty($tmpArray['type']))
                {
                    $properties[$fieldName] = $tmpArray;
                }
            }
        }

        return $properties;
    }

    /**
     *
     * This function creates a full mapping for all modules.
     * index must exist before calling this function.
     *
     */
    public function setFullMapping()
    {
        $allModules = SugarSearchEngineMetadataHelper::retrieveFtsEnabledFieldsForAllModules();

        // if the index already exists, is there a way to create mapping for multiple modules at once?
        // for now, create one mapping for a module at a time
        foreach ($allModules as $name => $module)
        {
            $this->setFieldMapping($name, $module);
        }
    }

}
