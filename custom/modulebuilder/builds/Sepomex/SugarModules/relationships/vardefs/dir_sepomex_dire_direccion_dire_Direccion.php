<?php
// created: 2022-04-27 14:56:21
$dictionary["dire_Direccion"]["fields"]["dir_sepomex_dire_direccion"] = array (
  'name' => 'dir_sepomex_dire_direccion',
  'type' => 'link',
  'relationship' => 'dir_sepomex_dire_direccion',
  'source' => 'non-db',
  'module' => 'dir_Sepomex',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_DIR_SEPOMEX_DIRE_DIRECCION_FROM_DIRE_DIRECCION_TITLE',
  'id_name' => 'dir_sepomex_dire_direcciondir_sepomex_ida',
  'link-type' => 'one',
);
$dictionary["dire_Direccion"]["fields"]["dir_sepomex_dire_direccion_name"] = array (
  'name' => 'dir_sepomex_dire_direccion_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_DIR_SEPOMEX_DIRE_DIRECCION_FROM_DIR_SEPOMEX_TITLE',
  'save' => true,
  'id_name' => 'dir_sepomex_dire_direcciondir_sepomex_ida',
  'link' => 'dir_sepomex_dire_direccion',
  'table' => 'dir_sepomex',
  'module' => 'dir_Sepomex',
  'rname' => 'name',
);
$dictionary["dire_Direccion"]["fields"]["dir_sepomex_dire_direcciondir_sepomex_ida"] = array (
  'name' => 'dir_sepomex_dire_direcciondir_sepomex_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_DIR_SEPOMEX_DIRE_DIRECCION_FROM_DIRE_DIRECCION_TITLE_ID',
  'id_name' => 'dir_sepomex_dire_direcciondir_sepomex_ida',
  'link' => 'dir_sepomex_dire_direccion',
  'table' => 'dir_sepomex',
  'module' => 'dir_Sepomex',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
