<?php
$module_name = 'TCT1_P_Fideicomiso';
$viewdefs[$module_name] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'record' => 
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
              2 => 
              array (
                'name' => 'favorite',
                'label' => 'LBL_FAVORITE',
                'type' => 'favorite',
                'readonly' => true,
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
                'name' => 'tct_tipo_ddw',
                'studio' => 'visible',
                'label' => 'LBL_TCT_TIPO_DDW',
              ),
              1 => 
              array (
                'name' => 'tct_regimen_fiscal_ddw',
                'studio' => 'visible',
                'label' => 'LBL_TCT_REGIMEN_FISCAL_DDW',
              ),
              2 => 
              array (
                'name' => 'tct_ocupacion_txf',
                'label' => 'LBL_TCT_OCUPACION_TXF',
                'span' => 12,
              ),
              3 => 
              array (
                'name' => 'tct_fecha_nacimiento_dat',
                'label' => 'LBL_TCT_FECHA_NACIMIENTO_DAT',
              ),
              4 => 
              array (
                'name' => 'tct_genero_ddw',
                'studio' => 'visible',
                'label' => 'LBL_TCT_GENERO_DDW',
              ),
              5 => 
              array (
                'name' => 'tct_pais_nacimiento_txf',
                'label' => 'LBL_TCT_PAIS_NACIMIENTO_TXF',
              ),
              6 => 
              array (
                'name' => 'tct_nacionalidad_txf',
                'label' => 'LBL_TCT_NACIONALIDAD_TXF',
              ),
              7 => 
              array (
                'name' => 'tct_rfc_txf',
                'label' => 'LBL_TCT_RFC_TXF',
              ),
              8 => 
              array (
                'name' => 'tct_no_serie_firma_txf',
                'label' => 'LBL_TCT_NO_SERIE_FIRMA_TXF',
              ),
              9 => 
              array (
                'name' => 'tct_curp_txf',
                'label' => 'LBL_TCT_CURP_TXF',
              ),
              10 => 
              array (
                'name' => 'tct_correo_electronico_txf',
                'label' => 'LBL_TCT_CORREO_ELECTRONICO_TXF',
              ),
              11 => 
              array (
                'name' => 'tct_domicilio_txf',
                'label' => 'LBL_TCT_DOMICILIO_TXF',
                'span' => 12,
              ),
              12 => 
              array (
                'name' => 'tct_telefono_tel',
                'label' => 'LBL_TCT_TELEFONO_TEL',
              ),
              13 => 
              array (
                'name' => 'tct_calle_txf',
                'label' => 'LBL_TCT_CALLE_TXF',
              ),
              14 => 
              array (
                'name' => 'tct_num_exterior_txf',
                'label' => 'LBL_TCT_NUM_EXTERIOR_TXF',
              ),
              15 => 
              array (
                'name' => 'tct_num_interior_txf',
                'label' => 'LBL_TCT_NUM_INTERIOR_TXF',
              ),
              16 => 
              array (
                'name' => 'tct_colonia_txf',
                'label' => 'LBL_TCT_COLONIA_TXF',
              ),
              17 => 
              array (
                'name' => 'tct_delegacion_txf',
                'label' => 'LBL_TCT_DELEGACION_TXF',
              ),
              18 => 
              array (
                'name' => 'tct_ciudad_txf',
                'label' => 'LBL_TCT_CIUDAD_TXF',
              ),
              19 => 
              array (
                'name' => 'tct_codigo_postal_txf',
                'label' => 'LBL_TCT_CODIGO_POSTAL_TXF',
              ),
              20 => 
              array (
                'name' => 'tct_entidad_federativa_txf',
                'label' => 'LBL_TCT_ENTIDAD_FEDERATIVA_TXF',
              ),
              21 => 
              array (
                'name' => 'tct_pais_txf',
                'label' => 'LBL_TCT_PAIS_TXF',
              ),
              22 => 
              array (
                'name' => 'tct_preg_v_ddw',
                'studio' => 'visible',
                'label' => 'LBL_TCT_PREG_V_DDW',
              ),
              23 => 
              array (
                'name' => 'tct_preg_w_ddw',
                'studio' => 'visible',
                'label' => 'LBL_TCT_PREG_W_DDW',
              ),
              24 => 
              array (
                'name' => 'tct_nombre_socio_txf',
                'label' => 'LBL_TCT_NOMBRE_SOCIO_TXF',
              ),
              25 => 
              array (
                'name' => 'tct_nombre_accionista_rel_txf',
                'label' => 'LBL_TCT_NOMBRE_ACCIONISTA_REL_TXF',
              ),
              26 => 
              array (
                'name' => 'tct_cargo_publico_txf',
                'label' => 'LBL_TCT_CARGO_PUBLICO_TXF',
              ),
              27 => 
              array (
                'name' => 'tct_especificar_parentsco_txf',
                'label' => 'LBL_TCT_ESPECIFICAR_PARENTSCO_TXF',
              ),
              28 => 
              array (
                'name' => 'tct_dependencia_txf',
                'label' => 'LBL_TCT_DEPENDENCIA_TXF',
              ),
              29 => 
              array (
                'name' => 'tct_nombre_persona_puesto_txf',
                'label' => 'LBL_TCT_NOMBRE_PERSONA_PUESTO_TXF',
              ),
              30 => 
              array (
                'name' => 'tct_periodo_txf',
                'label' => 'LBL_TCT_PERIODO_TXF',
              ),
              31 => 
              array (
                'name' => 'tct_cargo_publico_fam_txf',
                'label' => 'LBL_TCT_CARGO_PUBLICO_FAM_TXF',
              ),
              32 => 
              array (
                'name' => 'tct_fecha_inicio_dat',
                'label' => 'LBL_TCT_FECHA_INICIO_DAT',
              ),
              33 => 
              array (
                'name' => 'tct_dependencia_fam_txf',
                'label' => 'LBL_TCT_DEPENDENCIA_FAM_TXF',
              ),
              34 => 
              array (
                'name' => 'tct_fecha_termino_dat',
                'label' => 'LBL_TCT_FECHA_TERMINO_DAT',
              ),
              35 => 
              array (
                'name' => 'tct_periodo_fam_txf',
                'label' => 'LBL_TCT_PERIODO_FAM_TXF',
              ),
              36 => 
              array (
              ),
              37 => 
              array (
                'name' => 'tct_fecha_inicio_fam_dat',
                'label' => 'LBL_TCT_FECHA_INICIO_FAM_DAT',
              ),
              38 => 
              array (
              ),
              39 => 
              array (
                'name' => 'tct_fecha_termino_fam_dat',
                'label' => 'LBL_TCT_FECHA_TERMINO_FAM_DAT',
              ),
            ),
          ),
          2 => 
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
                'name' => 'date_modified_by',
                'readonly' => true,
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
              1 => 
              array (
                'name' => 'date_entered_by',
                'readonly' => true,
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
            ),
          ),
        ),
        'templateMeta' => 
        array (
          'useTabs' => false,
        ),
      ),
    ),
  ),
);
