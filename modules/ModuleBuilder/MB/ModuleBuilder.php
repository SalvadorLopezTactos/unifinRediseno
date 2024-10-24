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

/*********************************************************************************
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

use Sugarcrm\Sugarcrm\Util\Files\FileLoader;

require_once 'modules/ModuleBuilder/parsers/constants.php';

class ModuleBuilder
{
    public $packages = [];

    public function getPackageList()
    {
        static $list = [];
        if (!empty($list) || !file_exists(MB_PACKAGE_PATH)) {
            return $list;
        }

        // Get directories within the module builder package path
        $dirs = glob(MB_PACKAGE_PATH . '/*', GLOB_ONLYDIR);

        // And check to see if there is a manifest.php in it
        foreach ($dirs as $dir) {
            $path = "$dir/manifest.php";
            if (file_exists($path)) {
                $list[] = basename($dir);
            }
        }

        // Order is important as generate_nodes_array in Tree.php later loops
        // over this by foreach to generate the package list
        sort($list);
        return $list;
    }

    /**
     * @param $name
     * @return MBPackage
     */
    public function getPackage($name)
    {
        if (empty($this->packages [$name])) {
            $this->packages [$name] = new MBPackage($name);
        }

        return $this->packages [$name];
    }

    public function getPackageKey($name)
    {
        $manifestPath = MB_PACKAGE_PATH . '/' . $name . '/manifest.php';
        if (file_exists($manifestPath)) {
            require FileLoader::validateFilePath($manifestPath);
            if (!empty($manifest)) {
                return $manifest['key'];
            }
        }
        return false;
    }

    public function &getPackageModule($package, $module)
    {
        $this->getPackage($package);
        $this->packages [$package]->getModule($module);
        return $this->packages [$package]->modules [$module];
    }

    public function save()
    {
        $packages = array_keys($this->packages);
        foreach ($packages as $package) {
            $this->packages [$package]->save();
        }
    }

    public function build()
    {
        $packages = array_keys($this->packages);
        foreach ($packages as $package) {
            if (safeCount($packages) == 1) {
                $this->packages [$package]->build(true);
            } else {
                $this->packages [$package]->build(false);
            }
        }
    }

    public function getPackages()
    {
        if (empty($this->packages)) {
            $list = $this->getPackageList();
            foreach ($list as $package) {
                if (!empty($this->packages [$package])) {
                    continue;
                }
                $this->packages [$package] = new MBPackage($package);
            }
        }
    }

    public function getNodes()
    {
        $this->getPackages();
        $nodes = [];
        foreach (array_keys($this->packages) as $name) {
            $nodes [] = $this->packages [$name]->getNodes();
        }
        return $nodes;
    }

    /**
     * Function return module name and this aliases
     *
     * @param string $module
     * @return array $aliases
     */
    public static function getModuleAliases($module)
    {
        $aliases = [$module];
        $relate_arr = [
            'Users' => 'Employees',
            'Employees' => 'Users',
        ];

        if (isset($relate_arr[$module])) {
            $aliases[] = $relate_arr[$module];
        }

        return $aliases;
    }
}
