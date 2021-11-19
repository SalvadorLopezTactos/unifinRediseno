<?php
// created: 2015-07-21 23:08:07
$dictionary["RefBa_Referencia_Bancaria"]["fields"]["refba_referencia_bancaria_accounts"] = array (
  'name' => 'refba_referencia_bancaria_accounts',
  'type' => 'link',
  'relationship' => 'refba_referencia_bancaria_accounts',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_REFBA_REFERENCIA_BANCARIA_ACCOUNTS_FROM_REFBA_REFERENCIA_BANCARIA_TITLE',
  'id_name' => 'refba_referencia_bancaria_accountsaccounts_ida',
  'link-type' => 'one',
);
$dictionary["RefBa_Referencia_Bancaria"]["fields"]["refba_referencia_bancaria_accounts_name"] = array (
  'name' => 'refba_referencia_bancaria_accounts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_REFBA_REFERENCIA_BANCARIA_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'refba_referencia_bancaria_accountsaccounts_ida',
  'link' => 'refba_referencia_bancaria_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["RefBa_Referencia_Bancaria"]["fields"]["refba_referencia_bancaria_accountsaccounts_ida"] = array (
  'name' => 'refba_referencia_bancaria_accountsaccounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_REFBA_REFERENCIA_BANCARIA_ACCOUNTS_FROM_REFBA_REFERENCIA_BANCARIA_TITLE_ID',
  'id_name' => 'refba_referencia_bancaria_accountsaccounts_ida',
  'link' => 'refba_referencia_bancaria_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
