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
$module_name = 'Contracts';
$viewdefs[$module_name]['base']['menu']['header'] = [
    [
        'route' => '#Contracts/create',
        'label' => 'LNK_NEW_CONTRACT',
        'acl_action' => 'create',
        'acl_module' => $module_name,
        'icon' => 'sicon-plus',
    ],
    [
        'route' => '#Contracts',
        'label' => 'LNK_CONTRACT_LIST',
        'acl_action' => 'list',
        'acl_module' => $module_name,
        'icon' => 'sicon-list-view',
    ],
    [
        'route' => '#bwc/index.php?module=Import&action=Step1&import_module=Contracts&return_module=Contracts&return_action=index',
        'label' => 'LNK_IMPORT_CONTRACTS',
        'acl_action' => 'import',
        'acl_module' => $module_name,
        'icon' => 'sicon-upload',
    ],
];
