<?php
// created: 2019-03-28 18:50:43
$dictionary["Account"]["fields"]["accounts_tct3_noviable_1"] = array (
  'name' => 'accounts_tct3_noviable_1',
  'type' => 'link',
  'relationship' => 'accounts_tct3_noviable_1',
  'source' => 'non-db',
  'module' => 'tct3_noviable',
  'bean_name' => 'tct3_noviable',
  'vname' => 'LBL_ACCOUNTS_TCT3_NOVIABLE_1_FROM_TCT3_NOVIABLE_TITLE',
  'id_name' => 'accounts_tct3_noviable_1tct3_noviable_idb',
);
$dictionary["Account"]["fields"]["accounts_tct3_noviable_1_name"] = array (
  'name' => 'accounts_tct3_noviable_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_TCT3_NOVIABLE_1_FROM_TCT3_NOVIABLE_TITLE',
  'save' => true,
  'id_name' => 'accounts_tct3_noviable_1tct3_noviable_idb',
  'link' => 'accounts_tct3_noviable_1',
  'table' => 'tct3_noviable',
  'module' => 'tct3_noviable',
  'rname' => 'name',
);
$dictionary["Account"]["fields"]["accounts_tct3_noviable_1tct3_noviable_idb"] = array (
  'name' => 'accounts_tct3_noviable_1tct3_noviable_idb',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_TCT3_NOVIABLE_1_FROM_TCT3_NOVIABLE_TITLE_ID',
  'id_name' => 'accounts_tct3_noviable_1tct3_noviable_idb',
  'link' => 'accounts_tct3_noviable_1',
  'table' => 'tct3_noviable',
  'module' => 'tct3_noviable',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
