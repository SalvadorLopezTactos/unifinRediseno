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
 * Update data for renamed modules
 */
class SugarUpgradeRenameModules extends UpgradeScript
{
    public $order = 7000;
    public $type = self::UPGRADE_CUSTOM;

    public function run()
    {
        require_once('modules/Studio/wizards/RenameModules.php');
        require_once('include/utils.php');

        $languageDefault = $GLOBALS['sugar_config']['default_language']; // if empty
        $klass = $this->getRenameModulesInstance();
        $languages = $this->getLanguages();
        $renamedList = array();

        $default = $this->getDefaultAppListStrings();
        foreach ($languages as $langKey => $langName) {
            $GLOBALS['sugar_config']['default_language'] = $langKey;
            //get list strings for this language
            $strings = $this->getAppListStrings($langKey);

            $GLOBALS['sugar_config']['default_language'] = $languageDefault;

            //get base list strings for this language
            $app_list_strings = $this->getCoreAppListStrings($langKey);
            if ($app_list_strings === false) {
                continue;
            }

            if(empty($app_list_strings['moduleList'])) {
                // broken language file
                $this->log("Bad language file for $langKey, skipping");
                continue;
            }
            //Keep only renamed modules
            $renamedModules = array_diff($strings['moduleList'], $app_list_strings['moduleList']);

            if (count($renamedModules) > 0) {
                $renamedList[$langKey] = array();
            }
            foreach ($renamedModules as $moduleId => $moduleName) {
                $shouldUpdate = (
                    isset($app_list_strings['moduleListSingular'][$moduleId])
                    && (
                        !empty($app_list_strings['moduleList'][$moduleId])
                        || !empty($app_list_strings['moduleListSingular'][$moduleId])
                    )
                );

                $shouldUpdateSingular = false;
                if (
                    empty($app_list_strings['moduleListSingular'][$moduleId])
                    && isset($strings['moduleListSingular'][$moduleId])
                    && isset($default['moduleListSingular'][$moduleId])
                    && $strings['moduleListSingular'][$moduleId] != $default['moduleListSingular'][$moduleId]
                ) {
                    $shouldUpdateSingular = true;
                } elseif (
                    !empty($app_list_strings['moduleListSingular'][$moduleId])
                    && isset($strings['moduleListSingular'][$moduleId])
                    && $strings['moduleListSingular'][$moduleId] != $app_list_strings['moduleListSingular'][$moduleId]
                ) {
                    $shouldUpdateSingular = true;
                }

                $shouldUpdatePlural = false;
                if (
                    empty($app_list_strings['moduleList'][$moduleId])
                    && $strings['moduleList'][$moduleId] != $default['moduleList'][$moduleId]
                ) {
                    $shouldUpdatePlural = true;
                } elseif (
                    !empty($app_list_strings['moduleList'][$moduleId])
                    && $strings['moduleList'][$moduleId] != $app_list_strings['moduleList'][$moduleId]
                ) {
                    $shouldUpdatePlural = true;
                }

                $shouldUpdate = $shouldUpdate && ($shouldUpdateSingular || $shouldUpdatePlural);

                if ($shouldUpdate) {
                    if(empty($app_list_strings['moduleList'][$moduleId])) {
                        $app_list_strings['moduleList'][$moduleId] = $app_list_strings['moduleListSingular'][$moduleId];
                    }
                    $klass->selectedLanguage = $langKey;
                    if(empty($strings['moduleListSingular'][$moduleId])) {
                        $strings['moduleListSingular'][$moduleId] = $app_list_strings['moduleListSingular'][$moduleId];
                    }
                    if(empty($strings['moduleList'][$moduleId])) {
                        $strings['moduleList'][$moduleId] = $app_list_strings['moduleList'][$moduleId];
                    }
                    $replacementLabels = array(
                        'singular' => $strings['moduleListSingular'][$moduleId],
                        'plural' => $strings['moduleList'][$moduleId],
                        'prev_singular' => $app_list_strings['moduleListSingular'][$moduleId],
                        'prev_plural' => $app_list_strings['moduleList'][$moduleId],
                        'key_plural' => $moduleId,
                        'key_singular' => $klass->getModuleSingularKey($moduleId)
                    );

                    $changed = $klass->changeModuleModStrings($moduleId, $replacementLabels);
                    if ($changed) {
                        $klass->setChangedModules(array($moduleId => $replacementLabels));
                        $klass->changeStringsInRelatedModules();
                    }

                    $renamedModules = $klass->getRenamedModules();
                    $renamedList[$langKey] = array_merge($renamedList[$langKey], $renamedModules);
                }
            }
        }

        return($renamedList);
    }

    /**
     * @return array
     */
    protected function getLanguages()
    {
        return get_languages();
    }

    /**
     * @return array
     */
    protected function getDefaultAppListStrings()
    {
        return $this->getAppListStrings('en_us');
    }

    /**
     * @param string $lang
     *
     * @return array
     */
    protected function getAppListStrings($lang)
    {
        return return_app_list_strings_language($lang, false);
    }

    /**
     * @param string $lang
     *
     * @return false|array
     */
    protected function getCoreAppListStrings($lang)
    {
        $app_list_strings = false;
        if (file_exists('include/language/' . $lang . '.lang.php')) {
            $app_list_strings = array();
            include('include/language/' . $lang . '.lang.php');
        }
        return $app_list_strings;
    }

    /**
     * @return \RenameModules
     */
    protected function getRenameModulesInstance()
    {
        return new RenameModules();
    }
}
