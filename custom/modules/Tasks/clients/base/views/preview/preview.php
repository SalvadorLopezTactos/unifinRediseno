<?php
$viewdefs['Tasks'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'preview' => 
      array (
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
            ),
          ),
          1 => 
          array (
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'ayuda_asesor_cp_c',
                'label' => 'LBL_AYUDA_ASESOR_CP',
              ),
              1 => 
              array (
              ),
              2 => 'date_start',
              3 => 'priority',
              4 => 'date_due',
              5 => 'status',
              6 => 'assigned_user_name',
              7 => 'parent_name',
              8 => 
              array (
                'name' => 'tasks_opportunities_1_name',
              ),
              9 => 
              array (
                'name' => 'potencial_negocio_c',
                'label' => 'LBL_POTENCIAL_NEGOCIO',
              ),
              10 => 
              array (
                'name' => 'motivo_potencial_c',
                'label' => 'LBL_MOTIVO_POTENCIAL',
              ),
              11 => 
              array (
                'name' => 'detalle_motivo_potencial_c',
                'label' => 'LBL_DETALLE_MOTIVO_POTENCIAL',
              ),
              12 => 
              array (
                'name' => 'fecha_calificacion_c',
                'label' => 'LBL_FECHA_CALIFICACION',
              ),
              13 => 
              array (
                'name' => 'solicitud_alta_c',
                'label' => 'LBL_SOLICITUD_ALTA',
              ),
            ),
          ),
          2 => 
          array (
            'name' => 'panel_hidden',
            'label' => 'LBL_RECORD_SHOWMORE',
            'hide' => true,
            'columns' => 2,
            'labelsOnTop' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'description',
                'span' => 12,
              ),
              1 => 
              array (
                'name' => 'date_entered_by',
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
              2 => 
              array (
                'name' => 'date_modified_by',
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
            ),
          ),
        ),
        'templateMeta' => 
        array (
          'maxColumns' => 1,
        ),
      ),
    ),
  ),
);
