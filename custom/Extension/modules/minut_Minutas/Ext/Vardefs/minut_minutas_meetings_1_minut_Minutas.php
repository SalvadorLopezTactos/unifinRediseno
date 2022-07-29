<?php
// created: 2018-10-24 23:16:26
$dictionary["minut_Minutas"]["fields"]["minut_minutas_meetings_1"] = array (
  'name' => 'minut_minutas_meetings_1',
  'type' => 'link',
  'relationship' => 'minut_minutas_meetings_1',
  'source' => 'non-db',
  'module' => 'Meetings',
  'bean_name' => 'Meeting',
  'vname' => 'LBL_MINUT_MINUTAS_MEETINGS_1_FROM_MEETINGS_TITLE',
  'id_name' => 'minut_minutas_meetings_1meetings_idb',
);
$dictionary["minut_Minutas"]["fields"]["minut_minutas_meetings_1_name"] = array (
  'name' => 'minut_minutas_meetings_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_MINUT_MINUTAS_MEETINGS_1_FROM_MEETINGS_TITLE',
  'save' => true,
  'id_name' => 'minut_minutas_meetings_1meetings_idb',
  'link' => 'minut_minutas_meetings_1',
  'table' => 'meetings',
  'module' => 'Meetings',
  'rname' => 'name',
);
$dictionary["minut_Minutas"]["fields"]["minut_minutas_meetings_1meetings_idb"] = array (
  'name' => 'minut_minutas_meetings_1meetings_idb',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_MINUT_MINUTAS_MEETINGS_1_FROM_MEETINGS_TITLE_ID',
  'id_name' => 'minut_minutas_meetings_1meetings_idb',
  'link' => 'minut_minutas_meetings_1',
  'table' => 'meetings',
  'module' => 'Meetings',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
