<?php

/**
 * The file used to store Relationship Definition for adding send survey button
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$viewdefs['Leads']['base']['view']['recordlist']['selection']['actions'][] = array(
    'name' => 'send_survey',
    'type' => 'button',
    'label' => 'Send Survey',
    'acl_action' => 'send_survey',
    'primary' => true,
    'events' => array(
        'click' => 'list:sendsurvey:fire',
    ),
);