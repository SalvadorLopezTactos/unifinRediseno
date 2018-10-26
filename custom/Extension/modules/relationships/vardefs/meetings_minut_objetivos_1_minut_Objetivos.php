<?php
// created: 2018-10-25 10:01:15
$dictionary["minut_Objetivos"]["fields"]["meetings_minut_objetivos_1"] = array (
  'name' => 'meetings_minut_objetivos_1',
  'type' => 'link',
  'relationship' => 'meetings_minut_objetivos_1',
  'source' => 'non-db',
  'module' => 'Meetings',
  'bean_name' => 'Meeting',
  'side' => 'right',
  'vname' => 'LBL_MEETINGS_MINUT_OBJETIVOS_1_FROM_MINUT_OBJETIVOS_TITLE',
  'id_name' => 'meetings_minut_objetivos_1meetings_ida',
  'link-type' => 'one',
);
$dictionary["minut_Objetivos"]["fields"]["meetings_minut_objetivos_1_name"] = array (
  'name' => 'meetings_minut_objetivos_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_MEETINGS_MINUT_OBJETIVOS_1_FROM_MEETINGS_TITLE',
  'save' => true,
  'id_name' => 'meetings_minut_objetivos_1meetings_ida',
  'link' => 'meetings_minut_objetivos_1',
  'table' => 'meetings',
  'module' => 'Meetings',
  'rname' => 'name',
);
$dictionary["minut_Objetivos"]["fields"]["meetings_minut_objetivos_1meetings_ida"] = array (
  'name' => 'meetings_minut_objetivos_1meetings_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_MEETINGS_MINUT_OBJETIVOS_1_FROM_MINUT_OBJETIVOS_TITLE_ID',
  'id_name' => 'meetings_minut_objetivos_1meetings_ida',
  'link' => 'meetings_minut_objetivos_1',
  'table' => 'meetings',
  'module' => 'Meetings',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
