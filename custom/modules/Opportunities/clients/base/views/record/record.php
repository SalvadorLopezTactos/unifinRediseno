<?php
$viewdefs['Opportunities'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'record' => 
      array (
        'buttons' => 
        array (
          0 => 
          array (
            'type' => 'button',
            'name' => 'vobo_leasing',
            'label' => 'Vo.Bo.',
            'css_class' => 'btn-success hidden',
            'showOn' => 'view',
            'events' => 
            array (
              'click' => 'button:btn_auth_button:click',
            ),
          ),
          1 => 
          array (
            'type' => 'button',
            'name' => 'rechazo_leasing',
            'label' => 'Rechazar',
            'css_class' => 'btn-danger hidden',
            'showOn' => 'view',
            'events' => 
            array (
              'click' => 'button:btn_noauth_button:click',
            ),
          ),
          2 => 
          array (
            'type' => 'button',
            'name' => 'cancel_button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
            'showOn' => 'edit',
          ),
          3 => 
          array (
            'type' => 'rowaction',
            'event' => 'button:save_button:click',
            'name' => 'save_button',
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'css_class' => 'btn btn-primary',
            'showOn' => 'edit',
            'acl_action' => 'edit',
          ),
          4 => 
          array (
            'type' => 'actiondropdown',
            'name' => 'main_dropdown',
            'primary' => true,
            'showOn' => 'view',
            'css_class' => 'noEdit',
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
                'type' => 'shareaction',
                'name' => 'share',
                'label' => 'LBL_RECORD_SHARE_BUTTON',
                'acl_action' => 'view',
              ),
              2 => 
              array (
                'type' => 'divider',
              ),
              3 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:historical_summary_button:click',
                'name' => 'historical_summary_button',
                'label' => 'LBL_HISTORICAL_SUMMARY',
                'acl_action' => 'view',
              ),
              4 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:audit_button:click',
                'name' => 'audit_button',
                'label' => 'LNK_VIEW_CHANGE_LOG',
                'acl_action' => 'view',
              ),
              5 => 
              array (
                'type' => 'divider',
              ),
              6 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:expediente_button:click',
                'name' => 'expediente',
                'label' => 'Expediente',
                'acl_action' => 'view',
              ),
              7 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:sobregiro:click',
                'name' => 'solicita_sobregiro',
                'label' => 'Solicitar Sobregiro',
                'acl_action' => 'view',
              ),
              9 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:expediente_credito_button:click',
                'name' => 'expediente_credito',
                'label' => 'Expediente de Credito',
                'acl_action' => 'view',
              ),
              10 => 
              array (
                'type' => 'pdfaction',
                'name' => 'download-pdf',
                'label' => 'LBL_PDF_VIEW',
                'action' => 'download',
                'acl_action' => 'view',
              ),
              11 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:votacion_comite_button:click',
                'name' => 'votacion_comite',
                'label' => 'Votacion Comite',
                'acl_action' => 'view',
              ),
            ),
          ),
          5 => 
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
                'name' => 'favorite',
                'label' => 'LBL_FAVORITE',
                'type' => 'favorite',
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
            'labels' => true,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => true,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'admin_cartera_c',
                'label' => 'LBL_ADMIN_CARTERA_C',
              ),
              1 => 
              array (
                'name' => 'cartera_dias_vencido_c',
                'label' => 'LBL_CARTERA_DIAS_VENCIDO',
              ),
              2 => 
              array (
                'name' => 'tipo_sol_admin_cartera_c',
                'label' => 'LBL_TIPO_SOL_ADMIN_CARTERA_C',
              ),
              3 => 
              array (
                'name' => 'producto_origen_vencido_c',
                'label' => 'LBL_PRODUCTO_ORIGEN_VENCIDO_C',
              ),
              4 => 
              array (
                'name' => 'pipeline_opp',
                'studio' => 'visible',
                'label' => 'LBL_PIPELINE_OPP',
                'dismiss_label' => true,
                'span' => 12,
              ),
              5 => 
              array (
                'name' => 'tct_etapa_ddw_c',
                'label' => 'LBL_TCT_ETAPA_DDW_C',
              ),
              6 => 
              array (
                'name' => 'estatus_c',
                'label' => 'LBL_ESTATUS',
              ),
              7 => 
              array (
                'name' => 'opportunities_directores',
                'label' => 'Director de la solicitud',
                'studio' => 'visible',
              ),
              8 => 
              array (
                'name' => 'asesor_rm_c',
                'studio' => 'visible',
                'label' => 'LBL_ASESOR_RM',
              ),
              9 => 
              array (
                'name' => 'vobo_descripcion_txa_c',
                'studio' => 'visible',
                'label' => 'LBL_VOBO_DESCRIPCION_TXA',
              ),
              10 => 
              array (
                'name' => 'director_notificado_c',
                'label' => 'LBL_DIRECTOR_NOTIFICADO',
              ),
              11 => 
              array (
                'name' => 'doc_scoring_chk_c',
                'label' => 'LBL_DOC_SCORING_CHK',
              ),
              12 => 
              array (
                'name' => 'bandera_excluye_chk_c',
                'label' => 'LBL_BANDERA_EXCLUYE_CHK',
              ),
              13 => 
              array (
                'name' => 'director_solicitud_c',
                'label' => 'LBL_DIRECTOR_SOLICITUD',
                'span' => 12,
              ),
              14 => 
              array (
                'name' => 'idsolicitud_c',
                'label' => 'LBL_IDSOLICITUD',
              ),
              15 => 
              array (
                'name' => 'id_process_c',
                'label' => 'LBL_ID_PROCESS',
              ),
              16 => 
              array (
                'name' => 'account_name',
                'related_fields' => 
                array (
                  0 => 'account_id',
                ),
              ),
              17 => 
              array (
                'name' => 'blank_space',
                'label' => 'LBL_BLANK_SPACE',
              ),
              18 => 
              array (
                'name' => 'tipo_producto_c',
                'studio' => 'visible',
                'label' => 'LBL_TIPO_PRODUCTO',
              ),
              19 => 
              array (
                'name' => 'negocio_c',
                'studio' => 'visible',
                'label' => 'LBL_NEGOCIO_C',
              ),
