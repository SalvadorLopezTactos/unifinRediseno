<?php
// created: 2020-12-03 15:29:17
$dictionary["Lic_Licitaciones"]["fields"]["lic_licitaciones_accounts"] = array (
  'name' => 'lic_licitaciones_accounts',
  'type' => 'link',
  'relationship' => 'lic_licitaciones_accounts',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_LIC_LICITACIONES_ACCOUNTS_FROM_LIC_LICITACIONES_TITLE',
  'id_name' => 'lic_licitaciones_accountsaccounts_ida',
  'link-type' => 'one',
);
$dictionary["Lic_Licitaciones"]["fields"]["lic_licitaciones_accounts_name"] = array (
  'name' => 'lic_licitaciones_accounts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_LIC_LICITACIONES_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'lic_licitaciones_accountsaccounts_ida',
  'link' => 'lic_licitaciones_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["Lic_Licitaciones"]["fields"]["lic_licitaciones_accountsaccounts_ida"] = array (
  'name' => 'lic_licitaciones_accountsaccounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_LIC_LICITACIONES_ACCOUNTS_FROM_LIC_LICITACIONES_TITLE_ID',
  'id_name' => 'lic_licitaciones_accountsaccounts_ida',
  'link' => 'lic_licitaciones_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
