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

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

//Custom plugins
//Search through the plugins to include any custom_utils.php files
$dir_path = "./custom/workflow/plugins";
foreach(SugarAutoLoader::getDirFiles("custom/workflow/plugins", true) as $dir) {
    if(SugarAutoLoader::existing("$dir/custom_utils.php")) {
        include_once("$dir/custom_utils.php");
    }
}
