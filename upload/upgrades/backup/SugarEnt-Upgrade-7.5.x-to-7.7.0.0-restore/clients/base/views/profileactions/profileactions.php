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

$viewdefs['base']['view']['profileactions'] = array(
    array(
        'route' => '#bwc/index.php?module=Users&action=DetailView&record=',
        'label' => 'LBL_PROFILE',
        'css_class' => 'profileactions-profile',
        'acl_action' => 'view',
        'icon' => 'icon-user',
        'submenu' => '',
    ),
    array(
        'route'=> '#bwc/index.php?module=Employees&action=index&query=true',
        'label' => 'LBL_EMPLOYEES',
        'css_class' => 'profileactions-employees',
        'acl_action' => 'list',
        'icon' => 'icon-group',
        'submenu' => '',
    ),
    array(
        'route' => '#bwc/index.php?module=Administration&action=index',
        'label' => 'LBL_ADMIN',
        'css_class' => 'administration',
        'acl_action' => 'admin',
        'icon' => 'icon-cogs',
        'submenu' => '',
    ),
    array(
        'route' => '#about',
        'label' => 'LNK_ABOUT',
        'css_class' => 'profileactions-about',
        'acl_action' => 'view',
        'icon' => 'icon-info-sign',
        'submenu' => '',
    ),
    array(
        'route' => '#logout/?clear=1',
        'label' => 'LBL_LOGOUT',
        'css_class' => 'profileactions-logout',
        'icon' => 'icon-signout',
        'submenu' => '',
    ),
);
