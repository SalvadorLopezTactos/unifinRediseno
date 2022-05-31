<?php
$module_name = 'ANLZT_analizate';
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
                'name' => 'anlzt_analizate_accounts_name',
                'label' => 'LBL_ANLZT_ANALIZATE_ACCOUNTS_FROM_ACCOUNTS_TITLE',
                'enabled' => true,
                'id' => 'ANLZT_ANALIZATE_ACCOUNTSACCOUNTS_IDA',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              1 => 
              array (
                'name' => 'tipo_registro_cuenta_c',
                'label' => 'LBL_TIPO_REGISTRO_CUENTA_C',
                'enabled' => true,
                'readonly' => false,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'tipo',
                'label' => 'LBL_TIPO',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'estado',
                'label' => 'LBL_ESTADO',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'url_documento',
                'label' => 'LBL_URL_DOCUMENTO',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'documento',
                'label' => 'LBL_DOCUMENTO',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'fecha_actualizacion',
                'label' => 'LBL_FECHA_ACTUALIZACION',
                'enabled' => true,
                'default' => true,
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
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => false,
                'enabled' => true,
                'link' => true,
              ),
              10 => 
              array (
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => false,
                'enabled' => true,
                'link' => true,
              ),
              11 => 
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
