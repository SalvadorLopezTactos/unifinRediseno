<?php
// created: 2016-04-12 16:30:52
$dictionary["lev_Backlog"]["fields"]["lev_backlog_opportunities"] = array (
  'name' => 'lev_backlog_opportunities',
  'type' => 'link',
  'relationship' => 'lev_backlog_opportunities',
  'source' => 'non-db',
  'module' => 'Opportunities',
  'bean_name' => 'Opportunity',
  'side' => 'right',
  'vname' => 'LBL_LEV_BACKLOG_OPPORTUNITIES_FROM_LEV_BACKLOG_TITLE',
  'id_name' => 'lev_backlog_opportunitiesopportunities_ida',
  'link-type' => 'one',
);
$dictionary["lev_Backlog"]["fields"]["lev_backlog_opportunities_name"] = array (
  'name' => 'lev_backlog_opportunities_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_LEV_BACKLOG_OPPORTUNITIES_FROM_OPPORTUNITIES_TITLE',
  'save' => true,
  'id_name' => 'lev_backlog_opportunitiesopportunities_ida',
  'link' => 'lev_backlog_opportunities',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'name',
);
$dictionary["lev_Backlog"]["fields"]["lev_backlog_opportunitiesopportunities_ida"] = array (
  'name' => 'lev_backlog_opportunitiesopportunities_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_LEV_BACKLOG_OPPORTUNITIES_FROM_LEV_BACKLOG_TITLE_ID',
  'id_name' => 'lev_backlog_opportunitiesopportunities_ida',
  'link' => 'lev_backlog_opportunities',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
