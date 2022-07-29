<?php
// created: 2015-06-23 20:29:49
$dictionary["dire_Municipio"]["fields"]["dire_municipio_dire_estado"] = array (
  'name' => 'dire_municipio_dire_estado',
  'type' => 'link',
  'relationship' => 'dire_municipio_dire_estado',
  'source' => 'non-db',
  'module' => 'dire_Estado',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_DIRE_MUNICIPIO_DIRE_ESTADO_FROM_DIRE_MUNICIPIO_TITLE',
  'id_name' => 'dire_municipio_dire_estadodire_estado_ida',
  'link-type' => 'one',
);
$dictionary["dire_Municipio"]["fields"]["dire_municipio_dire_estado_name"] = array (
  'name' => 'dire_municipio_dire_estado_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_DIRE_MUNICIPIO_DIRE_ESTADO_FROM_DIRE_ESTADO_TITLE',
  'save' => true,
  'id_name' => 'dire_municipio_dire_estadodire_estado_ida',
  'link' => 'dire_municipio_dire_estado',
  'table' => 'dire_estado',
  'module' => 'dire_Estado',
  'rname' => 'name',
);
$dictionary["dire_Municipio"]["fields"]["dire_municipio_dire_estadodire_estado_ida"] = array (
  'name' => 'dire_municipio_dire_estadodire_estado_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_DIRE_MUNICIPIO_DIRE_ESTADO_FROM_DIRE_MUNICIPIO_TITLE_ID',
  'id_name' => 'dire_municipio_dire_estadodire_estado_ida',
  'link' => 'dire_municipio_dire_estado',
  'table' => 'dire_estado',
  'module' => 'dire_Estado',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
