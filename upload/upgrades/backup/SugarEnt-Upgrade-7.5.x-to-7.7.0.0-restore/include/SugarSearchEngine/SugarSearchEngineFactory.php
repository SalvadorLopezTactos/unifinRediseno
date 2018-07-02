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

/**
 * Search Engines drivers factory class
 * @api
 */
class SugarSearchEngineFactory
{
    /**
     * @var SugarSearchEngineInterface
     */
    public static $_instance;

    /**
     * Singleton pattern
     */
    private function __construct(){}

    /**
     * getInstance()
     *
     * Connect to the backend engine and store for later use
     *
     * @static
     * @return SugarSearchEngineInterface
     */
    public static function getInstance($name = '', $config = array(), $useDefaultWhenFTSDown = false)
    {
        require_once('include/SugarSearchEngine/SugarSearchEngineAbstractBase.php');
        if ($useDefaultWhenFTSDown && SugarSearchEngineAbstractBase::isSearchEngineDown())
        {
            $name = 'SugarSearchEngine';
        }

       if (!isset(self::$_instance[$name]))
       {
           self::$_instance[$name] = self::setupEngine($name, $config);
       }

       return self::$_instance[$name];
    }

    public static function getFTSEngineNameFromConfig()
    {
        $name = "";
        if(isset($GLOBALS['sugar_config']['full_text_engine']) &&
           is_array($GLOBALS['sugar_config']['full_text_engine']))
        {
            $keys = array_keys($GLOBALS['sugar_config']['full_text_engine']);
            $name = array_pop($keys);
        }
        return $name;
    }
    /**
     * @static
     * @param string $name
     * @param array $config
     * @return mixed (bool|SugarSearchEngineInterface)
     */
    protected static function setupEngine($name = '', $config = array())
    {
        // if name is empty set name and config
        if(empty($name) && !empty($GLOBALS['sugar_config']['full_text_engine'])) {
            $name = self::getFTSEngineNameFromConfig();
            $config = $GLOBALS['sugar_config']['full_text_engine'][$name];
        }

        // if config is empty set config
        if(empty($config) && !empty($GLOBALS['sugar_config']['full_text_engine'][$name])) {
            $config = $GLOBALS['sugar_config']['full_text_engine'][$name];
        }

        $paths = array(
            "include/SugarSearchEngine/{$name}/SugarSearchEngine{$name}.php" => $name,
            // fallback to base engine if unknown engine name
            "include/SugarSearchEngine/SugarSearchEngine.php" => '',
        );

        // object loader using custom override
        foreach ($paths as $path => $baseClass) {
            if (SugarAutoLoader::requireWithCustom($path, true)) {
                $engineClass = SugarAutoLoader::customClass("SugarSearchEngine{$baseClass}");
                $engineInstance = new $engineClass($config);
                if ($engineInstance instanceof SugarSearchEngineInterface) {
                    $GLOBALS['log']->info("Found Sugar Search Engine: " . get_class($engineInstance));
                    return $engineInstance;
                }
            }
        }
        return false;
    }
}
