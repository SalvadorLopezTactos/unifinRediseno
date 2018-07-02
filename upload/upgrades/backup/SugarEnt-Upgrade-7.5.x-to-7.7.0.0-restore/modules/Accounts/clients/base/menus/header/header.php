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

$moduleName = 'Accounts';
$viewdefs[$moduleName]['base']['menu']['header'] = array(
    array(
        'label' =>'LNK_NEW_ACCOUNT',
        'acl_action'=>'create',
        'acl_module'=>$moduleName,
        'icon' => 'icon-plus',
        'route'=>'#'.$moduleName.'/create',
    ),
    array(
        'label' => 'LBL_BAL',
        'acl_action' => 'create',
        'acl_module' => $moduleName,
        'icon' => 'icon-plus',
        'route' => '#'.$moduleName.'/layout/dnb-bal',
    ),
    array(
        'route'=>'#'.$moduleName,
        'label' =>'LNK_ACCOUNT_LIST',
        'acl_action'=>'list',
        'acl_module'=>$moduleName,
        'icon' => 'icon-reorder',
    ),
    array(
        'route' => '#bwc/index.php?' . http_build_query(
            array(
                'module' => 'Reports',
                'action' => 'index',
                'view' => $moduleName,
                'query' => 'true',
                'report_module' => $moduleName,
            )
        ),
        'label' =>'LNK_ACCOUNT_REPORTS',
        'acl_action'=>'list',
        'acl_module'=>$moduleName,
        'icon' => 'icon-bar-chart',
    ),
    array(
        'route' => '#bwc/index.php?' . http_build_query(
            array(
                'module' => 'Import',
                'action' => 'Step1',
                'import_module' => $moduleName,
            )
        ),
        'label' =>'LNK_IMPORT_ACCOUNTS',
        'acl_action'=>'import',
        'acl_module'=>$moduleName,
        'icon' => 'icon-upload',
    ),
);
