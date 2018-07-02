<?php
// created: 2015-06-08 12:20:19
$dictionary["Tel_Telefonos"]["fields"]["accounts_tel_telefonos_1"] = array (
  'name' => 'accounts_tel_telefonos_1',
  'type' => 'link',
  'relationship' => 'accounts_tel_telefonos_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_TEL_TELEFONOS_1_FROM_TEL_TELEFONOS_TITLE',
  'id_name' => 'accounts_tel_telefonos_1accounts_ida',
  'link-type' => 'one',
);
$dictionary["Tel_Telefonos"]["fields"]["accounts_tel_telefonos_1_name"] = array (
  'name' => 'accounts_tel_telefonos_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_TEL_TELEFONOS_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_tel_telefonos_1accounts_ida',
  'link' => 'accounts_tel_telefonos_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["Tel_Telefonos"]["fields"]["accounts_tel_telefonos_1accounts_ida"] = array (
  'name' => 'accounts_tel_telefonos_1accounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_TEL_TELEFONOS_1_FROM_TEL_TELEFONOS_TITLE_ID',
  'id_name' => 'accounts_tel_telefonos_1accounts_ida',
  'link' => 'accounts_tel_telefonos_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
