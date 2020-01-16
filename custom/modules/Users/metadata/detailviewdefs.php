<?php
$viewdefs['Users'] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'form' => 
      array (
        'headerTpl' => 'modules/Users/tpls/DetailViewHeader.tpl',
        'footerTpl' => 'modules/Users/tpls/DetailViewFooter.tpl',
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'LBL_USER_INFORMATION' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_DETAILVIEW_PANEL2' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_DETAILVIEW_PANEL3' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_DETAILVIEW_PANEL1' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'LBL_USER_INFORMATION' => 
      array (
        0 => 
        array (
          0 => 'full_name',
          1 => 'picture',
        ),
        1 => 
        array (
          0 => 'user_name',
          1 => 'status',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'iniciales_c',
            'label' => 'LBL_INICIALES',
          ),
        ),
        3 => 
        array (
          0 => 'description',
          1 => 
          array (
            'name' => 'UserType',
            'customCode' => '{$USER_TYPE_READONLY}',
          ),
        ),
      ),
      'lbl_detailview_panel2' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'ext_c',
            'label' => 'LBL_EXT',
          ),
          1 => 'phone_mobile',
        ),
      ),
      'lbl_detailview_panel3' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'puestousuario_c',
            'studio' => 'visible',
            'label' => 'LBL_PUESTOUSUARIO',
          ),
          1 => 'reports_to_name',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'subpuesto_c',
            'label' => 'LBL_SUBPUESTO',
          ),
          1 => '',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'region_c',
            'label' => 'LBL_REGION',
          ),
          1 => 
          array (
            'name' => 'tct_team_address_txf_c',
            'label' => 'LBL_TCT_TEAM_ADDRESS_TXF_C',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'equipo_c',
            'studio' => 'visible',
            'label' => 'LBL_EQUIPO',
          ),
          1 => 
          array (
            'name' => 'equipos_c',
            'studio' => 'visible',
            'label' => 'LBL_EQUIPOS_C',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'tipodeproducto_c',
            'studio' => 'visible',
            'label' => 'LBL_TIPODEPRODUCTO',
          ),
          1 => 
          array (
            'name' => 'productos_c',
            'studio' => 'visible',
            'label' => 'LBL_PRODUCTOS',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'tct_id_uni2_txf_c',
            'label' => 'LBL_TCT_ID_UNI2_TXF',
          ),
          1 => 
          array (
            'name' => 'tct_id_unics_txf_c',
            'label' => 'LBL_TCT_ID_UNICS_TXF',
          ),
        ),
      ),
      'lbl_detailview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'tct_altaproveedor_chk_c',
            'label' => 'LBL_TCT_ALTAPROVEEDOR_CHK',
          ),
          1 => 
          array (
            'name' => 'tct_alta_clientes_chk_c',
            'label' => 'LBL_TCT_ALTA_CLIENTES_CHK',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'tct_alta_cd_chk_c',
            'label' => 'LBL_TCT_ALTA_CD_CHK_C',
          ),
          1 => 
          array (
            'name' => 'cac_c',
            'label' => 'LBL_CAC',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'optout_c',
            'label' => 'LBL_OPTOUT',
          ),
          1 => 
          array (
            'name' => 'aut_caratulariesgo_c',
            'label' => 'LBL_AUT_CARATULARIESGO',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'tct_propietario_real_chk_c',
            'label' => 'LBL_TCT_PROPIETARIO_REAL_CHK',
          ),
          1 => 
          array (
            'name' => 'tct_vetar_usuarios_chk_c',
            'label' => 'LBL_TCT_VETAR_USUARIOS_CHK_C',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'tct_alta_credito_simple_chk_c',
            'label' => 'LBL_TCT_ALTA_CREDITO_SIMPLE_CHK',
          ),
          1 => 
          array (
            'name' => 'tct_no_contactar_chk_c',
            'label' => 'LBL_TCT_NO_CONTACTAR_CHK',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'agente_telefonico_c',
            'label' => 'LBL_AGENTE_TELEFONICO',
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
