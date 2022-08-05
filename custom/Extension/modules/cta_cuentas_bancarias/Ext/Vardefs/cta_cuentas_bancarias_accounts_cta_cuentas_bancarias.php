<?php
// created: 2020-05-27 14:08:29
$dictionary["cta_cuentas_bancarias"]["fields"]["cta_cuentas_bancarias_accounts"] = array (
  'name' => 'cta_cuentas_bancarias_accounts',
  'type' => 'link',
  'relationship' => 'cta_cuentas_bancarias_accounts',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_CTA_CUENTAS_BANCARIAS_ACCOUNTS_FROM_CTA_CUENTAS_BANCARIAS_TITLE',
  'id_name' => 'cta_cuentas_bancarias_accountsaccounts_ida',
  'link-type' => 'one',
);
$dictionary["cta_cuentas_bancarias"]["fields"]["cta_cuentas_bancarias_accounts_name"] = array (
  'name' => 'cta_cuentas_bancarias_accounts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CTA_CUENTAS_BANCARIAS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'cta_cuentas_bancarias_accountsaccounts_ida',
  'link' => 'cta_cuentas_bancarias_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["cta_cuentas_bancarias"]["fields"]["cta_cuentas_bancarias_accountsaccounts_ida"] = array (
  'name' => 'cta_cuentas_bancarias_accountsaccounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_CTA_CUENTAS_BANCARIAS_ACCOUNTS_FROM_CTA_CUENTAS_BANCARIAS_TITLE_ID',
  'id_name' => 'cta_cuentas_bancarias_accountsaccounts_ida',
  'link' => 'cta_cuentas_bancarias_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