<<<<<<< HEAD
              16 => 
=======
              20 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'producto_financiero_c',
                'studio' => 'visible',
                'label' => 'LBL_PRODUCTO_FINANCIERO_C',
              ),
<<<<<<< HEAD
              17 => 
=======
              21 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'blank_space',
                'label' => 'LBL_BLANK_SPACE',
              ),
<<<<<<< HEAD
              18 => 
=======
              22 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'tipo_operacion_c',
                'studio' => 'visible',
                'label' => 'LBL_TIPO_OPERACION',
              ),
<<<<<<< HEAD
              19 => 
=======
              23 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'tipo_de_operacion_c',
                'studio' => 'visible',
                'label' => 'LBL_TIPO_DE_OPERACION',
              ),
<<<<<<< HEAD
              20 => 
=======
              24 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'plan_financiero_c',
                'studio' => 'visible',
                'label' => 'LBL_PLAN_FINANCIERO',
              ),
<<<<<<< HEAD
              21 => 
=======
              25 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'blank_space',
                'label' => 'LBL_BLANK_SPACE',
              ),
<<<<<<< HEAD
              22 => 
=======
              26 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'tipo_seguro_c',
                'label' => 'LBL_TIPO_SEGURO',
              ),
<<<<<<< HEAD
              23 => 
=======
              27 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'accesorios_c',
                'label' => 'LBL_ACCESORIOS',
              ),
<<<<<<< HEAD
              24 => 
=======
              28 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'seguro_vida_c',
                'label' => 'LBL_SEGURO_VIDA',
              ),
<<<<<<< HEAD
              25 => 
=======
              29 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'seguro_desempleo_c',
                'label' => 'LBL_SEGURO_DESEMPLEO',
              ),
<<<<<<< HEAD
              26 => 
=======
              30 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'monto_c',
                'label' => 'LBL_MONTO',
              ),
<<<<<<< HEAD
              27 => 
=======
              31 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
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
                'span' => 6,
              ),
<<<<<<< HEAD
              28 => 
=======
              32 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'monto_ratificacion_increment_c',
                'label' => 'LBL_MONTO_RATIFICACION_INCREMENT',
              ),
<<<<<<< HEAD
              29 => 
