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

/**
 *
 * Facet Factory
 *
 */
class FacetFactory
{
    /**
     *
     * Local cache
     * @var array
     */
    protected static $loaded = array();

    /**
     *
     * Facet object loader
     * @param string $type
     * @return FacetAbstract
     */
    public static function get($type)
    {
        if (isset(self::$loaded[$type])) {
            return self::$loaded[$type];
        }

        self::$loaded[$type] = false;
        $className = "Facet".ucfirst($type);
        $classFile = "include/SugarSearchEngine/Elastic/Facets/{$className}.php";
        if (SugarAutoLoader::requireWithCustom($classFile)) {
            self::$loaded[$type] = new $className();
        }
        return self::$loaded[$type];
    }
}
