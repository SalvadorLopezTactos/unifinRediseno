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

$viewdefs['Home']['base']['layout']['about'] = array(
    'type' => 'simple',
    'name' => 'about',
    'css_class' => 'row-fluid',
    'components' => array(
        array(
            'layout' => array(
                'type' => 'simple',
                'css_class' => 'main-pane span12',
                'components' => array(
                    array(
                        'view' => 'about-headerpane',
                    ),
                    array(
                        'layout' => array(
                            'type' => 'fluid',
                            'components' => array(
                                array(
                                    'layout' => array(
                                        'type' => 'simple',
                                        'span' => 12,
                                        'components' => array(
                                            array(
                                                'view' => 'about-copyright',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    array(
                        'layout' => array(
                            'type' => 'fluid',
                            'components' => array(
                                array(
                                    'layout' => array(
                                        'type' => 'simple',
                                        'span' => 6,
                                        'components' => array(
                                            array(
                                                'view' => 'about-resources',
                                            ),
                                        ),
                                    ),
                                ),
                                array(
                                    'layout' => array(
                                        'type' => 'simple',
                                        'span' => 6,
                                        'components' => array(
                                            array(
                                                'view' => 'about-source-code',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
