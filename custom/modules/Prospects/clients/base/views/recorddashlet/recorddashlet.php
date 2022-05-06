<?php
$viewdefs['Prospects'] = 
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
            'events' => 
            array (
              'click' => 'button:cancel_button:click',
            ),
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
                'dismiss_label' => true,
              ),
              1 => 
              array (
                'name' => 'name_c',
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
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'readonly' => false,
                'name' => 'estatus_po_c',
                'label' => 'LBL_ESTATUS_PO',
              ),
              1 => 
              array (
                'readonly' => false,
                'name' => 'subestatus_po_c',
                'label' => 'LBL_SUBESTATUS_PO',
              ),
              2 => 
              array (
                'readonly' => false,
                'name' => 'detalle_subestatus_po_c',
                'label' => 'LBL_DETALLE_SUBESTATUS_PO',
              ),
              3 => 
              array (
              ),
              4 => 
              array (
                'readonly' => false,
                'name' => 'regimen_fiscal_c',
                'label' => 'LBL_REGIMEN_FISCAL_C',
              ),
              5 => 
              array (
                'readonly' => false,
                'name' => 'nombre_empresa_c',
                'label' => 'LBL_NOMBRE_EMPRESA_C',
              ),
              6 => 
              array (
                'readonly' => false,
                'name' => 'nombre_c',
                'label' => 'LBL_NOMBRE_C',
              ),
              7 => 
              array (
                'readonly' => false,
                'name' => 'apellido_paterno_c',
                'label' => 'LBL_APELLIDO_PATERNO_C',
              ),
              8 => 
              array (
                'readonly' => false,
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
                'readonly' => false,
                'name' => 'puesto_c',
                'label' => 'LBL_PUESTO_C',
              ),
              11 => 
              array (
              ),
              12 => 
              array (
                'readonly' => false,
                'name' => 'origen_c',
                'label' => 'LBL_ORIGEN_C',
              ),
              13 => 
              array (
                'readonly' => false,
                'name' => 'detalle_origen_c',
                'label' => 'LBL_DETALLE_ORIGEN_C',
              ),
              14 => 
              array (
                'readonly' => false,
                'name' => 'medio_digital_c',
                'label' => 'LBL_MEDIO_DIGITAL',
              ),
              15 => 
              array (
              ),
              16 => 
              array (
                'readonly' => false,
                'name' => 'referido_cliente_prov_c',
                'studio' => 'visible',
                'label' => 'LBL_REFERIDO_CLIENTE_PROV',
              ),
              17 => 
              array (
              ),
              18 => 
              array (
                'readonly' => false,
                'name' => 'codigo_expo_c',
                'label' => 'LBL_CODIGO_EXPO',
              ),
              19 => 
              array (
              ),
              20 => 
              array (
                'readonly' => false,
                'name' => 'prospeccion_propia_c',
                'label' => 'LBL_PROSPECCION_PROPIA',
              ),
              21 => 
              array (
              ),
              22 => 
              array (
                'readonly' => false,
                'name' => 'evento_c',
                'label' => 'LBL_EVENTO',
              ),
              23 => 
              array (
              ),
              24 => 
              array (
                'readonly' => false,
                'name' => 'camara_c',
                'label' => 'LBL_CAMARA_C',
              ),
              25 => 
              array (
              ),
              26 => 
              array (
                'readonly' => false,
                'name' => 'promotor_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTOR',
              ),
              27 => 
              array (
              ),
              28 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'readonly' => false,
                'name' => 'ventas_anuales_c',
                'label' => 'LBL_VENTAS_ANUALES_C',
              ),
              29 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'readonly' => false,
                'name' => 'potencial_lead_c',
                'label' => 'LBL_POTENCIAL_LEAD_C',
              ),
              30 => 
              array (
                'readonly' => false,
                'name' => 'rfc_c',
                'label' => 'LBL_RFC',
              ),
              31 => 
              array (
                'readonly' => false,
                'name' => 'zona_geografica_c',
                'label' => 'LBL_ZONA_GEOGRAFICA_C',
              ),
              32 => 
              array (
                'name' => 'email',
              ),
              33 => 
              array (
              ),
              34 => 
              array (
                'name' => 'prospects_telefonos',
                'studio' => 'visible',
                'label' => 'LBL_PROSPECTS_TELEFONOS',
                'span' => 12,
              ),
              35 => 'assigned_user_name',
              36 => 
              array (
                'readonly' => false,
                'name' => 'fecha_asignacion_c',
                'label' => 'LBL_FECHA_ASIGNACION',
              ),
              37 => 
              array (
                'readonly' => false,
                'name' => 'contacto_asociado_c',
                'label' => 'LBL_CONTACTO_ASOCIADO',
              ),
              38 => 
              array (
              ),
              39 => 
              array (
                'name' => 'account_name',
              ),
              40 => 
              array (
              ),
              41 => 
              array (
                'name' => 'prospects_prospects_1_name',
              ),
              42 => 
              array (
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
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'prospects_clasf_sectorial',
                'studio' => 'visible',
                'label' => 'LBL_PROSPECTS_CLASF_SECTORIAL',
                'span' => 12,
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
                'name' => 'prospects_direcciones',
                'studio' => 'visible',
                'label' => 'LBL_PROSPECTS_DIRECCIONES',
                'span' => 12,
              ),
            ),
          ),
          4 => 
          array (
            'name' => 'panel_hidden',
            'label' => 'LBL_RECORD_SHOWMORE',
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
                'name' => 'description',
                'related_fields' => 
                array (
                  0 => 'lead_id',
                ),
                'span' => 12,
              ),
              1 => 
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
            ),
          ),
          5 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL3',
            'label' => 'LBL_RECORDVIEW_PANEL3',
            'columns' => 2,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 'phone_work',
              1 => 'phone_mobile',
              2 => 
              array (
                'name' => 'phone_home',
                'comment' => 'Home phone number of the contact',
                'label' => 'LBL_HOME_PHONE',
              ),
              3 => 
              array (
                'readonly' => false,
                'name' => 'c_estatus_telefono_c',
                'studio' => 'visible',
                'label' => 'LBL_C_ESTATUS_TELEFONO',
              ),
              4 => 
              array (
                'readonly' => false,
                'name' => 'm_estatus_telefono_c',
                'studio' => 'visible',
                'label' => 'LBL_M_ESTATUS_TELEFONO',
              ),
              5 => 
              array (
                'readonly' => false,
                'name' => 'o_estatus_telefono_c',
                'studio' => 'visible',
                'label' => 'LBL_O_ESTATUS_TELEFONO',
              ),
              6 => 
              array (
                'readonly' => false,
                'name' => 'pendiente_reus_c',
                'label' => 'LBL_PENDIENTE_REUS',
              ),
              7 => 
              array (
                'readonly' => false,
                'name' => 'm_registro_reus_c',
                'label' => 'LBL_M_REGISTRO_REUS',
              ),
              8 => 
              array (
                'readonly' => false,
                'name' => 'o_registro_reus_c',
                'label' => 'LBL_O_REGISTRO_REUS',
              ),
              9 => 
              array (
                'readonly' => false,
                'name' => 'c_registro_reus_c',
                'label' => 'LBL_C_REGISTRO_REUS',
              ),
              10 => 
              array (
                'readonly' => false,
                'name' => 'actividad_economica_c',
                'label' => 'LBL_ACTIVIDAD_ECONOMICA',
              ),
              11 => 
              array (
                'readonly' => false,
                'name' => 'macrosector_c',
                'label' => 'LBL_MACROSECTOR',
              ),
              12 => 
              array (
                'readonly' => false,
                'name' => 'sector_economico_c',
                'label' => 'LBL_SECTOR_ECONOMICO',
              ),
              13 => 
              array (
                'readonly' => false,
                'name' => 'subsector_c',
                'label' => 'LBL_SUBSECTOR',
              ),
              14 => 
              array (
                'readonly' => false,
                'name' => 'inegi_clase_c',
                'label' => 'LBL_INEGI_CLASE_C',
              ),
              15 => 
              array (
                'readonly' => false,
                'name' => 'inegi_macro_c',
                'label' => 'LBL_INEGI_MACRO_C',
              ),
              16 => 
              array (
                'readonly' => false,
                'name' => 'inegi_sector_c',
                'label' => 'LBL_INEGI_SECTOR',
              ),
              17 => 
              array (
                'readonly' => false,
                'name' => 'inegi_subsector_c',
                'label' => 'LBL_INEGI_SUBSECTOR_C',
              ),
              18 => 
              array (
                'readonly' => false,
                'name' => 'inegi_rama_c',
                'label' => 'LBL_INEGI_RAMA',
              ),
              19 => 
              array (
                'readonly' => false,
                'name' => 'inegi_subrama_c',
                'label' => 'LBL_INEGI_SUBRAMA',
              ),
              20 => 
              array (
                'readonly' => false,
                'name' => 'pb_id_c',
                'label' => 'LBL_PB_ID',
              ),
              21 => 
              array (
                'readonly' => false,
                'name' => 'pb_grupo_c',
                'label' => 'LBL_PB_GRUPO',
              ),
              22 => 
              array (
                'readonly' => false,
                'name' => 'pb_clase_c',
                'label' => 'LBL_PB_CLASE',
              ),
              23 => 
              array (
                'readonly' => false,
                'name' => 'pb_division_c',
                'label' => 'LBL_PB_DIVISION',
              ),
              24 => 
              array (
                'readonly' => false,
                'name' => 'nombre_de_carga_c',
                'label' => 'LBL_NOMBRE_DE_CARGA',
              ),
              25 => 
              array (
                'readonly' => false,
                'name' => 'resultado_de_carga_c',
                'label' => 'LBL_RESULTADO_DE_CARGA',
              ),
              26 => 
              array (
                'readonly' => false,
                'name' => 'clean_name_c',
                'label' => 'LBL_CLEAN_NAME',
              ),
              27 => 
              array (
                'name' => 'team_name',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
