<?php
$viewdefs['Leads'] = 
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
                'readonly' => true,
                'dismiss_label' => true,
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
                'name' => 'tipo_registro_c',
                'label' => 'LBL_TIPO_REGISTRO',
                'readonly' => true,
              ),
              1 => 
              array (
                'name' => 'subtipo_registro_c',
                'label' => 'LBL_SUBTIPO_REGISTRO',
                'readonly' => true,
              ),
              2 => 
              array (
                'name' => 'regimen_fiscal_c',
                'studio' => 'visible',
                'label' => 'LBL_REGIMEN_FISCAL',
              ),
              3 => 
              array (
                'name' => 'nombre_empresa_c',
                'label' => 'LBL_NOMBRE_EMPRESA',
              ),
              4 => 
              array (
                'name' => 'nombre_c',
                'label' => 'LBL_NOMBRE',
              ),
              5 => 
              array (
                'name' => 'apellido_paterno_c',
                'label' => 'LBL_APELLIDO_PATERNO_C',
              ),
              6 => 
              array (
                'name' => 'apellido_materno_c',
                'label' => 'LBL_APELLIDO_MATERNO_C',
              ),
              7 => 
              array (
                'name' => 'puesto_c',
                'label' => 'LBL_PUESTO_C',
              ),
              8 => 
              array (
                'name' => 'origen_c',
                'label' => 'LBL_ORIGEN',
              ),
              9 => 
              array (
                'name' => 'detalle_origen_c',
                'label' => 'LBL_DETALLE_ORIGEN',
              ),
              10 => 
              array (
                'name' => 'prospeccion_propia_c',
                'label' => 'LBL_PROSPECCION_PROPIA',
                'span' => 12,
              ),
              11 => 
              array (
                'name' => 'medio_digital_c',
                'label' => 'LBL_MEDIO_DIGITAL',
              ),
              12 => 
              array (
                'name' => 'punto_contacto_c',
                'label' => 'LBL_PUNTO_CONTACTO',
              ),
              13 => 
              array (
                'name' => 'origen_busqueda_c',
                'label' => 'LBL_ORIGEN_BUSQUEDA_C',
                'span' => 12,
              ),
              14 => 
              array (
                'name' => 'evento_c',
                'label' => 'LBL_EVENTO_C',
                'span' => 12,
              ),
              15 => 
              array (
                'name' => 'camara_c',
                'label' => 'LBL_CAMARA_C',
                'span' => 12,
              ),
              16 => 
              array (
                'name' => 'origen_ag_tel_c',
                'studio' => 'visible',
                'label' => 'LBL_ORIGEN_AG_TEL_C',
              ),
              17 => 
              array (
                'name' => 'promotor_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTOR_C',
              ),
              18 => 
              array (
                'name' => 'macrosector_c',
                'label' => 'LBL_MACROSECTOR_C',
                'span' => 12,
              ),
              19 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'ventas_anuales_c',
                'label' => 'LBL_VENTAS_ANUALES_C',
              ),
              20 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'potencial_lead_c',
                'label' => 'LBL_POTENCIAL_LEAD',
              ),
              21 => 
              array (
                'name' => 'zona_geografica_c',
                'label' => 'LBL_ZONA_GEOGRAFICA_C',
              ),
              22 => 
              array (
              ),
              23 => 
              array (
                'name' => 'email',
              ),
              24 => 
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
                    'css_class' => 'llamada_mobile btn sicon sicon-phone fa-large btn-success',
                  ),
                  1 => 
                  array (
                    'name' => 'phone_mobile',
                  ),
                ),
              ),
              25 => 
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
                    'css_class' => 'llamada_home btn sicon sicon-phone fa-large btn-success',
                  ),
                  1 => 
                  array (
                    'name' => 'phone_home',
                  ),
                ),
              ),
              26 => 
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
                    'css_class' => 'llamada_work btn sicon sicon-phone fa-large btn-success',
                  ),
                  1 => 
                  array (
                    'name' => 'phone_work',
                  ),
                ),
              ),
              27 => 
              array (
                'name' => 'detalle_plataforma_c',
                'studio' => 'visible',
                'label' => 'LBL_DETALLE_PLATAFORMA_C',
              ),
              28 => 
              array (
                'name' => 'oficina_c',
                'label' => 'LBL_OFICINA',
              ),
              29 => 
              array (
                'name' => 'nombre_de_cargar_c',
                'label' => 'LBL_NOMBRE_DE_CARGAR',
              ),
              30 => 
              array (
                'name' => 'alianza_c',
                'label' => 'LBL_ALIANZA_C',
              ),
              31 => 
              array (
                'name' => 'lead_cancelado_c',
                'label' => 'LBL_LEAD_CANCELADO_C',
              ),
              32 => 
              array (
                'name' => 'motivo_cancelacion_c',
                'label' => 'LBL_MOTIVO_CANCELACION_C',
              ),
              33 => 
              array (
                'name' => 'submotivo_cancelacion_c',
                'label' => 'LBL_SUBMOTIVO_CANCELACION_C',
                'span' => 12,
              ),
              34 => 
              array (
                'name' => 'assigned_user_name',
              ),
              35 => 
              array (
                'name' => 'account_to_lead',
                'label' => 'LBL_ACCOUNT',
                'readonly' => true,
              ),
              36 => 
              array (
                'name' => 'status_management_c',
                'label' => 'LBL_STATUS_MANAGEMENT',
              ),
              37 => 
              array (
                'name' => 'fecha_asignacion_c',
                'label' => 'LBL_FECHA_ASIGNACION_C',
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
                'name' => 'blank_space',
                'label' => 'LBL_BLANK_SPACE',
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
