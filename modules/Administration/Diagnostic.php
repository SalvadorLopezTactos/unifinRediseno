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

use Sugarcrm\Sugarcrm\Security\InputValidation\InputValidation;
use Sugarcrm\Sugarcrm\Security\Validator\Constraints\Enum;
use Sugarcrm\Sugarcrm\Security\Validator\Validator;

global $mod_strings;
global $app_list_strings;
global $app_strings;

global $current_user;

if (!is_admin($current_user)) {
    sugar_die('Unauthorized access to administration.');
}
if (isset($GLOBALS['sugar_config']['hide_admin_diagnostics']) && $GLOBALS['sugar_config']['hide_admin_diagnostics']) {
    sugar_die('Unauthorized access to diagnostic tool.');
}

global $db;
if (empty($db)) {
    $db = DBManagerFactory::getInstance();
}

echo getClassicModuleTitle(
    'Administration',
    [
        "<a href='#Administration'>{$mod_strings['LBL_MODULE_NAME']}</a>",
        translate('LBL_DIAGNOSTIC_TITLE'),
    ],
    false
);

global $currentModule;

$GLOBALS['log']->info('Administration Diagnostic');

$select = $_REQUEST['select'] ?? [];

$constraint = new Enum([
    'allowedValues' => [
        'configphp',
        'custom_dir',
        'phpinfo',
        'mysql_dumps',
        'mysql_schema',
        'mysql_info',
        'md5',
        'beanlistbeanfiles',
        'sugarlog',
        'mlplog',
        'vardefs',
    ],
]);
$violations = Validator::getService()->validate($select, $constraint);

if (safeCount($violations) > 0) {
    $msg = array_reduce(iterator_to_array($violations), function ($msg, $violation) {
        return empty($msg) ? $violation->getMessage() : $msg . ' - ' . $violation->getMessage();
    });
    throw new \RuntimeException($msg);
}

$checkAll = empty($select) || !is_array($select);

$sugar_smarty = new Sugar_Smarty();
$sugar_smarty->assign('MOD', $mod_strings);
$sugar_smarty->assign('APP', $app_strings);
$sugar_smarty->assign('SELECT', $select);
$sugar_smarty->assign('CHECK_ALL', $checkAll);

$sugar_smarty->assign('RETURN_MODULE', 'Administration');
$sugar_smarty->assign('RETURN_ACTION', 'index');
$sugar_smarty->assign('DB_NAME', $db->dbName);

$sugar_smarty->assign('MODULE', $currentModule);

$sugar_smarty->assign('ADVANCED_SEARCH_PNG', SugarThemeRegistry::current()->getImage('advanced_search', 'border="0"', null, null, '.gif', $app_strings['LNK_ADVANCED_SEARCH']));
$sugar_smarty->assign('BASIC_SEARCH_PNG', SugarThemeRegistry::current()->getImage('basic_search', 'border="0"', null, null, '.gif', $app_strings['LNK_BASIC_SEARCH']));

$sugar_smarty->display('modules/Administration/Diagnostic.tpl');
