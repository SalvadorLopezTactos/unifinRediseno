<?php
$module_name = 'TCT1_P_Fideicomiso';
$viewdefs[$module_name] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_1',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
                'width' => '10%',
              ),
              1 => 
              array (
                'name' => 'tct_tipo_ddw',
                'label' => 'LBL_TCT_TIPO_DDW',
                'enabled' => true,
                'width' => '10%',
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'tct_ocupacion_txf',
                'label' => 'LBL_TCT_OCUPACION_TXF',
                'enabled' => true,
                'width' => '10%',
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'tct_fecha_nacimiento_dat',
                'label' => 'LBL_TCT_FECHA_NACIMIENTO_DAT',
                'enabled' => true,
                'width' => '10%',
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'readonly' => true,
                'width' => '10%',
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'modified_by_name',
                'label' => 'LBL_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'MODIFIED_USER_ID',
                'link' => true,
                'sortable' => false,
                'width' => '10%',
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'tct_genero_ddw',
                'label' => 'LBL_TCT_GENERO_DDW',
                'enabled' => true,
                'width' => '10%',
                'default' => false,
              ),
              7 => 
              array (
                'name' => 'tct_pais_nacimiento_txf',
                'label' => 'LBL_TCT_PAIS_NACIMIENTO_TXF',
                'enabled' => true,
                'width' => '10%',
                'default' => false,
              ),
              8 => 
              array (
                'name' => 'tct_nacionalidad_txf',
                'label' => 'LBL_TCT_NACIONALIDAD_TXF',
                'enabled' => true,
                'width' => '10%',
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'tct_rfc_txf',
                'label' => 'LBL_TCT_RFC_TXF',
                'enabled' => true,
                'width' => '10%',
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'tct_no_serie_firma_txf',
                'label' => 'LBL_TCT_NO_SERIE_FIRMA_TXF',
                'enabled' => true,
                'width' => '10%',
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'tct_curp_txf',
                'label' => 'LBL_TCT_CURP_TXF',
                'enabled' => true,
                'width' => '10%',
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'tct_correo_electronico_txf',
                'label' => 'LBL_TCT_CORREO_ELECTRONICO_TXF',
                'enabled' => true,
                'width' => '10%',
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'tct_telefono_tel',
                'label' => 'LBL_TCT_TELEFONO_TEL',
                'enabled' => true,
                'width' => '10%',
                'default' => false,
              ),
              14 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'width' => '9%',
                'default' => false,
                'enabled' => true,
                'link' => true,
              ),
            ),
          ),
        ),
        'orderBy' => 
        array (
          'field' => 'date_modified',
          'direction' => 'desc',
        ),
      ),
    ),
  ),
);
