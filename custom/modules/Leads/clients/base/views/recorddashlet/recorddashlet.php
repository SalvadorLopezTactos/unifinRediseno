<?php
$viewdefs['Leads'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'recorddashlet' => 
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
            'header' => true,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'picture',
                'type' => 'avatar',
                'size' => 'large',
                'readonly' => true,
                'dismiss_label' => true,
              ),
              4 => 
              array (
                'name' => 'name',
                'readonly' => true,
                'label' => 'LBL_NAME',
                'showOn' => 'view',
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
                'readonly' => false,
                'name' => 'fecha_bloqueo_origen_c',
                'label' => 'LBL_FECHA_BLOQUEO_ORIGEN',
              ),
              1 => 
              array (
              ),
              2 => 
              array (
                'name' => 'tipo_registro_c',
                'label' => 'LBL_TIPO_REGISTRO',
                'readonly' => true,
              ),
              3 => 
              array (
                'name' => 'subtipo_registro_c',
                'label' => 'LBL_SUBTIPO_REGISTRO',
                'readonly' => true,
              ),
              4 => 
              array (
                'name' => 'regimen_fiscal_c',
                'studio' => 'visible',
                'label' => 'LBL_REGIMEN_FISCAL',
              ),
              5 => 
              array (
                'name' => 'nombre_empresa_c',
                'label' => 'LBL_NOMBRE_EMPRESA',
              ),
              6 => 
              array (
                'name' => 'nombre_c',
                'label' => 'LBL_NOMBRE',
              ),
              7 => 
              array (
                'name' => 'apellido_paterno_c',
                'label' => 'LBL_APELLIDO_PATERNO_C',
              ),
              8 => 
              array (
                'name' => 'apellido_materno_c',
                'label' => 'LBL_APELLIDO_MATERNO_C',
              ),
              9 => 
              array (
                'readonly' => false,
                'name' => 'genero_c',
                'label' => 'LBL_GENERO',
              ),
              10 => 
              array (
                'name' => 'puesto_c',
                'label' => 'LBL_PUESTO_C',
              ),
              11 => 
              array (
              ),
              12 => 
              array (
                'name' => 'origen_c',
                'label' => 'LBL_ORIGEN',
              ),
              13 => 
              array (
                'readonly' => false,
                'name' => 'detalle_origen_c',
                'label' => 'LBL_DETALLE_ORIGEN',
              ),
              14 => 
              array (
                'name' => 'medio_digital_c',
                'label' => 'LBL_MEDIO_DIGITAL',
              ),
              15 => 
              array (
                'name' => 'punto_contacto_c',
                'label' => 'LBL_PUNTO_CONTACTO',
              ),
              16 => 
              array (
                'name' => 'origen_busqueda_c',
                'label' => 'LBL_ORIGEN_BUSQUEDA_C',
              ),
              17 => 
              array (
                'name' => 'evento_c',
                'label' => 'LBL_EVENTO_C',
              ),
              18 => 
              array (
                'name' => 'camara_c',
                'label' => 'LBL_CAMARA_C',
              ),
              19 => 
              array (
              ),
              20 => 
              array (
                'readonly' => false,
                'name' => 'referenciador_c',
                'studio' => 'visible',
                'label' => 'LBL_REFERENCIADOR',
              ),
              21 => 
              array (
              ),
              22 => 
              array (
                'readonly' => false,
                'name' => 'referido_cliente_prov_c',
                'studio' => 'visible',
                'label' => 'LBL_REFERIDO_CLIENTE_PROV',
              ),
              23 => 
              array (
              ),
              24 => 
              array (
                'readonly' => false,
                'name' => 'codigo_expo_c',
                'label' => 'LBL_CODIGO_EXPO',
              ),
              25 => 
              array (
              ),
              26 => 
              array (
                'name' => 'origen_ag_tel_c',
                'studio' => 'visible',
                'label' => 'LBL_ORIGEN_AG_TEL_C',
              ),
              27 => 
              array (
                'name' => 'promotor_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTOR_C',
              ),
              28 => 
              array (
                'name' => 'prospeccion_propia_c',
                'label' => 'LBL_PROSPECCION_PROPIA',
              ),
              29 => 
              array (
                'name' => 'alianza_soc_chk_c',
                'label' => 'LBL_ALIANZA_SOC_CHK_C',
              ),
              30 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'ventas_anuales_c',
                'label' => 'LBL_VENTAS_ANUALES_C',
              ),
              31 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'potencial_lead_c',
                'label' => 'LBL_POTENCIAL_LEAD',
              ),
              32 => 
              array (
                'name' => 'rfc_c',
                'label' => 'LBL_RFC',
              ),
              33 => 
              array (
                'name' => 'zona_geografica_c',
                'label' => 'LBL_ZONA_GEOGRAFICA_C',
              ),
              34 => 
              array (
                'name' => 'email',
              ),
              35 => 
              array (
                'name' => 'phone_mobile',
                'label' => 'LBL_MOBILE_PHONE',
                'inline' => true,
                'type' => 'fieldset',
                'fields' => 
                array (
                  0 => 
                  array (
                    'type' => 'rowaction',
                    'event' => 'button:llamada_mobile:click',
                    'css_class' => 'llamada_mobile btn fa fa-phone fa-large btn-success',
                  ),
                  1 => 
                  array (
                    'name' => 'phone_mobile',
                  ),
                ),
              ),
              36 => 
              array (
                'name' => 'o_registro_reus_c',
                'label' => 'LBL_O_REGISTRO_REUS_C',
              ),
              37 => 
              array (
                'name' => 'phone_home',
                'comment' => 'Home phone number of the contact',
                'label' => 'LBL_HOME_PHONE',
                'inline' => true,
                'type' => 'fieldset',
                'fields' => 
                array (
                  0 => 
                  array (
                    'type' => 'rowaction',
                    'event' => 'button:llamada_home:click',
                    'css_class' => 'llamada_home btn fa fa-phone fa-large btn-success',
                  ),
                  1 => 
                  array (
                    'name' => 'phone_home',
                  ),
                ),
              ),
              38 => 
              array (
                'name' => 'phone_work',
                'label' => 'LBL_OFFICE_PHONE',
                'inline' => true,
                'type' => 'fieldset',
                'fields' => 
                array (
                  0 => 
                  array (
                    'type' => 'rowaction',
                    'event' => 'button:llamada_work:click',
                    'css_class' => 'llamada_work btn fa fa-phone fa-large btn-success',
                  ),
                  1 => 
                  array (
                    'name' => 'phone_work',
                  ),
                ),
              ),
              39 => 
              array (
                'readonly' => false,
                'name' => 'c_estatus_telefono_c',
                'studio' => 'visible',
                'label' => 'LBL_C_ESTATUS_TELEFONO',
              ),
              40 => 
              array (
                'readonly' => false,
                'name' => 'm_estatus_telefono_c',
                'studio' => 'visible',
                'label' => 'LBL_M_ESTATUS_TELEFONO',
              ),
              41 => 
              array (
                'readonly' => false,
                'name' => 'o_estatus_telefono_c',
                'studio' => 'visible',
                'label' => 'LBL_O_ESTATUS_TELEFONO',
              ),
              42 => 
              array (
                'name' => 'lead_telefonos',
                'studio' => 'visible',
                'label' => 'LBL_LEAD_TELEFONOS',
                'span' => 12,
              ),
              43 => 
              array (
                'name' => 'detalle_plataforma_c',
                'studio' => 'visible',
                'label' => 'LBL_DETALLE_PLATAFORMA_C',
              ),
              44 => 
              array (
                'name' => 'oficina_c',
                'label' => 'LBL_OFICINA',
              ),
              45 => 
              array (
                'name' => 'nombre_de_cargar_c',
                'label' => 'LBL_NOMBRE_DE_CARGAR',
              ),
              46 => 
              array (
                'name' => 'alianza_c',
                'label' => 'LBL_ALIANZA_C',
              ),
              47 => 
              array (
                'name' => 'lead_cancelado_c',
                'label' => 'LBL_LEAD_CANCELADO_C',
              ),
              48 => 
              array (
                'name' => 'motivo_cancelacion_c',
                'label' => 'LBL_MOTIVO_CANCELACION_C',
              ),
              49 => 
              array (
                'name' => 'submotivo_cancelacion_c',
                'label' => 'LBL_SUBMOTIVO_CANCELACION_C',
                'span' => 12,
              ),
              50 => 
              array (
                'name' => 'assigned_user_name',
              ),
              51 => 
              array (
                'name' => 'account_to_lead',
                'label' => 'LBL_ACCOUNT',
                'readonly' => true,
              ),
              52 => 
              array (
                'name' => 'status_management_c',
                'label' => 'LBL_STATUS_MANAGEMENT',
              ),
              53 => 
              array (
                'name' => 'fecha_asignacion_c',
                'label' => 'LBL_FECHA_ASIGNACION_C',
              ),
              54 => 
              array (
                'name' => 'url_originacion_c',
                'label' => 'LBL_URL_ORIGINACION_C',
                'readonly' => true,
              ),
              55 => 
              array (
              ),
              56 => 
              array (
                'name' => 'contacto_asociado_c',
                'label' => 'LBL_CONTACTO_ASOCIADO_C',
              ),
              57 => 
              array (
                'name' => 'leads_leads_1_name',
                'label' => 'LBL_LEADS_LEADS_1_FROM_LEADS_L_TITLE',
              ),
              58 => 
              array (
                'name' => 'pb_division_c',
                'label' => 'LBL_PB_DIVISION',
              ),
              59 => 
              array (
                'name' => 'pb_grupo_c',
                'label' => 'LBL_PB_GRUPO',
              ),
              60 => 
              array (
                'name' => 'pb_clase_c',
                'label' => 'LBL_PB_CLASE',
              ),
              61 => 
              array (
                'name' => 'actividad_economica_c',
                'label' => 'LBL_ACTIVIDAD_ECONOMICA',
              ),
              62 => 
              array (
                'name' => 'sector_economico_c',
                'label' => 'LBL_SECTOR_ECONOMICO',
              ),
              63 => 
              array (
                'name' => 'subsector_c',
                'label' => 'LBL_SUBSECTOR',
              ),
              64 => 
              array (
                'name' => 'macrosector_c',
                'label' => 'LBL_MACROSECTOR_C',
              ),
              65 => 
              array (
                'name' => 'inegi_clase_c',
                'label' => 'LBL_INEGI_CLASE',
              ),
              66 => 
              array (
                'name' => 'inegi_macro_c',
                'label' => 'LBL_INEGI_MACRO',
              ),
              67 => 
              array (
                'name' => 'inegi_rama_c',
                'label' => 'LBL_INEGI_RAMA',
              ),
              68 => 
              array (
                'name' => 'inegi_sector_c',
                'label' => 'LBL_INEGI_SECTOR',
              ),
              69 => 
              array (
                'name' => 'inegi_subrama_c',
                'label' => 'LBL_INEGI_SUBRAMA',
              ),
              70 => 
              array (
                'name' => 'inegi_subsector_c',
                'label' => 'LBL_INEGI_SUBSECTOR',
              ),
              71 => 
              array (
                'name' => 'metodo_asignacion_lm_c',
                'label' => 'LBL_METODO_ASIGNACION_LM_C',
              ),
              72 => 
              array (
                'name' => 'homonimo_c',
                'label' => 'LBL_HOMONIMO',
              ),
              73 => 
              array (
                'name' => 'omite_match_c',
                'label' => 'LBL_OMITE_MATCH',
              ),
              74 => 
              array (
                'name' => 'blank_space',
                'label' => 'LBL_BLANK_SPACE',
              ),
              75 => 
              array (
              ),
              76 => 
              array (
                'name' => 'lead_direcciones',
                'studio' => 'visible',
                'label' => 'LBL_LEAD_DIRECCIONES',
                'span' => 12,
              ),
            ),
          ),
          2 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL2',
            'label' => 'LBL_RECORDVIEW_PANEL2',
            'columns' => 2,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'lead_clasf_sectorial',
                'studio' => 'visible',
                'label' => 'LBL_LEAD_CLASF_SECTORIAL',
                'span' => 12,
              ),
            ),
          ),
          3 => 
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
                'name' => 'id_landing_c',
                'label' => 'LBL_ID_LANDING',
              ),
              1 => 
              array (
                'name' => 'lead_source_c',
                'label' => 'LBL_LEAD_SOURCE_C',
              ),
              2 => 
              array (
                'name' => 'facebook_pixel_c',
                'label' => 'LBL_FACEBOOK_PIXEL',
              ),
              3 => 
              array (
                'name' => 'ga_client_id_c',
                'label' => 'LBL_GA_CLIENT_ID',
              ),
              4 => 
              array (
                'name' => 'keyword_c',
                'label' => 'LBL_KEYWORD',
              ),
              5 => 
              array (
                'name' => 'campana_c',
                'label' => 'LBL_CAMPANA',
              ),
              6 => 
              array (
                'name' => 'compania_c',
                'label' => 'LBL_COMPANIA',
              ),
              7 => 
              array (
                'name' => 'producto_financiero_c',
                'label' => 'LBL_PRODUCTO_FINANCIERO_C',
              ),
              8 => 
              array (
                'name' => 'contacto_nombre_c',
                'label' => 'LBL_CONTACTO_NOMBRE_C',
              ),
              9 => 
              array (
                'name' => 'contacto_apellidop_c',
                'label' => 'LBL_CONTACTO_APELLIDOP_C',
              ),
              10 => 
              array (
                'name' => 'contacto_apellidom_c',
                'label' => 'LBL_CONTACTO_APELLIDOM_C',
              ),
              11 => 
              array (
                'name' => 'contacto_telefono_c',
                'label' => 'LBL_CONTACTO_TELEFONO_C',
              ),
              12 => 
              array (
                'name' => 'contacto_email_c',
                'label' => 'LBL_CONTACTO_EMAIL_C',
              ),
              13 => 
              array (
              ),
              14 => 
              array (
                'name' => 'productos_interes_c',
                'label' => 'LBL_PRODUCTOS_INTERES_C',
              ),
              15 => 'opportunity_amount',
              16 => 
              array (
                'name' => 'plazo_c',
                'label' => 'LBL_PLAZO_C',
              ),
              17 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'pago_mensual_estimado_c',
                'label' => 'LBL_PAGO_MENSUAL_ESTIMADO_C',
              ),
              18 => 
              array (
                'name' => 'medios_contacto_deseado_c',
                'label' => 'LBL_MEDIOS_CONTACTO_DESEADO_C',
              ),
              19 => 
              array (
                'name' => 'medio_preferido_contacto_c',
                'label' => 'LBL_MEDIO_PREFERIDO_CONTACTO_C',
              ),
              20 => 
              array (
                'name' => 'dia_contacto_c',
                'label' => 'LBL_DIA_CONTACTO_C',
              ),
              21 => 
              array (
                'name' => 'hora_contacto_c',
                'label' => 'LBL_HORA_CONTACTO_C',
              ),
              22 => 
              array (
                'name' => 'c_registro_reus_c',
                'label' => 'LBL_C_REGISTRO_REUS_C',
              ),
              23 => 
              array (
                'name' => 'm_registro_reus_c',
                'label' => 'LBL_M_REGISTRO_REUS_C',
              ),
              24 => 
              array (
              ),
              25 => 
              array (
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
