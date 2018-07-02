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

$viewdefs['base']['view']['passwordmodal'] = array(
    'buttons' =>
        array(
            array(
                'name' => 'save_button',
                'type' => 'button',
                'label' => 'LBL_SAVE_BUTTON_LABEL',
                'value' => 'save',
                'css_class' => 'btn-primary save-profile',
            ),
            array(
                'name' => 'cancel_button',
                'type' => 'button',
                'label' => 'LBL_CANCEL_BUTTON_LABEL',
                'value' => 'cancel',
                'css_class' => 'btn-invisible btn-link',
            ),
        ),
    'panels' =>
        array(
            array(
                'label' => 'LBL_PANEL_DEFAULT',
                'fields' =>
                array(
                    array(
                        'name' => 'current_password',
                        'type' => 'password',
                        'label' => 'LBL_OLD_PASSWORD',
                        'displayParams' =>
                        array(
                            'colspan' => 2,
                        ),
                    ),
                    array(
                        'name' => 'new_password',
                        'type' => 'password',
                        'label' => 'LBL_NEW_PASSWORD',
                        'displayParams' =>
                        array(
                            'colspan' => 2,
                        ),
                    ),
                    array(
                        'name' => 'confirm_password',
                        'type' => 'password',
                        'label' => 'LBL_NEW_PASSWORD2',
                        'displayParams' =>
                        array(
                            'colspan' => 2,
                        ),
                    ),
                ),
            ),
        ),
);
