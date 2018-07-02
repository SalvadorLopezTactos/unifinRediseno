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
 * Not able to save Account > Member Organization subpanel after upgrading
 *
 * @see PAT-2031 for related issue
 */
class SugarUpgradeFixLegacySubpanelsLayout extends UpgradeScript
{
    public $order = 7100;
    public $type = self::UPGRADE_CUSTOM;
    private $mdc;

    public function run()
    {
        $files = array_merge(
            glob('custom/modules/*/Ext/clients/base/layouts/subpanels/subpanels.ext.php'),
            glob('custom/Extension/modules/*/Ext/clients/base/layouts/subpanels/*.php')
        );

        $this->mdc = new MetaDataConverter();

        foreach ($files as $file) {
            $this->process($file);
        }
    }

    /**
     * Fix broken layout defs
     * @param string $file
     */
    public function process($file)
    {
        if (is_dir($file)) {
            return;
        }

        $torewrite = false;
        $viewdefs = array();
        require $file;

        if (!empty($viewdefs)) {
            $module = key($viewdefs);

            foreach ($viewdefs[$module]['base']['layout']['subpanels']['components'] as $i => $component) {
                if (key($component) != 'override_subpanel_list_view') {
                    continue;
                }

                $subpanelview = $viewdefs[$module]['base']['layout']['subpanels']['components'][$i]['override_subpanel_list_view']['view'];
                $subpanelviewfile = "custom/modules/{$module}/clients/base/views/{$subpanelview}/{$subpanelview}.php";
                if (!file_exists($subpanelviewfile)) {
                    $subpanelname = $this->mdc->fromLegacySubpanelName("For{$module}");
                    $subpanelnamefile = "custom/modules/{$module}/clients/base/views/{$subpanelname}/{$subpanelname}.php";
                    if (file_exists($subpanelnamefile)) {
                        $torewrite = true;
                        $viewdefs[$module]['base']['layout']['subpanels']['components'][$i]['override_subpanel_list_view']['view'] = $subpanelname;
                    }
                }
            }
        }

        if ($torewrite) {
            $strToFile = "<?php\n\n";

            foreach ($viewdefs[$module]['base']['layout']['subpanels']['components'][$i] as $key => $value) {
                $strToFile .= "\$viewdefs['{$module}']['base']['layout']['subpanels']['components'][] = " . var_export(
                    array($key => $value),
                    true
                ) . ";\n";
            }

            $this->upgrader->backupFile($file);
            sugar_file_put_contents_atomic($file, $strToFile);
        }
    }
}
