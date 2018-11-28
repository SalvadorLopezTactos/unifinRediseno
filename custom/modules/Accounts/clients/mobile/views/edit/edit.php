<?php
$viewdefs['Accounts'] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'edit' => 
      array (
        'templateMeta' => 
        array (
          'maxColumns' => '2∫',
          'widths' => 
          array (
            0 => 
            array (
              'label' => '10',
              'field' => '30',
            ),
          ),
          'useTabs' => false,
        ),
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_PANEL_DEFAULT',
            'columns' => '1',
            'labelsOnTop' => 1,
            'placeholders' => 1,
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
                'name' => 'subtipo_cuenta_c',
                'label' => 'LBL_SUBTIPO_CUENTA',
              ),
              2 => 
              array (
                'name' => 'esproveedor_c',
                'label' => 'LBL_ESPROVEEDOR',
              ),
              3 => 
              array (
                'name' => 'cedente_factor_c',
                'label' => 'LBL_CEDENTE_FACTOR',
              ),
              4 => 
              array (
                'name' => 'deudor_factor_c',
                'label' => 'LBL_DEUDOR_FACTOR',
              ),
              5 => 
              array (
                'name' => 'origendelprospecto_c',
                'label' => 'LBL_ORIGENDELPROSPECTO',
              ),
              6 => 
              array (
                'name' => 'tct_detalle_origen_ddw_c',
                'label' => 'LBL_TCT_DETALLE_ORIGEN_DDW',
              ),
              7 => 
              array (
                'name' => 'metodo_prospeccion_c',
                'label' => 'LBL_METODO_PROSPECCION',
              ),
              8 => 
              array (
                'name' => 'referenciado_agencia_c',
                'label' => 'LBL_REFERENCIADO_AGENCIA',
              ),
              9 => 
              array (
                'name' => 'referido_cliente_prov_c',
                'studio' => 'visible',
                'label' => 'LBL_REFERIDO_CLIENTE_PROV',
              ),
              10 => 
              array (
                'name' => 'referenciador_c',
                'studio' => 'visible',
                'label' => 'LBL_REFERENCIADOR',
              ),
              11 => 
              array (
                'name' => 'tct_origen_busqueda_txf_c',
                'label' => 'LBL_TCT_ORIGEN_BUSQUEDA_TXF',
              ),
              12 => 
              array (
                'name' => 'tct_origen_base_ddw_c',
                'label' => 'LBL_TCT_ORIGEN_BASE_DDW',
              ),
              13 => 
              array (
                'name' => 'medio_digital_c',
                'label' => 'LBL_MEDIO_DIGITAL',
              ),
              14 => 
              array (
                'name' => 'tct_punto_contacto_ddw_c',
                'label' => 'LBL_TCT_PUNTO_CONTACTO_DDW',
              ),
              15 => 
              array (
                'name' => 'evento_c',
                'label' => 'LBL_EVENTO',
              ),
              16 => 
              array (
                'name' => 'camara_c',
                'label' => 'LBL_CAMARA',
              ),
              17 => 
              array (
                'name' => 'como_se_entero_c',
                'label' => 'LBL_COMO_SE_ENTERO',
              ),
              18 => 
              array (
                'name' => 'cual_c',
                'label' => 'LBL_CUAL',
              ),
              19 => 
              array (
                'name' => 'tct_origen_ag_tel_rel_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_ORIGEN_AG_TEL_REL',
              ),
              20 => 
              array (
                'name' => 'tct_que_promotor_rel_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_QUE_PROMOTOR_REL',
              ),
              21 => 
              array (
                'name' => 'reus_c',
                'label' => 'LBL_REUS',
              ),
              22 => 
              array (
                'name' => 'referenciabancaria_c',
                'label' => 'LBL_REFERENCIABANCARIA',
              ),
              23 => 
              array (
                'name' => 'alta_proveedor_c',
                'label' => 'LBL_ALTA_PROVEEDOR_C',
              ),
              24 => 
              array (
                'name' => 'tipo_proveedor_c',
                'label' => 'LBL_TIPO_PROVEEDOR',
              ),
              25 => 
              array (
                'name' => 'iva_c',
                'label' => 'LBL_IVA',
              ),
              26 => 
              array (
                'name' => 'es_referenciador_c',
                'label' => 'LBL_ES_REFERENCIADOR_C',
              ),
              27 => 
              array (
                'name' => 'tipodepersona_c',
                'label' => 'LBL_TIPODEPERSONA',
              ),
              28 => 
              array (
                'name' => 'primernombre_c',
                'label' => 'LBL_PRIMERNOMBRE',
              ),
              29 => 
              array (
                'name' => 'apellidopaterno_c',
                'label' => 'LBL_APELLIDOPATERNO',
              ),
              30 => 
              array (
                'name' => 'apellidomaterno_c',
                'label' => 'LBL_APELLIDOMATERNO',
              ),
              31 => 
              array (
                'name' => 'razonsocial_c',
                'label' => 'LBL_RAZONSOCIAL',
              ),
              32 => 
              array (
                'name' => 'nombre_comercial_c',
                'label' => 'LBL_NOMBRE_COMERCIAL',
              ),
              33 => 
              array (
                'name' => 'rfc_c',
                'label' => 'LBL_RFC',
              ),
              34 => 
              array (
                'name' => 'generar_rfc_c',
                'label' => 'LBL_GENERAR_RFC',
              ),
              35 => 
              array (
                'name' => 'curp_c',
                'label' => 'LBL_CURP',
              ),
              36 => 
              array (
                'name' => 'generar_curp_c',
                'label' => 'LBL_GENERAR_CURP',
              ),
              37 => 
              array (
                'name' => 'parent_name',
                'label' => 'LBL_MEMBER_OF',
              ),
              38 => 
              array (
                'name' => 'fechadenacimiento_c',
                'label' => 'LBL_FECHADENACIMIENTO',
              ),
              39 => 
              array (
                'name' => 'fechaconstitutiva_c',
                'label' => 'LBL_FECHACONSTITUTIVA',
              ),
              40 => 
              array (
                'name' => 'pais_nacimiento_c',
                'label' => 'LBL_PAIS_NACIMIENTO_C',
              ),
              41 => 
              array (
                'name' => 'estado_nacimiento_c',
                'label' => 'LBL_ESTADO_NACIMIENTO',
              ),
              42 => 
              array (
                'name' => 'zonageografica_c',
                'label' => 'LBL_ZONAGEOGRAFICA',
              ),
              43 => 
              array (
                'name' => 'genero_c',
                'label' => 'LBL_GENERO',
              ),
              44 => 
              array (
                'name' => 'ifepasaporte_c',
                'label' => 'LBL_IFEPASAPORTE',
              ),
              45 => 
              array (
                'name' => 'estadocivil_c',
                'label' => 'LBL_ESTADOCIVIL',
              ),
              46 => 
              array (
                'name' => 'regimenpatrimonial_c',
                'label' => 'LBL_REGIMENPATRIMONIAL',
              ),
              47 => 
              array (
                'name' => 'profesion_c',
                'label' => 'LBL_PROFESION',
              ),
              48 => 
              array (
                'name' => 'puesto_c',
                'label' => 'LBL_PUESTO',
              ),
              49 => 'email',
              50 => 
              array (
                'name' => 'website',
                'displayParams' => 
                array (
                  'type' => 'link',
                ),
              ),
              51 => 
              array (
                'name' => 'facebook',
                'comment' => 'The facebook name of the company',
                'label' => 'LBL_FACEBOOK',
              ),
              52 => 
              array (
                'name' => 'twitter',
                'comment' => 'The twitter name of the company',
                'label' => 'LBL_TWITTER',
              ),
              53 => 
              array (
                'name' => 'linkedin_c',
                'label' => 'LBL_LINKEDIN',
              ),
              54 => 
              array (
                'name' => 'referencia_bancaria_c',
                'label' => 'LBL_REFERENCIA_BANCARIA_C',
              ),
              55 => 
              array (
                'name' => 'tct_macro_sector_ddw_c',
                'label' => 'LBL_TCT_MACRO_SECTOR_DDW',
              ),
              56 => 
              array (
              ),
              57 => 
              array (
                'name' => 'sectoreconomico_c',
                'label' => 'LBL_SECTORECONOMICO',
              ),
              58 => 
              array (
                'name' => 'subsectoreconomico_c',
                'label' => 'LBL_SUBSECTORECONOMICO',
              ),
              59 => 
              array (
                'name' => 'actividadeconomica_c',
                'label' => 'LBL_ACTIVIDADECONOMICA',
              ),
              60 => 
              array (
                'name' => 'empleados_c',
                'label' => 'LBL_EMPLEADOS',
              ),
              61 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'ventas_anuales_c',
                'label' => 'LBL_VENTAS_ANUALES',
              ),
              62 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'activo_fijo_c',
                'label' => 'LBL_ACTIVO_FIJO',
              ),
              63 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'potencial_cuenta_c',
                'label' => 'LBL_POTENCIAL_CUENTA',
              ),
              64 => 
              array (
                'name' => 'promotorleasing_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTORLEASING',
                'css_class' => 'promotor_class',
              ),
              65 => 
              array (
                'name' => 'promotorfactoraje_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTORFACTORAJE',
              ),
              66 => 
              array (
                'name' => 'promotorcredit_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTORCREDIT',
              ),
              67 => 'phone_office',
              68 => 
              array (
                'span' => 12,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
