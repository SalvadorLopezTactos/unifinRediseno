<?php
// created: 2016-09-27 16:05:52
$dictionary["uni_Citas"]["fields"]["uni_citas_uni_brujula"] = array (
  'name' => 'uni_citas_uni_brujula',
  'type' => 'link',
  'relationship' => 'uni_citas_uni_brujula',
  'source' => 'non-db',
  'module' => 'uni_Brujula',
  'bean_name' => 'uni_Brujula',
  'side' => 'right',
  'vname' => 'LBL_UNI_CITAS_UNI_BRUJULA_FROM_UNI_CITAS_TITLE',
  'id_name' => 'uni_citas_uni_brujulauni_brujula_ida',
  'link-type' => 'one',
);
$dictionary["uni_Citas"]["fields"]["uni_citas_uni_brujula_name"] = array (
  'name' => 'uni_citas_uni_brujula_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_UNI_CITAS_UNI_BRUJULA_FROM_UNI_BRUJULA_TITLE',
  'save' => true,
  'id_name' => 'uni_citas_uni_brujulauni_brujula_ida',
  'link' => 'uni_citas_uni_brujula',
  'table' => 'uni_brujula',
  'module' => 'uni_Brujula',
  'rname' => 'name',
);
$dictionary["uni_Citas"]["fields"]["uni_citas_uni_brujulauni_brujula_ida"] = array (
  'name' => 'uni_citas_uni_brujulauni_brujula_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_UNI_CITAS_UNI_BRUJULA_FROM_UNI_CITAS_TITLE_ID',
  'id_name' => 'uni_citas_uni_brujulauni_brujula_ida',
  'link' => 'uni_citas_uni_brujula',
  'table' => 'uni_brujula',
  'module' => 'uni_Brujula',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
