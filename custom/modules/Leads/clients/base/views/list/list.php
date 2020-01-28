<?php
$viewdefs['Leads'] = 
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
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name_c',
                'link' => true,
                'label' => 'LBL_NAME',
                'enabled' => true,
                'default' => true,
              ),
              1 => 
              array (
                'name' => 'tipo_registro_c',
                'label' => 'LBL_TIPO_REGISTRO',
                'enabled' => true,
                'default' => true,
                'readonly' => true,
              ),
              2 => 
              array (
                'name' => 'subtipo_registro_c',
                'label' => 'LBL_SUBTIPO_REGISTRO',
                'enabled' => true,
                'default' => true,
                'readonly' => true,
              ),
              3 => 
              array (
                'name' => 'regimen_fiscal_c',
                'label' => 'LBL_REGIMEN_FISCAL',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_LIST_ASSIGNED_USER',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'default' => true,
                'readonly' => true,
              ),
              6 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => false,
              ),
              7 => 
              array (
                'name' => 'phone_work',
                'label' => 'LBL_LIST_PHONE',
                'enabled' => true,
                'default' => false,
              ),
              8 => 
              array (
                'name' => 'email',
                'label' => 'LBL_LIST_EMAIL_ADDRESS',
                'enabled' => true,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'status',
                'label' => 'LBL_LIST_STATUS',
                'enabled' => true,
                'default' => false,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
