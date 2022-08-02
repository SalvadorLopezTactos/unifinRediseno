<?php
// created: 2015-06-18 15:29:12
$dictionary["dire_CodigoPostal"]["fields"]["dire_codigopostal_dire_ciudad"] = array (
  'name' => 'dire_codigopostal_dire_ciudad',
  'type' => 'link',
  'relationship' => 'dire_codigopostal_dire_ciudad',
  'source' => 'non-db',
  'module' => 'dire_Ciudad',
  'bean_name' => 'dire_Ciudad',
  'side' => 'right',
  'vname' => 'LBL_DIRE_CODIGOPOSTAL_DIRE_CIUDAD_FROM_DIRE_CODIGOPOSTAL_TITLE',
  'id_name' => 'dire_codigopostal_dire_ciudaddire_ciudad_ida',
  'link-type' => 'one',
);
$dictionary["dire_CodigoPostal"]["fields"]["dire_codigopostal_dire_ciudad_name"] = array (
  'name' => 'dire_codigopostal_dire_ciudad_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_DIRE_CODIGOPOSTAL_DIRE_CIUDAD_FROM_DIRE_CIUDAD_TITLE',
  'save' => true,
  'id_name' => 'dire_codigopostal_dire_ciudaddire_ciudad_ida',
  'link' => 'dire_codigopostal_dire_ciudad',
  'table' => 'dire_ciudad',
  'module' => 'dire_Ciudad',
  'rname' => 'name',
);
$dictionary["dire_CodigoPostal"]["fields"]["dire_codigopostal_dire_ciudaddire_ciudad_ida"] = array (
  'name' => 'dire_codigopostal_dire_ciudaddire_ciudad_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_DIRE_CODIGOPOSTAL_DIRE_CIUDAD_FROM_DIRE_CODIGOPOSTAL_TITLE_ID',
  'id_name' => 'dire_codigopostal_dire_ciudaddire_ciudad_ida',
  'link' => 'dire_codigopostal_dire_ciudad',
  'table' => 'dire_ciudad',
  'module' => 'dire_Ciudad',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
