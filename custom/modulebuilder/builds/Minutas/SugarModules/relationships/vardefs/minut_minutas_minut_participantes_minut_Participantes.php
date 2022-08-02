<?php
// created: 2018-10-12 11:29:34
$dictionary["minut_Participantes"]["fields"]["minut_minutas_minut_participantes"] = array (
  'name' => 'minut_minutas_minut_participantes',
  'type' => 'link',
  'relationship' => 'minut_minutas_minut_participantes',
  'source' => 'non-db',
  'module' => 'minut_Minutas',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_MINUT_MINUTAS_MINUT_PARTICIPANTES_FROM_MINUT_PARTICIPANTES_TITLE',
  'id_name' => 'minut_minutas_minut_participantesminut_minutas_ida',
  'link-type' => 'one',
);
$dictionary["minut_Participantes"]["fields"]["minut_minutas_minut_participantes_name"] = array (
  'name' => 'minut_minutas_minut_participantes_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_MINUT_MINUTAS_MINUT_PARTICIPANTES_FROM_MINUT_MINUTAS_TITLE',
  'save' => true,
  'id_name' => 'minut_minutas_minut_participantesminut_minutas_ida',
  'link' => 'minut_minutas_minut_participantes',
  'table' => 'minut_minutas',
  'module' => 'minut_Minutas',
  'rname' => 'name',
);
$dictionary["minut_Participantes"]["fields"]["minut_minutas_minut_participantesminut_minutas_ida"] = array (
  'name' => 'minut_minutas_minut_participantesminut_minutas_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_MINUT_MINUTAS_MINUT_PARTICIPANTES_FROM_MINUT_PARTICIPANTES_TITLE_ID',
  'id_name' => 'minut_minutas_minut_participantesminut_minutas_ida',
  'link' => 'minut_minutas_minut_participantes',
  'table' => 'minut_minutas',
  'module' => 'minut_Minutas',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
