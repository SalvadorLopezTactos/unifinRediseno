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
global $sugar_config;

$moduleName = 'Users';
$viewdefs[$moduleName]['base']['menu']['header'] = array(
    array(
        'route' => '#bwc/index.php?' . http_build_query(
            array(
                'module' => $moduleName,
                'action' => 'EditView',
            )
        ),
        'label' => 'LNK_NEW_USER',
        'acl_action' => 'admin',
        'acl_module' => $moduleName,
        'icon' => 'fa-plus',
    ),
    array(
        'route' => '#bwc/index.php?' . http_build_query(
            array(
                'module' => $moduleName,
                'action' => 'EditView',
                'usertype'=>'group',
                'return_module' => $moduleName,
                'return_action' => 'DetailView',
            )
        ),
        'label' => 'LNK_NEW_GROUP_USER',
        'acl_action' => 'admin',
        'acl_module' => $moduleName,
        'icon' => 'fa-plus',
    ),
);
if (!empty($sugar_config['enable_web_services_user_creation'])) {
    $viewdefs[$moduleName]['base']['menu']['header'][] =
        array(
            'route' => '#bwc/index.php?' . http_build_query(
                array(
                    'module' => $moduleName,
                    'action' => 'EditView',
                    'usertype'=>'portal',
                    'return_module' => $moduleName,
                    'return_action' => 'DetailView',
                )
            ),
            'label' => 'LNK_NEW_PORTAL_USER',
            'acl_action' => 'admin',
            'acl_module' => $moduleName,
            'icon' => 'fa-plus',
        );
}
$viewdefs[$moduleName]['base']['menu']['header'][] =
    array(
        'route' => '#bwc/index.php?' . http_build_query(
                array(
                    'module' => $moduleName,
                    'action' => 'EditView',
                    'usertype'=>'portal',
                    'return_module' => $moduleName,
                    'return_action' => 'DetailView',
                )
            ),
        'label' => 'LNK_NEW_PORTAL_USER',
        'acl_action' => 'admin',
        'acl_module' => $moduleName,
        'icon' => 'fa-plus',
    );
$viewdefs[$moduleName]['base']['menu']['header'][] =
    array(
        'route' => '#bwc/index.php?' . http_build_query(
            array(
                'module' => $moduleName,
                'action' => 'reassignUserRecords',
            )
        ),
        'label' => 'LNK_REASSIGN_RECORDS',
        'acl_action' => 'admin',
        'acl_module' => $moduleName,
        'icon' => 'fa-arrows',
    );
$viewdefs[$moduleName]['base']['menu']['header'][] =
    array(
        'route' => '#bwc/index.php?' . http_build_query(
            array(
                'module' => 'Import',
                'action' => 'Step1',
                'import_module' => $moduleName,
                'return_module' => $moduleName,
                'return_action' => 'index',
            )
        ),
        'label' => 'LNK_IMPORT_USERS',
        'acl_action' => 'admin',
        'acl_module' => $moduleName,
        'icon' => 'fa-arrow-circle-o-up',
    );
