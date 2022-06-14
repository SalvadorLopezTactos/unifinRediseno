<?php
// created: 2022-05-31 13:02:50
$dictionary["minut_Participantes"]["fields"]["meetings_minut_participantes_1"] = array (
  'name' => 'meetings_minut_participantes_1',
  'type' => 'link',
  'relationship' => 'meetings_minut_participantes_1',
  'source' => 'non-db',
  'module' => 'Meetings',
  'bean_name' => 'Meeting',
  'side' => 'right',
  'vname' => 'LBL_MEETINGS_MINUT_PARTICIPANTES_1_FROM_MINUT_PARTICIPANTES_TITLE',
  'id_name' => 'meetings_minut_participantes_1meetings_ida',
  'link-type' => 'one',
);
$dictionary["minut_Participantes"]["fields"]["meetings_minut_participantes_1_name"] = array (
  'name' => 'meetings_minut_participantes_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_MEETINGS_MINUT_PARTICIPANTES_1_FROM_MEETINGS_TITLE',
  'save' => true,
  'id_name' => 'meetings_minut_participantes_1meetings_ida',
  'link' => 'meetings_minut_participantes_1',
  'table' => 'meetings',
  'module' => 'Meetings',
  'rname' => 'name',
);
$dictionary["minut_Participantes"]["fields"]["meetings_minut_participantes_1meetings_ida"] = array (
  'name' => 'meetings_minut_participantes_1meetings_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_MEETINGS_MINUT_PARTICIPANTES_1_FROM_MINUT_PARTICIPANTES_TITLE_ID',
  'id_name' => 'meetings_minut_participantes_1meetings_ida',
  'link' => 'meetings_minut_participantes_1',
  'table' => 'meetings',
  'module' => 'Meetings',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
