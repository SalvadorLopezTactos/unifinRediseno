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
$viewdefs['OutboundEmail']['base']['view']['record'] = array(
    'buttons' => array(
        array(
            'type' => 'button',
            'name' => 'cancel_button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
            'showOn' => 'edit',
            'events' => array(
                'click' => 'button:cancel_button:click',
            ),
        ),
        array(
            'type' => 'rowaction',
            'event' => 'button:save_button:click',
            'name' => 'save_button',
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'css_class' => 'btn btn-primary',
            'showOn' => 'edit',
            'acl_action' => 'edit',
        ),
        array(
            'type' => 'actiondropdown',
            'name' => 'main_dropdown',
            'primary' => true,
            'showOn' => 'view',
            'buttons' => array(
                array(
                    'type' => 'rowaction',
                    'event' => 'button:edit_button:click',
                    'name' => 'edit_button',
                    'label' => 'LBL_EDIT_BUTTON_LABEL',
                    'acl_action' => 'edit',
                ),
                array(
                    'type' => 'rowaction',
                    'event' => 'button:duplicate_button:click',
                    'name' => 'duplicate_button',
                    'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                    'acl_module' => 'OutboundEmail',
                    'acl_action' => 'create',
                ),
                array(
                    'type' => 'rowaction',
                    'event' => 'button:delete_button:click',
                    'name' => 'delete_button',
                    'label' => 'LBL_DELETE_BUTTON_LABEL',
                    'acl_action' => 'delete',
                ),
            ),
        ),
        array(
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
        ),
    ),
    'panels' => array(
        array(
            'name' => 'panel_header',
            'header' => true,
            'fields' => array(
                array(
                    'name' => 'picture',
                    'type' => 'avatar',
                    'size' => 'large',
                    'dismiss_label' => true,
                    'readonly' => true,
                ),
                array(
                    'name' => 'name',
                    'related_fields' => array(
                        'type',
                    ),
                ),
            ),
        ),
        array(
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'mail_smtptype',
                    'type' => 'email-provider',
                    'span' => 12,
                ),
                [
                    'name' => 'auth_status',
                    'type' => 'auth-status',
                    'label' => 'LBL_STATUS',
                    'related_fields' => [
                        'eapm_id',
                    ],
                    'readonly' => true,
                ],
                'authorized_account',
                array(
                    'name' => 'mail_smtpuser',
                    'required' => true,
                ),
                array(
                    'name' => 'mail_smtppass',
                    'type' => 'change-password',
                    'required' => true,
                ),
                'mail_smtpserver',
                'mail_smtpport',
                'mail_smtpauth_req',
                'mail_smtpssl',
                array(
                    'name' => 'email_address',
                    'type' => 'email-address',
                    'link' => false,
                ),
                'reply_to_name',
                array(
                    'name' => 'reply_to_email_address',
                    'type' => 'email-address',
                    'link' => false,
                ),
                'team_name',
            ),
        ),
    ),
    'dependencies' => array(
        array(
            'hooks' => array('edit'),
            'trigger' => 'true',
            'triggerFields' => array('mail_smtptype'),
            'onload' => false,
            'actions' => array(
                array(
                    'action' => 'SetValue',
                    'params' => array(
                        'target' => 'mail_smtpserver',
                        'value' =>
                            'ifElse(or(equal($mail_smtptype,"google"), equal($mail_smtptype,"google_oauth2")), "smtp.gmail.com",
                                ifElse(equal($mail_smtptype,"exchange"), "",
                                    ifElse(equal($mail_smtptype,"exchange_online"), "smtp.office365.com",
                                        ifElse(equal($mail_smtptype,"outlook"), "smtp-mail.outlook.com",
                                            $mail_smtpserver))))',
                    ),
                ),
                array(
                    'action' => 'SetValue',
                    'params' => array(
                        'target' => 'mail_smtpport',
                        'value' =>
                            'ifElse(or(equal($mail_smtptype,"google"), equal($mail_smtptype,"google_oauth2")), "587",
                                ifElse(or(equal($mail_smtptype,"exchange"), equal($mail_smtptype,"exchange_online")), "587",
                                    ifElse(equal($mail_smtptype,"outlook"), "587",
                                        $mail_smtpport)))',
                    ),
                ),
                array(
                    'action' => 'SetValue',
                    'params' => array(
                        'target' => 'mail_smtpssl',
                        'value' =>
                            'ifElse(or(equal($mail_smtptype,"google"), equal($mail_smtptype,"google_oauth2")), "2",
                                ifElse(or(equal($mail_smtptype,"exchange"), equal($mail_smtptype,"exchange_online")), "2",
                                    ifElse(equal($mail_smtptype,"outlook"), "2",
                                        $mail_smtpssl)))',
                    ),
                ),
                array(
                    'action' => 'SetValue',
                    'params' => array(
                        'target' => 'mail_smtpauth_req',
                        'value' =>
                            'ifElse(or(equal($mail_smtptype,"google"), equal($mail_smtptype,"google_oauth2")), "1",
                                ifElse(or(equal($mail_smtptype,"exchange"), equal($mail_smtptype,"exchange_online")), "1",
                                    ifElse(equal($mail_smtptype,"outlook"), "1",
                                        $mail_smtpauth_req)))',
                    ),
                ),
            ),
        ),
        array(
            'hooks' => array('edit'),
            'trigger' => 'true',
            'triggerFields' => array('mail_smtpssl'),
            'onload' => false,
            'actions' => array(
                array(
                    'action' => 'SetValue',
                    'params' => array(
                        'target' => 'mail_smtpport',
                        'value' =>
                            'ifElse(equal($mail_smtpssl,"1"), "465",
                                ifElse(equal($mail_smtpssl,"2"), "587",
                                    "25"))',
                    ),
                ),
            ),
        ),
        array(
            'hooks' => array('edit'),
            'trigger' => 'true',
            'triggerFields' => array('mail_smtpauth_req', 'mail_authtype'),
            'onload' => true,
            'actions' => array(
                array(
                    'action' => 'SetRequired',
                    'params' => array(
                        'target' => 'mail_smtpuser',
                        'value' => 'and(equal($mail_smtpauth_req, "1"), not(equal($mail_authtype,"oauth2")))',
                    ),
                ),
                array(
                    'action' => 'SetRequired',
                    'params' => array(
                        'target' => 'mail_smtppass',
                        'value' => 'and(equal($mail_smtpauth_req, "1"), not(equal($mail_authtype,"oauth2")))',
                    ),
                ),
            ),
        ),
        array(
            'hooks' => array('all'),
            'trigger' => 'true',
            'triggerFields' => array('mail_smtpauth_req', 'mail_authtype'),
            'onload' => true,
            'actions' => array(
                array(
                    'action' => 'SetVisibility',
                    'params' => array(
                        'target' => 'mail_smtpuser',
                        'value' => 'and(equal($mail_smtpauth_req, "1"), not(equal($mail_authtype,"oauth2")))',
                    ),
                ),
                array(
                    'action' => 'SetVisibility',
                    'params' => array(
                        'target' => 'mail_smtppass',
                        'value' => 'and(equal($mail_smtpauth_req, "1"), not(equal($mail_authtype,"oauth2")))',
                    ),
                ),
            ),
        ),
        array(
            'hooks' => array('all'),
            'trigger' => 'true',
            'triggerFields' => array('mail_authtype'),
            'onload' => true,
            'actions' => array(
                array(
                    'action' => 'SetVisibility',
                    'params' => array(
                        'target' => 'auth_status',
                        'value' => 'equal($mail_authtype,"oauth2")',
                    ),
                ),
                array(
                    'action' => 'SetVisibility',
                    'params' => array(
                        'target' => 'authorized_account',
                        'value' => 'equal($mail_authtype,"oauth2")',
                    ),
                ),
                array(
                    'action' => 'ReadOnly',
                    'params' => array(
                        'target' => 'mail_smtpauth_req',
                        'value' => 'equal($mail_authtype,"oauth2")',
                    ),
                ),
                array(
                    'action' => 'ReadOnly',
                    'params' => array(
                        'target' => 'authorized_account',
                        'value' => 'equal($mail_authtype,"oauth2")',
                    ),
                ),
            ),
        ),
    ),
);
