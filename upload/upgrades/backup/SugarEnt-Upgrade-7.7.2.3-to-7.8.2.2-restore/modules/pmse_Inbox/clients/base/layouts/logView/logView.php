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


$viewdefs['pmse_Inbox']['base']['layout']['logView'] = array(
    'components' => array(
//        array(
//            'layout' => array(
//                'components' => array(
                    array(
                        'layout' => array(
                            'components' => array(
                                array(
                                    'view' => 'logView-headerpane',
                                    'primary' => true,
                                ),
                                array(
                                    'layout' => array(
                                        'components' => array(
                                            array(
                                                'view' => 'logView-pane',
                                            ),
                                        ),
                                        'type' => 'simple',
                                        'name' => 'main-pane',
                                        'span' => 12,
                                    ),
                                ),
                            ),

                        ),
                    ),
                    array(
                        'layout' => array(
                            'components' => array(
                                array(
                                    'layout' => 'sidebar',
                                ),
                            ),
//                            'type' => 'simple',
//                            'name' => 'side-pane',
//                            'span' => 4,
                        ),
                    ),
//                ),
                'type' => 'default',
                'name' => 'sidebar',
                'span' => 12,
//            ),
//        ),
    ),
//    'type' => 'simple',
//    'name' => 'base',
//    'span' => 12,
);