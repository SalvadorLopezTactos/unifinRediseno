<?php
// created: 2015-06-10 15:13:34
$dictionary["Rel_Relaciones"]["fields"]["rel_relaciones_accounts"] = array (
  'name' => 'rel_relaciones_accounts',
  'type' => 'link',
  'relationship' => 'rel_relaciones_accounts',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_REL_RELACIONES_ACCOUNTS_FROM_REL_RELACIONES_TITLE',
  'id_name' => 'rel_relaciones_accountsaccounts_ida',
  'link-type' => 'one',
);
$dictionary["Rel_Relaciones"]["fields"]["rel_relaciones_accounts_name"] = array (
  'name' => 'rel_relaciones_accounts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_REL_RELACIONES_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'rel_relaciones_accountsaccounts_ida',
  'link' => 'rel_relaciones_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["Rel_Relaciones"]["fields"]["rel_relaciones_accountsaccounts_ida"] = array (
  'name' => 'rel_relaciones_accountsaccounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_REL_RELACIONES_ACCOUNTS_FROM_REL_RELACIONES_TITLE_ID',
  'id_name' => 'rel_relaciones_accountsaccounts_ida',
  'link' => 'rel_relaciones_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
