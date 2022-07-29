<?php
// created: 2015-06-23 20:37:07
$dictionary["dire_Direccion"]["fields"]["accounts_dire_direccion_1"] = array (
  'name' => 'accounts_dire_direccion_1',
  'type' => 'link',
  'relationship' => 'accounts_dire_direccion_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_DIRE_DIRECCION_1_FROM_DIRE_DIRECCION_TITLE',
  'id_name' => 'accounts_dire_direccion_1accounts_ida',
  'link-type' => 'one',
);
$dictionary["dire_Direccion"]["fields"]["accounts_dire_direccion_1_name"] = array (
  'name' => 'accounts_dire_direccion_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_DIRE_DIRECCION_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_dire_direccion_1accounts_ida',
  'link' => 'accounts_dire_direccion_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["dire_Direccion"]["fields"]["accounts_dire_direccion_1accounts_ida"] = array (
  'name' => 'accounts_dire_direccion_1accounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_DIRE_DIRECCION_1_FROM_DIRE_DIRECCION_TITLE_ID',
  'id_name' => 'accounts_dire_direccion_1accounts_ida',
  'link' => 'accounts_dire_direccion_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
