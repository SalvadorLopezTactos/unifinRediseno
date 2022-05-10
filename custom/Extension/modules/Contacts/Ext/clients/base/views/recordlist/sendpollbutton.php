<?php

/**
 * The file used to add send poll button to accounts list view
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$viewdefs['Contacts']['base']['view']['recordlist']['selection']['actions'][] = array(
            'name' => 'send_poll',
            'type' => 'button',
            'label' => 'Send Poll',
            'acl_action' => 'send_poll',
            'primary' => true,
            'events' => array(
                'click' => 'list:sendpoll:fire',
            ),
);