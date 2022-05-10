<?php
$viewdefs['Accounts'] = 
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
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              1 => 
              array (
                'name' => 'tipo_registro_c',
                'label' => 'LBL_TIPO_REGISTRO',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'email',
                'enabled' => true,
                'default' => false,
              ),
              3 => 
              array (
                'name' => 'phone_office',
                'enabled' => true,
                'default' => false,
              ),
              4 => 
              array (
                'name' => 'website',
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
