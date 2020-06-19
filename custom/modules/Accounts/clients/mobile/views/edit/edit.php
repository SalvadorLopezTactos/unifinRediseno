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
                'name' => 'tipo_registro_cuenta_c',
                'label' => 'LBL_TIPO_REGISTRO_CUENTA',
                'readonly' => true,
              ),
              1 => 
              array (
                'name' => 'subtipo_registro_cuenta_c',
                'label' => 'LBL_SUBTIPO_REGISTRO_CUENTA',
              ),
              2 => 
              array (
                'name' => 'cedente_factor_c',
                'label' => 'LBL_CEDENTE_FACTOR',
              ),
              3 => 
              array (
                'name' => 'estado_rfc_c',
                'label' => 'LBL_ESTADO_RFC',
                'css_class' => 'status_rfc hide',
              ),
              4 => 
              array (
                'name' => 'deudor_factor_c',
                'label' => 'LBL_DEUDOR_FACTOR',
              ),
              5 => 
              array (
                'name' => 'tct_no_contactar_chk_c',
                'label' => 'LBL_TCT_NO_CONTACTAR_CHK',
              ),
              6 => 
              array (
                'name' => 'origen_cuenta_c',
                'label' => 'LBL_ORIGEN_CUENTA_C',
              ),
              7 => 
              array (
                'name' => 'detalle_origen_c',
                'label' => 'LBL_DETALLE_ORIGEN_C',
              ),
              8 => 
              array (
                'name' => 'prospeccion_propia_c',
                'label' => 'LBL_PROSPECCION_PROPIA_C',
              ),
              9 => 
              array (
                'name' => 'referenciado_agencia_c',
                'label' => 'LBL_REFERENCIADO_AGENCIA',
              ),
              10 => 
              array (
                'name' => 'referido_cliente_prov_c',
                'studio' => 'visible',
                'label' => 'LBL_REFERIDO_CLIENTE_PROV',
              ),
              11 => 
              array (
                'name' => 'referenciador_c',
                'studio' => 'visible',
                'label' => 'LBL_REFERENCIADOR',
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
                'name' => 'medio_detalle_origen_c',
                'label' => 'LBL_MEDIO_DETALLE_ORIGEN_C',
              ),
              15 => 
              array (
                'name' => 'punto_contacto_origen_c',
                'label' => 'LBL_PUNTO_CONTACTO_ORIGEN_C',
              ),
              16 => 
              array (
                'name' => 'evento_c',
                'label' => 'LBL_EVENTO',
              ),
              17 => 
              array (
                'name' => 'camara_c',
                'label' => 'LBL_CAMARA',
              ),
              18 => 
              array (
                'name' => 'como_se_entero_c',
                'label' => 'LBL_COMO_SE_ENTERO',
              ),
              19 => 
              array (
                'name' => 'cual_c',
                'label' => 'LBL_CUAL',
              ),
              20 => 
              array (
                'name' => 'tct_origen_ag_tel_rel_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_ORIGEN_AG_TEL_REL',
              ),
              21 => 
              array (
                'name' => 'tct_que_promotor_rel_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_QUE_PROMOTOR_REL',
              ),
              22 => 
              array (
                'name' => 'reus_c',
                'label' => 'LBL_REUS',
              ),
              23 => 
              array (
                'name' => 'referenciabancaria_c',
                'label' => 'LBL_REFERENCIABANCARIA',
              ),
              24 => 
              array (
                'name' => 'alta_proveedor_c',
                'label' => 'LBL_ALTA_PROVEEDOR_C',
              ),
              25 => 
              array (
                'name' => 'tipo_proveedor_c',
                'label' => 'LBL_TIPO_PROVEEDOR',
              ),
              26 => 
              array (
                'name' => 'iva_c',
                'label' => 'LBL_IVA',
              ),
              27 => 
              array (
                'name' => 'es_referenciador_c',
                'label' => 'LBL_ES_REFERENCIADOR_C',
              ),
              28 => 
              array (
                'name' => 'tipodepersona_c',
                'label' => 'LBL_TIPODEPERSONA',
              ),
              29 => 
              array (
                'name' => 'primernombre_c',
                'label' => 'LBL_PRIMERNOMBRE',
              ),
              30 => 
              array (
                'name' => 'apellidopaterno_c',
                'label' => 'LBL_APELLIDOPATERNO',
              ),
              31 => 
              array (
                'name' => 'apellidomaterno_c',
                'label' => 'LBL_APELLIDOMATERNO',
              ),
              32 => 
              array (
                'name' => 'razonsocial_c',
                'label' => 'LBL_RAZONSOCIAL',
              ),
              33 => 
              array (
                'name' => 'nombre_comercial_c',
                'label' => 'LBL_NOMBRE_COMERCIAL',
              ),
              34 => 
              array (
                'name' => 'rfc_c',
                'label' => 'LBL_RFC',
              ),
              35 => 
              array (
                'name' => 'curp_c',
                'label' => 'LBL_CURP',
              ),
              36 => 
              array (
                'name' => 'parent_name',
                'label' => 'LBL_MEMBER_OF',
              ),
              37 => 
              array (
                'name' => 'fechadenacimiento_c',
                'label' => 'LBL_FECHADENACIMIENTO',
              ),
              38 => 
              array (
                'name' => 'fechaconstitutiva_c',
                'label' => 'LBL_FECHACONSTITUTIVA',
              ),
              39 => 
              array (
                'name' => 'pais_nacimiento_c',
                'label' => 'LBL_PAIS_NACIMIENTO_C',
              ),
              40 => 
              array (
                'name' => 'estado_nacimiento_c',
                'label' => 'LBL_ESTADO_NACIMIENTO',
              ),
              41 => 
              array (
                'name' => 'zonageografica_c',
                'label' => 'LBL_ZONAGEOGRAFICA',
              ),
              42 => 
              array (
                'name' => 'genero_c',
                'label' => 'LBL_GENERO',
              ),
              43 => 
              array (
                'name' => 'ifepasaporte_c',
                'label' => 'LBL_IFEPASAPORTE',
              ),
              44 => 
              array (
                'name' => 'estadocivil_c',
                'label' => 'LBL_ESTADOCIVIL',
              ),
              45 => 
              array (
                'name' => 'regimenpatrimonial_c',
                'label' => 'LBL_REGIMENPATRIMONIAL',
              ),
              46 => 
              array (
                'name' => 'profesion_c',
                'label' => 'LBL_PROFESION',
              ),
              47 => 
              array (
                'name' => 'puesto_cuenta_c',
                'label' => 'LBL_PUESTO_CUENTA_C',
              ),
              48 => 'email',
              49 => 
              array (
                'name' => 'website',
                'displayParams' => 
                array (
                  'type' => 'link',
                ),
              ),
              50 => 
              array (
                'name' => 'facebook',
                'comment' => 'The facebook name of the company',
                'label' => 'LBL_FACEBOOK',
              ),
              51 => 
              array (
                'name' => 'twitter',
                'comment' => 'The twitter name of the company',
                'label' => 'LBL_TWITTER',
              ),
              52 => 
              array (
                'name' => 'linkedin_c',
                'label' => 'LBL_LINKEDIN',
              ),
              53 => 
              array (
                'name' => 'referencia_bancaria_c',
                'label' => 'LBL_REFERENCIA_BANCARIA_C',
              ),
              54 => 
              array (
                'name' => 'tct_macro_sector_ddw_c',
                'label' => 'LBL_TCT_MACRO_SECTOR_DDW',
              ),
              55 => 
              array (
              ),
              56 => 
              array (
                'name' => 'sectoreconomico_c',
                'label' => 'LBL_SECTORECONOMICO',
              ),
              57 => 
              array (
                'name' => 'subsectoreconomico_c',
                'label' => 'LBL_SUBSECTORECONOMICO',
              ),
              58 => 
              array (
                'name' => 'actividadeconomica_c',
                'label' => 'LBL_ACTIVIDADECONOMICA',
              ),
              59 => 
              array (
                'name' => 'empleados_c',
                'label' => 'LBL_EMPLEADOS',
              ),
              60 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'ventas_anuales_c',
                'label' => 'LBL_VENTAS_ANUALES',
              ),
              61 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'activo_fijo_c',
                'label' => 'LBL_ACTIVO_FIJO',
              ),
              62 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'potencial_cuenta_c',
                'label' => 'LBL_POTENCIAL_CUENTA',
              ),
              63 => 
              array (
                'name' => 'promotorleasing_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTORLEASING',
                'css_class' => 'promotor_class',
              ),
              64 => 
              array (
                'name' => 'promotorfactoraje_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTORFACTORAJE',
              ),
              65 => 
              array (
                'name' => 'promotorcredit_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTORCREDIT',
              ),
              66 => 
              array (
                'name' => 'promotorfleet_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTORFLEET',
              ),
              67 => 
              array (
                'name' => 'promotoruniclick_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTORUNICLICK_C',
              ),
              68 => 
              array (
                'name' => 'canal_uniclick_mobile',
                'type' => 'canal_uniclick_mobile',
                'studio' => 'visible',
                'label' => 'Producto Uniclick',
              ),
              69 => 
              array (
                'name' => 'no_viable',
                'type' => 'no_viable',
                'studio' => 'visible',
                'label' => 'Lead No viable',
              ),
              70 => 'phone_office',
              71 => 
              array (
                'name' => 'clean_name',
                'studio' => 'visible',
                'label' => 'LBL_CLEAN_NAME',
                'css_class' => 'hide',
              ),
              72 => 
              array (
                'name' => 'account_uni_productos',
                'studio' => 'visible',
                'label' => 'LBL_ACCOUNT_UNI_PRODUTOS',
                'css_class' => 'hide',
              ),
              73 => 
              array (
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
