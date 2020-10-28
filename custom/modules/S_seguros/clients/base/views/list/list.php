<?php
$module_name = 'S_seguros';
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
              ),
              1 => 
              array (
                'name' => 'etapa',
                'label' => 'LBL_ETAPA',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'tipo_registro_sf_c',
                'label' => 'LBL_TIPO_REGISTRO_SF',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'ejecutivo_c',
                'label' => 'LBL_EJECUTIVO',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'prima_obj_c',
                'label' => 'LBL_PRIMA_OBJ_C',
                'enabled' => true,
                'type' => 'currency',
                'currency_format' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'prima_neta_ganada_c',
                'label' => 'LBL_PRIMA_NETA_GANADA',
                'type' => 'currency',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              7 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => true,
              ),
              8 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => true,
              ),
              9 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
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
