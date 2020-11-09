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
$module_name = 'Manufacturers';
$viewdefs[$module_name]['base']['menu']['header'] = array(
    array(
        'route'=>'#'.$module_name.'/create',
        'label' =>'LNK_NEW_MANUFACTURER',
        'acl_action' => 'create',
        'acl_module' => $module_name,
        'icon' => 'fa-plus',
    ),
    array(
        'route'=>'#Manufacturers',
        'label' =>'LNK_VIEW_MANUFACTURERS',
        'acl_action' => 'list',
        'acl_module' => 'Manufacturers',
        'icon' => 'fa-bars',
    ),
    array(
        'route'=>'#' . 'ProductTemplates',
        'label' =>'LNK_PRODUCT_LIST',
        'acl_action' => 'list',
        'acl_module' => 'ProductTemplates',
        'icon' => 'fa-bars',
    ),
    array(
        'route'=>'#ProductCategories',
        'label' =>'LNK_NEW_PRODUCT_CATEGORY',
        'acl_action' => 'list',
        'acl_module' => 'ProductCategories',
        'icon' => 'fa-bars',
    ),
    array(
        'route'=>'#ProductTypes',
        'label' =>'LNK_NEW_PRODUCT_TYPE',
        'acl_action' => 'list',
        'acl_module' => 'ProductTypes',
        'icon' => 'fa-bars',
    ),
    array(
        'route'=>'#bwc/index.php?module=Import&action=Step1&import_module=Manufacturers&return_module=Manufacturers&return_action=index',
        'label' =>'LNK_IMPORT_MANUFACTURERS',
        'acl_action' => 'create',
        'acl_module' => $module_name,
        'icon' => 'fa-arrow-circle-o-up',
    ),

);
