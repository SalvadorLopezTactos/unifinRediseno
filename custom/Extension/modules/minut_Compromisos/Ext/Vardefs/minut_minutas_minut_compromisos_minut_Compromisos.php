<?php
// created: 2018-10-12 11:29:36
$dictionary["minut_Compromisos"]["fields"]["minut_minutas_minut_compromisos"] = array (
  'name' => 'minut_minutas_minut_compromisos',
  'type' => 'link',
  'relationship' => 'minut_minutas_minut_compromisos',
  'source' => 'non-db',
  'module' => 'minut_Minutas',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_MINUT_MINUTAS_MINUT_COMPROMISOS_FROM_MINUT_COMPROMISOS_TITLE',
  'id_name' => 'minut_minutas_minut_compromisosminut_minutas_ida',
  'link-type' => 'one',
);
$dictionary["minut_Compromisos"]["fields"]["minut_minutas_minut_compromisos_name"] = array (
  'name' => 'minut_minutas_minut_compromisos_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_MINUT_MINUTAS_MINUT_COMPROMISOS_FROM_MINUT_MINUTAS_TITLE',
  'save' => true,
  'id_name' => 'minut_minutas_minut_compromisosminut_minutas_ida',
  'link' => 'minut_minutas_minut_compromisos',
  'table' => 'minut_minutas',
  'module' => 'minut_Minutas',
  'rname' => 'name',
);
$dictionary["minut_Compromisos"]["fields"]["minut_minutas_minut_compromisosminut_minutas_ida"] = array (
  'name' => 'minut_minutas_minut_compromisosminut_minutas_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_MINUT_MINUTAS_MINUT_COMPROMISOS_FROM_MINUT_COMPROMISOS_TITLE_ID',
  'id_name' => 'minut_minutas_minut_compromisosminut_minutas_ida',
  'link' => 'minut_minutas_minut_compromisos',
  'table' => 'minut_minutas',
  'module' => 'minut_Minutas',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
