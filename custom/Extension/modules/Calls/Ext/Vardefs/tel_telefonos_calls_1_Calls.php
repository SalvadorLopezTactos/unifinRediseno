<?php
// created: 2018-03-09 10:42:17
$dictionary["Call"]["fields"]["tel_telefonos_calls_1"] = array (
  'name' => 'tel_telefonos_calls_1',
  'type' => 'link',
  'relationship' => 'tel_telefonos_calls_1',
  'source' => 'non-db',
  'module' => 'Tel_Telefonos',
  'bean_name' => 'Tel_Telefonos',
  'side' => 'right',
  'vname' => 'LBL_TEL_TELEFONOS_CALLS_1_FROM_CALLS_TITLE',
  'id_name' => 'tel_telefonos_calls_1tel_telefonos_ida',
  'link-type' => 'one',
);
$dictionary["Call"]["fields"]["tel_telefonos_calls_1_name"] = array (
  'name' => 'tel_telefonos_calls_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TEL_TELEFONOS_CALLS_1_FROM_TEL_TELEFONOS_TITLE',
  'save' => true,
  'id_name' => 'tel_telefonos_calls_1tel_telefonos_ida',
  'link' => 'tel_telefonos_calls_1',
  'table' => 'tel_telefonos',
  'module' => 'Tel_Telefonos',
  'rname' => 'name',
);
$dictionary["Call"]["fields"]["tel_telefonos_calls_1tel_telefonos_ida"] = array (
  'name' => 'tel_telefonos_calls_1tel_telefonos_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_TEL_TELEFONOS_CALLS_1_FROM_CALLS_TITLE_ID',
  'id_name' => 'tel_telefonos_calls_1tel_telefonos_ida',
  'link' => 'tel_telefonos_calls_1',
  'table' => 'tel_telefonos',
  'module' => 'Tel_Telefonos',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
