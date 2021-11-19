<?php
// created: 2015-06-23 20:29:51
$dictionary["dire_Direccion"]["fields"]["dire_direccion_dire_pais"] = array (
  'name' => 'dire_direccion_dire_pais',
  'type' => 'link',
  'relationship' => 'dire_direccion_dire_pais',
  'source' => 'non-db',
  'module' => 'dire_Pais',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_DIRE_DIRECCION_DIRE_PAIS_FROM_DIRE_DIRECCION_TITLE',
  'id_name' => 'dire_direccion_dire_paisdire_pais_ida',
  'link-type' => 'one',
);
$dictionary["dire_Direccion"]["fields"]["dire_direccion_dire_pais_name"] = array (
  'name' => 'dire_direccion_dire_pais_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_DIRE_DIRECCION_DIRE_PAIS_FROM_DIRE_PAIS_TITLE',
  'save' => true,
  'id_name' => 'dire_direccion_dire_paisdire_pais_ida',
  'link' => 'dire_direccion_dire_pais',
  'table' => 'dire_pais',
  'module' => 'dire_Pais',
  'rname' => 'name',
);
$dictionary["dire_Direccion"]["fields"]["dire_direccion_dire_paisdire_pais_ida"] = array (
  'name' => 'dire_direccion_dire_paisdire_pais_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_DIRE_DIRECCION_DIRE_PAIS_FROM_DIRE_DIRECCION_TITLE_ID',
  'id_name' => 'dire_direccion_dire_paisdire_pais_ida',
  'link' => 'dire_direccion_dire_pais',
  'table' => 'dire_pais',
  'module' => 'dire_Pais',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
