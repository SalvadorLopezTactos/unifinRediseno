<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

use Elastica\Request;
use Sugarcrm\Sugarcrm\SearchEngine\SearchEngine;
use Sugarcrm\Sugarcrm\SearchEngine\Engine\Elastic;

/**
 * Upgrade script to schedule a full FTS index.
 */
class SugarUpgradeRunFTSIndexFor920 extends UpgradeScript
{
    public $order = 9610;
    public $type = self::UPGRADE_CUSTOM;

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        if (version_compare($this->from_version, '9.2.0', '>=')) {
            return;
        }

        $esVersion = $this->getEsVersion();

        try {
            // Since the full reindex may take a long time, only schedule the indexing for upgrade.
            // Note: After the upgrade, the cron job needs to be run before the global search
            // can be used. It includes indexing the data from database to Elastic search server.

            // For ES 6.0 or above, every module has its own index
            // so we can wipe out the index and re-index that module.
            // For ES versions before 6.0, all modules are in one single index
            // we can't just wipe out the index and re-index one module
            // otherwise we will lose all other modules
            // we have to re0index everything
            $modules = version_compare($esVersion, '6.0', '>=') ? ['KBContents'] : [];
            SearchEngine::getInstance()->scheduleIndexing($modules, true);
        } catch (Exception $e) {
            $this->log('SugarUpgradeRunFTSIndexFor920: scheduling FTS reindex got exceptions!');
        }
    }

    /**
     * @return string elasticsearch version
     */
    protected function getEsVersion() : string
    {
        $esVersion = null;
        $engine = SearchEngine::getInstance()->getEngine();
        if ($engine instanceof Elastic) {
            try {
                $result = $engine->getContainer()->client->request('', Request::GET);
                if ($result->isOk()) {
                    $data = $result->getData();
                    $esVersion = $data['version']['number'] ?? '0';
                }
            } catch (Exception $e) {
                $this->log('getEsVersion: get ES version got exceptions: ' . $e->getMessage());
            }
        }
        return $esVersion;
    }
}
