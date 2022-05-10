<?php
// created: 2021-09-21 12:10:36
$dictionary["Task"]["fields"]["tasks_opportunities_1"] = array (
  'name' => 'tasks_opportunities_1',
  'type' => 'link',
  'relationship' => 'tasks_opportunities_1',
  'source' => 'non-db',
  'module' => 'Opportunities',
  'bean_name' => 'Opportunity',
  'vname' => 'LBL_TASKS_OPPORTUNITIES_1_FROM_OPPORTUNITIES_TITLE',
  'id_name' => 'tasks_opportunities_1opportunities_idb',
);
$dictionary["Task"]["fields"]["tasks_opportunities_1_name"] = array (
  'name' => 'tasks_opportunities_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TASKS_OPPORTUNITIES_1_FROM_OPPORTUNITIES_TITLE',
  'save' => true,
  'id_name' => 'tasks_opportunities_1opportunities_idb',
  'link' => 'tasks_opportunities_1',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'name',
);
$dictionary["Task"]["fields"]["tasks_opportunities_1opportunities_idb"] = array (
  'name' => 'tasks_opportunities_1opportunities_idb',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_TASKS_OPPORTUNITIES_1_FROM_OPPORTUNITIES_TITLE_ID',
  'id_name' => 'tasks_opportunities_1opportunities_idb',
  'link' => 'tasks_opportunities_1',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
