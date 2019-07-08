<?php

/**
 * The file used to handle action of create-survey component 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$viewdefs['bc_survey'] = array(
    'base' =>
    array(
        'view' =>
        array(
            'record' =>
            array(
                'buttons' =>
                array(
                    0 =>
                    array(
                        'type' => 'button',
                        'name' => 'cancel_button',
                        'label' => 'LBL_CANCEL_BUTTON_LABEL',
                        'css_class' => 'btn-invisible btn-link',
                        'showOn' => 'edit',
                    ),
                    1 =>
                    array(
                        'type' => 'rowaction',
                        'event' => 'button:save_button:click',
                        'name' => 'save_button',
                        'label' => 'LBL_SAVE_BUTTON_LABEL',
                        'css_class' => 'btn btn-primary',
                        'showOn' => 'edit',
                        'acl_action' => 'edit',
                    ),
                    2 =>
                    array(
                        'type' => 'actiondropdown',
                        'name' => 'main_dropdown',
                        'primary' => true,
                        'showOn' => 'view',
                        'buttons' =>
                        array(
                            0 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:edit_button:click',
                                'name' => 'edit_button',
                                'label' => 'LBL_EDIT_BUTTON_LABEL',
                                'primary' => true,
                                'acl_action' => 'edit',
                            ),
                            1 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:duplicate_button:click',
                                'name' => 'duplicate_button',
                                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                                'acl_module' => 'bc_survey',
                                'acl_action' => 'create',
                                'icon' => 'fa-copy'
                            ),
                            2 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:delete_button:click',
                                'name' => 'delete_button',
                                'label' => 'LBL_DELETE_BUTTON_LABEL',
                                'acl_action' => 'delete',
                                'icon' => 'fa-trash-o',
                            ),
                            3 =>
                            array(
                                'type' => 'divider',
                            ),
                            4 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:manage_email_template:click',
                                'name' => 'manage_email_template',
                                'label' => 'LBL_MANAGE_EMAIL_TEMPLATE',
                                'acl_action' => 'view',
                                'icon' => ' fa-envelope',
                            ),
                            5 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:preview_survey:click',
                                'name' => 'preview_survey',
                                'label' => 'LBL_PREVIEW_SURVEY',
                                'acl_action' => 'view',
                                'icon' => ' fa-eye',
                            ),
                            6 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:view_report:click',
                                'name' => 'view_report',
                                'label' => 'LBL_VIEW_REPORT',
                                'acl_action' => 'view',
                                'icon' => 'fa-line-chart',
                            ),
                            7 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:translate_survey:click',
                                'name' => 'translate_survey',
                                'label' => 'LBL_TRANSLATE_SURVEY_LABEL',
                                'acl_action' => 'delete',
                                'icon' => 'fa-globe',
                            ),
                            8 =>
                            array(
                                'type' => 'divider',
                            ),
                            9 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:export_button:click',
                                'name' => 'export_button',
                                'label' => 'LBL_EXPORT_BUTTON_LABEL',
                                'acl_action' => 'export',
                                'icon' => 'fa-file-pdf-o',
                            ),
                            10 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:export_word_button:click',
                                'name' => 'export_button',
                                'label' => 'LBL_EXPORT_WORD_BUTTON_LABEL',
                                'acl_action' => 'export',
                                'icon' => 'fa-file-word-o',
                            ),
                            11 =>
                            array(
                                'type' => 'divider',
                            ),
                        ),
                    ),
                    3 =>
                    array(
                        'name' => 'sidebar_toggle',
                        'type' => 'sidebartoggle',
                    ),
                ),
                'panels' =>
                array(
                    0 =>
                    array(
                        'name' => 'panel_header',
                        'header' => true,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'picture',
                                'type' => 'avatar',
                                'size' => 'large',
                                'dismiss_label' => true,
                                'readonly' => true,
                            ),
                            1 => 'name',
                            2 =>
                            array(
                                'name' => 'favorite',
                                'label' => 'LBL_FAVORITE',
                                'type' => 'favorite',
                                'dismiss_label' => true,
                            ),
                            3 =>
                            array(
                                'name' => 'follow',
                                'label' => 'LBL_FOLLOW',
                                'type' => 'follow',
                                'readonly' => true,
                                'dismiss_label' => true,
                            ),
                            4 =>
                            array(
                                'name' => 'survey_send_status',
                                'label' => 'LBL_SURVEY_SEND_STATUS',
                                'type' => 'event-status',
                                'readonly' => true,
                                'dismiss_label' => true,
                            ),
                            // Survey Status :: LoadedTech Customization
                            5 =>
                            array(
                                'name' => 'survey_status',
                                'label' => 'LBL_SURVEY_STATUS',
                                'type' => 'custom', //'event-status',
                                'readonly' => true,
                                'dismiss_label' => true,
                            ),
                        // Survey Status :: LoadedTech Customization END
                        ),
                    ),
                    1 =>
                    array(
                        'name' => 'panel_body',
                        'label' => 'LBL_RECORD_BODY',
                        'columns' => 3,
                        'labelsOnTop' => true,
                        'placeholders' => true,
                        'newTab' => false,
                        'panelDefault' => 'collapsed',
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'survey_logo',
                                'studio' => 'visible',
                                'label' => 'LBL_SURVEY_LOGO',
                                'span' => 4,
                            ),
                            1 =>
                            array(
                                'name' => 'survey_background_image',
                                'studio' => 'visible',
                                'label' => 'LBL_SURVEY_BACKGROUND_IMAGE',
                                'span' => 4,
                            ),
                            2 =>
                            array(
                                'name' => 'survey_theme',
                                'studio' => 'visible',
                                'label' => 'LBL_THEME',
                                'span' => 4,
                            ),
                            3 =>
                            array(
                                'name' => 'start_date',
                                'label' => 'LBL_START_DATE',
                                'span' => 6,
                            ),
                            4 =>
                            array(
                                'name' => 'end_date',
                                'label' => 'LBL_END_DATE',
                                'span' => 6,
                            ),
                            5 =>
                            array(
                                'name' => 'description',
                                'span' => 12,
                            ),
                            6 =>
                            array(
                                'name' => 'footer_content',
                                'label' => 'LBL_FOOTER_AREA',
                                'hideLabel' => false,
                                'type' => 'cstm_htmleditable_tinymce',
                                'dismiss_label' => false,
                                'span' => 12,
                            ),
                            7 =>
                            array(
                                'name' => 'allow_redundant_answers',
                                'label' => 'LBL_ALLOW_REDUNDANT_ANSWERS',
                                'span' => 12,
                            ),
                        ),
                    ),
                    2 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'collapsed',
                        'name' => 'LBL_RECORDVIEW_PANEL3',
                        'label' => 'LBL_RECORDVIEW_PANEL3',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'survey_welcome_page',
                                //  'type' => 'htmleditable_tinymce',
                                'label' => 'LBL_WELCOME_PAGE',
                                'hideLabel' => true,
                                'type' => 'cstm_htmleditable_tinymce',
                                'dismiss_label' => true,
                                'span' => 12,
                            ),
                        ),
                    ),
                    3 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'collapsed',
                        'name' => 'LBL_RECORDVIEW_PANEL1',
                        'label' => 'LBL_RECORDVIEW_PANEL1',
                        'columns' => 3,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'enable_data_piping',
                                'span' => 2,
                            ),
                            1 =>
                            array(
                                'name' => 'sync_module',
                                'span' => 5,
                            ),
                            2 =>
                            array(
                                'name' => 'sync_type',
                                'span' => 5,
                            ),
                            3 =>
                            array(
                                'name' => 'surveypages',
                                'dismiss_label' => false,
                                'span' => 12,
                            ),
                        ),
                    ),
                    4 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'collapsed',
                        'name' => 'LBL_RECORDVIEW_PANEL4',
                        'label' => 'LBL_RECORDVIEW_PANEL4',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'survey_thanks_page',
                                'type' => 'cstm_htmleditable_tinymce',
                                'label' => 'LBL_THANKS_PAGE',
                                'span' => 12,
                            ),
                        ),
                    ),
                    5 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'collapsed',
                        'name' => 'LBL_RECORDVIEW_PANEL2',
                        'label' => 'LBL_RECORDVIEW_PANEL2',
                        'columns' => 3,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'redirect_url',
                                'span' => 12,
                            ),
                            1 =>
                            array(
                                'name' => 'allowed_resubmit_count',
                                'studio' => 'visible',
                                'label' => 'LBL_ALLOWED_RESUBMIT_COUNT',
                                'span' => 4,
                            ),
                            2 =>
                            array(
                                'name' => 'is_progress',
                                'studio' => 'visible',
                                'label' => 'LBL_IS_PROGRESS',
                                'span' => 8,
                            ),
                            4 =>
                            array(
                                'name' => 'recursive_email',
                                'label' => 'LBL_RECURSIVE_EMAIL',
                                'span' => 4,
                            ),
                            5 =>
                            array(
                                'name' => 'resend_count',
                                'label' => 'LBL_RESEND_COUNT',
                                'span' => 4,
                            ),
                            6 =>
                            array(
                                'name' => 'resend_interval',
                                'studio' => 'visible',
                                'label' => 'LBL_INTERVAL',
                            ),
                            
                            7 =>
                            array(
                                'name' => 'enable_agreement',
                                'label' => 'LBL_ENABLE_AGREEMENT',
                                'span' => 4,
                            ),
                            8 =>
                            array(
                                'name' => 'is_required_agreement',
                                'label' => 'LBL_IS_REQUIRED_AGREEMENT',
                                'span' => 4,
                            ),
                            9 =>
                            array(
                                'name' => 'agreement_content',
                                'studio' => 'visible',
                                'label' => 'LBL_AGRREMENT_TEXT',
                                'span' => 12,
                            ),
                            
                            
                            10 =>
                            array(
                                'name' => 'enable_review_mail',
                                'label' => 'LBL_ENABLE_REVIEW_MAIL',
                                'span' => 12,
                            ),
                            11 =>
                            array(
                                'name' => 'review_mail_content',
                                'studio' => 'visible',
                                'type' => 'cstm_htmleditable_tinymce',
                                'label' => 'LBL_REVIEW_MAIL_CONTENT',
                                'dismiss_label' => true,
                                'span' => 12,
                            ),
                            12 =>
                            array(
                                'name' => 'survey_type',
                                'label' => 'LBL_SURVEY_TYPE',
                                'dismiss_label' => true,
                                'readonly' => true,
                                'span' => 12,
                            ),
                        ),
                    ),
                    array(
                        'name' => 'panel_hidden',
                        'label' => 'LBL_RECORD_SHOWMORE',
                        'hide' => true,
                        'columns' => 2,
                        'labelsOnTop' => true,
                        'fields' => array(
                            
                            array(
                                'name' => 'date_entered_by',
                                'readonly' => true,
                                'inline' => true,
                                'type' => 'fieldset',
                                'label' => 'LBL_DATE_ENTERED',
                                'fields' => array(
                                    array(
                                        'name' => 'date_entered',
                ),
                                    array(
                                        'type' => 'label',
                                        'default_value' => 'LBL_BY',
                                    ),
                                    array(
                                        'name' => 'created_by_name',
                                    ),
                                ),
                            ),
                            'team_name',
                            array(
                                'name' => 'date_modified_by',
                                'readonly' => true,
                                'inline' => true,
                                'type' => 'fieldset',
                                'label' => 'LBL_DATE_MODIFIED',
                                'fields' => array(
                                    array(
                                        'name' => 'date_modified',
                                    ),
                                    array(
                                        'type' => 'label',
                                        'default_value' => 'LBL_BY',
                                    ),
                                    array(
                                        'name' => 'modified_by_name',
                                    ),
                                ),
                            ),
                            array('name' => 'assigned_user_name', 'span' => 6),
                        ),
                    ),
                ),
                'templateMeta' =>
                array(
                    'useTabs' => false,
                ),
            ),
        ),
    ),
);
