<?php
// created: 2020-06-30 20:33:48
$dictionary["S_seguros"]["fields"]["s_seguros_accounts"] = array (
  'name' => 's_seguros_accounts',
  'type' => 'link',
  'relationship' => 's_seguros_accounts',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_S_SEGUROS_ACCOUNTS_FROM_S_SEGUROS_TITLE',
  'id_name' => 's_seguros_accountsaccounts_ida',
  'link-type' => 'one',
);
$dictionary["S_seguros"]["fields"]["s_seguros_accounts_name"] = array (
  'name' => 's_seguros_accounts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_S_SEGUROS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 's_seguros_accountsaccounts_ida',
  'link' => 's_seguros_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["S_seguros"]["fields"]["s_seguros_accountsaccounts_ida"] = array (
  'name' => 's_seguros_accountsaccounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_S_SEGUROS_ACCOUNTS_FROM_S_SEGUROS_TITLE_ID',
  'id_name' => 's_seguros_accountsaccounts_ida',
  'link' => 's_seguros_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
