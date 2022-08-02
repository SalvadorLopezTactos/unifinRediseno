<?php
// created: 2022-04-27 23:16:21
$dictionary["Prospect"]["fields"]["prospects_prospects_1"] = array (
  'name' => 'prospects_prospects_1',
  'type' => 'link',
  'relationship' => 'prospects_prospects_1',
  'source' => 'non-db',
  'module' => 'Prospects',
  'bean_name' => 'Prospect',
  'vname' => 'LBL_PROSPECTS_PROSPECTS_1_FROM_PROSPECTS_L_TITLE',
  'id_name' => 'prospects_prospects_1prospects_idb',
  'link-type' => 'many',
  'side' => 'left',
);
$dictionary["Prospect"]["fields"]["prospects_prospects_1_right"] = array (
  'name' => 'prospects_prospects_1_right',
  'type' => 'link',
  'relationship' => 'prospects_prospects_1',
  'source' => 'non-db',
  'module' => 'Prospects',
  'bean_name' => 'Prospect',
  'side' => 'right',
  'vname' => 'LBL_PROSPECTS_PROSPECTS_1_FROM_PROSPECTS_R_TITLE',
  'id_name' => 'prospects_prospects_1prospects_ida',
  'link-type' => 'one',
);
$dictionary["Prospect"]["fields"]["prospects_prospects_1_name"] = array (
  'name' => 'prospects_prospects_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PROSPECTS_PROSPECTS_1_FROM_PROSPECTS_L_TITLE',
  'save' => true,
  'id_name' => 'prospects_prospects_1prospects_ida',
  'link' => 'prospects_prospects_1_right',
  'table' => 'prospects',
  'module' => 'Prospects',
  'rname' => 'name',
);
$dictionary["Prospect"]["fields"]["prospects_prospects_1prospects_ida"] = array (
  'name' => 'prospects_prospects_1prospects_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_PROSPECTS_PROSPECTS_1_FROM_PROSPECTS_R_TITLE_ID',
  'id_name' => 'prospects_prospects_1prospects_ida',
  'link' => 'prospects_prospects_1_right',
  'table' => 'prospects',
  'module' => 'Prospects',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
