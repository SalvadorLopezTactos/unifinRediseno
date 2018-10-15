<?php
// created: 2018-10-12 11:29:33
$dictionary["minut_Minutas"]["fields"]["minut_minutas_meetings"] = array (
  'name' => 'minut_minutas_meetings',
  'type' => 'link',
  'relationship' => 'minut_minutas_meetings',
  'source' => 'non-db',
  'module' => 'Meetings',
  'bean_name' => 'Meeting',
  'vname' => 'LBL_MINUT_MINUTAS_MEETINGS_FROM_MEETINGS_TITLE',
  'id_name' => 'minut_minutas_meetingsmeetings_idb',
);
$dictionary["minut_Minutas"]["fields"]["minut_minutas_meetings_name"] = array (
  'name' => 'minut_minutas_meetings_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_MINUT_MINUTAS_MEETINGS_FROM_MEETINGS_TITLE',
  'save' => true,
  'id_name' => 'minut_minutas_meetingsmeetings_idb',
  'link' => 'minut_minutas_meetings',
  'table' => 'meetings',
  'module' => 'Meetings',
  'rname' => 'name',
);
$dictionary["minut_Minutas"]["fields"]["minut_minutas_meetingsmeetings_idb"] = array (
  'name' => 'minut_minutas_meetingsmeetings_idb',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_MINUT_MINUTAS_MEETINGS_FROM_MEETINGS_TITLE_ID',
  'id_name' => 'minut_minutas_meetingsmeetings_idb',
  'link' => 'minut_minutas_meetings',
  'table' => 'meetings',
  'module' => 'Meetings',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
