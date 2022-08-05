<?php
// created: 2018-03-22 10:47:18
$dictionary["TCT2_Notificaciones"]["fields"]["tct2_notificaciones_users"] = array (
  'name' => 'tct2_notificaciones_users',
  'type' => 'link',
  'relationship' => 'tct2_notificaciones_users',
  'source' => 'non-db',
  'module' => 'Users',
  'bean_name' => 'User',
  'side' => 'right',
  'vname' => 'LBL_TCT2_NOTIFICACIONES_USERS_FROM_TCT2_NOTIFICACIONES_TITLE',
  'id_name' => 'tct2_notificaciones_usersusers_ida',
  'link-type' => 'one',
);
$dictionary["TCT2_Notificaciones"]["fields"]["tct2_notificaciones_users_name"] = array (
  'name' => 'tct2_notificaciones_users_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TCT2_NOTIFICACIONES_USERS_FROM_USERS_TITLE',
  'save' => true,
  'id_name' => 'tct2_notificaciones_usersusers_ida',
  'link' => 'tct2_notificaciones_users',
  'table' => 'users',
  'module' => 'Users',
  'rname' => 'full_name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["TCT2_Notificaciones"]["fields"]["tct2_notificaciones_usersusers_ida"] = array (
  'name' => 'tct2_notificaciones_usersusers_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_TCT2_NOTIFICACIONES_USERS_FROM_TCT2_NOTIFICACIONES_TITLE_ID',
  'id_name' => 'tct2_notificaciones_usersusers_ida',
  'link' => 'tct2_notificaciones_users',
  'table' => 'users',
  'module' => 'Users',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
