<?php
// created: 2020-02-19 17:17:00
$dictionary["ANLZT_analizate"]["fields"]["anlzt_analizate_accounts"] = array (
  'name' => 'anlzt_analizate_accounts',
  'type' => 'link',
  'relationship' => 'anlzt_analizate_accounts',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_ANLZT_ANALIZATE_ACCOUNTS_FROM_ANLZT_ANALIZATE_TITLE',
  'id_name' => 'anlzt_analizate_accountsaccounts_ida',
  'link-type' => 'one',
);
$dictionary["ANLZT_analizate"]["fields"]["anlzt_analizate_accounts_name"] = array (
  'name' => 'anlzt_analizate_accounts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ANLZT_ANALIZATE_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'anlzt_analizate_accountsaccounts_ida',
  'link' => 'anlzt_analizate_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["ANLZT_analizate"]["fields"]["anlzt_analizate_accountsaccounts_ida"] = array (
  'name' => 'anlzt_analizate_accountsaccounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ANLZT_ANALIZATE_ACCOUNTS_FROM_ANLZT_ANALIZATE_TITLE_ID',
  'id_name' => 'anlzt_analizate_accountsaccounts_ida',
  'link' => 'anlzt_analizate_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
