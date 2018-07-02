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

// For clearing the metadata API cache
require_once "include/MetaDataManager/MetaDataManager.php";

/**
 * Create relationship objects
 * @api
 */
class SugarRelationshipFactory {
    static $rfInstance;

    protected $relationships;

    protected function __construct(){
        //Load the relationship definitions from the cache.
        $this->loadRelationships();
    }

    /**
     * @static
     * @return SugarRelationshipFactory
     */
    public static function getInstance()
    {
        if (is_null(self::$rfInstance)) {
            self::$rfInstance = new SugarRelationshipFactory();
        }
        return self::$rfInstance;
    }

    public static function rebuildCache()
    {
        $rf = self::getInstance();
        $rf->buildRelationshipCache();
    }

    public static function deleteCache()
    {
        $file = self::getInstance()->getCacheFile();
        if(sugar_is_file($file)) {
            unlink($file);
        }
    }

    /**
     * Gets a relationship by name
     * 
     * @param  $relationshipName String name of relationship to load
     * @return SugarRelationship
     */
    public function getRelationship($relationshipName)
    {
        if (empty($this->relationships[$relationshipName])) {
            $GLOBALS['log']->error("Unable to find relationship $relationshipName");
            return false;
        }

        $def = $this->relationships[$relationshipName];

        $type = isset($def['true_relationship_type']) ? $def['true_relationship_type'] : $def['relationship_type'];
        switch($type) {
            case "many-to-many":
                if (isset($def['rhs_module']) && $def['rhs_module'] == 'EmailAddresses') {
                    return new EmailAddressRelationship($def);
                }
                
                return new M2MRelationship($def);
            break;
            case "user-based":
                return new UserBasedRelationship($def);
            break;
            case "one-to-many":
                //If a relationship has no table or join keys, it must be bean based
                if (empty($def['true_relationship_type']) || (empty($def['table']) && empty($def['join_table'])) || empty($def['join_key_rhs'])){
                    return new One2MBeanRelationship($def);
                } else {
                    return new One2MRelationship($def);
                }
                break;
            case "one-to-one":
                if (empty($def['true_relationship_type'])) {
                    return new One2OneBeanRelationship($def);
                } else {
                    return new One2OneRelationship($def);
                }
                break;
        }

        $GLOBALS['log']->fatal ("$relationshipName had an unknown type $type ");

        return false;
    }

    public function getRelationshipDef($relationshipName)
    {
        if (empty($this->relationships[$relationshipName])) {
            $GLOBALS['log']->error("Unable to find relationship $relationshipName");
            return false;
        }

        return $this->relationships[$relationshipName];
    }

    /**
     * This function returns an array of every relationship in the system from 
     * cache unless told to fetch fresh defs
     * 
     * @param boolean $fresh If true, will get data from the source instead of cache
     * @return array An array of relationships, indexed by the relationship name
     */
    public function getRelationshipDefs($fresh = false)
    {
        // The relationships are loaded in the constructor, so if there is a
        // request for fresh relationships, handle it
        if ($fresh) {
            $this->relationships = $this->getRelationshipData();
        }

        return $this->relationships;
    }

    protected function loadRelationships()
    {
        if(sugar_is_file($this->getCacheFile())) {
            include $this->getCacheFile();
            $this->relationships = $relationships;
        } else {
            $this->buildRelationshipCache();
        }
    }

    protected function buildRelationshipCache()
    {
        global $beanList, $buildingRelCache;
        if ($buildingRelCache) {
            return;
        }

        $buildingRelCache = true;
        $relationships = $this->getRelationshipData();

        //Save it out
        sugar_mkdir(dirname($this->getCacheFile()), null, true);
        $out = "<?php \n \$relationships = " . var_export($relationships, true) . ";";
        sugar_file_put_contents_atomic($this->getCacheFile(), $out);

        // There are only certain times when the relationship cache needs to be 
        // refreshed...
        // 
        // If we have a cache, but no internal relationships yet, do NOT rebuild
        // the api cache. This is a first load of this class.
        //
        // If there is no cache, then do NOT rebuild the api cache since there is
        // nothing to rebuild.
        //
        // DO rebuild the cache if there is a cache, there is an internal relationships
        // property and it is different than $relationships
        $rebuildApiCache = false;
        $mm = MetaDataManager::getManager();
        if (file_exists($mm->getMetadataCacheFileName())) {
            $rebuildApiCache = !empty($this->relationships) && array_diff_key($this->relationships, $relationships) !== array();
        }

        $this->relationships = $relationships;

        if ($rebuildApiCache) {
            MetaDataManager::refreshSectionCache(array(MetaDataManager::MM_RELATIONSHIPS));
        }

        //Now load all vardefs a second time populating the rel_calc_fields
        foreach ($beanList as $moduleName => $beanName) {
            // need to refresh the vardef so that the related calc fields are loaded
            VardefManager::loadVardef($moduleName, BeanFactory::getObjectName($moduleName), true);
        }

        $buildingRelCache = false;
    }

    /**
     * Gets the relationship metadata data that is ultimately cached
     * 
     * @return array
     */
    protected function getRelationshipData()
    {
        global $beanList, $dictionary;
        include("modules/TableDictionary.php");

        if (empty($beanList)) {
            include("include/modules.php");
        }

        //Reload ALL the module vardefs....
        foreach($beanList as $moduleName => $beanName)
        {
            VardefManager::loadVardef($moduleName, BeanFactory::getObjectName($moduleName), false, array(
                //If relationships are not yet loaded, we can't figure out the rel_calc_fields.
                "ignore_rel_calc_fields" => true,
            ));
        }

        $relationships = array();

        //Grab all the relationships from the dictionary.
        foreach ($dictionary as $key => $def) {
            if (!empty($def['relationships'])) {
                foreach($def['relationships'] as $relKey => $relDef) {
                    if ($key == $relKey) {
                        //Relationship only entry, we need to capture everything
                        $relationships[$key] = array_merge(array('name' => $key), $def, $relDef);
                    } else {
                        $relationships[$relKey] = array_merge(array('name' => $relKey), $relDef);
                        if(!empty($relationships[$relKey]['join_table']) && empty($relationships[$relKey]['fields'])
                            && isset($dictionary[$relationships[$relKey]['join_table']]['fields'])) {
                            $relationships[$relKey]['fields'] = $dictionary[$relationships[$relKey]['join_table']]['fields'];
                        }
                    }
                }
            }
        }
        
        return $relationships;
    }

    /**
     * Gets the cache file name
     * 
     * @return string
     */
    protected function getCacheFile() {
        return sugar_cached("Relationships/relationships.cache.php");
    }
}
