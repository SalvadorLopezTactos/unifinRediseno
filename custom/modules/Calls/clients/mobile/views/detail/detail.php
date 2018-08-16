<?php
$viewdefs['Calls'] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'detail' => 
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
              0 => 
              array (
                'name' => 'name',
                'displayParams' => 
                array (
                  'required' => true,
                  'wireless_edit_only' => true,
                ),
              ),
              1 => 'date_start',
              2 => 'direction',
              3 => 'status',
              4 => 
              array (
                'name' => 'duration',
                'type' => 'fieldset',
                'orientation' => 'horizontal',
                'related_fields' => 
                array (
                  0 => 'duration_hours',
                  1 => 'duration_minutes',
                ),
                'label' => 'LBL_DURATION',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'duration_hours',
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default' => 'LBL_HOURS_ABBREV',
                    'css_class' => 'label_duration_hours hide',
                  ),
                  2 => 
                  array (
                    'name' => 'duration_minutes',
                  ),
                  3 => 
                  array (
                    'type' => 'label',
                    'default' => 'LBL_MINSS_ABBREV',
                    'css_class' => 'label_duration_minutes hide',
                  ),
                ),
              ),
              5 => 'description',
              6 => 'parent_name',
              7 => 'assigned_user_name',
              8 => 
              array (
                'name' => 'tct_resultado_llamada_ddw_c',
                'label' => 'LBL_TCT_RESULTADO_LLAMADA_DDW',
              ),
              9 => 
              array (
                'name' => 'tct_motivo_ilocalizable_ddw_c',
                'label' => 'LBL_TCT_MOTIVO_ILOCALIZABLE_DDW',
              ),
              10 => 
              array (
                'name' => 'tct_fecha_cita_dat_c',
                'label' => 'LBL_TCT_FECHA_CITA_DAT',
              ),
              11 => 
              array (
                'name' => 'tct_usuario_cita_rel_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_USUARIO_CITA_REL',
              ),
              12 => 
              array (
                'name' => 'tct_fecha_seguimiento_dat_c',
                'label' => 'LBL_TCT_FECHA_SEGUIMIENTO_DAT',
              ),
              13 => 
              array (
                'name' => 'tct_motivo_desinteres_ddw_c',
                'label' => 'LBL_TCT_MOTIVO_DESINTERES_DDW',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
