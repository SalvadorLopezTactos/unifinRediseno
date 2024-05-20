<?php
// created: 2024-05-20 10:34:39
$viewdefs['Leads']['base']['view']['record'] = array (
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
        1 => 
        array (
          'name' => 'send_survey',
          'type' => 'rowaction',
          'label' => 'Send Survey',
          'acl_action' => 'send_survey',
          'event' => 'button:send_survey:click',
        ),
        2 => 
        array (
          'name' => 'send_poll',
          'type' => 'rowaction',
          'label' => 'Send Poll',
          'acl_action' => 'send_poll',
          'event' => 'button:send_poll:click',
        ),
        3 => 
        array (
          'name' => 'convert_Leads_button',
          'type' => 'rowaction',
          'label' => 'LBL_CONVERT_LEADS_BUTTON_LABEL',
          'acl_action' => 'view',
          'event' => 'button:convert_Lead_to_Accounts:click',
          'class' => 'btn_convertLeads',
        ),
        4 => 
        array (
          'name' => 'reset_lead',
          'type' => 'rowaction',
          'label' => 'Restablecer Lead',
          'acl_action' => 'view',
          'event' => 'button:reset_lead:click',
          'class' => 'btn_resetLeads',
        ),
        5 => 
        array (
          'name' => 'solicitar_ciec',
          'type' => 'rowaction',
          'label' => 'Solicitar CIEC',
          'event' => 'button:solicitar_ciec:click',
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
        1 => 
        array (
          'type' => 'favorite',
        ),
        2 => 
        array (
          'type' => 'follow',
          'readonly' => true,
        ),
        3 => 
        array (
          'name' => 'badge',
          'type' => 'badge',
          'readonly' => true,
          'related_fields' => 
          array (
            0 => 'converted',
            1 => 'account_id',
            2 => 'contact_id',
            3 => 'contact_name',
            4 => 'opportunity_id',
            5 => 'opportunity_name',
          ),
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
          'readonly' => false,
          'name' => 'subestatus_ld_c',
          'label' => 'LBL_SUBESTATUS_LD_C',
        ),
        5 => 
        array (
          'readonly' => false,
          'name' => 'detalle_subestatus_ld_c',
          'label' => 'LBL_DETALLE_SUBESTATUS_LD',
        ),
        6 => 
        array (
          'name' => 'regimen_fiscal_c',
          'studio' => 'visible',
          'label' => 'LBL_REGIMEN_FISCAL',
        ),
        7 => 
        array (
          'name' => 'nombre_empresa_c',
          'label' => 'LBL_NOMBRE_EMPRESA',
        ),
        8 => 
        array (
          'name' => 'nombre_c',
          'label' => 'LBL_NOMBRE',
        ),
        9 => 
        array (
          'name' => 'apellido_paterno_c',
          'label' => 'LBL_APELLIDO_PATERNO_C',
        ),
        10 => 
        array (
          'name' => 'apellido_materno_c',
          'label' => 'LBL_APELLIDO_MATERNO_C',
        ),
        11 => 
        array (
          'readonly' => false,
          'name' => 'genero_c',
          'label' => 'LBL_GENERO',
        ),
        12 => 
        array (
          'name' => 'puesto_c',
          'label' => 'LBL_PUESTO_C',
        ),
        13 => 
        array (
        ),
        14 => 
        array (
          'readonly' => true,
          'name' => 'compania_lead_c',
          'label' => 'LBL_COMPANIA_LEAD_C',
        ),
        15 => 
        array (
        ),
        16 => 
        array (
          'name' => 'origen_c',
          'label' => 'LBL_ORIGEN',
          'readonly' => true,
        ),
        17 => 
        array (
          'readonly' => false,
          'name' => 'detalle_origen_c',
          'label' => 'LBL_DETALLE_ORIGEN',
        ),
        18 => 
        array (
          'name' => 'medio_digital_c',
          'label' => 'LBL_MEDIO_DIGITAL',
        ),
        19 => 
        array (
          'name' => 'punto_contacto_c',
          'label' => 'LBL_PUNTO_CONTACTO',
        ),
        20 => 
        array (
          'name' => 'origen_busqueda_c',
          'label' => 'LBL_ORIGEN_BUSQUEDA_C',
        ),
        21 => 
        array (
          'name' => 'evento_c',
          'label' => 'LBL_EVENTO_C',
        ),
        22 => 
        array (
          'name' => 'camara_c',
          'label' => 'LBL_CAMARA_C',
        ),
        23 => 
        array (
        ),
        24 => 
        array (
          'readonly' => false,
          'name' => 'referenciador_c',
          'studio' => 'visible',
          'label' => 'LBL_REFERENCIADOR',
        ),
        25 => 
        array (
        ),
        26 => 
        array (
          'readonly' => false,
          'name' => 'referido_cliente_prov_c',
          'studio' => 'visible',
          'label' => 'LBL_REFERIDO_CLIENTE_PROV',
        ),
        27 => 
        array (
        ),
        28 => 
        array (
          'readonly' => false,
          'name' => 'codigo_expo_c',
          'label' => 'LBL_CODIGO_EXPO',
        ),
        29 => 
        array (
        ),
        30 => 
        array (
          'name' => 'origen_ag_tel_c',
          'studio' => 'visible',
          'label' => 'LBL_ORIGEN_AG_TEL_C',
        ),
        31 => 
        array (
          'name' => 'promotor_c',
          'studio' => 'visible',
          'label' => 'LBL_PROMOTOR_C',
        ),
        32 => 
        array (
          'name' => 'prospeccion_propia_c',
          'label' => 'LBL_PROSPECCION_PROPIA',
        ),
        33 => 
        array (
          'name' => 'alianza_soc_chk_c',
          'label' => 'LBL_ALIANZA_SOC_CHK_C',
        ),
        34 => 
        array (
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'name' => 'ventas_anuales_c',
          'label' => 'LBL_VENTAS_ANUALES_C',
        ),
        35 => 
        array (
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'name' => 'potencial_lead_c',
          'label' => 'LBL_POTENCIAL_LEAD',
        ),
        36 => 
        array (
          'name' => 'rfc_c',
          'label' => 'LBL_RFC',
        ),
        37 => 
        array (
          'name' => 'zona_geografica_c',
          'label' => 'LBL_ZONA_GEOGRAFICA_C',
        ),
        38 => 
        array (
          'name' => 'email',
        ),
        39 => 
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
        40 => 
        array (
          'name' => 'o_registro_reus_c',
          'label' => 'LBL_O_REGISTRO_REUS_C',
        ),
        41 => 
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
        42 => 
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
        43 => 
        array (
          'readonly' => false,
          'name' => 'c_estatus_telefono_c',
          'studio' => 'visible',
          'label' => 'LBL_C_ESTATUS_TELEFONO',
        ),
        44 => 
        array (
          'readonly' => false,
          'name' => 'm_estatus_telefono_c',
          'studio' => 'visible',
          'label' => 'LBL_M_ESTATUS_TELEFONO',
        ),
        45 => 
        array (
          'readonly' => false,
          'name' => 'o_estatus_telefono_c',
          'studio' => 'visible',
          'label' => 'LBL_O_ESTATUS_TELEFONO',
        ),
        46 => 
        array (
          'name' => 'lead_telefonos',
          'studio' => 'visible',
          'label' => 'LBL_LEAD_TELEFONOS',
          'span' => 12,
        ),
        47 => 
        array (
          'name' => 'detalle_plataforma_c',
          'studio' => 'visible',
          'label' => 'LBL_DETALLE_PLATAFORMA_C',
        ),
        48 => 
        array (
          'name' => 'oficina_c',
          'label' => 'LBL_OFICINA',
        ),
        49 => 
        array (
          'name' => 'nombre_de_cargar_c',
          'label' => 'LBL_NOMBRE_DE_CARGAR',
        ),
        50 => 
        array (
          'name' => 'alianza_c',
          'label' => 'LBL_ALIANZA_C',
        ),
        51 => 
        array (
          'name' => 'lead_cancelado_c',
          'label' => 'LBL_LEAD_CANCELADO_C',
        ),
        52 => 
        array (
          'name' => 'motivo_cancelacion_c',
          'label' => 'LBL_MOTIVO_CANCELACION_C',
        ),
        53 => 
        array (
          'name' => 'submotivo_cancelacion_c',
          'label' => 'LBL_SUBMOTIVO_CANCELACION_C',
          'span' => 12,
        ),
        54 => 
        array (
          'name' => 'assigned_user_name',
        ),
        55 => 
        array (
          'name' => 'account_to_lead',
          'label' => 'LBL_ACCOUNT',
          'readonly' => true,
        ),
        56 => 
        array (
          'name' => 'status_management_c',
          'label' => 'LBL_STATUS_MANAGEMENT',
        ),
        57 => 
        array (
          'name' => 'fecha_asignacion_c',
          'label' => 'LBL_FECHA_ASIGNACION_C',
        ),
        58 => 
        array (
          'name' => 'url_originacion_c',
          'label' => 'LBL_URL_ORIGINACION_C',
          'readonly' => true,
        ),
        59 => 
        array (
        ),
        60 => 
        array (
          'name' => 'contacto_asociado_c',
          'label' => 'LBL_CONTACTO_ASOCIADO_C',
        ),
        61 => 
        array (
          'name' => 'leads_leads_1_name',
          'label' => 'LBL_LEADS_LEADS_1_FROM_LEADS_L_TITLE',
        ),
        62 => 
        array (
          'name' => 'pb_division_c',
          'label' => 'LBL_PB_DIVISION',
        ),
        63 => 
        array (
          'name' => 'pb_grupo_c',
          'label' => 'LBL_PB_GRUPO',
        ),
        64 => 
        array (
          'name' => 'pb_clase_c',
          'label' => 'LBL_PB_CLASE',
        ),
        65 => 
        array (
          'name' => 'actividad_economica_c',
          'label' => 'LBL_ACTIVIDAD_ECONOMICA',
        ),
        66 => 
        array (
          'name' => 'sector_economico_c',
          'label' => 'LBL_SECTOR_ECONOMICO',
        ),
        67 => 
        array (
          'name' => 'subsector_c',
          'label' => 'LBL_SUBSECTOR',
        ),
        68 => 
        array (
          'name' => 'macrosector_c',
          'label' => 'LBL_MACROSECTOR_C',
        ),
        69 => 
        array (
          'name' => 'inegi_clase_c',
          'label' => 'LBL_INEGI_CLASE',
        ),
        70 => 
        array (
          'name' => 'inegi_macro_c',
          'label' => 'LBL_INEGI_MACRO',
        ),
        71 => 
        array (
          'name' => 'inegi_rama_c',
          'label' => 'LBL_INEGI_RAMA',
        ),
        72 => 
        array (
          'name' => 'inegi_sector_c',
          'label' => 'LBL_INEGI_SECTOR',
        ),
        73 => 
        array (
          'name' => 'inegi_subrama_c',
          'label' => 'LBL_INEGI_SUBRAMA',
        ),
        74 => 
        array (
          'name' => 'inegi_subsector_c',
          'label' => 'LBL_INEGI_SUBSECTOR',
        ),
        75 => 
        array (
          'name' => 'metodo_asignacion_lm_c',
          'label' => 'LBL_METODO_ASIGNACION_LM_C',
        ),
        76 => 
        array (
          'name' => 'homonimo_c',
          'label' => 'LBL_HOMONIMO',
        ),
        77 => 
        array (
          'name' => 'omite_match_c',
          'label' => 'LBL_OMITE_MATCH',
        ),
        78 => 
        array (
          'name' => 'blank_space',
          'label' => 'LBL_BLANK_SPACE',
        ),
        79 => 
        array (
        ),
        80 => 
        array (
          'name' => 'prospects_leads_1_name',
        ),
        81 => 
        array (
        ),
      ),
    ),
    2 => 
    array (
      'newTab' => false,
      'panelDefault' => 'expanded',
      'name' => 'LBL_RECORDVIEW_PANEL3',
      'label' => 'LBL_RECORDVIEW_PANEL3',
      'columns' => 2,
      'placeholders' => 1,
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'lead_direcciones',
          'studio' => 'visible',
          'label' => 'LBL_LEAD_DIRECCIONES',
          'span' => 12,
        ),
        1 => 
        array (
          'name' => 'geocode_status',
          'licenseFilter' => 
          array (
            0 => 'MAPS',
          ),
        ),
      ),
    ),
    3 => 
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
    4 => 
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
    5 => 
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
          'name' => 'leads_analizate_clientes',
          'studio' => 'visible',
          'label' => 'LBL_LEADS_ANALIZATE_CLIENTES',
          'span' => 12,
        ),
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'useTabs' => true,
  ),
);