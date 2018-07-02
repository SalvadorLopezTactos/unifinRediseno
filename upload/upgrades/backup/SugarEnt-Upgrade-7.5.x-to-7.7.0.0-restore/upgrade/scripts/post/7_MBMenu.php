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
 * If MB module does not have menu, create one
 */
class SugarUpgradeMBMenu extends UpgradeScript
{
    public $order = 7200;

    /**
     * Add default menu for module
     * @param string $module
     */
    protected function addMenu($moduleName)
    {
        $menu = array();
        // Create default menu for the module
        $menu[] = array(
                'route' => "#$moduleName/create",
                'label' => 'LNK_NEW_RECORD',
                'acl_action' => 'create',
                'acl_module' => $moduleName,
                'icon' => 'icon-plus',
        );

        // Handle link to vCard
        if (is_subclass_of(BeanFactory::getBean($moduleName), 'Person')) {
            $vCardRoute = (in_array($moduleName, $GLOBALS['bwcModules']))
                ? '#bwc/index.php?' . http_build_query(array('module' => $moduleName, 'action' => 'ImportVCard'))
                : "#$moduleName/vcard-import";
            $menu[] = array(
                'route' => $vCardRoute,
                'label' => 'LNK_IMPORT_VCARD',
                'acl_action' => 'create',
                'acl_module' => $moduleName,
                'icon' => 'icon-plus',
            );
        }

        $menu[] = array(
                'route' => "#$moduleName",
                'label' => 'LNK_LIST',
                'acl_action' => 'list',
                'acl_module' => $moduleName,
                'icon' => 'icon-reorder',
        );
        $menu[] = array(
                'route' => '#bwc/index.php?' . http_build_query(
                        array(
                                'module' => 'Import',
                                'action' => 'Step1',
                                'import_module' => $moduleName,
                        )
                ),
                'label' => 'LNK_IMPORT_'.strtoupper($moduleName),
                'acl_action' => 'import',
                'acl_module' => $moduleName,
                'icon' => 'icon-upload',
        );
        $content = <<<END
<?php
/* Created by SugarUpgrader for module $moduleName */
\$viewdefs['$moduleName']['base']['menu']['header'] =
END;
        $content .= var_export($menu, true) . ";\n";
        $this->ensureDir("modules/$moduleName/clients/base/menus/header");
        $this->putFile("modules/$moduleName/clients/base/menus/header/header.php", $content);
        $this->log("Added default menu file for $moduleName");
    }

    public function run()
    {
        global $mod_strings;

        if (!empty($this->upgrader->state['MBModules'])) {
            foreach ($this->upgrader->state['MBModules'] as $moduleName) {
                if (!file_exists("modules/$moduleName")) {
                    continue;
                }
                if (!file_exists("modules/$moduleName/clients/base/menus/header/header.php")
                    && !file_exists("custom/modules/$moduleName/clients/base/menus/header/header.php")
                ) {
                    $this->addMenu($moduleName);
                }
            }
        }

        // Do it also for bwcModules since some of them may not have Menu.php and we need it
        // Also some non-MB modules marked as BWC in post scripts and should have valid menu as well.
        foreach ($GLOBALS['bwcModules'] as $moduleName) {
            if (!file_exists("modules/$moduleName")) {
                continue;
            }
            if (!file_exists("modules/$moduleName/clients/base/menus/header/header.php")
                && !file_exists("custom/modules/$moduleName/clients/base/menus/header/header.php")
            ) {
                //Check if this module explcitly doesn't have a menu. In that case don't add one now.
                if (file_exists("modules/$moduleName/Menu.php")) {
                    //Need to make sure the mod_strings match the requested module or Menus may fail
                    $curr_mod_strings = $mod_strings;
                    $mod_strings = return_module_language("en_us", $moduleName);
                    $module_menu = array();
                    include "modules/$moduleName/Menu.php";
                    $mod_strings = $curr_mod_strings;
                    if (empty($module_menu)) {
                        continue;
                    }
                }
                $this->addMenu($moduleName);
            }
        }
    }
}
