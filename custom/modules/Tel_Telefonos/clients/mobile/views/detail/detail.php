<?php
$module_name = 'Tel_Telefonos';
$viewdefs[$module_name] = 
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
            1 => 
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
                'name' => 'telefono',
                'label' => 'LBL_TELEFONO',
              ),
              1 => 
              array (
                'name' => 'tipotelefono',
                'studio' => 'visible',
                'label' => 'LBL_TIPOTELEFONO',
              ),
              2 => 
              array (
                'name' => 'extension',
                'label' => 'LBL_EXTENSION',
              ),
              3 => 
              array (
                'name' => 'estatus',
                'studio' => 'visible',
                'label' => 'LBL_ESTATUS',
              ),
              4 => 
              array (
                'name' => 'pais',
                'label' => 'LBL_PAIS',
              ),
              5 => 
              array (
                'name' => 'principal',
                'label' => 'LBL_PRINCIPAL',
              ),
              6 => 
              array (
                'name' => 'accounts_tel_telefonos_1_name',
                'label' => 'LBL_ACCOUNTS_TEL_TELEFONOS_1_FROM_ACCOUNTS_TITLE',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