=======
              33 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'monto_gpo_emp_c',
                'label' => 'LBL_MONTO_GPO_EMP_C',
              ),
<<<<<<< HEAD
              30 => 
=======
              34 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'tct_numero_vehiculos_c',
                'label' => 'LBL_TCT_NUMERO_VEHICULOS',
              ),
<<<<<<< HEAD
              31 => 
=======
              35 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'blank_space',
                'label' => 'LBL_BLANK_SPACE',
              ),
<<<<<<< HEAD
              32 => 
=======
              36 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'ca_pago_mensual_c',
                'label' => 'LBL_CA_PAGO_MENSUAL',
              ),
<<<<<<< HEAD
              33 => 
=======
              37 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'plazo_c',
                'studio' => 'visible',
                'label' => 'LBL_PLAZO',
              ),
<<<<<<< HEAD
              34 => 
=======
              38 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'ca_importe_enganche_c',
                'label' => 'LBL_CA_IMPORTE_ENGANCHE',
              ),
<<<<<<< HEAD
              35 => 
=======
              39 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'porciento_ri_c',
                'label' => 'LBL_PORCIENTO_RI_C',
              ),
<<<<<<< HEAD
              36 => 
              array (
                'name' => 'assigned_user_name',
              ),
              37 => 
=======
              40 => 
              array (
                'name' => 'assigned_user_name',
              ),
              41 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'usuario_bo_c',
                'studio' => 'visible',
                'label' => 'LBL_USUARIO_BO',
              ),
<<<<<<< HEAD
              38 => 
=======
              42 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'asesor_operacion_c',
                'studio' => 'visible',
                'label' => 'LBL_ASESOR_OPERACION_C',
                'readonly' => true,
                'span' => 12,
              ),
<<<<<<< HEAD
              39 => 
=======
              43 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'f_tipo_factoraje_c',
                'studio' => 'visible',
                'label' => 'LBL_F_TIPO_FACTORAJE',
                'span' => 12,
              ),
<<<<<<< HEAD
              40 => 
=======
              44 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'tipo_tasa_ordinario_c',
                'studio' => 'visible',
                'label' => 'LBL_TIPO_TASA_ORDINARIO',
              ),
<<<<<<< HEAD
              41 => 
=======
              45 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'tasa_fija_ordinario_c',
                'label' => 'LBL_TASA_FIJA_ORDINARIO',
              ),
<<<<<<< HEAD
              42 => 
=======
              46 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'instrumento_c',
                'studio' => 'visible',
                'label' => 'LBL_INSTRUMENTO',
              ),
<<<<<<< HEAD
              43 => 
=======
              47 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'puntos_sobre_tasa_c',
                'label' => 'LBL_PUNTOS_SOBRE_TASA',
              ),
<<<<<<< HEAD
              44 => 
=======
              48 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'porcentaje_ca_c',
                'label' => 'LBL_PORCENTAJE_CA',
              ),
<<<<<<< HEAD
              45 => 
=======
              49 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'f_aforo_c',
                'label' => 'LBL_F_AFORO',
              ),
<<<<<<< HEAD
              46 => 
=======
              50 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'tipo_tasa_moratorio_c',
                'studio' => 'visible',
                'label' => 'LBL_TIPO_TASA_MORATORIO',
              ),
<<<<<<< HEAD
              47 => 
=======
              51 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'tasa_fija_moratorio_c',
                'label' => 'LBL_TASA_FIJA_MORATORIO',
              ),
<<<<<<< HEAD
              48 => 
=======
              52 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'instrumento_moratorio_c',
                'studio' => 'visible',
                'label' => 'LBL_INSTRUMENTO_MORATORIO',
              ),
<<<<<<< HEAD
              49 => 
=======
              53 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'puntos_tasa_moratorio_c',
                'label' => 'LBL_PUNTOS_TASA_MORATORIO',
              ),
<<<<<<< HEAD
              50 => 
=======
              54 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'factor_moratorio_c',
                'label' => 'LBL_FACTOR_MORATORIO',
              ),
<<<<<<< HEAD
              51 => 
=======
              55 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'blank_space',
                'label' => 'LBL_BLANK_SPACE',
              ),
<<<<<<< HEAD
              52 => 
