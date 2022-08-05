<?php
// created: 2019-02-12 14:01:34
$dictionary["minut_Minutas"]["fields"]["minut_minutas_calls_1"] = array (
  'name' => 'minut_minutas_calls_1',
  'type' => 'link',
  'relationship' => 'minut_minutas_calls_1',
  'source' => 'non-db',
  'module' => 'Calls',
  'bean_name' => 'Call',
  'vname' => 'LBL_MINUT_MINUTAS_CALLS_1_FROM_CALLS_TITLE',
  'id_name' => 'minut_minutas_calls_1calls_idb',
);
$dictionary["minut_Minutas"]["fields"]["minut_minutas_calls_1_name"] = array (
  'name' => 'minut_minutas_calls_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_MINUT_MINUTAS_CALLS_1_FROM_CALLS_TITLE',
  'save' => true,
  'id_name' => 'minut_minutas_calls_1calls_idb',
  'link' => 'minut_minutas_calls_1',
  'table' => 'calls',
  'module' => 'Calls',
  'rname' => 'name',
);
$dictionary["minut_Minutas"]["fields"]["minut_minutas_calls_1calls_idb"] = array (
  'name' => 'minut_minutas_calls_1calls_idb',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_MINUT_MINUTAS_CALLS_1_FROM_CALLS_TITLE_ID',
  'id_name' => 'minut_minutas_calls_1calls_idb',
  'link' => 'minut_minutas_calls_1',
  'table' => 'calls',
  'module' => 'Calls',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
