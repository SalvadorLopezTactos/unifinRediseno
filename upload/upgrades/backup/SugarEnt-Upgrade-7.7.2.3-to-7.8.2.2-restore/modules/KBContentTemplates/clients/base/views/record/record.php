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

$viewdefs['KBContentTemplates']['base']['view']['record'] = array(
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
                    'type' => 'divider',
                ),
                array(
                    'type' => 'shareaction',
                    'name' => 'share',
                    'label' => 'LBL_RECORD_SHARE_BUTTON',
                    'acl_action' => 'view',
                ),
                array(
                    'type' => 'pdfaction',
                    'name' => 'download-pdf',
                    'label' => 'LBL_PDF_VIEW',
                    'action' => 'download',
                    'acl_action' => 'view',
                ),
                array(
                    'type' => 'pdfaction',
                    'name' => 'email-pdf',
                    'label' => 'LBL_PDF_EMAIL',
                    'action' => 'email',
                    'acl_action' => 'view',
                ),
                array(
                    'type' => 'divider',
                ),
                array(
                    'type' => 'rowaction',
                    'event' => 'button:audit_button:click',
                    'name' => 'audit_button',
                    'label' => 'LNK_VIEW_CHANGE_LOG',
                    'acl_action' => 'view',
                ),
                array(
                    'type' => 'divider',
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
            'label' => 'LBL_PANEL_HEADER',
            'header' => true,
            'fields' => array(
                array(
                    'name' => 'picture',
                    'type' => 'avatar',
                    'size' => 'large',
                    'dismiss_label' => true,
                    'readonly' => true,
                    'span' => 8,
                ),
                array(
                    'name' => 'name',
                ),
                array(
                    'name' => 'favorite',
                    'label' => 'LBL_FAVORITE',
                    'type' => 'favorite',
                    'dismiss_label' => true,
                ),
                array(
                    'name' => 'follow',
                    'label' => 'LBL_FOLLOW',
                    'type' => 'follow',
                    'readonly' => true,
                    'dismiss_label' => true,
                ),
            ),
        ),
        array(
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'body_set',
                    'type' => 'fieldset',
                    'label' => 'LBL_TEXT_BODY',
                    'span' => 12,
                    'fields' => array(
                        array(
                            'name' => 'body',
                            'type' => 'htmleditable_tinymce',
                            'span' => 12,
                            'dismiss_label' => false,
                            'fieldSelector' => 'body',
                            'tinyConfig' => array(
                                'height' => '300',
                                'width' => '100%',
                                'plugins' => 'style,paste,inlinepopups,advimage,advlink',
                                'forced_root_block' => false,
                                'theme_advanced_buttons1' => 'code,separator,bold,italic,underline,strikethrough,' .
                                    'separator,bullist,numlist,separator,justifyleft,justifycenter,justifyright,' .
                                    'justifyfull,separator,forecolor,backcolor,separator,cleanup,removeformat, ' .
                                    'separator,image,link',
                                'theme_advanced_buttons2' => 'fontsizeselect, formatselect, styleselect',
                                'theme_advanced_resizing' => false,
                                'theme_advanced_blockformats' => 'h1,h2,h3,h4,h5,h6,code,p,div',
                                'theme_advanced_font_sizes' => 'Normal=.fontSizeNormal,Header=.fontSizeHeader,' .
                                    'Large=.fontSizeLarge,Medium=.fontSizeMedium,Small=.fontSizeSmall,' .
                                    'Mini=.fontSizeMini',
                                'style_formats' => array(
                                    array(
                                        'title' => 'Bold text',
                                        'inline' => 'b',
                                    )
                                ),
                            ),
                        ),
                        array(
                            'name' => 'filename',
                            'type' => 'file',
                            'css_class' => 'hidden',
                            'comment' => 'Used for uploading embedded files',
                        ),
                    ),
                ),
                'created_by_name',
            ),
        ),
        array(
            'name' => 'panel_hidden',
            'label' => 'LBL_SHOW_MORE',
            'hide' => true,
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                'date_entered',
                'date_modified',
            ),
        ),
    ),
);
