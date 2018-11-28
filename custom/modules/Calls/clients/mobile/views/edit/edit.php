<?php
$viewdefs['Calls'] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'edit' => 
      array (
        'templateMeta' => 
        array (
          'maxColumns' => '1',
          'widths' => 
          array (
            0 => 
            array (
              'label' => '10',
              'field' => '30',
            ),
          ),
          'useTabs' => false,
        ),
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_PANEL_DEFAULT',
            'columns' => '1',
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 'name',
              1 => 'status',
              2 => 
              array (
                'name' => 'date',
                'type' => 'fieldset',
                'related_fields' => 
                array (
                  0 => 'date_start',
                  1 => 'date_end',
                ),
                'label' => 'LBL_START_AND_END_DATE_DETAIL_VIEW',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_start',
                  ),
                  1 => 
                  array (
                    'name' => 'date_end',
                    'required' => true,
                    'readonly' => false,
                  ),
                ),
              ),
              3 => 
              array (
                'name' => 'reminder',
                'type' => 'fieldset',
                'orientation' => 'horizontal',
                'related_fields' => 
                array (
                  0 => 'reminder_checked',
                  1 => 'reminder_time',
                ),
                'label' => 'LBL_REMINDER',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'reminder_checked',
                  ),
                  1 => 
                  array (
                    'name' => 'reminder_time',
                    'type' => 'enum',
                    'options' => 'reminder_time_options',
                  ),
                ),
              ),
              4 => 
              array (
                'name' => 'email_reminder',
                'type' => 'fieldset',
                'orientation' => 'horizontal',
                'related_fields' => 
                array (
                  0 => 'email_reminder_checked',
                  1 => 'email_reminder_time',
                ),
                'label' => 'LBL_EMAIL_REMINDER',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'email_reminder_checked',
                  ),
                  1 => 
                  array (
                    'name' => 'email_reminder_time',
                    'type' => 'enum',
                    'options' => 'reminder_time_options',
                  ),
                ),
              ),
              5 => 'direction',
              6 => 'description',
              7 => 
              array (
                'name' => 'tct_related_person_txf_c',
                'label' => 'LBL_TCT_RELATED_PERSON_TXF',
                'css_class' => 'related_person',
              ),
              8 => 'assigned_user_name',
              9 => 
              array (
                'name' => 'tct_resultado_llamada_ddw_c',
                'label' => 'LBL_TCT_RESULTADO_LLAMADA_DDW',
              ),
              10 => 
              array (
                'name' => 'tct_motivo_ilocalizable_ddw_c',
                'label' => 'LBL_TCT_MOTIVO_ILOCALIZABLE_DDW',
              ),
              11 => 
              array (
                'name' => 'tct_fecha_cita_dat_c',
                'label' => 'LBL_TCT_FECHA_CITA_DAT',
              ),
              12 => 
              array (
                'name' => 'tct_usuario_cita_rel_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_USUARIO_CITA_REL',
              ),
              13 => 
              array (
                'name' => 'tct_fecha_seguimiento_dat_c',
                'label' => 'LBL_TCT_FECHA_SEGUIMIENTO_DAT',
              ),
              14 => 
              array (
                'name' => 'tct_motivo_desinteres_ddw_c',
                'label' => 'LBL_TCT_MOTIVO_DESINTERES_DDW',
              ),
              15 => 'parent_name',
            ),
          ),
        ),
      ),
    ),
  ),
);
