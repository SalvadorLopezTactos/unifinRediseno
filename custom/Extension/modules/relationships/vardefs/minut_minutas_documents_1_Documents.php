<?php
// created: 2018-10-22 12:04:29
$dictionary["Document"]["fields"]["minut_minutas_documents_1"] = array (
  'name' => 'minut_minutas_documents_1',
  'type' => 'link',
  'relationship' => 'minut_minutas_documents_1',
  'source' => 'non-db',
  'module' => 'minut_Minutas',
  'bean_name' => 'minut_Minutas',
  'side' => 'right',
  'vname' => 'LBL_MINUT_MINUTAS_DOCUMENTS_1_FROM_DOCUMENTS_TITLE',
  'id_name' => 'minut_minutas_documents_1minut_minutas_ida',
  'link-type' => 'one',
);
$dictionary["Document"]["fields"]["minut_minutas_documents_1_name"] = array (
  'name' => 'minut_minutas_documents_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_MINUT_MINUTAS_DOCUMENTS_1_FROM_MINUT_MINUTAS_TITLE',
  'save' => true,
  'id_name' => 'minut_minutas_documents_1minut_minutas_ida',
  'link' => 'minut_minutas_documents_1',
  'table' => 'minut_minutas',
  'module' => 'minut_Minutas',
  'rname' => 'name',
);
$dictionary["Document"]["fields"]["minut_minutas_documents_1minut_minutas_ida"] = array (
  'name' => 'minut_minutas_documents_1minut_minutas_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_MINUT_MINUTAS_DOCUMENTS_1_FROM_DOCUMENTS_TITLE_ID',
  'id_name' => 'minut_minutas_documents_1minut_minutas_ida',
  'link' => 'minut_minutas_documents_1',
  'table' => 'minut_minutas',
  'module' => 'minut_Minutas',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
