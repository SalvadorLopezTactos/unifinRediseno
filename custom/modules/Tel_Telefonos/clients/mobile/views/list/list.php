<?php
$module_name = 'Tel_Telefonos';
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
                'name' => 'telefono',
                'label' => 'LBL_TELEFONO',
                'enabled' => true,
                'default' => true,
              ),
              1 => 
              array (
                'name' => 'tipotelefono',
                'label' => 'LBL_TIPOTELEFONO',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'principal',
                'label' => 'LBL_PRINCIPAL',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'width' => '9',
                'default' => false,
                'enabled' => true,
                'link' => true,
              ),
              4 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'width' => '9',
                'default' => false,
                'enabled' => true,
              ),
              5 => 
              array (
                'name' => 'name',
                'label' => 'LBL_NAME',
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
