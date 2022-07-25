<?php
// created: 2022-07-18 16:54:06
$dictionary["Rel_Relaciones"]["fields"]["accounts_rel_relaciones_1"] = array (
  'name' => 'accounts_rel_relaciones_1',
  'type' => 'link',
  'relationship' => 'accounts_rel_relaciones_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_REL_RELACIONES_1_FROM_REL_RELACIONES_TITLE',
  'id_name' => 'accounts_rel_relaciones_1accounts_ida',
  'link-type' => 'one',
);
$dictionary["Rel_Relaciones"]["fields"]["accounts_rel_relaciones_1_name"] = array (
  'name' => 'accounts_rel_relaciones_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_REL_RELACIONES_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_rel_relaciones_1accounts_ida',
  'link' => 'accounts_rel_relaciones_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["Rel_Relaciones"]["fields"]["accounts_rel_relaciones_1accounts_ida"] = array (
  'name' => 'accounts_rel_relaciones_1accounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_REL_RELACIONES_1_FROM_REL_RELACIONES_TITLE_ID',
  'id_name' => 'accounts_rel_relaciones_1accounts_ida',
  'link' => 'accounts_rel_relaciones_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
