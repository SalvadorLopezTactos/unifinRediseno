<?php
// created: 2019-12-19 17:08:59
$dictionary["Lead"]["fields"]["leads_leads_1"] = array (
  'name' => 'leads_leads_1',
  'type' => 'link',
  'relationship' => 'leads_leads_1',
  'source' => 'non-db',
  'module' => 'Leads',
  'bean_name' => 'Lead',
  'vname' => 'LBL_LEADS_LEADS_1_FROM_LEADS_L_TITLE',
  'id_name' => 'leads_leads_1leads_idb',
  'link-type' => 'many',
  'side' => 'left',
);
$dictionary["Lead"]["fields"]["leads_leads_1_right"] = array (
  'name' => 'leads_leads_1_right',
  'type' => 'link',
  'relationship' => 'leads_leads_1',
  'source' => 'non-db',
  'module' => 'Leads',
  'bean_name' => 'Lead',
  'side' => 'right',
  'vname' => 'LBL_LEADS_LEADS_1_FROM_LEADS_R_TITLE',
  'id_name' => 'leads_leads_1leads_ida',
  'link-type' => 'one',
);
$dictionary["Lead"]["fields"]["leads_leads_1_name"] = array (
  'name' => 'leads_leads_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_LEADS_LEADS_1_FROM_LEADS_L_TITLE',
  'save' => true,
  'id_name' => 'leads_leads_1leads_ida',
  'link' => 'leads_leads_1_right',
  'table' => 'leads',
  'module' => 'Leads',
  'rname' => 'full_name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["Lead"]["fields"]["leads_leads_1leads_ida"] = array (
  'name' => 'leads_leads_1leads_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_LEADS_LEADS_1_FROM_LEADS_R_TITLE_ID',
  'id_name' => 'leads_leads_1leads_ida',
  'link' => 'leads_leads_1_right',
  'table' => 'leads',
  'module' => 'Leads',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
