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
require_once 'modules/ModuleBuilder/Module/StudioModule.php' ;

class StudioModuleFactory
{
	protected static $loadedMods = array();

    public static function getStudioModule($module)
	{
		if (!empty(self::$loadedMods[$module]))
            return self::$loadedMods[$module];

        $studioModClass = "{$module}StudioModule";
		if (file_exists("custom/modules/{$module}/{$studioModClass}.php"))
		{
			require_once "custom/modules/{$module}/{$studioModClass}.php";
			$sm = new $studioModClass($module);

		} else if (file_exists("modules/{$module}/{$studioModClass}.php"))
		{
			require_once "modules/{$module}/{$studioModClass}.php";
			$sm = new $studioModClass($module);

		}
		else 
		{
			$sm = new StudioModule($module);
		}
        self::$loadedMods[$module] = $sm;
        return $sm;
	}
}
?>