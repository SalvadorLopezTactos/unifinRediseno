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

require_once("include/SugarSearchEngine/Elastic/SugarSearchEngineElasticIndexStrategyInterface.php");
require_once("include/SugarSearchEngine/Elastic/SugarSearchEngineElasticIndexStrategyBase.php");

/**
 * Elastic index strategy factory class
 */
class SugarSearchEngineElasticIndexStrategyFactory
{
    /**
     * @var array
     */
    protected static $instance;

    /**
     * getInstance()
     *
     * Create or fetch index strategy
     *
     * @static
     * @param string $name
     * @param array $config
     * @return ElasticIndexStrategyInterface
     */
    public static function getInstance($strategy = '', $config = null)
    {
        $sugarConfig = SugarConfig::getInstance();
        // get strategy name from $sugar_config, default to "single"
        if (empty($strategy)) {
            $strategy = $sugarConfig->get('full_text_engine.Elastic.index_strategy.name', 'single');
        }

        if (!empty(self::$instance[$strategy])) {
            return self::$instance[$strategy];
        }

        // use strategy config from $sugar_config if not set explicitly
        if (!is_array($config)) {
            $config = $sugarConfig->get('full_text_engine.Elastic.index_strategy.config', array());
        }

        // setup instance
        self::$instance[$strategy] = self::setupStrategy($strategy, $config);
        return self::$instance[$strategy];
    }

    /**
     * @static
     * @param string $name
     * @param array $config
     * @return mixed (bool|SugarSearchEngineInterface)
     */
    protected static function setupStrategy($name, $config = array())
    {
        $className = "SugarSearchEngineElasticIndexStrategy" . ucfirst($name);
        $filePath = "include/SugarSearchEngine/Elastic/{$className}.php";

        if (SugarAutoLoader::requireWithCustom($filePath, true)) {
            $className = SugarAutoLoader::customClass($className, true);
            $strategy = new $className();
            if ($strategy instanceof SugarSearchEngineElasticIndexStrategyInterface) {
                $strategy->setConfig($config);
                $GLOBALS['log']->info("Found Sugar Search Elastic Index Strategy: {$className}");
                return $strategy;
            }
        }
        $GLOBALS['log']->fatal("Failure loading SSE index strategy class: {$className}");
        return false;
    }
}
