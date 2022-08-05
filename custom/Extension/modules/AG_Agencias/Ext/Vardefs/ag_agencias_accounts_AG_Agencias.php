<?php
// created: 2015-10-28 13:22:52
$dictionary["AG_Agencias"]["fields"]["ag_agencias_accounts"] = array (
  'name' => 'ag_agencias_accounts',
  'type' => 'link',
  'relationship' => 'ag_agencias_accounts',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_AG_AGENCIAS_ACCOUNTS_FROM_AG_AGENCIAS_TITLE',
  'id_name' => 'ag_agencias_accountsaccounts_ida',
  'link-type' => 'one',
);
$dictionary["AG_Agencias"]["fields"]["ag_agencias_accounts_name"] = array (
  'name' => 'ag_agencias_accounts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_AG_AGENCIAS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'ag_agencias_accountsaccounts_ida',
  'link' => 'ag_agencias_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["AG_Agencias"]["fields"]["ag_agencias_accountsaccounts_ida"] = array (
  'name' => 'ag_agencias_accountsaccounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_AG_AGENCIAS_ACCOUNTS_FROM_AG_AGENCIAS_TITLE_ID',
  'id_name' => 'ag_agencias_accountsaccounts_ida',
  'link' => 'ag_agencias_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