=======
              56 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'cartera_descontar_c',
                'studio' => 'visible',
                'label' => 'LBL_CARTERA_DESCONTAR_C',
                'span' => 12,
              ),
<<<<<<< HEAD
              53 => 
=======
              57 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'comision_c',
                'label' => 'LBL_COMISION',
              ),
<<<<<<< HEAD
              54 => 
              array (
                'name' => 'opportunities_ag_vendedores_1_name',
              ),
              55 => 
=======
              58 => 
              array (
                'name' => 'opportunities_ag_vendedores_1_name',
              ),
              59 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'condiciones_financieras',
                'studio' => 'visible',
                'label' => 'LBL_CONDICIONES_FINANCIERAS',
                'span' => 12,
              ),
<<<<<<< HEAD
              56 => 
=======
              60 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'ratificacion_incremento_c',
                'label' => 'LBL_RATIFICACION_INCREMENTO',
              ),
<<<<<<< HEAD
              57 => 
=======
              61 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'ri_usuario_bo_c',
                'studio' => 'visible',
                'label' => 'LBL_RI_USUARIO_BO',
              ),
<<<<<<< HEAD
              58 => 
=======
              62 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'ri_anio_c',
                'studio' => 'visible',
                'label' => 'LBL_RI_ANIO_C',
              ),
<<<<<<< HEAD
              59 => 
=======
              63 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'ri_mes_c',
                'studio' => 'visible',
                'label' => 'LBL_RI_MES_C',
              ),
<<<<<<< HEAD
              60 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'monto_ratificacion_increment_c',
                'label' => 'LBL_MONTO_RATIFICACION_INCREMENT',
              ),
              61 => 
=======
              64 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'plazo_ratificado_incremento_c',
                'studio' => 'visible',
                'label' => 'LBL_PLAZO_RATIFICADO_INCREMENTO',
              ),
<<<<<<< HEAD
              62 => 
=======
              65 => 
              array (
                'name' => 'blank_space',
                'label' => 'LBL_BLANK_SPACE',
              ),
              66 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'condiciones_financieras_incremento_ratificacion',
                'studio' => 'visible',
                'label' => 'LBL_CONDICIONES_FINANCIERAS_INCREMENTO_RATIFICACION',
                'span' => 12,
              ),
<<<<<<< HEAD
              63 => 
=======
              67 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'ri_porcentaje_ca_c',
                'label' => 'LBL_RI_PORCENTAJE_CA',
              ),
<<<<<<< HEAD
              64 => 
=======
              68 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'blank_space',
                'label' => 'LBL_BLANK_SPACE',
              ),
<<<<<<< HEAD
              65 => 
=======
              69 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'ri_tipo_tasa_ordinario_c',
                'studio' => 'visible',
                'label' => 'LBL_RI_TIPO_TASA_ORDINARIO',
              ),
<<<<<<< HEAD
              66 => 
=======
              70 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'ri_tasa_fija_ordinario_c',
                'label' => 'LBL_RI_TASA_FIJA_ORDINARIO',
              ),
<<<<<<< HEAD
              67 => 
=======
              71 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'ri_instrumento_c',
                'studio' => 'visible',
                'label' => 'LBL_RI_INSTRUMENTO',
              ),
<<<<<<< HEAD
              68 => 
=======
              72 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'ri_puntos_sobre_tasa_c',
                'label' => 'LBL_RI_PUNTOS_SOBRE_TASA',
              ),
<<<<<<< HEAD
              69 => 
=======
              73 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'ri_tipo_tasa_moratorio_c',
                'studio' => 'visible',
                'label' => 'LBL_RI_TIPO_TASA_MORATORIO',
              ),
<<<<<<< HEAD
              70 => 
=======
              74 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'ri_tasa_fija_moratorio_c',
                'label' => 'LBL_RI_TASA_FIJA_MORATORIO',
              ),
<<<<<<< HEAD
              71 => 
=======
              75 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'ri_instrumento_moratorio_c',
                'studio' => 'visible',
                'label' => 'LBL_RI_INSTRUMENTO_MORATORIO',
              ),
<<<<<<< HEAD
              72 => 
