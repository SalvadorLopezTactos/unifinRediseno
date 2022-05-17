<?php
// created: 2018-02-16 17:27:02
$viewdefs['lev_Backlog']['base']['view']['record'] = array (
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
          'name' => 'region',
          'studio' => 'visible',
          'label' => 'LBL_REGION',
        ),
        1 => 
        array (
          'name' => 'tipo',
          'studio' => 'visible',
          'label' => 'LBL_TIPO',
        ),
        2 => 'assigned_user_name',
        3 => 
        array (
          'name' => 'producto',
          'studio' => 'visible',
          'label' => 'LBL_PRODUCTO',
        ),
        4 => 
        array (
          'name' => 'lev_backlog_opportunities_name',
        ),
        5 => 
        array (
          'name' => 'cliente',
          'studio' => 'visible',
          'label' => 'LBL_CLIENTE',
        ),
        6 => 
        array (
          'name' => 'activo',
          'studio' => 'visible',
          'label' => 'LBL_ACTIVO',
        ),
        7 => 
        array (
          'name' => 'equipo',
          'studio' => 'visible',
          'label' => 'LBL_EQUIPO',
        ),
        8 => 
        array (
          'name' => 'monto_original',
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'label' => 'LBL_MONTO_ORIGINAL',
        ),
        9 => 
        array (
        ),
        10 => 
        array (
          'name' => 'monto_comprometido',
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'label' => 'LBL_MONTO_COMPROMETIDO',
        ),
        11 => 
        array (
          'name' => 'monto_real_logrado',
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'label' => 'LBL_MONTO_REAL_LOGRADO',
        ),
        12 => 
        array (
          'name' => 'porciento_ri',
          'label' => 'LBL_PORCIENTO_RI',
        ),
        13 => 
        array (
          'name' => 'renta_inicial_comprometida',
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'label' => 'LBL_RENTA_INICIAL_COMPROMETIDA',
        ),
        14 => 
        array (
          'name' => 'renta_inicial_real',
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'label' => 'LBL_RENTA_INICIAL_REAL',
        ),
        15 => 
        array (
          'name' => 'progreso',
          'studio' => 'visible',
          'label' => 'LBL_PROGRESO',
        ),
        16 => 
        array (
          'name' => 'etapa_preliminar',
          'studio' => 'visible',
          'label' => 'LBL_ETAPA_PRELIMINAR',
        ),
        17 => 
        array (
          'name' => 'etapa',
          'studio' => 'visible',
          'label' => 'LBL_ETAPA',
        ),
        18 => 
        array (
          'name' => 'mes',
          'studio' => 'visible',
          'label' => 'LBL_MES',
        ),
        19 => 
        array (
          'name' => 'anio',
          'studio' => 'visible',
          'label' => 'LBL_ANIO',
        ),
        20 => 
        array (
          'name' => 'comentario',
          'studio' => 'visible',
          'label' => 'LBL_COMENTARIO',
          'span' => 12,
        ),
        21 => 
        array (
          'name' => 'description',
          'span' => 12,
        ),
        22 => 
        array (
          'name' => 'numero_de_backlog',
          'label' => 'LBL_NUMERO_DE_BACKLOG',
        ),
        23 => 
        array (
          'name' => 'numero_de_solicitud',
          'label' => 'LBL_NUMERO_DE_SOLICITUD',
        ),
        24 => 
        array (
          'name' => 'estatus_de_la_operacion',
          'studio' => 'visible',
          'label' => 'LBL_ESTATUS_DE_LA_OPERACION',
        ),
        25 => 
        array (
          'name' => 'tipo_de_operacion',
          'studio' => 'visible',
          'label' => 'LBL_TIPO_DE_OPERACION',
        ),
        26 => 
        array (
          'name' => 'motivo_de_cancelacion',
          'studio' => 'visible',
          'label' => 'LBL_MOTIVO_DE_CANCELACION',
        ),
        27 => 
        array (
        ),
        28 => 
        array (
          'name' => 'monto_comprometido_cancelado',
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'label' => 'LBL_MONTO_COMPROMETIDO_CANCELADO',
        ),
        29 => 
        array (
          'name' => 'renta_inicialcomp_can',
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'label' => 'LBL_RENTA_INICIALCOMP_CAN',
        ),
        30 => 
        array (
          'name' => 'tag',
          'span' => 12,
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
      'newTab' => false,
      'panelDefault' => 'expanded',
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'date_modified_by',
          'readonly' => true,
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
        1 => 
        array (
          'name' => 'date_entered_by',
          'readonly' => true,
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
          'name' => 'editar',
          'label' => 'LBL_EDITAR',
        ),
        3 => 
        array (
        ),
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'useTabs' => false,
  ),
);