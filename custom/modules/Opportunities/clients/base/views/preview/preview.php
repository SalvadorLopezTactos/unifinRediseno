<?php
// created: 2024-05-21 12:55:59
$viewdefs['Opportunities']['base']['view']['preview'] = array (
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
        1 => 
        array (
          'name' => 'name',
          'related_fields' => 
          array (
            0 => 'total_revenue_line_items',
            1 => 'closed_revenue_line_items',
            2 => 'included_revenue_line_items',
          ),
        ),
        2 => 
        array (
          'name' => 'renewal',
          'type' => 'renewal',
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
      'newTab' => true,
      'panelDefault' => 'expanded',
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'tct_etapa_ddw_c',
          'label' => 'LBL_TCT_ETAPA_DDW_C',
        ),
        1 => 
        array (
          'name' => 'estatus_c',
          'label' => 'LBL_ESTATUS',
        ),
        2 => 
        array (
          'name' => 'opportunities_directores',
          'label' => 'Director de la solicitud',
          'studio' => 'visible',
        ),
        3 => 
        array (
          'name' => 'vobo_dir_c',
          'label' => 'LBL_VOBO_DIR',
        ),
        4 => 
        array (
          'name' => 'vobo_descripcion_txa_c',
          'studio' => 'visible',
          'label' => 'LBL_VOBO_DESCRIPCION_TXA',
        ),
        5 => 
        array (
          'name' => 'director_notificado_c',
          'label' => 'LBL_DIRECTOR_NOTIFICADO',
        ),
        6 => 
        array (
          'name' => 'doc_scoring_chk_c',
          'label' => 'LBL_DOC_SCORING_CHK',
        ),
        7 => 
        array (
          'name' => 'bandera_excluye_chk_c',
          'label' => 'LBL_BANDERA_EXCLUYE_CHK',
        ),
        8 => 
        array (
          'name' => 'director_solicitud_c',
          'label' => 'LBL_DIRECTOR_SOLICITUD',
        ),
        9 => 
        array (
          'name' => 'idsolicitud_c',
          'label' => 'LBL_IDSOLICITUD',
        ),
        10 => 
        array (
          'name' => 'id_process_c',
          'label' => 'LBL_ID_PROCESS',
        ),
        11 => 
        array (
          'name' => 'account_name',
          'related_fields' => 
          array (
            0 => 'account_id',
          ),
        ),
        12 => 
        array (
          'name' => 'tipo_producto_c',
          'studio' => 'visible',
          'label' => 'LBL_TIPO_PRODUCTO',
        ),
        13 => 
        array (
          'name' => 'tipo_operacion_c',
          'studio' => 'visible',
          'label' => 'LBL_TIPO_OPERACION',
        ),
        14 => 
        array (
          'name' => 'tipo_de_operacion_c',
          'studio' => 'visible',
          'label' => 'LBL_TIPO_DE_OPERACION',
        ),
        15 => 
        array (
          'name' => 'plan_financiero_c',
          'studio' => 'visible',
          'label' => 'LBL_PLAN_FINANCIERO',
        ),
        16 => 
        array (
          'name' => 'tipo_seguro_c',
          'label' => 'LBL_TIPO_SEGURO',
        ),
        17 => 
        array (
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'name' => 'accesorios_c',
          'label' => 'LBL_ACCESORIOS',
        ),
        18 => 
        array (
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'name' => 'seguro_vida_c',
          'label' => 'LBL_SEGURO_VIDA',
        ),
        19 => 
        array (
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'name' => 'seguro_desempleo_c',
          'label' => 'LBL_SEGURO_DESEMPLEO',
        ),
        20 => 
        array (
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'name' => 'monto_c',
          'label' => 'LBL_MONTO',
        ),
        21 => 
        array (
          'name' => 'amount',
          'type' => 'currency',
          'label' => 'LBL_LIKELY',
          'related_fields' => 
          array (
            0 => 'amount',
            1 => 'currency_id',
            2 => 'base_rate',
          ),
          'currency_field' => 'currency_id',
          'base_rate_field' => 'base_rate',
        ),
        22 => 
        array (
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'name' => 'monto_gpo_emp_c',
          'label' => 'LBL_MONTO_GPO_EMP_C',
        ),
        23 => 
        array (
          'name' => 'tct_numero_vehiculos_c',
          'label' => 'LBL_TCT_NUMERO_VEHICULOS',
        ),
        24 => 
        array (
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'name' => 'ca_pago_mensual_c',
          'label' => 'LBL_CA_PAGO_MENSUAL',
        ),
        25 => 
        array (
          'name' => 'plazo_c',
          'studio' => 'visible',
          'label' => 'LBL_PLAZO',
        ),
        26 => 
        array (
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'name' => 'ca_importe_enganche_c',
          'label' => 'LBL_CA_IMPORTE_ENGANCHE',
        ),
        27 => 
        array (
          'name' => 'porciento_ri_c',
          'label' => 'LBL_PORCIENTO_RI_C',
        ),
        28 => 
        array (
          'name' => 'assigned_user_name',
        ),
        29 => 
        array (
          'name' => 'usuario_bo_c',
          'studio' => 'visible',
          'label' => 'LBL_USUARIO_BO',
        ),
        30 => 
        array (
          'name' => 'asesor_operacion_c',
          'studio' => 'visible',
          'label' => 'LBL_ASESOR_OPERACION_C',
          'readonly' => true,
        ),
        31 => 
        array (
          'name' => 'f_tipo_factoraje_c',
          'studio' => 'visible',
          'label' => 'LBL_F_TIPO_FACTORAJE',
        ),
        32 => 
        array (
          'name' => 'tipo_tasa_ordinario_c',
          'studio' => 'visible',
          'label' => 'LBL_TIPO_TASA_ORDINARIO',
        ),
        33 => 
        array (
          'name' => 'tasa_fija_ordinario_c',
          'label' => 'LBL_TASA_FIJA_ORDINARIO',
        ),
        34 => 
        array (
          'name' => 'instrumento_c',
          'studio' => 'visible',
          'label' => 'LBL_INSTRUMENTO',
        ),
        35 => 
        array (
          'name' => 'puntos_sobre_tasa_c',
          'label' => 'LBL_PUNTOS_SOBRE_TASA',
        ),
        36 => 
        array (
          'name' => 'porcentaje_ca_c',
          'label' => 'LBL_PORCENTAJE_CA',
        ),
        37 => 
        array (
          'name' => 'f_aforo_c',
          'label' => 'LBL_F_AFORO',
        ),
        38 => 
        array (
          'name' => 'tipo_tasa_moratorio_c',
          'studio' => 'visible',
          'label' => 'LBL_TIPO_TASA_MORATORIO',
        ),
        39 => 
        array (
          'name' => 'tasa_fija_moratorio_c',
          'label' => 'LBL_TASA_FIJA_MORATORIO',
        ),
        40 => 
        array (
          'name' => 'instrumento_moratorio_c',
          'studio' => 'visible',
          'label' => 'LBL_INSTRUMENTO_MORATORIO',
        ),
        41 => 
        array (
          'name' => 'puntos_tasa_moratorio_c',
          'label' => 'LBL_PUNTOS_TASA_MORATORIO',
        ),
        42 => 
        array (
          'name' => 'factor_moratorio_c',
          'label' => 'LBL_FACTOR_MORATORIO',
        ),
        43 => 
        array (
          'name' => 'cartera_descontar_c',
          'studio' => 'visible',
          'label' => 'LBL_CARTERA_DESCONTAR_C',
        ),
        44 => 
        array (
          'name' => 'comision_c',
          'label' => 'LBL_COMISION',
        ),
        45 => 
        array (
          'name' => 'opportunities_ag_vendedores_1_name',
        ),
        46 => 
        array (
          'name' => 'condiciones_financieras',
          'studio' => 'visible',
          'label' => 'LBL_CONDICIONES_FINANCIERAS',
        ),
        47 => 
        array (
          'name' => 'ratificacion_incremento_c',
          'label' => 'LBL_RATIFICACION_INCREMENTO',
        ),
        48 => 
        array (
          'name' => 'ri_usuario_bo_c',
          'studio' => 'visible',
          'label' => 'LBL_RI_USUARIO_BO',
        ),
        49 => 
        array (
          'name' => 'ri_anio_c',
          'studio' => 'visible',
          'label' => 'LBL_RI_ANIO_C',
        ),
        50 => 
        array (
          'name' => 'ri_mes_c',
          'studio' => 'visible',
          'label' => 'LBL_RI_MES_C',
        ),
        51 => 
        array (
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'name' => 'monto_ratificacion_increment_c',
          'label' => 'LBL_MONTO_RATIFICACION_INCREMENT',
        ),
        52 => 
        array (
          'name' => 'plazo_ratificado_incremento_c',
          'studio' => 'visible',
          'label' => 'LBL_PLAZO_RATIFICADO_INCREMENTO',
        ),
        53 => 
        array (
          'name' => 'condiciones_financieras_incremento_ratificacion',
          'studio' => 'visible',
          'label' => 'LBL_CONDICIONES_FINANCIERAS_INCREMENTO_RATIFICACION',
        ),
        54 => 
        array (
          'name' => 'ri_porcentaje_ca_c',
          'label' => 'LBL_RI_PORCENTAJE_CA',
        ),
        55 => 
        array (
          'name' => 'ri_tipo_tasa_ordinario_c',
          'studio' => 'visible',
          'label' => 'LBL_RI_TIPO_TASA_ORDINARIO',
        ),
        56 => 
        array (
          'name' => 'ri_tasa_fija_ordinario_c',
          'label' => 'LBL_RI_TASA_FIJA_ORDINARIO',
        ),
        57 => 
        array (
          'name' => 'ri_instrumento_c',
          'studio' => 'visible',
          'label' => 'LBL_RI_INSTRUMENTO',
        ),
        58 => 
        array (
          'name' => 'ri_puntos_sobre_tasa_c',
          'label' => 'LBL_RI_PUNTOS_SOBRE_TASA',
        ),
        59 => 
        array (
          'name' => 'ri_tipo_tasa_moratorio_c',
          'studio' => 'visible',
          'label' => 'LBL_RI_TIPO_TASA_MORATORIO',
        ),
        60 => 
        array (
          'name' => 'ri_tasa_fija_moratorio_c',
          'label' => 'LBL_RI_TASA_FIJA_MORATORIO',
        ),
        61 => 
        array (
          'name' => 'ri_instrumento_moratorio_c',
          'studio' => 'visible',
          'label' => 'LBL_RI_INSTRUMENTO_MORATORIO',
        ),
        62 => 
        array (
          'name' => 'ri_puntos_tasa_moratorio_c',
          'label' => 'LBL_RI_PUNTOS_TASA_MORATORIO',
        ),
        63 => 
        array (
          'name' => 'ri_factor_moratorio_c',
          'label' => 'LBL_RI_FACTOR_MORATORIO',
        ),
        64 => 
        array (
          'name' => 'ri_cartera_descontar_c',
          'studio' => 'visible',
          'label' => 'LBL_RI_CARTERA_DESCONTAR',
        ),
        65 => 
        array (
          'name' => 'referenciada_c',
          'label' => 'LBL_REFERENCIADA_C',
        ),
        66 => 
        array (
          'name' => 'referenciador_c',
          'studio' => 'visible',
          'label' => 'LBL_REFERENCIADOR_C',
        ),
        67 => 
        array (
          'name' => 'comision_referenciador_c',
          'label' => 'LBL_COMISION_REFERENCIADOR_C',
        ),
        68 => 
        array (
          'name' => 'vendedor_c',
          'label' => 'LBL_VENDEDOR_C',
        ),
        69 => 
        array (
          'name' => 'pago_referenciador_c',
          'studio' => 'visible',
          'label' => 'LBL_PAGO_REFERENCIADOR_C',
        ),
        70 => 
        array (
          'name' => 'seguro_contado_c',
          'label' => 'LBL_SEGURO_CONTADO_C',
        ),
        71 => 
        array (
          'name' => 'seguro_financiado_c',
          'label' => 'LBL_SEGURO_FINANCIADO_C',
        ),
        72 => 
        array (
          'name' => 'garantia_adicional_c',
          'label' => 'LBL_GARANTIA_ADICIONAL_C',
        ),
        73 => 
        array (
          'name' => 'descripcion_garantia_adicion_c',
          'studio' => 'visible',
          'label' => 'LBL_DESCRIPCION_GARANTIA_ADICION',
        ),
        74 => 
        array (
          'name' => 'f_comentarios_generales_c',
          'studio' => 'visible',
          'label' => 'LBL_F_COMENTARIOS_GENERALES',
        ),
        75 => 
        array (
          'name' => 'ult_operacion_activa_c',
          'label' => 'LBL_ULT_OPERACION_ACTIVA',
        ),
        76 => 
        array (
          'name' => 'operacion_curso_chk_c',
          'label' => 'LBL_OPERACION_CURSO_CHK',
        ),
        77 => 
        array (
          'name' => 'forecasted_likely',
          'comment' => 'Rollup of included RLIs on the Opportunity',
          'readonly' => true,
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'label' => 'LBL_FORECASTED_LIKELY',
        ),
        78 => 
        array (
          'name' => 'lost',
          'comment' => 'Rollup of lost RLIs on the Opportunity',
          'readonly' => true,
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'label' => 'LBL_LOST',
        ),
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => 1,
    'useTabs' => true,
  ),
);