=======
              76 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'ri_puntos_tasa_moratorio_c',
                'label' => 'LBL_RI_PUNTOS_TASA_MORATORIO',
              ),
<<<<<<< HEAD
              73 => 
=======
              77 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'ri_factor_moratorio_c',
                'label' => 'LBL_RI_FACTOR_MORATORIO',
              ),
<<<<<<< HEAD
              74 => 
=======
              78 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'blank_space',
                'label' => 'LBL_BLANK_SPACE',
              ),
<<<<<<< HEAD
              75 => 
=======
              79 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'ri_cartera_descontar_c',
                'studio' => 'visible',
                'label' => 'LBL_RI_CARTERA_DESCONTAR',
                'span' => 12,
              ),
<<<<<<< HEAD
              76 => 
=======
              80 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'referenciada_c',
                'label' => 'LBL_REFERENCIADA_C',
              ),
<<<<<<< HEAD
              77 => 
=======
              81 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'blank_space',
                'label' => 'LBL_BLANK_SPACE',
              ),
<<<<<<< HEAD
              78 => 
=======
              82 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'referenciador_c',
                'studio' => 'visible',
                'label' => 'LBL_REFERENCIADOR_C',
              ),
<<<<<<< HEAD
              79 => 
=======
              83 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'comision_referenciador_c',
                'label' => 'LBL_COMISION_REFERENCIADOR_C',
              ),
<<<<<<< HEAD
              80 => 
=======
              84 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'vendedor_c',
                'label' => 'LBL_VENDEDOR_C',
              ),
<<<<<<< HEAD
              81 => 
=======
              85 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'pago_referenciador_c',
                'studio' => 'visible',
                'label' => 'LBL_PAGO_REFERENCIADOR_C',
              ),
<<<<<<< HEAD
              82 => 
=======
              86 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'seguro_contado_c',
                'label' => 'LBL_SEGURO_CONTADO_C',
              ),
<<<<<<< HEAD
              83 => 
=======
              87 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'seguro_financiado_c',
                'label' => 'LBL_SEGURO_FINANCIADO_C',
              ),
<<<<<<< HEAD
              84 => 
=======
              88 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'garantia_adicional_c',
                'label' => 'LBL_GARANTIA_ADICIONAL_C',
              ),
<<<<<<< HEAD
              85 => 
=======
              89 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'blank_space',
                'label' => 'LBL_BLANK_SPACE',
              ),
<<<<<<< HEAD
              86 => 
=======
              90 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'descripcion_garantia_adicion_c',
                'studio' => 'visible',
                'label' => 'LBL_DESCRIPCION_GARANTIA_ADICION',
                'span' => 12,
              ),
<<<<<<< HEAD
              87 => 
=======
              91 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'f_comentarios_generales_c',
                'studio' => 'visible',
                'label' => 'LBL_F_COMENTARIOS_GENERALES',
                'span' => 12,
              ),
<<<<<<< HEAD
              88 => 
=======
              92 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'ult_operacion_activa_c',
                'label' => 'LBL_ULT_OPERACION_ACTIVA',
              ),
<<<<<<< HEAD
              89 => 
=======
              93 => 
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              array (
                'name' => 'operacion_curso_chk_c',
                'label' => 'LBL_OPERACION_CURSO_CHK',
              ),
