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
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\Config;

$idpConfig  = new Config(\SugarConfig::getInstance());
$isIDMModeEnabled  = $idpConfig->isIDMModeEnabled();

$viewdefs['base']['view']['profileactions'] = [
    [
        'route' => '#profile',
        'label' => 'LBL_PROFILE',
        'css_class' => 'profileactions-profile',
        'acl_action' => 'view',
        'icon' => 'sicon-user',
    ],
];

if ($isIDMModeEnabled) {
    $viewdefs['base']['view']['profileactions'][] = [
        'route' => $idpConfig->getIDMModeConfig()['profileUrls']['changePassword'],
        'label' => 'LBL_CHANGE_PASSWORD',
        'css_class' => 'profileactions-change-password',
        'acl_action' => 'view',
        'icon' => 'sicon-lock',
    ];
}

$viewdefs['base']['view']['profileactions'] = array_merge(
    $viewdefs['base']['view']['profileactions'],
    [
        array(
            'route'=> '#bwc/index.php?module=Employees&action=index&query=true',
            'label' => 'LBL_EMPLOYEES',
            'css_class' => 'profileactions-employees',
            'acl_action' => 'list',
            'icon' => 'sicon-user-group',
        ),
        array(
            'route' => '#Administration',
            'label' => 'LBL_ADMIN',
            'css_class' => 'administration',
            'module' => 'Administration',
            'acl_action' => 'admin',
            'icon' => 'sicon-settings',
        ),
        [
            'label' => 'LNK_MOBILE',
            'css_class' => 'profileactions-mobile',
            'icon' => 'sicon-mobile-lg',
        ],
        [
            'label' => 'LBL_SHORTCUTS',
            'css_class' => 'profileactions-shortcuts',
            'icon' => 'sicon-shortcuts-lg',
        ],
        array(
            'route' => '#about',
            'label' => 'LNK_ABOUT',
            'css_class' => 'profileactions-about',
            'acl_action' => 'view',
            'icon' => 'sicon-info',
        ),
        array(
            'route' => '#logout/?clear=1',
            'label' => 'LBL_LOGOUT',
            'css_class' => 'profileactions-logout',
            'icon' => 'sicon-logout',
        ),

    ]
);

if ($isIDMModeEnabled) {
    $viewdefs['base']['view']['profileactions'][] = [
        'route' => '#finishImpersonation',
        'label' => 'LBL_FINISH_IMPERSONATING',
        'css_class' => 'profileactions-finish-impersonating',
        'icon' => 'sicon sicon-logout',
    ];

    if ($idpConfig->isMultiFactorAuthenticationEnabled()) {
        array_splice(
            $viewdefs['base']['view']['profileactions'],
            3,
            0,
            [
                [
                    'label' => 'LBL_RESET_MFA',
                    'css_class' => 'profileactions-reset-mfa',
                    'icon' => 'sicon-lock',
                ],
            ],
        );
    }
}
