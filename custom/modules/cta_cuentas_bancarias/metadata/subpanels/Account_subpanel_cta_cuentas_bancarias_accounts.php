<?php
// created: 2022-09-26 11:17:21
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'cta_cuentas_bancarias_accounts_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_CTA_CUENTAS_BANCARIAS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
    'id' => 'CTA_CUENTAS_BANCARIAS_ACCOUNTSACCOUNTS_IDA',
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Accounts',
    'target_record_key' => 'cta_cuentas_bancarias_accountsaccounts_ida',
  ),
  'estado' => 
  array (
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_ESTADO',
    'width' => 10,
  ),
  'cuenta' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'vname' => 'LBL_CUENTA',
    'width' => 10,
  ),
  'clabe' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'vname' => 'LBL_CLABE',
    'width' => 10,
  ),
  'banco' => 
  array (
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_BANCO',
    'width' => 10,
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'vname' => 'LBL_DATE_ENTERED',
    'width' => 10,
    'default' => true,
  ),
  'date_modified' => 
  array (
    'vname' => 'LBL_DATE_MODIFIED',
    'width' => 10,
    'default' => true,
  ),
);