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

/**
 * SugarLogic action factory
 * @api
 */
class ActionFactory
{
    public static $exclude_files = ['ActionFactory.php', 'AbstractAction.php'];
    public static $action_directory = 'include/Expressions/Actions';
    public static $loaded_actions = [];

    public static function loadFunctionList()
    {
        $actions = null;
        $cachefile = sugar_cached('Expressions/actions_cache.php');
        if (!is_file($cachefile)) {
            ActionFactory::buildActionCache();
        } else {
            include $cachefile;
            ActionFactory::$loaded_actions = $actions;
        }
    }

    public static function buildActionCache($silent = true)
    {
        if (!is_dir(ActionFactory::$action_directory)) {
            return false;
        }

        // First get a list of all the files in this directory.
        $entries = [];
        $actions = [];
        $javascript = '';
        foreach (SugarAutoLoader::getFilesCustom(ActionFactory::$action_directory) as $path) {
            $entry = basename($path);
            if (strtolower(substr($entry, -4)) != '.php' || in_array($entry, ActionFactory::$exclude_files)) {
                continue;
            }
            require_once $path;

            $className = substr($entry, 0, strlen($entry) - 4);
            $actionName = call_user_func([$className, 'getActionName']);
            $actions[$actionName] = ['class' => $className, 'file' => $path];
            $javascript .= call_user_func([$className, 'getJavascriptClass']);
            if (!$silent) {
                echo "added action $actionName <br/>";
            }
        }

        if (empty($actions)) {
            return '';
        }

        create_cache_directory('Expressions/actions_cache.php');
        write_array_to_file('actions', $actions, sugar_cached('Expressions/actions_cache.php'));

        ActionFactory::$loaded_actions = $actions;

        return $javascript;
    }

    public static function getNewAction($name, $params)
    {
        if (empty(ActionFactory::$loaded_actions)) {
            ActionFactory::loadFunctionList();
        }
        if (isset(ActionFactory::$loaded_actions[$name])) {
            require_once ActionFactory::$loaded_actions[$name]['file'];
            $class = ActionFactory::$loaded_actions[$name]['class'];
            return new $class($params);
        }

        return false;
    }
}
