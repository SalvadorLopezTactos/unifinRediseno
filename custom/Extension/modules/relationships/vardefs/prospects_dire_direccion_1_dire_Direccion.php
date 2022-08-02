<?php
// created: 2022-05-03 01:30:00
$dictionary["dire_Direccion"]["fields"]["prospects_dire_direccion_1"] = array (
  'name' => 'prospects_dire_direccion_1',
  'type' => 'link',
  'relationship' => 'prospects_dire_direccion_1',
  'source' => 'non-db',
  'module' => 'Prospects',
  'bean_name' => 'Prospect',
  'side' => 'right',
  'vname' => 'LBL_PROSPECTS_DIRE_DIRECCION_1_FROM_DIRE_DIRECCION_TITLE',
  'id_name' => 'prospects_dire_direccion_1prospects_ida',
  'link-type' => 'one',
);
$dictionary["dire_Direccion"]["fields"]["prospects_dire_direccion_1_name"] = array (
  'name' => 'prospects_dire_direccion_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PROSPECTS_DIRE_DIRECCION_1_FROM_PROSPECTS_TITLE',
  'save' => true,
  'id_name' => 'prospects_dire_direccion_1prospects_ida',
  'link' => 'prospects_dire_direccion_1',
  'table' => 'prospects',
  'module' => 'Prospects',
  'rname' => 'name',
);
$dictionary["dire_Direccion"]["fields"]["prospects_dire_direccion_1prospects_ida"] = array (
  'name' => 'prospects_dire_direccion_1prospects_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_PROSPECTS_DIRE_DIRECCION_1_FROM_DIRE_DIRECCION_TITLE_ID',
  'id_name' => 'prospects_dire_direccion_1prospects_ida',
  'link' => 'prospects_dire_direccion_1',
  'table' => 'prospects',
  'module' => 'Prospects',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
