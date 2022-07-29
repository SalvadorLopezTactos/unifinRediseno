<?php
// created: 2020-08-28 19:03:26
$dictionary["Document"]["fields"]["opportunities_documents_1"] = array (
  'name' => 'opportunities_documents_1',
  'type' => 'link',
  'relationship' => 'opportunities_documents_1',
  'source' => 'non-db',
  'module' => 'Opportunities',
  'bean_name' => 'Opportunity',
  'side' => 'right',
  'vname' => 'LBL_OPPORTUNITIES_DOCUMENTS_1_FROM_DOCUMENTS_TITLE',
  'id_name' => 'opportunities_documents_1opportunities_ida',
  'link-type' => 'one',
);
$dictionary["Document"]["fields"]["opportunities_documents_1_name"] = array (
  'name' => 'opportunities_documents_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_OPPORTUNITIES_DOCUMENTS_1_FROM_OPPORTUNITIES_TITLE',
  'save' => true,
  'id_name' => 'opportunities_documents_1opportunities_ida',
  'link' => 'opportunities_documents_1',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'name',
);
$dictionary["Document"]["fields"]["opportunities_documents_1opportunities_ida"] = array (
  'name' => 'opportunities_documents_1opportunities_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_OPPORTUNITIES_DOCUMENTS_1_FROM_DOCUMENTS_TITLE_ID',
  'id_name' => 'opportunities_documents_1opportunities_ida',
  'link' => 'opportunities_documents_1',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
