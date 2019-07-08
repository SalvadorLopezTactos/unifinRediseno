<?php
$viewdefs['bc_survey_submission'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'record' => 
      array (
        'buttons' => 
        array (
          2 => 
          array (
            'type' => 'actiondropdown',
            'name' => 'main_dropdown',
            'primary' => true,
            'showOn' => 'view',
            'buttons' => 
            array (
              1 => 
              array (
              ),
            ),
          ),
          3 => 
          array (
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
          ),
        ),
        'panels' => 
        array (
          0 => 
          array (
            'name' => 'panel_header',
            'header' => true,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'picture',
                'type' => 'avatar',
                'size' => 'large',
                'dismiss_label' => true,
                'readonly' => true,
              ),
              1 => 'customer_name',
            ),
          ),
          1 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL2',
            'label' => 'LBL_RECORDVIEW_PANEL2',
            'columns' => 3,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'bc_survey_submission_bc_survey_name',
                'label' => 'LBL_BC_SURVEY_SUBMISSION_BC_SURVEY_FROM_BC_SURVEY_TITLE',
                'span' => 12,
              ),
              1 => 
              array (
                'name' => 'survey_send',
                'span' => 4,
              ),
              2 => 
              array (
                'name' => 'email_opened',
                'span' => 4,
              ),
              3 => 
              array (
                'name' => 'status',
                'span' => 4,
              ),
              4 => 
              array (
                'name' => 'schedule_on',
                'label' => 'LBL_SCHEDULE_ON',
                'span' => 4,
              ),
              5 => 
              array (
                'name' => 'last_send_on',
                'span' => 4,
              ),
              6 => 
              array (
                'name' => 'submission_date',
                'label' => 'LBL_SUBMISSION_DATE',
                'span' => 4,
              ),
              7 => 
              array (
                'name' => 'mail_status',
                'label' => 'LBL_MAIL_STATUS',
                'span' => 6,
              ),
              8 => 
              array (
                'span' => 6,
              ),
            ),
          ),
          2 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL4',
            'label' => 'LBL_RECORDVIEW_PANEL4',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'change_request',
                'span' => 6,
              ),
              1 => 
              array (
                'span' => 6,
              ),
              2 => 
              array (
                'name' => 'resend',
                'label' => 'LBL_RESEND',
              ),
              3 => 
              array (
                'name' => 'resend_counter',
              ),
              4 => 
              array (
                'name' => 'resubmit',
                'label' => 'LBL_RESUBMIT',
              ),
              5 => 
              array (
                'name' => 'resubmit_counter',
                'span' => 6,
              ),
            ),
          ),
          3 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL1',
            'label' => 'LBL_RECORDVIEW_PANEL1',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'submitted_by',
                'span' => 6,
              ),
              1 => 
              array (
                'name' => 'submission_type',
                'studio' => true,
                'label' => 'LBL_SUBMISSION_TYPE',
                'span' => 6,
              ),
            ),
          ),
          4 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL3',
            'label' => 'LBL_RECORDVIEW_PANEL3',
            'columns' => 3,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'base_score',
                'span' => 4,
              ),
              1 => 
              array (
                'name' => 'obtained_score',
                'span' => 4,
              ),
              2 => 
              array (
                'name' => 'score_percentage',
                'span' => 4,
              ),
            ),
          ),
        ),
        'templateMeta' => 
        array (
          'useTabs' => false,
        ),
      ),
    ),
  ),
);
