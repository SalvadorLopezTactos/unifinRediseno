<?php
$module_name = 'QPRO_Gestion_Encuestas';
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
                'name' => 'estatus',
                'label' => 'LBL_ESTATUS',
                'enabled' => true,
                'readonly' => false,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'tipo_envio',
                'label' => 'LBL_TIPO_ENVIO',
                'enabled' => true,
                'readonly' => false,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'url',
                'label' => 'LBL_URL',
                'enabled' => true,
                'readonly' => false,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => false,
              ),
              6 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
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
