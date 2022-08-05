<?php
$module_name = 'Val_Validaciones';
$viewdefs[$module_name] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'modulo',
                'label' => 'LBL_MODULO',
                'enabled' => true,
                'width' => '10%',
                'default' => true,
              ),
              1 => 
              array (
                'name' => 'campo_padre',
                'label' => 'LBL_CAMPO_PADRE',
                'enabled' => true,
                'width' => '10%',
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'criterio_validacion',
                'label' => 'LBL_CRITERIO_VALIDACION',
                'enabled' => true,
                'width' => '10%',
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
                'width' => '10%',
              ),
              4 => 
              array (
                'name' => 'visible',
                'label' => 'LBL_VISIBLE',
                'enabled' => true,
                'width' => '10%',
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'estatus',
                'label' => 'LBL_ESTATUS',
                'enabled' => true,
                'width' => '10%',
                'default' => true,
              ),
              6 => 
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
      ),
    ),
  ),
);
