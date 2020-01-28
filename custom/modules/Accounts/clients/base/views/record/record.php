<?php
$viewdefs['Accounts'] = 
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
            'name' => 'cancel_button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
            'showOn' => 'edit',
          ),
          1 => 
          array (
            'type' => 'rowaction',
            'event' => 'button:save_button:click',
            'name' => 'save_button',
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'css_class' => 'btn btn-primary',
            'showOn' => 'edit',
            'acl_action' => 'edit',
          ),
          2 => 
          array (
            'type' => 'actiondropdown',
            'name' => 'main_dropdown',
            'primary' => true,
            'css_class' => 'noEdit',
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
                'event' => 'button:cotizador_button:click',
                'name' => 'cotizador',
                'label' => 'Cotizador',
                'acl_action' => 'view',
              ),
              7 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:Historial_cotizaciones_button:click',
                'name' => 'HistorialCotizaciones',
                'label' => 'Historial de Cotizaciones',
                'acl_action' => 'view',
              ),
              8 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:expediente_button:click',
                'name' => 'expediente',
                'label' => 'Expediente',
                'acl_action' => 'view',
              ),
              9 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:negociacion:click',
                'name' => 'negociacion',
                'label' => 'Generar Disposicion',
                'acl_action' => 'view',
              ),
              10 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:prospecto_contactado:click',
                'name' => 'prospectocontactado',
                'label' => 'LBL_PROSPECTO_CONTACTADO_C',
                'acl_action' => 'view',
                'class' => 'jcmx1',
              ),
              11 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:regresa_lead:click',
                'name' => 'regresalead',
                'label' => 'LBL_REGRESA_A_LEAD_C',
                'acl_action' => 'view',
                'css_class' => 'btn-regresa-alead',
              ),
              12 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:convierte_lead:click',
                'name' => 'conviertelead',
                'label' => 'Convertir a Lead',
                'acl_action' => 'view',
                'class' => 'jcmx1',
              ),
              13 =>
              array (
                'type' => 'rowaction',
                'event' => 'button:conversion_cliente_uniclick:click',
                'name' => 'clienteuniclick',
                'label' => 'Conversión Cliente Uniclick',
                'acl_action' => 'view',
                'class' => 'jcmx1',
              ),
              14 =>
              array (
                'name' => 'send_survey',
                'type' => 'rowaction',
                'label' => 'Send Survey',
                'acl_action' => 'send_survey',
                'event' => 'button:send_survey:click',
              ),
              15 =>
              array (
                'name' => 'send_poll',
                'type' => 'rowaction',
                'label' => 'Send Poll',
                'acl_action' => 'send_poll',
                'event' => 'button:send_poll:click',
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
            'label' => 'LBL_PANEL_HEADER',
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
              ),
            ),
          ),
          1 => 
          array (
            'newTab' => true,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL8',
            'label' => 'LBL_RECORDVIEW_PANEL8',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'account_leasing',
                'studio' => 'visible',
                'label' => 'LBL_ACCOUNT_LEASING',
                'readonly' => true,
                'span' => 12,
              ),
            ),
          ),
          2 => 
          array (
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 3,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => true,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'tipo_registro_c',
              ),
              1 => 
              array (
                'name' => 'subtipo_cuenta_c',
                'readonly' => true,
              ),
              2 => 
              array (
                'name' => 'tct_status_atencion_ddw_c',
                'readonly' => true,
              ),
              3 => 
              array (
                'name' => 'tct_prioridad_ddw_c',
              ),
              4 => 
              array (
                'name' => 'tct_homonimo_chk_c',
                'label' => 'LBL_TCT_HOMONIMO_CHK',
              ),
              5 => 
              array (
              ),
              6 => 
              array (
                'name' => 'esproveedor_c',
                'label' => 'LBL_ESPROVEEDOR',
              ),
              7 => 
              array (
                'name' => 'cedente_factor_c',
                'label' => 'LBL_CEDENTE_FACTOR',
              ),
              8 => 
              array (
                'name' => 'deudor_factor_c',
                'label' => 'LBL_DEUDOR_FACTOR',
              ),
              9 => 
              array (
              ),
              10 => 
              array (
                'name' => 'tct_noviable',
                'studio' => 'visible',
                'label' => 'tct_noviable',
                'span' => 12,
              ),
              11 => 
              array (
                'name' => 'tct_no_contactar_chk_c',
                'label' => 'LBL_TCT_NO_CONTACTAR_CHK',
              ),
              12 => 
              array (
              ),
            ),
          ),
          3 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL17',
            'label' => 'LBL_RECORDVIEW_PANEL17',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'cuenta_productos',
                'label' => 'LBL_CUENTA_PRODUCTOS',
                'studio' => 'visible',
                'span' => 12,
              ),
            ),
          ),
          4 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL16',
            'label' => 'LBL_RECORDVIEW_PANEL16',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'origendelprospecto_c',
                'studio' => 'visible',
                'label' => 'LBL_ORIGENDELPROSPECTO',
              ),
              1 => 
              array (
                'name' => 'tct_detalle_origen_ddw_c',
                'label' => 'LBL_TCT_DETALLE_ORIGEN_DDW',
              ),
              2 => 
              array (
                'name' => 'metodo_prospeccion_c',
                'label' => 'LBL_METODO_PROSPECCION',
              ),
              3 => 
              array (
              ),
              4 => 
              array (
                'name' => 'referenciador_c',
                'studio' => 'visible',
                'label' => 'LBL_REFERENCIADOR',
              ),
              5 => 
              array (
              ),
              6 => 
              array (
                'name' => 'referido_cliente_prov_c',
                'studio' => 'visible',
                'label' => 'LBL_REFERIDO_CLIENTE_PROV',
              ),
              7 => 
              array (
              ),
              8 => 
              array (
                'name' => 'referenciado_agencia_c',
                'label' => 'LBL_REFERENCIADO_AGENCIA',
              ),
              9 => 
              array (
              ),
              10 => 
              array (
                'name' => 'tct_referenciado_dir_rel_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_REFERENCIADO_DIR_REL',
              ),
              11 => 
              array (
              ),
              12 => 
              array (
                'name' => 'tct_origen_busqueda_txf_c',
                'label' => 'LBL_TCT_ORIGEN_BUSQUEDA_TXF',
              ),
              13 => 
              array (
                'name' => 'tct_origen_base_ddw_c',
                'label' => 'LBL_TCT_ORIGEN_BASE_DDW',
              ),
              14 => 
              array (
                'name' => 'medio_digital_c',
                'label' => 'LBL_MEDIO_DIGITAL',
              ),
              15 => 
              array (
                'name' => 'tct_punto_contacto_ddw_c',
                'label' => 'LBL_TCT_PUNTO_CONTACTO_DDW',
              ),
              16 => 
              array (
                'name' => 'evento_c',
                'label' => 'LBL_EVENTO',
              ),
              17 => 
              array (
              ),
              18 => 
              array (
                'name' => 'camara_c',
                'label' => 'LBL_CAMARA',
              ),
              19 => 
              array (
              ),
              20 => 
              array (
                'name' => 'como_se_entero_c',
                'label' => 'LBL_COMO_SE_ENTERO',
              ),
              21 => 
              array (
                'name' => 'cual_c',
                'label' => 'LBL_CUAL',
              ),
              22 => 
              array (
                'name' => 'tct_origen_ag_tel_rel_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_ORIGEN_AG_TEL_REL',
                'initial_filter' => 'filterAgentesTelefonicosTemplate',
                'initial_filter_label' => 'LBL_FILTER_USER_BY_PUESTO',
                'filter_populate' => 
                array (
                  'puestousuario_c' => 
                  array (
                    0 => '27',
                    1 => '31',
                  ),
                ),
              ),
              23 => 
              array (
                'name' => 'tct_que_promotor_rel_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_QUE_PROMOTOR_REL',
              ),
            ),
          ),
          5 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL11',
            'label' => 'LBL_RECORDVIEW_PANEL11',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'estatus_persona_c',
                'label' => 'LBL_ESTATUS_PERSONA',
              ),
              1 => 
              array (
              ),
              2 => 
              array (
                'name' => 'tipodepersona_c',
                'studio' => 'visible',
                'label' => 'LBL_TIPODEPERSONA',
              ),
              3 => 
              array (
                'name' => 'primernombre_c',
                'label' => 'LBL_PRIMERNOMBRE',
              ),
              4 => 
              array (
                'name' => 'apellidopaterno_c',
                'label' => 'LBL_APELLIDOPATERNO',
              ),
              5 => 
              array (
                'name' => 'apellidomaterno_c',
                'label' => 'LBL_APELLIDOMATERNO',
              ),
              6 => 
              array (
                'name' => 'razonsocial_c',
                'label' => 'LBL_RAZONSOCIAL',
                'span' => 12,
              ),
              7 => 
              array (
                'name' => 'nombre_comercial_c',
                'label' => 'LBL_NOMBRE_COMERCIAL',
                'span' => 12,
              ),
              8 => 
              array (
                'name' => 'fechadenacimiento_c',
                'label' => 'LBL_FECHADENACIMIENTO',
              ),
              9 => 
              array (
                'name' => 'genero_c',
                'studio' => 'visible',
                'label' => 'LBL_GENERO',
              ),
              10 => 
              array (
                'name' => 'parent_name',
              ),
              11 => 
              array (
                'name' => 'fechaconstitutiva_c',
                'label' => 'LBL_FECHACONSTITUTIVA',
              ),
              12 => 
              array (
                'name' => 'rfc_c',
                'label' => 'LBL_RFC',
              ),
              13 => 
              array (
                'type' => 'button',
                'name' => 'generar_rfc_c',
                'label' => 'LBL_GENERAR_RFC',
              ),
              14 => 
              array (
                'name' => 'nacionalidad_c',
                'label' => 'LBL_NACIONALIDAD',
              ),
              15 => 
              array (
                'name' => 'tct_pais_expide_rfc_c',
                'label' => 'LBL_TCT_PAIS_EXPIDE_RFC',
              ),
              16 => 
              array (
                'name' => 'pais_nacimiento_c',
                'studio' => 'visible',
                'label' => 'LBL_PAIS_NACIMIENTO',
              ),
              17 => 
              array (
                'name' => 'estado_nacimiento_c',
                'studio' => 'visible',
                'label' => 'LBL_ESTADO_NACIMIENTO',
              ),
              18 => 
              array (
                'name' => 'zonageografica_c',
                'studio' => 'visible',
                'label' => 'LBL_ZONAGEOGRAFICA',
              ),
              19 => 
              array (
                'name' => 'ifepasaporte_c',
                'label' => 'LBL_IFEPASAPORTE',
              ),
              20 => 
              array (
                'name' => 'curp_c',
                'label' => 'LBL_CURP',
              ),
              21 => 
              array (
                'type' => 'button',
                'name' => 'generar_curp_c',
                'label' => 'LBL_GENERAR_CURP',
              ),
              22 => 
              array (
                'name' => 'estadocivil_c',
                'studio' => 'visible',
                'label' => 'LBL_ESTADOCIVIL',
              ),
              23 => 
              array (
                'name' => 'regimenpatrimonial_c',
                'studio' => 'visible',
                'label' => 'LBL_REGIMENPATRIMONIAL',
              ),
              24 => 
              array (
                'name' => 'profesion_c',
                'studio' => 'visible',
                'label' => 'LBL_PROFESION',
              ),
              25 => 
              array (
                'name' => 'puesto_c',
                'label' => 'LBL_PUESTO',
              ),
              26 => 
              array (
                'name' => 'email',
              ),
              27 => 'website',
              28 => 
              array (
                'name' => 'facebook',
                'comment' => 'The facebook name of the company',
                'label' => 'LBL_FACEBOOK',
              ),
              29 => 
              array (
                'name' => 'linkedin_c',
                'label' => 'LBL_LINKEDIN',
              ),
              30 => 'twitter',
              31 => 
              array (
                'name' => 'referenciabancaria_c',
                'label' => 'LBL_REFERENCIABANCARIA',
              ),
              32 => 
              array (
                'name' => 'tipo_relacion_c',
                'label' => 'LBL_TIPO_RELACION',
              ),
              33 => 
              array (
              ),
              34 => 
              array (
                'name' => 'tipo_proveedor_c',
                'label' => 'LBL_TIPO_PROVEEDOR',
              ),
              35 => 
              array (
                'name' => 'alta_proveedor_c',
                'label' => 'LBL_ALTA_PROVEEDOR_C',
              ),
              36 => 
              array (
                'name' => 'iva_c',
                'label' => 'LBL_IVA',
              ),
              37 => 
              array (
                'name' => 'es_referenciador_c',
                'label' => 'LBL_ES_REFERENCIADOR_C',
              ),
              38 => 
              array (
                'name' => 'reus_c',
                'label' => 'LBL_REUS',
              ),
              39 => 
              array (
                'name' => 'referencia_bancaria_c',
                'label' => 'LBL_REFERENCIA_BANCARIA_C',
              ),
              40 => 
              array (
                'name' => 'tct_prospecto_contactado_chk_c',
                'label' => 'LBL_TCT_PROSPECTO_CONTACTADO_CHK',
              ),
              41 => 
              array (
                'name' => 'show_panel_c',
                'label' => 'LBL_SHOW_PANEL',
              ),
            ),
          ),
          6 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL12',
            'label' => 'LBL_RECORDVIEW_PANEL12',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'tct_macro_sector_ddw_c',
                'label' => 'LBL_TCT_MACRO_SECTOR_DDW',
              ),
              1 => 
              array (
                'name' => 'sectoreconomico_c',
                'label' => 'LBL_SECTORECONOMICO',
              ),
              2 => 
              array (
                'name' => 'subsectoreconomico_c',
                'studio' => 'visible',
                'label' => 'LBL_SUBSECTORECONOMICO',
              ),
              3 => 
              array (
                'name' => 'actividadeconomica_c',
                'studio' => 'visible',
                'label' => 'LBL_ACTIVIDADECONOMICA',
              ),
              4 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'ventas_anuales_c',
                'label' => 'LBL_VENTAS_ANUALES',
              ),
              5 => 
              array (
                'name' => 'tct_ano_ventas_ddw_c',
                'label' => 'LBL_TCT_ANO_VENTAS_DDW',
              ),
              6 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'activo_fijo_c',
                'label' => 'LBL_ACTIVO_FIJO',
              ),
              7 => 
              array (
                'readonly' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'potencial_cuenta_c',
                'label' => 'LBL_POTENCIAL_CUENTA',
              ),
              8 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'tct_depositos_promedio_c',
                'label' => 'LBL_TCT_DEPOSITOS_PROMEDIO_C',
              ),
              9 => 
              array (
                'name' => 'empleados_c',
                'label' => 'LBL_EMPLEADOS',
              ),
              10 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'tct_prom_cheques_cur_c',
                'label' => 'LBL_TCT_PROM_CHEQUES_CUR_C',
              ),
              11 => 
              array (
                'name' => 'dates_account_statements',
                'studio' => 'visible',
                'label' => 'LBL_TCT_DATES_ACCOUNT_STATEMENTS_C',
                'type' => 'dates_account_statements',
              ),
              12 => 
              array (
                'name' => 'tct_dates_acc_statements_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_DATES_ACC_STATEMENTS_C',
                'span' => 12,
              ),
              13 => 
              array (
                'name' => 'potencial_autos',
                'studio' => 'visible',
                'label' => 'LBL_POTENCIAL_AUTOS',
                'span' => 12,
              ),
            ),
          ),
          7 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL13',
            'label' => 'LBL_RECORDVIEW_PANEL13',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'promotorleasing_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTORLEASING',
                'initial_filter' => 'filterPromotorTemplate',
                'initial_filter_label' => 'LBL_FILTER_PROMOTOR_TEMPLATE',
                'filter_populate' => 
                array (
                  'tipodeproducto_c' => '1',
                ),
              ),
              1 => 
              array (
                'name' => 'promotorfactoraje_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTORFACTORAJE',
                'initial_filter' => 'filterPromotorTemplate',
                'initial_filter_label' => 'LBL_FILTER_PROMOTOR_TEMPLATE',
                'filter_populate' => 
                array (
                  'tipodeproducto_c' => '4',
                ),
              ),
              2 => 
              array (
                'name' => 'promotorcredit_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTORCREDIT',
                'initial_filter' => 'filterPromotorTemplate',
                'initial_filter_label' => 'LBL_FILTER_PROMOTOR_TEMPLATE',
                'filter_populate' => 
                array (
                  'tipodeproducto_c' => '3',
                ),
              ),
              3 => 
              array (
                'name' => 'promotorfleet_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTORFLEET',
                'initial_filter' => 'filterPromotorTemplate',
                'initial_filter_label' => 'LBL_FILTER_PROMOTOR_TEMPLATE',
                'filter_populate' => 
                array (
                  'tipodeproducto_c' => '6',
                ),
              ),
              4 => 
              array (
                'name' => 'promotoruniclick_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTORUNICLICK_C',
              ),
              5 => 
              array (
              ),
            ),
          ),
          8 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL10',
            'label' => 'LBL_RECORDVIEW_PANEL10',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'nivel_satisfaccion_c',
                'label' => 'LBL_NIVEL_SATISFACCION',
              ),
              1 => 
              array (
                'name' => 'fecha_leasing_c',
                'label' => 'LBL_FECHA_LEASING',
              ),
              2 => 
              array (
                'name' => 'comenta_leasing_c',
                'studio' => 'visible',
                'label' => 'LBL_COMENTA_LEASING',
                'span' => 12,
              ),
              3 => 
              array (
                'name' => 'nivel_satisfaccion_factoring_c',
                'label' => 'LBL_NIVEL_SATISFACCION_FACTORING',
              ),
              4 => 
              array (
                'name' => 'fecha_factoraje_c',
                'label' => 'LBL_FECHA_FACTORAJE',
              ),
              5 => 
              array (
                'name' => 'comenta_factoraje_c',
                'studio' => 'visible',
                'label' => 'LBL_COMENTA_FACTORAJE',
                'span' => 12,
              ),
              6 => 
              array (
                'name' => 'nivel_satisfaccion_ca_c',
                'label' => 'LBL_NIVEL_SATISFACCION_CA',
              ),
              7 => 
              array (
                'name' => 'fecha_ca_c',
                'label' => 'LBL_FECHA_CA',
              ),
              8 => 
              array (
                'name' => 'comenta_ca_c',
                'studio' => 'visible',
                'label' => 'LBL_COMENTA_CA',
                'span' => 12,
              ),
            ),
          ),
          9 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL14',
            'label' => 'LBL_RECORDVIEW_PANEL14',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'account_telefonos',
                'studio' => 'visible',
                'label' => 'ACCOUNT_TELEFONOS',
                'span' => 12,
              ),
            ),
          ),
          10 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL15',
            'label' => 'LBL_RECORDVIEW_PANEL15',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'account_direcciones',
                'studio' => 'visible',
                'label' => 'ACCOUNT_DIRECCIONES',
                'span' => 12,
              ),
            ),
          ),
          11 => 
          array (
            'newTab' => true,
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
                'name' => 'ctpldnoseriefiel_c',
                'label' => 'LBL_CTPLDNOSERIEFIEL',
              ),
              1 => 
              array (
              ),
              2 => 
              array (
                'name' => 'tct_cpld_pregunta_u1_ddw_c',
                'label' => 'LBL_TCT_CPLD_PREGUNTA_U1_DDW',
              ),
              3 => 
              array (
                'name' => 'tct_cpld_pregunta_u2_txf_c',
                'label' => 'LBL_TCT_CPLD_PREGUNTA_U2_TXF',
              ),
              4 => 
              array (
                'name' => 'tct_cpld_pregunta_u3_ddw_c',
                'label' => 'LBL_TCT_CPLD_PREGUNTA_U3_DDW',
              ),
              5 => 
              array (
                'name' => 'tct_cpld_pregunta_u4_txf_c',
                'label' => 'LBL_TCT_CPLD_PREGUNTA_U4_TXF',
              ),
              6 => 
              array (
                'name' => 'tct_fedeicomiso_chk_c',
                'label' => 'LBL_TCT_FEDEICOMISO_CHK',
              ),
              7 => 
              array (
              ),
              8 => 
              array (
                'name' => 'accounts_tct_pld',
                'studio' => 'visible',
                'label' => 'accounts_tct_pld',
                'span' => 12,
              ),
              9 => 
              array (
                'name' => 'tct_nuevo_pld_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_NUEVO_PLD_C',
                'span' => 12,
              ),
            ),
          ),
          12 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL4',
            'label' => 'LBL_RECORDVIEW_PANEL4',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'ctpldfuncionespublicas_c',
                'label' => 'LBL_CTPLDFUNCIONESPUBLICAS',
              ),
              1 => 
              array (
                'name' => 'ctpldfuncionespublicascargo_c',
                'label' => 'LBL_CTPLDFUNCIONESPUBLICASCARGO',
              ),
              2 => 
              array (
                'name' => 'tct_dependencia_pf_c',
                'label' => 'LBL_TCT_DEPENDENCIA_PF',
              ),
              3 => 
              array (
                'name' => 'tct_periodo_pf1_c',
                'label' => 'LBL_TCT_PERIODO_PF1',
              ),
              4 => 
              array (
                'name' => 'tct_fecha_ini_pf_c',
                'label' => 'LBL_TCT_FECHA_INI_PF',
              ),
              5 => 
              array (
                'name' => 'tct_fecha_fin_pf_c',
                'label' => 'LBL_TCT_FECHA_FIN_PF',
              ),
            ),
          ),
          13 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL5',
            'label' => 'LBL_RECORDVIEW_PANEL5',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'ctpldconyuge_c',
                'label' => 'LBL_CTPLDCONYUGE',
              ),
              1 => 
              array (
                'name' => 'ctpldconyugecargo_c',
                'label' => 'LBL_CTPLDCONYUGECARGO',
              ),
              2 => 
              array (
                'name' => 'tct_nombre_pf_peps_c',
                'label' => 'LBL_TCT_NOMBRE_PF_PEPS',
              ),
              3 => 
              array (
                'name' => 'tct_cargo2_pf_c',
                'label' => 'LBL_TCT_CARGO2_PF',
              ),
              4 => 
              array (
                'name' => 'tct_dependencia2_pf_c',
                'label' => 'LBL_TCT_DEPENDENCIA2_PF',
              ),
              5 => 
              array (
                'name' => 'tct_periodo2_pf_c',
                'label' => 'LBL_TCT_PERIODO2_PF',
              ),
              6 => 
              array (
                'name' => 'tct_fecha_ini2_pf_c',
                'label' => 'LBL_TCT_FECHA_INI2_PF',
              ),
              7 => 
              array (
                'name' => 'tct_fecha_fin2_pf_c',
                'label' => 'LBL_TCT_FECHA_FIN2_PF',
              ),
            ),
          ),
          14 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL7',
            'label' => 'LBL_RECORDVIEW_PANEL7',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'ctpldaccionistasconyuge_c',
                'label' => 'LBL_CTPLDACCIONISTASCONYUGE',
              ),
              1 => 
              array (
                'name' => 'tct_socio2_pm_c',
                'label' => 'LBL_TCT_SOCIO2_PM',
              ),
              2 => 
              array (
                'name' => 'ctpldaccionistasconyugecargo_c',
                'label' => 'LBL_CTPLDACCIONISTASCONYUGECARGO',
              ),
              3 => 
              array (
                'name' => 'tct_nombre_pm_c',
                'label' => 'LBL_TCT_NOMBRE_PM',
              ),
              4 => 
              array (
                'name' => 'tct_cargo_pm_c',
                'label' => 'LBL_TCT_CARGO_PM',
              ),
              5 => 
              array (
                'name' => 'tct_dependencia2_pm_c',
                'label' => 'LBL_TCT_DEPENDENCIA2_PM_C',
              ),
              6 => 
              array (
                'name' => 'tct_periodo2_pm_c',
                'label' => 'LBL_TCT_PERIODO2_PM',
              ),
              7 => 
              array (
              ),
              8 => 
              array (
                'name' => 'tct_fecha_ini2_pm_c',
                'label' => 'LBL_TCT_FECHA_INI2_PM',
              ),
              9 => 
              array (
                'name' => 'tct_fecha_fin2_pm_c',
                'label' => 'LBL_TCT_FECHA_FIN2_PM',
              ),
            ),
          ),
          15 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL6',
            'label' => 'LBL_RECORDVIEW_PANEL6',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'ctpldaccionistas_c',
                'label' => 'LBL_CTPLDACCIONISTAS',
              ),
              1 => 
              array (
                'name' => 'tct_socio_pm_c',
                'label' => 'LBL_TCT_SOCIO_PM',
              ),
              2 => 
              array (
                'name' => 'ctpldaccionistascargo_c',
                'label' => 'LBL_CTPLDACCIONISTASCARGO',
              ),
              3 => 
              array (
                'name' => 'tct_dependencia_pm_c',
                'label' => 'LBL_TCT_DEPENDENCIA_PM',
              ),
              4 => 
              array (
                'name' => 'tct_periodo_pm_c',
                'label' => 'LBL_TCT_PERIODO_PM',
              ),
              5 => 
              array (
              ),
              6 => 
              array (
                'name' => 'tct_fecha_ini_pm_c',
                'label' => 'LBL_TCT_FECHA_INI_PM',
              ),
              7 => 
              array (
                'name' => 'tct_fecha_fin_pm_c',
                'label' => 'LBL_TCT_FECHA_FIN_PM',
              ),
            ),
          ),
          16 => 
          array (
            'newTab' => true,
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
                'name' => 'tct_fedeicomiso_c1_txf_c',
                'label' => 'LBL_TCT_FEDEICOMISO_C1_TXF',
              ),
              1 => 
              array (
                'name' => 'tct_fedeicomiso_c2_txf_c',
                'label' => 'LBL_TCT_FEDEICOMISO_C2_TXF',
              ),
              2 => 
              array (
                'name' => 'tct_fedeicomiso_c3_txf_c',
                'label' => 'LBL_TCT_FEDEICOMISO_C3_TXF',
              ),
              3 => 
              array (
                'name' => 'tct_fedeicomiso_c4_txf_c',
                'label' => 'LBL_TCT_FEDEICOMISO_C4_TXF',
              ),
              4 => 
              array (
                'name' => 'tct_fedeicomiso_c5_txf_c',
                'label' => 'LBL_TCT_FEDEICOMISO_C5_TXF',
              ),
              5 => 
              array (
                'name' => 'tct_fedeicomiso_c6_dat_c',
                'label' => 'LBL_TCT_FEDEICOMISO_C6_DAT',
              ),
              6 => 
              array (
                'name' => 'tct_fedeicomiso_c7_txf_c',
                'label' => 'LBL_TCT_FEDEICOMISO_C7_TXF',
              ),
              7 => 
              array (
                'name' => 'tct_fedeicomiso_c8_txf_c',
                'label' => 'LBL_TCT_FEDEICOMISO_C8_TXF',
              ),
              8 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'tct_fedeicomiso_c9_cur_c',
                'label' => 'LBL_TCT_FEDEICOMISO_C9_CUR',
              ),
              9 => 
              array (
                'name' => 'tct_fedeicomiso_c10_ddw_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_FEDEICOMISO_C10_DDW',
              ),
              10 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'tct_fedeicomiso_c12_cur_c',
                'label' => 'LBL_TCT_FEDEICOMISO_C12_CUR',
              ),
              11 => 
              array (
                'name' => 'tct_fedeicomiso_c13_int_c',
                'label' => 'LBL_TCT_FEDEICOMISO_C13_INT',
              ),
              12 => 
              array (
                'name' => 'tct_fedeicomiso_c14_ddw_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_FEDEICOMISO_C14_DDW',
              ),
              13 => 
              array (
                'name' => 'tct_fedeicomiso_c14_2_txf_c',
                'label' => 'LBL_TCT_FEDEICOMISO_C14_2_TXF',
              ),
              14 => 
              array (
                'name' => 'tct_fedeicomiso_c15_ddw_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_FEDEICOMISO_C15_DDW',
              ),
              15 => 
              array (
              ),
              16 => 
              array (
                'name' => 'tct_fedeicomiso_c16_ddw_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_FEDEICOMISO_C16_DDW',
              ),
              17 => 
              array (
                'name' => 'tct_fedeicomiso_c16_2_txf_c',
                'label' => 'LBL_TCT_FEDEICOMISO_C16_2_TXF',
              ),
              18 => 
              array (
                'name' => 'tct_fedeicomiso_c17_ddw_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_FEDEICOMISO_C17_DDW',
              ),
              19 => 
              array (
                'name' => 'tct_fedeicomiso_c17_2_txf_c',
                'label' => 'LBL_TCT_FEDEICOMISO_C17_2_TXF',
              ),
              20 => 
              array (
                'name' => 'tct_fedeicomiso_c18_ddw_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_FEDEICOMISO_C18_DDW',
              ),
              21 => 
              array (
                'name' => 'tct_fedeicomiso_c18_2_txf_c',
                'label' => 'LBL_TCT_FEDEICOMISO_C18_2_TXF',
              ),
              22 => 
              array (
                'name' => 'tct_fedeicomiso_c19_txf_c',
                'label' => 'LBL_TCT_FEDEICOMISO_C19_TXF',
              ),
              23 => 
              array (
              ),
              24 => 
              array (
                'name' => 'tct_fedeicomiso_c20_msl_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_FEDEICOMISO_C20_MSL',
              ),
              25 => 
              array (
                'name' => 'tct_fedeicomiso_c21_ddw_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_FEDEICOMISO_C21_DDW',
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
