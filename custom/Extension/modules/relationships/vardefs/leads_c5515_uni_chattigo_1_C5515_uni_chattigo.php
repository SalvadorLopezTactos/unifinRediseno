<?php
// created: 2020-06-19 08:34:54
$dictionary["C5515_uni_chattigo"]["fields"]["leads_c5515_uni_chattigo_1"] = array (
  'name' => 'leads_c5515_uni_chattigo_1',
  'type' => 'link',
  'relationship' => 'leads_c5515_uni_chattigo_1',
  'source' => 'non-db',
  'module' => 'Leads',
  'bean_name' => 'Lead',
  'side' => 'right',
  'vname' => 'LBL_LEADS_C5515_UNI_CHATTIGO_1_FROM_C5515_UNI_CHATTIGO_TITLE',
  'id_name' => 'leads_c5515_uni_chattigo_1leads_ida',
  'link-type' => 'one',
);
$dictionary["C5515_uni_chattigo"]["fields"]["leads_c5515_uni_chattigo_1_name"] = array (
  'name' => 'leads_c5515_uni_chattigo_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_LEADS_C5515_UNI_CHATTIGO_1_FROM_LEADS_TITLE',
  'save' => true,
  'id_name' => 'leads_c5515_uni_chattigo_1leads_ida',
  'link' => 'leads_c5515_uni_chattigo_1',
  'table' => 'leads',
  'module' => 'Leads',
  'rname' => 'full_name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["C5515_uni_chattigo"]["fields"]["leads_c5515_uni_chattigo_1leads_ida"] = array (
  'name' => 'leads_c5515_uni_chattigo_1leads_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_LEADS_C5515_UNI_CHATTIGO_1_FROM_C5515_UNI_CHATTIGO_TITLE_ID',
  'id_name' => 'leads_c5515_uni_chattigo_1leads_ida',
  'link' => 'leads_c5515_uni_chattigo_1',
  'table' => 'leads',
  'module' => 'Leads',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
