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

$viewdefs['base']['layout']['search'] = array(
    'components' => array(
        array(
            'layout' => array(
                'components' => array(
                    array(
                        'layout' => array(
                            'components' => array(
                                array(
                                    'view' => 'search-headerpane',
                                ),
                                array(
                                    'view' => 'search-list',
                                    'primary' => true,
                                ),
                                array(
                                    'view' => array(
                                        'name' => 'list-bottom',
                                        'label' => 'LBL_SHOW_MORE_RESULTS',
                                        'css_class' => 'search-more-results',
                                    ),
                                ),
                            ),
                            'type' => 'simple',
                            'name' => 'main-pane',
                        ),
                    ),
                    array(
                        'layout' => array(
                            'components' => array(
                                array(
                                    'layout' => array(
                                        'name' => 'search-dashboard',
                                        'type' => 'dashboard',
                                        'last_state' => array(
                                            'id' => 'last-visit',
                                        ),
                                    ),
                                    'context' => array(
                                        'forceNew' => true,
                                        'module' => 'Home',
                                    ),
                                ),
                            ),
                            'type' => 'simple',
                            'name' => 'dashboard-pane',
                        ),
                    ),
                    array(
                        'layout' => array(
                            'components' => array(
                                array(
                                    'layout' => 'preview',
                                ),
                            ),
                            'type' => 'simple',
                            'name' => 'preview-pane',
                        ),
                    ),
                ),
                'type' => 'default',
                'name' => 'sidebar',
            ),
        ),
    ),
    'name' => 'search',
);
