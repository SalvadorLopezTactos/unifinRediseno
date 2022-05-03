<?php
// created: 2022-05-03 01:27:21
$dictionary["Tel_Telefonos"]["fields"]["prospects_tel_telefonos_1"] = array (
  'name' => 'prospects_tel_telefonos_1',
  'type' => 'link',
  'relationship' => 'prospects_tel_telefonos_1',
  'source' => 'non-db',
  'module' => 'Prospects',
  'bean_name' => 'Prospect',
  'side' => 'right',
  'vname' => 'LBL_PROSPECTS_TEL_TELEFONOS_1_FROM_TEL_TELEFONOS_TITLE',
  'id_name' => 'prospects_tel_telefonos_1prospects_ida',
  'link-type' => 'one',
);
$dictionary["Tel_Telefonos"]["fields"]["prospects_tel_telefonos_1_name"] = array (
  'name' => 'prospects_tel_telefonos_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PROSPECTS_TEL_TELEFONOS_1_FROM_PROSPECTS_TITLE',
  'save' => true,
  'id_name' => 'prospects_tel_telefonos_1prospects_ida',
  'link' => 'prospects_tel_telefonos_1',
  'table' => 'prospects',
  'module' => 'Prospects',
  'rname' => 'name',
);
$dictionary["Tel_Telefonos"]["fields"]["prospects_tel_telefonos_1prospects_ida"] = array (
  'name' => 'prospects_tel_telefonos_1prospects_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_PROSPECTS_TEL_TELEFONOS_1_FROM_TEL_TELEFONOS_TITLE_ID',
  'id_name' => 'prospects_tel_telefonos_1prospects_ida',
  'link' => 'prospects_tel_telefonos_1',
  'table' => 'prospects',
  'module' => 'Prospects',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
