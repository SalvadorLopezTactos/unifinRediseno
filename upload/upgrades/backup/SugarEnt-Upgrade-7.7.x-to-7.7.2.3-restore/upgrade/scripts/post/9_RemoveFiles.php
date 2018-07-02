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
 * Remove files that were scheduled to be deleted
 * Files are backed up to custom/backup
 */
class SugarUpgradeRemoveFiles extends UpgradeScript
{
    public $order = 9100;

    // ALL since some DB-only modules may request file deletions
    public $type = self::UPGRADE_ALL;

    public function run()
    {
        if(empty($this->state['files_to_delete'])) {
            return;
        }

        $caseInsensitiveFS = $this->upgrader->context['case_insensitive_fs'];
        foreach ($this->state['files_to_delete'] as $file) {
            $file = SugarAutoLoader::normalizeFilePath($file);
            // If we're using a case-insensitive file-system and the
            // file is not present as we specified it, don't remove it.
            if ($caseInsensitiveFS && !in_array($file, glob("$file*"))) {
                continue;
            }

            $this->backupFile($file);
            $this->log("Removing $file");

            if (is_dir($file)) {
                $this->removeDir($file);
            } else {
                $this->unlink($file);
            }
        }

        $this->cleanFileCache();
    }
}
