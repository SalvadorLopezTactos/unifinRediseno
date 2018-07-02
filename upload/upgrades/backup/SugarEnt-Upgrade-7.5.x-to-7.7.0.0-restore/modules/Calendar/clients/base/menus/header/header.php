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
$module_name = 'Calendar';
$viewdefs[$module_name]['base']['menu']['header'] = array(
    array(
        'route'=>'#bwc/index.php?module=Meetings&action=EditView&return_module=Meetings&return_action=DetailView',
        'label' =>'LNK_NEW_MEETING',
        'acl_action'=>'create',
        'acl_module'=>'Meetings',
        'icon' => 'icon-plus',
    ),
    array(
        'route'=>'#bwc/index.php?module=Calls&action=EditView&return_module=Calls&return_action=DetailView',
        'label' =>'LNK_NEW_CALL',
        'acl_action'=>'create',
        'acl_module'=>'Calls',
        'icon' => 'icon-plus',
    ),
    array(
        'route'=>'#Tasks/create',
        'label' =>'LNK_NEW_TASK',
        'acl_action'=>'create',
        'acl_module'=>'Tasks',
        'icon' => 'icon-plus',
    ),
    array(
        'route'=>'#bwc/index.php?module=Calendar&action=index&view=day',
        'label' =>'LNK_VIEW_CALENDAR',
        'acl_action'=>'list',
        'acl_module'=>$module_name,
        'icon' => 'icon-reorder',
    ),


);
