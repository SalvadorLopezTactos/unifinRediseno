<?php
$viewdefs['Accounts'] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'detail' => 
      array (
        'templateMeta' => 
        array (
          'maxColumns' => '1',
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
                'name' => 'name',
                'displayParams' => 
                array (
                  'required' => true,
                  'wireless_edit_only' => true,
                ),
              ),
              1 => 
              array (
                'name' => 'tipo_registro_c',
                'studio' => 'visible',
                'label' => 'LBL_TIPO_REGISTRO',
                'readonly' => true,
              ),
              2 => 
              array (
                'name' => 'subtipo_cuenta_c',
                'label' => 'LBL_SUBTIPO_CUENTA',
              ),
              3 => 
              array (
                'name' => 'esproveedor_c',
                'label' => 'LBL_ESPROVEEDOR',
              ),
              4 => 
              array (
                'name' => 'cedente_factor_c',
                'label' => 'LBL_CEDENTE_FACTOR',
              ),
              5 => 
              array (
                'name' => 'deudor_factor_c',
                'label' => 'LBL_DEUDOR_FACTOR',
              ),
              6 => 
              array (
                'name' => 'origendelprospecto_c',
                'studio' => 'visible',
                'label' => 'LBL_ORIGENDELPROSPECTO',
              ),
              7 => 
              array (
                'name' => 'tct_detalle_origen_ddw_c',
                'label' => 'LBL_TCT_DETALLE_ORIGEN_DDW',
              ),
              8 => 
              array (
                'name' => 'metodo_prospeccion_c',
                'studio' => 'visible',
                'label' => 'LBL_METODO_PROSPECCION',
              ),
              9 => 
              array (
                'name' => 'referido_cliente_prov_c',
                'studio' => 'visible',
                'label' => 'LBL_REFERIDO_CLIENTE_PROV',
              ),
              10 => 
              array (
                'name' => 'referenciado_agencia_c',
                'label' => 'LBL_REFERENCIADO_AGENCIA',
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
                'name' => 'referencia_bancaria_c',
                'label' => 'LBL_REFERENCIA_BANCARIA_C',
              ),
              24 => 
              array (
                'name' => 'alta_proveedor_c',
                'label' => 'LBL_ALTA_PROVEEDOR_C',
              ),
              25 => 
              array (
                'name' => 'tipo_proveedor_c',
                'studio' => 'visible',
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
                'studio' => 'visible',
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
                'type' => 'button',
                'name' => 'generar_rfc_c',
                'label' => 'LBL_GENERAR_RFC',
              ),
              36 => 
              array (
                'name' => 'curp_c',
                'label' => 'LBL_CURP',
              ),
              37 => 
              array (
                'type' => 'button',
                'name' => 'generar_curp_c',
                'label' => 'LBL_GENERAR_CURP',
              ),
              38 => 
              array (
                'name' => 'parent_name',
              ),
              39 => 
              array (
                'name' => 'fechaconstitutiva_c',
                'label' => 'LBL_FECHACONSTITUTIVA',
              ),
              40 => 
              array (
                'name' => 'fechadenacimiento_c',
                'label' => 'LBL_FECHADENACIMIENTO',
              ),
              41 => 
              array (
                'name' => 'pais_nacimiento_c',
                'studio' => 'visible',
                'label' => 'LBL_PAIS_NACIMIENTO',
              ),
              42 => 
              array (
                'name' => 'estado_nacimiento_c',
                'studio' => 'visible',
                'label' => 'LBL_ESTADO_NACIMIENTO',
              ),
              43 => 
              array (
                'span' => 12,
              ),
              44 => 
              array (
                'name' => 'zonageografica_c',
                'studio' => 'visible',
                'label' => 'LBL_ZONAGEOGRAFICA',
              ),
              45 => 
              array (
                'name' => 'genero_c',
                'studio' => 'visible',
                'label' => 'LBL_GENERO',
              ),
              46 => 
              array (
                'name' => 'ifepasaporte_c',
                'label' => 'LBL_IFEPASAPORTE',
              ),
              47 => 
              array (
                'name' => 'estadocivil_c',
                'studio' => 'visible',
                'label' => 'LBL_ESTADOCIVIL',
              ),
              48 => 
              array (
                'name' => 'regimenpatrimonial_c',
                'studio' => 'visible',
                'label' => 'LBL_REGIMENPATRIMONIAL',
              ),
              49 => 
              array (
                'name' => 'profesion_c',
                'studio' => 'visible',
                'label' => 'LBL_PROFESION',
              ),
              50 => 
              array (
                'name' => 'puesto_c',
                'label' => 'LBL_PUESTO',
              ),
              51 => 
              array (
                'name' => 'email',
              ),
              52 => 
              array (
                'name' => 'website',
                'displayParams' => 
                array (
                  'type' => 'link',
                ),
              ),
              53 => 
              array (
                'name' => 'facebook',
                'comment' => 'The facebook name of the company',
                'label' => 'LBL_FACEBOOK',
              ),
              54 => 
              array (
                'name' => 'twitter',
                'comment' => 'The twitter name of the company',
                'label' => 'LBL_TWITTER',
              ),
              55 => 
              array (
                'name' => 'linkedin_c',
                'label' => 'LBL_LINKEDIN',
              ),
              56 => 
              array (
                'name' => 'referenciabancaria_c',
                'label' => 'LBL_REFERENCIABANCARIA',
              ),
              57 => 
              array (
                'name' => 'tct_macro_sector_ddw_c',
                'label' => 'LBL_TCT_MACRO_SECTOR_DDW',
              ),
              58 => 
              array (
                'name' => 'sectoreconomico_c',
                'label' => 'LBL_SECTORECONOMICO',
              ),
              59 => 
              array (
                'name' => 'subsectoreconomico_c',
                'studio' => 'visible',
                'label' => 'LBL_SUBSECTORECONOMICO',
              ),
              60 => 
              array (
                'name' => 'actividadeconomica_c',
                'studio' => 'visible',
                'label' => 'LBL_ACTIVIDADECONOMICA',
              ),
              61 => 
              array (
                'name' => 'empleados_c',
                'label' => 'LBL_EMPLEADOS',
              ),
              62 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'ventas_anuales_c',
                'label' => 'LBL_VENTAS_ANUALES',
              ),
              63 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'activo_fijo_c',
                'label' => 'LBL_ACTIVO_FIJO',
              ),
              64 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'potencial_cuenta_c',
                'label' => 'LBL_POTENCIAL_CUENTA',
              ),
              65 => 
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
              66 => 
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
              67 => 
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
              68 => 
              array (
                'name' => 'promotorfleet_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTORFLEET',
              ),
              69 => 
              array (
                'name' => 'promotoruniclick_c',
                'studio' => 'visible',
                'label' => 'LBL_PROMOTORUNICLICK_C',
              ),
              70 => 'phone_office',
            ),
          ),
        ),
      ),
    ),
  ),
);
