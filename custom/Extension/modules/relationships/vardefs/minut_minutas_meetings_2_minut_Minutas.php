<?php
// created: 2019-02-12 13:23:11
$dictionary["minut_Minutas"]["fields"]["minut_minutas_meetings_2"] = array (
  'name' => 'minut_minutas_meetings_2',
  'type' => 'link',
  'relationship' => 'minut_minutas_meetings_2',
  'source' => 'non-db',
  'module' => 'Meetings',
  'bean_name' => 'Meeting',
  'vname' => 'LBL_MINUT_MINUTAS_MEETINGS_2_FROM_MEETINGS_TITLE',
  'id_name' => 'minut_minutas_meetings_2meetings_idb',
);
$dictionary["minut_Minutas"]["fields"]["minut_minutas_meetings_2_name"] = array (
  'name' => 'minut_minutas_meetings_2_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_MINUT_MINUTAS_MEETINGS_2_FROM_MEETINGS_TITLE',
  'save' => true,
  'id_name' => 'minut_minutas_meetings_2meetings_idb',
  'link' => 'minut_minutas_meetings_2',
  'table' => 'meetings',
  'module' => 'Meetings',
  'rname' => 'name',
);
$dictionary["minut_Minutas"]["fields"]["minut_minutas_meetings_2meetings_idb"] = array (
  'name' => 'minut_minutas_meetings_2meetings_idb',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_MINUT_MINUTAS_MEETINGS_2_FROM_MEETINGS_TITLE_ID',
  'id_name' => 'minut_minutas_meetings_2meetings_idb',
  'link' => 'minut_minutas_meetings_2',
  'table' => 'meetings',
  'module' => 'Meetings',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
