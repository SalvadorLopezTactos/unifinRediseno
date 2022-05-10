<?php
// created: 2020-07-22 13:07:09
$dictionary["Document"]["fields"]["s_seguros_documents_1"] = array (
  'name' => 's_seguros_documents_1',
  'type' => 'link',
  'relationship' => 's_seguros_documents_1',
  'source' => 'non-db',
  'module' => 'S_seguros',
  'bean_name' => 'S_seguros',
  'side' => 'right',
  'vname' => 'LBL_S_SEGUROS_DOCUMENTS_1_FROM_DOCUMENTS_TITLE',
  'id_name' => 's_seguros_documents_1s_seguros_ida',
  'link-type' => 'one',
);
$dictionary["Document"]["fields"]["s_seguros_documents_1_name"] = array (
  'name' => 's_seguros_documents_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_S_SEGUROS_DOCUMENTS_1_FROM_S_SEGUROS_TITLE',
  'save' => true,
  'id_name' => 's_seguros_documents_1s_seguros_ida',
  'link' => 's_seguros_documents_1',
  'table' => 's_seguros',
  'module' => 'S_seguros',
  'rname' => 'name',
);
$dictionary["Document"]["fields"]["s_seguros_documents_1s_seguros_ida"] = array (
  'name' => 's_seguros_documents_1s_seguros_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_S_SEGUROS_DOCUMENTS_1_FROM_DOCUMENTS_TITLE_ID',
  'id_name' => 's_seguros_documents_1s_seguros_ida',
  'link' => 's_seguros_documents_1',
  'table' => 's_seguros',
  'module' => 'S_seguros',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
