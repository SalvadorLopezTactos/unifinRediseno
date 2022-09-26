<?php
$module_name = 'cta_cuentas_bancarias';
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
                'name' => 'cta_cuentas_bancarias_accounts_name',
                'label' => 'LBL_CTA_CUENTAS_BANCARIAS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
                'enabled' => true,
                'id' => 'CTA_CUENTAS_BANCARIAS_ACCOUNTSACCOUNTS_IDA',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'clabe',
                'label' => 'LBL_CLABE',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'cuenta',
                'label' => 'LBL_CUENTA',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'banco',
                'label' => 'LBL_BANCO',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'sucursal',
                'label' => 'LBL_SUCURSAL',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => false,
                'enabled' => true,
                'link' => true,
              ),
              7 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => false,
              ),
              8 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'divisa_c',
                'label' => 'LBL_DIVISA',
                'enabled' => true,
                'readonly' => false,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'tipo_clave_c',
                'label' => 'LBL_TIPO_CLAVE',
                'enabled' => true,
                'readonly' => false,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'forma_pago_c',
                'label' => 'LBL_FORMA_PAGO',
                'enabled' => true,
                'readonly' => false,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'regimen_cuenta_c',
                'label' => 'LBL_REGIMEN_CUENTA',
                'enabled' => true,
                'readonly' => false,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'domiciliacion_c',
                'label' => 'LBL_DOMICILIACION',
                'enabled' => true,
                'readonly' => false,
                'default' => false,
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
