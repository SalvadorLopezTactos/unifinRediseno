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

$viewdefs['base']['view']['pipeline-recordlist-content'] = array(
    'tileDef' => array(
        'panels' => array(
            array(
                'name' => 'header',
                'is_header' => true,
                'buttons' => array(
                    array(
                        'type' => 'actiondropdown',
                        'name' => 'main_dropdown',
                        'buttons' =>
                            array(
                                array(
                                    'type' => 'rowaction',
                                    'event' => 'button:delete_button:click',
                                    'acl_action' => 'delete',
                                    'tooltip' => 'LBL_DELETE',
                                    'css_class' => 'delete',
                                    'icon'=>'fa-times',
                                ),
                            ),
                    ),
                ),
                'fields' => array(),
            ),
            array(
                'name' => 'body',
                'fields' => array(),
            ),
        ),
    ),
);
