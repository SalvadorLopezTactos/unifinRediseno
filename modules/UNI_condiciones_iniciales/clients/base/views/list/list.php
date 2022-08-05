<?php
$module_name = 'UNI_condiciones_iniciales';
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
                'name' => 'activo',
                'label' => 'LBL_ACTIVO',
                'enabled' => true,
                'width' => '10%',
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'campo_destino_minimo',
                'label' => 'LBL_CAMPO_DESTINO_MINIMO',
                'enabled' => true,
                'width' => '10%',
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'rango_minimo',
                'label' => 'LBL_RANGO_MINIMO',
                'enabled' => true,
                'width' => '10%',
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'campo_destino_maximo',
                'label' => 'LBL_CAMPO_DESTINO_MAXIMO',
                'enabled' => true,
                'width' => '10%',
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'rango_maximo',
                'label' => 'LBL_RANGO_MAXIMO',
                'enabled' => true,
                'width' => '10%',
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'width' => '9%',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              7 => 
              array (
                'label' => 'LBL_DATE_MODIFIED',
                'enabled' => true,
                'default' => true,
                'name' => 'date_modified',
                'readonly' => true,
                'width' => '10%',
              ),
              8 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'width' => '9%',
                'default' => false,
                'enabled' => true,
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
