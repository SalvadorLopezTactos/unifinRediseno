<?php
// created: 2019-03-28 18:50:43
$dictionary["tct3_noviable"]["fields"]["accounts_tct3_noviable_1"] = array (
  'name' => 'accounts_tct3_noviable_1',
  'type' => 'link',
  'relationship' => 'accounts_tct3_noviable_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'vname' => 'LBL_ACCOUNTS_TCT3_NOVIABLE_1_FROM_ACCOUNTS_TITLE',
  'id_name' => 'accounts_tct3_noviable_1accounts_ida',
);
$dictionary["tct3_noviable"]["fields"]["accounts_tct3_noviable_1_name"] = array (
  'name' => 'accounts_tct3_noviable_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_TCT3_NOVIABLE_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_tct3_noviable_1accounts_ida',
  'link' => 'accounts_tct3_noviable_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["tct3_noviable"]["fields"]["accounts_tct3_noviable_1accounts_ida"] = array (
  'name' => 'accounts_tct3_noviable_1accounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_TCT3_NOVIABLE_1_FROM_ACCOUNTS_TITLE_ID',
  'id_name' => 'accounts_tct3_noviable_1accounts_ida',
  'link' => 'accounts_tct3_noviable_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
