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
$module_name = 'Contacts';
$viewdefs[$module_name]['base']['menu']['header'] = array(
    array(
        'route'=>'#'.$module_name.'/create',
        'label' =>'LNK_NEW_CONTACT',
        'acl_action'=>'create',
        'acl_module'=>$module_name,
        'icon' => 'fa-plus',
    ),
    array(
        'route'=>'#'.$module_name.'/vcard-import',
        'label' =>'LNK_IMPORT_VCARD',
        'acl_action'=>'create',
        'acl_module'=>$module_name,
        'icon' => 'fa-plus',
    ),
    array(
        'route'=>'#'.$module_name,
        'label' =>'LNK_CONTACT_LIST',
        'acl_action'=>'list',
        'acl_module'=>$module_name,
        'icon' => 'fa-bars',
    ),
    array(
        'route'=>'#bwc/index.php?module=Reports&action=index&view=contacts&query=true&report_module=Contacts',
        'label' =>'LNK_CONTACT_REPORTS',
        'acl_action'=>'list',
        'acl_module'=>$module_name,
        'icon' => 'fa-bar-chart-o',
    ),
    array(
        'route'=>'#bwc/index.php?module=Import&action=Step1&import_module=Contacts&return_module=Contacts&return_action=index',
        'label' =>'LNK_IMPORT_CONTACTS',
        'acl_action'=>'import',
        'acl_module'=>$module_name,
        'icon' => 'fa-arrow-circle-o-up',
    ),
    array(
        'type' => 'dnb-bal-import-menu-label',
        'default_value' => 'LBL_BAL',
        'icon' => 'fa-arrow-circle-o-up',
        'route' => '#'.$module_name.'/layout/dnb-bal',
    ),
);
