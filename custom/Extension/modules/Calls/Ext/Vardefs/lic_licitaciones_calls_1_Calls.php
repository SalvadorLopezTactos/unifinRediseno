<?php
// created: 2021-02-08 14:32:09
$dictionary["Call"]["fields"]["lic_licitaciones_calls_1"] = array (
  'name' => 'lic_licitaciones_calls_1',
  'type' => 'link',
  'relationship' => 'lic_licitaciones_calls_1',
  'source' => 'non-db',
  'module' => 'Lic_Licitaciones',
  'bean_name' => 'Lic_Licitaciones',
  'side' => 'right',
  'vname' => 'LBL_LIC_LICITACIONES_CALLS_1_FROM_CALLS_TITLE',
  'id_name' => 'lic_licitaciones_calls_1lic_licitaciones_ida',
  'link-type' => 'one',
);
$dictionary["Call"]["fields"]["lic_licitaciones_calls_1_name"] = array (
  'name' => 'lic_licitaciones_calls_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_LIC_LICITACIONES_CALLS_1_FROM_LIC_LICITACIONES_TITLE',
  'save' => true,
  'id_name' => 'lic_licitaciones_calls_1lic_licitaciones_ida',
  'link' => 'lic_licitaciones_calls_1',
  'table' => 'lic_licitaciones',
  'module' => 'Lic_Licitaciones',
  'rname' => 'name',
);
$dictionary["Call"]["fields"]["lic_licitaciones_calls_1lic_licitaciones_ida"] = array (
  'name' => 'lic_licitaciones_calls_1lic_licitaciones_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_LIC_LICITACIONES_CALLS_1_FROM_CALLS_TITLE_ID',
  'id_name' => 'lic_licitaciones_calls_1lic_licitaciones_ida',
  'link' => 'lic_licitaciones_calls_1',
  'table' => 'lic_licitaciones',
  'module' => 'Lic_Licitaciones',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
