<?php
// created: 2021-06-28 15:55:34
$dictionary["Lic_Licitaciones"]["fields"]["leads_lic_licitaciones_1"] = array (
  'name' => 'leads_lic_licitaciones_1',
  'type' => 'link',
  'relationship' => 'leads_lic_licitaciones_1',
  'source' => 'non-db',
  'module' => 'Leads',
  'bean_name' => 'Lead',
  'side' => 'right',
  'vname' => 'LBL_LEADS_LIC_LICITACIONES_1_FROM_LIC_LICITACIONES_TITLE',
  'id_name' => 'leads_lic_licitaciones_1leads_ida',
  'link-type' => 'one',
);
$dictionary["Lic_Licitaciones"]["fields"]["leads_lic_licitaciones_1_name"] = array (
  'name' => 'leads_lic_licitaciones_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_LEADS_LIC_LICITACIONES_1_FROM_LEADS_TITLE',
  'save' => true,
  'id_name' => 'leads_lic_licitaciones_1leads_ida',
  'link' => 'leads_lic_licitaciones_1',
  'table' => 'leads',
  'module' => 'Leads',
  'rname' => 'full_name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["Lic_Licitaciones"]["fields"]["leads_lic_licitaciones_1leads_ida"] = array (
  'name' => 'leads_lic_licitaciones_1leads_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_LEADS_LIC_LICITACIONES_1_FROM_LIC_LICITACIONES_TITLE_ID',
  'id_name' => 'leads_lic_licitaciones_1leads_ida',
  'link' => 'leads_lic_licitaciones_1',
  'table' => 'leads',
  'module' => 'Leads',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
