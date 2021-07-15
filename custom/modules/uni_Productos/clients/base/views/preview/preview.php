<?php
$module_name = 'uni_Productos';
$viewdefs[$module_name] = 
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
            'label' => 'LBL_RECORD_HEADER',
            'header' => true,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'picture',
                'type' => 'avatar',
                'width' => 42,
                'height' => 42,
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
            'newTab' => true,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'no_viable',
                'label' => 'LBL_NO_VIABLE',
              ),
              1 => 
              array (
                'name' => 'multilinea_c',
                'label' => 'LBL_MULTILINEA_C',
              ),
              2 => 
              array (
                'name' => 'tipo_producto',
                'label' => 'LBL_TIPO_PRODUCTO',
              ),
              3 => 
              array (
                'name' => 'no_viable_razon',
                'label' => 'LBL_NO_VIABLE_RAZON',
              ),
              4 => 
              array (
                'name' => 'no_viable_razon_fp',
                'label' => 'LBL_NO_VIABLE_RAZON_FP',
              ),
              5 => 
              array (
                'name' => 'no_viable_razon_ni',
                'label' => 'LBL_NO_VIABLE_RAZON_NI',
              ),
              6 => 
              array (
                'name' => 'no_viable_producto',
                'label' => 'LBL_NO_VIABLE_PRODUCTO',
              ),
              7 => 
              array (
                'name' => 'no_viable_otro_c',
                'label' => 'LBL_NO_VIABLE_OTRO',
              ),
              8 => 
              array (
                'name' => 'no_viable_quien',
                'label' => 'LBL_NO_VIABLE_QUIEN',
              ),
              9 => 
              array (
                'name' => 'no_viable_porque',
                'label' => 'LBL_NO_VIABLE_PORQUE',
              ),
              10 => 
              array (
                'name' => 'tipo_cuenta',
                'label' => 'LBL_TIPO_CUENTA',
              ),
              11 => 
              array (
                'name' => 'subtipo_cuenta',
                'label' => 'LBL_SUBTIPO_CUENTA',
              ),
              12 => 
              array (
                'name' => 'tipo_subtipo_cuenta',
                'label' => 'LBL_TIPO_SUBTIPO_CUENTA',
              ),
              13 => 
              array (
              ),
              14 => 
              array (
                'name' => 'anexos_activos',
                'label' => 'LBL_ANEXOS_ACTIVOS',
              ),
              15 => 
              array (
                'name' => 'anexos_historicos',
                'label' => 'LBL_ANEXOS_HISTORICOS',
              ),
              16 => 
              array (
                'name' => 'no_viable_razon_cf',
                'label' => 'LBL_NO_VIABLE_RAZON_CF',
              ),
              17 => 
              array (
                'name' => 'estatus_atencion',
                'label' => 'LBL_ESTATUS_ATENCION',
              ),
              18 => 
              array (
                'name' => 'fecha_pago',
                'label' => 'LBL_FECHA_PAGO',
              ),
              19 => 
              array (
                'name' => 'fecha_termino',
                'label' => 'LBL_FECHA_TERMINO',
              ),
              20 => 
              array (
                'name' => 'fecha_impago',
                'label' => 'LBL_FECHA_IMPAGO',
              ),
              21 => 
              array (
                'name' => 'fecha_liberacion',
                'label' => 'LBL_FECHA_LIBERACION',
              ),
              22 => 
              array (
                'name' => 'monto_impago',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_MONTO_IMPAGO',
              ),
              23 => 
              array (
                'name' => 'nps_calificacion',
                'label' => 'LBL_NPS_CALIFICACION',
              ),
              24 => 
              array (
                'name' => 'nps_comentario',
                'studio' => 'visible',
                'label' => 'LBL_NPS_COMENTARIO',
              ),
              25 => 
              array (
                'name' => 'nps_fecha',
                'label' => 'LBL_NPS_FECHA',
              ),
              26 => 
              array (
                'name' => 'accounts_uni_productos_1_name',
              ),
              27 => 
              array (
                'name' => 'fecha_asignacion_c',
                'label' => 'LBL_FECHA_ASIGNACION_C',
              ),
              28 => 
              array (
                'name' => 'status_management_c',
                'label' => 'LBL_STATUS_MANAGEMENT',
              ),
              29 => 
              array (
              ),
            ),
          ),
          2 => 
          array (
            'name' => 'panel_hidden',
            'label' => 'LBL_SHOW_MORE',
            'hide' => true,
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => true,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 'assigned_user_name',
              1 => 'team_name',
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
              3 => 
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
