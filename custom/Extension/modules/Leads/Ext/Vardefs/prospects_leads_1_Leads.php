<?php
// created: 2023-08-28 16:26:17
$dictionary["Lead"]["fields"]["prospects_leads_1"] = array (
  'name' => 'prospects_leads_1',
  'type' => 'link',
  'relationship' => 'prospects_leads_1',
  'source' => 'non-db',
  'module' => 'Prospects',
  'bean_name' => 'Prospect',
  'side' => 'right',
  'vname' => 'LBL_PROSPECTS_LEADS_1_FROM_LEADS_TITLE',
  'id_name' => 'prospects_leads_1prospects_ida',
  'link-type' => 'one',
);
$dictionary["Lead"]["fields"]["prospects_leads_1_name"] = array (
  'name' => 'prospects_leads_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PROSPECTS_LEADS_1_FROM_PROSPECTS_TITLE',
  'save' => true,
  'id_name' => 'prospects_leads_1prospects_ida',
  'link' => 'prospects_leads_1',
  'table' => 'prospects',
  'module' => 'Prospects',
  'rname' => 'name',
);
$dictionary["Lead"]["fields"]["prospects_leads_1prospects_ida"] = array (
  'name' => 'prospects_leads_1prospects_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_PROSPECTS_LEADS_1_FROM_LEADS_TITLE_ID',
  'id_name' => 'prospects_leads_1prospects_ida',
  'link' => 'prospects_leads_1',
  'table' => 'prospects',
  'module' => 'Prospects',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
