<?php
// created: 2022-06-03 21:25:29
$dictionary["User"]["fields"]["obj_objetivos_users"] = array (
  'name' => 'obj_objetivos_users',
  'type' => 'link',
  'relationship' => 'obj_objetivos_users',
  'source' => 'non-db',
  'module' => 'Obj_Objetivos',
  'bean_name' => false,
  'vname' => 'LBL_OBJ_OBJETIVOS_USERS_FROM_OBJ_OBJETIVOS_TITLE',
  'id_name' => 'obj_objetivos_usersobj_objetivos_ida',
);
$dictionary["User"]["fields"]["obj_objetivos_users_name"] = array (
  'name' => 'obj_objetivos_users_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_OBJ_OBJETIVOS_USERS_FROM_OBJ_OBJETIVOS_TITLE',
  'save' => true,
  'id_name' => 'obj_objetivos_usersobj_objetivos_ida',
  'link' => 'obj_objetivos_users',
  'table' => 'obj_objetivos',
  'module' => 'Obj_Objetivos',
  'rname' => 'name',
);
$dictionary["User"]["fields"]["obj_objetivos_usersobj_objetivos_ida"] = array (
  'name' => 'obj_objetivos_usersobj_objetivos_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_OBJ_OBJETIVOS_USERS_FROM_OBJ_OBJETIVOS_TITLE_ID',
  'id_name' => 'obj_objetivos_usersobj_objetivos_ida',
  'link' => 'obj_objetivos_users',
  'table' => 'obj_objetivos',
  'module' => 'Obj_Objetivos',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
