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
      ),
    ),
    'panels' => 
    array (
      'LBL_USER_INFORMATION' => 
      array (
        0 => 
        array (
          0 => 'full_name',
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
            'name' => 'puestousuario_c',
            'studio' => 'visible',
            'label' => 'LBL_PUESTOUSUARIO',
          ),
          1 => 
          array (
            'name' => 'aut_caratulariesgo_c',
            'label' => 'LBL_AUT_CARATULARIESGO',
          ),
        ),
        3 => 
        array (
          0 => 'phone_work',
          1 => 
          array (
            'name' => 'ext_c',
            'label' => 'LBL_EXT',
          ),
        ),
        4 => 
        array (
          0 => 'phone_mobile',
        ),
        5 => 
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
        6 => 
        array (
          0 => 
          array (
            'name' => 'tct_team_address_txf_c',
            'label' => 'LBL_TCT_TEAM_ADDRESS_TXF_C',
          ),
          1 => 
          array (
            'name' => 'region_c',
            'label' => 'LBL_REGION',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'sucursal_c',
            'studio' => 'visible',
            'label' => 'LBL_SUCURSAL',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'tipodeproducto_c',
            'studio' => 'visible',
            'label' => 'LBL_TIPODEPRODUCTO',
          ),
          1 => 
          array (
            'name' => 'optout_c',
            'label' => 'LBL_OPTOUT',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'productos_c',
            'studio' => 'visible',
            'label' => 'LBL_PRODUCTOS',
          ),
          1 => 
          array (
            'name' => 'UserType',
            'customCode' => '{$USER_TYPE_READONLY}',
          ),
        ),
        10 => 
        array (
          0 => 'reports_to_name',
          1 => 
          array (
            'name' => 'uni_citas_users_1_name',
          ),
        ),
      ),
    ),
  ),
);
