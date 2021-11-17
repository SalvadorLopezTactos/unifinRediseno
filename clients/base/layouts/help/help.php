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

$viewdefs['base']['layout']['help'] = array(
    'components' => array(
        array(
            'view' => 'help-header',
        ),
        array(
            'layout' => array(
                'type' => 'base',
                'css_class' => 'helplet-list-container',
                'components' => array(
                    array(
                        'view' => 'helplet',
                    ),
                    array(
                        'view' => array(
                            'type' => 'helplet',
                            'resources' => array(
                                'sugar_university' => array(
                                    'url' => 'https://sugarclub.sugarcrm.com/learn',
                                    'link' => 'LBL_LEARNING_RESOURCES_SUGAR_UNIVERSITY_LINK',
                                    'type' => 'sugar-university',
                                ),
                                'community' => array(
                                    'url' => 'https://sugarclub.sugarcrm.com/explore',
                                    'link' => 'LBL_LEARNING_RESOURCES_COMMUNITY_LINK',
                                    'type' => 'community',
                                ),
                                'support' => array(
                                    'url' => 'https://support.sugarcrm.com/',
                                    'link' => 'LBL_LEARNING_RESOURCES_SUPPORT_LINK',
                                    'type' => 'support',
                                ),
                                'tour' => array(
                                    'id' => 'tour',
                                    'color' => 'gray',
                                    'icon' => 'fa-road',
                                    'link' => 'LBL_TOUR_LINK',
                                    'type' => 'tour',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
