<?php
// created: 2015-10-28 13:22:51
$dictionary["AG_Vendedores"]["fields"]["ag_vendedores_ag_agencias"] = array (
  'name' => 'ag_vendedores_ag_agencias',
  'type' => 'link',
  'relationship' => 'ag_vendedores_ag_agencias',
  'source' => 'non-db',
  'module' => 'AG_Agencias',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_AG_VENDEDORES_AG_AGENCIAS_FROM_AG_VENDEDORES_TITLE',
  'id_name' => 'ag_vendedores_ag_agenciasag_agencias_ida',
  'link-type' => 'one',
);
$dictionary["AG_Vendedores"]["fields"]["ag_vendedores_ag_agencias_name"] = array (
  'name' => 'ag_vendedores_ag_agencias_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_AG_VENDEDORES_AG_AGENCIAS_FROM_AG_AGENCIAS_TITLE',
  'save' => true,
  'id_name' => 'ag_vendedores_ag_agenciasag_agencias_ida',
  'link' => 'ag_vendedores_ag_agencias',
  'table' => 'ag_agencias',
  'module' => 'AG_Agencias',
  'rname' => 'name',
);
$dictionary["AG_Vendedores"]["fields"]["ag_vendedores_ag_agenciasag_agencias_ida"] = array (
  'name' => 'ag_vendedores_ag_agenciasag_agencias_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_AG_VENDEDORES_AG_AGENCIAS_FROM_AG_VENDEDORES_TITLE_ID',
  'id_name' => 'ag_vendedores_ag_agenciasag_agencias_ida',
  'link' => 'ag_vendedores_ag_agencias',
  'table' => 'ag_agencias',
  'module' => 'AG_Agencias',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
