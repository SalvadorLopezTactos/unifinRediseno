<?php
$viewdefs['Leads'] = 
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
                'type' => 'fullname',
                'label' => 'LBL_NAME',
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
              ),
              1 => 
              array (
                'name' => 'subtipo_registro_c',
                'label' => 'LBL_SUBTIPO_REGISTRO',
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
                'name' => 'origen_busqueda_c',
                'label' => 'LBL_ORIGEN_BUSQUEDA_C',
              ),
              11 => 
              array (
              ),
              12 => 
              array (
                'name' => 'medio_digital_c',
                'label' => 'LBL_MEDIO_DIGITAL',
              ),
              13 => 
              array (
                'name' => 'punto_contacto_c',
                'label' => 'LBL_PUNTO_CONTACTO',
              ),
              14 => 
              array (
                'name' => 'evento_c',
                'label' => 'LBL_EVENTO_C',
              ),
              15 => 
              array (
              ),
              16 => 
              array (
                'name' => 'camara_c',
                'label' => 'LBL_CAMARA_C',
              ),
              17 => 
              array (
              ),
              18 => 
              array (
                'name' => 'origen_ag_tel_c',
                'studio' => 'visible',
                'label' => 'LBL_ORIGEN_AG_TEL_C',
              ),
              19 => 
              array (
                'name' => 'promotor_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTOR_C',
              ),
              20 => 
              array (
                'name' => 'macrosector_c',
                'label' => 'LBL_MACROSECTOR_C',
              ),
              21 => 
              array (
              ),
              22 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'ventas_anuales_c',
                'label' => 'LBL_VENTAS_ANUALES_C',
              ),
              23 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'potencial_lead_c',
                'label' => 'LBL_POTENCIAL_LEAD',
              ),
              24 => 
              array (
                'name' => 'zona_geografica_c',
                'label' => 'LBL_ZONA_GEOGRAFICA_C',
              ),
              25 => 
              array (
              ),
              26 => 
              array (
                'name' => 'email',
              ),
              27 => 
              array (
                'name' => 'phone_mobile',
              ),
              28 => 
              array (
                'name' => 'phone_home',
                'comment' => 'Home phone number of the contact',
                'label' => 'LBL_HOME_PHONE',
              ),
              29 => 'phone_work',
              30 => 
              array (
                'name' => 'motivo_cancelacion_c',
                'label' => 'LBL_MOTIVO_CANCELACION_C',
              ),
              31 => 
              array (
                'name' => 'submotivo_cancelacion_c',
                'label' => 'LBL_SUBMOTIVO_CANCELACION_C',
              ),
              32 => 
              array (
                'name' => 'assigned_user_name',
              ),
              33 => 
              array (
                'name' => 'leads_leads_1_name',
                'label' => 'LBL_LEADS_LEADS_1_FROM_LEADS_L_TITLE',
              ),
            ),
          ),
          2 => 
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
                'name' => 'nombre_de_cargar_c',
                'label' => 'LBL_NOMBRE_DE_CARGAR',
              ),
              1 => 
              array (
                'name' => 'resultado_de_carga_c',
                'label' => 'LBL_RESULTADO_DE_CARGA',
              ),
              2 => 
              array (
                'name' => 'clean_name_c',
                'label' => 'LBL_CLEAN_NAME',
              ),
              3 => 
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
