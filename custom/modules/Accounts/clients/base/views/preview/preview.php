<?php
$viewdefs['Accounts'] = 
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
                'name' => 'control_dynamics_365_c',
                'label' => 'LBL_CONTROL_DYNAMICS_365_C',
              ),

              1 =>
              array (
                'name' => 'account_tipoSubtipo',
                'studio' => 'visible',
                'label' => 'LBL_ACCOUNT_TIPOSUBTIPO',
                'readonly' => true,
                'dismiss_label' => true,
                'span' => 12,
              ),
              2 =>
              array (
                'name' => 'rfc_qr',
                'label' => 'LBL_RFC_QR',
                'studio' => 'visible',
                'span' => 12,
              ),
              3 =>
              array (
                'name' => 'path_img_qr_c',
                'label' => 'LBL_PATH_IMG_QR',
                'span' => 12,
              ),
              4 =>
              array (
                'name' => 'nivel_digitalizacion_c',
                'label' => 'LBL_NIVEL_DIGITALIZACION_C',
              ),
              5 =>
              array (
                'name' => 'tipo_registro_cuenta_c',
                'label' => 'LBL_TIPO_REGISTRO_CUENTA',
              ),
              6 =>
              array (
                'name' => 'subtipo_registro_cuenta_c',
                'label' => 'LBL_SUBTIPO_REGISTRO_CUENTA',
              ),
              7 =>
              array (
                'name' => 'tct_prioridad_ddw_c',
              ),
              8 =>
              array (
                'name' => 'tct_homonimo_chk_c',
                'label' => 'LBL_TCT_HOMONIMO_CHK',
              ),
              9 =>
              array (
                'name' => 'esproveedor_c',
                'label' => 'LBL_ESPROVEEDOR',
              ),
              10 =>
              array (
                'name' => 'cedente_factor_c',
                'label' => 'LBL_CEDENTE_FACTOR',
              ),
              11 =>
              array (
                'name' => 'deudor_factor_c',
                'label' => 'LBL_DEUDOR_FACTOR',
              ),
              12 =>
              array (
                'name' => 'tct_no_contactar_chk_c',
                'label' => 'LBL_TCT_NO_CONTACTAR_CHK',
              ),
            ),
          ),
          2 =>
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
                'dismiss_label' => true,
              ),
            ),
          ),
          3 =>
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL19',
            'label' => 'LBL_RECORDVIEW_PANEL19',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'account_uni_productos',
                'studio' => 'visible',
                'label' => 'LBL_ACCOUNT_UNI_PRODUTOS',
                'span' => 12,
                'dismiss_label' => true,
              ),
            ),
          ),
          4 =>
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
                'name' => 'id_uniclick_c',
                'label' => 'LBL_ID_UNICLICK',
              ),
              1 => 
              array (
                'name' => 'estatus_persona_c',
                'label' => 'LBL_ESTATUS_PERSONA',
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
                'name' => 'puesto_cuenta_c',
                'label' => 'LBL_PUESTO_CUENTA_C',
              ),
              26 => 
              array (
                'name' => 'email',
              ),

            ),
          ),
          5 =>
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
                'name' => 'promotorrm_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTORRM_C',
                'initial_filter' => 'filterPromotorTemplate',
                'initial_filter_label' => 'LBL_FILTER_PROMOTOR_TEMPLATE',
                'filter_populate' => 
                array (
                  'tipodeproducto_c' => '11',
                ),
              ),
            ),
          ),
          6 =>
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
          7 =>
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
        ),
        'templateMeta' => 
        array (
          'maxColumns' => 1,
        ),
      ),
    ),
  ),
);
