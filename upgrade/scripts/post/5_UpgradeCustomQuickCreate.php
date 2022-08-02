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
 * Adds default order for visible modules.
 */
class SugarUpgradeUpgradeCustomQuickCreate extends UpgradeScript
{
    public $order = 5000;
    public $type = self::UPGRADE_CUSTOM;
    public $version = '7.2';

    public function run()
    {
        // Only run when coming from a version lower than 7.2.
        if (version_compare($this->from_version, '7.2', '>=')) {
            return;
        }

        global $moduleList;
        $enabledModules = array();

        foreach ($moduleList as $module) {

            $quickCreateFile = "modules/$module/clients/base/menus/quick-create/quick-create.php";
            $customQuickCreateFile = "custom/$quickCreateFile";

            if (!file_exists($quickCreateFile) || !file_exists($customQuickCreateFile)) {
                continue;
            }
            require $customQuickCreateFile;
            $customMeta = $viewdefs[$module]['base']['menu']['quick-create'];

            if (!$customMeta['visible'] || isset($customMeta['order'])) {
                continue;
            }
            require $quickCreateFile;
            $defaultMeta = $viewdefs[$module]['base']['menu']['quick-create'];

            // -1 is default value for non-ordered modules.
            // See ViewConfigureshortcutbar::getQuickCreateModules();
            $customMeta['order'] = isset($defaultMeta['order']) ? $defaultMeta['order'] : -1;
            write_array_to_file(
                "viewdefs['$module']['base']['menu']['quick-create']",
                $customMeta,
                $customQuickCreateFile
            );
        }

    }
}
