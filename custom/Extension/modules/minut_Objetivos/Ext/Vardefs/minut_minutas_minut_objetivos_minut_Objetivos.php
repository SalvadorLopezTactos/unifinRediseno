<?php
// created: 2018-10-12 11:29:35
$dictionary["minut_Objetivos"]["fields"]["minut_minutas_minut_objetivos"] = array (
  'name' => 'minut_minutas_minut_objetivos',
  'type' => 'link',
  'relationship' => 'minut_minutas_minut_objetivos',
  'source' => 'non-db',
  'module' => 'minut_Minutas',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_MINUT_MINUTAS_MINUT_OBJETIVOS_FROM_MINUT_OBJETIVOS_TITLE',
  'id_name' => 'minut_minutas_minut_objetivosminut_minutas_ida',
  'link-type' => 'one',
);
$dictionary["minut_Objetivos"]["fields"]["minut_minutas_minut_objetivos_name"] = array (
  'name' => 'minut_minutas_minut_objetivos_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_MINUT_MINUTAS_MINUT_OBJETIVOS_FROM_MINUT_MINUTAS_TITLE',
  'save' => true,
  'id_name' => 'minut_minutas_minut_objetivosminut_minutas_ida',
  'link' => 'minut_minutas_minut_objetivos',
  'table' => 'minut_minutas',
  'module' => 'minut_Minutas',
  'rname' => 'name',
);
$dictionary["minut_Objetivos"]["fields"]["minut_minutas_minut_objetivosminut_minutas_ida"] = array (
  'name' => 'minut_minutas_minut_objetivosminut_minutas_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_MINUT_MINUTAS_MINUT_OBJETIVOS_FROM_MINUT_OBJETIVOS_TITLE_ID',
  'id_name' => 'minut_minutas_minut_objetivosminut_minutas_ida',
  'link' => 'minut_minutas_minut_objetivos',
  'table' => 'minut_minutas',
  'module' => 'minut_Minutas',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
