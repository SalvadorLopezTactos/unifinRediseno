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

$module_name = 'Contracts';
$viewdefs[$module_name]['base']['menu']['quickcreate'] = array(
    'layout' => 'create',
    'href' => '#bwc/index.php?module='.$module_name.'&action=EditView&return_module='.$module_name.'&return_action=DetailView',
    'label' => 'LNK_NEW_CONTRACT',
    'visible' => false,
    'icon' => 'fa-plus',
);
