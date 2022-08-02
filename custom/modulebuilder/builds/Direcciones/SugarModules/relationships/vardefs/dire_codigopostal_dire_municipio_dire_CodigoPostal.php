<?php
// created: 2015-06-23 20:29:51
$dictionary["dire_CodigoPostal"]["fields"]["dire_codigopostal_dire_municipio"] = array (
  'name' => 'dire_codigopostal_dire_municipio',
  'type' => 'link',
  'relationship' => 'dire_codigopostal_dire_municipio',
  'source' => 'non-db',
  'module' => 'dire_Municipio',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_DIRE_CODIGOPOSTAL_DIRE_MUNICIPIO_FROM_DIRE_CODIGOPOSTAL_TITLE',
  'id_name' => 'dire_codigopostal_dire_municipiodire_municipio_ida',
  'link-type' => 'one',
);
$dictionary["dire_CodigoPostal"]["fields"]["dire_codigopostal_dire_municipio_name"] = array (
  'name' => 'dire_codigopostal_dire_municipio_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_DIRE_CODIGOPOSTAL_DIRE_MUNICIPIO_FROM_DIRE_MUNICIPIO_TITLE',
  'save' => true,
  'id_name' => 'dire_codigopostal_dire_municipiodire_municipio_ida',
  'link' => 'dire_codigopostal_dire_municipio',
  'table' => 'dire_municipio',
  'module' => 'dire_Municipio',
  'rname' => 'name',
);
$dictionary["dire_CodigoPostal"]["fields"]["dire_codigopostal_dire_municipiodire_municipio_ida"] = array (
  'name' => 'dire_codigopostal_dire_municipiodire_municipio_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_DIRE_CODIGOPOSTAL_DIRE_MUNICIPIO_FROM_DIRE_CODIGOPOSTAL_TITLE_ID',
  'id_name' => 'dire_codigopostal_dire_municipiodire_municipio_ida',
  'link' => 'dire_codigopostal_dire_municipio',
  'table' => 'dire_municipio',
  'module' => 'dire_Municipio',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
