<?php
$viewdefs['Meetings'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'record' => 
      array (
        'buttons' => 
        array (
          1 => 
          array (
            'type' => 'button',
            'name' => 'cancel_button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
            'showOn' => 'edit',
            'events' => 
            array (
              'click' => 'button:cancel_button:click',
            ),
          ),
          2 => 
          array (
            'type' => 'actiondropdown',
            'name' => 'save_dropdown',
            'primary' => true,
            'switch_on_click' => true,
            'showOn' => 'edit',
            'buttons' => 
            array (
              0 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:save_button:click',
                'name' => 'save_button',
                'label' => 'LBL_SAVE_BUTTON_LABEL',
                'css_class' => 'btn btn-primary',
                'acl_action' => 'edit',
              ),
              1 => 
              array (
                'type' => 'save-and-send-invites-button',
                'event' => 'button:save_button:click',
                'name' => 'save_invite_button',
                'label' => 'LBL_SAVE_AND_SEND_INVITES_BUTTON',
                'acl_action' => 'edit',
              ),
            ),
          ),
          3 => 
          array (
            'type' => 'actiondropdown',
            'name' => 'main_dropdown',
            'primary' => true,
            'showOn' => 'view',
            'buttons' => 
            array (
              0 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:edit_button:click',
                'name' => 'edit_button',
                'label' => 'LBL_EDIT_BUTTON_LABEL',
                'acl_action' => 'edit',
              ),
              1 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:new_minuta_b:click',
                'name' => 'new_minuta',
                'label' => 'LBL_CREATE_NEW_MINUTA',
                'acl_action' => 'edit',
              ),
              2 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:getlocation:click',
                'name' => 'check_in1',
                'label' => 'LBL_CHECK_IN_LABEL',
                'acl_action' => 'edit',
              ),
            ),
          ),
          4 => 
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
              1 => 'name',
              2 => 
              array (
                'name' => 'favorite',
                'label' => 'LBL_FAVORITE',
                'type' => 'favorite',
                'readonly' => true,
                'dismiss_label' => true,
              ),
              3 => 
              array (
                'name' => 'follow',
                'label' => 'LBL_FOLLOW',
                'type' => 'follow',
                'readonly' => true,
                'dismiss_label' => true,
              ),
              4 => 
              array (
                'name' => 'status',
              ),
            ),
          ),
          1 => 
          array (
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => true,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'duration',
                'type' => 'duration',
                'label' => 'LBL_START_AND_END_DATE_DETAIL_VIEW',
                'dismiss_label' => true,
                'inline' => true,
                'show_child_labels' => true,
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_start',
                    'time' => 
                    array (
                      'step' => 15,
                    ),
                    'readonly' => false,
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default_value' => 'LBL_START_AND_END_DATE_TO',
                  ),
                  2 => 
                  array (
                    'name' => 'date_end',
                    'time' => 
                    array (
                      'step' => 15,
                      'duration' => 
                      array (
                        'relative_to' => 'date_start',
                      ),
                    ),
                    'readonly' => false,
                  ),
                ),
                'related_fields' => 
                array (
                  0 => 'duration_hours',
                  1 => 'duration_minutes',
                ),
                'span' => 9,
              ),
              1 => 
              array (
                'name' => 'repeat_type',
                'related_fields' => 
                array (
                  0 => 'repeat_parent_id',
                ),
                'span' => 3,
              ),
              2 => 
              array (
                'name' => 'recurrence',
                'type' => 'recurrence',
                'inline' => true,
                'show_child_labels' => true,
                'fields' => 
                array (
                  0 => 
                  array (
                    'label' => 'LBL_CALENDAR_REPEAT_INTERVAL',
                    'name' => 'repeat_interval',
                    'type' => 'enum',
                    'options' => 'repeat_interval_number',
                    'required' => true,
                    'default' => 1,
                  ),
                  1 => 
                  array (
                    'label' => 'LBL_CALENDAR_REPEAT_DOW',
                    'name' => 'repeat_dow',
                    'type' => 'repeat-dow',
                    'options' => 'dom_cal_day_of_week',
                    'isMultiSelect' => true,
                  ),
                  2 => 
                  array (
                    'label' => 'LBL_CALENDAR_CUSTOM_DATE',
                    'name' => 'repeat_selector',
                    'type' => 'enum',
                    'options' => 'repeat_selector_dom',
                    'default' => 'None',
                  ),
                  3 => 
                  array (
                    'name' => 'repeat_days',
                    'type' => 'repeat-days',
                    'options' => 
                    array (
                      '' => '',
                    ),
                    'isMultiSelect' => true,
                    'dropdown_class' => 'recurring-date-dropdown',
                    'container_class' => 'recurring-date-container select2-choices-pills-close',
                  ),
                  4 => 
                  array (
                    'label' => ' ',
                    'name' => 'repeat_ordinal',
                    'type' => 'enum',
                    'options' => 'repeat_ordinal_dom',
                  ),
                  5 => 
                  array (
                    'label' => ' ',
                    'name' => 'repeat_unit',
                    'type' => 'enum',
                    'options' => 'repeat_unit_dom',
                  ),
                  6 => 
                  array (
                    'label' => 'LBL_CALENDAR_REPEAT',
                    'name' => 'repeat_end_type',
                    'type' => 'enum',
                    'options' => 'repeat_end_types',
                    'default' => 'Until',
                  ),
                  7 => 
                  array (
                    'label' => 'LBL_CALENDAR_REPEAT_UNTIL_DATE',
                    'name' => 'repeat_until',
                    'type' => 'repeat-until',
                  ),
                  8 => 
                  array (
                    'label' => 'LBL_CALENDAR_REPEAT_COUNT',
                    'name' => 'repeat_count',
                    'type' => 'repeat-count',
                  ),
                ),
                'span' => 12,
              ),
              3 => 'location',
              4 => 
              array (
                'name' => 'reminders',
                'type' => 'fieldset',
                'inline' => true,
                'equal_spacing' => true,
                'show_child_labels' => true,
                'fields' => 
                array (
                  0 => 'reminder_time',
                  1 => 'email_reminder_time',
                ),
              ),
              5 => 
              array (
                'name' => 'description',
                'rows' => 3,
                'span' => 12,
              ),
              6 => 
              array (
                'name' => 'parent_name',
                'span' => 12,
              ),
              7 => 
              array (
                'name' => 'invitees',
                'type' => 'participants',
                'label' => 'LBL_INVITEES',
                'fields' => 
                array (
                  0 => 'name',
                  1 => 'accept_status_meetings',
                  2 => 'picture',
                  3 => 'email',
                ),
                'related_fields' => 
                array (
                  0 => 'date_start',
                  1 => 'date_end',
                  2 => 'duration_hours',
                  3 => 'duration_minutes',
                ),
                'span' => 12,
              ),
              8 => 
              array (
                'name' => 'assigned_user_name',
              ),
              9 => 
              array (
              ),
              10 => 
              array (
                'name' => 'objetivo_c',
                'label' => 'LBL_OBJETIVO_C',
              ),
              11 => 
              array (
                'name' => 'resultado_c',
                'label' => 'LBL_RESULTADO_C',
              ),
              12 => 
              array (
                'name' => 'referenciada_c',
                'label' => 'LBL_REFERENCIADA_C',
              ),
            ),
          ),
          2 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL1',
            'label' => 'LBL_RECORDVIEW_PANEL1',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'reunion_objetivos',
                'studio' => 'visible',
                'label' => 'reunion_objetivos',
                'span' => 12,
              ),
            ),
          ),
          3 => 
          array (
            'name' => 'panel_hidden',
            'label' => 'LBL_RECORD_SHOWMORE',
            'columns' => 2,
            'hide' => true,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'minut_minutas_meetings_name',
                'label' => 'LBL_MINUT_MINUTAS_MEETINGS_FROM_MINUT_MINUTAS_TITLE',
              ),
              1 => 
              array (
              ),
              2 => 
              array (
                'name' => 'date_entered_by',
                'readonly' => true,
                'inline' => true,
                'type' => 'fieldset',
                'label' => 'LBL_DATE_MODIFIED',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_modified',
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default_value' => 'LBL_BY',
                  ),
                  2 => 
                  array (
                    'name' => 'modified_by_name',
                  ),
                ),
              ),
              3 => 
              array (
                'name' => 'date_modified_by',
                'readonly' => true,
                'inline' => true,
                'type' => 'fieldset',
                'label' => 'LBL_DATE_ENTERED',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_entered',
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default_value' => 'LBL_BY',
                  ),
                  2 => 
                  array (
                    'name' => 'created_by_name',
                  ),
                ),
              ),
            ),
          ),
          4 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL2',
            'label' => 'LBL_RECORDVIEW_PANEL2',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'check_in_longitude_c',
                'label' => 'LBL_CHECK_IN_LONGITUDE',
              ),
              1 => 
              array (
                'name' => 'check_in_latitude_c',
                'label' => 'LBL_CHECK_IN_LATITUDE',
              ),
              2 => 
              array (
                'name' => 'check_in_address_c',
                'label' => 'LBL_CHECK_IN_ADDRESS',
              ),
              3 => 
              array (
                'name' => 'check_in_time_c',
                'label' => 'LBL_CHECK_IN_TIME_C',
              ),
              4 => 
              array (
                'name' => 'check_out_longitude_c',
                'label' => 'LBL_CHECK_OUT_LONGITUDE_C',
              ),
              5 => 
              array (
                'name' => 'check_out_latitude_c',
                'label' => 'LBL_CHECK_OUT_LATITUDE_C',
              ),
              6 => 
              array (
                'name' => 'check_out_address_c',
                'label' => 'LBL_CHECK_OUT_ADDRESS_C',
              ),
              7 => 
              array (
                'name' => 'check_out_time_c',
                'label' => 'LBL_CHECK_OUT_TIME_C',
              ),
            ),
          ),
        ),
        'templateMeta' => 
        array (
          'useTabs' => true,
        ),
      ),
    ),
  ),
);
