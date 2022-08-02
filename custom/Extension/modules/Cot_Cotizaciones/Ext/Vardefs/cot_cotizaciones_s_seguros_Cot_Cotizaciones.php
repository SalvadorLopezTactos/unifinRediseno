<?php
// created: 2022-06-15 20:25:16
$dictionary["Cot_Cotizaciones"]["fields"]["cot_cotizaciones_s_seguros"] = array (
  'name' => 'cot_cotizaciones_s_seguros',
  'type' => 'link',
  'relationship' => 'cot_cotizaciones_s_seguros',
  'source' => 'non-db',
  'module' => 'S_seguros',
  'bean_name' => 'S_seguros',
  'side' => 'right',
  'vname' => 'LBL_COT_COTIZACIONES_S_SEGUROS_FROM_COT_COTIZACIONES_TITLE',
  'id_name' => 'cot_cotizaciones_s_seguross_seguros_ida',
  'link-type' => 'one',
);
$dictionary["Cot_Cotizaciones"]["fields"]["cot_cotizaciones_s_seguros_name"] = array (
  'name' => 'cot_cotizaciones_s_seguros_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_COT_COTIZACIONES_S_SEGUROS_FROM_S_SEGUROS_TITLE',
  'save' => true,
  'id_name' => 'cot_cotizaciones_s_seguross_seguros_ida',
  'link' => 'cot_cotizaciones_s_seguros',
  'table' => 's_seguros',
  'module' => 'S_seguros',
  'rname' => 'name',
);
$dictionary["Cot_Cotizaciones"]["fields"]["cot_cotizaciones_s_seguross_seguros_ida"] = array (
  'name' => 'cot_cotizaciones_s_seguross_seguros_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_COT_COTIZACIONES_S_SEGUROS_FROM_COT_COTIZACIONES_TITLE_ID',
  'id_name' => 'cot_cotizaciones_s_seguross_seguros_ida',
  'link' => 'cot_cotizaciones_s_seguros',
  'table' => 's_seguros',
  'module' => 'S_seguros',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
