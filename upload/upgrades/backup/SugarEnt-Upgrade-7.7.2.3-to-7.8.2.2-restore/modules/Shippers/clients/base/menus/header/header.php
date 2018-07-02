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
$module_name = 'Shippers';
$viewdefs[$module_name]['base']['menu']['header'] = array(
    array(
        'route'=>'#bwc/index.php?module=Shippers&action=EditView&return_module=Shippers&return_action=DetailView',
        'label' =>'LNK_NEW_SHIPPER',
        'acl_action'=>'',
        'acl_module'=>'',
        'icon' => '',
    ),
    array(
        'route'=>'#bwc/index.php?module=TaxRates&action=EditView&return_module=TaxRates&return_action=DetailView',
        'label' =>'LNK_NEW_TAXRATE',
        'acl_action'=>'',
        'acl_module'=>'',
        'icon' => '',
    ),
);