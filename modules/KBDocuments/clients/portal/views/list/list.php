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

$viewdefs['KBDocuments']['portal']['view']['list'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => array(
                 array (
                    'name' => 'kbdocument_name',
                    'width' => '45%',
                    'label' => 'LBL_NAME',
                    'link' => true,
                    'bwcLink' => false,
                    'enabled' => true,
                    'default' => true,
                ),
                array (
                    'name' => 'active_date',
                    'label' => 'LBL_DOC_ACTIVE_DATE',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array (
                    'name' => 'exp_date',
                    'label' => 'LBL_DOC_EXP_DATE',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array (
                    'name' => 'date_entered',
                    'label' => 'LBL_DATE_ENTERED',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                    'readonly' => true,
                ),
                array (
                    'name' => 'kbdocument_revision_number',
                    'label' => 'LBL_KBDOCUMENT_REVISION_NUMBER',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
            ),
        ),
    ),
    'last_state' => array(
        'id' => 'list',
    ),
);
