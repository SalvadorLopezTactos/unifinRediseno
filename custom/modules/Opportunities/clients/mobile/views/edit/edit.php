<?php
$viewdefs['Opportunities'] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'edit' => 
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
            'name' => 'LBL_PANEL_DEFAULT',
            'columns' => '1',
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'newTab' => false,
            'panelDefault' => 'expanded',
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
                'name' => 'tct_etapa_ddw_c',
                'label' => 'LBL_TCT_ETAPA_DDW_C',
              ),
              2 => 
              array (
                'name' => 'estatus_c',
                'label' => 'LBL_ESTATUS',
              ),
              3 => 
              array (
                'readonly' => true,
                'name' => 'idsolicitud_c',
                'label' => 'LBL_IDSOLICITUD',
              ),
              4 => 
              array (
                'name' => 'id_process_c',
                'label' => 'LBL_ID_PROCESS',
              ),
              5 => 'account_name',
              6 => 
              array (
                'name' => 'tipo_producto_c',
                'label' => 'LBL_TIPO_PRODUCTO',
              ),
              7 => 
              array (
                'readonly' => true,
                'name' => 'tipo_operacion_c',
                'label' => 'LBL_TIPO_OPERACION',
              ),
              8 => 
              array (
                'readonly' => true,
                'name' => 'tipo_de_operacion_c',
                'label' => 'LBL_TIPO_DE_OPERACION',
              ),
              9 => 
              array (
                'name' => 'plan_financiero_c',
                'label' => 'LBL_PLAN_FINANCIERO',
              ),
              10 => 
              array (
                'name' => 'tipo_seguro_c',
                'label' => 'LBL_TIPO_SEGURO_C',
              ),
              11 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'accesorios_c',
                'label' => 'LBL_ACCESORIOS_C',
              ),
              12 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'seguro_vida_c',
                'label' => 'LBL_SEGURO_VIDA_C',
              ),
              13 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'seguro_desempleo_c',
                'label' => 'LBL_SEGURO_DESEMPLEO_C',
              ),
              14 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'monto_c',
                'label' => 'LBL_MONTO',
              ),
              15 => 'amount',
              16 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'ca_pago_mensual_c',
                'label' => 'LBL_CA_PAGO_MENSUAL',
              ),
              17 => 
              array (
                'name' => 'plazo_c',
                'label' => 'LBL_PLAZO',
              ),
              18 => 
              array (
                'name' => 'porciento_ri_c',
                'label' => 'LBL_PORCIENTO_RI_C',
              ),
              19 => 'assigned_user_name',
              20 => 
              array (
                'name' => 'usuario_bo_c',
                'label' => 'LBL_USUARIO_BO',
              ),
              21 => 
              array (
                'name' => 'f_tipo_factoraje_c',
                'label' => 'LBL_F_TIPO_FACTORAJE',
              ),
              22 => 
              array (
                'name' => 'tipo_tasa_ordinario_c',
                'label' => 'LBL_TIPO_TASA_ORDINARIO',
              ),
              23 => 
              array (
                'name' => 'tasa_fija_ordinario_c',
                'label' => 'LBL_TASA_FIJA_ORDINARIO',
              ),
              24 => 
              array (
                'name' => 'instrumento_c',
                'label' => 'LBL_INSTRUMENTO',
              ),
              25 => 
              array (
                'name' => 'puntos_sobre_tasa_c',
                'label' => 'LBL_PUNTOS_SOBRE_TASA',
              ),
              26 => 
              array (
                'name' => 'porcentaje_ca_c',
                'label' => 'LBL_PORCENTAJE_CA',
              ),
              27 => 
              array (
                'name' => 'f_aforo_c',
                'label' => 'LBL_F_AFORO',
              ),
              28 => 
              array (
                'name' => 'tipo_tasa_moratorio_c',
                'label' => 'LBL_TIPO_TASA_MORATORIO',
              ),
              29 => 
              array (
                'name' => 'tasa_fija_moratorio_c',
                'label' => 'LBL_TASA_FIJA_MORATORIO',
              ),
              30 => 
              array (
                'name' => 'instrumento_moratorio_c',
                'label' => 'LBL_INSTRUMENTO_MORATORIO',
              ),
              31 => 
              array (
                'name' => 'puntos_tasa_moratorio_c',
                'label' => 'LBL_PUNTOS_TASA_MORATORIO',
              ),
              32 => 
              array (
                'name' => 'factor_moratorio_c',
                'label' => 'LBL_FACTOR_MORATORIO',
              ),
              33 => 
              array (
                'name' => 'cartera_descontar_c',
                'studio' => 'visible',
                'label' => 'LBL_CARTERA_DESCONTAR_C',
              ),
              34 => 
              array (
                'name' => 'comision_c',
                'label' => 'LBL_COMISION',
              ),
              35 => 
              array (
                'name' => 'opportunities_ag_vendedores_1_name',
                'label' => 'LBL_OPPORTUNITIES_AG_VENDEDORES_1_FROM_AG_VENDEDORES_TITLE',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
