<?php
// created: 2024-05-21 12:55:59
$viewdefs['Leads']['base']['view']['selection-list'] = array (
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
        ),
        2 => 
        array (
          'name' => 'subtipo_registro_c',
          'label' => 'LBL_SUBTIPO_REGISTRO',
          'enabled' => true,
          'default' => true,
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
          'name' => 'nombre_de_cargar_c',
          'label' => 'LBL_NOMBRE_DE_CARGAR',
          'enabled' => true,
          'default' => true,
        ),
        7 => 
        array (
          'name' => 'contacto_asociado_c',
          'label' => 'LBL_CONTACTO_ASOCIADO_C',
          'enabled' => true,
          'default' => true,
        ),
        8 => 
        array (
          'name' => 'status',
          'label' => 'LBL_LIST_STATUS',
          'enabled' => true,
          'default' => false,
        ),
        9 => 
        array (
          'name' => 'nombre_empresa_c',
          'label' => 'LBL_NOMBRE_EMPRESA',
          'enabled' => true,
          'default' => false,
        ),
        10 => 
        array (
          'name' => 'nombre_c',
          'label' => 'LBL_NOMBRE',
          'enabled' => true,
          'default' => false,
        ),
        11 => 
        array (
          'name' => 'apellido_paterno_c',
          'label' => 'LBL_APELLIDO_PATERNO_C',
          'enabled' => true,
          'default' => false,
        ),
        12 => 
        array (
          'name' => 'account_name',
          'label' => 'LBL_LIST_ACCOUNT_NAME',
          'enabled' => true,
          'default' => false,
          'related_fields' => 
          array (
            0 => 'account_id',
            1 => 'converted',
          ),
        ),
        13 => 
        array (
          'name' => 'phone_work',
          'label' => 'LBL_LIST_PHONE',
          'enabled' => true,
          'default' => false,
        ),
        14 => 
        array (
          'name' => 'apellido_materno_c',
          'label' => 'LBL_APELLIDO_MATERNO_C',
          'enabled' => true,
          'default' => false,
        ),
        15 => 
        array (
          'name' => 'name',
          'type' => 'fullname',
          'fields' => 
          array (
            0 => 'salutation',
            1 => 'first_name',
            2 => 'last_name',
          ),
          'link' => true,
          'label' => 'LBL_LIST_NAME',
          'enabled' => true,
          'default' => false,
        ),
        16 => 
        array (
          'name' => 'email',
          'label' => 'LBL_LIST_EMAIL_ADDRESS',
          'enabled' => true,
          'default' => false,
        ),
      ),
    ),
  ),
);