<?php
// created: 2020-03-27 10:03:16
$dictionary["C5515_uni_chattigo"]["fields"]["accounts_c5515_uni_chattigo_1"] = array (
  'name' => 'accounts_c5515_uni_chattigo_1',
  'type' => 'link',
  'relationship' => 'accounts_c5515_uni_chattigo_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_C5515_UNI_CHATTIGO_1_FROM_C5515_UNI_CHATTIGO_TITLE',
  'id_name' => 'accounts_c5515_uni_chattigo_1accounts_ida',
  'link-type' => 'one',
);
$dictionary["C5515_uni_chattigo"]["fields"]["accounts_c5515_uni_chattigo_1_name"] = array (
  'name' => 'accounts_c5515_uni_chattigo_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_C5515_UNI_CHATTIGO_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_c5515_uni_chattigo_1accounts_ida',
  'link' => 'accounts_c5515_uni_chattigo_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["C5515_uni_chattigo"]["fields"]["accounts_c5515_uni_chattigo_1accounts_ida"] = array (
  'name' => 'accounts_c5515_uni_chattigo_1accounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_C5515_UNI_CHATTIGO_1_FROM_C5515_UNI_CHATTIGO_TITLE_ID',
  'id_name' => 'accounts_c5515_uni_chattigo_1accounts_ida',
  'link' => 'accounts_c5515_uni_chattigo_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
