<?php
// created: 2015-10-28 13:32:17
$dictionary["AG_Vendedores"]["fields"]["opportunities_ag_vendedores_1"] = array (
  'name' => 'opportunities_ag_vendedores_1',
  'type' => 'link',
  'relationship' => 'opportunities_ag_vendedores_1',
  'source' => 'non-db',
  'module' => 'Opportunities',
  'bean_name' => 'Opportunity',
  'vname' => 'LBL_OPPORTUNITIES_AG_VENDEDORES_1_FROM_OPPORTUNITIES_TITLE',
  'id_name' => 'opportunities_ag_vendedores_1opportunities_ida',
);
$dictionary["AG_Vendedores"]["fields"]["opportunities_ag_vendedores_1_name"] = array (
  'name' => 'opportunities_ag_vendedores_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_OPPORTUNITIES_AG_VENDEDORES_1_FROM_OPPORTUNITIES_TITLE',
  'save' => true,
  'id_name' => 'opportunities_ag_vendedores_1opportunities_ida',
  'link' => 'opportunities_ag_vendedores_1',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'name',
);
$dictionary["AG_Vendedores"]["fields"]["opportunities_ag_vendedores_1opportunities_ida"] = array (
  'name' => 'opportunities_ag_vendedores_1opportunities_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_OPPORTUNITIES_AG_VENDEDORES_1_FROM_OPPORTUNITIES_TITLE_ID',
  'id_name' => 'opportunities_ag_vendedores_1opportunities_ida',
  'link' => 'opportunities_ag_vendedores_1',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
