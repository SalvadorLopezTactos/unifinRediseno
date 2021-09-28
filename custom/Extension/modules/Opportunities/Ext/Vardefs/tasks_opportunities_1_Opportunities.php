<?php
// created: 2021-09-21 12:10:36
$dictionary["Opportunity"]["fields"]["tasks_opportunities_1"] = array (
  'name' => 'tasks_opportunities_1',
  'type' => 'link',
  'relationship' => 'tasks_opportunities_1',
  'source' => 'non-db',
  'module' => 'Tasks',
  'bean_name' => 'Task',
  'vname' => 'LBL_TASKS_OPPORTUNITIES_1_FROM_TASKS_TITLE',
  'id_name' => 'tasks_opportunities_1tasks_ida',
);
$dictionary["Opportunity"]["fields"]["tasks_opportunities_1_name"] = array (
  'name' => 'tasks_opportunities_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TASKS_OPPORTUNITIES_1_FROM_TASKS_TITLE',
  'save' => true,
  'id_name' => 'tasks_opportunities_1tasks_ida',
  'link' => 'tasks_opportunities_1',
  'table' => 'tasks',
  'module' => 'Tasks',
  'rname' => 'name',
);
$dictionary["Opportunity"]["fields"]["tasks_opportunities_1tasks_ida"] = array (
  'name' => 'tasks_opportunities_1tasks_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_TASKS_OPPORTUNITIES_1_FROM_TASKS_TITLE_ID',
  'id_name' => 'tasks_opportunities_1tasks_ida',
  'link' => 'tasks_opportunities_1',
  'table' => 'tasks',
  'module' => 'Tasks',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
