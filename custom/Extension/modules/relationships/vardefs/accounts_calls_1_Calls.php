<?php
// created: 2021-07-27 16:50:52
$dictionary["Call"]["fields"]["accounts_calls_1"] = array (
  'name' => 'accounts_calls_1',
  'type' => 'link',
  'relationship' => 'accounts_calls_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_CALLS_1_FROM_CALLS_TITLE',
  'id_name' => 'accounts_calls_1accounts_ida',
  'link-type' => 'one',
);
$dictionary["Call"]["fields"]["accounts_calls_1_name"] = array (
  'name' => 'accounts_calls_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_CALLS_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_calls_1accounts_ida',
  'link' => 'accounts_calls_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["Call"]["fields"]["accounts_calls_1accounts_ida"] = array (
  'name' => 'accounts_calls_1accounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_CALLS_1_FROM_CALLS_TITLE_ID',
  'id_name' => 'accounts_calls_1accounts_ida',
  'link' => 'accounts_calls_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
