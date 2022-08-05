<?php
// created: 2018-03-22 10:47:18
$dictionary["tct2_notificaciones_users"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'tct2_notificaciones_users' => 
    array (
      'lhs_module' => 'Users',
      'lhs_table' => 'users',
      'lhs_key' => 'id',
      'rhs_module' => 'TCT2_Notificaciones',
      'rhs_table' => 'tct2_notificaciones',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'tct2_notificaciones_users_c',
      'join_key_lhs' => 'tct2_notificaciones_usersusers_ida',
      'join_key_rhs' => 'tct2_notificaciones_userstct2_notificaciones_idb',
    ),
  ),
  'table' => 'tct2_notificaciones_users_c',
  'fields' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'id',
    ),
    'date_modified' => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    'deleted' => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'default' => 0,
    ),
    'tct2_notificaciones_usersusers_ida' => 
    array (
      'name' => 'tct2_notificaciones_usersusers_ida',
      'type' => 'id',
    ),
    'tct2_notificaciones_userstct2_notificaciones_idb' => 
    array (
      'name' => 'tct2_notificaciones_userstct2_notificaciones_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_tct2_notificaciones_users_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_tct2_notificaciones_users_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'tct2_notificaciones_usersusers_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_tct2_notificaciones_users_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'tct2_notificaciones_userstct2_notificaciones_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'tct2_notificaciones_users_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'tct2_notificaciones_userstct2_notificaciones_idb',
      ),
    ),
  ),
);