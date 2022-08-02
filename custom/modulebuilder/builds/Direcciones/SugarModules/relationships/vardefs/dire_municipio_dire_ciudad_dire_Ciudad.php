<?php
// created: 2015-06-08 16:18:04
$dictionary["dire_Ciudad"]["fields"]["dire_municipio_dire_ciudad"] = array (
  'name' => 'dire_municipio_dire_ciudad',
  'type' => 'link',
  'relationship' => 'dire_municipio_dire_ciudad',
  'source' => 'non-db',
  'module' => 'dire_Municipio',
  'bean_name' => 'dire_Municipio',
  'side' => 'right',
  'vname' => 'LBL_DIRE_MUNICIPIO_DIRE_CIUDAD_FROM_DIRE_CIUDAD_TITLE',
  'id_name' => 'dire_municipio_dire_ciudaddire_municipio_ida',
  'link-type' => 'one',
);
$dictionary["dire_Ciudad"]["fields"]["dire_municipio_dire_ciudad_name"] = array (
  'name' => 'dire_municipio_dire_ciudad_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_DIRE_MUNICIPIO_DIRE_CIUDAD_FROM_DIRE_MUNICIPIO_TITLE',
  'save' => true,
  'id_name' => 'dire_municipio_dire_ciudaddire_municipio_ida',
  'link' => 'dire_municipio_dire_ciudad',
  'table' => 'dire_municipio',
  'module' => 'dire_Municipio',
  'rname' => 'name',
);
$dictionary["dire_Ciudad"]["fields"]["dire_municipio_dire_ciudaddire_municipio_ida"] = array (
  'name' => 'dire_municipio_dire_ciudaddire_municipio_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_DIRE_MUNICIPIO_DIRE_CIUDAD_FROM_DIRE_CIUDAD_TITLE_ID',
  'id_name' => 'dire_municipio_dire_ciudaddire_municipio_ida',
  'link' => 'dire_municipio_dire_ciudad',
  'table' => 'dire_municipio',
  'module' => 'dire_Municipio',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
