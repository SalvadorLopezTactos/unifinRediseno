<?php
// created: 2020-12-11 22:28:11
$dictionary["Lic_Licitaciones"]["fields"]["accounts_lic_licitaciones_1"] = array (
  'name' => 'accounts_lic_licitaciones_1',
  'type' => 'link',
  'relationship' => 'accounts_lic_licitaciones_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_LIC_LICITACIONES_1_FROM_LIC_LICITACIONES_TITLE',
  'id_name' => 'accounts_lic_licitaciones_1accounts_ida',
  'link-type' => 'one',
);
$dictionary["Lic_Licitaciones"]["fields"]["accounts_lic_licitaciones_1_name"] = array (
  'name' => 'accounts_lic_licitaciones_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_LIC_LICITACIONES_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_lic_licitaciones_1accounts_ida',
  'link' => 'accounts_lic_licitaciones_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["Lic_Licitaciones"]["fields"]["accounts_lic_licitaciones_1accounts_ida"] = array (
  'name' => 'accounts_lic_licitaciones_1accounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_LIC_LICITACIONES_1_FROM_LIC_LICITACIONES_TITLE_ID',
  'id_name' => 'accounts_lic_licitaciones_1accounts_ida',
  'link' => 'accounts_lic_licitaciones_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
