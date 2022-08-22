<?php
// created: 2022-08-20 14:06:26
$dictionary["ANLZT_analizate"]["fields"]["leads_anlzt_analizate_1"] = array (
  'name' => 'leads_anlzt_analizate_1',
  'type' => 'link',
  'relationship' => 'leads_anlzt_analizate_1',
  'source' => 'non-db',
  'module' => 'Leads',
  'bean_name' => 'Lead',
  'side' => 'right',
  'vname' => 'LBL_LEADS_ANLZT_ANALIZATE_1_FROM_ANLZT_ANALIZATE_TITLE',
  'id_name' => 'leads_anlzt_analizate_1leads_ida',
  'link-type' => 'one',
);
$dictionary["ANLZT_analizate"]["fields"]["leads_anlzt_analizate_1_name"] = array (
  'name' => 'leads_anlzt_analizate_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_LEADS_ANLZT_ANALIZATE_1_FROM_LEADS_TITLE',
  'save' => true,
  'id_name' => 'leads_anlzt_analizate_1leads_ida',
  'link' => 'leads_anlzt_analizate_1',
  'table' => 'leads',
  'module' => 'Leads',
  'rname' => 'full_name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["ANLZT_analizate"]["fields"]["leads_anlzt_analizate_1leads_ida"] = array (
  'name' => 'leads_anlzt_analizate_1leads_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_LEADS_ANLZT_ANALIZATE_1_FROM_ANLZT_ANALIZATE_TITLE_ID',
  'id_name' => 'leads_anlzt_analizate_1leads_ida',
  'link' => 'leads_anlzt_analizate_1',
  'table' => 'leads',
  'module' => 'Leads',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
