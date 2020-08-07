<?php
// created: 2020-07-23 13:01:15
$dictionary["Ref_Venta_Cruzada"]["fields"]["accounts_ref_venta_cruzada_1"] = array (
  'name' => 'accounts_ref_venta_cruzada_1',
  'type' => 'link',
  'relationship' => 'accounts_ref_venta_cruzada_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_REF_VENTA_CRUZADA_1_FROM_REF_VENTA_CRUZADA_TITLE',
  'id_name' => 'accounts_ref_venta_cruzada_1accounts_ida',
  'link-type' => 'one',
);
$dictionary["Ref_Venta_Cruzada"]["fields"]["accounts_ref_venta_cruzada_1_name"] = array (
  'name' => 'accounts_ref_venta_cruzada_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_REF_VENTA_CRUZADA_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_ref_venta_cruzada_1accounts_ida',
  'link' => 'accounts_ref_venta_cruzada_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["Ref_Venta_Cruzada"]["fields"]["accounts_ref_venta_cruzada_1accounts_ida"] = array (
  'name' => 'accounts_ref_venta_cruzada_1accounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_REF_VENTA_CRUZADA_1_FROM_REF_VENTA_CRUZADA_TITLE_ID',
  'id_name' => 'accounts_ref_venta_cruzada_1accounts_ida',
  'link' => 'accounts_ref_venta_cruzada_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
