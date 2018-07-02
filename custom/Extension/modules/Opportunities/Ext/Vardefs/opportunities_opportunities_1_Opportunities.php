<?php
// created: 2015-07-01 22:51:53
$dictionary["Opportunity"]["fields"]["opportunities_opportunities_1"] = array (
  'name' => 'opportunities_opportunities_1',
  'type' => 'link',
  'relationship' => 'opportunities_opportunities_1',
  'source' => 'non-db',
  'module' => 'Opportunities',
  'bean_name' => 'Opportunity',
  'vname' => 'LBL_OPPORTUNITIES_OPPORTUNITIES_1_FROM_OPPORTUNITIES_L_TITLE',
  'id_name' => 'opportunities_opportunities_1opportunities_idb',
  'link-type' => 'many',
  'side' => 'left',
);
$dictionary["Opportunity"]["fields"]["opportunities_opportunities_1_right"] = array (
  'name' => 'opportunities_opportunities_1_right',
  'type' => 'link',
  'relationship' => 'opportunities_opportunities_1',
  'source' => 'non-db',
  'module' => 'Opportunities',
  'bean_name' => 'Opportunity',
  'side' => 'right',
  'vname' => 'LBL_OPPORTUNITIES_OPPORTUNITIES_1_FROM_OPPORTUNITIES_R_TITLE',
  'id_name' => 'opportunities_opportunities_1opportunities_ida',
  'link-type' => 'one',
);
$dictionary["Opportunity"]["fields"]["opportunities_opportunities_1_name"] = array (
  'name' => 'opportunities_opportunities_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_OPPORTUNITIES_OPPORTUNITIES_1_FROM_OPPORTUNITIES_L_TITLE',
  'save' => true,
  'id_name' => 'opportunities_opportunities_1opportunities_ida',
  'link' => 'opportunities_opportunities_1_right',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'name',
);
$dictionary["Opportunity"]["fields"]["opportunities_opportunities_1opportunities_ida"] = array (
  'name' => 'opportunities_opportunities_1opportunities_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_OPPORTUNITIES_OPPORTUNITIES_1_FROM_OPPORTUNITIES_R_TITLE_ID',
  'id_name' => 'opportunities_opportunities_1opportunities_ida',
  'link' => 'opportunities_opportunities_1_right',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
