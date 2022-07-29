<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
$viewdefs['KBDocuments']['portal']['view']['record'] = array(
    'buttons' => array(
        array(
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
        ),
    ),
    'panels' => array(
        array(
            'name' => 'panel_header',
            'header' => true,
            'fields' => array(
                array(
                    'name'          => 'picture',
                    'type'          => 'avatar',
                    'size'          => 'large',
                    'dismiss_label' => true,
                    'readonly'      => true,
                ),
                'name',
            ),
        ),
        array(
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                array (
                    'name' => 'body',
                    'span' => 12,
                ),
                array (
                    'name' => 'active_date',
                    'label' => 'LBL_DOC_ACTIVE_DATE',
                    'span' => 12,
                ),
                array (
                    'name' => 'date_modified',
                    'span' => 12,
                    'readonly' => true,
                ),
                array (
                    'name' => 'exp_date',
                    'span' => 12,
                ),
                array(
                    'name'  => 'attachment_list',
                    'label' => 'LBL_ATTACHMENTS',
                    'type' => 'file'
                )
            )
        ),

    ),
);

