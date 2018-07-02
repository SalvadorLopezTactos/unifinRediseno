<?php
// created: 2016-04-03 12:50:00
$dictionary["lev_CondicionesFinancieras"]["fields"]["lev_condicionesfinancieras_opportunities"] = array (
  'name' => 'lev_condicionesfinancieras_opportunities',
  'type' => 'link',
  'relationship' => 'lev_condicionesfinancieras_opportunities',
  'source' => 'non-db',
  'module' => 'Opportunities',
  'bean_name' => 'Opportunity',
  'side' => 'right',
  'vname' => 'LBL_LEV_CONDICIONESFINANCIERAS_OPPORTUNITIES_FROM_LEV_CONDICIONESFINANCIERAS_TITLE',
  'id_name' => 'lev_condicionesfinancieras_opportunitiesopportunities_ida',
  'link-type' => 'one',
);
$dictionary["lev_CondicionesFinancieras"]["fields"]["lev_condicionesfinancieras_opportunities_name"] = array (
  'name' => 'lev_condicionesfinancieras_opportunities_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_LEV_CONDICIONESFINANCIERAS_OPPORTUNITIES_FROM_OPPORTUNITIES_TITLE',
  'save' => true,
  'id_name' => 'lev_condicionesfinancieras_opportunitiesopportunities_ida',
  'link' => 'lev_condicionesfinancieras_opportunities',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'name',
);
$dictionary["lev_CondicionesFinancieras"]["fields"]["lev_condicionesfinancieras_opportunitiesopportunities_ida"] = array (
  'name' => 'lev_condicionesfinancieras_opportunitiesopportunities_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_LEV_CONDICIONESFINANCIERAS_OPPORTUNITIES_FROM_LEV_CONDICIONESFINANCIERAS_TITLE_ID',
  'id_name' => 'lev_condicionesfinancieras_opportunitiesopportunities_ida',
  'link' => 'lev_condicionesfinancieras_opportunities',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
