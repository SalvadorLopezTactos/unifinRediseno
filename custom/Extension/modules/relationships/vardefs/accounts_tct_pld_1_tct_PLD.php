<?php
// created: 2019-01-28 17:38:25
$dictionary["tct_PLD"]["fields"]["accounts_tct_pld_1"] = array (
  'name' => 'accounts_tct_pld_1',
  'type' => 'link',
  'relationship' => 'accounts_tct_pld_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_TCT_PLD_1_FROM_TCT_PLD_TITLE',
  'id_name' => 'accounts_tct_pld_1accounts_ida',
  'link-type' => 'one',
);
$dictionary["tct_PLD"]["fields"]["accounts_tct_pld_1_name"] = array (
  'name' => 'accounts_tct_pld_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_TCT_PLD_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_tct_pld_1accounts_ida',
  'link' => 'accounts_tct_pld_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["tct_PLD"]["fields"]["accounts_tct_pld_1accounts_ida"] = array (
  'name' => 'accounts_tct_pld_1accounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_TCT_PLD_1_FROM_TCT_PLD_TITLE_ID',
  'id_name' => 'accounts_tct_pld_1accounts_ida',
  'link' => 'accounts_tct_pld_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
