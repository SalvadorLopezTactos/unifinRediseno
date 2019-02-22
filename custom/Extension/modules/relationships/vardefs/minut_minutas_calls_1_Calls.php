<?php
// created: 2019-02-12 14:01:34
$dictionary["Call"]["fields"]["minut_minutas_calls_1"] = array (
  'name' => 'minut_minutas_calls_1',
  'type' => 'link',
  'relationship' => 'minut_minutas_calls_1',
  'source' => 'non-db',
  'module' => 'minut_Minutas',
  'bean_name' => 'minut_Minutas',
  'vname' => 'LBL_MINUT_MINUTAS_CALLS_1_FROM_MINUT_MINUTAS_TITLE',
  'id_name' => 'minut_minutas_calls_1minut_minutas_ida',
);
$dictionary["Call"]["fields"]["minut_minutas_calls_1_name"] = array (
  'name' => 'minut_minutas_calls_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_MINUT_MINUTAS_CALLS_1_FROM_MINUT_MINUTAS_TITLE',
  'save' => true,
  'id_name' => 'minut_minutas_calls_1minut_minutas_ida',
  'link' => 'minut_minutas_calls_1',
  'table' => 'minut_minutas',
  'module' => 'minut_Minutas',
  'rname' => 'name',
);
$dictionary["Call"]["fields"]["minut_minutas_calls_1minut_minutas_ida"] = array (
  'name' => 'minut_minutas_calls_1minut_minutas_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_MINUT_MINUTAS_CALLS_1_FROM_MINUT_MINUTAS_TITLE_ID',
  'id_name' => 'minut_minutas_calls_1minut_minutas_ida',
  'link' => 'minut_minutas_calls_1',
  'table' => 'minut_minutas',
  'module' => 'minut_Minutas',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
