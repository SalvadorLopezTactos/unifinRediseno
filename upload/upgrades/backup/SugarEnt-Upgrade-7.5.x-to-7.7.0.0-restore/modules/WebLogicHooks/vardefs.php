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
$dictionary['WebLogicHook'] = array(
    'table' => 'weblogichooks',
    'favorites'=>false,
    'comment' => 'Web Logic Hooks',
    'audited' => false,
    'activity_enabled'=>false,
    'unified_search' => false,
    'unified_search_default_enabled' => false,
    'full_text_search' => false,
    'optimistic_locking' => true,
    'fields' => array(
        'name' => array(
            'name' => 'name',
            'vname' => 'LBL_NAME',
            'type' => 'name',
            'dbType' => 'varchar',
            'len' => '255',
            'comment' => 'Hook name',
            'required' => true,
        ),
        'webhook_target_module' => array(
            'name' => 'webhook_target_module',
            'vname' => 'LBL_TARGET_NAME',
            'type' => 'enum',
            'options' => 'moduleList',
            'required' => true,
        ),
        'request_method' => array(
            'name' => 'request_method',
            'vname' => 'LBL_REQUEST_METHOD',
            'type' => 'enum',
            'options' => 'web_hook_request_method_list',
            'default' => 'POST',
            'required' => true,
        ),
        'url' => array(
            'name' => 'url',
            'vname' => 'LBL_URL',
            'type' => 'varchar',
            'len' => '255',
            'comment' => 'URL of website for the company',
            'required' => true,
        ),
        'trigger_event' => array(
            'name' => 'trigger_event',
            'vname' => 'LBL_TRIGGER_EVENT',
            'type' => 'enum',
            'options' => 'webLogicHookList',
            'required' => true,
        ),
    ),
    'acls' => array(
        'SugarACLAdminOnly' => array(
            'adminFor' => 'Users',
        ),
    ),
);

VardefManager::createVardef(
    'WebLogicHooks',
    'WebLogicHook',
    array(
        'default',
        'basic',
    )
);
