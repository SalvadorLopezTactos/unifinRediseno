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

$viewdefs['base']['view']['interactionschart'] = array(
    'dashlets' => array(
        array(
            'name' => 'Interactions Chart',
            'description' => 'Displays Account interactions on chart.',
            'config' => array(
            ),
            'preview' => array(
            ),
            'filter' => array(
                'module' => array(
                    // Changed to 'Documents' for SugarCon 2013 since we don't
                    // want this chart visible in Sugar 7 Preview.
                    'Documents',
                    /*'Accounts',
                    'Contacts',
                    'Leads',
                    'Opportunities',*/
                ),
                'view' => 'record'
            )
        ),
    ),
    'panels' => array(
        array(
            'name' => 'panel_body',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'filter_duration',
                    'label' => 'Filter',
                    'type' => 'enum',
                    'options' => 'interactions_options'
                ),
            ),
        ),
    ),
    'ui' => array(
        'colors' => array(
            'default' => '#085f94',
            'calls' => '#cce8f6',
            'emailsSent' => '#0092d1',
            'emailsRecv' => '#085f94',
            'meetings' => '#0d3d66',
        ),
    ),
    'filter_duration' => array(
        array(
            'name' => 'filter_duration',
            'label' => 'Filter',
            'type' => 'enum',
            'options' => 'interactions_options'
        ),
    )
);
