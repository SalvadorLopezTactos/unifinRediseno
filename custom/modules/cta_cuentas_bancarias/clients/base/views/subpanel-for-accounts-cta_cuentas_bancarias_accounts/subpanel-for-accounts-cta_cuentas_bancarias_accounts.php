<?php
// created: 2022-09-26 11:17:21
$viewdefs['cta_cuentas_bancarias']['base']['view']['subpanel-for-accounts-cta_cuentas_bancarias_accounts'] = array (
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
          'label' => 'LBL_NAME',
          'enabled' => true,
          'default' => true,
          'name' => 'name',
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
          'name' => 'estado',
          'label' => 'LBL_ESTADO',
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
          'name' => 'clabe',
          'label' => 'LBL_CLABE',
          'enabled' => true,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'banco',
          'label' => 'LBL_BANCO',
          'enabled' => true,
          'default' => true,
        ),
        6 => 
        array (
          'name' => 'date_entered',
          'label' => 'LBL_DATE_ENTERED',
          'enabled' => true,
          'readonly' => true,
          'default' => true,
        ),
        7 => 
        array (
          'label' => 'LBL_DATE_MODIFIED',
          'enabled' => true,
          'default' => true,
          'name' => 'date_modified',
        ),
      ),
    ),
  ),
  'orderBy' => 
  array (
    'field' => 'date_modified',
    'direction' => 'desc',
  ),
  'type' => 'subpanel-list',
);