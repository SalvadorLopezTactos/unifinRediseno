<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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
 * Check that the Sugar FTS Engine configuration is valid
 */
class SugarUpgradeCheckFTSConfig extends UpgradeScript
{
    public $order = 200;
    public $version = '7.1.5';

    public function run()
    {
        global $sugar_config;

        $ftsConfig = isset($sugar_config['full_text_engine']) ? $sugar_config['full_text_engine'] : null;
        // Check that Elastic info is set (only currently supported search engine)
        if (empty($ftsConfig) || empty($ftsConfig['Elastic']) ||
            empty($ftsConfig['Elastic']['host']) || empty($ftsConfig['Elastic']['port'])
        ) {
            // error implies fail
            $this->error('Elastic Full Text Search engine needs to be configured on this Sugar instance prior to upgrade.');
            $this->error('Access Full Text Search configuration under Administration > Search.');
        } else {
            // Test Elastic FTS connection
            require_once('include/SugarSearchEngine/SugarSearchEngineFactory.php');
            $searchEngine = SugarSearchEngineFactory::getInstance('Elastic', $ftsConfig['Elastic']);
            $status = $this->getServerStatusElastic($searchEngine, $ftsConfig['Elastic']);

            if (!$status['valid']) {
                $this->error('Connection test for Elastic Full Text Search engine failed.  Check your FTS configuration.');
                $this->error('Access Full Text Search configuration under Administration > Search.');
            }
        }
    }

    /**
     * The older versions of getServerStatus may be broken, so we need to re-implement this to have it pass
     *
     * @return array
     */
    protected function getServerStatusElastic($searchEngine, $config)
    {
        $this->_client = $this->getElasticaClient($config);
        global $app_strings;
        $isValid = false;
        try {
            $results = $this->_client->request('', $this->getElasticaRequestConstant('GET'))->getData();
            if (!empty($results['status']) && $results['status'] === 200) {
                $isValid = true;
                $displayText = $app_strings['LBL_EMAIL_SUCCESS'];
            } else {
                $displayText = $app_strings['ERR_ELASTIC_TEST_FAILED'];
            }
        } catch (Exception $e) {
            $displayText = $e->getMessage();
            $this->error("Unable to get server status: $displayText");
        }

        return array('valid' => $isValid, 'status' => $displayText);
    }

    /**
     * Wrapper to instantiate Elastica Client object
     *
     * @param array $config
     * @return mixed \Elastica\Client|Elastica_Client
     */
    protected function getElasticaClient($config)
    {
        $class = $this->getElasticaFQClassName('Client');
        return new $class($config);
    }

    /**
     * Wrapper to get constant values from Elastica Request
     *
     * @param string $name
     * @return string
     */
    protected function getElasticaRequestConstant($name)
    {
        $class = $this->getElasticaFQClassName('Request');
        return constant($class.'::'.$name);
    }

    /**
     * Get fully qualified Elastica class name based on the available Elastica library
     *
     * @param string $class Base Elastica class name (i.e. Client, Request, ...)
     * @return string
     */
    protected function getElasticaFQClassName($class)
    {
        if (class_exists('Elastica_'.$class)) {
            $prefix =  'Elastica_';
        } else {
            $prefix = '\\Elastica\\';
        }
        return $prefix.$class;
    }
}
