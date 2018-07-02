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
$viewdefs['Emails']['base']['view']['compose'] = array(
    'template' => 'record',
    'buttons' => array(
        array(
            'type'      => 'button',
            'name'      => 'cancel_button',
            'label'     => 'LBL_CANCEL_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
            'events' => array(
                'click' => 'button:cancel_button:click',
            ),
        ),
        array(
            'type'    => 'actiondropdown',
            'name'    => 'main_dropdown',
            'primary' => true,
            'buttons' => array(
                array(
                    'name'  => 'send_button',
                    'type'  => 'rowaction',
                    'label' => 'LBL_SEND_BUTTON_LABEL',
                    'events' => array(
                        'click' => 'button:send_button:click',
                    ),
                ),
                array(
                    'name'  => 'draft_button',
                    'type'  => 'rowaction',
                    'label' => 'LBL_SAVE_AS_DRAFT_BUTTON_LABEL',
                    'events' => array(
                        'click' => 'button:draft_button:click',
                    ),
                ),
            ),
        ),
        array(
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
        ),
    ),
    'panels'  => array(
        array(
            'name'         => 'panel_body',
            'label'        => 'LBL_PANEL_2',
            'columns'      => 1,
            'labels'       => true,
            'labelsOnTop'  => false,
            'placeholders' => true,
            'fields'       => array(
                array(
                    'name'            => 'email_config',
                    'label'           => 'LBL_FROM',
                    'type'            => 'sender',
                    'span'            => 12,
                    'css_class'       => 'inherit-width',
                    'label_css_class' => 'begin-fieldgroup',
                    'endpoint'        => array(
                        'module' => 'OutboundEmailConfiguration',
                        'action' => 'list',
                    )
                ),
                array(
                    'name'           => 'to_addresses',
                    'type'           => 'recipients',
                    'label'          => 'LBL_TO_ADDRS',
                    'span'           => 12,
                    'cell_css_class' => 'controls-one btn-fit',
                    'required'       => true,
                ),
                array(
                    'name'           => 'cc_addresses',
                    'type'           => 'recipients',
                    'label'          => 'LBL_CC',
                    'span'           => 12,
                    'cell_css_class' => 'controls-one btn-fit',
                ),
                array(
                    'name'           => 'bcc_addresses',
                    'type'           => 'recipients',
                    'label'          => 'LBL_BCC',
                    'span'           => 12,
                    'cell_css_class' => 'controls-one btn-fit',
                ),
                array(
                    'name'            => 'subject',
                    'label'           => 'LBL_SUBJECT',
                    'span'            => 12,
                    'label_css_class' => 'end-fieldgroup',
                ),
                array(
                    'name'        => 'attachments',
                    'label'       => 'LBL_ATTACHMENTS',
                    'type'        => 'attachments',
                ),
                array(
                    'name'           => 'actionbar',
                    'type'           => 'compose-actionbar',
                    'span'           => 12,
                    'inline' => true,
                    'dismiss_label'  => true,
                    'fields' => array(
                        array(
                            'name'      => 'attachments_dropdown',
                            'css_class' => 'btn-group',
                            'type'      => 'actiondropdown',
                            'buttons'   => array(
                                array(
                                    'name'  => 'upload_new_button',
                                    'type'  => 'attachment-button',
                                    'icon'  => 'fa-paperclip',
                                    'label' => 'LBL_ATTACHMENT',
                                ),
                                array(
                                    'name'  => 'attach_sugardoc_button',
                                    'type'  => 'rowaction',
                                    'label' => 'LBL_ATTACH_SUGAR_DOC',
                                ),
                            ),
                        ),
                        array(
                            'name'      => 'other_actions',
                            'type' => 'fieldset',
                            'inline' => true,
                            'css_class' => 'actions pull-right',
                            'fields'   => array(
                                array(
                                    'name'  => 'signature_button',
                                    'type'  => 'button',
                                    'icon'  => 'fa-edit',
                                    'label' => 'LBL_EMAIL_SIGNATURES',
                                ),
                                array(
                                    'name'  => 'template_button',
                                    'type'  => 'button',
                                    'icon'  => 'fa-file-o',
                                    'label' => 'LBL_EMAIL_TEMPLATES',
                                ),
                            ),
                        ),
                    ),
                ),
                array(
                    'name'          => 'html_body',
                    'type'          => 'htmleditable_tinymce',
                    'dismiss_label' => true,
                    'span'          => 12,
                    'fieldSelector' => 'compose_html_body',
                    'tinyConfig'    => array(
                        'height' => '100%',
                        'width' => '100%',
                        'plugins' => 'style,paste,inlinepopups',
                        'forced_root_block' => false,
                        'theme_advanced_buttons1' => "code,separator,bold,italic,underline,strikethrough,separator,bullist,numlist,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,forecolor,backcolor,separator,fontsizeselect",
                        'theme_advanced_buttons2' => null,
                        'theme_advanced_resizing' => false,
                    ),
                ),
            ),
        ),
        array(
            'name'         => 'panel_hidden',
            'hide'         => true,
            'columns'      => 1,
            'labelsOnTop'  => false,
            'placeholders' => true,
            'fields'       => array(
                array(
                    'type' => 'teamset',
                    'name' => 'team_name',
                    'span' => 12,
                ),
                array(
                    'name' => 'parent_name',
                    'span' => 12,
                ),
            ),
        ),
    ),
);
