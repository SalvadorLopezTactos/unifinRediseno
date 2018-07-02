<?php
// created: 2018-03-22 10:47:18
$dictionary["TCT2_Notificaciones"]["fields"]["tct2_notificaciones_accounts"] = array (
  'name' => 'tct2_notificaciones_accounts',
  'type' => 'link',
  'relationship' => 'tct2_notificaciones_accounts',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_TCT2_NOTIFICACIONES_ACCOUNTS_FROM_TCT2_NOTIFICACIONES_TITLE',
  'id_name' => 'tct2_notificaciones_accountsaccounts_ida',
  'link-type' => 'one',
);
$dictionary["TCT2_Notificaciones"]["fields"]["tct2_notificaciones_accounts_name"] = array (
  'name' => 'tct2_notificaciones_accounts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TCT2_NOTIFICACIONES_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'tct2_notificaciones_accountsaccounts_ida',
  'link' => 'tct2_notificaciones_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["TCT2_Notificaciones"]["fields"]["tct2_notificaciones_accountsaccounts_ida"] = array (
  'name' => 'tct2_notificaciones_accountsaccounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_TCT2_NOTIFICACIONES_ACCOUNTS_FROM_TCT2_NOTIFICACIONES_TITLE_ID',
  'id_name' => 'tct2_notificaciones_accountsaccounts_ida',
  'link' => 'tct2_notificaciones_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
