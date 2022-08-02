<?php
// created: 2015-10-28 13:32:17
$dictionary["Opportunity"]["fields"]["opportunities_ag_vendedores_1"] = array (
  'name' => 'opportunities_ag_vendedores_1',
  'type' => 'link',
  'relationship' => 'opportunities_ag_vendedores_1',
  'source' => 'non-db',
  'module' => 'AG_Vendedores',
  'bean_name' => 'AG_Vendedores',
  'vname' => 'LBL_OPPORTUNITIES_AG_VENDEDORES_1_FROM_AG_VENDEDORES_TITLE',
  'id_name' => 'opportunities_ag_vendedores_1ag_vendedores_idb',
);
$dictionary["Opportunity"]["fields"]["opportunities_ag_vendedores_1_name"] = array (
  'name' => 'opportunities_ag_vendedores_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_OPPORTUNITIES_AG_VENDEDORES_1_FROM_AG_VENDEDORES_TITLE',
  'save' => true,
  'id_name' => 'opportunities_ag_vendedores_1ag_vendedores_idb',
  'link' => 'opportunities_ag_vendedores_1',
  'table' => 'ag_vendedores',
  'module' => 'AG_Vendedores',
  'rname' => 'name',
);
$dictionary["Opportunity"]["fields"]["opportunities_ag_vendedores_1ag_vendedores_idb"] = array (
  'name' => 'opportunities_ag_vendedores_1ag_vendedores_idb',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_OPPORTUNITIES_AG_VENDEDORES_1_FROM_AG_VENDEDORES_TITLE_ID',
  'id_name' => 'opportunities_ag_vendedores_1ag_vendedores_idb',
  'link' => 'opportunities_ag_vendedores_1',
  'table' => 'ag_vendedores',
  'module' => 'AG_Vendedores',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
