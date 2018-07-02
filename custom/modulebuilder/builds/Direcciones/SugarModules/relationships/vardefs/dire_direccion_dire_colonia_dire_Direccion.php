<?php
// created: 2015-06-23 20:29:53
$dictionary["dire_Direccion"]["fields"]["dire_direccion_dire_colonia"] = array (
  'name' => 'dire_direccion_dire_colonia',
  'type' => 'link',
  'relationship' => 'dire_direccion_dire_colonia',
  'source' => 'non-db',
  'module' => 'dire_Colonia',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_DIRE_DIRECCION_DIRE_COLONIA_FROM_DIRE_DIRECCION_TITLE',
  'id_name' => 'dire_direccion_dire_coloniadire_colonia_ida',
  'link-type' => 'one',
);
$dictionary["dire_Direccion"]["fields"]["dire_direccion_dire_colonia_name"] = array (
  'name' => 'dire_direccion_dire_colonia_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_DIRE_DIRECCION_DIRE_COLONIA_FROM_DIRE_COLONIA_TITLE',
  'save' => true,
  'id_name' => 'dire_direccion_dire_coloniadire_colonia_ida',
  'link' => 'dire_direccion_dire_colonia',
  'table' => 'dire_colonia',
  'module' => 'dire_Colonia',
  'rname' => 'name',
);
$dictionary["dire_Direccion"]["fields"]["dire_direccion_dire_coloniadire_colonia_ida"] = array (
  'name' => 'dire_direccion_dire_coloniadire_colonia_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_DIRE_DIRECCION_DIRE_COLONIA_FROM_DIRE_DIRECCION_TITLE_ID',
  'id_name' => 'dire_direccion_dire_coloniadire_colonia_ida',
  'link' => 'dire_direccion_dire_colonia',
  'table' => 'dire_colonia',
  'module' => 'dire_Colonia',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
