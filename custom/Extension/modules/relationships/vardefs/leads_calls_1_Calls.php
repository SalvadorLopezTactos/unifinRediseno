<?php
// created: 2021-07-27 16:53:07
$dictionary["Call"]["fields"]["leads_calls_1"] = array (
  'name' => 'leads_calls_1',
  'type' => 'link',
  'relationship' => 'leads_calls_1',
  'source' => 'non-db',
  'module' => 'Leads',
  'bean_name' => 'Lead',
  'side' => 'right',
  'vname' => 'LBL_LEADS_CALLS_1_FROM_CALLS_TITLE',
  'id_name' => 'leads_calls_1leads_ida',
  'link-type' => 'one',
);
$dictionary["Call"]["fields"]["leads_calls_1_name"] = array (
  'name' => 'leads_calls_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_LEADS_CALLS_1_FROM_LEADS_TITLE',
  'save' => true,
  'id_name' => 'leads_calls_1leads_ida',
  'link' => 'leads_calls_1',
  'table' => 'leads',
  'module' => 'Leads',
  'rname' => 'full_name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["Call"]["fields"]["leads_calls_1leads_ida"] = array (
  'name' => 'leads_calls_1leads_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_LEADS_CALLS_1_FROM_CALLS_TITLE_ID',
  'id_name' => 'leads_calls_1leads_ida',
  'link' => 'leads_calls_1',
  'table' => 'leads',
  'module' => 'Leads',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
