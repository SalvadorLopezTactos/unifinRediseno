<?php
// created: 2015-06-18 15:29:09
$dictionary["dire_Ciudad"]["fields"]["dire_ciudad_dire_municipio"] = array (
  'name' => 'dire_ciudad_dire_municipio',
  'type' => 'link',
  'relationship' => 'dire_ciudad_dire_municipio',
  'source' => 'non-db',
  'module' => 'dire_Municipio',
  'bean_name' => 'dire_Municipio',
  'side' => 'right',
  'vname' => 'LBL_DIRE_CIUDAD_DIRE_MUNICIPIO_FROM_DIRE_CIUDAD_TITLE',
  'id_name' => 'dire_ciudad_dire_municipiodire_municipio_ida',
  'link-type' => 'one',
);
$dictionary["dire_Ciudad"]["fields"]["dire_ciudad_dire_municipio_name"] = array (
  'name' => 'dire_ciudad_dire_municipio_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_DIRE_CIUDAD_DIRE_MUNICIPIO_FROM_DIRE_MUNICIPIO_TITLE',
  'save' => true,
  'id_name' => 'dire_ciudad_dire_municipiodire_municipio_ida',
  'link' => 'dire_ciudad_dire_municipio',
  'table' => 'dire_municipio',
  'module' => 'dire_Municipio',
  'rname' => 'name',
);
$dictionary["dire_Ciudad"]["fields"]["dire_ciudad_dire_municipiodire_municipio_ida"] = array (
  'name' => 'dire_ciudad_dire_municipiodire_municipio_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_DIRE_CIUDAD_DIRE_MUNICIPIO_FROM_DIRE_CIUDAD_TITLE_ID',
  'id_name' => 'dire_ciudad_dire_municipiodire_municipio_ida',
  'link' => 'dire_ciudad_dire_municipio',
  'table' => 'dire_municipio',
  'module' => 'dire_Municipio',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
