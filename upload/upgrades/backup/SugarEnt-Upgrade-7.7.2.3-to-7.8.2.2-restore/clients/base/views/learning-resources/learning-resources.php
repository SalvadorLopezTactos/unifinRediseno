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

$viewdefs['base']['view']['learning-resources'] = array(
    'dashlets' => array(
        array(
            'label' => 'LBL_LEARNING_RESOURCES_TITLE',
            'description' => 'LBL_LEARNING_RESOURCES_DESC',
            'config' => array(),
            'preview' => array(),
            'filter' => array(),
        ),
    ),
    'resources' => array(
        'sugar_university' => array(
            'color' => 'blue',
            'icon' => 'fa-book',
            'url' => 'http://university.sugarcrm.com/',
            'link' => 'LBL_LEARNING_RESOURCES_SUGAR_UNIVERSITY_LINK',
            'teaser' => 'LBL_LEARNING_RESOURCES_SUGAR_UNIVERSITY_TEASER',
        ),
        'community' => array(
            'color' => 'green',
            'icon' => 'fa-comments-o',
            'url' => 'https://community.sugarcrm.com/',
            'link' => 'LBL_LEARNING_RESOURCES_COMMUNITY_LINK',
            'teaser' => 'LBL_LEARNING_RESOURCES_COMMUNITY_TEASER',
        ),
        'support' => array(
            'color' => 'red',
            'icon' => 'fa-question-circle',
            'url' => 'http://support.sugarcrm.com/',
            'link' => 'LBL_LEARNING_RESOURCES_SUPPORT_LINK',
            'teaser' => 'LBL_LEARNING_RESOURCES_SUPPORT_TEASER',
        ),
    ),
);
