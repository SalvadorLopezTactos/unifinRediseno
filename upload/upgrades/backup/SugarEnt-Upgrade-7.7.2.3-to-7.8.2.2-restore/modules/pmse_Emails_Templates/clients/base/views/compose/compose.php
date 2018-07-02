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

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


$viewdefs['pmse_Emails_Templates']['base']['view']['compose'] = array(
    'template' => 'record',
    'buttons' => array(
        array(
            'type'      => 'button',
            'name'      => 'cancel_button',
            'label'     => 'LBL_CANCEL_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
        ),
        array(
            'type'    => 'actiondropdown',
            'name'    => 'main_dropdown',
            'primary' => true,
            'buttons' => array(
                array(
                    'type'   => 'rowaction',
                    'name'   => 'save_button',
                    'label'  => 'LBL_SAVE_BUTTON_LABEL',
                ),
                array(
                    'type'  => 'rowaction',
                    'name'  => 'save_buttonExit',
                    'label' => 'LBL_PMSE_SAVE_EXIT_BUTTON_LABEL',
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
                    'name'           => 'lbl_base_module',
                    'type'           => 'readonly',
                    'label'          => 'LBL_BASE_MODULE',
                    'span'           => 12,
                ),
                array(
                    'name'            => 'name',
                    'label'           => 'LBL_NAME',
                    'span'            => 12,
                ),
                array(
                    'name'            => 'description',
                    'label'           => 'LBL_DESCRIPTION',
                    'span'            => 12,
                ),
                array(
                    'name'            => 'subject',
                    'type'            => 'subject',
                    'label'           => 'LBL_SUBJECT',
                    'span'            => 12,
                    'cell_css_class'  => 'btn-fit',
                    'required'        => true,
                    'label_css_class' => 'end-fieldgroup',
                ),
                array(
                    'name'          => 'body_html',
                    'type'          => 'pmse_htmleditable_tinymce',
                    'dismiss_label' => true,
                    'span'          => 12,
                    'tinyConfig'    => array(
                        // Location of TinyMCE script
                        'script_url'                        => 'include/javascript/tiny_mce/tiny_mce.js',
                        'height'                            => '100%',
                        'width'                             => '100%',
                        // General options
                        'theme'                             => 'advanced',
                        'skin'                              => 'sugar7',
                        'plugins'                           => 'style,paste,inlinepopups',
                        'entity_encoding'                   => 'raw',
                        'forced_root_block'                 => false,
                        // Theme options
                        'theme_advanced_buttons1'           => "code,separator,bold,italic,underline,strikethrough,separator,bullist,numlist,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,forecolor,backcolor,separator,fontsizeselect,mybutton,sugarlinkbutton",
                        'theme_advanced_toolbar_location'   => "top",
                        'theme_advanced_toolbar_align'      => "left",
                        'theme_advanced_statusbar_location' => "none",
                        'theme_advanced_resizing'           => false,
                        'schema'                            => 'html5',
                        'template_external_list_url'        => 'lists/template_list.js',
                        'external_link_list_url'            => 'lists/link_list.js',
                        'external_image_list_url'           => 'lists/image_list.js',
                        'media_external_list_url'           => 'lists/media_list.js',
                        'theme_advanced_path'               => false,
                        'theme_advanced_source_editor_width'=> 500,
                        'theme_advanced_source_editor_height'=> 400,
                        'inlinepopups_skin'                 => 'sugar7modal',

                        //Url options for links
                        'relative_urls'                     => false,
                        'remove_script_host'                => false,
                    ),
                ),
            ),
        ),

    ),
);
