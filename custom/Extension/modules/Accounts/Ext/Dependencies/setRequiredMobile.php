<?php

$dependencies['Accounts']['tct_mobile_email'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('phone_office'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'email',
                'label' => 'tct_mobile_email',
                'value' => 'equal($phone_office,"")',
            ),
        ),
    ),
);

$dependencies['Accounts']['tct_mobile_phone'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('email'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'phone_office',
                'label' => 'tct_mobile_phone',
                'value' => 'equal(strlen($email1),0)',
            ),
        ),
    ),
);