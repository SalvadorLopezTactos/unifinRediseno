<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
$module_name = 'Styleguide';
$viewdefs[$module_name]['base']['menu']['header'] = array(
    array(
        'route'=>'#'.$module_name.'/docs/index',
        'label' =>'Core Elements',
        'acl_action'=>'list',
        'acl_module'=>'Accounts',
        'icon' => 'fa-book',
    ),
    array(
        'route'=>'#'.$module_name.'/layout/records',
        'label' =>'Default Module Layout',
        'acl_action'=>'list',
        'acl_module'=>'Accounts',
        'icon' => 'fa-columns',
    ),
    array(
        'route'=>'#'.$module_name.'/view/list',
        'label' =>'Default List View',
        'acl_action'=>'list',
        'acl_module'=>'Accounts',
        'icon' => 'fa-bars',
    ),
    array(
        'route'=>'#'.$module_name.'/create',
        'label' =>'Default Create View',
        'acl_action'=>'list',
        'acl_module'=>'Accounts',
        'icon' => 'fa-plus',
    ),
    array(
        'route'=>'#'.$module_name.'/field/all',
        'label' =>'Example Sugar7 Fields',
        'acl_action'=>'list',
        'acl_module'=>'Accounts',
        'icon' => 'fa-list-alt',
    ),
    // array(
    //     'route'=>'styleguide/tests/global.html',
    //     'label' =>'Run Tests',
    //     'acl_action'=>'list',
    //     'acl_module'=>'Accounts',
    //     'icon' => 'fa-heart',
    // ),
);
