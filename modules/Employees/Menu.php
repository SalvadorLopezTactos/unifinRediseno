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
 * Description:  TODO To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

global $mod_strings;
global $current_user;
$module_menu = [];

if (empty($_REQUEST['record'])) {
    $employee_id = '';
} else {
    $employee_id = $_REQUEST['record'];
}

if (is_admin($current_user)) {
    $module_menu[] = ['index.php?module=Employees&action=EditView&return_module=Employees&return_action=DetailView', $mod_strings['LNK_NEW_EMPLOYEE'], 'CreateEmployees'];
}

$module_menu[] = ['index.php?module=Employees&action=index&return_module=Employees&return_action=DetailView', $mod_strings['LNK_EMPLOYEE_LIST'], 'Employees'];
