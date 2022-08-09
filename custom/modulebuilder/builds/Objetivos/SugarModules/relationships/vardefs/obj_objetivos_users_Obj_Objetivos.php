<?php
// created: 2022-06-03 21:25:29
$dictionary["Obj_Objetivos"]["fields"]["obj_objetivos_users"] = array (
  'name' => 'obj_objetivos_users',
  'type' => 'link',
  'relationship' => 'obj_objetivos_users',
  'source' => 'non-db',
  'module' => 'Users',
  'bean_name' => 'User',
  'vname' => 'LBL_OBJ_OBJETIVOS_USERS_FROM_USERS_TITLE',
  'id_name' => 'obj_objetivos_usersusers_idb',
);
$dictionary["Obj_Objetivos"]["fields"]["obj_objetivos_users_name"] = array (
  'name' => 'obj_objetivos_users_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_OBJ_OBJETIVOS_USERS_FROM_USERS_TITLE',
  'save' => true,
  'id_name' => 'obj_objetivos_usersusers_idb',
  'link' => 'obj_objetivos_users',
  'table' => 'users',
  'module' => 'Users',
  'rname' => 'full_name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["Obj_Objetivos"]["fields"]["obj_objetivos_usersusers_idb"] = array (
  'name' => 'obj_objetivos_usersusers_idb',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_OBJ_OBJETIVOS_USERS_FROM_USERS_TITLE_ID',
  'id_name' => 'obj_objetivos_usersusers_idb',
  'link' => 'obj_objetivos_users',
  'table' => 'users',
  'module' => 'Users',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
