<?php
$module_name = 'S_seguros';
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
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'seguro_pipeline',
                'studio' => 'visible',
                'label' => '',
              ),
              1 => 
              array (
                'name' => 's_seguros_accounts_name',
                'label' => 'LBL_S_SEGUROS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
              ),
              2 => 
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
              3 => 
              array (
                'name' => 'tipo',
                'label' => 'LBL_TIPO',
              ),
              4 => 
              array (
                'name' => 'tipo_registro_sf_c',
                'label' => 'LBL_TIPO_REGISTRO_SF',
              ),
              5 => 
              array (
                'name' => 'tipo_venta_c',
                'label' => 'LBL_TIPO_VENTA',
              ),
              6 => 
              array (
                'name' => 'tipo_sf_c',
                'label' => 'LBL_TIPO_SF',
              ),
              7 => 
              array (
                'name' => 'ejecutivo_c',
                'label' => 'LBL_EJECUTIVO',
              ),
              8 => 
              array (
                'name' => 'tipo_referenciador',
                'label' => 'LBL_TIPO_REFERENCIADOR',
              ),
              9 => 
              array (
                'name' => 'referenciador',
                'studio' => 'visible',
                'label' => 'LBL_REFERENCIADOR',
              ),
              10 => 
              array (
                'name' => 'region',
                'label' => 'LBL_REGION',
                'readonly' => true,
              ),
              11 => 
              array (
                'name' => 'empleados_c',
                'studio' => 'visible',
                'label' => 'LBL_EMPLEADOS',
              ),
              12 => 
              array (
                'name' => 'departamento_c',
                'label' => 'LBL_DEPARTAMENTO',
                'readonly' => true,
              ),
              13 => 
              array (
                'name' => 'etapa',
                'label' => 'LBL_ETAPA',
              ),
              14 => 
              array (
                'name' => 'area',
                'label' => 'LBL_AREA',
              ),
              15 => 
              array (
                'name' => 'prima_objetivo',
                'label' => 'LBL_PRIMA_OBJ_C',
                'inline' => true,
                'type' => 'fieldset',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'monedas_c',
                  ),
                  1 => 
                  array (
                    'name' => 'prima_obj_c',
                  ),
                ),
              ),
              16 => 
              array (
                'name' => 'tipo_cambio_obj',
                'label' => 'LBL_TIPO_CAMBIO_OBJ',
              ),
              17 => 
              array (
                'name' => 'fecha_req',
                'label' => 'LBL_FECHA_REQ',
              ),
              18 => 
              array (
                'name' => 'fecha_cierre_c',
                'label' => 'LBL_FECHA_CIERRE',
              ),
              19 => 
              array (
                'name' => 'motivos_c',
                'studio' => 'visible',
                'label' => 'LBL_MOTIVOS',
              ),
              20 => 
              array (
                'name' => 'motivo_no_cotizado_c',
                'label' => 'LBL_MOTIVO_NO_COTIZADO',
              ),
              21 => 
              array (
                'name' => 'requiere_ayuda_c',
                'label' => 'LBL_REQUIERE_AYUDA',
              ),
              22 => 
              array (
                'name' => 'servicios_a_incluir_c',
                'label' => 'LBL_SERVICIOS_A_INCLUIR',
              ),
              23 => 
              array (
                'name' => 'subramos_c',
                'label' => 'LBL_SUBRAMOS',
              ),
              24 => 
              array (
                'name' => 'oficina_c',
                'label' => 'LBL_OFICINA',
              ),
              25 => 
              array (
                'name' => 'kam_c',
                'label' => 'LBL_KAM',
              ),
              26 => 
              array (
                'name' => 'nacional_c',
                'label' => 'LBL_NACIONAL',
              ),
              27 => 
              array (
                'name' => 'fee_c',
                'label' => 'LBL_FEE',
              ),
              28 => 
              array (
                'name' => 'fee_p_c',
                'label' => 'LBL_FEE_P',
              ),
              29 => 
              array (
                'name' => 'razon_perdida_c',
                'label' => 'LBL_RAZON_PERDIDA',
              ),
              30 => 
              array (
                'name' => 'comentarios_c',
                'studio' => 'visible',
                'label' => 'LBL_COMENTARIOS',
              ),
              31 => 
              array (
                'name' => 'no_renovable_c',
                'label' => 'LBL_NO_RENOVABLE',
              ),
              32 => 
              array (
                'name' => 'motivos_revision_c',
                'studio' => 'visible',
                'label' => 'LBL_MOTIVOS_REVISION',
              ),
              33 => 
              array (
                'name' => 'info_actual',
                'label' => 'LBL_INFO_ACTUAL',
              ),
              34 => 
              array (
                'name' => 'notifica_kam_c',
                'label' => 'LBL_NOTIFICA_KAM',
              ),
              35 => 
              array (
                'name' => 'registro_no_valido_c',
                'label' => 'LBL_REGISTRO_NO_VALIDO',
              ),
              36 => 
              array (
                'span' => 12,
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
                'name' => 'prima_neta_c',
                'label' => 'LBL_PRIMA_NETA_C',
                'inline' => true,
                'type' => 'fieldset',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'monedas_c',
                  ),
                  1 => 
                  array (
                    'name' => 'prima_neta_c',
                  ),
                ),
              ),
              1 => 
              array (
                'name' => 'tipo_cambio_n',
                'label' => 'LBL_TIPO_CAMBIO_N',
              ),
              2 => 
              array (
                'name' => 'compania',
                'label' => 'LBL_COMPANIA',
              ),
              3 => 
              array (
                'name' => 'forma_pago_act',
                'label' => 'LBL_FORMA_PAGO_ACT',
              ),
              4 => 
              array (
                'name' => 'siniestralidad',
                'label' => 'LBL_SINIESTRALIDAD',
              ),
              5 => 
              array (
                'span' => 12,
              ),
              6 => 
              array (
                'name' => 'fecha_ini',
                'label' => 'LBL_FECHA_INI',
              ),
              7 => 
              array (
                'name' => 'fecha_fin',
                'label' => 'LBL_FECHA_FIN',
              ),
            ),
          ),
          3 => 
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
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'prima_c',
                'label' => 'LBL_PRIMA',
                'readonly' => true,
              ),
              1 => 
              array (
                'name' => 'comision_tec_c',
                'label' => 'LBL_COMISION_TEC',
                'readonly' => true,
              ),
              2 => 
              array (
                'name' => 'asegurador_tec_c',
                'label' => 'LBL_ASEGURADOR_TEC',
                'readonly' => true,
              ),
              3 => 
              array (
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
                'name' => 'prima_neta_ganada_c',
                'label' => 'LBL_PRIMA_NETA_GANADA',
                'inline' => true,
                'type' => 'fieldset',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'monedas_c',
                  ),
                  1 => 
                  array (
                    'name' => 'prima_neta_ganada_c',
                  ),
                ),
              ),
              1 => 
              array (
                'name' => 'tipo_cambio_ganada_c',
                'label' => 'LBL_TIPO_CAMBIO_GANADA',
              ),
              2 => 
              array (
                'name' => 'forma_pago',
                'label' => 'LBL_FORMA_PAGO',
              ),
              3 => 
              array (
                'name' => 'comision_c',
                'label' => 'LBL_COMISION',
              ),
              4 => 
              array (
                'name' => 'aseguradora_c',
                'label' => 'LBL_ASEGURADORA',
              ),
              5 => 
              array (
                'name' => 'fecha_ini_c',
                'label' => 'LBL_FECHA_INI_C',
              ),
              6 => 
              array (
                'name' => 'fecha_fin_c',
                'label' => 'LBL_FECHA_FIN_C',
              ),
              7 => 
              array (
                'name' => 'participa_kam_c',
                'label' => 'LBL_PARTICIPA_KAM',
              ),
              8 => 
              array (
                'name' => 'seguro_uni2_c',
                'label' => 'LBL_SEGURO_UNI2',
              ),
              9 => 
              array (
                'name' => 'subetapa_c',
                'label' => 'LBL_SUBETAPA',
              ),
              10 => 
              array (
                'name' => 'prima_neta',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_PRIMA_NETA',
                'readonly' => true,
              ),
              11 => 
              array (
                'name' => 'incentivo',
                'label' => 'LBL_INCENTIVO',
              ),
              12 => 
              array (
                'name' => 'ingreso_ref',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_INGRESO_REF',
                'readonly' => true,
              ),
              13 => 
              array (
                'name' => 'no_poliza_emitida_c',
                'label' => 'LBL_NO_POLIZA_EMITIDA',
              ),
              14 => 
              array (
                'name' => 'inicio_vigencia_emitida_c',
                'label' => 'LBL_INICIO_VIGENCIA_EMITIDA',
              ),
              15 => 
              array (
                'name' => 'fin_vigencia_emitida_c',
                'label' => 'LBL_FIN_VIGENCIA_EMITIDA',
              ),
              16 => 
              array (
                'name' => 'cambio_pn_emitida_c',
                'label' => 'LBL_CAMBIO_PN_EMITIDA',
              ),
              17 => 
              array (
                'name' => 'cambio_pt_emitida_c',
                'label' => 'LBL_CAMBIO_PT_EMITIDA',
              ),
              18 => 
              array (
                'name' => 'forma_pago_emitida_c',
                'label' => 'LBL_FORMA_PAGO_EMITIDA',
              ),
              19 => 
              array (
                'name' => 'aseguradora_emitida_c',
                'label' => 'LBL_ASEGURADORA_EMITIDA',
              ),
              20 => 
              array (
                'name' => 'fecha_pago_c',
                'label' => 'LBL_FECHA_PAGO',
              ),
              21 => 
              array (
                'name' => 'fecha_aplicacion_c',
                'label' => 'LBL_FECHA_APLICACION',
              ),
              22 => 
              array (
                'name' => 'razon_cancel_ganada_c',
                'label' => 'LBL_RAZON_CANCEL_GANADA',
              ),
              23 => 
              array (
                'name' => 'comentarios_ganada_c',
                'label' => 'LBL_COMENTARIOS_GANADA',
              ),
            ),
          ),
          5 => 
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
                'name' => 'tipo_cliente_c',
                'label' => 'LBL_TIPO_CLIENTE',
              ),
              1 => 
              array (
                'name' => 'description',
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
              3 => 
              array (
                'name' => 'producto_c',
                'label' => 'LBL_PRODUCTO',
                'readonly' => true,
              ),
              4 => 
              array (
                'name' => 'id_disposicion_c',
                'label' => 'LBL_ID_DISPOSICION',
                'readonly' => true,
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
