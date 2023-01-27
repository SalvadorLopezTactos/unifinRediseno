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
$viewdefs['base']['view']['stage2-preview'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'labels' => false,
            'fields' => array(
                array(
                    'name' => 'hint_photo',
                    'type' => 'stage2_image',
                    'size' => 'large',
                    'dismiss_label' => true,
                    'readonly' => true,
                ),
                array(
                    'name' => 'full_name',
                    'type' => 'fullname',
                    'label' => 'LBL_NAME',
                    'dismiss_label' => true,
                    'fields' => array(
                        'first_name',
                        'last_name',
                    ),
                ),
                array(
                    'name' => 'title',
                    'type' => 'text',
                    'dismiss_label' => true,
                    'fields' => array(
                        'title',
                    ),
                ),
            ),
        ),
        array(
            'name' => 'contacts_basic',
            'columns' => 1,
            'labels' => true,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'phone_work',
                    'label' => "LBL_LIST_PHONE",
                ),
                array(
                    'name' => 'phone_mobile',
                    'label' => 'LBL_MOBILE_PHONE',
                ),
                array(
                    'name' => 'phone_other',
                    'label' => 'LBL_OTHER_PHONE',
                ),
                array(
                    'name' => 'email',
                    'label' => 'LBL_LIST_EMAIL_ADDRESS',
                ),
            ),
        ),
        array(
            'name' => 'contacts_extended',
            'hide' => true,
            'fields' => array(
                array(
                    'name' => 'hint_education',
                    'label' => 'LBL_HINT_EDUCATION',
                ),
                array(
                    'name' => 'hint_education_2',
                    'type' => 'text',
                    'label' => 'LBL_HINT_EDUCATION_2',
                    'dismiss_label' => true,
                    'fields' => array(
                        'hint_education_2',
                    ),
                ),
                array(
                    'name' => 'hint_job_2',
                    'label' => 'LBL_HINT_JOB_2',
                ),

                array(
                    'name' => 'hint_facebook',
                    'type' => 'stage2_url',
                    'label' => 'LBL_HINT_FACEBOOK',
                ),
                array(
                    'name' => 'hint_twitter',
                    'type' => 'stage2_url',
                    'label' => 'LBL_HINT_TWITTER',
                ),
            ),
        ),

        array(
            'name' => 'company_header',
            'labels' => false,
            'fields' => array(
                array (
                    'name' => 'hint_account_logo',
                    'type' => 'stage2_image',
                    'label' => 'LBL_HINT_COMPANY_LOGO',
                    'dismiss_label' => true,
                    'fields' => array(
                        'hint_account_logo',
                    ),
                ),
                array(
                    'name' => 'account_name',
                    'type' => 'text',
                    'dismiss_label' => true,
                    'fields' => array(
                        'account_name',
                    ),
                ),
                array(
                    'name' => 'hint_account_website',
                    'type' => 'stage2_url',
                    'dismiss_label' => true,
                    'fields' => array(
                        'hint_account_website',
                    ),
                ),
            ),
        ),
        array(
            'name' => 'company_info',
            'columns' => 1,
            'labels' => true,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'hint_account_size',
                    'label' => 'LBL_HINT_COMPANY_SIZE',
                ),
                array(
                    'name' => 'hint_account_industry',
                    'label' => 'LBL_HINT_COMPANY_INDUSTRY',
                ),
                array(
                    'name' => 'hint_account_location',
                    'label' => 'LBL_HINT_COMPANY_LOCATION',
                ),
                array(
                    'name' => 'hint_account_annual_revenue',
                    'label' => 'LBL_HINT_COMPANY_ANNUAL_REVENUE',
                ),
                array(
                    'name' => 'hint_account_description',
                    'label' => 'LBL_HINT_COMPANY_DESCRIPTION',
                ),
            ),
        ),
        array(
            'name' => 'company_extended',
            'hide' => true,
            'fields' => array(
                array(
                    'name' => 'hint_account_naics_code_lbl',
                    'label' => 'LBL_HINT_COMPANY_NAICS_CODE_LABEL',
                ),
                array(
                    'name' => 'hint_account_sic_code_label',
                    'label' => 'LBL_HINT_COMPANY_SIC_CODE_LABEL',
                ),
                array(
                    'name' => 'hint_account_fiscal_year_end',
                    'label' => 'LBL_HINT_COMPANY_FISCAL_YEAR_END',
                ),
                array(
                    'name' => 'hint_account_founded_year',
                    'label' => 'LBL_HINT_COMPANY_FOUNDED_YEAR',
                ),
                array(
                    'name' => 'hint_account_facebook_handle',
                    'type' => 'stage2_url',
                    'label' => 'LBL_HINT_COMPANY_FACEBOOK',
                ),
                array(
                    'name' => 'hint_account_twitter_handle',
                    'type' => 'stage2_url',
                    'label' => 'LBL_HINT_COMPANY_TWITTER',
                ),
                array(
                    'name' => 'hint_industry_tags',
                    'label' => 'LBL_HINT_COMPANY_INDUSTRY_TAGS',
                ),
            ),
        ),
    ),
);
