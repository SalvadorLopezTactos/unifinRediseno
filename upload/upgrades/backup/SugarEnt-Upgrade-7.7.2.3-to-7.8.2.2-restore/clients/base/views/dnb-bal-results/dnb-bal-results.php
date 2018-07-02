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

$viewdefs['base']['view']['dnb-bal-results'] = array(
    'import_enabled_modules' => array('Contacts', 'Leads', 'Prospects'),
    'dashlets' => array(
        array(
            'label' => 'LBL_DNB_BAL_RSLT',
            'description' => 'LBL_DNB_BAL_RSLT',
            'config' => array(),
            'preview' => array(),
            'filter' => array(
                'module' => array(
                    'DnbNoDisplay',
                ),
                'view' => 'DnbNoDisplay'
            )
        ),
    )
);
