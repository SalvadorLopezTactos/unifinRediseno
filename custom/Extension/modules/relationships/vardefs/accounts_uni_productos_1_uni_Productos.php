<?php
// created: 2020-03-12 15:55:02
$dictionary["uni_Productos"]["fields"]["accounts_uni_productos_1"] = array (
  'name' => 'accounts_uni_productos_1',
  'type' => 'link',
  'relationship' => 'accounts_uni_productos_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_UNI_PRODUCTOS_1_FROM_UNI_PRODUCTOS_TITLE',
  'id_name' => 'accounts_uni_productos_1accounts_ida',
  'link-type' => 'one',
);
$dictionary["uni_Productos"]["fields"]["accounts_uni_productos_1_name"] = array (
  'name' => 'accounts_uni_productos_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_UNI_PRODUCTOS_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_uni_productos_1accounts_ida',
  'link' => 'accounts_uni_productos_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["uni_Productos"]["fields"]["accounts_uni_productos_1accounts_ida"] = array (
  'name' => 'accounts_uni_productos_1accounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_UNI_PRODUCTOS_1_FROM_UNI_PRODUCTOS_TITLE_ID',
  'id_name' => 'accounts_uni_productos_1accounts_ida',
  'link' => 'accounts_uni_productos_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
