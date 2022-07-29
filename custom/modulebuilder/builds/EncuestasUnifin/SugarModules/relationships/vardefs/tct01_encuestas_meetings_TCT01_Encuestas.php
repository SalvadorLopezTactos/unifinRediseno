<?php
// created: 2018-09-27 12:54:00
$dictionary["TCT01_Encuestas"]["fields"]["tct01_encuestas_meetings"] = array (
  'name' => 'tct01_encuestas_meetings',
  'type' => 'link',
  'relationship' => 'tct01_encuestas_meetings',
  'source' => 'non-db',
  'module' => 'Meetings',
  'bean_name' => 'Meeting',
  'side' => 'right',
  'vname' => 'LBL_TCT01_ENCUESTAS_MEETINGS_FROM_TCT01_ENCUESTAS_TITLE',
  'id_name' => 'tct01_encuestas_meetingsmeetings_ida',
  'link-type' => 'one',
);
$dictionary["TCT01_Encuestas"]["fields"]["tct01_encuestas_meetings_name"] = array (
  'name' => 'tct01_encuestas_meetings_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TCT01_ENCUESTAS_MEETINGS_FROM_MEETINGS_TITLE',
  'save' => true,
  'id_name' => 'tct01_encuestas_meetingsmeetings_ida',
  'link' => 'tct01_encuestas_meetings',
  'table' => 'meetings',
  'module' => 'Meetings',
  'rname' => 'name',
);
$dictionary["TCT01_Encuestas"]["fields"]["tct01_encuestas_meetingsmeetings_ida"] = array (
  'name' => 'tct01_encuestas_meetingsmeetings_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_TCT01_ENCUESTAS_MEETINGS_FROM_TCT01_ENCUESTAS_TITLE_ID',
  'id_name' => 'tct01_encuestas_meetingsmeetings_ida',
  'link' => 'tct01_encuestas_meetings',
  'table' => 'meetings',
  'module' => 'Meetings',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
