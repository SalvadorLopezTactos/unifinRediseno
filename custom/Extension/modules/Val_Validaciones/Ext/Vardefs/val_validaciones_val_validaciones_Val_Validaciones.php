<?php
// created: 2015-09-24 19:19:49
$dictionary["Val_Validaciones"]["fields"]["val_validaciones_val_validaciones"] = array (
  'name' => 'val_validaciones_val_validaciones',
  'type' => 'link',
  'relationship' => 'val_validaciones_val_validaciones',
  'source' => 'non-db',
  'module' => 'Val_Validaciones',
  'bean_name' => 'Val_Validaciones',
  'vname' => 'LBL_VAL_VALIDACIONES_VAL_VALIDACIONES_FROM_VAL_VALIDACIONES_L_TITLE',
  'id_name' => 'val_validaciones_val_validacionesval_validaciones_idb',
  'link-type' => 'many',
  'side' => 'left',
);
$dictionary["Val_Validaciones"]["fields"]["val_validaciones_val_validaciones_right"] = array (
  'name' => 'val_validaciones_val_validaciones_right',
  'type' => 'link',
  'relationship' => 'val_validaciones_val_validaciones',
  'source' => 'non-db',
  'module' => 'Val_Validaciones',
  'bean_name' => 'Val_Validaciones',
  'side' => 'right',
  'vname' => 'LBL_VAL_VALIDACIONES_VAL_VALIDACIONES_FROM_VAL_VALIDACIONES_R_TITLE',
  'id_name' => 'val_validaciones_val_validacionesval_validaciones_ida',
  'link-type' => 'one',
);
$dictionary["Val_Validaciones"]["fields"]["val_validaciones_val_validaciones_name"] = array (
  'name' => 'val_validaciones_val_validaciones_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_VAL_VALIDACIONES_VAL_VALIDACIONES_FROM_VAL_VALIDACIONES_L_TITLE',
  'save' => true,
  'id_name' => 'val_validaciones_val_validacionesval_validaciones_ida',
  'link' => 'val_validaciones_val_validaciones_right',
  'table' => 'val_validaciones',
  'module' => 'Val_Validaciones',
  'rname' => 'name',
);
$dictionary["Val_Validaciones"]["fields"]["val_validaciones_val_validacionesval_validaciones_ida"] = array (
  'name' => 'val_validaciones_val_validacionesval_validaciones_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_VAL_VALIDACIONES_VAL_VALIDACIONES_FROM_VAL_VALIDACIONES_R_TITLE_ID',
  'id_name' => 'val_validaciones_val_validacionesval_validaciones_ida',
  'link' => 'val_validaciones_val_validaciones_right',
  'table' => 'val_validaciones',
  'module' => 'Val_Validaciones',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