<<<<<<< HEAD
              90 => 
              array (
                'name' => 'lic_licitaciones_opportunities_1_name',
=======
              94 => 
              array (
                'name' => 'vobo_dir_c',
                'label' => 'LBL_VOBO_DIR',
              ),
              95 => 
              array (
>>>>>>> a08b1f1084bb6bfbd3c53cbe85b75ce38ac372ed
              ),
            ),
          ),
          2 => 
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
                'name' => 'tct_oportunidad_perdida_chk_c',
                'label' => 'LBL_TCT_OPORTUNIDAD_PERDIDA_CHK',
              ),
              1 => 
              array (
                'name' => 'tct_razon_op_perdida_ddw_c',
                'label' => 'LBL_TCT_RAZON_OP_PERDIDA_DDW',
              ),
              2 => 
              array (
                'name' => 'tct_competencia_quien_txf_c',
                'label' => 'LBL_TCT_COMPETENCIA_QUIEN_TXF',
              ),
              3 => 
              array (
                'name' => 'tct_competencia_porque_txf_c',
                'label' => 'LBL_TCT_COMPETENCIA_PORQUE_TXF',
              ),
              4 => 
              array (
                'name' => 'tct_sin_prod_financiero_ddw_c',
                'label' => 'LBL_TCT_SIN_PROD_FINANCIERO_DDW',
              ),
              5 => 
              array (
              ),
              6 => 
              array (
                'name' => 'renewal_parent_name',
              ),
              7 => 
              array (
              ),
            ),
          ),
          3 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL4',
            'label' => 'LBL_RECORDVIEW_PANEL4',
            'columns' => 2,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'ce_destino_c',
                'label' => 'LBL_CE_DESTINO',
                'span' => 12,
              ),
              1 => 
              array (
                'name' => 'ce_tasa_c',
                'label' => 'LBL_CE_TASA',
              ),
              2 => 
              array (
                'name' => 'ce_plazo_c',
                'label' => 'LBL_CE_PLAZO',
              ),
              3 => 
              array (
                'name' => 'ce_moneda_c',
                'label' => 'LBL_CE_MONEDA',
              ),
              4 => 
              array (
              ),
              5 => 
              array (
                'name' => 'ce_apertura_c',
                'label' => 'LBL_CE_APERTURA',
              ),
              6 => 
              array (
                'name' => 'ce_comisiones_c',
                'studio' => 'visible',
                'label' => 'LBL_CE_COMISIONES',
              ),
              7 => 
              array (
                'name' => 'credito_estructurado',
                'label' => 'Comisiones adicionales',
                'studio' => 'visible',
                'span' => 12,
              ),
              8 => 
              array (
                'name' => 'ce_comentarios_c',
                'studio' => 'visible',
                'label' => 'LBL_CE_COMENTARIOS',
                'span' => 12,
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
                'name' => 'area_benef_c',
                'label' => 'LBL_AREA_BENEF_C',
                'studio' => 'visible',
              ),
              1 => 
              array (
                'name' => 'blank_space',
                'label' => 'LBL_BLANK_SPACE',
              ),
              2 => 
              array (
                'name' => 'estado_benef_c',
                'label' => 'LBL_ESTADO_BENEF_C',
              ),
              3 => 
              array (
                'name' => 'municipio_benef_c',
                'label' => 'LBL_MUNICIPIO_BENEF_C',
              ),
              4 => 
              array (
                'name' => 'ent_gob_benef_c',
                'label' => 'LBL_ENT_GOB_BENEF_C',
              ),
              5 => 
              array (
                'name' => 'blank_space',
                'label' => 'LBL_BLANK_SPACE',
              ),
              6 => 
              array (
                'name' => 'cuenta_benef_c',
                'studio' => 'visible',
                'label' => 'LBL_CUENTA_BENEF_C',
              ),
              7 => 
              array (
                'name' => 'blank_space',
                'label' => 'LBL_BLANK_SPACE',
              ),
              8 => 
              array (
                'name' => 'emp_no_reg_benef_c',
                'label' => 'LBL_EMP_NO_REG_BENEF_C',
              ),
              9 => 
              array (
              ),
            ),
          ),
          5 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL3',
            'label' => 'LBL_RECORDVIEW_PANEL3',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'subyacente_c',
                'label' => 'LBL_SUBYACENTE_C',
              ),
              1 => 
              array (
                'name' => 'blank_space',
                'label' => 'LBL_BLANK_SPACE',
              ),
              2 => 
              array (
                'name' => 'estado_suby_c',
                'label' => 'LBL_ESTADO_SUBY_C',
              ),
              3 => 
              array (
                'name' => 'municipio_suby_c',
                'label' => 'LBL_MUNICIPIO_SUBY_C',
              ),
              4 => 
              array (
                'name' => 'ent_gob_suby_c',
                'label' => 'LBL_ENT_GOB_SUBY_C',
              ),
              5 => 
              array (
                'name' => 'blank_space',
                'label' => 'LBL_BLANK_SPACE',
              ),
              6 => 
              array (
                'name' => 'otro_suby_c',
                'studio' => 'visible',
                'label' => 'LBL_OTRO_SUBY_C',
              ),
              7 => 
              array (
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
